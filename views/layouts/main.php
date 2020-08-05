<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\common\helpers\Html;
use app\common\helpers\Url;
use app\widgets\Alert;
use app\assets\AppAsset;
use app\models\Type;

AppAsset::register($this);

$navRes = Type::find()->select(['id', 'title'])->cache(60)->orderBy('sort')->asArray()->all();
$navArray = null;
foreach ($navRes as $key => $value) {
	$navArray[] = ['label' => $value['title'], 'url' => ['/type/index', 'id' => $value['id']]];
}
$banner = unserialize(Yii::$app->debris->config('site_banners'));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<style>
    .navcss{
        top: 51px;
    }
    .navbar-down-app{
        background-color: #1468a8;
        border-color: #12467f;
    }
    .navbar-app-brand {
        float: left;
        height: 50px;
        font-size: 18px;
        line-height: 20px;
    }
    .navbar-app-brand>img{
        display:inline;
        height: 50px;
    }
    .navbar-app-text{
        display:inline;
        font-size: 35px;
        color: #FFFFFF;
    }
    .navbar-app-bnt {
        display:inline;
        float: right!important;
        margin-right: 1px;
    }
</style>
<div class="wrap">
    <nav id="down_app" class="navbar navbar-down-app navbar-fixed-top">
        <div class="container">
            <div class="navbar-header" style="float:left;display:inline">
                <a class="navbar-app-brand" href="#">
                    <img alt="Brand" src="/images/logo.png">
                </a>
                <div class="navbar-app-text"><?=Yii::$app->debris->config('navbar_top_title')?></div>
            </div>
            <a href="<?=Yii::$app->debris->config('navbar_down_url')?>" target="_blank"><button type="button" class="btn btn-default navbar-btn btn-success navbar-app-bnt">下载 App</button></a>
        </div>
    </nav>
	<?php
	NavBar::begin([
		'brandLabel' => Yii::$app->debris->config('site_name'),
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar-inverse navbar-static-top navcss',
		],
	]);
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-left'],
		'items' => $navArray
	]);
	NavBar::end();
	?>
	<?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index' && (Yii::$app->request->get('page') === null || Yii::$app->request->get('page') == 1)) { ?>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                <li data-target="#carousel-example-generic" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
				<?php foreach ($banner as $key => $value) { ?>
                    <div class="item <?= $key == 0 ? 'active' : '' ?>">
                        <a href="<?=$value['link']?>" target="_blank"><img src="<?= $value['images'] ?>" alt="<?= Yii::$app->debris->config('site_name') . Yii::$app->debris->config('subtitle_name') ?>"></a>
                        <div class="carousel-caption"></div>
                    </div>
				<?php } ?>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
	<?php } ?>
    <div class="container"<?= (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index' && (Yii::$app->request->get('page') === null || Yii::$app->request->get('page') == 1)) ? ' style="padding: 15px 15px 20px;"' : '' ?>>
		<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
		<?= Alert::widget() ?>
		<?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <a href="<?= Url::home() ?>"><?= Yii::$app->debris->config('site_name') ?></a>&nbsp;&nbsp;<?= date('Y') ?>
        </p>
        <p class="pull-right"><?= Yii::$app->debris->config('site_description') ?>&nbsp;&nbsp;&nbsp;&nbsp;<?= Yii::$app->debris->config('website_statistics_code') ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
