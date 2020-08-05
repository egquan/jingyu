<?php

namespace app\controllers;

use yii\data\Pagination;
use app\models\Article;

class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

	/**
	 * 网站首页
	 * @return string
	 */
    public function actionIndex()
    {
        $data = Article::find()->where(['status' => 1])->cache($this->CacheTime);

	    $pages = new Pagination(['totalCount' => $data->count(),'pageSize' => $this->pageSize,'defaultPageSize' =>  $this->pageSize]);
	    $model = $data->orderBy('id desc')
		    ->offset($pages->offset)
		    ->limit($pages->limit)
		    ->asArray()
		    ->all();

        return $this->render('index', [
        	'model' => $model,
	        'pages' => $pages,
	        ]);
    }
}
