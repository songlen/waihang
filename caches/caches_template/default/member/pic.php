<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<?php include template('member', 'top'); ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>placeholder.js"></script>
<div class="container">
    <?php include template('member', 'left'); ?>
    <div class="page_right">
        <div class="current_crumb">
            <div class="crumb">个人中心 > 图像采集</div>
            <div class="category_title">图像采集</div>
        </div>
        <div class="page_content">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>大头照</legend>
                <div class="layui-field-box">
                    <div class="layui-upload">
                        <button type="button" class="layui-btn" id="headimgbtn">上传大头照</button>
                        <div class="layui-upload-list">
                            <img class="layui-upload-img" id="headimg" src="<?php echo $memberinfo['headimg'];?>">
                            <p id="demoText"></p>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="layui-elem-field layui-field-title">
                <legend>全身照</legend>
                <div class="layui-field-box">
                    <div class="layui-upload">
                        <button type="button" class="layui-btn" id="bodyimgbtn">上传全身照</button>
                        <div class="layui-upload-list">
                            <img class="layui-upload-img" id="bodyimg" src="<?php echo $memberinfo['bodyimg'];?>">
                            <p id="demoText"></p>
                        </div>
                    </div>
                </div>
            </fieldset> 
        </div>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    layui.use('upload', function(){
        var $ = layui.jquery
        ,upload = layui.upload;

        //头像上传
        var uploadhead = upload.render({
            elem: '#headimgbtn'
            ,url: '?m=member&a=pic&type=head'
            ,data: {dosubmit:1}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#headimg').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 400){
                    return layer.msg('上传失败');
                }
                //上传成功
                if(res.code == 200){
                    $('#headimg').attr('src', res.data.filepath)
                    layer.msg('上传成功');
                }
            }
            ,error: function(){
                layer.msg('上传失败');
            }
        });

        // 全身照上传
        var uploadhead = upload.render({
            elem: '#bodyimgbtn'
            ,url: '?m=member&a=pic&type=body'
            ,data: {dosubmit:1}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#bodyimg').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 400){
                    return layer.msg('上传失败');
                }
                //上传成功
                if(res.code == 200){
                    $('#bodyimg').attr('src', res.data.filepath)
                    layer.msg('上传成功');
                }
            }
            ,error: function(){
                layer.msg('上传失败');
            }
        })
    });

</script>

<?php include template('content', 'footer'); ?>