<?php

namespace app\common\helpers;

use Yii;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\models\Attachment;
use app\common\components\uploaddrive\DriveInterface;

/**
 * 上传辅助类
 *
 * Class UploadHelper
 * @package app\common\helpers
 */
class UploadHelper
{
    /**
     * 切片合并缓存前缀
     */
    const PREFIX_MERGE_CACHE = 'upload-file-guid:';

    /**
     * 上传配置
     *
     * @var array
     */
    public $config = [];

    /**
     * 上传路径
     *
     * @var array
     */
    public $paths = [];

    /**
     * 默认取 $_FILE['file']
     *
     * @var string
     */
    public $uploadFileName = 'file';

    /**
     * 上传驱动
     *
     * @var
     */
    protected $drive = 'local';

    /**
     * 拿取需要的数据
     *
     * @var array
     */
    protected $filter = [
        'drive',
        'guid',
        'image',
        'md5',
        'poster'
    ];

    /**
     * 上传文件基础信息
     *
     * @var array
     */
    protected $baseInfo = [
        'name' => '',
        'width' => '',
        'height' => '',
        'size' => 0,
        'extension' => 'jpg',
        'url' => '',
        'guid' => '',
        'type' => 'image/jpeg',
    ];

    /**
     * @var DriveInterface
     */
    protected $uploadDrive;

    /**
     * @var \League\Flysystem\Filesystem
     */
    protected $filesystem;

    /**
     * UploadHelper constructor.
     * @param array $config
     * @param string $type 文件类型
     * @param bool $superaddition 追加写入
     * @throws \Exception
     */
    public function __construct(array $config, $type, $superaddition = false)
    {
        // 过滤数据
        $this->filter($config, $type);
        // 设置文件类型
        $this->type = $type;
        // 初始化上传地址
        $this->initPaths();
        $this->setDrive(Yii::$app->debris->config('update_drive'));
        $drive = $this->drive;
        $this->uploadDrive = Yii::$app->uploadDrive->$drive([
            'superaddition' => $superaddition
        ]);
        $this->filesystem = $this->uploadDrive->entity();
    }

    /**
     * 验证文件
     *
     * @throws NotFoundHttpException
     */
    public function verifyFile()
    {
        $file = UploadedFile::getInstanceByName($this->uploadFileName);

        if (!$file) {
            throw new NotFoundHttpException('找不到上传文件');
        }

        if ($file->getHasError()) {
            throw new NotFoundHttpException('上传失败，请检查文件');
        }

        $this->baseInfo['extension'] = $file->getExtension();
        $this->baseInfo['size'] = $file->size;

        empty($this->baseInfo['name']) && $this->baseInfo['name'] = $file->getBaseName();
        $this->baseInfo['url'] = $this->paths['relativePath'] . $this->baseInfo['name'] . '.' . $file->getExtension();

        unset($file);
        $this->verify();
    }

    /**
     * 验证Url
     *
     * @param $url
     * @return bool
     * @throws NotFoundHttpException
     */
    public function verifyUrl($url)
    {
        $imgUrl = str_replace("&amp;", "&", htmlspecialchars($url));
        // http开头验证
        if (strpos($imgUrl, "http") !== 0) {
            throw new NotFoundHttpException('不是一个http地址');
        }

        preg_match('/(^https?:\/\/[^:\/]+)/', $imgUrl, $matches);
        $host_with_protocol = count($matches) > 1 ? $matches[1] : '';

        // 判断是否是合法 url
        if (!filter_var($host_with_protocol, FILTER_VALIDATE_URL)) {
            throw new NotFoundHttpException('Url不合法');
        }

        preg_match('/^https?:\/\/(.+)/', $host_with_protocol, $matches);
        $host_without_protocol = count($matches) > 1 ? $matches[1] : '';

        // 此时提取出来的可能是 IP 也有可能是域名，先获取 IP
        $ip = gethostbyname($host_without_protocol);

        // 获取请求头并检测死链
        $heads = get_headers($imgUrl, 1);
        if (!(stristr($heads[0], "200") && stristr($heads[0], "OK"))) {
            throw new NotFoundHttpException('文件获取失败');
        }

        // Content-Type验证)
        if (!isset($heads['Content-Type']) || !stristr($heads['Content-Type'], "image")) {
            throw new NotFoundHttpException('格式验证失败');
        }

        $extend = StringHelper::clipping($imgUrl, '.', 1);

        //打开输出缓冲区并获取远程图片
        ob_start();
        $context = stream_context_create(
            [
                'http' => [
                    'follow_location' => false // don't follow redirects
                ]
            ]
        );
        readfile($imgUrl, false, $context);
        $img = ob_get_contents();
        ob_end_clean();
        preg_match("/[\/]([^\/]*)[\.]?[^\.\/]*$/", $imgUrl, $m);

        // $name = $m ? $m[1] : "",
        $this->baseInfo['extension'] = $extend;
        $this->baseInfo['size'] = strlen($img);
        $this->baseInfo['url'] = $this->paths['relativePath'] . $this->baseInfo['name'] . '.' . $extend;

        $this->verify();

        return $img;
    }

    /**
     * 验证base64格式的内容
     *
     * @param $data
     * @param $extend
     * @throws NotFoundHttpException
     */
    public function verifyBase64($data, $extend)
    {
        $this->baseInfo['extension'] = $extend;
        $this->baseInfo['size'] = strlen($data);
        $this->baseInfo['url'] = $this->paths['relativePath'] . $this->baseInfo['name'] . '.' . $extend;

        $this->verify();

        unset($data, $extend);
    }

