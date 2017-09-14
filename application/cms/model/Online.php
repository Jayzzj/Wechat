<?php
/**
 * Created by PhpStorm.
 * User: 周子健
 * Date: 2017/9/12
 * Time: 15:25
 */

namespace app\cms\model;
use think\model as ThinkModel;

class Online extends ThinkModel
{
    protected $table  = '__INDEX_ONLINE__';

    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d H:i:s',$value);
    }

    public function getStatusAAttr($v,$data)
    {
        $status = [
            0=>'未处理',
            1=>'处理中',
            2=>'已处理'
        ];
        return $status[$data['status']];
    }

    public function getStatusNameAttr($value,$data)
    {
        if ($data['status']==0){
            return '<a href="edit?id='.$data['id'].'"class="btn btn-info ajax-get">未处理</a>';
        }
        if ($data['status']==1){
            return '<a href="edit?id='.$data['id'].'"class="btn btn-success ajax-get">处理中</a>';
        }

        if ($data['status'] ==2){
            return '处理完成';
        }

    }

}