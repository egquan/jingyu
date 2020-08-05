<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/30
 * Time: 23:25
 */
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\common\helpers\Html;
use app\common\helpers\Url;
$model->status = is_null($model->status) ? 1:$model->status;
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
    <div class="layui-input-inline">
        <?=$form->field($model,'type_id')->dropDownList(ArrayHelper::map($type,'id','title'))->label('所属分类')?>
    </div>
    <div class="layui-input-inline">
        <?=$form->field($model,'status')->dropDownList([0 => '不显示',1 => '正常'])->label('所属分类')?>
    </div>
    <?=$form->field($model,'title')->textInput(['placeholder' => '输入文章标题'])?>
    <div class="form-group field-article-cover required">
    <div class="layui-form-item">
        <label class="layui-form-label" for="article-cover">文章封面</label>
        <div class="layui-input-block">
            <img <?=empty($model->cover) ? '':'src="'.$model->cover.'"'?> class="article-cover" style="width: 115px;height:76px;border:5px solid ghostwhite">
            <button type="button" class="layui-btn article-cover-bnt"><?= $model->isNewRecord ? '上传':'更新' ?></button>
        </div>
        <div class="layui-input-block help-block"></div>
    </div></div>
	<?= Html::activeHiddenInput($model,'cover') ?>
    <?=$form->field($model,'keyword')->textarea(['placeholder' => '输入分类关键词,最多支持64个字符,SEO优化项','class' => 'layui-textarea'])?>
    <?=$form->field($model,'description')->textarea(['placeholder' => '输入分类描述,最大支持128个字符,SEO优化项','class' => 'layui-textarea'])?>
    <?=$form->field($model,'content')->textarea(['placeholder' => '输入分类描述,最大支持128个字符,SEO优化项','class' => 'layui-textarea','lay-verify' => 'articleContent'])?>
    <div class="form-group">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <?=$model->isNewRecord ? '<button type="submit" class="layui-btn" lay-submit="" lay-filter="article-create">添加</button>':'<button type="submit" class="layui-btn" lay-submit="" lay-filter="article-update">更新</button>'?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script>
    <?php $this->beginBlock('js_end') ?>
    layui.use(['form','layedit','upload'], function () {
        var form = layui.form
            , upload = layui.upload
            , layedit = layui.layedit;
        //封面上传
        upload.render({
            elem: '.article-cover-bnt'
            ,url: '<?=Url::to(['/admin/file/images'])?>'
            ,done: function(res){
                if (res.code == 0){
                $('#article-cover').val(res.data.url);
                $('.article-cover').attr('src',res.data.url);
                }
                layer.msg(res.msg,{ icon:1, time:1000,offset: 't'});
            }
            ,error: function(res){
                layer.msg(res.msg,{ icon:2, time:1000,offset: 't'});
            }
        });

        layedit.set({
                uploadImage: {
                    url: '<?=Url::to(['/admin/file/images'])?>',
                    field: 'file',//上传时的文件参数字段名
                    accept: 'image',
                    acceptMime: 'image/*',
                    exts: 'jpg|png|gif|bmp|jpeg',
                    size: 1024 * 10
                }
                , uploadVideo: {
                    url: '<?=Url::to(['/admin/file/videos'])?>',
                    field: 'file',//上传时的文件参数字段名
                    accept: 'videos',
                    acceptMime: 'video/*',
                    exts: 'mp4|flv|avi|rm|rmvb',
                    size: 1024 * 2 * 10
                }
                //右键删除图片/视频时的回调参数，post到后台删除服务器文件等操作，
                //传递参数：
                //图片： imgpath --图片路径
                //视频： filepath --视频路径 imgpath --封面路径
                , calldel: {
                    url: '<?=Url::to(['/admin/attachment/edit-del'])?>'
                }
        });
        var ieditor = layedit.build('article-content', {
            tool: [
                'undo'
                , 'redo'
                , 'strong'
                , 'italic'
                , 'underline'
                , 'del'
                , 'addhr'
                , '|'
                , 'fontFomatt'
                , 'fontfamily'
                , 'fontSize'
                , 'colorpicker'
                , 'fontBackColor'
                , 'face'
                , '|'
                , 'left'
                , 'center'
                , 'right'
                , '|'
                , 'link'
                , 'unlink'
                , 'images'
                , 'image_alt'
                , 'attachment'
                , 'video'
                , '|', 'table'
                , 'customlink'
                , 'fullScreen'
                , 'preview'
            ]
        });
        //处理同步问题
        form.verify({
            articleContent: function(value) {
                return layedit.sync(ieditor);
            }
        });
        //监听添加文章提交
        form.on('submit(article-create)', function (data) {
            $.ajax({
                url: '<?=Url::to(['/admin/article/create'])?>',
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
                    layer.msg("未知错误，文章操作失败！", {icon: 2, time: 2000, offset: 't'})
                }
            });
            return false;
        });
        //监听更新文章提交
        form.on('submit(article-update)', function (data) {
            $.ajax({
                url: '<?=Url::to(['/admin/article/update'])?>?<?='id='.$model->id?>',
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
                    layer.msg("未知错误，文章操作失败！", {icon: 2, time: 2000, offset: 't'})
                }
            });
            return false;
        });
    });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_LOAD); ?>
