<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/18
 * Time: 21:42
 */

namespace app\modules\admin\controllers;

use Yii;
use app\models\User;
use yii\web\NotFoundHttpException;

class AccountController extends BaseController
{

    /**
     * 用户管理列表
     * @param int $page 页数
     * @param int $limit 每页数量
     * @param null $searchParams 搜索数据
     * @return false|string
     */
    public function actionIndex($page = 1, $limit = 15,$searchParams = null)
    {
        if (Yii::$app->request->isAjax) {

            //搜索默认值
            $search = [
                'username' => '',
                'nickname' => '',
                'email' => ''
            ];

            if($searchParams != ''){
                $searchParams = json_decode($searchParams,true);
                $searchParams = array_merge($search,$searchParams);
            }else{
                $searchParams = $search;
            }

            $model = User::find()
                ->andFilterWhere(['like','username',$searchParams['username']])
                ->andFilterWhere(['like','nickname',$searchParams['nickname']])
                ->andFilterWhere(['like','email',$searchParams['email']]);

            $count = $model->count();
            $model = $model
	            ->orderBy('id desc')
                ->offset($page - 1)
                ->limit($limit)
	            ->asArray()
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
     * 创建后台用户
     * @return false|string
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new User();
        $model->generateAuthKey();
        if ($model->load(Yii::$app->request->post())){
            $model->setPassword($model->password_hash);
            if ($model->save()){
                return $this->api(200,'后台用户添加成功！');
            }
            return $this->api(422,$this->getError($model));
        }
        return $this->render('create',['model' => $model]);
    }


    /**
     * 更新用户
     * @param $id integer UserID
     * @return false|string
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = \app\modules\admin\models\User::findOne($id);
        if (empty($model)){
            throw new NotFoundHttpException('请求用户数据不存在！');
        }


        if (($data = Yii::$app->request->post())){

            if (!empty($data['User']['password_hash'])){
                $model->load($data);
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            }else{
                unset($data['User']['password_hash']);
                $model->load($data);
            }

            if ($model->save()){
                return $this->api(200,'用户更新成功！');
            }
            return $this->api(422,$this->getError($model));
        }
        $model->password_hash = '';
        return $this->render('update',['model' => $model]);
    }

    /**
     * 删除用户
     * @param $id integer UserId
     * @return false|string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()){
            return $this->api(200,'用户删除成功！');
        }
        return $this->api(422,'未知错误，删除失败！');
    }

    /**
     * 获取用户数据对象
     * @param $id integer 用户id
     * @return User|array|\yii\db\ActiveRecord|null
     * @throws NotFoundHttpException
     */
    private function findModel($id)
    {
        if (empty($id) || empty(($model = User::find()->where(['id' => $id])->one()))) {

            throw new NotFoundHttpException('请求用户数据不存在！');
        }

        return $model;
    }
}