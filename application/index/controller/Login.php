<?php
/**
 * Created by PhpStorm.
 * User: 周子健
 * Date: 2017/9/11
 * Time: 21:47
 */

namespace app\index\controller;


use app\index\model\User;
use think\Controller;

class Login extends Controller
{
    public function login()
    {
        if (request()->isPost()){
            $data = input('post.');
            $checkCode = $this->validate($data,[
                'captcha|验证码'=>'require|captcha'
            ]);
            if ($checkCode!==true){
                $this->error($checkCode);
            }
           $user = User::get(['username'=>$data['username']]);
            if ($user){
                if (password_verify($data['password'],$user['password'])){
                    session('uid',$user['id']);
                    session('username',$user['username']);
                    $user['last_login_time'] = time();
                    $user['last_login_ip'] = ip2long(request()->ip());
                    $user->save();
                    $this->success('登录成功','index.php/index/index/index');
                }else{
                    $this->error('密码不正确');
                }
            }else{
                $this->error('用户名不存在');
            }
        }
        return  $this->fetch();
    }

    public function register()
    {
        if (request()->isPost()){
            $data = input('post.');
            $result = $this->validate($data,'User');
            if (true !== $result) $this->error($result);
            if (empty($data['checkbox'])){
                $this->error('请同意协议');
            }
            $userModel = new User();
            if ($data['password']===$data['repassword']){
                if ($userModel->save($data)){
                    $this->success('注册成功','login');
                }else{
                    $this->error($userModel->getError());
                }
            }else{
                $this->error('两次密码不一致');
            }
        }
        return $this->fetch();
    }

}