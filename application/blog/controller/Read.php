<?php

namespace app\blog\controller;
use think\Controller;
use think\Db;
use think\Request;
use Util\data\Sysdb;

class Read extends Controller{

	public function index($id = 0){

		$GLOBALS['pid']=$id;
		session('pid',$id);
        $handler=new Sysdb;
        $content=$handler->table('blog')->where(['pid'=>$GLOBALS['pid']])->item();
        if(!$content) abort(404,'页面不存在');
        $reply=empty($content['reply_lists'])? '' : array_filter(explode("#",$content['reply_lists']));
        $this->assign(['content'=>$content['content'],'reply'=>$reply]);
        return $this->fetch();
	}

	public function reply(Sysdb $handler){
		$content=htmlspecialchars(input('post.content'));
        if(strlen($content)>400){
            exit(json_encode(array('code'=>1,'msg'=>'言简意赅更好哦')));
        }
		$content="#".$content;
		$verifycode=htmlspecialchars(input('post.verifycode'));

		if($verifycode == ''){
           exit(json_encode(array('code'=>1,'msg'=>'请输入验证码')));
        }
        if($content == ''){
           exit(json_encode(array('code'=>1,'msg'=>'内容不能为空哦')));
        }
        if(!captcha_check($verifycode)){
           exit(json_encode(array('code'=>1,'msg'=>'验证码错误')));
        }
        $pre_reply_lists=$handler->table('blog')->where(['pid'=>session('pid')])->field('reply_lists')->item();
        $data['reply_lists']=$pre_reply_lists['reply_lists'].$content;
        $handler->table('blog')->where(['pid'=>session('pid')])->update($data);
        exit(json_encode(array('code'=>0,'msg'=>'评论成功')));
	}

}

?>