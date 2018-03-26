<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><link rel="stylesheet" href="statics/default/css/member.css">
<link rel="stylesheet" href="statics/plugin/layui/css/layui.css">
<script type="text/javascript" src="statics/plugin/layui/layui.js"></script>
<div class="pad_top20"></div>
<form class="layui-form" action="?m=member&a=education_add" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">学校名称</label>
        <div class="layui-input-inline">
            <input type="text" name="info[school_name]" placeholder="学校名称" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">专业</label>
        <div class="layui-input-inline">
            <input type="text" name="info[major]" placeholder="专业" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">在校时间</label>
        <div class="layui-input-inline">
            <input type="text" name="info[start_time]" id="start_time" placeholder="开始时间" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
        <div class="layui-form-mid">-</div>
        <div class="layui-input-inline">
            <input type="text" name="info[end_time]" id="end_time" placeholder="结束时间" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">学历</label>
        <div class="layui-input-inline">
            <select name="info[diploma]" lay-verify="required">
                <option value="">选择学历</option>
                <?php $n=1; if(is_array($enums[diploma])) foreach($enums[diploma] AS $k => $v) { ?>
                <option value="<?php echo $k;?>"><?php echo $v;?></option>
                <?php $n++;}unset($n); ?>
            </select>
        </div>
        <div class="layui-input-inline"><input type="checkbox" name="info[has_diploma]" title="已取得毕业证"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="checkbox" name="info[study_abroad]" title="留学">
        </div>
        <div class="layui-input-inline">
            <input type="checkbox" name="info[civil _viation]" title="民航院校">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">其他说明</label>
        <div class="layui-input-block" style="width: 410px;">
            <textarea placeholder="其他说明" class="layui-textarea"></textarea>
        </div>
    </div>
    <!-- 提交按钮 -->
    <div class="layui-form-item" style="display: block;">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
        </div>
    </div>
    <input type="hidden" name="dosubmit" value="1">
</form>

<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
        ,layer = layui.layer
        ,layedit = layui.layedit
        ,laydate = layui.laydate;

        //在校时间
        laydate.render({
            elem: '#start_time',
            type: 'month',
        });
        laydate.render({
            elem: '#end_time',
            type: 'month',
        });
        //监听提交
        form.on('submit(submit)');
    })
</script>