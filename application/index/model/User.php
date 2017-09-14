<?php
/**
 * Created by PhpStorm.
 * User: 周子健
 * Date: 2017/9/11
 * Time: 21:48
 */

namespace app\index\model;

use think\Model as ThinkModel;
class User extends ThinkModel
{
    protected $table = '__INDEX_USER__';

    protected $autoWriteTimestamp = true;

    public function setPasswordAttr($value)
    {
        return password_hash($value,PASSWORD_DEFAULT);
    }



}