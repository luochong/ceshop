<?php

require_once("mysqldao.class.php");
require_once("userinfo.class.php");

class MemberDao extends MysqlDao
{
	
	/// [Summary]
	///     ����û��Ƿ����
	/// [Parameter]
	///     $userid  - �û���¼id
	///     $userpwd - �û���¼����
	public function checkUserExist($userid, $userpwd)
	{
		$sql = "select id,basic_user,basic_name,basic_pwd,";
		$sql .= " basic_title,basic_unit,basic_dept_id,basic_address_home,basic_end_login_r,basic_dept_id,basic_role,basic_state,basic_class
";		
		$sql .= " from sns_pdc_basic ";
		$sql .= " where basic_user = ?";
		
		$argv = array();
		$argv[] = $userid;	
		$rows = $this->executeQuery($sql, $argv);
		
		$ret = array();
		
		if (count($rows) === 0)
		{
			$ret[0] = -1;
			$ret[1] = "用户名不存在";
		}
		else
		{
			
			
			$row = $rows[0];
			
			$userinfo = new UserInfo();
			$userinfo->user_id = $row[0];
			$userinfo->user_user = $row[1];
			$userinfo->user_name = $row[2];
			$userinfo->user_pwd = $row[3];
			$real_password = $row[3];
			$userinfo->user_title = $row[4];
			$userinfo->user_unit  = $row[5];
			$userinfo->user_dept = $row[6];		
			$userinfo->user_address = $row[7];			
            $userinfo->end_login_time = $row[8];
            $userinfo->dept =$row[9];		
			$userinfo->basic_role =$row[10];
			
			$userinfo->class_code =$row[12];
			
			if ($userpwd !== $real_password)
			{
				$ret[0] = -2;
				$ret[1] =  "用户名或密码错误";
			}			
			elseif($row[11]!='1'){
				if($row[11]=='0'){
					$ret[0] = -3;
					$ret[1] ="您的账号已被禁用，请与管理员联系";
				}else{
					$ret[0] = -4;
					$ret[1] ="您的账号还未激活，请先激活";					
				}	
			}			
			else{
				$ret[0] = 1;
				$ret[1] = $userinfo;
			}
		}
		
		return $ret;
}
//修改用户信息
  public function updateUser($data,$where){
  	$this->setTableName('sns_pdc_basic');
  	return $this->update($data,$where);
  }
	

	/// [Summary]
	///     获取用户所在集团的名称
	/// [Parameter]
	///     $unitid  - 用户所在集团id
	public function fetchUnitName($unitid)
	{
		$sql = "select group_name from sns_pdc_group ";
		$sql .= " where id = ?";
		
		$argv = array();
		$argv[] = $unitid;
		$rows = $this->executeQuery($sql, $argv);
		
		$ret = array();

		if (count($rows) == 0){
			$ret[0] = -1;
			$ret[1] = "";
		}else{
			$ret[0] = 0;
			$ret[1] = $rows[0][0];
		}
		
		
		return $ret;
	}
	
