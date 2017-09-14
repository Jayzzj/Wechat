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

namespace app\index\controller;
use app\cms\model\Activity;
use app\cms\model\Notice;
use app\cms\model\Questionnaire;
use app\cms\model\Sale;
use app\cms\model\Service;
use app\cms\model\Shop;

/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Home
{
    public function index()
    {
        // 默认跳转模块
        if (config('home_default_module') != 'index') {
            $this->redirect(config('home_default_module'). '/index/index');
        }
        return $this->fetch();
    }

    public function notice()
    {
        $notices = Notice::all();

        return $this->fetch('notice',['notices'=>$notices]);
    }

    public function content($id)
    {
        $notice = Notice::get($id);
        return $this->fetch('notice-detail',['notice'=>$notice]);
    }

    public function services()
    {
        $services = Service::all();
        return $this->fetch('service',['services'=>$services]);
    }

    public function service($id)
    {
        $service = Service::get($id);
        return $this->fetch('service-detail',['service'=>$service]);
    }

    public function shops()
    {
        $shops = Shop::all();
        return $this->fetch('shop',['shops'=>$shops]);
    }

    public function shop($id)
    {
        $shop = Shop::get($id);
        return $this->fetch('shop-detail',['shop'=>$shop]);
    }

    public function activitys()
    {
        $activitys = Activity::all();
        return $this->fetch('activity',['activitys'=>$activitys]);
    }

    public function activity($id)
    {
        $activity = Activity::get($id);
        return $this->fetch('activity-detail',['activity'=>$activity]);
    }

    public function sale()
    {
        $shous = Sale::all(['type'=>1]);
        $zhus = Sale::all(['type'=>0]);

        return $this->fetch('zushou',['shous'=>$shous,'zhus'=>$zhus]);
    }

    public function zushou($id)
    {
        $sale = Sale::get($id);
        return $this->fetch('zushou-detail',['sale'=>$sale]);
    }

    public function fuwu()
    {
        return $this->fetch();
    }

    public function questionnaire()
    {
        $questionnaires = Questionnaire::all();
        return $this->fetch('diaochawenjuan',['questionnaires'=>$questionnaires]);
    }

    public function guanyu()
    {
        return '关于我们';
    }

    public function yezhurenzheng()
    {
        return $this->fetch();
    }




}
