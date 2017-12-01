<?php
namespace app\home\controller;
use think\Db;

class My extends Home{
    public function index(){
        $uid = is_login();
        if (!$uid){
            return $this->error('请先登录',url('/home/login/index'));
        }
        $user = Db::name('ucenter_member')->where('id',$uid)->find();
        $this->assign('user',$user);
        return  $this->fetch();
    }
}