<?php

return [
    // 全局上传配置
    'uploadConfig' => [
        // 图片
        'images' => [
            'originalName' => false, // 是否保留原名
            'fullPath' => true, // 是否开启返回完整的文件路径
            'maxSize' => 1024 * 1024 * 10,// 图片最大上传大小,默认10M
            'extensions' => ["png", "jpg", "jpeg", "gif", "bmp"],// 可上传图片后缀不填写即为不限
            'path' => 'images/', // 图片创建路径
            'subName' => 'Y/m/d', // 图片上传子目录规则
            'prefix' => 'image_', // 图片名称前缀
            'mimeTypes' => 'image/*', // 媒体类型
        ],
        // 视频
        'videos' => [
            'originalName' => false, // 是否保留原名
            'fullPath' => true, // 是否开启返回完整的文件路径
            'maxSize' => 1024 * 1024 * 50,// 最大上传大小,默认50M
            'extensions' => ['mp4'],// 可上传文件后缀不填写即为不限
            'path' => 'videos/',// 创建路径
            'subName' => 'Y/m/d',// 上传子目录规则
            'prefix' => 'video_',// 名称前缀
            'mimeTypes' => 'video/*', // 媒体类型
        ],
        // 文件
        'files' => [
            'originalName' => false, // 是否保留原名
            'fullPath' => true, // 是否开启返回完整的文件路径
            'maxSize' => 1024 * 1024 * 150,// 最大上传大小,默认150M
            'extensions' => [],// 可上传文件后缀不填写即为不限
            'path' => 'files/',// 创建路径
            'subName' => 'Y/m/d',// 上传子目录规则
            'prefix' => 'file_',// 名称前缀
            'mimeTypes' => '*', // 媒体类型
            'blacklist' => [ // 文件后缀黑名单
                'php', 'php5', 'php4', 'php3', 'php2', 'php1',
                'java', 'asp', 'jsp', 'jspa', 'javac',
                'py', 'pl', 'rb', 'sh', 'ini', 'svg', 'html', 'jtml', 'phtml', 'pht', 'js'
            ],
        ],
    ],
];
