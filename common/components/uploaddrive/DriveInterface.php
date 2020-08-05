<?php

namespace app\common\components\uploaddrive;

use app\common\helpers\RegularHelper;
use app\models\Attachment;
use League\Flysystem\Filesystem;
use Xxtime\Flysystem\Aliyun\OssAdapter;

/**
 * Interface DriveInterface
 * @package common\components\uploaddrive
 */
abstract class DriveInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var OssAdapter
     */
    protected $adapter;

    /**
     * 上传组件
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * DriveInterface constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->create();
    }

    /**
     * @return Filesystem
     */
    public function entity(): Filesystem
    {
        if (!$this->filesystem instanceof Filesystem) {
            $this->filesystem = new Filesystem($this->adapter);
        }

        return $this->filesystem;
    }

    /**
     * @param $baseInfo
     * @param $fullPath
     * @return mixed
     */
    public function getUrl($baseInfo, $fullPath)
    {
        $baseInfo = $this->baseUrl($baseInfo, $fullPath);

        if ($baseInfo['type'] != Attachment::DRIVE_LOCAL && !RegularHelper::verify('url', $baseInfo['url'])) {
            $baseInfo['url'] = 'http://' . $baseInfo['url'];
        }

        return $baseInfo;
    }

    /**
     * 返回路由
     *
     * @param $baseInfo
     * @param $fullPath
     * @return $baseInfo
     */
    abstract protected function baseUrl($baseInfo, $fullPath);

    /**
     * @return mixed
     */
    abstract protected function create();
}