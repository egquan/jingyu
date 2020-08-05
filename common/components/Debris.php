<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 17:36
 */

namespace app\common\components;

use Yii;
use app\common\enums\CacheEnum;
use app\models\Config;
class Debris
{
    /**
     * 配置数组
     * @var array
     */
    protected static $config = [];

    /**
     * 按key返回配置
     *
     * @param string $key 字段名称
     * @param bool $noCache true 不从缓存读取 false 从缓存读取
     * @return string|null
     */
    public function config($key, $noCache = false)
    {
        // 获取缓存信息
        $info = $this->getConfigInfo($noCache);

        return isset($info[$key]) ? trim($info[$key]) : null;
    }

    /**
     * 返回配全部置
     *
     * @param bool $noCache true 不从缓存读取 false 从缓存读取
     * @return array|bool|mixed
     */
    public function configAll($noCache = false)
    {
        $info = $this->getConfigInfo($noCache);
        return $info ? $info : [];
    }

    /**
     * 获取全部配置信息
     *
     * @param $noCache true 不从缓存读取 false 从缓存读取
     * @return array|mixed
     */
    protected function getConfigInfo($noCache)
    {
        if ($noCache == false && static::$config) {
            return static::$config;
        }

        // 获取缓存信息
        $cacheKey = CacheEnum::$CONFIG_CACHE;
        if ($noCache == true || !(static::$config = Yii::$app->cache->get($cacheKey))) {
            $config = Config::find()->select(['key','value'])->asArray()->all();
            static::$config = [];

            foreach ($config as $row) {
                static::$config[$row['key']] = $row['value'];
            }

            // 设置缓存
            Yii::$app->cache->set($cacheKey, static::$config, 60 * 60 * 1);
        }

        return static::$config;
    }
}