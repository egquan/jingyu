<?php
/**
 * Created by egquan@163.com
 * Date: 2020/8/4
 * Time: 17:08
 */

namespace app\controllers;

use yii\data\Pagination;
use app\models\Article;
use app\models\Type;

class TypeController extends BaseController
{
	public function actionIndex($id)
	{
		$type =  Type::find()->cache($this->CacheTime)->where(['id' => $id])->one();

		$data = Article::find()->alias('a')
			->select(['a.*','t.title as type_title'])
			->where(['a.type_id' => $id,'a.status' => 1])
			->cache($this->CacheTime);

		$pages = new Pagination(['totalCount' => $data->count(),'pageSize' => $this->pageSize,'defaultPageSize' =>  $this->pageSize]);
		$model = $data
			->leftJoin('jy_type t','t.id = a.type_id')
			->orderBy('a.id desc')
			->offset($pages->offset)
			->limit($pages->limit)
			->asArray()
			->all();

		return $this->render('index', [
			'model' => $model,
			'pages' => $pages,
			'type' => $type
		]);
	}
}