    /**
     * 验证文件大小及类型
     *
     * @throws NotFoundHttpException
     */
    protected function verify()
    {
        if ($this->baseInfo['size'] > $this->config['maxSize']) {
            throw new NotFoundHttpException('文件大小超出网站限制');
        }

        if (!empty($this->config['extensions']) && !in_array($this->baseInfo['extension'],
                $this->config['extensions'])) {
            throw new NotFoundHttpException('文件类型不允许');
        }

        // 存储本地进行安全校验
        if ($this->drive == Attachment::DRIVE_LOCAL) {
            if ($this->type == Attachment::UPLOAD_TYPE_FILES && in_array($this->baseInfo['extension'],
                    $this->config['blacklist'])) {
                throw new NotFoundHttpException('上传的文件类型不允许');
            }
        }
    }

    /**
     * 写入
     *
     * @param bool $data
     * @throws NotFoundHttpException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function save($data = false)
    {
        // 判断如果文件存在就重命名文件名
        if ($this->filesystem->has($this->baseInfo['url'])) {
            $this->baseInfo['name'] = $this->baseInfo['name'] . '_' . StringHelper::randomNum();
            $this->baseInfo['url'] = $this->paths['relativePath'] . $this->baseInfo['name'] . '.' . $this->baseInfo['extension'];
        }

        // 判断是否直接写入
        if (false === $data) {
            $file = UploadedFile::getInstanceByName($this->uploadFileName);
            if (!$file->getHasError()) {
                $stream = fopen($file->tempName, 'r+');
                $result = $this->filesystem->writeStream($this->baseInfo['url'], $stream);


                if (!$result) {
                    throw new NotFoundHttpException('文件写入失败');
                }

                if (is_resource($stream)) {
                    fclose($stream);
                }
            } else {
                throw new NotFoundHttpException('上传失败，可能文件太大了');
            }
        } else {
            $result = $this->filesystem->write($this->baseInfo['url'], $data);

            if (!$result) {
                throw new NotFoundHttpException('文件写入失败');
            }
        }

        return;
    }


    /**
     * 获取生成路径信息
     *
     * @return array
     */
    protected function initPaths()
    {
        if (!empty($this->paths)) {
            return $this->paths;
        }

        $config = $this->config;
        // 保留原名称
        $config['originalName'] == false && $this->baseInfo['name'] = $config['prefix'] . StringHelper::randomNum(time());

        // 文件路径
        $filePath = $config['path'] . date($config['subName'], time()) . "/";

        empty($config['guid']) && $config['guid'] = StringHelper::randomNum();
        $tmpPath = 'tmp/' . date($config['subName'], time()) . "/" . $config['guid'] . '/';
        $this->paths = [
            'relativePath' => $filePath, // 相对路径
            'tmpRelativePath' => $tmpPath, // 临时相对路径
        ];

        return $this->paths;
    }

    /**
     * 过滤数据
     *
     * @param $config
     */
    protected function filter($config, $type)
    {
        try {
            // 解密json
            foreach ($config as $key => &$item) {
                if (!empty($item) && !is_numeric($item) && !is_array($item)) {
                    !empty(json_decode($item)) && $item = Json::decode($item);
                }
            }

            $config = ArrayHelper::filter($config, $this->filter);
            $this->config = ArrayHelper::merge(Yii::$app->params['uploadConfig'][$type], $config);
            // 参数
            $this->baseInfo['width'] = $this->config['width'] ?? 0;
            $this->baseInfo['height'] = $this->config['height'] ?? 0;
        } catch (\Exception $e) {
            $this->config = Yii::$app->params['uploadConfig'][$type];
        }

        !empty($this->config['drive']) && $this->drive = $this->config['drive'];
    }

    /**
     * 写入目录
     *
     * @param array $paths
     */
    public function setPaths(array $paths)
    {
        $this->paths = $paths;
    }

    /**
     * 写入基础信息
     *
     * @param array $baseInfo
     */
    public function setBaseInfo(array $baseInfo)
    {
        $this->baseInfo = $baseInfo;
    }

    /**
     * @param mixed $drive
     */
    public function setDrive($drive)
    {
        $this->drive = $drive;
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getBaseInfo()
    {
        // 处理上传的文件信息
        $this->baseInfo['type'] = $this->filesystem->getMimetype($this->baseInfo['url']);
        $this->baseInfo['size'] = $this->filesystem->getSize($this->baseInfo['url']);
        $path = $this->baseInfo['url'];
        // 获取上传路径
        $this->baseInfo = $this->uploadDrive->getUrl($this->baseInfo, $this->config['fullPath']);

        $data = [
            'drive' => $this->drive,
            'upload_type' => $this->type,
            'mime_type' => $this->baseInfo['type'],
            'size' => $this->baseInfo['size'],
            'width' => $this->baseInfo['width'],
            'height' => $this->baseInfo['height'],
            'extension' => $this->baseInfo['extension'],
            'name' => $this->baseInfo['name'],
            'md5' => $this->config['md5'] ?? '',
            'base_url' => $this->baseInfo['url'],
            'path' => $path,
            'ip' => Yii::$app->request->getUserIP()
        ];

        $this->baseInfo['id'] = Attachment::create($data);

        $this->baseInfo['formatter_size'] = Yii::$app->formatter->asShortSize($this->baseInfo['size'], 2);
        $this->baseInfo['upload_type'] = self::formattingFileType($this->baseInfo['type'], $this->baseInfo['extension'], $this->type);

        return $this->baseInfo;
    }

    /**
     * @param $specific_type
     * @param $extension
     * @return string
     */
    public static function formattingFileType($specific_type, $extension, $upload_type)
    {
        if (preg_match("/^image/", $specific_type) && $extension != 'psd') {
            return Attachment::UPLOAD_TYPE_IMAGES;
        }

        return $upload_type;
    }
}