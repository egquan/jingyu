<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/15
 * Time: 20:28
 */

namespace app\modules\admin\controllers;

use Yii;
use app\common\helpers\UploadHelper;
use app\models\Attachment;
class FileController extends BaseController
{
    /**
     * 关闭Csrf验证
     *
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * 图片上传
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionImages()
    {
        try {
            $upload = new UploadHelper(Yii::$app->request->post(), Attachment::UPLOAD_TYPE_IMAGES);
            $upload->verifyFile();
            $upload->save();

            $data = $upload->getBaseInfo();
	        $data['src'] = $data['url'];
            return $this->api(0,'图片上传成功！',count($data),$data);
        } catch (\Exception $e) {
            return $this->api(422,$e->getMessage());
        }
    }

    /**
     * 文件上传
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionFiles()
    {
        try {
            $upload = new UploadHelper(Yii::$app->request->post(), Attachment::UPLOAD_TYPE_FILES);
            $upload->verifyFile();
            $upload->save();

            $data = $upload->getBaseInfo();
            return $this->api(0,'文件上传成功！',count($data),$data);
        } catch (\Exception $e) {
            return $this->api(422,$e->getMessage());
        }
    }

    /**
     * 视频上传
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionVideos()
    {
        try {
            $upload = new UploadHelper(Yii::$app->request->post(), Attachment::UPLOAD_TYPE_VIDEOS);
            $upload->verifyFile();
            $upload->save();

            $data = $upload->getBaseInfo();
	        $data['src'] = $data['url'];
            return $this->api(0,'视频上传成功！',count($data),$data);
        } catch (\Exception $e) {
            return $this->api(422,$e->getMessage());
        }
    }
}