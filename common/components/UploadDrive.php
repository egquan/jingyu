<?php

namespace app\common\components;

use Yii;
use yii\helpers\ArrayHelper;
use app\common\components\uploaddrive\Local;
use app\common\components\uploaddrive\OSS;

/**
 * Class UploadDrive
 * @package app\common\components
 */
class UploadDrive
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * UploadDrive constructor.
     */
    public function __construct()
    {
        $this->config = Yii::$app->debris->configAll();
    }

    /**
     * @param array $config
     * @return Local
     */
    public function local($config = [])
    {
        return new Local(ArrayHelper::merge($this->config, $config));
    }

    /**
     * @param array $config
     * @return OSS
     */
    public function oss($config = [])
    {
        return new OSS(ArrayHelper::merge($this->config, $config));
    }


}