<?php
/* @var $this yii\web\View */
use app\common\helpers\Url;
use yii\widgets\LinkPager;

$this->registerMetaTag(['name' => 'Keywords','content'=>Yii::$app->debris->config('site_keyword')]);
$this->registerMetaTag(['name' => 'Description','content'=>Yii::$app->debris->config('site_description')]);
$this->title = Yii::$app->debris->config('site_name') . Yii::$app->debris->config('subtitle_name');
?>
 <div class="index">
    <div class="body-content">
        <div class="row" style="margin-left: 0;">
                <ul class="media-list">
		            <?php foreach ($model as $key => $value) { ?>
                        <li class="media" style="margin-top: 10px">
                            <div class="media-left">
                                <a href="<?=Url::to(['/article/view','id' =>$value['id']])?>">
                                    <img src="<?= $value['cover'] ?>">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="<?=Url::to(['/article/view','id' =>$value['id']])?>"><?= $value['title'] ?></a></h4>
                                <p><?= $value['description'] ?></p>
                            </div>
                        </li>
		            <?php } ?>
                </ul>
        </div>
	    <?= LinkPager::widget([
		    'options' => ['class' => 'pagination','style' => 'margin: 10px 0'],
		    'pagination' => $pages,
		    'maxButtonCount' => 8
	    ]) ?>
    </div>
</div>
