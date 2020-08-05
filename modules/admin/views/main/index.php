<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 10:33
 * @var $this \yii\web\View
 * @var $content string
 */
use app\common\helpers\Url;
use app\assets\AdminAsset;

AdminAsset::register($this);

$this->title = Yii::$app->debris->config('site_name').Yii::$app->debris->config('subtitle_name');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <title><?= $this->title.' - 管理后台' ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
    <style id="layuimini-bg-color">
    </style>
</head>
<body class="layui-layout-body layuimini-all">
<?php $this->beginBody() ?>
<div class="layui-layout layui-layout-admin">
    <!--header-->
    <?= $this->render('_header'); ?>
    <!--无限极左侧菜单-->
    <?= $this->render('_sidebar'); ?>
    <!--初始化加载层-->
    <div class="layuimini-loader">
        <div class="layuimini-loader-inner"></div>
    </div>
    <!--手机端遮罩层-->
    <div class="layuimini-make"></div>
    <!-- 移动导航 -->
    <div class="layuimini-site-mobile"><i class="layui-icon"></i></div>
    <!-- 内容区域 -->
    <?= $this->render('_content'); ?>
</div>
<script src="/resources/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
<script src="/resources/js/lay-config.js?v=2.0.0" charset="utf-8"></script>
<script>
    layui.use(['jquery', 'layer', 'miniAdmin'], function () {
        var $ = layui.jquery,
            layer = layui.layer,
            miniAdmin = layui.miniAdmin;

        var options = {
            iniUrl: "/resources/api/init.json",    // 初始化接口
            clearUrl: "/admin/config/clear", // 缓存清理接口
            urlHashLocation: true,      // 是否打开hash定位
            bgColorDefault: 0,          // 主题默认配置
            multiModule: true,          // 是否开启多模块
            menuChildOpen: false,       // 是否默认展开菜单
            loadingTime: 0,             // 初始化加载时间
            pageAnim: true,             // iframe窗口动画
            maxTabNum: 20,              // 最大的tab打开数量
        };
        miniAdmin.render(options);

        $('.login-out').on("click", function () {
            $.post('<?=Url::to(['/admin/user/logout'])?>');
            layer.msg('退出登录成功', function () {
                window.location = '<?=Url::to(['/admin/user/login'])?>';
            });
        });
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
