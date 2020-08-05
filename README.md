<p align="center">
    <h1 align="center">鲸鱼文章系统V1.0版本</h1>
    <br>
</p>

<h1>安装说明：</h1>
项目基于Yii2框架开发

所需环境: PHP >=7.2，PDO扩展，Redis扩展

1.绑定网站访问入口文件夹 web 目录

2.新建数据库(字符集utf8mb4 -> utf8mb4_unicode_ci) 导入jingyu.sql文件

3.配置数据库config/db.php “dbname”数据库名 ，“username”数据库用户名 “password”数据库密码

4.执行composer install 安装所需依赖

<h1>网站后台说明：</h1>
后台入口 /admin   用户：admin  密码：admin888

<h1>网站安全防护：</h1>
1.登陆页面密码错误3次 自动开启验证码。

2.所有数据输入全部需要csrf验证，除网站后台任何外部软件、工具等使用POST提交数据都会被拒绝！

3.通过数据库字段绑定的方式更新、新增数据，不存在任何SQL注入漏洞。

<h1>附件储存：</h1>
附件储存有两种方式，本地和阿里云OSS。

注意：附件管理页面删除附件后，相应的文件会被清理。

文章编辑器内点击右键删除附件附件也会被自动清理。

DIRECTORY STRUCTURE
-------------------

      assets/             网站CSS,JS文件定义
      common/             网站公共文件目录
      commands/           console controllers 文件
      config/             所有配置文件
      controllers/        网站前台controllers文件
      mail/               contains view files for e-mails
      models/             所有数据模型类
      modules/            网站模块 如admin模块
      migrations/         网站数据迁移文件
      runtime/            网站临时文件储存如日志文件文件缓存等
      tests/              contains various tests for the basic application
      vendor/             包含相关的第三方软件包
      views/              Web应用程序的视图文件
      web/                包含输入脚本和Web资源



REQUIREMENTS
------------
