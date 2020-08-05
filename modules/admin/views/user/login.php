<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 18:33
 */

use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use app\common\helpers\Html;
use app\assets\AdminOneAsset;

AdminOneAsset::register($this);

$this->registerCssFile('@web/css/login.css', ['depends' => 'app\assets\AdminOneAsset'])
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <title><?= Yii::$app->debris->config('site_name') . ' - 管理后台登录' ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body style="margin: 0 0 0 0;">
<div class="admin-user-login admin-user-display-show">
    <div class="admin-user-login-main">
        <div class="admin-user-login-box admin-user-login-body">
            <div class="admin-user-login-header">
                <h2><?= Yii::$app->debris->config('site_name') . '管理后台登录' ?></h2>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'layui-form'],
                'fieldConfig' => [
                    'template' => "<div class='layui-form-item'>{label}\n{input}\n{hint}\n{error}</div>",
                ]

            ]); ?>

            <?= $form
                ->field($model, 'username')
                ->textInput(['placeholder' => $model->getAttributeLabel('username'), 'class' => 'layui-input'])
                ->label('', ['class' => 'layadmin-user-login-icon layui-icon layui-icon-username']); ?>
            <?= $form
                ->field($model, 'password')
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'class' => 'layui-input'])
                ->label('', ['class' => 'layadmin-user-login-icon layui-icon layui-icon-password']); ?>
            <?php if ($model->scenario == 'captchaRequired') { ?>
                <?= $form
                    ->field($model, 'verifyCode')
                    ->widget(Captcha::class, [
                        'captchaAction' => '/admin/user/captcha',
                        'options' => [
                            'class' => 'layui-input',
                            'placeholder' => '输入验证码',
                        ],
                        'template' => '<div class="layui-row"><div class="layui-col-xs7"><label class="layadmin-user-login-icon layui-icon layui-icon-vercode"></label>{input}</div><div class="layui-col-xs5"><div style="margin-left: 10px;">{image}</div></div></div>',
                        'imageOptions' => [
                            'class' => 'layadmin-user-login-codeimg'
                        ]
                    ])
                    ->label(false); ?>
            <?php } ?>
            <?= $form->field($model, 'rememberMe')->checkbox([
                'lay-skin' => 'primary',
                'title' => '记住密码'
            ], false)->label(false) ?>
            <?= Html::submitButton('登 入', ['class' => 'layui-btn layui-btn-fluid', 'name' => 'login-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
<script>
    layui.use(['form'], function () {

    });
</script>
</body>
</html>
<?php $this->endPage() ?>
