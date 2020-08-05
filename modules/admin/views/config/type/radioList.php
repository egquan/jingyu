<?php
/**
 * radioList单选框
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/17
 * Time: 21:50
 */
$key = $model->key;

if (is_array($model->data)){
    $defaultValue = array_values([0]);
}else{
    $defaultValue = null;
}

$model->value = ($model->value) ?: $defaultValue;
echo $form->field($model, 'value', [
    'options' => ['class' => 'form-group'],
    'template' => '<div class="layui-form-item"><label class="layui-form-label" for="config-value">'.$model->title.'</label><div class="layui-input-block">{input}</div>{hint}{error}</div>',
])->radioList($data,
    [
        'item' => function ($index, $label, $name, $checked, $value) use ($key) {
            $checked = $checked ? "checked" : "";
            $return = '<input type="radio" id="Config['.$key.$value.']" name="Config['.$key.']" value="' . $value . '" title="' . ucwords($label) . '"  ' . $checked . '>';
            return $return;
        }
    ]);