	/// [Summary]
	///     修改密码
	/// [Parameter]
	///     $user_id - 用户名
	///     $old_password  - 原来的密码
	///     $new_password  - 重新设置的密码
	public function changePassword($user_id, $old_password, $new_password)
	{
		$sql = "select basic_pwd from sns_pdc_basic where basic_user = ? ";
		$argv = array();
		$argv[] = $user_id;
		$rows = $this->executeQuery($sql,$argv,0,0);
		
		$ret = array();
		if (count($rows) == 0)
		{
			$ret[0] = -1;
			$ret[1] = "系统中不存在此用户";
			//throw new DaoException($ret[1]);
		}
		else
		{
			$row = $rows[0];
			
			if ($row[0] !== $old_password)
			{
				$ret[0] = -2;
				$ret[1] = "请正确输入以前的密码";
				//throw new DaoException($ret[1]);
			}
			else
			{				
				$sql = "update sns_pdc_basic set basic_pwd = ? where basic_user = ?";			
				$argv[0] = $new_password;
				$argv[1] = $user_id;
				$upret = $this->executeNonQuery($sql,$argv);
				if($upret){
					$ret[0] = 0;
					$ret[1] = "密码修改成功";
				}else{
					$ret[0] = -3;
					$ret[1] = "数据库操作失败";
				}				
			}
		}
				
		return $ret;
	}
	
	
	/// [Summary]
	///     查找登录密码
	/// [Parameter]
	///     $user_rname - 用户真实姓名
	///     $user_name  - 用户电子邮箱 登录名
	///     $user_idcard - 用户身份证
	public function findpassword($user_rname,$user_name,$user_idcard)
	{
		$sql = "select basic_name,basic_idcard,basic_pwd from sns_pdc_basic where basic_user = ? ";
		$argv = array();
		$argv[] = $user_name;
		$rows = $this->executeQuery($sql,$argv,0,0);
		
		$ret = array();
		if (count($rows) == 0)
		{
			$ret[0] = -1;
			$ret[1] = "系统中不存在此用户";
			//throw new DaoException($ret[1]);
		}
		else
		{
			$row = $rows[0];
			
			if ($row[0] !== $user_rname)
			{
				$ret[0] = -2;
				$ret[1] = "请正确填写姓名";
				//throw new DaoException($ret[1]);
			}
			else
			{
				if($row[1] !== $user_idcard){
					$ret[0] = -3;
					$ret[1] = "请正确填写你的身份证";
				}
				else
				{									
					$ret[0] = 0;
					$ret[1] = '您的登录密码是：'.$row[2];								
				}
			}
			
		}
				
		return $ret;
	}
	public function updateUserPic($newdata,$where){
		$this->setTableName('sns_pdc_basic');
		return $this->update($newdata,$where);
	}
	public function getUserPic($user_id){
		$user_pic=$this->queryObjectRow("select basic_picture,basic_bigpic,basic_smallpic from sns_pdc_basic where id=$user_id");
		return $user_pic;
	}
	public function is_deptuser($userinfo,$root){
		if($userinfo->basic_role!=1){
			return false;
		}
		if($userinfo->user_unit!=1){
			return false;
		}
		$dept_sub=$userinfo->dept;
		$sql="select count(*) as num from sns_group_dept where (dept_sub='$dept_sub' and dept_father_id=$root) or (dept_sub='$dept_sub' and dept_father_id=0)";
		$num=$this->queryObjectRow($sql)->num;
		echo $num;
		if($num==0){
			return false;
		}else {
			return true;
		}
	}
	public function is_dloginmr($userinfo){
		if($userinfo->basic_role!=1){
			echo '1';
			return false;
		}
		if($userinfo->user_unit!=1){
			echo '2';
			return false;
		}
		echo $sql="select count(*) as num from sns_group_pindex where pindex_basicid='$userinfo->user_user' and pindex_ment='1'";
		$num=$this->queryObjectRow($sql)->num;
		if($num==0){
			echo '3';
			return false;
		}else {
			return true;
		}
	}
	public function updateUerBigPic($user_id,$new_img_name){
		$this->setTableName('sns_pdc_basic');
		$data['basic_bigpic']=$new_img_name;
		$where['id']=$user_id;
		return $this->update($data,$where);
	}
	public function getUserInfo($user_id){
		$sql="select * from sns_pdc_basic where id=$user_id";
		return $this->queryObjectRow($sql);
	}
	public function getUserDept($dept_id){
	   $sql="select dept_name from sns_group_dept where id='$dept_id'";
		return $this->queryObjectRow($sql);
	}
	public function getTodayVisit($user_id){
		ini_set('date.timezone','Asia/Shanghai');
		$today=date('Y-m-d');
		$sql="select count(*) as mum from sns_pub_visit where user_id=$user_id and visit_date='$today'";
		$result=$this->queryObjectRow($sql);
		$result->mum;
		/*if($result->mum < 2){
			return 2;
		}else {*/
			return $result->mum;
		/*}*/
	}
	public function getAllVisit($user_id){
		$sql="select sum(visit_count) as mum from sns_pub_visit where user_id=$user_id";
		$result=$this->queryObjectRow($sql);
		if($result->mum < 2){
			return 2;
		}else {
			return $result->mum;
		}
	}
	public function checkIsFriend($friend_id,$user_id){
		if(!isset($friend_id)){
			return ;
		}
		$sql="select count(*) as num from sns_pub_friend where user_id=$user_id and friend_id=$friend_id and state=3";
	    $row=$this->queryObjectRow($sql);
	    if($row->num==0){
	    	return 0;
	    }else {
	    	return 1;
	    }
	}
	public function getblog_info($user_id){
		$sql="select * from sns_blog_info where user_id=$user_id";
		return $row=$this->queryObjectRow($sql);
	}

