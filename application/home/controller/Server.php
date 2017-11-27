<?php
namespace app\home\controller;
use think\Controller;

class Server extends Home{
    public function index(){
        return $this->fetch();
    }
    /**
     * 添加报修订单
     */
    public function add(){
//        return $this->fetch();
//        echo 2;
        if ($this->request->isPost()){
            $server = model('server');
//            var_dump($server);die;
            $data = \think\Request::instance()->post();
            $str_old = 'ABCD567EFGHIJ23KMNOPQR48SGUVWXYZ19';
            $str = str_shuffle($str_old);
            $sn = substr($str,0,8);
//            var_dump($sn);die;
            $data['sn'] = $sn;
//            var_dump($data);die;
            $validate = validate('server');
            if (!$validate->check($data)){
                return $this->error($validate->getError());
            }else{
//                var_dump($server);die;
                $result = $server->create($data);
                if ($result){
                    $this->success('新增成功', url('index.php'));
                    //记录行为
//                    action_log('update_channel', 'channel', $data->id, UID);
                }else{
                    $this->error($server->getError());
                }
            }
        }else{
            return $this->fetch();
        }
    }
}
