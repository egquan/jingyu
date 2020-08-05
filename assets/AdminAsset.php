<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 10:34
 */

namespace app\assets;

use yii\web\AssetBundle;
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'resources/lib/layui-v2.5.5/css/layui.css',
        'resources/css/layuimini.css',
        'resources/lib/font-awesome-4.7.0/css/font-awesome.min.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\CompatibilityIEAsset',
    ];
}