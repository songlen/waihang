<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class enroll extends admin {
	private $db;
	function __construct() {
		parent::__construct();

		$this->db = pc_base::load_model('recruit_enroll_model');
	}
	//首页
	public function init() {
		$show_header = $show_dialog = '';
		// 搜索
		// 学历
		$diploma_l = isset($_GET['diploma_l']) ? $_GET['diploma_l'] : '';
		// $diploma_r = isset($_GET['diploma_r']) ? $_GET['diploma_r'] : '';
		// 身高
		$height_l = isset($_GET['height_l']) ? $_GET['height_l'] : '';
		$height_r = isset($_GET['height_r']) ? $_GET['height_r'] : '';
		// 年龄
		$age_l = isset($_GET['age_l']) ? $_GET['age_l'] : '';
		$age_r = isset($_GET['age_r']) ? $_GET['age_r'] : '';
		// 毕业日期
		$graduation_date_l = isset($_GET['graduation_date_l']) ? $_GET['graduation_date_l'] : '';
		$graduation_date_r = isset($_GET['graduation_date_r']) ? $_GET['graduation_date_r'] : '';
		// 空乘经验
		$aviation_experience_l = isset($_GET['aviation_experience_l']) ? $_GET['aviation_experience_l'] : '';
		$aviation_experience_r = isset($_GET['aviation_experience_r']) ? $_GET['aviation_experience_r'] : '';
		// 航空经验
		$flight_experience_l = isset($_GET['flight_experience_l']) ? $_GET['flight_experience_l'] : '';
		$flight_experience_r = isset($_GET['flight_experience_r']) ? $_GET['flight_experience_r'] : '';
		// 性别
		$sex = isset($_GET['sex']) ? $_GET['sex'] : '';
		// 审核状态
		$status = isset($_GET['status']) ? $_GET['status'] : '';
		// 婚姻状态
		$marital_status = isset($_GET['marital_status']) ? $_GET['marital_status'] : '';
		// 搜索类型
		$searchType = isset($_GET['searchType']) ? $_GET['searchType'] : '';
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		// 身份证号批量搜索
		$ID_number = isset($_GET['ID_number']) ? $_GET['ID_number'] : '';
		// 职位列表查看应聘者
		$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : '';

		$where = "language='zh'";
		if($_GET['search']){
			if($diploma_l){
				$where .= " and mr.diploma >= $diploma_l";
			}
			// if($diploma_r){
			// 	$where .= " and mr.diploma <= $diploma_r";
			// }

			if($height_l){
				$where .= " and mr.height >= $height_l";
			}
			if($height_r){
				$where .= " and mr.height <= $height_r";
			}
			if($age_l){
				$y = date('Y');
				$m = date('m');
				$d = date('d');
				$birthday_l = $y-$age_l.'-'.$m.'-'.$d;
				$where .= " and mr.birthday <= '$birthday_l'";
			}
			if($age_r){
				$y = date('Y');
				$m = date('m');
				$d = date('d');
				$birthday_r = ($y-$age_r-1).'-'.$m.'-'.$d;
				$where .= " and mr.birthday > '$birthday_r'";
			}

			//毕业日期
			if($graduation_date_l){
				$where .= " and mr.graduation_date >= '$graduation_date_l'";
			}
			if($graduation_date_r){
				$where .= " and mr.graduation_date <= '$graduation_date_r'";
			}
			// 空乘经验
			if($aviation_experience_l){
				$where .= " and mr.work_experience <= $aviation_experience_l";
			}
			if($aviation_experience_r){
				$where .= " and mr.work_experience <= $aviation_experience_r";
			}
			// 航空经验
			if($flight_experience_l){
				$where .= " and mr.work_experience <= $flight_experience_l";
			}
			if($aviation_experience_r){
				$where .= " and mr.work_experience <= $aviation_experience_r";
			}
			// 空乘经验
			if($flight_experience_r){
				$where .= " and mr.work_experience <= $flight_experience_r";
			}
			if($aviation_experience_r){
				$where .= " and mr.work_experience <= $aviation_experience_r";
			}



			if($sex || $sex == "0"){
				$where .= " and mr.sex = $sex";
			}

			if($status){
				$where .= " and re.status = $status";
			}

			if($marital_status){
				$where .= " and mr.marital_status = $marital_status";
			}

			if($ID_number){
				
				$ID_numbers = explode(' ', trim($ID_number));
				$ID_numbers_temp = '';
				if(is_array($ID_numbers) && !empty($ID_numbers)){
					foreach ($ID_numbers as $item) {
						$ID_numbers_temp .= "'".$item."',";
					}
				}
				$ID_numbers_temp = trim($ID_numbers_temp, ',');
				$pos = strpos($ID_numbers_temp, ',');
				if($pos){
					$where .= " and mr.ID_number in ($ID_numbers_temp)";
				} else {
					$where .= " and mr.ID_number = $ID_numbers_temp";
				}
			}

			if($keyword){
				if($searchType == 'enroll_number'){
					$where .= " and enroll_number = '$keyword'";
				}
				if($searchType == 'fullname'){
					$where .= " and mr.fullname like '%$keyword%'";
				}
				if($searchType == 'email'){
					$where .= " and mr.email = '$keyword'";
				}
				if($searchType == 'passport_number'){
					$where .= " and mr.passport_number = '$keyword'";
				}

				if($searchType == 'registered_residence'){
					$where .= " and mr.registered_residence like '%$keyword%'";
				}
				if($searchType == 'living_city'){
					$where .= " and mr.living_city like '%$keyword%'";
				}
				if($searchType == 'profession'){
					$where .= " and mr.profession like '%$keyword%'";
				}
			}
		}

		if($job_id){
			$where .= " and job_id = $job_id";
		}

		// 分页
		$sql = "SELECT *, re.id  FROM phpcms_recruit_enroll re LEFT JOIN phpcms_member_resume mr on re.member_id=mr.member_id WHERE {$where}";
		$this->db->query($sql);
		$result_for_page = $this->db->fetch_array();
		

		// 一键审核
		if(($job_id && $_GET['pass']) || ($job_id && $_GET['refuse'])){
			$ope_status = $_GET['pass'] ? '2' : '3';
			if(is_array($result_for_page) && !empty($result_for_page)){
				foreach ($result_for_page as $item) {
					$this->db->update(array('status'=>$ope_status), array('id'=>$item['id']));
				}
			}
		}

		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pernum = 20;
		$limit_start = ($page-1)*$pernum;
		$count = count($result_for_page);
		// $count = $this->db->count();
		$pages = pages($count, $page, $pernum);

		$sql = "SELECT *, re.id  FROM phpcms_recruit_enroll re LEFT JOIN phpcms_member_resume mr on re.member_id=mr.member_id WHERE {$where} order by re.id desc limit {$limit_start}, $pernum";

		$this->db->query($sql);
		$result = $this->db->fetch_array();

		// 导出中文简历
		if($_GET['export']){
			if(empty($result)) return false;
			$this->export($where);
		}
		// 导出英文简历
		if($_GET['export_en']){
			if(empty($result)) return false;
			$this->export($where, 'en');
		}

		$member_model = pc_base::load_model('member_model');
		if(is_array($result)){
			foreach ($result as &$item) {
				$memberinfo = $member_model->get_one(array('userid'=>$item['member_id']), 'headimg , bodyimg');
				$item['headimg'] = $memberinfo['headimg'];
				$item['bodyimg'] = $memberinfo['bodyimg'];
			}
		}

		$enums = pc_base::load_config('enums', 'member');
		$recruit_enroll_status = pc_base::load_config('enums', 'recruit_enroll_status');

		pc_base::load_sys_class('form');
		include $this->admin_tpl('enroll_list');
	}

	// 一键审核通过、拒绝
	public function oneTimeExamine($status){

	}

	public function export($where = '', $language='zh'){
		if($language == 'en') $where = str_replace("language='zh'", "language='en'", $where);

		$sql = "SELECT *, re.id  FROM phpcms_recruit_enroll re LEFT JOIN phpcms_member_resume mr on re.member_id=mr.member_id WHERE {$where} order by re.id desc";

		$this->db->query($sql);
		$result = $this->db->fetch_array();

		$enums = pc_base::load_config('enums', 'member');
		
		// $csvcontent = "简历已审,允许面试,报名号,面试地点,报名时间,英文名,姓拼音,名拼音,民族,工作年限,政治面貌,年龄,身高,体重,空乘经验,航空经验,护照有效期,姓名,游泳能力,身上是否有疤痕及纹身,何时可开始工作,性别,毕业日期,身份证号,护照号码,手机,国内座机,邮箱,档案存放地,出生日期,现居住城市,简历批注,父亲姓名,父亲电话,母亲姓名,母亲电话,婚姻状况,配偶姓名（未婚不填）,配偶电话（未婚不填）,户口地址,通讯编码,最高学历、学位,专业,毕业院校,国外住址,国外电话,备注";

		$strTable ='<table width="100%" border="1">';
    	$strTable .= '<tr style="font-weight:bold">';
    	$strTable .= '<td>简历已审</td>';
    	$strTable .= '<td>允许面试</td>';
    	$strTable .= '<td>报名号</td>';
    	$strTable .= '<td>面试地点</td>';
    	$strTable .= '<td>报名时间</td>';
    	$strTable .= '<td>英文名</td>';
    	$strTable .= '<td>姓拼音</td>';
    	$strTable .= '<td>名拼音</td>';
    	$strTable .= '<td>民族</td>';
    	$strTable .= '<td>工作年限</td>';
    	$strTable .= '<td>政治面貌</td>';
    	$strTable .= '<td>年龄</td>';
    	$strTable .= '<td>身高</td>';
    	$strTable .= '<td>体重</td>';
    	$strTable .= '<td>空乘经验（年）</td>';
    	$strTable .= '<td>航空经验（年）</td>';
    	$strTable .= '<td>护照有效期</td>';
    	$strTable .= '<td>姓名</td>';
    	$strTable .= '<td>游泳能力</td>';
    	$strTable .= '<td>身上是否有疤痕及纹身</td>';
    	$strTable .= '<td>何时可开始工作</td>';
    	$strTable .= '<td>性别</td>';
    	$strTable .= '<td>毕业日期</td>';
    	$strTable .= '<td>身份证号</td>';
    	$strTable .= '<td>护照号码</td>';
    	$strTable .= '<td>手机</td>';
    	$strTable .= '<td>国内座机</td>';
    	$strTable .= '<td>邮箱</td>';
    	$strTable .= '<td>档案存放地</td>';
    	$strTable .= '<td>出生日期</td>';
    	$strTable .= '<td>现居住城市</td>';
    	$strTable .= '<td>简历批注</td>';
    	$strTable .= '<td>父亲姓名</td>';
    	$strTable .= '<td>父亲电话</td>';
    	$strTable .= '<td>母亲姓名</td>';
    	$strTable .= '<td>母亲电话</td>';
    	$strTable .= '<td>婚姻状况</td>';
    	$strTable .= '<td>配偶姓名（未婚不填）</td>';
    	$strTable .= '<td>配偶电话（未婚不填）</td>';
    	$strTable .= '<td>户口地址</td>';
    	$strTable .= '<td>通讯编码</td>';
    	$strTable .= '<td>最高学历、学位</td>';
    	$strTable .= '<td>专业</td>';
    	$strTable .= '<td>毕业院校</td>';
    	$strTable .= '<td>国外住址</td>';
    	$strTable .= '<td>国外电话</td>';
    	$strTable .= '<td>备注</td>';
    	$strTable .= '</tr>';

		foreach ($result as $item) {
			extract($item);
			$fullname = str_replace(array(',', "\r\n", "\r", "\n", ' '), array('，',''), $fullname);
			$shenhe = $status == '1' ? '' : '是';
			$yunxumianshi = $status == '2' ? '是' : ($status == '3' ? '否' : '');
			$mianshididian = '';
			if($language == 'zh'){
				$living_city = get_linkage_name($living_province_id).get_linkage_name($living_city_id); // 现居住城市
				$marital_status = $enums['marital_status'][$marital_status]; // 婚姻桩体
				$diploma = $enums['diploma'][$diploma]; // 最高学历、学位
				$swimming_ability = $enums['swimming_ability'][$swimming_ability];
				$political_outlook = $enums['political_outlook'][$political_outlook];
				$nation = $enums['nation'][$nation];
				$sex = $enums['sex'][$sex];
			} else {
				$living_city = get_linkage_name($living_province_id, 'pinyin').get_linkage_name($living_city_id, 'pinyin'); // 现居住城市
				$marital_status = $enums['marital_status_en'][$marital_status]; // 婚姻桩体
				$diploma = $enums['diploma_en'][$diploma]; // 最高学历、学位
				$swimming_ability = $enums['swimming_ability_en'][$swimming_ability];
				$political_outlook = $enums['political_outlook_en'][$political_outlook];
				$nation = $enums['nation_en'][$nation];
				$sex = $enums['sex_en'][$sex];
			}
			
			$foreign_address = ''; // 国外住址
			$foreign_telphone = ''; // 国外电话
			$mark = ''; // 备注


			$strTable .= '<tr>';
			$strTable .= '<td>'.$shenhe.'</td>';// 简历已审
			$strTable .= '<td>'.$yunxumianshi.'</td>';// 允许面试
			$strTable .= '<td style="vnd.ms-excel.numberformat:@">'.substr($enroll_number, -4).'</td>';// 报名号
			$strTable .= '<td>'.$mianshididian.'</td>';// 面试地点
			$strTable .= '<td>'.date('Y/n/j', strtotime($inputtime)).'</td>';// 报名时间
			$strTable .= '<td>'.$foreign_name.'</td>';// 英文名
			$strTable .= '<td>'.$surname_spell.'</td>';// 姓拼音
			$strTable .= '<td>'.$firstname_spell.'</td>';// 名拼音
			$strTable .= '<td>'.$nation.'</td>';// 民族
			$strTable .= '<td>'.$work_experience.'</td>';// 工作年限
			$strTable .= '<td>'.$political_outlook.'</td>';// 政治面貌
			$strTable .= '<td>'.$age.'</td>';// 年龄
			$strTable .= '<td>'.$height.'</td>';// 身高
			$strTable .= '<td>'.$weight.'</td>';// 体重
			$strTable .= '<td>'.$aviation_experience.'</td>';// 体重
			$strTable .= '<td>'.$flight_experience.'</td>';// 体重
			$strTable .= '<td>'.$passport_deadline.'</td>';// 护照有效期
			$strTable .= '<td>'.$fullname.'</td>';// 姓名
			$strTable .= '<td>'.$swimming_ability.'</td>';// 游泳能力
			$strTable .= '<td>'.$scar_tattoo.'</td>';// 身上是否有疤痕及纹身
			$strTable .= '<td>'.date('Y/n/j', strtotime($start_work_date)).'</td>';// 何时可开始工作
			$strTable .= '<td>'.$sex.'</td>';// 性别
			$strTable .= '<td>'.date('Y/n/j', strtotime($graduation_date)).'</td>';// 毕业日期
			$strTable .= '<td style="vnd.ms-excel.numberformat:@">'.$ID_number.'</td>';// 身份证号
			$strTable .= '<td>'.$passport_number.'</td>';// 护照号码
			$strTable .= '<td>'.$mobile_phone.'</td>';// 手机
			$strTable .= '<td>'.$telphone.'</td>';// 国内座机
			$strTable .= '<td>'.$email.'</td>';// 邮箱
			$strTable .= '<td>'.$archiving_organization.'</td>';// 档案存放地
			$strTable .= '<td>'.date('Y/n/j', strtotime($birthday)).'</td>';// 出生日期
			$strTable .= '<td>'.$living_city.'</td>';// 现居住城市
			$strTable .= '<td>'.$annotation.'</td>';// 简历批注
			$strTable .= '<td>'.$father_name.'</td>';// 父亲姓名
			$strTable .= '<td>'.$father_phone.'</td>';// 父亲电话
			$strTable .= '<td>'.$mother_name.'</td>';// 母亲姓名
			$strTable .= '<td>'.$mother_phone.'</td>';// 母亲电话
			$strTable .= '<td>'.$marital_status.'</td>';// 婚姻状况
			$strTable .= '<td>'.$spouse_name.'</td>';// 配偶姓名（未婚不填）
			$strTable .= '<td>'.$spouse_phone.'</td>';// 配偶电话（未婚不填）
			$strTable .= '<td>'.$address.'</td>';// 户口地址
			$strTable .= '<td>'.$zip_code.'</td>';// 通讯编码
			$strTable .= '<td>'.$diploma.'</td>';// 最高学历、学位
			$strTable .= '<td>'.$profession.'</td>';// 专业
			$strTable .= '<td>'.$graduation_university.'</td>';// 毕业院校
			$strTable .= '<td>'.$foreign_address.'</td>';// 国外住址
			$strTable .= '<td>'.$foreign_telphone.'</td>';// 国外电话
			$strTable .= '<td>'.$mark.'</td>';// 备注
			$strTable .= '</tr>';
		}
		$strTable .= '</table>';
		// $csvcontent = mb_convert_encoding($csvcontent,'gbk','utf-8');
		$filename = '人才库名单';
		downloadExcel($strTable, $filename);
	}

	public function doexport($content, $filename){

		header('Pragma: public');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Encoding: none');
		header('Content-Disposition: attachment; filename='.$filename);

		echo $content;
		exit();
	}

	public function detail(){
		$id = $_GET['id'];

		$language = isset($_GET['language']) ? $_GET['language'] : 'zh';

		$recruit_enroll_model = pc_base::load_model('recruit_enroll_model');
		$recruit_enterprise_model = pc_base::load_model('recruit_enterprise_model');
		$member_model = pc_base::load_model('member_model');
		$member_resume_model = pc_base::load_model('member_resume_model');
		$member_education_model = pc_base::load_model('member_education_model');
		$member_work_model = pc_base::load_model('member_work_model');
		$member_language_model = pc_base::load_model('member_language_model');

		$enrollinfo = $recruit_enroll_model->get_one(array('id'=>$id));

		// 获取公司logo
		$sql = "select re.logo from phpcms_recruit_job rj left join phpcms_recruit_enterprise re on rj.enterprise_id = re.id where rj.id={$enrollinfo['job_id']}";
		$recruit_enterprise_model->query($sql);
		$logo = $recruit_enterprise_model->fetch_array();

		$logo = $logo[0]['logo'];

		// 获取基本信息
		$basicinfo = $member_resume_model->get_one(array('member_id'=>$enrollinfo['member_id'], 'language'=>$language));

		// 头像
		$memberinfo = $member_model->get_one(array('userid'=>$enrollinfo['member_id']), 'headimg');
		// 教育经历
		$educationlist = $member_education_model->select(array('member_id'=>$enrollinfo['member_id'], 'language'=>$language), '*', '', 'start_time desc, end_time desc');
		// 工作经历
		$worklist = $member_work_model->select(array('member_id'=>$enrollinfo['member_id'], 'language'=>$language), '*', '', 'start_time desc, end_time desc');
		// 外语经历
		$languagelist = $member_language_model->select(array('member_id'=>$enrollinfo['member_id'], 'language'=>$language), '*', '', 'id desc');
		// 如果是英文简历，英文名和中文名抓取中文简历里填写的
		$name = $member_resume_model->get_one(array('member_id'=>$enrollinfo['member_id'], 'language'=>'zh'), 'fullname, foreign_name');

		$enums = pc_base::load_config('enums', 'member');

		$show_header = false;

		if($language == 'zh'){
			if($_GET['resume'] == '1'){
				include template('member', 'personalResume');
			} else {
				include $this->admin_tpl('enroll_detail');
			}
		} elseif($language == 'en'){
			if($_GET['resume'] == '1'){
				include template('member', 'personalResume_en');
			} else {
				include $this->admin_tpl('enroll_detail_en');
			}
		}

	}

	public function statistics(){
		$id = $_GET['id'];

		$count = $this->db->count(array('job_id' => $id));

		$enums = pc_base::load_config('enums', 'member');
		$enums_sex = $enums['sex'];
		$enums_diploma = $enums['diploma'];

		if($count){
			// 按日统计
			$sql = "select date(inputtime) day, count(1) count from phpcms_recruit_enroll re left join phpcms_member_resume mr on re.member_id=mr.member_id where re.job_id={$id} and mr.language='zh' group by date(inputtime)";
			$this->db->query($sql);
			$result = $this->db->fetch_array();
			if(!empty($result)){
				foreach ($result as $v) {
					$day_x[] = $v['day'];
					$day_y[] = $v['count'];
				}
				$day_x_data = json_encode($day_x);
				$day_y_data = json_encode($day_y);
			}

			// 统计男女
			$sql = "select sex, count(1) count from phpcms_recruit_enroll re left join phpcms_member_resume mr on re.member_id=mr.member_id where re.job_id={$id} and mr.language='zh' group by sex";
			$this->db->query($sql);
			$result = $this->db->fetch_array();
			foreach ($enums_sex as $k => $v) {
				$sex_data[$k] = array(
					'value' => 0,
					'name' => $v,
				);
			}
			if(!empty($result)){
				foreach ($result as $v) {
					$sex_data[$v['sex']]['value'] = $v['count'];
				}
			}
			$sex_data = json_encode(array_values($sex_data));

			// 按学历统计
			$sql = "select diploma, count(1) count from phpcms_recruit_enroll re left join phpcms_member_resume mr on re.member_id=mr.member_id where re.job_id={$id} and mr.language='zh' group by diploma";

			$this->db->query($sql);
			$result = $this->db->fetch_array();

			foreach ($enums_diploma as $k => $v) {
				$diploma_data[$k] = array(
					'value' => 0,
					'name' => $v,
				);
			}
			// p($result);
			if(!empty($result)){
				foreach ($result as $v) {
					$diploma_data[$v['diploma']]['value'] = $v['count'];
				}
			}

			$diploma_data = json_encode(array_values($diploma_data));

			// 按现居住地（省份）
			$sql = "select living_province_id, count(1) count from phpcms_recruit_enroll re left join phpcms_member_resume mr on re.member_id=mr.member_id where re.job_id={$id} and mr.language='zh' group by living_province_id";

			$this->db->query($sql);
			$result = $this->db->fetch_array();

			if(!empty($result)){
				foreach ($result as $v) {
					if($v['living_province_id'] == ''){
						$living_x[] = '未知';
					} else{
						$living_x[] = get_linkage($v['living_province_id'], 1, '', 2);
					}
					
					$living_y[] = $v['count'];
				}
				$living_x_data = json_encode($living_x);
				$living_y_data = json_encode($living_y);
			}
		
			// 按户口所在地（省份）
			$sql = "select hukou_province_id, count(1) count from phpcms_recruit_enroll re left join phpcms_member_resume mr on re.member_id=mr.member_id where re.job_id={$id} and mr.language='zh' group by hukou_province_id";

			$this->db->query($sql);
			$result = $this->db->fetch_array();

			if(!empty($result)){
				foreach ($result as $v) {
					if($v['hukou_province_id'] == ''){
						$hukou_x[] = '未知';
					} else{
						$hukou_x[] = get_linkage($v['hukou_province_id'], 1, '', 2);
					}
					
					$hukou_y[] = $v['count'];
				}
				$hukou_x_data = json_encode($hukou_x);
				$hukou_y_data = json_encode($hukou_y);
			}


		}

		include $this->admin_tpl('enroll_statistics');
	}

	// 批量审批
	public function check(){
		if($_POST['dosubmit']){
			$ids = isset($_POST['ids']) ? $_POST['ids'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$status = $_POST['status'];

			$where = to_sqls($ids, '', 'id');

			$this->db->update(array('status'=>$status), $where);
			showmessage('操作成功', HTTP_REFERER, '', 'check');
		} else {

			$ids = isset($_GET['ids']) ? $_GET['ids'] : showmessage(L('illegal_parameters'), HTTP_REFERER);
			$ids = explode(',', trim($ids, ','));

			$enroll_status = pc_base::load_config('enums', 'recruit_enroll_status');
			include $this->admin_tpl('enroll_check');
		}
	}

	public function ajax_change_status(){
		$id = $_GET['id'];
		$status = $_GET['status'];

		$recruit_enroll = pc_base::load_model('recruit_enroll_model');
		$recruit_enroll->update(array('status'=>$status), array('id'=>$id));

	}

	public function ajax_update_annotation(){
		$id = $_GET['id'];
		$annotation = $_GET['annotation'];

		$this->db->update(array('annotation'=>$annotation), array('id'=>$id));
	}
}