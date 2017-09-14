<?php
/**
 * Created by PhpStorm.
 * User: 周子健
 * Date: 2017/9/12
 * Time: 19:23
 */

namespace app\index\controller;
use app\index\model\User as UserModel;
use app\index\model\Online;
class User extends Home
{
    public function index()
    {

        if (!session('uid')){
            $this->error('你还未登录','index.php/index/login/login');
        }
        $user = UserModel::get(['id'=>session('uid')]);
        $sign = db('index_sign')->where(['user_id'=>session('uid')])->value('integral');

        return $this->fetch('user',['user'=>$user,'sign'=>$sign]);
    }

    public function online($id)
    {
        $onlines = Online::all(['user_id'=>$id]);
        return $this->fetch('online',['onlines'=>$onlines]);

    }

    public function logout()
    {

        session('uid',null);
        session('username',null);
        $this->success('退出成功','/index.php/index/index/index');
    }

    public function sign()
    {
        $sign  = db('index_sign')->where(['user_id'=>session('uid'),'create_time'=>date('Ymd')])->find();
        if ($sign){
           $this->error('今天已签到!请勿重复操作');
        }else{
            $row = db('index_sign')->where(['user_id'=>session('uid')])->find();
            if ($row){
                $result = db('index_sign')->where(['user_id'=>$row['id']])->update(['integral'=>$row['integral']+10,'create_time'=>date('Ymd')]);
                if ($result){
                    $this->success('签到成功 积分+10','index');
                }
            }else{
                $result = db('index_sign')->insert([
                    'user_id'=>session('uid'),
                    'integral'=>10,
                    'create_time'=>date('Ymd'),
                ]);
                if ($result){
                    $this->success('签到成功 积分+10','index');
                }
            }

        }

    }


}