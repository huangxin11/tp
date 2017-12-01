<?php
namespace app\home\controller;
use think\Controller;
use think\Db;

class Server extends Home{
    public function index(){
        $uid = is_login();
        if (!$uid){
             $this->error('请先登录',url('user/login/index'));
        }
        $user = Db::name('ucenter_member')->where('id',$uid)->find();
        if ($user['status'] != 2){
             $this->error('你还没有认证，请先认证',url('/home/owner/index'));
        }
        if ($this->request->isAjax()){
            $page = $this->request->get('page');
            $notice = \think\Db::name('server')->limit(2)->page($page)->select();
            $notice['page']=$page;
            return json_encode($notice);
        }else{
            $page = 1;
        }
        $servers = \think\Db::name('server')->limit(2)->page($page)->select();
        $total = \think\Db::name('server')->count();
        $this->assign('page',$page);
        $this->assign('servers',$servers);
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
    public function notice_article($id){
        /* 更新浏览数 */
        $map = array('id' => $id);
        $server = new \app\home\model\Server();
        $server->where($map)->setInc('view');
        $notice_article = \think\Db::name('server')->where(['id'=>$id])->find();

        $notice = \think\Db::name('document')->where(['id'=>$id])->find();
        $user = \think\Db::name('member')->where(['uid'=>$notice['uid']])->find();
//        var_dump($user);die;
        $this->assign('notice_article',$notice_article);
        $this->assign('notice',$notice);
        $this->assign('user',$user);
        return $this->fetch();
    }
}
