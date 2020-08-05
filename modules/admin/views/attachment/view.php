<?php
/**
 * Created by egquan@163.com
 * Date: 2020/8/3
 * Time: 17:05
 */
?>
<div class="layuimini-container">
    <div class="layuimini-main">

        <fieldset class="table-search-fieldset">
            <legend>查看附件</legend>
            <div style="margin: 10px 10px 10px 10px">
                <form class="layui-form layui-form-pane" action="">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">链接地址</label>
                            <div class="layui-input-inline">
                                <input type="text" name="base_url" value="<?= $model->base_url ?>" autocomplete="off"
                                       class="layui-input" style="width: 400%">
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                $pattern = '/[a-zA-z]+/';
                $keyword = preg_match($pattern, $model->mime_type, $mimeType);

                if ($keyword > 0) {
                    if ($mimeType[0] == 'image') {
                        ?>
                        <img src="<?= $model->base_url ?>" alt="<?= $model->name ?>">
                    <?php } elseif ($mimeType[0] == 'video') { ?>
                        <video src="<?= $model->base_url ?>" controls="controls" autoplay="autoplay"></video>
                    <?php } elseif ($mimeType[0] == 'text') {
                        $text = file_get_contents($model->base_url);
                        $text = preg_replace('/\n|\r\n/', '<br>', $text);
                        ?>
                        <?= $text ?>
                    <?php } elseif ($mimeType[0] == 'audio') { ?>
                        <audio src="<?= $model->base_url ?>" autoplay="autoplay" controls="controls"></audio>
                    <?php } else { ?>
                        <p class="layui-elem-quote" style="border-left: 5px solid #cc0a0d;font-size: 25px"><i
                                    class="layui-icon layui-icon-about" style="font-size: 30px; color: #cc0a0d;"></i>附件格式不支持在线查看!
                        </p>
                    <?php }
                } ?>
            </div>
        </fieldset>
    </div>
