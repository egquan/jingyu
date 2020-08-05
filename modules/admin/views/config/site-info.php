<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/12
 * Time: 11:54
 * @var $this \yii\web\View
 */
use yii\widgets\ActiveForm;
use app\common\helpers\Url;
?>
<div class="config-site-info-form">
    <?php $form = ActiveForm::begin([
        'id' => 'config-site-info-form',
        'options' => ['class' => 'layui-form layuimini-form'],
        'fieldConfig' => [
            'template' => "<div class='layui-form-item'>{label}\n<div class='layui-input-block'>{input}</div>\n{hint}\n{error}</div>",
        ]

    ]); ?>
    <?php foreach ($models as $model) {
        if ($model->type == 'text'){
        echo $this->render('type/text',['model' => $model,'form' => $form]);
        }elseif ($model->type == 'radioList'){
            echo $this->render('type/radioList',['model' => $model,'form' => $form,'data' => json_decode($model->data)]);
        }
     } ?>
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
    layui.use(['form'], function () {
        var form = layui.form
            , layer = layui.layer;

        //监听提交
        form.on('submit(siteInfo)', function (data) {
            $.ajax({
                url:'<?=Url::to(['/admin/config/site-info'])?>',
                type:'post',
                dataType:'json',
                data:data.field,
                timeout:2000,
                success:function(data){
                    console.log(data.code);
                    if(data.code === 200){
                        layer.msg(data.msg,{ icon:1, time:2000,offset: 't'},function(){
                            location.reload()
                        });
                    }else{
                        layer.msg(data.msg,{ icon:2, time:2000,offset: 't'})
                    }
                },
                error:function () {
                    layer.msg("未知错误，站点设置保存失败",{ icon:2, time:2000,offset: 't'})
                }
            });
            return false;
        });
    });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js_end'],\yii\web\View::POS_LOAD); ?>