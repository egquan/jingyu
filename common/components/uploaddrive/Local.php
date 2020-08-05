<?php

namespace app\common\components\uploaddrive;

use Yii;
use app\common\helpers\RegularHelper;

/**
 * Class Local
 * @package app\common\components\uploaddrive
 */
class Local extends DriveInterface
{
    /**
     * @param $baseInfo
     * @param $fullPath
     * @return mixed
     */
    protected function baseUrl($baseInfo, $fullPath)
    {
        $baseInfo['url'] = Yii::getAlias('@attachmentUrl') . '/' . $baseInfo['url'];
        if ($fullPath == true && !RegularHelper::verify('url', $baseInfo['url'])) {
            $baseInfo['url'] = Yii::$app->request->hostInfo . $baseInfo['url'];
        }

        return $baseInfo;
    }

    /**
     * 初始化
     */
    protected function create()
    {
        $this->adapter = new \League\Flysystem\Adapter\Local(Yii::getAlias('@attachment'));
    }
}