	/**
	 * 用户账号激活 匹配姓名 身份证 和学号
	 */
	public function activeUser($basic_name,$basic_type,$basic_idcard) {
		
		if ($basic_type == 'old') {//老生
			
			$sql = "SELECT dict_oldstud.id,ZZMM AS basic_feature,XB AS basic_sex,CSRQ AS birth,BM AS class_name,BYZX AS highschool,XSH AS college,RXNJ AS adminssion,sns_group_dept.dept_sub AS dept_id FROM dict_oldstud,sns_group_dept WHERE XM='$basic_name' AND SFZH = '$basic_idcard' AND XSH = sns_group_dept.id";
		
		} else {//新生 
			
			$sql = "SELECT stud_id AS id,stud_XBM AS basic_sex,stud_CSRQ AS birth,stud_BJ AS class_name,stud_ZXMC AS highschool,stud_XYMC AS college,sns_group_dept.dept_sub AS dept_id FROM dict_stud,sns_group_dept WHERE stud_XM='$basic_name' AND SFZH = '$basic_idcard' AND stud_XYMC = sns_group_dept.id";
		
		}
		
		return $this->queryObjectRow($sql);
	}
	/**
	 * 获得学生表中学生的学院编号
	 *
	 * @param string $basic_name
	 * @param string $basic_type
	 * @param string $basic_idcard
	 * @return object
	 */
	public function getUserCollegeId($basic_name,$basic_type,$basic_idcard){
		if ($basic_type == 'old') {//老生
			
			$sql = "SELECT XSH AS college FROM dict_oldstud WHERE XM='$basic_name' AND SFZH = '$basic_idcard'";
		
		} else {//新生 
			
			$sql = "SELECT stud_XYMC AS college FROM dict_stud WHERE stud_XM='$basic_name' AND SFZH = '$basic_idcard'";
		
		}
		
		return $this->queryObjectRow($sql);		
	}
	
	
	/**
	 * 若发送邮件成功 则更新email和保存随机数de表中
	 * 
	 */
	public function insertNewUserData($basic_email,$password,$basic_idcard,$basic_name,$basic_state,$userdata,$basic_type,$dept_id) {
					
		$time = Globals::getNowTimeUnix();
		
		$data = array('basic_user'=>$basic_email,
					  'basic_idcard'=>$basic_idcard,
					  'basic_pwd'=>$password,
					  'basic_name'=>$basic_name,
					  'basic_state'=>$basic_state,
					  'basic_role'=>'2',
					  'basic_unit'=>'1',
					  'basic_active_time'=>$time,
					  'basic_smallpic'=>Globals::inihead(2),
					  'basic_bigpic'=>Globals::inihead(0),
					  'basic_polity'=>'3',
					  'basic_dept_id'=>$dept_id,
					);
					
		if($basic_type == 'old') {//老生
			/*$birth = trim($userdata->birth);
			$basic_birthy = substr($birth,0,4);
			$basic_birthm = substr($birth,4,2);
			$basic_birthd = substr($birth,6,2);
			$sql = "INSERT INTO sns_pdc_basic SET
					basic_user='$basic_email',
					basic_idcard='$basic_idcard',
					basic_pwd ='$password',
					basic_name='$basic_name',
					basic_state='$basic_state',
					basic_role='2',
					basic_unit='1',
					basic_active_time='$time',
					basic_feature='$userdata->basic_feature',
					basic_sex='$userdata->basic_sex',
					basic_birthy = '$basic_birthy',
					basic_birthm= '$basic_birthm',
					basic_birthd = '$basic_birthd'
					";*/
			//$data['basic_feature'] = $userdata->basic_feature;
			$data['basic_sex'] = $userdata->basic_sex;
			$birth = trim($userdata->birth);
			$data['basic_birthy'] = substr($birth,0,4);
			$data['basic_birthm'] = substr($birth,4,2);
			$data['basic_birthd'] = substr($birth,6,2);
			
		} else {//新生
			$data['basic_sex'] = $userdata->basic_sex == '1' ? '男' : '女';
			$birth = explode('-',trim($userdata->birth));
			$data['basic_birthy'] = $birth[0];
			$data['basic_birthm'] = $birth[1];
			$data['basic_birthd'] = $birth[2];
			
		}
		//echo '<pre>';
		//var_dump($data);
		//echo '</pre>';
		$this->setTableName('sns_pdc_basic');
		
		$this->insert($data);
		return $this->getInsertId();
	}
	/**
	 * 将学校信息写入到数据库
	 * 
	 */
	public function insertDataToSchool($user_id,$userdata,$basic_type) {
		
		if(empty($userdata)) return false;
		
		$time = Globals::getNowDateTime();
		
		//高中学校
		$highschool['user_id'] = $user_id;
		$highschool['school_ty'] = 2;
		$highschool['school_name'] = $userdata->highschool;	
		$highschool['creat_time'] = $time;
		$this->setTableName('sns_pdc_school');
		$this->insert($highschool);	
			
		
		
		//大学		
		if($basic_type == 'old') { 
			//school_dept='$userdata->college',
		//大学入学时间 
		$endy = $userdata->adminssion + 4;
		$sql = "insert into sns_pdc_school set 
				starty='$userdata->adminssion',
				endy='$endy',
				user_id='$user_id',
				school_name='湖南农业大学',
				school_ty='1',
				startm='09',
				endm='07',
				school_class='$userdata->class_name',
				creat_time='$time'";
					
		} else {
			
			$year = date('Y');
			$endy = $year + 4;
			$sql = "insert into sns_pdc_school set 
				starty='$year',
				endy='$endy',
				user_id='$user_id',
				school_name='湖南农业大学',
				school_ty='1',
				startm='09',
				endm='07',
				school_class='$userdata->class_name',
				creat_time='$time'";	
				
		}
		
		$this->executeNonQuery($sql);	
		
		return $this->getInsertId();
	}
	public function checkClassExist($userdata) {
		$sql = "SELECT class_code FROM sns_pdc_class WHERE class_name = '$userdata->class_name'";
		return $this->queryObjectRow($sql);
		
	}
	/**
	 * 插入班级信息
	 * return 班级ID码
	 */
	public function insertDataToClass($userdata) {
		$class = $this->checkClassExist($userdata);
		if($class->class_code) return $class->class_code;
				
		$this->setTableName('sns_pdc_class');
		
		//生成唯一的班级id码
		$class_code = md5(uniqid(microtime(),1));
		
		$data = array(
						'class_dept'=>$userdata->college,
						'class_name'=>$userdata->class_name,
						'class_code'=>$class_code
					);
		$this->insert($data);
		return $this->getInsertId() ? $class_code : false;
		
	}
	/**
	* 	
	*班级ID码更新到basic表中 
	* 
	*/
	public function updateBasicClass($user_id,$class_code) {
		
		$this->setTableName('sns_pdc_basic');

		$data = array('basic_class'=>$class_code);
		$cond = array('id'=>$user_id);
		
		return $this->update($data,$cond);
	}
	
	
	public function updateNewUserData($basic_email,$password,$num,$basic_idcard){
		$time = Globals::getNowTimeUnix();
		$this->setTableName('sns_pdc_basic');
		$data = array('basic_user'=>$basic_email,'basic_pwd'=>$password,'basic_state'=>$num,'basic_active_time'=>$time);
		$cond = array('basic_idcard'=>$basic_idcard);
		return $this->update($data,$cond);
	}
	
