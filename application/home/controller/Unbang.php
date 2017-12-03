<?php
namespace app\home\controller;
use think\Controller;
use think\Db;

class Unbang extends Controller{
    public function index(){
        $id = is_login();
        if ($id){
            $user = Db::name('ucenter_member')->where('id',$id)->setField('openid',0);
//            var_dump($user);die;
//            $user['openid'] = 0;
//            var_dump($user);die;
//            $user->save();
            return $this->success('解除绑定成功','/user/login/index');
        }else{
            $this->redirect('/user/login/index');
        }
    }
}
