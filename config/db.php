<?php

return [
    /**
     * 数据库配置 必须开启PDO扩展
     */
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=jingyu',
    'username' => 'roota',
    'password' => 'root',
    'charset' => 'utf8mb4',
    'tablePrefix' => 'jy_'

    /**
     * 数据结构缓存(用于生产环境) *
     */
    //'enableSchemaCache' => true,
    /** 数据结构缓存时长/秒（使用0表示缓存的数据将永不过期）**/
    //'schemaCacheDuration' => 60,
    /** 缓存组件 **/
    //'schemaCache' => 'cache',
    /**
     * 查询缓存(用于生产环境) *
     */
    //'enableQueryCache' => true,
    /** 查询缓存有保持时长/秒（使用0表示缓存的数据将永不过期） **/
    //'queryCacheDuration' => 3600,
    /** 缓存组件 **/
    //'queryCache' => 'cache'
];
