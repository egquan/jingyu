<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 12:50
 */

namespace app\assets;

use yii\web\AssetBundle;
class AdminOneAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'resources/lib/layui-v2.5.5/css/layui.css',
        'resources/css/public.css',
    ];
    public $js = [
        'resources/lib/layui-v2.5.5/layui.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}