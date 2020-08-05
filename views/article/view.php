<?php
/**
 * Created by egquan@163.com
 * Date: 2020/8/4
 * Time: 15:16
 * @var $this yii\web\View
 */
$this->title = $model->title.' - '.Yii::$app->debris->config('site_name') . Yii::$app->debris->config('subtitle_name');
$this->registerMetaTag(['name' => 'Keywords','content'=>$model->keyword]);
$this->registerMetaTag(['name' => 'Description','content'=>$model->description]);
$this->params['breadcrumbs'][] = ['label' =>$model->type->title,'url' =>['/type/index','id' => $model->type_id]];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="row article-view">
    <div class="page-header">
        <h1><?=$model->title?></h1>
    </div>
    <div class="col-md-12">
	    <?=$model->content?>
    </div>
</div>

