<?php
/**
 * Created by egquan@163.com
 * Date: 2020/8/3
 * Time: 16:35
 */

namespace app\modules\admin\controllers;

use Yii;
use app\models\Attachment;
use yii\web\NotFoundHttpException;
class AttachmentController extends BaseController
{

	/**
	 * 附件管理首页
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
				'base_url' => ''
			];

			if($searchParams != ''){
				$searchParams = json_decode($searchParams,true);
				$searchParams = array_merge($search,$searchParams);
			}else{
				$searchParams = $search;
			}

			$model = Attachment::find()
				->andFilterWhere(['like','base_url',$searchParams['base_url']]);

			$count = $model->count();
			$model = $model->asArray()
				->orderBy('id desc')
				->offset($page - 1)
				->limit($limit)
				->all();

			foreach ($model as $key => $value){
				$model[$key]['created_at'] = date('Y-m-d H:i',$value['created_at']);
				$model[$key]['updated_at'] = date('Y-m-d H:i',$value['updated_at']);
				$model[$key]['size'] = round($model[$key]['size'] / 1024 /1024,2) .' M';
			}
			return $this->api(0, '', $count, $model);
		}

		return $this->render('index');
	}

    /**
     * 查看附件
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
     * 删除附件
     * @param $id
     * @return false|string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $drive = $model->drive;
        //判断文件存在删除文件
        if (Yii::$app->uploadDrive->$drive()->entity()->has($model->path)){
            Yii::$app->uploadDrive->$drive()->entity()->delete($model->path);
        };
        //删除数据
        if ($model->delete()){
            return $this->api(200,'文章删除成功！');
        }
        return $this->api(422,'未知错误，文章删除失败！');
    }

	/**
	 * 编辑器删除附件
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 */
    public function actionEditDel()
    {
    	$data = Yii::$app->request->post();
    	if (count($data) > 0){
    		foreach ($data as $value){
    			$model = Attachment::find()->where(['base_url' => $value])->one();
    			if (!empty($model)){
				    $drive = $model->drive;
				    if (Yii::$app->uploadDrive->$drive()->entity()->has($model->path)){
					    Yii::$app->uploadDrive->$drive()->entity()->delete($model->path);
				    };
				    $model->delete();
			    }
		    }
	    }
    }
	/**
	 * 获取附件数据对象
	 * @param $id
	 * @return Attachment|array|\yii\db\ActiveRecord|null
	 * @throws NotFoundHttpException
	 */
	private function findModel($id)
	{
		if (empty($id) || empty(($model = Attachment::find()->where(['id' => $id])->one()))) {

			throw new NotFoundHttpException('请求数据不存在！');
		}
		return $model;
	}
}