<?php


namespace app\index\controller;


use think\Controller;
use think\Request;

class BaseAdmin extends Controller{

    protected $authen;

    public function __construct(Request $request = null){

        parent::__construct();
        $this->authen = session('admin');

        $request = Request::instance();
        session('current_url',$request -> url());

        if(!$this->authen){
            header('Location: /index/index/admin_panel_login');
            exit;
        }
    }

}