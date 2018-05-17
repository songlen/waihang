<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<style type="text/css">

</style>

<script type="text/javascript" src="statics/plugin/echart/echarts.min.js"></script>
<div class="pad-lr-10">

	<div class="table-list">
	<div class="common-form">
		<fieldset>
			<legend>基本信息</legend>

		</fieldset>


		<div class="bk15"></div>
		<fieldset>
			<legend>统计结果：总报名人数 <?php echo $count; ?>人</legend>
			<table width="100%" class="">
				<tr>
					<td><div id="sex" style="width: 300px; height: 300px;"></div></td>
					<td><div id="diploma" style="width: 300px; height: 300px;"></div></td>
				</tr>
				<tr>
					<td colspan="2"><div id="day" style="width: 100%; height: 300px;"></div></td>
				</tr>

				<tr>
					<td colspan="2"><div id="living_province" style="width: 100%; height: 300px;"></div></td>
				</tr>

				<tr>
					<td colspan="2"><div id="hukou_province" style="width: 100%; height: 300px;"></div></td>
				</tr>
			</table>
		</fieldset>

	</div>
	<div class="bk15"></div>
	<input type="button" class="dialog" name="dosubmit" id="dosubmit" onclick="window.top.art.dialog({id:'modelinfo'}).close();"/>
	</div>
</div>

<script type="text/javascript">
		// 按男女
		var option = null;
		option = {
	    	title : {
	    	    text: '男女比例',
	    	    x:'center',
	    	},
	    	tooltip : {
	    	    trigger: 'item',
	    	    // formatter: "{a} <br/>{b} : {c} ({d}%)",
	    	    formatter: "{b}{c}人<br />{d}%",
	    	},
	    	series : [
	    	    {
	    	        name: '',
	    	        type: 'pie',
	    	        radius : '60%',
	    	        center: ['50%', '60%'],
	    	        itemStyle:{
	    	        	normal:{
	    	        		label:{
	    	        			show:false // 隐藏标注文字
	    	        		},
	    	        		labelLine:{
	    	        			show:false // 隐藏标示线
	    	        		}
	    	        	}
	    	        },
	    	        data:<?php echo $sex_data; ?>
	    	        
	    	    }
	    	],
		};

		var pie_sex = echarts.init(document.getElementById("sex"));
	    pie_sex.setOption(option, true);		

	    // 按学历统计
	    option = {
	    	title : {
	    	    text: '最高学历',
	    	    x:'center',
	    	},
	    	tooltip : {
	    	    trigger: 'item',
	    	    // formatter: "{a} <br/>{b} : {c} ({d}%)",
	    	    formatter: "{b}{c}人<br />{d}%",
	    	},
	    	series : [
	    	    {
	    	        name: '',
	    	        type: 'pie',
	    	        radius : '60%',
	    	        center: ['50%', '60%'],
	    	        itemStyle:{
	    	        	normal:{
	    	        		label:{
	    	        			show:false // 隐藏标注文字
	    	        		},
	    	        		labelLine:{
	    	        			show:false // 隐藏标示线
	    	        		}
	    	        	}
	    	        },
	    	        data:<?php echo $diploma_data;?>
	    	        
	    	    }
	    	],
		};

		var pie_diploma = echarts.init(document.getElementById("diploma"));
	    pie_diploma.setOption(option, true);

	    // 按天统计
	    option = {

	    	title : {
	    	    text: '按日统计',
	    	    x:'center',
	    	},
			color: ['#3398DB'],
			tooltip : {
			    trigger: 'axis',
			    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
			        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
			    }
			},
			grid: {
			    left: '3%',
			    right: '4%',
			    bottom: '3%',
			    containLabel: true
			},
			xAxis : [
			    {
			        type : 'category',
			        data : <?php echo $day_x_data;?>,
			        axisTick: {
			            alignWithLabel: true
			        }
			    }
			],
			yAxis : [
			    {
			        type : 'value'
			    }
			],
			series : [
			    {
			        name:'报名人数',
			        type:'bar',
			        barWidth: '60%',
			        data:<?php echo $day_y_data;?>
			    }
			]
		};

		var line_day = echarts.init(document.getElementById("day"));
	    line_day.setOption(option, true);

	    // 按居住地统计
	    option = {

	    	title : {
	    	    text: '居住地',
	    	    x:'center',
	    	},
			color: ['#3398DB'],
			tooltip : {
			    trigger: 'axis',
			    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
			        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
			    }
			},
			grid: {
			    left: '3%',
			    right: '4%',
			    bottom: '3%',
			    containLabel: true
			},
			xAxis : [
			    {
			        type : 'category',
			        data : <?php echo $living_x_data;?>,
			        axisTick: {
			            alignWithLabel: true
			        }
			    }
			],
			yAxis : [
			    {
			        type : 'value'
			    }
			],
			series : [
			    {
			        name:'报名人数',
			        type:'bar',
			        barWidth: '60%',
			        data:<?php echo $living_y_data;?>
			    }
			]
		};

		var line_day = echarts.init(document.getElementById("living_province"));
	    line_day.setOption(option, true);
	    // 按户口所在地统计
	    option = {

	    	title : {
	    	    text: '户口所在地',
	    	    x:'center',
	    	},
			color: ['#3398DB'],
			tooltip : {
			    trigger: 'axis',
			    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
			        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
			    }
			},
			grid: {
			    left: '3%',
			    right: '4%',
			    bottom: '3%',
			    containLabel: true
			},
			xAxis : [
			    {
			        type : 'category',
			        data : <?php echo $hukou_x_data;?>,
			        axisTick: {
			            alignWithLabel: true
			        }
			    }
			],
			yAxis : [
			    {
			        type : 'value'
			    }
			],
			series : [
			    {
			        name:'报名人数',
			        type:'bar',
			        barWidth: '60%',
			        data:<?php echo $hukou_y_data;?>
			    }
			]
		};

		var line_day = echarts.init(document.getElementById("hukou_province"));
	    line_day.setOption(option, true);

</script>
</body>
</html>