<?php
/**
 * Created by PhpStorm.
 * User: 周子健
 * Date: 2017/9/12
 * Time: 15:22
 */

namespace app\cms\admin;


use app\admin\controller\Admin;
use app\cms\model\Online as OnlineModel;
use app\common\builder\ZBuilder;

class Online extends Admin
{
    public function index()
    {

        //查询
        $map = $this->getMap();
        //排序
        $order = $this->getOrder('update_time desc');
        //数据列表
        $data_list = OnlineModel::where($map)->order($order)->paginate();
        //使用ZBuilder快速创建数据表格
        $btn_access = [
            'title' => '查看详情',
            'icon'  => 'fa fa-fw fa-list-alt',
            'href'  => url('content', ['id' => '__id__'])
        ];
        return ZBuilder::make('table')
            ->setSearch(['name'=>'报修名称'])
            ->addColumns([
                ['number','单号','text'],

                ['title','报修名称','text'],
                ['name','报修人','text'],
                ['tel','联系电话','text'],
                ['address','用户住址','text'],
                ['create_time','报修时间','text'],
                ['status_a','状态','text'],
                ['status_name','处理','text'],
                ['right_button', '操作', 'btn'],

            ])
            ->addTopButtons('add,enable,disable,delete')
            ->addRightButton('access',$btn_access)
//            ->addRightButton('edit', ['href' => url('edit', ['id' => '__id__', 'group' => 'index']),'icon'  => 'fa fa-fw fa-wrench','title' => '处理订单','text'=>'编辑'])
               // ->addRightButton('delete')
            ->addRightButtons(['delete' => ['data-tips' => '删除后无法恢复。']]) // 批量添加右侧按钮
            ->setRowList($data_list)
            ->fetch();
    }

    public function edit($id=null)
    {
        if ($id === null) $this->error('缺少参数');
        $online = OnlineModel::get($id);
        if ($online->status ==0){
            $online->status =1;
        }elseif ($online->status ==1){
            $online->status = 2;
        }elseif ($online->status == 2){

        }
        if ($online->save()){
            $this->success('更新成功','index');
        }else{
            $this->error($online->getError());
        }
    }

    public function content($id)
    {
        $data_list = OnlineModel::get($id);
        //生成表格
        return ZBuilder::make('table')
            ->addColumns([
                ['number','报修编号','text'],
                ['title','报修标题','text'],
                ['status_a','状态','text'],
                ['name','报修人','text'],
                ['tel','联系电话','text'],
                ['content','报修内容','text'],
            ])
            ->setRowList([$data_list])
            ->fetch();
    }

}