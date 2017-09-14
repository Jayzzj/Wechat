<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\cms\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\cms\model\Sale as SaleModel;
use app\cms\model\AdvertType as AdvertTypeModel;
use think\Validate;

/**
 * 广告控制器
 * @package app\cms\admin
 */
class Sale extends Admin
{
    /**
     * 广告列表
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 排序
        $order = $this->getOrder('update_time desc');
        // 数据列表
        $data_list = SaleModel::where($map)->order($order)->paginate();



        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '标题', 'text.edit'],
                ['name', '发布人', 'text'],
                ['tel', '发布人电话', 'text'],
                //['logo', 'logo', 'src'],
                ['intro', '简介', 'text'],
                ['type_name', '租/售', 'text'],
                ['price', '价格', 'text'],
                ['end_time', '结束时间', 'text'],
                ['status', '状态', 'switch'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,enable,disable,delete') // 批量添加顶部按钮
            //->addTopButton('custom', $btnType) // 添加顶部按钮
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']]) // 批量添加右侧按钮
            ->addOrder('id,name,typeid,timeset,ad_type,create_time,update_time')
            ->setRowList($data_list) // 设置表格数据
            //->addValidate('Advert', 'name')
            ->fetch(); // 渲染模板
    }

    /**
     * 新增
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function add()
    {

        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();
            $data['name']= $_SESSION['dolphin_admin_']['user_auth']['username'];

            // 验证
//            $result = $this->validate($data, 'Notice');
//            if (true !== $result) $this->error($result);
//            if ($data['ad_type'] != 0) {
//                $data['link'] == '' && $this->error('链接不能为空');
//               Validate::is($data['link'], 'url') === false && $this->error('链接不是有效的url地址'); // true
//            }



            if ($notice = SaleModel::create($data)) {
                // 记录行为
                action_log('notice_add', 'cms_notice', $notice['id'], UID, $data['title']);
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }

        //$list_type = AdvertTypeModel::where('status', 1)->column('id,name');
        //array_unshift($list_type, '默认分类');

        // 显示添加页面
        return ZBuilder::make('form')
            ->setPageTips('如果出现无法添加的情况，可能由于浏览器将本页面当成了广告，请尝试关闭浏览器的广告过滤功能再试。', 'warning')
            ->addFormItems([
                ['text', 'title', '标题', '由小写字母、数字或下划线组成，不能以数字开头'],
                ['text', 'price', '价格'],
                ['textarea', 'intro', '简介'],
                ['radio', 'status', '立即启用', '', ['否', '是']]
            ])
            ->addSelect('company', '单位', '',[0 => '元/月', 1 => '万元'])
            ->addSelect('type', '类型', '',[0 => '出租', 1 => '出售'])
            ->addImage('logo', '图片')
            ->addUeditor('content', '内容')
            ->addDatetime('end_time', '截止日期时间')
            ->addText('tel','联系电话')
            ->fetch();
    }

    /**
     * 编辑
     * @param null $id 广告id
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');

        // 保存数据
        if ($this->request->isPost()) {
            //exit(11);
            // 表单数据
            $data = $this->request->post();
            $data['name'] = $_SESSION['dolphin_admin_']['user_auth']['username'];
            // 验证
//            $result = $this->validate($data, 'Notice');
//            if (true !== $result) $this->error($result);

            if (SaleModel::update($data)) {
                // 记录行为
                action_log('sale_edit', 'cms_sale', $id, UID, $data['title']);
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }

            $info = SaleModel::get($id);
            //$info['ad_type'] = ['代码', '文字', '图片', 'flash'][$info['ad_type']];
            // 显示编辑页面
            // 显示添加页面
            return ZBuilder::make('form')
                ->setPageTips('如果出现无法添加的情况，可能由于浏览器将本页面当成了广告，请尝试关闭浏览器的广告过滤功能再试。', 'warning')
                ->addFormItems([
                    ['hidden', 'id'],
                    ['text', 'title', '标题', '由小写字母、数字或下划线组成，不能以数字开头'],
                    ['text', 'price', '价格'],
                    ['textarea', 'intro', '简介'],
                    ['radio', 'status', '立即启用', '', ['否', '是']]
                ])
                ->addSelect('company', '单位', '', [0 => '元/月', 1 => '万元'])
                ->addSelect('type', '类型', '', [0 => '出租', 1 => '出售'])
                ->addImage('logo', '图片')
                ->addUeditor('content', '内容')
                ->addDatetime('end_time', '截止日期时间')
                ->addText('tel', '联系电话')
                ->setFormData($info)
                ->fetch();



    }

    /**
     * 删除广告
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function delete($record = [])
    {
        return $this->setStatus('delete');
    }

    /**
     * 启用广告
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function enable($record = [])
    {
        return $this->setStatus('enable');
    }

    /**
     * 禁用广告
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function disable($record = [])
    {
        return $this->setStatus('disable');
    }

    /**
     * 设置广告状态：删除、禁用、启用
     * @param string $type 类型：delete/enable/disable
     * @param array $record
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function setStatus($type = '', $record = [])
    {
        $ids         = $this->request->isPost() ? input('post.ids/a') : input('param.ids');
        $sale_name = SaleModel::where('id', 'in', $ids)->column('title');
        return parent::setStatus($type, ['sale_'.$type, 'cms_sale', 0, UID, implode('、', $sale_name)]);
    }

    /**
     * 快速编辑
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function quickEdit($record = [])
    {
        $id      = input('post.pk', '');
        $field   = input('post.name', '');
        $value   = input('post.value', '');
        $sale  = SaleModel::where('id', $id)->value($field);
        $details = '字段(' . $field . ')，原值(' . $sale . ')，新值：(' . $value . ')';
        return parent::quickEdit(['sale_edit', 'cms_sale', $id, UID, $details]);
    }
}