<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?><?php include template('content', 'header'); ?>

<div class="ch"></div>
<div class="container">
	<div class="page_content">
		<div class="page_title"><?php echo $title;?></div>
		<?php echo $content;?>
	</div>
	<div id="form_box">
		<form class="layui-form" action="" method="get">
			<input type="hidden" name="m" value="recruit">
			<input type="hidden" name="a" value="enroll">
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">职位名称</label>
					<div class="layui-input-inline">
						<select name="job_id">
							<option value="">请选择职位</option>
							<?php $n=1;if(is_array($jobs)) foreach($jobs AS $r) { ?>
							<option value="<?php echo $r['id'];?>"><?php echo $r['job_name'];?></option>
							<?php $n++;}unset($n); ?>
						</select>
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
					<button class="layui-btn" style="background: #d0161b;" lay-submit="" lay-filter="demo1">应聘职位</button>
				</div>
			</div>
		</form>	
	</div>

</div>

<link rel="stylesheet" href="statics/plugin/layui/css/layui.css">
<style type="text/css">
	.layui-form-select dl dd.layui-this {background: #d0161b;}
</style>
<script type="text/javascript" src="statics/plugin/layui/layui.js"></script>
<script type="text/javascript">
	layui.use('form', function(){
		var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
	});      
     
</script>
<?php include template('content', 'footer'); ?>