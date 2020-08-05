<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 10:58
 */

namespace app\assets;

use yii\web\AssetBundle;
class CompatibilityIEAsset extends AssetBundle
{
    public $js = [
        'resources/lib/html5shiv.min.js',
        'resources/lib/js/respond.min.js',
    ];

    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => \yii\web\View::POS_HEAD
    ];
}