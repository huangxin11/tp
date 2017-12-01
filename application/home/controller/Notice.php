<?php
namespace app\home\controller;
use app\home\model\Document;

class Notice extends Home{
    /**
     * 展示通知
     */
    public function index(){
        if ($this->request->isAjax()){
            $page = $this->request->get('page');
            $notice = \think\Db::name('document')->where(['status'=>1])->limit(2)->page($page)->select();
            $notice['page']=$page;
            return json_encode($notice);
        }else{
            $page = 1;
        }
        $notice = \think\Db::name('document')->where(['status'=>1])->limit(2)->page($page)->select();
        $this->assign('notice',$notice);
        $this->assign('page',$page);
        return $this->fetch();
    }
    public function notice_article($id){
        $notice = new \app\home\model\Document();
        /* 更新浏览数 */
        $map = array('id' => $id);
        $notice->where($map)->setInc('view');
        $notice_article = \think\Db::name('document_article')->where(['id'=>$id])->find();

        $notice = \think\Db::name('document')->where(['id'=>$id])->find();
        $user = \think\Db::name('member')->where(['uid'=>$notice['uid']])->find();
//        var_dump($user);die;
        $this->assign('notice_article',$notice_article);
        $this->assign('notice',$notice);
        $this->assign('user',$user);
        return $this->fetch();
    }
    public function path(){
        if ($this->request->isAjax()){
            $id = $this->request->post('cover_id');
            $time = $this->request->post('time');
            $time = date('Y-m-d H:i',$time);
            $data['path'] = get_cover($id)['path'];
            $data['time'] = $time;
            return $data;
        }
    }

}
