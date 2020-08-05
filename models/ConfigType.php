<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%config_type}}".
 *
 * @property int $id 配置分类id
 * @property string $title 配置分类标题
 * @property int $sort 配置分类排序
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class ConfigType extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%config_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['sort', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '配置分类id',
            'title' => '配置分类标题',
            'sort' => '配置分类排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
