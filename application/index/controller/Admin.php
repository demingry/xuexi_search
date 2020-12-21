<?php


namespace app\index\controller;
use app\index\controller\BaseAdmin as Baseadmin;
use Util\data\Sysdb;

class Admin extends Baseadmin{

    public function index(){
        $this->assign(['authen'=>$this->authen]);
        return $this->fetch();
    }

    public function save(Sysdb $handler){
        $data['title'] = trim(input('post.title'));
        $data['choicea'] = input('post.choicea');
        $data['choiceb'] = input('post.choiceb');
        $data['choicec'] = (input('post.choicec'));
        $data['choiced'] = (input('post.choiced'));
        $data['answer'] = (input('post.answer'));

        $handler->table('data')->insert($data);

        exit(json_encode(['status'=>1,'message'=>'插入成功']));
    }

}