<?php
namespace Home\Model;
use Think\Model;

class CommentModel {
	public function getComment($pid){
		$comment = M("comment");
		$res =  $comment->where(array('pid'=>$pid))->order("ctime desc")->select();
		return $res;
	}
	public function delectComment($id){
		$comment = M("comment");
		$res =  $comment->where(array('id'=>$id))->delect();
		return $res;
	}
	/*
	 * 回复楼主用微博pid，回复评论id用评论id加pid，session中的用户名,vtype
	 * 有评论id加pid时认为是评论回复的
	 */
	public function addComment($data,$vtype){
		$add_data = array();
		$add_data['pid'] = $data['pid'];
		$add_data['content'] = $data['content'];
		$add_data['ctime'] = $data['ctime'];
		$publish_model = D('Publish');
		$vuser_model = D('Vuser');
		$comment = M("comment");
		$res_msg = $publish_model->getMsgbyId($data['pid']);
		if($data['id'] !== null){
			//回复评论
			$res = $comment->where(array('id'=>$data['id']))->find();
			$add_data['touser'] = $res_msg['user'];
			$add_data['tovuser'] = $res_msg['vuser'];
			
		}else{
			//回复楼主 
			$add_data['touser'] = $res_msg['user'];
			$add_data['tovuser'] = $res_msg['vuser'];
		}
		//楼主回复
		if($res_msg['user'] == $data['user']){
			$add_data['vuser'] = $res_msg['vuser'];
		}else{
			$res = $comment->where(array('pid'=>$data['pid'],'user'=>$data['user']))->find();
			if(!empty($res)){
				$add_data['vuser'] = $res['vuser'];
			}else{
				$add_data['vuser'] =  $vuser_model->getVuser($vtype,$data['pid']);
			}
		}
		$res =  $comment->add($add_data);
		if( is_numeric($res)){
			//更新评论数目
			$publishDb = M('publish');
			$res = $publishDb->where(array('id'=>$add_data['pid']))->setInc('comment_num'); 
			return $add_data;
		}else{
			return null;
		}
		
	}
}