<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 18:29
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\form\LoginForm;
class UserController extends Controller
{

    /**
     * 图形验证码
     * @return array
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? '123456' : null,
                'maxLength' => 6, // 最大显示个数
                'minLength' => 6, // 最少显示个数
                'padding' => 2, // 间距
                'height' => 50, // 高度
                'width' => 130, // 宽度
                'offset' => 2, // 设置字符偏移量
                'backColor' => 0xffffff, // 背景颜色
                'foreColor' => 0x62a8ea, // 字体颜色
            ]
        ];
    }

    /**
     * 后台登录
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest){
            return $this->redirect(['/admin']);
        }

        $model = new LoginForm();
        $model->loginCaptchaRequired();
        if ($model->load(Yii::$app->request->post()) && $model->login()){
            return $this->redirect(['/admin']);
        }
        return $this->renderPartial('login',[
            'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->actionLogin();
    }
}