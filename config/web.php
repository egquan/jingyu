<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'JingYu',
    'language' => "zh-CN",
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    /** Admin模块 **/
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'components' => [
        /** Request组件 **/
        'request' => [
            // cookie验证密钥
            'cookieValidationKey' => 'poOtmjAErdtpYSUJiSwgsBnKrkqKvXFGcQZbZyYoLurozUbRYXgLgXuHxJagYnLO',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser'
            ]
        ],
        'session' => [
            'name' => 'jy',
            'class' => 'yii\redis\Session',
            'redis' => 'redis',
            'keyPrefix' => 'session:admin:'
        ],
        /** Cache(缓存组件)配置 **/
        'cache' => [
            /** 使用文件缓存无Redis扩展时使用 */
            //'class' => 'yii\caching\FileCache',
            /** 使用 Redis 缓存 推荐*/
            'class' => 'yii\redis\cache'
        ],
        /** Redis配置 **/
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'password' => null,
            'database' => 5,
        ],
        /** User配置 **/
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/admin/user/login'],
            'identityCookie' => ['name' => '_JingYu', 'httpOnly' => true],
        ],
        /** 错误处理 **/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /** 邮件配置 **/
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        /** 日志配置 **/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        /** 载入数据库配置 **/
        'db' => $db,
        /** 路由配置(用户Url美化) **/
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'index/page-<page:\d+>'=>'site/index',
	            'type-<id:\d+>/page-<page:\d+>'=>'type/index',
                'type-<id:\d+>'=>'type/index',
                'article/<id:\d+>'=>'article/view',
            ],
        ],
        /** ------ 网站碎片类 ------ **/
        'debris' => [
            'class' => 'app\common\components\Debris',
        ],
        /** ------ 上传组件 ------ **/
        'uploadDrive' => [
            'class' => 'app\common\components\UploadDrive',
        ],
        //禁用资源
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                // 禁用boostrap.css
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                // 禁用boostrap.js
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ]
            ]
        ],

    ],
    /** 载入全局配置参数 **/
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
