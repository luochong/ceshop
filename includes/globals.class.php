<?php
//***********************************************//
///		ȫ�ֶ���
//***********************************************//

require_once("constant.include.php");		
require_once("userinfo.class.php");

class Globals
{
	
	/// [Summary]
	///     ȡ�õ�ǰ��¼�û�
	/// [Return]
	///     �û���Ϣ
	static public function getCurrentLoginUser()
	{
		$userinfo = NULL;
		
		if (isset($_SESSION["user_id"]))
		{			
			//$userinfo = $_SESSION[SESSION_LOGINUSER];
			
			$userinfo->user_id = $_SESSION["user_id"];			
			$userinfo->user_user = $_SESSION["user_user"];
			$userinfo->user_name = $_SESSION["user_name"];
			$userinfo->user_pwd = $_SESSION["user_pwd"];
			$userinfo->user_title = $_SESSION["user_title"];
			$userinfo->user_unit = $_SESSION["user_unit"];
			$userinfo->unit_id = $_SESSION["unit_id"];
			$userinfo->user_dept = $_SESSION["user_dept"];
		    $userinfo->user_address=$_SESSION["user_address"];
			$userinfo->login_page = $_SESSION["login_page"];
			$userinfo->login_time = $_SESSION["login_time"];
			$userinfo->login_ip = $_SESSION["login_ip"];
			$userinfo->end_login_time=$_SESSION["end_login_time"];
		
		}
		
		return $userinfo;
	}
	/// [Summary]
	///     ���õ�ǰ��¼�û�
	/// [Parameter]
	///     �û���Ϣ
	static public function setCurrentLoginUser($userinfo = NULL)
	{		
		
		if (isset($userinfo) && is_object($userinfo) && get_class($userinfo) == "UserInfo")
		{		
			//$_SESSION[SESSION_LOGINUSER] = $userinfo;
			
			$_SESSION["user_id"] = $userinfo->user_id;
			$_SESSION["user_user"] = $userinfo->user_user;
			$_SESSION["user_name"] = $userinfo->user_name;
			$_SESSION["user_pwd"] = $userinfo->user_pwd;
			$_SESSION["user_title"] = $userinfo->user_title;
			$_SESSION["user_unit"] = $userinfo->user_unit;
			$_SESSION["unit_id"] =$userinfo->user_unit;
			$_SESSION["user_dept"] = $userinfo->user_dept;
			$_SESSION["login_page"] = $userinfo->login_page;
			$_SESSION["login_time"] = $userinfo->login_time;
			$_SESSION["login_ip"] = $userinfo->login_ip;
			
			//用户的地址
			$_SESSION["user_address"] = $userinfo->user_address;
		    $_SESSION["end_login_time"] = $userinfo->end_login_time;
		}
		else
		{			
			//unset($_SESSION[SESSION_LOGINUSER]);
			unset($_SESSION["user_id"]);
			unset($_SESSION["user_user"]);
			unset($_SESSION["user_name"]);
			unset($_SESSION["user_pwd"]);
			unset($_SESSION["user_title"]);
			unset($_SESSION["user_unit"]);
			unset($_SESSION["user_dept"]);
			unset($_SESSION["login_page"]);
			unset($_SESSION["login_time"]);
			unset($_SESSION["login_ip"]);	
			unset($_SESSION["user_address"]);
			unset($_SESSION["unit_id"]);	
			unset($_SESSION["end_login_time"]);
			session_destroy();		
		}
	}
	
	/// [Summary]
	///    获取文件大小，以M、K、B的形式
	/// [Parameter]
	///     文件字节数
	public function fetchFileSize($size)
	{
		if($size<1024)
		{
			 $size=$size." B";
		}
		else{
			 $size = $size/1024;
			 if($size<1000){
			 	$size_1 = ceil(number_format($size,0));
			 	$size = $size_1." K";
			 }
			 else{
			 	$size = $size/1024;
				$size_2 = number_format($size,2);
				$size = $size_2." M";
			 }
		}
		return $size;
	}
	
	
	/// [Summary]
	///    获取文档上传的文件夹
	/// [Parameter]
	///    
	static public function getFileUploadPath()
	{
		return FILE_UPLOAD_PATH;
	}

