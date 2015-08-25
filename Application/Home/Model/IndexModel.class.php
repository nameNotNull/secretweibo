<?php 
namespace Home\Model;
use Think\Model;

class IndexModel {
	public $dbname = "hk";

	public function Index() {
		return $this->dbname;
	}
};
