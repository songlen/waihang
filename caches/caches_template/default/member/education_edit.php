<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><link rel="stylesheet" href="statics/plugin/layui/css/layui.css">
    <link rel="stylesheet" href="statics/plugin/layui/css/modules/layer/default/layer.css">
    <script type="text/javascript" src="statics/plugin/layui/lay/modules/layer.js"></script>
    <script type="text/javascript" src="statics/plugin/layui/layui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>placeholder.js"></script>

  
<table class="layui-table">
    <colgroup>
        <col width="170">
        <col width="150">
        <col width="80">
        <col width="80">
        <col width="50">
        <col width="80">
        <col width="50">
        <col width="50">
        <col width="50">
        <col width="">
    </colgroup>
    <thead>
        <tr>
            <th>学校名称</th>
            <th>专业</th>
            <th>入学时间</th>
            <th>毕业时间</th>
            <th>学历</th>
            <th>已取得<br>毕业证</th>
            <th>留学</th>
            <th>民航院校</th>
            <th>最高学历</th>
            <th>操作</th>
        </tr> 
    </thead>
    <tbody>
        <tr>
            <td>人生就像是一场修行</td>
            <td>贤心技术</td>
            <td>2016-11</td>
            <td>2016-11</td>
            <td>大专</td>
            <td>是</td>
            <td>是</td>
            <td>是</td>
            <td>是</td>
            <td>
                <a href="javascript:;" onclick="edit()">修改</a>
                <a href="">删除</a>
            </td>
        </tr>
    </tbody>
</table>


<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
        ,layer = layui.layer
        ,layedit = layui.layedit
        ,laydate = layui.laydate;

        //监听提交
        form.on('submit(submit)');
    })
</script>