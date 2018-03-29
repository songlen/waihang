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
            <div class="basicinfo">
                <div class="tit"><div class="language"><a <?php if($language=='en') { ?> href="?m=member" <?php } else { ?>class="current"<?php } ?>>中文</a><a <?php if($language=='zh') { ?> href="?m=member&l=en" <?php } else { ?>class="current"<?php } ?>>英文</a></div>完善基本资料</div>
                <form class="layui-form layui-form-en" action="?m=member" method="post">
                    <div class="layui-form-item">
                        <label class="layui-form-label">surname(spell)</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[surname]" value="<?php echo $basicinfo['surname'];?>" lay-verify="required" autocomplete="off" placeholder="surname" class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="info[surname_spell]" value="<?php echo $basicinfo['surname_spell'];?>" lay-verify="required" autocomplete="off" placeholder="surname spell" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">名（拼音）</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[firstname]" value="<?php echo $basicinfo['firstname'];?>" lay-verify="required" autocomplete="off" placeholder="名" class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="info[firstname_spell]" value="<?php echo $basicinfo['firstname_spell'];?>" lay-verify="required" autocomplete="off" placeholder="名拼音" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">性别</label>
                        <div class="layui-input-inline">
                            <?php $n=1; if(is_array($enums[sex])) foreach($enums[sex] AS $k => $v) { ?>
                            <input type="radio" name="info[sex]" value="<?php echo $k;?>" title="<?php echo $v;?>" <?php if($n=='1' || $basicinfo[sex]==="$k") { ?>checked<?php } ?>>
                            <?php $n++;}unset($n); ?>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">身份证号</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[ID_number]" value="<?php echo $basicinfo['ID_number'];?>" lay-verify="required|identity" autocomplete="off" placeholder="身份证号" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">民族</label>
                        <div class="layui-input-inline">
                            <select name="info[nation]" lay-verify="required" placeholder="汉族" lay-search="">
                                <?php $n=1; if(is_array($enums[nation])) foreach($enums[nation] AS $k => $v) { ?>
                                <option value="<?php echo $k;?>" <?php if($basicinfo[nation]==$k) { ?>selected<?php } ?>><?php echo $v;?></option>
                                <?php $n++;}unset($n); ?>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">出生日期</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[birthday]" value="<?php echo $basicinfo['birthday'];?>" id="birthday" lay-verify="date" placeholder="出生日期" autocomplete="off" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">政治面貌</label>
                        <div class="layui-input-block">
                            <?php $n=1; if(is_array($enums[political_outlook])) foreach($enums[political_outlook] AS $k => $v) { ?>
                            <input type="radio" name="info[political_outlook]" value="<?php echo $k;?>" title="<?php echo $v;?>" <?php if($n=='1' || $basicinfo[political_outlook] == $k) { ?>checked<?php } ?>>
                            <?php $n++;}unset($n); ?>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">婚姻状况</label>
                        <div class="layui-input-block">
                            <?php $n=1; if(is_array($enums[marital_status])) foreach($enums[marital_status] AS $k => $v) { ?>
                            <input type="radio" name="info[marital_status]" value="<?php echo $k;?>" title="<?php echo $v;?>" <?php if($n=='1' || $basicinfo[marital_status] == $k) { ?>checked<?php } ?>>
                            <?php $n++;}unset($n); ?>
                        </div>
                    </div>

                   <!--  <div class="layui-form-item">
                       <label class="layui-form-label">矫正视力</label>
                       <div class="layui-input-inline">
                           <input type="text" name="info[vision]" value="<?php echo $basicinfo['vision'];?>" lay-verify="required" autocomplete="off" placeholder="矫正视力" class="layui-input">
                       </div>
                   </div> -->

                    <div class="layui-form-item">
                        <label class="layui-form-label">身高(cm)</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[height]" value="<?php echo $basicinfo['height'];?>" lay-verify="required|number" autocomplete="off" placeholder="身高" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">体重(kg)</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[weight]" value="<?php echo $basicinfo['weight'];?>" lay-verify="required|number" autocomplete="off" placeholder="体重" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">手机号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[mobile_phone]" value="<?php echo $basicinfo['mobile_phone'];?>" lay-verify="required|phone" autocomplete="off" placeholder="手机号" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">家庭电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[telphone]" value="<?php echo $basicinfo['telphone'];?>" lay-verify="required" autocomplete="off" placeholder="家庭电话" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">现居住城市</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[living_city]" value="<?php echo $basicinfo['living_city'];?>" lay-verify="required" autocomplete="off" placeholder="现居住城市" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">户口所在地</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[registered_residence]" value="<?php echo $basicinfo['registered_residence'];?>" lay-verify="required" autocomplete="off" placeholder="户口所在地" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">存档机构</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[archiving_organization]" value="<?php echo $basicinfo['archiving_organization'];?>" lay-verify="required" autocomplete="off" placeholder="存档机构" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">通讯地址</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[address]" value="<?php echo $basicinfo['address'];?>" lay-verify="required" autocomplete="off" placeholder="通讯地址" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">通讯编码</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[zip_code]" value="<?php echo $basicinfo['zip_code'];?>" lay-verify="required" autocomplete="off" placeholder="通讯编码" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">游泳能力</label>
                        <div class="layui-input-inline size410">
                            <input type="text" name="info[swimming_ability]" value="<?php echo $basicinfo['swimming_ability'];?>" lay-verify="required" autocomplete="off" placeholder="游泳能力" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">母亲姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[mother_name]" value="<?php echo $basicinfo['mother_name'];?>" lay-verify="required" autocomplete="off" placeholder="母亲姓名" class="layui-input">
                        </div>
                        <label class="layui-form-label">母亲电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[mother_phone]" value="<?php echo $basicinfo['mother_phone'];?>" lay-verify="required" autocomplete="off" placeholder="母亲电话" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">父亲姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[father_name]" value="<?php echo $basicinfo['father_name'];?>" lay-verify="required" autocomplete="off" placeholder="父亲姓名" class="layui-input">
                        </div>
                        <label class="layui-form-label">父亲电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[father_phone]" value="<?php echo $basicinfo['father_phone'];?>" lay-verify="required" autocomplete="off" placeholder="父亲电话" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">配偶姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[spouse_name]" value="<?php echo $basicinfo['spouse_name'];?>" lay-verify="" autocomplete="off" placeholder="配偶姓名" class="layui-input">
                        </div>
                        <label class="layui-form-label">配偶电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="info[spouse_phone]" value="<?php echo $basicinfo['spouse_phone'];?>" lay-verify="" autocomplete="off" placeholder="配偶电话" class="layui-input">
                        </div>
                    </div>
                    <!-- 提交按钮 -->
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit="" lay-filter="submit">保存</button>
                        </div>
                    </div>

                    <input type="hidden" name="info[language]" value="<?php echo $language;?>">
                    <input type="hidden" name="dosubmit" value="1">
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
            elem: '#birthday',
        });
        //监听提交
        form.on('submit(submit)');
    })
</script>

<?php include template('content', 'footer'); ?>