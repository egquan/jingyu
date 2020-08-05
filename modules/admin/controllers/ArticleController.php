<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/30
 * Time: 23:03
 */

namespace app\modules\admin\controllers;

use Yii;
use app\models\Article;
use app\models\Type;
use yii\web\NotFoundHttpException;

class ArticleController extends BaseController
{
    /**
     * 文章管理首页
     * @param int $page
     * @param int $limit
     * @param null $searchParams
     * @return false|string
     */
    public function actionIndex($page = 1, $limit = 15,$searchParams = null)
    {
        if (Yii::$app->request->isAjax) {

            //搜索默认值
            $search = [
                'title' => ''
            ];

            if($searchParams != ''){
                $searchParams = json_decode($searchParams,true);
                $searchParams = array_merge($search,$searchParams);
            }else{
                $searchParams = $search;
            }

            $model = Article::find()->alias('a')
                ->andFilterWhere(['like','a.title',$searchParams['title']]);

            $count = $model->count();
            $model = $model->asArray()
	            ->select(['a.*','t.title as type_title'])
	            ->leftJoin('jy_type t','t.id = a.type_id')
	            ->orderBy('a.id desc')
                ->offset($page - 1)
                ->limit($limit)
                ->all();

            foreach ($model as $key => $value){
                $model[$key]['created_at'] = date('Y-m-d H:i',$value['created_at']);
                $model[$key]['updated_at'] = date('Y-m-d H:i',$value['updated_at']);
            }
            return $this->api(0, '', $count, $model);
        }

        return $this->render('index');
    }

	/**
	 * 创建文章
	 * @return false|string
	 */
    public function actionCreate()
    {
        $model = new  Article();
        $type = Type::find()->asArray()->all();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        	$model->user_id = $this->user_id;
            if ($model->save()) {
                return $this->api(200, '文章发布成功！');
            }
            return $this->api(422, $this->getError($model));
        }

        return $this->render('create', ['model' => $model,'type' => $type]);
    }

	/**
	 * 更新文章
	 * @param $id
	 * @return false|string
	 * @throws NotFoundHttpException
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$type = Type::find()->asArray()->all();

		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

			if ($model->save()){
				return $this->api(200, '文章更新成功！');
			}else{
				return $this->api(422,$this->getError($model));
			}

		}
		return $this->render('update', ['model' => $model,'type' => $type]);
	}

	/**
	 * 删除文章
	 * @param $id
	 * @return false|string
	 * @throws NotFoundHttpException
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		if ($model->delete()){
			return $this->api(200,'文章删除成功！');
		}
		return $this->api(422,'未知错误，文章删除失败！');
	}
	/**
	 * 获取文章数据对象
	 * @param $id
	 * @return Article|array|\yii\db\ActiveRecord|null
	 * @throws NotFoundHttpException
	 */
	private function findModel($id)
	{
		if (empty($id) || empty(($model = Article::find()->where(['id' => $id])->one()))) {

			throw new NotFoundHttpException('请求数据不存在！');
		}
		return $model;
	}
}