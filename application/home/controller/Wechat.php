<?php
namespace app\home\controller;
use think\Controller;
use think\Session;

class Wechat extends Home {
    //获取用户的oppid
    public function info(){
        //保存当前地址
        Session::set('return_url',url('home/wechat/info'));
        if (!Session::has('openid')){
            //第一步：用户同意授权，获取code
            //1 引导关注者打开如下页面
            $appid = 'wx31187cf6a0191ab0';
            //设置绝对路径url地址
            $callback_url = url('home/wechat/callback','',true,true);
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?".
                "appid={$appid}&redirect_uri={$callback_url}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            $this->redirect($url);
        }else{
            $openid = Session::get('openid');
        }

    }
    //授权成功回调页
    public function callback(){
//        echo 'callback';die;
        $code = request()->get('code');
        //通过code换取网页授权access_token
        //请求：https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
        $appid = 'wx31187cf6a0191ab0';
        $secret = 'db4bd5e2c27081cc04538f36c12f0a05';
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code";
        $str = file_get_contents($url);
        $json = json_decode($str);
        //将opendid保存到session
        Session::set('openid',$json->openid);
        if (Session::has('return_url')){
            $this->redirect(Session::get('return_url'));
        }

    }
}















































