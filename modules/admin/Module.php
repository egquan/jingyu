<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * 控制器命名空间
     * @var string
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * 设置布局文件
     * @var string
     */
    public $layout = 'default';

    /**
     * 默认路由
     * @var string
     */
    public $defaultRoute = 'main';

    /**
     * 初始化
     */
    public function init()
    {
        $this->errorHandler->errorAction = 'admin/base/error';
        parent::init();

        // custom initialization code goes here
    }
}
