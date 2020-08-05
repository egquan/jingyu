<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/8/4
 * Time: 23:21
 * @var $this yii\web\View
 */
$this->registerCssFile('/resources/lib/font-awesome-4.7.0/css/font-awesome.min.css')
?>
<style>
    .layui-card {border:1px solid #f2f2f2;border-radius:5px;}
    .icon {margin-right:10px;color:#1aa094;}
    .icon-blue {color:#1e9fff!important;}
    .layuimini-qiuck-module {text-align:center;margin-top: 10px}
    .layuimini-qiuck-module a i {display:inline-block;width:100%;height:60px;line-height:60px;text-align:center;border-radius:2px;font-size:30px;background-color:#F8F8F8;color:#333;transition:all .3s;-webkit-transition:all .3s;}
    .layuimini-qiuck-module a cite {position:relative;top:2px;display:block;color:#666;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;font-size:14px;}
    .welcome-module {width:100%;height:210px;}
    .panel {background-color:#fff;border:1px solid transparent;border-radius:3px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}
    .panel-body {padding:10px}
    .panel-title {margin-top:0;margin-bottom:0;font-size:12px;color:inherit}
    .label {display:inline;padding:.2em .6em .3em;font-size:75%;font-weight:700;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25em;margin-top: .3em;}
    .main_btn > p {height:40px;}
    .layui-bg-number {background-color:#F8F8F8;}
</style>
<div class="layui-row layui-col-space15">
    <div class="layui-col-md8">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header"><i class="fa fa-warning icon"></i>数据统计</div>
                    <div class="layui-card-body">
                        <div class="welcome-module">
                            <div class="layui-row layui-col-space10">
                                <div class="layui-col-xs6">
                                    <div class="panel layui-bg-number">
                                        <div class="panel-body">
                                            <div class="panel-title">
                                                <span class="label pull-right layui-bg-blue">实时</span>
                                                <h5>文章统计</h5>
                                            </div>
                                            <div class="panel-content">
                                                <h1 class="no-margins"><?=$model['articleCount']?></h1>
                                                <small>当前文章总记录数</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-xs6">
                                    <div class="panel layui-bg-number">
                                        <div class="panel-body">
                                            <div class="panel-title">
                                                <span class="label pull-right layui-bg-cyan">实时</span>
                                                <h5>分类统计</h5>
                                            </div>
                                            <div class="panel-content">
                                                <h1 class="no-margins"><?=$model['typeCount']?></h1>
                                                <small>当前分类总记录数</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-xs6">
                                    <div class="panel layui-bg-number">
                                        <div class="panel-body">
                                            <div class="panel-title">
                                                <span class="label pull-right layui-bg-orange">实时</span>
                                                <h5>用户统计</h5>
                                            </div>
                                            <div class="panel-content">
                                                <h1 class="no-margins"><?=$model['userCount']?></h1>
                                                <small>当前后台用户总记录数</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-xs6">
                                    <div class="panel layui-bg-number">
                                        <div class="panel-body">
                                            <div class="panel-title">
                                                <span class="label pull-right layui-bg-green">实时</span>
                                                <h5>附件统计</h5>
                                            </div>
                                            <div class="panel-content">
                                                <h1 class="no-margins"><?=$model['attachmentCount']?></h1>
                                                <small>占用储存：<?=$model['attachmentSize']?>M</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header"><i class="fa fa-credit-card icon icon-blue"></i>快捷入口</div>
                    <div class="layui-card-body">
                        <div class="welcome-module">
                            <div class="layui-row layui-col-space10 layuimini-qiuck">
                                <div class="layui-col-xs3 layuimini-qiuck-module">
                                    <a href="javascript:;" layuimini-content-href="admin/config/site-info" data-title="站点设置" data-icon="fa fa-gears">
                                        <i class="fa fa-gears"></i>
                                        <cite>站点设置</cite>
                                    </a>
                                </div>
                                <div class="layui-col-xs3 layuimini-qiuck-module">
                                    <a href="javascript:;" layuimini-content-href="admin/config/banners" data-title="轮播管理" data-icon="fa fa-picture-o">
                                        <i class="fa fa-picture-o"></i>
                                        <cite>轮播管理</cite>
                                    </a>
                                </div>
                                <div class="layui-col-xs3 layuimini-qiuck-module">
                                    <a href="javascript:;" layuimini-content-href="admin/account" data-title="后台用户" data-icon="fa fa-user">
                                        <i class="fa fa-user"></i>
                                        <cite>后台用户</cite>
                                    </a>
                                </div>
                                <div class="layui-col-xs3 layuimini-qiuck-module">
                                    <a href="javascript:;" layuimini-content-href="admin/attachment" data-title="附件管理" data-icon="fa fa-hdd-o">
                                        <i class="fa fa-hdd-o"></i>
                                        <cite>附件管理</cite>
                                    </a>
                                </div>
                                <div class="layui-col-xs3 layuimini-qiuck-module">
                                    <a href="javascript:;" layuimini-content-href="admin/article/create" data-title="发布文章" data-icon="fa fa-window-maximize">
                                        <i class="layui-icon layui-icon-release"></i>
                                        <cite>发布文章</cite>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="layui-col-md4">
        <div class="layui-card">
            <div class="layui-card-header"><i class="fa fa-fire icon"></i>版本信息</div>
            <div class="layui-card-body layui-text">
                <table class="layui-table">
                    <colgroup>
                        <col width="100">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <td>网站名称</td>
                        <td>
                            <?=Yii::$app->debris->config('site_name')?>
                        </td>
                    </tr>
                    <tr>
                        <td>当前版本</td>
                        <td>v1.0</td>
                    </tr>
                    <tr>
                        <td>PHP</td>
                        <td>
                            当前PHP版本：<?= PHP_VERSION; ?><br>
                            项目开发环境PHP版本：7.4.2<br>
                        </td>
                    </tr>
                    <tr>
                        <td>MYSQL</td>
                        <td>
                            当前MYSQL版本：<?=Yii::$app->db->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);?><br>
                            项目开发环境MYSQL版本：8.0.15<br>
                        </td>
                    </tr>
                    <tr>
                        <td>当前环境</td>
                        <td>
                            <?=php_sapi_name()?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    <?php $this->beginBlock('js_end') ?>

    layui.config({
        base: "/resources/js/lay-module/",
        version: true
    }).extend({
        miniTab: "layuimini/miniTab", // layuimini tab扩展
    });

    layui.use(['miniTab'], function () {
        var $ = layui.jquery,
            miniTab = layui.miniTab;

        miniTab.listen();
    });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_LOAD); ?>
