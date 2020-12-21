<?php


namespace app\cos\controller;
use app\index\controller\BaseAdmin;
use think\Db;
use think\Request;
use Util\data\Sysdb;
use Qcloud\Cos\Client;

class Index extends BaseAdmin{

    public function index(){
        if(Request::instance()->isPost()){
            $img_real_url=input('post.img_real_url');


            $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Content-type:application/x-www-form-urlencoded'."\n".'
                    Accept: text/html, application/xhtml+xml, application/xml; q=0.9, */*; q=0.8'."\n".'
                    Accept-Language: zh-Hans-CN, zh-Hans; q=0.5'."\n".'
                    User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/18.17763',
                'timeout' => 30 * 60
            )
        );
            $response=file_get_contents($img_real_url);
            $filename=md5(time()).".jpg";
            $howsitgoing=file_put_contents($filename, $response);


                $secretId = "AKIDraDg3Hp2SkrGUbpXqxSqyymnkbKs6cGv"; //"云 API 密钥 SecretId";
                $secretKey = "gDoLm4NapiS4UjpmdQ5ZszwlOuFQRL5r"; //"云 API 密钥 SecretKey";
                $region = "ap-chengdu"; //设置一个默认的存储桶地域
                $cosClient = new Client(
                    array(
                        'region' => $region,
                        'credentials'=> array(
                            'secretId'  => $secretId ,
                            'secretKey' => $secretKey)));

                try {
                    $bucket = "heyuan-search-1300456377"; //存储桶名称 格式：BucketName-APPID
                    $key = "/blog/".$filename;
                    $srcPath = "C:/wamp64/www/public/".$filename;//本地文件绝对路径
                    $file = fopen($srcPath, "rb");
                    if ($file) {
                        $result = $cosClient->putObject(array(
                            'Bucket' => $bucket,
                            'Key' => $key,
                            'Body' => $file));
                        $backtouser="https://".$result["Location"];
                        if(file_exists($srcPath)){
                            unlink($srcPath);
                        }
                    }
                }catch (\Exception $e) {
                    echo "$e\n";
                }


            return $backtouser;
        }
        else{
            return $this->fetch();
        }

    }

}