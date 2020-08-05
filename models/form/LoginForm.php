<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 18:42
 */

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\captcha\CaptchaValidator;
class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $rememberMe = true;

    private $loginErrorCount = 3;
    private $_user = false;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['verifyCode','captcha','captchaAction' => '/admin/user/captcha', 'on' => 'captchaRequired'],
        ];
    }

    /**
     * 数据库字段注释
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户账号或邮箱',
            'password' => '密码',
            'rememberMe' => '记住密码',
            'verifyCode' => '验证码',

        ];
    }

    /**
     * 密码验证
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '账号或密码错误.');
            }
        }
    }

    /**
     * 登录
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }

        //Session统计失败次数
        $counter = Yii::$app->session->get('loginErrors') + 1;
        Yii::$app->session->set('loginErrors', $counter);

        return false;
    }

    /**
     * 获取用户数据
     * @return User|bool|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * 验证码显示判断
     */
    public function loginCaptchaRequired()
    {
        if (Yii::$app->session->get('loginErrors') >= ($this->loginErrorCount -1)) {
            $this->setScenario("captchaRequired");
        }
    }
}
