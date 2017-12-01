<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络 <http://www.twothink.cn>
// +----------------------------------------------------------------------

namespace app\user\controller;
use app\common\controller\UcApi;
use app\common\model\UcenterMember;
use app\home\controller\Wechat;
use app\user\model\Member;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Session;

/**
 * 用户登入
 * 包括用户登录及注册
 */
class Login extends Controller {
    public function __construct(){
        /* 读取站点配置 */
        $config = api('Config/lists');
        config($config); //添加配置
        parent::__construct();
    }
    /* 登录页面 */
    public function index($username = '', $password = '', $verify = '',$type = 1){
        //判断用户是否绑定账号
        //获取opendid
        //保存当前地址
        Session::set('return_url',url('user/login/index'));
        if (!Session::has('openid')){
            //第一步：用户同意授权，获取code
            //1 引导关注者打开如下页面
            $appid = 'wx31187cf6a0191ab0';
            //设置绝对路径url地址
            $callback_url = url('home/wechat/callback','',true,true);
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?".
                "appid={$appid}&redirect_uri={$callback_url}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            $this->redirect($url);
        }
        $openid = Session::get('openid');
            $user = Db::name('ucenter_member')->where('openid',$openid)->find();
            if ($user){
                $ucm = new UcenterMember();
                $ucm->autoLogin($user->id);
                $member = model('Member');
                $member->login($user->id);
//                $cookie_url = Cookie::get('__forward__');
                $this->redirect('home/my/index');


            }else{
//                echo 1;die;
                if($this->request->isPost()){ //登录验证
//            var_dump($_POST);die;
                    /* 检测验证码 */
                    if(!captcha_check($verify)){
                        $this->error('验证码输入错误！');
                    }

                    /* 调用UC登录接口登录 */
                    $user = new UcApi;
                    $uid = $user->login($username, $password, $type);
                    if(0 < $uid){ //UC登录成功
                        /* 登录用户 */
                        $Member = model('Member');
                        if($Member->login($uid)){ //登录用户
                            //TODO:跳转到登录前页面
                            if(!$cookie_url = Cookie::get('__forward__')){
                                $cookie_url = url('Home/Index/index');
                            }
                            //绑定用户
                            Db::name('ucenter_member')->where('id',$uid)->setField('openid',$openid);
                            //写入数据库
                                $this->success('登录成功！',$cookie_url);
                        } else {
                            $this->error($Member->getError());
                        }
                    } else { //登录失败
                        switch($uid) {
                            case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                            case -2: $error = '密码错误！'; break;
                            default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                        }
                        $this->error($error);
                    }

                } else { //显示登录表单
                    return $this->fetch();
                }
            }

    }

	/* 注册页面 */
	public function register($username = '', $password = '', $repassword = '', $email = '', $verify = ''){
        if(!config('user_allow_register')){
            $this->error('注册已关闭');
        }
		if($this->request->isPost()){ //注册用户
			/* 检测验证码 */
		   if(!captcha_check($verify)){
                $this->error('验证码输入错误！');
            }

			/* 检测密码 */
			if($password != $repassword){
				$this->error('密码和重复密码不一致！');
			}			

			/* 调用注册接口注册用户 */
            $User = new UcApi;
			$uid = $User->register($username, $password, $email); 
			if(0 < $uid){ //注册成功
				//TODO: 发送验证邮件
				$this->success('注册成功！',url('login/index'));
			} else { //注册失败，显示错误信息
				$this->error($uid);
			}

		} else { //显示注册表单
			return $this->fetch();
		}
	}
	/* 退出登录 */
	public function logout(){
		if(is_login()){
			model('Member')->logout();
			$this->success('退出成功！', url('User/login'));
		} else {
			$this->redirect('User/login');
		}
	}

}
