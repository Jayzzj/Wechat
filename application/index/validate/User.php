<?php
namespace app\index\validate;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: 周子健
 * Date: 2017/9/12
 * Time: 21:59
 */
class User extends Validate
{
    // 定义验证规则
    protected $rule = [
        'username'   => 'require|unique:index_user|min:5',
        'password'    => 'require',
        //'logo'         => 'require',
        'tel'          => 'require|unique:index_user|min:11',
        'address'         => 'require',
        //'browser'          => 'integer',
        //'width'         => 'integer',
        //'height'        => 'integer',
        //'src'           => 'requireIf:ad_type,2',
    ];

    // 定义验证提示
    protected $message = [
        'username.require'         => '用户名不能为空',
        'username.min'         => '用户名至少5位',
        'username.unique'         => '用户名已存在',
        'password.require'         => '密码不能为空',
        'tel.require'         => '电话不能为空',
        'tel.unique'         => '电话已存在',
        'tel.min'         => '请输入有效手机号',
        'address'         => '地址不能为空',
        //'size'          => '文字大小只能填写数字',
        //'width'         => '宽度只能填写数字',
        //'height'        => '高度只能填写数字',
    ];

    // 定义验证场景
    protected $scene = [
        'name' => ['name']
    ];

}