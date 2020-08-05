<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 12:02
 */

namespace app\modules\admin\controllers;

use app\models\Article;
use app\models\Type;
use app\models\User;
use app\models\Attachment;
class MainController extends BaseController
{
    /**
     * 管理后台首页
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

    public function actionInfoBoard()
    {
        $data = [];
        //文章数量
        $data['articleCount'] = Article::find()->count();
        //分类数量
        $data['typeCount'] = Type::find()->count();
        //后台用户数量
        $data['userCount'] = User::find()->count();
        //附件数量
        $data['attachmentCount'] = Attachment::find()->count();
        //附件总大小单位MB
        $data['attachmentSize'] = round(Attachment::find()->sum('size') / 1024 / 1024,2);

        return $this->render('info-board',['model'=>$data]);
    }
}