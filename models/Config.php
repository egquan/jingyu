<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property int $id 配置id
 * @property string $title 配置标题
 * @property string $description 配置描述
 * @property int $type_id 配置分类Id
 * @property string $key 配置key
 * @property string $value 配置value
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Config extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'type_id', 'key', 'value'], 'required'],
            [['type_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 12],
            [['description'], 'string', 'max' => 128],
            [['key'], 'string', 'max' => 32],
            [['value'], 'string', 'max' => 1024],
            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '配置id',
            'title' => '配置标题',
            'description' => '配置描述',
            'type_id' => '配置分类Id',
            'key' => '配置key',
            'value' => '配置value',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
