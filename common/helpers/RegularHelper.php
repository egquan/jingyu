<?php

namespace app\common\helpers;

/**
 * 正则匹配验证
 *
 * Class RegularHelper
 * @package common\helpers
 */
class RegularHelper
{
    /**
     * 验证
     *
     * @param string $type 方法类型
     * @param string $value 值
     * @return false|int
     */
    public static function verify($type, $value)
    {
        return preg_match(self::$type(), $value);
    }

    /**
     * 验证是否是url
     *
     * @return string
     */
    public static function url()
    {
        return '/(http:\/\/)|(https:\/\/)/i';
    }
}