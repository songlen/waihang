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
		// 婚姻状态
		$marital_status = isset($_GET['marital_status']) ? $_GET['marital_status'] : '';
		// 搜索类型
		$searchType = isset($_GET['searchType']) ? $_GET['searchType'] : '';
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
		// 身份证号批量搜索
		$ID_number = isset($_GET['ID_number']) ? $_GET['ID_number'] : '';
		// 职位列表查看应聘者
		$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : '';

		$where = 'language="zh"';
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
				$where .= " and mr.age >= $age_l";
			}
			if($age_r){
				$where .= " and mr.age <= $age_r";
			}
			//毕业日期
			if($graduation_date_l){
				$where .= " and mr.graduation_date >= $graduation_date_l";
			}
			if($graduation_date_r){
				$where .= " and mr.graduation_date <= $graduation_date_r";
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

			if($marital_status){
				$where .= " and mr.marital_status = $marital_status";
			}

			if($ID_number){
				$ID_numbers = preg_replace("/(，)/", ',', $ID_number);
				$ID_numbers = trim($ID_numbers, ',');
				$pos = strpos($ID_numbers, ',');

				if($pos){
					$where .= " and mr.ID_number in ($ID_numbers)";
				} else {
					$where .= " and mr.ID_number = $ID_numbers";
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

		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pernum = 15;
		$limit_start = ($page-1)*$pernum;

		$sql = "SELECT *, re.id  FROM phpcms_recruit_enroll re LEFT JOIN phpcms_member_resume mr on re.member_id=mr.member_id WHERE {$where} order by re.id desc limit {$limit_start}, $pernum";
		$this->db->query($sql);
		$result = $this->db->fetch_array();

		if($_GET['export']){
			if(empty($result)) return false;
			$this->export($where);
		}

		$member_model = pc_base::load_model('member_model');
		if(is_array($result)){
			foreach ($result as &$item) {
				$memberinfo = $member_model->get_one(array('userid'=>$item['member_id']), 'headimg , bodyimg');
				$item['headimg'] = $memberinfo['headimg'];
				$item['bodyimg'] = $memberinfo['bodyimg'];
			}
		}

		$count = $this->db->count();
		$pages = pages($count, $page, $pernum);

		$enums = pc_base::load_config('enums', 'member');
		$recruit_enroll_status = pc_base::load_config('enums', 'recruit_enroll_status');

		pc_base::load_sys_class('form');
		include $this->admin_tpl('enroll_list');
	}

	public function export($where = ''){
		$sql = "SELECT *, re.id  FROM phpcms_recruit_enroll re LEFT JOIN phpcms_member_resume mr on re.member_id=mr.member_id WHERE {$where} order by re.id desc";
		$this->db->query($sql);
		$result = $this->db->fetch_array();

		$enums = pc_base::load_config('enums', 'member');
		
		$csvcontent = "报名号,姓名,姓,名,姓拼音,名拼音,性别,民族,身份证号,出生日期,年龄,所学专业,最高学历,毕业院校,毕业日期,工作年限,政治面貌,婚姻状况,身高,体重,手机号,电话,护照号,护照有效期,现居住地址,户口所在地,存档机构,通讯地址,通讯编码,游泳能力,身上是否有疤痕及纹身,何时可开始工作,母亲姓名,母亲电话,父亲姓名,父亲电话,配偶姓名,配偶电话";

		foreach ($result as $item) {
			extract($item);
			// $fullname = str_replace(array(',', "\r\n", "\r", "\n", ' '), array('，',''), $item['fullname']);
			// $sex = $item['sex'] == '1' ? '男' : '女';
			$csvcontent .= "\r\n"
				.$enroll_number.','
				.$fullname.','
				.$surname.','
				.$firstname.','
				.$surname_spell.','
				.$firstname_spell.','
				.$enums['sex'][$sex].','
				.$enums['nation'][$nation].','
				.$ID_number."\t".','
				.$birthday.','
				.$age.','
				.$profession.','
				.$enums['diploma'][$diploma].','
				.$graduation_university.','
				.$graduation_date.','
				.$work_experience.','
				.$enums['political_outlook'][$political_outlook].','
				.$enums['marital_status'][$marital_status].','
				.$height.','
				.$weight.','
				.$mobile_phone."\t".','
				.$telphone.','
				.$passport_number.','
				.$passport_deadline.','
				.$living_city.','
				.$registered_residence.','
				.$archiving_organization.','
				.$address.','
				.$zip_code.','
				.$swimming_ability.','
				.$scar_tattoo.','
				.$start_work_date.','
				.$mather_name.','
				.$mather_phone.','
				.$father_name.','
				.$father_phone.','
				.$spouse_name.','
				.$spouse_phone
				;
		}

		$csvcontent = mb_convert_encoding($csvcontent,'gb2312','utf-8');
		$filename = '人才库名单.csv';
		$this->doexport($csvcontent, $filename);
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

		$enums = pc_base::load_config('enums');

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