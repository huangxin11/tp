<?php
namespace app\admin\controller;

/**
 * 后台保修
 */
class Server extends Admin{
    /**
     * 展示保修订单
     */
    public function index(){
        $servers = \think\Db::name('server')->select();
        $this->assign('servers',$servers);
        return $this->fetch();
//        var_dump($server);die;
    }
    /**
     * 添加报修订单
     */
    public function add(){
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
                    $this->success('新增成功', url('index'));
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
    /**
     * 操作报修
     */
    public function edit($id = 0){
//        var_dump($id);die;
        if($this->request->isPost()){
            $data = \think\Request::instance()->post();
            $server = \think\Db::name("server");
            $result = $server->update($data);
            if($result !== false){
                $this->success('修改成功', url('index'));
            } else {
                $this->error('修改失败');
            }
        } else {
            /* 获取数据 */
            $server = \think\Db::name('server')->find($id);
            if(false === $server){
                $this->error('获取配置信息错误');
            }
            $this->assign('server', $server);
            $this->meta_title = '修改报修订单';
            return $this->fetch('add');
        }
    }

    /**
     * 删除订单
     */
    public function del(){
    if ($this->request->isAjax()){
        $id = input('id',0);
        if (\think\Db::name('server')->where(['id'=>$id])->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败！');
        }
    }
    }
}
