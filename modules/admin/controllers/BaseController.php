<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 11:46
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class BaseController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // 登录
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 错误处理
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
     * 用户id
     * @var integer
     */
    public $user_id;

    /*
     * 初始化
     */
    public function init()
    {
        parent::init();
        //赋值用户ID
        if (!Yii::$app->user->isGuest) {
            $this->user_id = Yii::$app->user->getId();
        }
    }

    /**
     * @param $code integer 状态码
     * @param string $msg 信息
     * @param int $count 数量
     * @param array $data 数据
     * @return false|string
     */
    public function api($code, $msg = '', $count = 0, $data = [])
    {
        $response = [
            'code' => $code,
            'msg' => $msg,
            'count' => $count,
            'data' => $data
        ];
        return json_encode($response, 256);
    }


    /**
     * 解析错误1
     * @param Model $model
     * @return string
     */
    protected function getError(Model $model)
    {
        return $this->analyErr($model->getFirstErrors());
    }

    /**
     * 解析错误2
     * @param $fistErrors
     * @return string
     */

    private function analyErr($firstErrors)
    {
        if (!is_array($firstErrors) || empty($firstErrors)) {
            return false;
        }

        $errors = array_values($firstErrors)[0];
        return $errors ?? '未捕获到错误信息';
    }

}