<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><link rel="stylesheet" href="statics/default/css/member.css">
<link rel="stylesheet" href="statics/plugin/layui/css/layui.css">
<script type="text/javascript" src="statics/plugin/layui/layui.js"></script>
<div class="pad_top20"></div>
<form class="layui-form" action="?m=member&a=language_modify" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">语言</label>
        <div class="layui-input-inline">
            <input type="text" name="info[name]" value="<?php echo $data['name'];?>" placeholder="语言" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">证书</label>
        <div class="layui-input-inline">
            <input type="text" name="info[certificate]" placeholder="证书" value="<?php echo $data['certificate'];?>" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">等级</label>
        <div class="layui-input-inline">
            <input type="text" name="info[level]" placeholder="等级" value="<?php echo $data['level'];?>" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">获得时间</label>
        <div class="layui-input-inline">
            <input type="text" name="info[gettime]" value="<?php if($data[gettime]) { ?><?php echo date('Y-m', strtotime($data[gettime]));?><?php } ?>" id="gettime" placeholder="获得时间" autocomplete="off" class="layui-input" lay-verify="required">
        </div>
    </div>
    <!-- 提交按钮 -->
    <div class="layui-form-item" style="display: none;">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <input type="hidden" name="info[language]" value="<?php echo $language;?>">
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
            elem: '#gettime',
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