	/// [Summary]
	///     生成 SELECCT 框的 OPTIONS 列表
	/// [Parameter]
	///    $optionData  -- 联想数组
	///    $optionKey   -- select框的选中项
	///    $optionFirstStr   -- 第一个option选项字符
	/// [Return]
	///    
	public function writeSelectOpitions($optionData,$optionKey=null,$optionFirstStr = null)
	{
		$options = "";
		$optionfirststr = "...";		
		if(isset($optionFirstStr)){
			$optionfirststr = $optionFirstStr;
		}
			
		if( !isset($optionKey) ){
			$options .= "<option value='0' selected>$optionfirststr</option>";
		}else{
			$options .= "<option value='0' >$optionfirststr</option>";			
		}
		
		if($optionData != null ){
			foreach ($optionData as $key => $data){
				if($key == $optionKey){
					$options .= "<option value='$key' selected >$data</option>";
				}else{
					$options .= "<option value='$key' >$data</option>";
				}	
			}
		}
				
		return $options;
	}
	

	/// [Summary]
	///    出生年份的 OPTIONS 列表
	/// [Parameter]  	
	///
	static public function birthyOption($key = null)
	{
		$birthy = array();
		$currTime = date("Y")-15;		
		for($i=$currTime;$i>=1960;$i--){
			$birthy[$i] = $i;
		}		
		return Globals::writeSelectOpitions($birthy,$key);
	}
	
	/// [Summary]
	///    时间[月份] OPTIONS 列表
	/// [Parameter]  
	///   
	static public function timeMonthOption($key = null)
	{
		$birthm = array();		
		for($i=1;$i<=12;$i++){
			if($i<=9)$str="0".$i;else $str=$i;
			$birthm[$str] = $str;
		}		
		return Globals::writeSelectOpitions($birthm,$key);
	}
	
	/// [Summary]
	///     时间[日期] OPTIONS 列表
	/// [Parameter]  
	///   
	static public function timeDayOption($key = null)
	{
		$birthd = array();		
		for($i=1;$i<=31;$i++){
			if($i<=9)$str="0".$i;else $str=$i;
			$birthd[$str] = $str;
		}
		return Globals::writeSelectOpitions($birthd,$key);
	}
	
	/// [Summary]
	///     性别的 OPTIONS 列表
	/// [Parameter]  
	///   
	static public function sexOption($key = null)
	{
		$sexData = array("男"=>"男","女"=>"女");
		return Globals::writeSelectOpitions($sexData,$key);
	}
	//民族
	static public function nationArray(){
		$nationData = array("1"=>"汉族","2"=>"蒙古族","3"=>"彝族","4"=>"侗族","5"=>"哈萨克族","6"=>"畲族",
		"7"=>"纳西族","8"=>"仫佬族","9"=>"仡佬族","10"=>"怒族","11"=>"保安族","12"=>"鄂伦春族","13"=>"回族","14"=>"壮族",
		"15"=>"瑶族","16"=>"傣族","17"=>"高山族","18"=>"景颇族","19"=>"羌族","20"=>"锡伯族","21"=>"乌孜别克族","22"=>"裕固族",
		"23"=>"赫哲族","24"=>"藏族","25"=>"布依族","26"=>"白族","27"=>"黎族","28"=>"拉祜族","29"=>"柯尔克孜族","30"=>"布朗族",
		"31"=>"阿昌族","32"=>"俄罗斯族","33"=>"京族","34"=>"门巴族","35"=>"维吾尔族","36"=>"朝鲜族","37"=>"土家族","38"=>"傈僳族",
		"39"=>"水族","40"=>"土族","41"=>"撒拉族","42"=>"普米族","43"=>"鄂温克族","44"=>"塔塔尔族","45"=>"珞巴族","46"=>"苗族",
		"47"=>"满族","48"=>"哈尼族","49"=>"佤族","50"=>"东乡族","51"=>"达斡尔族","52"=>"毛南族","53"=>"塔吉克族","54"=>"德昂族",
		"55"=>"独龙族","56"=>"基诺族"
		);
		return $nationData;
	}
	
