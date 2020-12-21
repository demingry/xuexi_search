<?php

namespace app\blog\controller;
use think\Db;
use Util\data\Sysdb;
use app\index\controller\BaseAdmin;

class Editor extends BaseAdmin{

	public function index(){

		return $this->fetch();
	}

    public function save(Sysdb $handler){
        $data['content']=htmlspecialchars(input('post.content'));
        $data['title']=htmlspecialchars(input('post.title'));
        $data['imgrealurl']=htmlspecialchars(input('post.album'));
        $data['add_time']=time();
        $data['pid']=md5($data['add_time']);
        $handler->table('blog')->insert($data);

        return "<script>window.location.href('/blog/editor/index');</script>";
    }
}

?>