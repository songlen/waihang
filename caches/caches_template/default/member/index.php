<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<?php include template('member', 'top'); ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>placeholder.js"></script>
<div class="container">
    <?php include template('member', 'left'); ?>
    <div class="page_right">
        <div class="current_crumb">
            <div class="crumb">个人中心 > 基本资料</div>
            <div class="category_title">基本资料</div>
        </div>
        <div class="page_content">
            <div class="basicInfo">
                <form class="layui-form" action="">
                    <div class="layui-form-item">
                        <label class="layui-form-label">姓（拼音）</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[surname]" lay-verify="required" autocomplete="off" placeholder="姓" class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="info[surname_spell]" lay-verify="required" autocomplete="off" placeholder="姓拼音" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">名（拼音）</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[firstname]" lay-verify="required" autocomplete="off" placeholder="名" class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="info[firstname_spell]" lay-verify="required" autocomplete="off" placeholder="名拼音" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">性别</label>
                        <div class="layui-input-inline">
                            <?php $n=1; if(is_array($enums[sex])) foreach($enums[sex] AS $k => $v) { ?>
                            <input type="radio" name="info[sex]" value="{$k]" title="<?php echo $v;?>" <?php if($n=='1') { ?>checked<?php } ?>>
                            <?php $n++;}unset($n); ?>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">身份证号</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[ID_number}" lay-verify="required" autocomplete="off" placeholder="身份证号" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">民族</label>
                        <div class="layui-input-inline">
                            <select name="info[nation]" lay-verify="required" placeholder="汉族" lay-search="">
                                <?php $n=1; if(is_array($enums[nation])) foreach($enums[nation] AS $k => $v) { ?>
                                <option value="<?php echo $k;?>"><?php echo $v;?></option>
                                <?php $n++;}unset($n); ?>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">出生日期</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[birthday]" id="birthday" lay-verify="date" placeholder="出生日期" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">政治面貌</label>
                        <div class="layui-input-block">
                            <?php $n=1; if(is_array($enums[political_outlook])) foreach($enums[political_outlook] AS $k => $v) { ?>
                            <input type="radio" name="info[political_outlook]" value="{$k]" title="<?php echo $v;?>" <?php if($n=='1') { ?>checked<?php } ?>>
                            <?php $n++;}unset($n); ?>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">婚姻状况</label>
                        <div class="layui-input-block">
                            <?php $n=1; if(is_array($enums[marital_status])) foreach($enums[marital_status] AS $k => $v) { ?>
                            <input type="radio" name="info[marital_status]" value="{$k]" title="<?php echo $v;?>" <?php if($n=='1') { ?>checked<?php } ?>>
                            <?php $n++;}unset($n); ?>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">矫正视力</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[vision]" lay-verify="required" autocomplete="off" placeholder="矫正视力" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">身高</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[height]" lay-verify="required|number" autocomplete="off" placeholder="身高" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">体重</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[weight]" lay-verify="required|number" autocomplete="off" placeholder="体重" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">手机号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[phone]" lay-verify="required|phone" autocomplete="off" placeholder="手机号" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">家庭电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[telphone]" lay-verify="required" autocomplete="off" placeholder="家庭电话" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">现居住城市</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[living_city]" lay-verify="required" autocomplete="off" placeholder="现居住城市" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">户口所在地</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[registered_residence]" lay-verify="required" autocomplete="off" placeholder="户口所在地" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">存档机构</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[archiving_organization]" lay-verify="required" autocomplete="off" placeholder="存档机构" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">通讯地址</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[address]" lay-verify="required" autocomplete="off" placeholder="通讯地址" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">通讯编码</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[zip_code]" lay-verify="required" autocomplete="off" placeholder="通讯地址" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">游泳能力</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[swimming_ability]" lay-verify="required" autocomplete="off" placeholder="游泳能力" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">母亲姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[mother_name]" lay-verify="required" autocomplete="off" placeholder="母亲姓名" class="layui-input">
                        </div>
                        <label class="layui-form-label">母亲电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[mother_phone]" lay-verify="required" autocomplete="off" placeholder="母亲电话" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">父亲姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[father_name]" lay-verify="required" autocomplete="off" placeholder="父亲姓名" class="layui-input">
                        </div>
                        <label class="layui-form-label">父亲电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[father_phone]" lay-verify="required" autocomplete="off" placeholder="父亲电话" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">配偶姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[father_name]" lay-verify="" autocomplete="off" placeholder="配偶姓名" class="layui-input">
                        </div>
                        <label class="layui-form-label">配偶电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[father_phone]" lay-verify="" autocomplete="off" placeholder="配偶电话" class="layui-input">
                        </div>
                    </div>
                    <!-- 提交按钮 -->
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                        </div>
                    </div>

                    <input type="hidden" name="language" value="zh">
                </form>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
        ,layer = layui.layer
        ,layedit = layui.layedit
        ,laydate = layui.laydate;

        //出生日期
        laydate.render({
            elem: '#birthday'
        });
        //监听提交
        form.on('submit(demo1)', function(data){
            layer.alert(JSON.stringify(data.field), {
              title: '最终的提交信息'
            })
            return false;
        });
    })
</script>

<?php include template('content', 'footer'); ?>