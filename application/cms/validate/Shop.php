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

namespace app\cms\validate;

use think\Validate;

/**
 * 广告验证器
 * @package app\cms\validate
 * @author 蔡伟明 <314013107@qq.com>
 */
class Shop extends Validate
{
    // 定义验证规则
    protected $rule = [
        'title'   => 'require|unique:cms_shop',
        //'tagname|广告位标识' => 'require|regex:^[a-z]+[a-z0-9_]{0,20}$|unique:cms_advert',
        'content'    => 'require',
        'start_time'    => 'require',
        'end_time'      => 'require',
        'logo'         => 'require',
        'status'         => 'require',
        //'browser'          => 'requireIf:ad_type,0',
        'browser'          => 'integer',
        //'width'         => 'integer',
        //'height'        => 'integer',
        //'src'           => 'requireIf:ad_type,2',
    ];

    // 定义验证提示
    protected $message = [
        'tagname.regex' => '广告位标识由小写字母、数字或下划线组成，不能以数字开头',
        'browser'          => '浏览量只能是数字',
        'logo'           => 'logo不能为空',
        'title'         => '标题内容不能为空',
        'title.unique'         => '标题名称已存在',
        'start_time'    => '开始时间不能为空',
        'end_time'      => '结束时间不能为空',
        'content'      => '内容不能为空',
        'status'      => '状态必填',
        //'size'          => '文字大小只能填写数字',
        //'width'         => '宽度只能填写数字',
        //'height'        => '高度只能填写数字',
    ];

    // 定义验证场景
    protected $scene = [
        'name' => ['name']
    ];
}
