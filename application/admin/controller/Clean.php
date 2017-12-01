<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Clean extends Controller{
    public function clean(){
        set_time_limit(0);
        while (true){
            $time = time();
            Db::name('document')->where('deadline','<',$time)->update(['status'=>-1]);
            Db::name('shop')->where('end_time','<',$time)->update(['status'=>-1]);
            echo "已执行"."<br>";
            sleep(60);
    }
    }
}

