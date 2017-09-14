<?php
/**
 * Created by PhpStorm.
 * User: 周子健
 * Date: 2017/9/11
 * Time: 18:22
 */

namespace app\index\controller;
use app\index\model\Online as OnlineModel;

class Online extends Home
{
    public function online()
    {


//        dump();exit;
//        dump(date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8));

        if (session('username')){
            if (request()->isPost()){
                $data = input('post.');
                          $strings='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
                $str = str_shuffle ($strings);
                $str = substr($str,5,35);
                $data['number'] = 'IT'.substr($str,0,30);
                $data['user_id'] = session('uid');
                if (OnlineModel::create($data)){
                    $this->success('新增成功', 'index.php/index/index/index');
                } else {
                    $this->error('新增失败');
                }
            }
            return $this->fetch();
        }else{
            $this->error('你还未登录请登录','index.php/index/login/login');
        }


    }

}