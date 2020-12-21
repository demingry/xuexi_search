<?php

namespace app\blog\controller;
use think\Controller;
use think\Db;
use Util\data\Sysdb;

class Index extends Controller{

	public function index(Sysdb $handler){
		$data=$handler->table('blog')->order('add_time desc')->pages(3);
		$this->assign(['data'=>$data]);
	    return $this->fetch();
	}
}

?>