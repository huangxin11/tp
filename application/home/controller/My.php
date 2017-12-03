<?php
namespace app\home\controller;
use think\Db;
use think\Session;

class My extends Home{
    public function index(){
        $uid = is_login();
        if (!$uid){
            Session::set('url',url('home/my/index'));
            $this->redirect('/user/login/index');
//             $this->error('请先登录',url('/user/login/index'),0);
        }
        $user = Db::name('ucenter_member')->where('id',$uid)->find();
        $this->assign('user',$user);
        return  $this->fetch();
    }
}
