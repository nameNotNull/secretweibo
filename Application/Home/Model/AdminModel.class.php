<?php
namespace Home\Model;
use Think\Model;

class AdminModel {
	public function getList(){
		$list = M("vuser");
		$res =  $list->field('id,vuser,vtype')->select();
		return $res;
	}
	public function addList($data){
		$list = M("vuser");
		$res =  $list->addAll($data);
		return $res;
	}
	
}