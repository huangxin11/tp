<?php
namespace app\home\controller;

use think\Controller;

class Profile extends Home {
    public function index(){
        if ($this->request->isAjax()){
            $page = $this->request->get('page');
            $shop = \think\Db::name('document')->where('status',1)->where('category_id',44)->where('deadline','>=',time())->limit(2)->page($page)->select();
            $shop['page']=$page;
            return json_encode($shop);
        }else{
            $page = 1;
        }
        $shop = \think\Db::name('document')->where('status',1)->where('category_id',44)->where('deadline','>=',time())->limit(2)->page($page)->select();
        $this->assign('page',$page);
        $this->assign('shop',$shop);
//        var_dump($shop);die;
        return $this->fetch();
    }
    public function fuwu(){
        return $this->fetch();
    }
}
