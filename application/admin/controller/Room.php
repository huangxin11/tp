<?php
namespace app\admin\controller;
use app\admin\model\RoomContent;
use think\Controller;
use think\Db;

class Room extends Admin {
    public function index(){
        $room = Db::name('room')->paginate(2);
        $page = $room->render();
        $this->assign('room',$room);
        $this->assign('page',$page);
        return $this->fetch();
    }
    public function add(){
        if ($this->request->isPost()){
            $data = $this->request->post();
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            unset($data['parse']);
            $room = model('room');
            $validate = validate('room');
            if ($validate->check($data)){
                return $this->error($validate->getError());
            }else{
               $result = $room->create($data);
               if ($result){
                   return $this->success('新增成功',url('add'));
               }else{
                   $this->error($room->getError());
               }
            }
        }else{
            return $this->fetch();
        }
    }
    public function edit($id = 0){
        if ($this->request->isPost()){
            $data = $this->request->post();
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            unset($data['parse']);
            $shop = \think\Db::name("room");
            $result = $shop->update($data);
            if ($result != false){
                $this->success('修改成功', url('index'));
            }else{
                $this->error('修改失败');
            }
        }else{
            /* 获取数据 */
            $room = \think\Db::name('room')->where('id',$id)->find();
            if(null === $room){
                $this->error('获取配置信息错误');
            }
//            var_dump($room);die;
            $room['start_time'] = date('Y-m-d H:s',$room['start_time']);
            $room['end_time'] = date('Y-m-d H:s',$room['end_time']);
            $this->assign('room', $room);
            $this->meta_title = '修改租售信息';
            return $this->fetch('add');
        }
    }

}
