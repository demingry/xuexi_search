<?php

namespace app\index\controller;
use think\Controller;
use think\Db;
use Util\data\Sysdb;

class OfferWall extends Controller{

	public function index(){

		$this->assign(['uid'=>90187]);
		return $this->fetch();
	}
}

?>