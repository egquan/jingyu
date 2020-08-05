<div class="layui-body">

    <div class="layuimini-tab layui-tab-rollTool layui-tab" lay-filter="layuiminiTab" lay-allowclose="true">
        <ul class="layui-tab-title">
            <li class="layui-this" id="layuiminiHomeTabId" lay-id=""></li>
        </ul>
        <div class="layui-tab-control">
            <li class="layuimini-tab-roll-left layui-icon layui-icon-left"></li>
            <li class="layuimini-tab-roll-right layui-icon layui-icon-right"></li>
            <li class="layui-tab-tool layui-icon layui-icon-down">
                <ul class="layui-nav close-box">
                    <li class="layui-nav-item">
                        <a href="javascript:;"><span class="layui-nav-more"></span></a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;" layuimini-tab-close="current">关 闭 当 前</a></dd>
                            <dd><a href="javascript:;" layuimini-tab-close="other">关 闭 其 他</a></dd>
                            <dd><a href="javascript:;" layuimini-tab-close="all">关 闭 全 部</a></dd>
                        </dl>
                    </li>
                </ul>
            </li>
        </div>
        <div class="layui-tab-content">
            <div id="layuiminiHomeTabIframe" class="layui-tab-item layui-show"></div>
        </div>
    </div>
</div>