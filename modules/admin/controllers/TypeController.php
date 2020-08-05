<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/20
 * Time: 22:04
 */

namespace app\modules\admin\controllers;

use Yii;
use app\models\Type;
use yii\web\NotFoundHttpException;

class TypeController extends BaseController
{

    /**
     * 文章分类列表 无分页
     * @param null $searchParams
     * @return false|string
     */
    public function actionIndex($searchParams = null)
    {
        if (Yii::$app->request->isAjax) {

            $model = Type::find();
            $searchParams = json_decode($searchParams,true);
            $title = !empty($searchParams) ? $searchParams['title']:'';
            $count = $model
                ->andFilterWhere(['like','title',$title])
                ->count();
            $model = $model->asArray()
                ->orderBy([
                    'sort' => SORT_ASC,
                    'id' => SORT_DESC
                ])
                ->all();

            foreach ($model as $key => $value) {
                $model[$key]['created_at'] = date('Y-m-d H:i', $value['created_at']);
                $model[$key]['updated_at'] = date('Y-m-d H:i', $value['updated_at']);
            }
            return $this->api(0, '', $count, $model);
        }

        return $this->render('index');
    }

    /**
     * 创建分类
     * @return false|string
     */
    public function actionCreate()
    {
        $model = new  Type();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->save()) {
                return $this->api(200, '分类创建成功！');
            }
            return $this->api(422, $this->getError($model));
        }

        return $this->render('create', ['model' => $model]);
    }


    /**
     * 更新分类
     * @param $id integer
     * @return false|string
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            if ($model->save()){
                return $this->api(200, '分类更新成功！');
            }else{
                return $this->api(422,$this->getError($model));
            }

        }
        return $this->render('update', ['model' => $model]);
    }

    /**
     * 删除分类
     * @param $id integer
     * @return false|string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()){
            return $this->api(200,'分类删除成功！');
        }
        return $this->api(422,'未知错误，删除失败！');
    }

    /**
     * 获取分类数据对象
     * @param $id integer 用户id
     * @return Type|array|\yii\db\ActiveRecord|null
     * @throws NotFoundHttpException
     */
    private function findModel($id)
    {
        if (empty($id) || empty(($model = Type::find()->where(['id' => $id])->one()))) {

            throw new NotFoundHttpException('请求分类数据不存在！');
        }
        return $model;
    }
}