	/**
	 * 查找用户根据$id和$basic_lock
	 *
	 * @param unknown_type $id
	 *
	 * @return unknown
	 */
	public function getBasicDataByID($basic_idcard) {
		$sql = "select basic_pwd,basic_user,id,basic_state from sns_pdc_basic where basic_idcard = '$basic_idcard'";
		return $this->queryObjectRow($sql);
	}
	/**
	 * 更新激活字段 basic_block
	 */
	public function ativeUserState($id){
		$time = Globals::getNowTimeUnix();
		$this->setTableName('sns_pdc_basic');
		$data = array('basic_state'=>'1','basic_active_time'=>$time);
		$cond = array('id'=>$id);
		return $update = $this->update($data,$cond);
	}


	//获取隐私设置
	public  function getprivacy_info_info($user_id)
	{
		$sql="select * from sns_pdc_privacy where user_id=$user_id";
		return $row=$this->queryObjectRow($sql);
	}
	/**
	 * 获取邮箱 判断用户激活时 邮箱是否唯一
	 * 
	 */
	public function getUserByEmail($basic_user) {
		$sql = "select id,basic_idcard,basic_state,basic_role,basic_user,basic_active_time from sns_pdc_basic where basic_user = '$basic_user'";
		return $this->queryObjectRow($sql);
	}
	/**
	 * 查找用户是否激活
	 * 
	 */
	public function getUserByIdCard($basic_idcard) {
		$sql = "select id,basic_idcard,basic_state,basic_role,basic_user,basic_active_time from sns_pdc_basic where basic_idcard = '$basic_idcard'";
		return $this->queryObjectRow($sql);
	}



}

?>
