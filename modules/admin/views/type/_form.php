<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/20
 * Time: 23:02
 */
use app\common\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="type-create-form">
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
    <?=$form->field($model,'title')->textInput(['placeholder' => '输入分类标题'])?>
    <?=$form->field($model,'keyword')->textarea(['placeholder' => '输入分类关键词,最多支持64个字符,SEO优化项','class' => 'layui-textarea'])?>
    <?=$form->field($model,'description')->textarea(['placeholder' => '输入分类描述,最大支持128个字符,SEO优化项','class' => 'layui-textarea'])?>
    <?=$form->field($model,'sort')->textInput(['placeholder' => '输入分类排序,只能束数字','lay-verify' => 'number'])?>
    <div class="form-group">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <?=$model->isNewRecord ? '<button type="submit" class="layui-btn" lay-submit="" lay-filter="type-create">添加</button>':'<button type="submit" class="layui-btn" lay-submit="" lay-filter="type-update">更新</button>'?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script>
    <?php $this->beginBlock('js_end') ?>
    layui.use(['form'], function () {
        var form = layui.form;
        //监听添加分类提交
        form.on('submit(type-create)', function (data) {
            $.ajax({
                url: '<?=Url::to(['/admin/type/create'])?>',
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
                    layer.msg("未知错误，分类操作失败！", {icon: 2, time: 2000, offset: 't'})
                }
            });
            return false;
        });
        //监听更新分类提交
        form.on('submit(type-update)', function (data) {
            $.ajax({
                url: '<?=Url::to(['/admin/type/update'])?>?<?='id='.$model->id?>',
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
                    layer.msg("未知错误，分类操作失败！", {icon: 2, time: 2000, offset: 't'})
                }
            });
            return false;
        });
    });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_LOAD); ?>
