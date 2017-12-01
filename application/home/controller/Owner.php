<?php
namespace app\home\controller;
use think\Controller;
use think\Db;
use think\Validate;

class Owner extends Home {
    public function index(){
        $uid = is_login();
//        var_dump($uid);die;
        if (!$uid){
            $this->redirect('user/login/index');
//             $this->error('请先登录',url('user/login/index'));
        }else{
            $user = Db::name('ucenter_member')->where('id',$uid)->find();
            if ($user['status'] == 2){
                 $this->error('你已经认证过，无需再次验证');
            }
        }
        if ($this->request->isPost()){
            $data = $this->request->post();
//            var_dump($data);die;
            $validate = validate('owner');
            if (!$validate->check($data)){
                return $this->error($validate->getError());
            }else{
                $result = Db::name('ucenter_member')->where('id',$uid)->update(['status'=>2]);
                if ($result){
                    return $this->success('验证成功',url('home/index/index'));
                }else{
                    return $this->error($validate->getError());
                }
            }
        }else{
            return $this->fetch();
        }
    }
}
