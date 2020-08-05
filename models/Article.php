<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property int $id 文章id
 * @property string $title 文章标题
 * @property string $keyword 文章关键词
 * @property string $description 文章描述
 * @property int $type_id 文章分类Id
 * @property int $status 文章状态 0删除 1正常
 * @property int $user_id 发布用户Id
 * @property string $cover 文章封面图
 * @property string $content 文章内容
 * @property int $created_at 发布时间
 * @property int $updated_at 更新时间
 */
class Article extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'keyword', 'description', 'type_id', 'user_id', 'cover', 'content'], 'required'],
            [['type_id', 'status', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title', 'keyword'], 'string', 'max' => 64],
            [['description', 'cover'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '文章id',
            'title' => '文章标题',
            'keyword' => '文章关键词',
            'description' => '文章描述',
            'type_id' => '文章分类Id',
            'status' => '文章状态 0删除 1正常',
            'user_id' => '发布用户Id',
            'cover' => '文章封面图',
            'content' => '文章内容',
            'created_at' => '发布时间',
            'updated_at' => '更新时间',
        ];
    }

	/**
	 * 关联类型表
	 * @return \yii\db\ActiveQuery
	 */
    public function getType()
    {
    	return $this->hasOne(Type::class,['id' => 'type_id']);
    }
}
