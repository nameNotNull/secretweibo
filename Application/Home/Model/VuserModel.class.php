<?php
namespace Home\Model;
use Think\Model;

class VuserModel {
	public function getVuser($type = 0 ,$pid){
		$vuser = array();
		$old_user = array();
		if($pid !== null){
			$Comment_model = D('Comment');
			$com_res = $Comment_model->getComment($pid);
			if(!empty($com_res)){
				foreach ($com_res as $v){
					$vuser_list[] = $v['vuser'];
				}
				$old_user = array_unique($vuser_list);
			}
		}
		$user = M("vuser");
		$res = $user->where(array('vtype'=>$type))->select();
		foreach ($res as $v){
			$vuser[] = $v['vuser'];
		}
		if(!empty($old_user)){
			$vuser = array_diff($vuser,$old_user);
		}
		$num = array_rand($vuser);
		return $vuser[$num];
	}
	public function getVtype(){
		$user = M();
		$res = $user->query("select vtype from hk_vuser group by vtype");
		return $res;
		
	}
}