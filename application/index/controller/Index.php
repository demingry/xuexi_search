<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use Util\data\Sysdb;

class Index extends Controller{

    public function index(){
        $GLOBALS['title']=trim(htmlspecialchars(input('post.title')));
        if($GLOBALS['title'] && strlen($GLOBALS['title'])>3){
            $data_like['title|choicea|choiceb|choicec|choiced']=array('like','%'.$GLOBALS['title'].'%');
            $response=Db::name('data')->where($data_like)->select();
            $this->assign(['data'=>$response]);
        }


        if(isset($response)&&empty($response)){
            $missfile = fopen(MYAPP_PATH."\\"."missfile.txt", "a+") or die("Unable to open file!");
            $txt = $GLOBALS['title']."#";
            fwrite($missfile, $txt);
            fclose($missfile);
        }

        return $this->fetch();
    }


    public function upload_file(){
        $file=request()->file('file');
        if($file==null) exit(json_encode(['status'=>0,'message'=>'未选中上传文件']));

        $path=ROOT_PATH.DS.'public'.DS.'Marks'.DS.'uploads';
        $info=$file->move($path);
        // $ext=$info->getExtension();
        // if(!in_array($ext,array('jpg','jpeg','png','gif')))exit(json_encode(['status'=>0,'message'=>'不支持的格式']));
        $realpath='http://47.95.122.208\Marks\uploads'.DS.$info->getSaveName();
        exit(json_encode(['status'=>1,'message'=>'上传成功: '.$realpath]));
    }

    public function vip_video(){
        return $this->fetch();
    }

    public function get_ip(){
        $request=request();
        return "访问的IP地址：".$request->ip();
    }

    public function admin_panel_login(){
        return $this->fetch();
    }

    public function admin_panel_dologin(Sysdb $handler){
        $username = trim(input('post.username'));
        $pwd = trim(input('post.pwd'));
        $verifycode = trim(input('post.verifycode'));

        if($username == ''){
            exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
        }
        if($pwd == ''){
            exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
        }
        if($verifycode == ''){
            exit(json_encode(array('code'=>1,'msg'=>'请输入验证码')));
        }
        // 验证验证码
        if(!captcha_check($verifycode)){
            exit(json_encode(array('code'=>1,'msg'=>'验证码错误')));
        }
        // 验证用户
        $admin = $handler->table('admin')->where(array('name'=>$username))->item();
        if(!$admin){
            exit(json_encode(array('code'=>1,'msg'=>'用户不存在')));
        }
        if(md5($admin['name'].$pwd) != $admin['password']){
            exit(json_encode(array('code'=>1,'msg'=>'密码错误')));
        }
        if($admin['status'] == 0){
            exit(json_encode(array('code'=>1,'msg'=>'用户已被禁用')));
        }
        // 设置用户session
        session('admin',$admin);
        exit(json_encode(array('code'=>0,'msg'=>'登录成功','current'=>session('current_url'))));
    }

}
