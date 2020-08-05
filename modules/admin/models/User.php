<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/20
 * Time: 20:23
 */
namespace app\modules\admin\models;

class User extends \app\models\User
{
    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'email','nickname'], 'required'],
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
}