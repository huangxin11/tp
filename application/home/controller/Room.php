<?php
namespace app\home\controller;
use think\Db;

class Room extends Home{
    public function index(){
        $room = Db::name('room')->where('status',1)->where('room',1)->select();
        $room1 = Db::name('room')->where('status',1)->where('room',2)->select();
        $this->assign('room',$room);
        $this->assign('room1',$room1);
        return $this->fetch();
    }
    public function view($id = 0){
        $room = Db::name('room')->where('id',$id)->find();
        $this->assign('room',$room);
        return $this->fetch();
    }
}
