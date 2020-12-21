<?php

namespace app\index\controller;
use think\Controller;
use think\Db;
use Util\data\Sysdb;

class Ichaoxing extends Controller{

	   //  public function ichaoxing(){
    //     $GLOBALS['title'] = trim(htmlspecialchars(input('post.title')));
    //     if($GLOBALS['title']){
    //         $result=$this->post_ichaoxing(["keyword"=>$GLOBALS['title']]);
    //         if($result['code']==200) $this->assign(['data'=>$result['data']]);
    //         else $this->assign(['status'=>$result]);
    //     }
    //     return $this->fetch();
    // }

    // public function post_ichaoxing($post_data){
    //     $postdata = http_build_query($post_data);
    //     $options = array(
    //         'http' => array(
    //             'method' => 'POST',
    //             'header' => 'Content-type:application/x-www-form-urlencoded'."\n".'token:9Or67ulzROuYmwS8jCZUrmlYm9F8qgAJXXvAtQVaWVUapZ3kghtnKqLJAw99',
    //             'content' => $postdata,
    //             'timeout' => 15 * 60
    //         )
    //     );
    //     $context = stream_context_create($options);
    //     $result = file_get_contents('https://app.51xuexiaoyi.com/api/v1/searchQuestion', false, $context);

    //     $result= json_decode($result,true);
    //     return $result;
    // }
}

?>