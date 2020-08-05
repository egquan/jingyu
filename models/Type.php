<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%type}}".
 *
 * @property int $id 分类id
 * @property string $title 分类标题
 * @property string $keyword 分类关键词
 * @property string $description 分类描述
 * @property int $sort 分类排序
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Type extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'keyword', 'description'], 'required'],
            [['sort', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 8],
            [['keyword'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '分类id',
            'title' => '分类标题',
            'keyword' => '分类关键词',
            'description' => '分类描述',
            'sort' => '分类排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
