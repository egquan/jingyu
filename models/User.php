<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/11
 * Time: 22:37
 */

namespace app\models;


use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id 用户id
 * @property string $username 用户账号
 * @property string $auth_key 用户记住密码KEY
 * @property string $password_hash HASH密码
 * @property string $email 用户邮箱
 * @property string $nickname 用户昵称
 * @property string $head_portrait 用户头像
 * @property int $status 用户状态 0禁用 1正常
 * @property int $created_at 账号创建时间
 * @property int $updated_at 最后更新时间
 */
class User extends BaseModel implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static $statusList = [
        self::STATUS_INACTIVE => '封禁',
        self::STATUS_ACTIVE => '正常',
    ];

    /**
     * 数据表名称
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email','nickname'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 255],
            ['email', 'string', 'max' => 64],
            ['nickname','string','max' => 10],
            ['head_portrait','string','max' => 128],
            ['username', 'unique'],
            ['email', 'unique'],
        ];
    }

    /**
     * 数据库字段注释
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户id',
            'username' => '用户账号',
            'auth_key' => '用户记住密码KEY',
            'password_hash' => '用户密码',
            'nickname' => '用户昵称',
            'email' => '用户邮箱',
            'status' => '用户状态',
            'created_at' => '账号创建时间',
            'updated_at' => '最后更新时间',
        ];
    }

    /**
     * 根据用户Id获取用户资料
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * 根据用户账号查找用户
     * @param $username string
     * @return User|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * 根据用户Token获取用户 暂时未使用
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface|null
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * 获取用户Id
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * 获取用户Auth_Key
     * @return mixed|string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * 验证用户Auth_Key
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 设置密码
     * @param $password string 密码
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 密码验证
     * @param $password string 密码
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * 生产Auth_Key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}