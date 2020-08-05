<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 21:16
 */

use yii\widgets\ActiveForm;
use app\common\helpers\Url;

?>
<div class="config-banners-form">
    <div class="layui-carousel" id="banners">
        <div carousel-item>
            <?php foreach (unserialize($model->value) as $key => $value) { ?>
            <a href="<?= $value['link'] ?>"> <img src="<?= $value['images'] ?>" style="width: 100%;height: 350px;"></a>
            <?php } ?>
        </div>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'config-banners-form',
        'options' => ['class' => 'layui-form layuimini-form'],
        'fieldConfig' => [
            'template' => "<div class='layui-form-item'>{label}\n<div class='layui-input-block'>{input}</div>\n{hint}\n{error}</div>",
        ]

    ]); ?>
    <?php foreach (unserialize($model->value) as $key => $value) { ?>
        <div class="layui-input-inline" style="vertical-align:inherit">
            <div class="layui-form-item"><label class="layui-form-label" for="banner-value-<?= $key ?>">轮播图<?= $key ?></label>
                <div class="layui-input-block"><input type="text" style="width: 350px" id="banner-value-<?= $key ?>" class="layui-input" name="banner-value[<?= $key ?>][images]" value="<?= $value['images'] ?>" placeholder="网站首页轮播图 <?= $key ?>" aria-required="true"></div>
                <div class="help-block"></div>
            </div>
        </div>
        <button type="button" class="layui-btn banner-<?= $key ?>">上传</button>
        <div class="layui-input-inline">
            <div class="layui-form-item"><label class="layui-form-label" for="banner-link-<?= $key ?>">轮播链接<?= $key ?></label>
                <div class="layui-input-block"><input type="text" id="banner-link-<?= $key ?>" class="layui-input" name="banner-value[<?= $key ?>][link]" value="<?= $value['link'] ?>" placeholder="网站首页轮播图 <?= $key ?>" aria-required="true"></div>
                <div class="help-block"></div>
            </div>
        </div>
        <br><br>
    <?php } ?>
    <div class="form-group">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="siteInfo">确认保存</button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script>
    <?php $this->beginBlock('js_end') ?>
    layui.use(['form','upload','carousel'], function () {
        var form = layui.form
            , upload = layui.upload
            , carousel = layui.carousel;

        //轮播
        carousel.render({
            elem: '#banners'
            ,width: '100%' //设置容器宽度
            ,arrow: 'always' //始终显示箭头
            //,anim: 'updown' //切换动画方式
        });
        //监听提交
        form.on('submit(siteInfo)', function (data) {
            console.log(data.field);
            $.ajax({
                url: '<?=Url::to(['/admin/config/banners'])?>',
                type: 'post',
                dataType: 'json',
                data: data.field,
                timeout: 2000,
                success: function (data) {
                    console.log(data.code);
                    if (data.code === 200) {
                        layer.msg(data.msg,{ icon:1, time:2000,offset: 't'},function(){
                            location.reload()
                        });
                    } else {
                        layer.msg(data.msg)
                    }
                },
                error: function () {
                    layer.msg("未知错误，轮播保存失败")
                }
            });
            return false;
        });
        //执行实例
        upload.render({
            elem: '.banner-0'
            ,url: '<?=Url::to(['/admin/file/images'])?>'
            ,done: function(res){
                $('#banner-value-0').val(res.data.url);
                layer.msg(res.msg,{ icon:1, time:1000,offset: 't'});
            }
            ,error: function(res){
                layer.msg(res.msg,{ icon:2, time:1000,offset: 't'});
            }
        });
        upload.render({
            elem: '.banner-1'
            ,url: '<?=Url::to(['/admin/file/images'])?>'
            ,done: function(res){
                $('#banner-value-1').val(res.data.url);
                layer.msg(res.msg,{ icon:1, time:1000,offset: 't'});
            }
            ,error: function(res){
                layer.msg(res.msg,{ icon:2, time:1000,offset: 't'});
            }
        });
        upload.render({
            elem: '.banner-2'
            ,url: '<?=Url::to(['/admin/file/images'])?>'
            ,done: function(res){
                $('#banner-value-2').val(res.data.url);
                layer.msg(res.msg,{ icon:1, time:1000,offset: 't'});
            }
            ,error: function(res){
                layer.msg(res.msg,{ icon:2, time:1000,offset: 't'});
            }
        });
        upload.render({
            elem: '.banner-3'
            ,url: '<?=Url::to(['/admin/file/images'])?>'
            ,done: function(res){
                $('#banner-value-3').val(res.data.url);
                layer.msg(res.msg,{ icon:1, time:1000,offset: 't'});
            }
            ,error: function(res){
                layer.msg(res.msg,{ icon:2, time:1000,offset: 't'});
            }
        });

    });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_LOAD); ?>
