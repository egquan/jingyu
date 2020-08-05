<?php
/**
 * Created by egquan@163.com
 * Date: 2020/8/4
 * Time: 15:12
 */

namespace app\controllers;

use yii\web\NotFoundHttpException;
use app\models\Article;
class ArticleController extends BaseController
{
	/**
	 * 查看文章
	 * @param $id
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);
		return $this->render('view',['model' => $model]);
	}

	/**
	 * 获取文章数据对象
	 * @param $id integer
	 * @return Article|array|\yii\db\ActiveRecord|null
	 * @throws NotFoundHttpException
	 */
	private function findModel($id)
	{
		if (empty($id) || empty(($model = Article::find()->where(['id' => $id])->one()))) {

			throw new NotFoundHttpException('请求文章不存在！');
		}
		return $model;
	}
}