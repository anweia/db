<?php
namespace app\index\controller;
use extend\url\Curl;
use think\Request;
use think\Controller;
use QL\QueryList;
use app\index\model\vide;
use think\Db;

class Index extends Controller 
{
   //电影加载首页获取
   public function index()
   {
       $url='https://api.douban.com/v2/movie/top250';
       $curl = new Curl();
       $result = $curl->get($url);
       echo $result;
   }
   //详情页获取
  public function movie()
  {
   $request = Request::instance();
   $url='https://api.douban.com/v2/movie/subject/'.input('get.id');
   $curl = new Curl();
    $result = $curl->get($url);
    echo $result;
  
  }
  //搜索页
  public function search()
  {
   $request = Request::instance();
   $url='https://api.douban.com/v2/movie/search'.'?q='.input('get.id');
   $curl = new Curl();
    $result = $curl->get($url);
    echo $result;
  }
  public function ba()
  {
   $url = 'https://movie.douban.com/cinema/nowplaying/beijing/';
   // 元数据采集规则
   $rules =[
      'id' => ['','id'],
      'img' => ['a>img','src'],
      'alt' => ['a>img','alt'],
      'datascore' => ['','data-score'],
      'dataactors' => ['','data-actors'],
   ];
   // 切片选择器
   $range = '.lists>li:lt(19)';
   $rt = QueryList::get($url)->rules($rules)->range($range)->query()->getData();
      $date=$rt->all();
      $date['subjects']=$date;
      $date['title']='正在热映电影前20';
      echo json_encode($date);
      //插入数据库
      // foreach ($date as $key => $value) {
      //   // 添加单条数据
      //    $result=db('vide')->insert($value);
         
      // }
      // if($result)
      //    {
      //       echo '添加成功';
      //    }
  }

   public function popular()
   {
      $result['subjects']=db('vide')->select();
      $result['title']='电影热映前20';
      echo json_encode($result);
   }

   public function music()
   {
      dump(['a'=>1]);
   }

  }
