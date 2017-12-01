<?php
namespace app\home\controller;
use app\home\model\UserArticle;
use think\Db;
use think\Validate;

class Community extends Home{
    /**
     * 展示活动
     */
    public function index(){
        if ($this->request->isAjax()){
            $page = $this->request->get('page');
            $shop = \think\Db::name('document')->where('status',1)->where('category_id',43)->where('deadline','>=',time())->limit(2)->page($page)->select();
            $shop['page']=$page;
            return json_encode($shop);
        }else{
            $page = 1;
        }
        $shop = \think\Db::name('document')->where('status',1)->where('category_id',43)->where('deadline','>=',time())->limit(2)->page($page)->select();
        $this->assign('page',$page);
        $this->assign('shop',$shop);
//        var_dump($shop);die;
        return $this->fetch();
    }
    public function path(){
        if ($this->request->isAjax()){
            $id = $this->request->post('cover_id');
            $end = $this->request->post('end');
            $time = $this->request->post('time');
            $end_time = date('Y-m-d H:i',$end);
            $time = date('Y-m-d H:i',$time);
            $data['path'] = get_cover($id)['path'];
            $data['end']=$end_time;
            $data['time'] = $time;
            return $data;
        }
    }
    public function community_article($id = 0){
        $notice = new \app\home\model\Document();
        /* 更新浏览数 */
        $map = array('id' => $id);
        $notice->where($map)->setInc('view');
//        var_dump($id);die;
        $shop_article = \think\Db::name('document_article')->where(['id'=>$id])->find();
        $shop = \think\Db::name('document')->where(['id'=>$id])->find();
        $user = \think\Db::name('member')->where(['uid'=>$shop['uid']])->find();
//        var_dump($shop);die;
        $this->assign('shop_article',$shop_article);
//        var_dump($shop_article);die;
        $this->assign('shop',$shop);
        $this->assign('user',$user);
        return $this->fetch();
    }
    public function play(){
        if ($this->request->isAjax()){
            $uid = is_login();
            if (!$uid){
                return 'nologin';
            }
            $article_id = input('article_id',0);
//            var_dump($article_id);die;
            $result = Db::name('user_article')->where('article_id',$article_id)->find();
//            var_dump($result);die;
            if ($result['user_id']){
                return 'false';
            }else{
                $user =new UserArticle();
                $data = [  'user_id' => $uid, 'article_id' =>$article_id];
                    $result1 = $user->insert($data);
                    if ($result1){
                       return 'success';
                    }else{
                        return 'shibai';
                    }
                }
            }


    }
}