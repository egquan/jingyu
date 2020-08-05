<?php
/**
 * Created by egquan@163.com
 * Date: 2020/8/4
 * Time: 17:28
 */

use app\common\helpers\Url;
use yii\widgets\LinkPager;

$this->registerMetaTag(['name' => 'Keywords', 'content' => $type->keyword]);
$this->registerMetaTag(['name' => 'Description', 'content' => $type->description]);
$this->title = $type->title . ' - ' . Yii::$app->debris->config('site_name') . Yii::$app->debris->config('subtitle_name');

$this->params['breadcrumbs'][] = $type->title;
?>
<div class="index">
    <div class="body-content">
        <div class="row" style="margin-left: 0;">
			<?php if (count($model) > 0) { ?>
                <ul class="media-list" style="margin-top: 10px">
					<?php foreach ($model as $key => $value) { ?>
                        <li class="media" style="margin-top: 10px">
                            <div class="media-left">
                                <a href="<?= Url::to(['/article/view', 'id' => $value['id']]) ?>"><img src="<?= $value['cover'] ?>"></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="<?= Url::to(['/article/view', 'id' => $value['id']]) ?>"><?= $value['title'] ?></a></h4>
                                <p><?= $value['description'] ?></p>
                            </div>
                        </li>
					<?php } ?>
                </ul>
			<?php } else { ?>
                <h1 class="text-center">
                    <small><?= $type->title ?> 还没有发布内容~</small>
                </h1>
			<?php } ?>
        </div>
    </div>
	<?= LinkPager::widget([
		'options' => ['class' => 'pagination','style' => 'margin: 10px 0'],
		'pagination' => $pages,
		'maxButtonCount' => 8
	]) ?>
</div>