	/// [Summary]
	///     民族的 OPTIONS 列表
	/// [Parameter]  
	///   
	static public function nationOption($key = null)
	{
        $nationData=Globals::nationArray();
		return Globals::writeSelectOpitions($nationData,$key);
	}
    //政治面貌
    static public function polityArray(){
    	$polityData = array("1"=>"中共党员","2"=>"中共预备党员","3"=>"共青团员","4"=>"民革会员","5"=>"民盟盟员","6"=>"民建会员",
		"7"=>"民进会员","8"=>"农工党党员","9"=>"致公党党员","10"=>"九三学社社员","11"=>"台盟盟员","12"=>"无党派民主人士",
		"13"=>"群众","14"=>"其他"		
		);
		return $polityData;
    }
	/// [Summary]
	///     政治面貌的 OPTIONS 列表
	/// [Parameter]  
	///   
	static public function polityOption($key = null)
	{
		$polityData = Globals::polityArray();
		return Globals::writeSelectOpitions($polityData,$key);
	}

	
	/// [Summary]
	///     时间[年份] OPTIONS 列表
	/// [Parameter]  	
	///
	static public function timeYearOption($key = null,$startYear = null,$endYear = null,$firstStr = null)
	{
		$timelist = array();
		$currTime = date("Y");		
		if(!isset($startYear))$startYear = 1930;
		if(!isset($endYear))$endYear = $currTime;
		for($i=$endYear;$i>=$startYear;$i--){
			$timelist[$i] = $i;
		}
		return Globals::writeSelectOpitions($timelist,$key,$firstStr);
	}
	
	/// [Summary]
	///     人员类别 OPTIONS 列表
	/// [Parameter]  	
	///
	static public function persKind($key = null)
	{
		$perskind = array("1"=>"教师","2"=>"科研","3"=>"行政管理","4"=>"教辅","5"=>"双肩挑","6"=>"校外聘用");
		
		return Globals::writeSelectOpitions($perskind,$key);
	}
	
	/// [Summary]
	///     最后学历 OPTIONS 列表
	/// [Parameter]  	
	///
	static public function finishSchoolage($key = null)
	{
		$finishschoolage = array("博士研究生"=>"博士研究生","硕士研究生"=>"硕士研究生","本科"=>"本科","大专"=>"大专","中专"=>"中专"
		,"高中"=>"高中","初中"=>"初中","小学"=>"小学");
		
		return Globals::writeSelectOpitions($finishschoolage,$key);
	}
	
	
	/// [Summary]
	///     最高学位 OPTIONS 列表
	/// [Parameter]  	
	///
	static public function finishDegree($key = null)
	{
		$finishdegree = array("博士"=>"博士","硕士"=>"硕士","学士"=>"学士","无"=>"无");		
		return Globals::writeSelectOpitions($finishdegree,$key);
	}
	
	static public function getPath(){
			$curr_url = $_SERVER["PHP_SELF"];
			$count = substr_count($curr_url, "/"); 
	
			$cfgfile = "webapp.ini";
		while ($count > 0)
		{
		if (realpath($cfgfile))
		{
			break;
		}
		$cfgfile = "../$cfgfile";
		$count --;
	}
  
	$pieces = explode("/", $curr_url);
	return $app_root = implode("/", array_slice($pieces, 0, $count)); 
	}
	
	/// [Summary]
	///     省份 OPTIONS 列表
	/// [Parameter]  	
	///
	static public function provinceOptions($key = null)
	{
		
		$url=$_SERVER['DOCUMENT_ROOT'].Globals::getPath().'/xml/data.xml';
		//$url = 'E:\WebSite\sns\xml\data.xml';
		$xml = simplexml_load_file($url);
		foreach ($xml->children() as $chidren){			
			$province["{$chidren["Desc"]}"]=$chidren["Desc"]; 		
		}		
		return Globals::writeSelectOpitions($province,$key);
	}
	/// [Summary]
	///     城市 OPTIONS 列表
	/// [Parameter]  	
	///
	static public function cityOptions($province,$key = null)
	{
		$url=$_SERVER['DOCUMENT_ROOT'].Globals::getPath().'/xml/data.xml';
		$xml = simplexml_load_file($url);
		foreach ($xml->children() as $chidren){			
			if($chidren["Desc"]==$province) 
			{
				foreach($chidren->children() as $lchidren) 	
					$city["{$lchidren["Desc"]}"]=$lchidren["Desc"]; 
				break;				
			}		
		
		}
	return Globals::writeSelectOpitions($city,$key);
	}
	
	
	
	
	
