<?php
namespace Home\Model;
use Think\Model;

class LikeModel {
	public function getNum($pid){
		$like = M("like");
		$res =  $like->where(array('pid'=>$pid))->order("ctime desc")->select();
		return $res;
	}
	
	/*
	 * $data['pid'],$data['cid'],$data['user']
	 */
	public function delectLike($data){
		$like = M("like");
		
		$res =  $like->where($data)->delect();
		return $res;
	}
	
	/*
	 * $data['pid'],$data['cid'],$data['user']
	 * false 表示已经点赞
	*/
	public function addLike($data){
		$like = M('like');
		$is_have = $like->where($data)->find();
		if($is_have){
			return false;
		}
		$publish_model = D('Publish');
		$comment_model = D('comment');
		if($data['pid']!=0){
			$res_msg = $publish_model->getMsgbyId($data['pid']);
		}
		if($data['cid']!=0){
			$res_msg = $comment_model->where(array('id'=>$data['id']))->find();
		}
		//$re = 
		$data['touser'] = $res_msg['user'];
		$data['tovuser'] = $res_msg['vuser'];
		$res =  $like->add($data);
		return $res;
	}
}