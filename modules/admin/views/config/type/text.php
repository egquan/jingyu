<?php
/**
 * text文本框
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/17
 * Time: 21:50
 */
echo $form->field($model,'value')
    ->textInput(['class' =>'layui-input','placeholder' => $model->description,'name' => "Config[$model->key]",'id' =>"Config[$model->key]"])
    ->label($model->title,['class' => 'layui-form-label'])
?>