	/// [Summary]
	///     单位/公司/组织 所属行业 OPTIONS 列表
	/// [Parameter]  
	///   
	static public function compkindOption($key = null)
	{
		$compkindData = array(
		"1"=>"教育·培训·科研·院校","2"=>"政府·非营利机构","3"=>"计算机软件","4"=>"计算机硬件·网络设备",
		"5"=>"IT服务·系统集成","6"=>"电子·微电子","7"=>"通信(设备·运营·增值服务)","8"=>"广告·会展·公关","9"=>"房地产开发·建筑与工程",
		"10"=>"房地产服务(中介·物业管理·监理、设计院)","11"=>"家居·室内设计·装潢","12"=>"中介服务(人才·商标专利)","13"=>"专业服务(咨询·财会·法律等)",
		"14"=>"银行","15"=>"保险","16"=>"基金·证券·期货·投资","17"=>"贸易·进出口","18"=>"媒体·出版·文化传播","19"=>"印刷·包装·造纸",
		"20"=>"快速消费品(食品·饮料·日化·烟酒等)","21"=>"耐用消费品(服饰·纺织·家具）","22"=>"家电业","23"=>"办公设备·用品",
		"24"=>"旅游·酒店·餐饮服务","25"=>"批发·零售","26"=>"交通·运输·物流","27"=>"娱乐·运动·休闲","28"=>"制药·生物工程",
		"29"=>"医疗·保健·美容·卫生服务","30"=>"医疗设备·器械","31"=>"环保","32"=>"化工","33"=>"采掘·冶炼","34"=>"能源（电力·石油）·水利",
		"35"=>"仪器·仪表·工业自动化·电气","36"=>"汽车·摩托车(制造·维护·配件·销售·服务)","37"=>"机械制造·机电·重工",
		"38"=>"原材料及加工（金属·木材·橡胶·塑料·玻璃·陶瓷·建材）","39"=>"其他"
		);
		return Globals::writeSelectOpitions($compkindData,$key);
	}
	/// [Summary]
	///     获取当前的日期
	/// [Parameter]  
	///   
	static public function getNowDate(){
		ini_set('date.timezone','Asia/Shanghai');
		return date('Y-m-d');
	}
	/// [Summary]
	///     获取当前的日期和时间
	/// [Parameter]  
	///   
	static public function getNowDateTime(){
		ini_set('date.timezone','Asia/Shanghai');
		return date('Y-m-d H:i:s');
	}
	/// [Summary]
	///     获取当前unix时间戳
	/// [Parameter]  
	///   
	//生日提示
	static public function getDateByMonthAndDay($month,$date){
		ini_set('date.timezone','Asia/Shanghai');
		$today=date('m-d');
		$birthday=$month.'-'.$date;
		$birthdayJianyi=$month.'-'.($date-1);
		if($today==$birthday){
			return '今天';
		}elseif($today==$birthdayJianyi) {
			return '明天';
		}else {
			return $month.'月'.$date.'日';;
		}
		
	}
	static public function getNowTimeUnix(){
		ini_set('date.timezone','Asia/Shanghai');
		return time();
	}
	/// [Summary]
	///     unix时间戳转化成字符串
	/// [Parameter]  
	///   
	static public function getTimeStr($old){
		$now=Globals::getNowTimeUnix();
		$time=$now-$old;
		switch ($time){
			case $time>-1 &&$time<60:return $time.'秒前';break;			
			case $time>=60 && $time<3600:return intval(($time/60)).'分'.($time%60).'秒前';break;
			case $time>=3600 && $time<86400:return intval(($time/3600)).'小时'.intval(($time%3600/60)).'分前';break;
			default:return date('m-d H:i',$old);break;
		}
	}
	/// [Summary]
	///     用户是否在线
	/// [Parameter]  
	///   
	static public function is_online($old){
		$now=Globals::getNowTimeUnix();
		$time=$now-$old;
         if($time<300){
         	return '在线';
         }else {
         	return '离线';
         }
	}
	static public function validEmail($str){
   	   	   if( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)){
   	   	      return false;
   	       }else{
   	        	return true;
   	       }
   }
   	 //将字符串格式化  
   	static public function stringToSafe($str){
 		return htmlspecialchars(addslashes(trim($str)));
 	}
 	//将数组数据格式化
 	static public function arrayToSafe($array=array()){
 		foreach ($array as $key=>$value){
 			if(is_array($value)) $array[$key] = self::arrayToSafe($value);
 			else $array[$key]=Globals::stringToSafe($value);
 		}
 		return $array;
 	}
 	//获取post数据，并将其格式化
 	static public function getPostData($post){
 		unset($post['__eventcontrol']);
     	unset($post['__eventtarget']);
     	unset($post['__eventargument']);
     	return Globals::arrayToSafe($post);
 	}
 	//获取get数据，并格式化
 	 	static public function getGetData($get){
     	return Globals::arrayToSafe($get);
 	}
    /// [Summary]
	///     任务重复频率列表
	/// [Parameter]  
	///   
	static public function repeatTypeOption($key=null){
       $repeat_type_array=array('no'=>'不重复',
                                'day'=>'按天',
                                'week'=>'按周',
                                'month'=>'按月',
                                'year'=>'按年'
                                );
		
		return Globals::writeSelectOpitions($repeat_type_array,$key);
	}
	//搜索类型
	static public function GtdmSearchOption($key=null){
		  $Search_type_array=array('1'=>'所有',
                                '2'=>'标题',
                                '3'=>'地点',
                                );
		
		return Globals::writeSelectOpitions($Search_type_array,$key);
	}
	/// [Summary]
	///     任务重要性列表
	/// [Parameter]  
	///   
	static public function importanceOption($key=null){
    $importance_array =array('4'=>'紧急又重要',
                      '3'=>'重要不紧急',
                      '2'=>'紧急不重要',
                      '1'=>'不重要也不紧急', 
                     );
		
		return Globals::writeSelectOpitions($importance_array,$key);
	}
	/// [Summary]
	///     开放程度列表
	/// [Parameter]  
	///   
	static public function openTypeOption($key=null){
                $open_type_array=array('3'=>'只有我可见',
                                       '2'=>'好友可见',
                                       '1'=>'所有人可见',
                                       );
		
		return Globals::writeSelectOpitions($open_type_array,$key);
	}
	/// [Summary]
	///     群组任务程度列表
	/// [Parameter]  
	///   
	static public function groupOpenTypeOption($key=null){
                $open_type_array=array('3'=>'群内',
                                       '1'=>'公开',
                                       );
		
		return Globals::writeSelectOpitions($open_type_array,$key);
	}
	//星期数组
	static public function weeksArray(){
        $week=array('1'=>'星期一',
                '2'=>'星期二',
                '3'=>'星期三',
                '4'=>'星期四',
                '5'=>'星期五',
                '6'=>'星期六',
                '7'=>'星期天',  ); 	
		return $week;
	}
	/// [Summary]
	///     星期几列表
	/// [Parameter]  
	///   
	static public function weeksOption($key=null){
        $week=Globals::weeksArray();
		return Globals::writeSelectOpitions($week,$key);
	}

    /// [Summary]
	/// 上课节次列表
	/// [Parameter]  
	///   
	static public function courseTimeOption($key=null){
	    $course_time_array=array('1'=>'第一大节',
                       '2'=>'第二大节',
                       '3'=>'第三大节',
                       '4'=>'第四大节',
                       '5'=>'第五大节',  
                         );	
		return Globals::writeSelectOpitions($course_time_array,$key);
	}
	//设置任务执行时间,参数为任务对象
	  static public function setDoTime($taskInfo){
	          	 $start_time=mb_substr($taskInfo->start_time,0,5,'utf-8');
	          	 $end_time=mb_substr($taskInfo->end_time,0,5,'utf-8');
	          	 $do_start_date=mb_substr($taskInfo->do_start_date,5,5,'utf-8');
	          	 $do_end_date=mb_substr($taskInfo->do_end_date,5,5,'utf-8');
	          	 $doweek=Globals::weeksArray();
	          	 $doweek=$doweek[$taskInfo->do_week];
		         if($taskInfo->task_type==1){
			       switch ($taskInfo->repeat_type){
				    case 'no':if($taskInfo->do_start_date==$taskInfo->do_end_date){
					          return  $do_time=$do_start_date.' '.$start_time.'至'.$end_time;
				           }else {
				           	    return $do_time=$do_start_date.' '.$start_time.'至'.$do_end_date.' '.$end_time;
				           }
				       break;
				     case 'day':return $do_time='每天'.$start_time.'至'.$end_time;
				       break;
				    case 'week':return $do_time='每周'.$doweek.' '.$start_time.'至'.$end_time;
				       break;
				    case 'month':return $do_time='每个月的'.$taskInfo->do_date.'日'.' '.$start_time.'至'.$end_time;
				       break;
				    case 'year':return $do_time='每年的'.$taskInfo->do_monthdate.'日'.' '.$start_time.'至'.$end_time; 
			      }
		        }else {
			        return $do_time=$doweek.'&nbsp;第'.$taskInfo->course_time.'大节 '.$start_time.'至'.$end_time;
		        }
	            } 
	/// [Summary]
	///    处理上传
	/// [Parameter]  
	///   
	static public function upload() {
		//上传的类型
		$allowedType = array('image/gif','image/jpeg','image/jpg','image/pjpeg','image/png',
								'html/html','html/htm','text/plain',
								'office/doc','office/xls','office/ppt',
								'pdf/pdf',
								'rar/rar','rar/zip',
								'text/txt',
								'zip/tar','zip/rar','zip/zip','zip/gz'
							);
		$data['upload_name'] = $_FILES['upload']['name'];
		$data['upload_size'] = $_FILES['upload']['size'];
	 	$data['upload_type'] = $_FILES['upload']['type'];
		$today = date('Y-m-d');
		if (!is_dir(FILE_UPLOAD_PATH.'/'.$today)) mkdir(FILE_UPLOAD_PATH.'/'.$today);
		$data['upload_url'] = FILE_UPLOAD_PATH.'/'.$today.'/'.$data['upload_name'];
		if(in_array($data['upload_type'],$allowedType) && $data['upload_size'] < 2048000) {
			$result = move_uploaded_file($_FILES['upload']['tmp_name'],$data['upload_url'] );
			if($result) {
				return $data;
			}
		}		
	}
	static public function mulitUpload() {
		
	}
	/// [Summary]
	///   字符串有格式的输出以html形式呈现
	/// [Parameter]  
	/// 	
	static public function strtohtml($str){	
		$old = array(" ","\n",);
		$new = array("&nbsp;","<br />",);
		$str  =  str_replace($old,$new,$str);	
		return $str;
	}
	/// [Summary]
	///   留言的html传统的格式替代
	/// [Parameter]  
	/// 
	static function ubbReplace($str){
		$ubb_search = array(
		"/\[color=([^\[\<]+?)\](.+?)\[\/color\]/i",
		"/\[url\]([^\[]*)\[\/url\]/i",
		"/\[url=([^\[]*)\](.+?)\[\/url\]/is",
		"/\[b\](.+?)\[\/b\]/i",
		"/\[i\](.+?)\[\/i\]/i",
		"/\[u\](.+?)\[\/u\]/i",
		"/\[emot\]([0-9]+?)\[\/emot\]/i",
		);
		$ubb_replace = array(
		"<span style=\"color: \\1;\">\\2</span>",
		"<a href=\"\\1\" target=\"_blank\">\\1</a>",
		"<a href=\"\\1\" target=\"_blank\">\\2</a>",
		"<strong>\\1</strong>",
		"<em>\\1</em>",
		"<u>\\1</u>",
		"<img src=\"".APP_SKIN."/images/emot/\\1.gif\" />",
		);
		return preg_replace($ubb_search, $ubb_replace, $str);
	}
	/// [Summary]
	///   字符串截取函数
	/// [Parameter]  
	/// 
	static public function strlimt($str, $len){
		
		
		if(mb_strlen($str,"utf-8")>$len){
			$str=mb_substr( $str,0,$len,"utf-8");
			$str.="......";
		}
		
    /*    $i = 0; $j = 0;
        while($i < $width){
                if(strlen(mb_substr($str,$j++,1))>1){
                        $i += 2;
                }else{
                        $i += 1;
                }
        }
        $restr=mb_substr($str, 0, $j);        
        if($str!=$restr) $restr.="......";*/
        return $str;
}
	
		
	
		/// [Summary]
	///     好友类别
	/// [Parameter]  	
	///
	static public function AllfrieType() {
		$frieTypeArray=array( '1'=>'朋友',
		                     '2'=>'大学同学',
		                     '3'=>'高中同学',
		                     '4'=>'初中同学',
		                     '5'=>'小学同学',
		                     '6'=>'亲人',
		                     '7'=>'同事',
		                     '8'=>'其他',
		                     );
	    return $frieTypeArray;
	}
	/// [Summary]
	///     好友类别 OPTIONS 列表
	/// [Parameter]  	
	///
	static public function frieTypeOption($key = null) {
		$frieTypeArray=Globals::AllfrieType();
	    return Globals::writeSelectOpitions($frieTypeArray,$key);
	}
	/// [Summary]
	///     返回好友类别
	/// [Parameter]  	
	///
	static public function getFriendTy($frie_ty){
				$frieTypeArray=Globals::AllfrieType();
		        if(isset($frie_ty)&&$frie_ty!=0){
		        	 return $frieTypeArray[$frie_ty];
		        }else {
		        	return '未分组';
		        }   
	}
	
	//普通群组类型
	static public function groupTypeArray(){
				$groupTypeArray=array('1'=>'兴趣爱好',
							  '2'=>'第二课堂',
							  '3'=>'考试认证',
							  '4'=>'老乡会',
							  '5'=>'游戏',
							  '6'=>'经验交流',
							  '7'=>'其他',
		      );
		      return $groupTypeArray;
	}
	//普通群组类型列表
	static public function groupTypeOption($key = null){
		   $groupTypeArray=Globals::groupTypeArray();
			return Globals::writeSelectOpitions($groupTypeArray,$key);
	}
	static public function AllGpTypeOption($key = null){
		   $groupTypeArray=Globals::groupTypeArray();
		   $new01['102']='热门群组';
		   $new01['103']='最新群组';
		   $new01['100']='社团';
		   $new01['101']='学生会';
		   $AllGpType=$new01+$groupTypeArray;
		   return Globals::writeSelectOpitions($AllGpType,$key);
	}
	//
	//返回群组类型
	static public function getGptype($gp_type,$type_id){
		 $groupTypeArray=Globals::groupTypeArray();
		if($gp_type=='pt'){
			$reg[0]=$type_id;
			$reg[1]=$groupTypeArray[$type_id];
		}elseif ($gp_type=='sht'){
			$reg[0]='100';
			$reg[1]='社团';
		}else {
			$reg[0]='101';
			$reg[1]='学生会';
		}
		return $reg;
	}
	//群组角色
	static public function groupRoleArray(){
			 $groupRoleArray=array(
			                  '1'=>'创建者',
							  '2'=>'管理员',
							  '3'=>'成员',
		      );
		      return $groupRoleArray;
	}
	
	static public function groupBrowOption($edit,$key = null){
		$groupTypeArray=array('1'=>'公开',
							  '2'=>'半公开',	
							  '3'=>'私有',
		);
		if ($edit){
			return Globals::writeSelectOpitions($groupTypeArray,$key);
		}else {
			return $groupTypeArray[$key];
		}
	}
	/// [Summary]
	///    获取用户的群组角色
	/// [Parameter]  	
	///
	static public function getUserGpRoleObj($role_id,$roleArray){
		foreach ($roleArray as $row){
			if($role_id==$row->role_id){
				return $row;
			}
		}
	}

	//学校类型
	static public function schooltyOption($key=null,$rety=1){
		$TypeArray=array('1'=>'大学',
		                 '2'=>'高中',
		                 '3'=>'初中',
		                 '4'=>'小学',
		                     );
		if($rety==1){
			 return Globals::writeSelectOpitions($TypeArray,$key);
		}else {
			return $TypeArray;
		}
	   
	}
	static public function allsearchOption($key){
		$TypeArray=array('1'=>'搜朋友',
		                 '2'=>'搜群组',
		                 '3'=>'搜日程',
		                 '4'=>'搜主题'
		                     );
	    return Globals::writeSelectOpitions($TypeArray,$key);
	}
	static public function groupTopicType(){
		$type = array('1'=>'按回应');
		return Globals::writeSelectOpitions($type);
	}
	//默认头像
	static public function inihead($key){
		$head[0]='userhead/userlogo.jpg';
		$head[2]='userhead/usersmalllogo.jpg';
		$head[1]='grouphead/userlogo.jpg';		
		$head[3]='grouphead/usersmalllogo.jpg';
		return $head[$key];
	}
	  /// [Summary]
	///   群组操作权限集
	/// [Parameter]  	
	///
	static public function getGpPowers(){
           $powers=array('admMember'=>'admMember',//成员管理
                         'appDeal'=>'appDeal',//请求处理
                         'setInfo'=>'setInfo',//基本设置
                         'admDept'=>'admDept',//部门管理
                         'setGphead'=>'setGphead',//群组个性设置
                         'setGpmanager'=>'setGpmanager',//设置管理员
                         'highSet'=>'highSet',//高级设置权,如设立主席，换届等
                         'setHighManager'=>'setHighManager',//高级主管、移动成员
                         'managerNews'=>'managerNews',
                         'downfile'=>'downfile'
                    );
                    return $powers;
	}
	/// [Summary]
	///   群组角色
	/// [Parameter]  	
	///
	static public function getGpRoles(){
           $Roles=array('1'=>'创建者',//根群创建者
                        '2'=>'主席或理事长',//跟群管理员
                        '3'=>'管理员',//跟群管理员
                        '4'=>'部门超级管理员',//主管理员,如部长
                        '5'=>'部门副管理员',//副管理员
                        '6'=>'成员',//副管理员

                    );
                    return $Roles;
	}
    /// [Summary]
	///   群组角色及权限集
	/// [Parameter]  	
	///
	static public function getRolePowers($role_id){
		   $allPowers=Globals::getGpPowers();
		   //主席	
		   $zhuxiPowers=$allPowers;
	       //去掉部分权力
		   unset($zhuxiPowers['highSet']);
		   //管理员
		   $managerPowers[]=$allPowers['admMember'];
		   $managerPowers[]=$allPowers['appDeal'];//
		   $managerPowers[]=$allPowers['setInfo'];//
		   $managerPowers[]=$allPowers['admDept'];//
           $managerPowers[]=$allPowers['setGphead'];//
           $managerPowers[]=$allPowers['setGpmanager'];//
           $managerPowers[]=$allPowers['managerNews'];//
           $managerPowers[]=$allPowers['uploadfile'];//
		   $managerPowers[]=$allPowers['downfile'];//
           //部门超级管理员
           $deptMaPowers[]=$allPowers['admMember'];//
           $deptMaPowers[]=$allPowers['appDeal'];//
           $deptMaPowers[]=$allPowers['setInfo'];//
           $deptMaPowers[]=$allPowers['setGpmanager'];//
           $deptMaPowers[]=$allPowers['managerNews'];//
           $deptMaPowers[]=$allPowers['uploadfile'];//
		   $deptMaPowers[]=$allPowers['downfile'];//
           //部门管理员
           $deptFMaPowers[]=$allPowers['admMember'];//
           $deptFMaPowers[]=$allPowers['setGpmanager'];//
           $deptFMaPowers[]=$allPowers['appDeal'];//
           $deptFMaPowers[]=$allPowers['setInfo'];//
           $deptFMaPowers[]=$allPowers['managerNews'];
           $deptFMaPowers[]=$allPowers['uploadfile'];
           $member = array();
           $RolePowers=array('1'=>$allPowers,//创建者拥有所有权限
                             '2'=>$zhuxiPowers,
                             '3'=>$managerPowers,
                             '4'=>$deptMaPowers,
                             '5'=>$deptFMaPowers,
                             '6'=>$member
                       
                    );
                    return $RolePowers[$role_id];
	}
	/// [Summary]
	///   群组空间大小配置
	/// [Parameter]  	
	///
	static public function groupSpace($group_type) {
		$space =  array('pt'=>'10','sht'=>'20','xsh'=>'20','dept'=>'20');//单位：M
		return $space[$group_type];
	} 
		/// [Summary]
	///   群组空间大小配置
	/// [Parameter]  	
	///
	static public function checkCaptcha($Captcha){
		$Captcha=strtolower($Captcha);
		if(session_is_registered('Captcha')&&$Captcha==$_SESSION['Captcha'])
			return true;
		else 
			return false;		
	}
	
	

	/**
	 * 加密算法 RC4
	 * 对称加密算法
	 * @param string $string 明文
	 * @param string $key    密钥
	 * @return string 密文
	 */
	static public function authcode($string,$key = '') {		
		 $key = md5($key);
		 $key_length = strlen($key);
		 
		 $string = base64_decode($string);
		 $string_length = strlen($string);
		
		 $rndkey = $box = array();
		 $result = '';
		
		 for($i = 0; $i <= 255; $i++) {
		  $rndkey[$i] = ord($key[$i % $key_length]);
		  $box[$i] = $i;
		 }
		
		 for($j = $i = 0; $i < 256; $i++) {
		  $j = ($j + $box[$i] + $rndkey[$i]) % 256;
		  $tmp = $box[$i];
		  $box[$i] = $box[$j];
		  $box[$j] = $tmp;
		 }
		
		 for($a = $j = $i = 0; $i < $string_length; $i++) {
		  $a = ($a + 1) % 256;
		  $j = ($j + $box[$a]) % 256;
		  $tmp = $box[$a];
		  $box[$a] = $box[$j];
		  $box[$j] = $tmp;
		  $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		 }
		 return str_replace('=','', base64_encode($result));
   }
   	/**
	 * 生成唯一ID
	 */
	static public function CreateUniq()
    {
       
        srand((double) microtime() * 1000000);      
        $uniq = uniqid(rand());
        return $uniq;
    }		
}
	



?>
