<?php
/**
 * Created by PhpStorm.
 * User: 周子健
 * Date: 2017/9/13
 * Time: 10:58
 */

namespace app\cms\model;


class Questionnaire extends \think\Model
{
    protected  $table = '__CMS_QUESTIONNAIRE__';

    public function setEndTimeAttr($value)
    {
        return $value != '' ? strtotime($value) : 0;
    }

    public function getEndTimeAttr($value)
    {
        return $value != 0 ? date('Y-m-d H:i:s', $value) : '';
    }

}