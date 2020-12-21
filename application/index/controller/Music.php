<?php


namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use Util\data\Sysdb;

class Music extends Controller{

    public function music(){

            $source=input('post.source');
            $title=input('post.title');
            if($title){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/18.17763');


                if ($source == 'qq') {
                    $url = "https://api.qq.jsososo.com/search?&key=" . urlencode($title);
                } elseif ($source == 'migu') {
                    $url = "api.migu.jsososo.com/search?keyword=" . urlencode($title);
                } else {
                    exit(json_encode(array('code' => 0, 'msg' => '参数错误')));
                }

                curl_setopt($ch, CURLOPT_URL, $url);
                $response = curl_exec($ch);
                curl_close($ch);


                preg_match('/\n{.+/', $response, $preg_result);
                $result = json_decode($preg_result[0], true)['data']['list'];

            if($source=='migu') $this->assign(['data'=>$result,'source'=>'migu']);
            if($source=='qq') $this->assign(['data'=>$result,'source'=>'qq']);

                return $this->fetch();
            }
        return $this->fetch();
    }

    public function Mv($vid=0){

        $url='https://api.qq.jsososo.com/mv/url?id='.$vid;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/18.17763');
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        curl_close($ch);

        preg_match('/\n{.+/', $response, $preg_result);
        $result = end(json_decode($preg_result[0], true)['data'][$vid]);
        $this->assign(['data'=>$result]);
        return $this->fetch();
    }

    public function media($id=0){
        $url='https://api.qq.jsososo.com/song/url?id='.$id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/18.17763');
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        curl_close($ch);

        preg_match('/\n{.+/', $response, $preg_result);
        $status=json_decode($preg_result[0], true)['result'];
        if($status==100) $result = json_decode($preg_result[0], true)['data'];
        else return '暂时没有资源或访问方式不正确';
        return "<script>location.href='".$result."'</script>";
    }

}