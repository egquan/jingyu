<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/19
 * Time: 0:43
 */
use app\common\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="account-create-form">
    <?php $form = ActiveForm::begin([
        'id' => 'config-site-info-form',
        'options' => ['class' => 'layui-form layuimini-form'],
        'fieldConfig' => [
            'template' => "<div class='layui-form-item'>{label}\n<div class='layui-input-block'>{input}</div>\n{hint}\n{error}</div>",
            'inputOptions' => ['class' => 'layui-input'],
            'labelOptions' => ['class' => 'layui-form-label'],
            'errorOptions' => ['class' => 'layui-input-block help-block']
        ]
    ]); ?>
    <?=$form->field($model,'username')->textInput(['placeholder' => '输入用户账号'])?>
    <?=$form->field($model,'password_hash')->passwordInput(['placeholder' => $model->isNewRecord ? '输入用户密码': '不修改密码时无需输入'])?>
    <?=$form->field($model,'nickname')->textInput(['placeholder' => '输入用户昵称'])?>
    <?=$form->field($model,'email')->textInput(['placeholder' => '输入用户邮箱'])?>
    <?=$form->field($model,'status')->dropDownList([1=>'正常',0=>'禁用'])?>
    <div class="form-group">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <?=$model->isNewRecord ? '<button type="submit" class="layui-btn" lay-submit="" lay-filter="account-create">添加</button>':'<button type="submit" class="layui-btn" lay-submit="" lay-filter="account-update">更新</button>'?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script>
    <?php $this->beginBlock('js_end') ?>
    layui.use(['form'], function () {
        var form = layui.form;
        //监听添加用户提交
        form.on('submit(account-create)', function (data) {
            $.ajax({
                url: '<?=Url::to(['/admin/account/create'])?>',
                type: 'post',
                dataType: 'json',
                data: data.field,
                timeout: 2000,
                success: function (data) {
                    if (data.code === 200) {
                        layer.msg(data.msg, {icon: 1, time: 2000, offset: 't'}, function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.location.reload();
                            parent.layer.close(index);

                        });
                    } else {
                        layer.msg(data.msg, {icon: 2, time: 2000, offset: 't'})
                    }
                },
                error: function () {
                    layer.msg("未知错误，用户操作失败！", {icon: 2, time: 2000, offset: 't'})
                }
            });
            return false;
        });
        //监听更新用户提交
        form.on('submit(account-update)', function (data) {
            $.ajax({
                url: '<?=Url::to(['/admin/account/update'])?>?<?='id='.$model->id?>',
                type: 'post',
                dataType: 'json',
                data: data.field,
                timeout: 2000,
                success: function (data) {
                    if (data.code === 200) {
                        layer.msg(data.msg, {icon: 1, time: 2000, offset: 't'}, function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.location.reload();
                            parent.layer.close(index);

                        });
                    } else {
                        layer.msg(data.msg, {icon: 2, time: 2000, offset: 't'})
                    }
                },
                error: function () {
                    layer.msg("未知错误，用户操作失败！", {icon: 2, time: 2000, offset: 't'})
                }
            });
            return false;
        });
    });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_LOAD); ?>
