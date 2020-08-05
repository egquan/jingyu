<?php
/**
 * Created by ChunBlog.com.
 * User: 春风
 * WeChat: binzhou5
 * QQ: 860646000
 * Date: 2020/7/18
 * Time: 21:43
 */

use app\common\helpers\Url;

?>
    <div class="layuimini-container">
        <div class="layuimini-main">

            <fieldset class="table-search-fieldset">
                <legend>搜索信息</legend>
                <div style="margin: 10px 10px 10px 10px">
                    <form class="layui-form layui-form-pane" action="">
                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">文章标题</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="title" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <button type="submit" class="layui-btn layui-btn-primary" lay-submit
                                        lay-filter="data-search-btn"><i class="layui-icon"></i> 搜 索
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>

            <script type="text/html" id="toolbarDemo">
                <div class="layui-btn-container">
                    <button class="layui-btn layui-btn-sm data-add-btn" lay-event="add"> 添加文章</button>
                    <button class="layui-btn layui-btn-sm layui-btn-danger data-delete-btn" lay-event="delete"> 删除文章
                    </button>
                </div>
            </script>

            <table class="layui-hide" id="currentTableId" lay-filter="currentTableFilter"></table>

            <script type="text/html" id="currentTableBar">
                <a class="layui-btn layui-btn-xs data-count-edit" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-xs layui-btn-danger data-count-delete" lay-event="delete">删除</a>
            </script>

        </div>
    </div>
    <script>
        <?php $this->beginBlock('js_end') ?>
        layui.use(['form', 'table'], function () {
            var $ = layui.jquery,
                form = layui.form,
                table = layui.table;

            table.render({
                elem: '#currentTableId',
                url: '<?=Url::to(['/admin/article/index'])?>',
                toolbar: '#toolbarDemo',
                defaultToolbar: ['filter', 'exports', 'print', {
                    title: '提示',
                    layEvent: 'LAYTABLE_TIPS',
                    icon: 'layui-icon-tips'
                }],
                cols: [[
                    {type: "checkbox", width: 50, fixed: "left"},
                    {field: 'id', width: 80, title: 'ID', sort: true},
                    {field: 'title', width: 300, title: '标题'},
                    {field: 'type_title',width:150, title: '所属分类'},
                    {
                        field: 'status', width: 80, title: '状态', templet: function (d) {
                            if (d.status == 1) {
                                return '<span style="color: #08cc16;">正常</span>';
                            }
                            return '<span style="color: #cc0a0d;">不显示</span>';
                        }
                    },
                    {field: 'created_at', width: 150, title: '创建时间', sort: true},
                    {field: 'updated_at', width: 150, title: '更新时间', sort: true},
                    {title: '操作', minWidth: 50, templet: '#currentTableBar', fixed: "right", align: "center"}
                ]],
                limits: [10, 15, 20, 25, 50, 100],
                limit: 15,
                page: true
            });

            // 监听搜索操作
            form.on('submit(data-search-btn)', function (data) {
                var result = JSON.stringify(data.field);
                //执行搜索重载
                table.reload('currentTableId', {
                    page: {
                        curr: 1
                    }
                    , where: {
                        searchParams: result
                    }
                }, 'data');
                return false;
            });

            /**
             * toolbar监听事件
             */
            table.on('toolbar(currentTableFilter)', function (obj) {
                if (obj.event === 'add') {  // 监听添加操作
                    var index = layer.open({
                        title: '添加文章',
                        type: 2,
                        shade: 0.2,
                        maxmin: true,
                        shadeClose: true,
                        area: ['100%', '100%'],
                        content: '<?=Url::to(['/admin/article/create'])?>',
                    });
                    $(window).on("resize", function () {
                        layer.full(index);
                    });
                } else if (obj.event === 'delete') {  // 监听删除操作
                    var checkStatus = table.checkStatus('currentTableId')
                        , data = checkStatus.data;
                    if (data.length <= 0) {
                        layer.msg('请选择要删除的文章！', {icon: 3, time: 2000, offset: 't'});
                        return false;
                    }
                    for (i = 0, len = data.length; i < len; i++) {
                        $.ajax({
                            url: '<?=Url::to(['/admin/article/delete'])?>?id=' + data[i].id,
                            type: 'post',
                            dataType: 'json',
                            timeout: 2000
                        });
                    }
                    layer.msg('删除成功！', {icon: 1, time: 2000, offset: 't'}, function () {
                        location.reload();
                    });
                }
            });

            //监听表格复选框选择
            table.on('checkbox(currentTableFilter)', function (obj) {

            });

            table.on('tool(currentTableFilter)', function (obj) {
                var data = obj.data;
                if (obj.event === 'edit') {

                    var index = layer.open({
                        title: '编辑文章',
                        type: 2,
                        shade: 0.2,
                        maxmin: true,
                        shadeClose: true,
                        area: ['100%', '100%'],
                        content: '<?=Url::to(['/admin/article/update'])?>?id=' + data.id,
                    });
                    $(window).on("resize", function () {
                        layer.full(index);
                    });
                    return false;
                } else if (obj.event === 'delete') {
                    layer.confirm('真的删除行么', function (index) {
                        layer.close(index);
                        $.ajax({
                            url: '<?=Url::to(['/admin/article/delete'])?>?id=' + obj.data.id,
                            type: 'post',
                            dataType: 'json',
                            timeout: 2000,
                            success: function (data) {
                                if (data.code === 200) {
                                    layer.msg(data.msg, {icon: 1, time: 2000, offset: 't'}, function () {
                                        obj.del();
                                    });
                                } else {
                                    layer.msg(data.msg, {icon: 2, time: 2000, offset: 't'})
                                }
                            },
                            error: function () {
                                layer.msg("未知错误，文章操作失败！", {icon: 2, time: 2000, offset: 't'})
                            }
                        });
                    });
                }
            });

        });
        <?php $this->endBlock(); ?>
    </script>
<?php $this->registerJs($this->blocks['js_end'], \yii\web\View::POS_LOAD); ?>