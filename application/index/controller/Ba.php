<?php
namespace app\index\controller;
use think\Controller;
use Beanbun\Beanbun;
use Beanbun\Lib\Helper;
class ba extends Controller
{
    public function beanbun()
    {
        
        $beanbun = new Beanbun;
        $beanbun->name = 'qiubai';
        $beanbun->count = 5;
        $beanbun->seed = 'http://www.wodmx.cn/';
        $beanbun->max = 30;
        $beanbun->logFile = __DIR__ . '/qiubai_access.log';
        $beanbun->urlFilter = [
            '/http:\/\/www.qiushibaike.com\/8hr\/page\/(\d*)\?s=(\d*)/'
        ];
        // 设置队列
        $beanbun->setQueue('memory', [
            'host' => '127.0.0.1',
            'port' => '2207'
        ]);
        $beanbun->afterDownloadPage = function($beanbun) {
            file_put_contents(__DIR__ . '/' . md5($beanbun->url), $beanbun->page);
        };
        $beanbun->start();
    } 
}