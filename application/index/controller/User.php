<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
use extend\wxencr\WXBizDataCrypt;
use extend\url\Curl;
use think\Db;
use hightman\xunsearch\Database;
class User extends Controller
{
    public function login()
    {
         $date=input('get.');
        //  dump($da);
        //  die;
        $date['appid']='wxc4f7f8e5a883abe7';
        $date['secret']='792484555bc459cf78b3ba2ea1c9711f';
        $url='https://api.weixin.qq.com/sns/jscode2session?appid='.$date['appid'].'&secret='.$date['secret'].'&js_code='.$date['code'].'&grant_type=authorization_code';
        $curl = new Curl();
        //获取session_key
        $result = $curl->get($url);
        //转化为数组
        $result=json_decode($result,true);
        $pc = new WXBizDataCrypt($date['appid'], $result['session_key']);
        $errCode = $pc->decryptData($date['encryptedData'], $date['iv'], $data );
        
        if ($errCode == 0) {
           $data=json_decode($data,true);
          
           $res=db('user')->where('openId',$data['openId'])->find();
           $data['timestamp']=$data['watermark']['timestamp'];
           $data['appid']=$data['watermark']['appid'];
            unset($data['watermark']);
           
            echo json_encode($data);
           if(!$res)
           {
              $data['ctime']=time();
              db('user')->insert($data);
              
           }else{
               // 更新数据表中的数据
               $data['ctime']=time();
               db('user')->where('openId',$data['openId'])->update($data);
           }
        } else {
            print($errCode . "\n");
        }
    }
    public function logindo()
    {
            echo '大大大·';
    }
}