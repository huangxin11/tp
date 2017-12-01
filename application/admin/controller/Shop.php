<?php
namespace app\admin\controller;

use think\Db;

class Shop extends Admin {
    /**
     * 展示
     */
    public function index(){
        $shop = \think\Db::name('shop')->where('status','>',0)->paginate(2);
        $page = $shop->render();
        $this->assign('_page',$page);
        $this->assign('shop',$shop);
        return $this->fetch();
    }
    /**
     * 添加
     */
    public function add(){
        if ($this->request->isPost()){

            $shop = model('shop');
            $data = \think\Request::instance()->post();
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
//            var_dump($data['start_time']);die;
            $validate = validate('shop');
            if (!$validate->check($data)){
                return $this->error($validate->getError());
            }else{
                $result = $shop->create($data);
                if ($result){
                    $this->success('新增成功',url('index'));
                }else{
                    $this->error($shop->getError());
                }
            }
        }else{
            return $this->fetch();
        }

    }
    /**
     * 修改
     */
    public function edit($id = 0){
            if ($this->request->isPost()){
                $data = \think\Request::instance()->post();
                $data['start_time'] = strtotime($data['start_time']);
                $data['end_time'] = strtotime($data['end_time']);
//                var_dump($data);die;
                $shop = \think\Db::name("shop");
                $result = $shop->update($data);
                if($result !== false){
                    $this->success('修改成功', url('index'));
                } else {
                    $this->error('修改失败');
                }
            }else{
                /* 获取数据 */
                $shop = \think\Db::name('shop')->find($id);
                if(false === $shop){
                    $this->error('获取配置信息错误');
                }
                $shop['start_time'] = date('Y-m-d H:s',$shop['start_time']);
                $shop['end_time'] = date('Y-m-d H:s',$shop['end_time']);
                $this->assign('shop', $shop);
                $this->meta_title = '修改商家活动';
                return $this->fetch('add');
            }
    }
    /**
     * 逻辑删除
     */
    public function del($id = 0){
        if ($this->request->isAjax()){
            $id = input('id',0);
            $shop = \think\Db::name('shop')->find($id);
            $shop['status']= 0;
            $data = \think\Db::name('shop');
            $result = $data->update($shop);
            if ($result){
                 $this->success('删除成功!');
            }
        }
    }
    /**
     * 过期删除
     */
    public function time(){
        $time = time();
        Db::query("update shop set status=0 where {$time}>=end_time");
    }
}
