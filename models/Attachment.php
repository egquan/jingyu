<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%attachment}}".
 *
 * @property int $id 附件id
 * @property string $drive 驱动
 * @property string $base_url 访问URL
 * @property string $path 路径
 * @property string $name 原始文件名
 * @property string $extension 文件后缀
 * @property int $size 文件大小
 * @property string $mime_type MimeType
 * @property string $ip 上传IP
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Attachment extends BaseModel
{

    const UPLOAD_TYPE_IMAGES = 'images';
    const UPLOAD_TYPE_FILES = 'files';
    const UPLOAD_TYPE_VIDEOS = 'videos';

    /**
     * @var array
     */
    public static $uploadTypeExplain = [
        self::UPLOAD_TYPE_IMAGES => '图片',
        self::UPLOAD_TYPE_FILES => '文件',
        self::UPLOAD_TYPE_VIDEOS => '视频',
    ];

    const DRIVE_LOCAL = 'local';
    const DRIVE_OSS = 'oss';
    const DRIVE_OSS_DIRECT_PASSING = 'oss-direct-passing';

    /**
     * @var array
     */
    public static $driveExplain = [
        self::DRIVE_LOCAL => '本地',
        self::DRIVE_OSS => 'OSS',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['drive', 'base_url', 'path', 'name', 'extension', 'size', 'mime_type', 'ip'], 'required'],
            [['size', 'created_at', 'updated_at'], 'integer'],
            [['drive', 'extension'], 'string', 'max' => 10],
            [['base_url', 'path', 'name'], 'string', 'max' => 256],
            [['mime_type'], 'string', 'max' => 24]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '附件id',
            'drive' => '驱动',
            'base_url' => '访问URL',
            'path' => '路径',
            'name' => '原始文件名',
            'extension' => '文件后缀',
            'size' => '文件大小',
            'mime_type' => 'MimeType',
            'md5' => 'md5校验码',
            'ip' => '上传IP',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 附件写入数据库
     * @param $data array 文件数组
     * @return bool
     */
    public static function create($data)
    {
        $model = new self();
        $model->attributes = $data;
        $model->save();
        return $model->id;
    }
}
