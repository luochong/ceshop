<?php

//**************************//
//页面基类
//www.cardii.com
//2008-04-05 wzq_pro@163.com
//*************************//

require_once("daofactory.class.php");
require_once("server.class.php");
require_once("globals.class.php");
require_once("userinfo.class.php");
abstract class PageBase
{
	public $title = "";			 // 页面标题
	
	protected $__id;
	protected $__children;
	private   $__eventtarget;		// 事件名
	private   $__eventcontrol;	    // 事件控件
	private   $__eventargument;	    // 事件参数
	private   $__ispostback;
	
	private $__uid;
	
	public $login_userInfo;
	private $__uuser;
	private $__uname;
	private $__uunit;       //集团名称[湖南农业大学]
	private $__user_colege;
	private $__unitCode;    //集团代码[1]
	private $__useradress;
	private $__udept;
	private $__fpage;   //登录来源页面
	
	
    public $id;//主页用户id
	public $is_friend;
	public $group_info; //前端群组信息
	public $friend_info; //前端用户信息
	
	
	public $DBdata;

    private $__userInfo;//
    
    

	function __construct($id = "")    // 构造函数
	{
		print_r($_POST['check']);
		$this->__id = $id;
		$this->__children = array();		
		$this->Initialize();
		$this->getPost();
		$this->setPageGet();
		$this->load();
		$this->fireEvent();
		$this->prerend();	
			
	}
	
	function __destruct()   //  析构函数
	{
		$this->unload();
	}
	
	abstract protected function load();
	
	abstract protected function prerend();
	
	abstract protected function unload();
	
	/// [Summary]
	///     判断页面是否第一次打开
	/// [Return]
	///     true - 第一次打开 false - 非第一次打开
	public function isPostBack()
	{
		return $this->__ispostback;
	}
	
	/// [Summary]
	//   将控件与页面关联在一起
	/// [Parameter]
	///    用户控件对象
	public function LoadControl($ctrl_class)
	{
		$len = strlen($ctrl_class);
		if ($len <= 7 || strtolower(substr($ctrl_class, $len - 7)) != "control")
		{
			return false;
		}
		
		$ctrlid = "ctrl" . count($this->__children);
		if (strlen($this->__id) > 0)
		{
			$ctrlid = $this->__id . "\$" . $ctrlid;
		}
		
		$basename = strtolower(substr($ctrl_class, 0, $len - 7));
		require_once("$basename.class.php");
		$ctrl = new $ctrl_class($ctrlid);
		$this->__children[$ctrlid] = $ctrl;
		
		return $ctrl;
	}
	
	/// [Summary]
	///  页面初始化
	private function Initialize()
	{
	
		$userinfo = Globals::getCurrentLoginUser();
		ini_set('date.timezone','Asia/Shanghai');
		if(isset($userinfo))
		{		
			$this->__userInfo=$userinfo;			
			$this->__uid   = $userinfo->user_id;
			$this->__uuser = $userinfo->user_user;
			$this->__uname = $userinfo->user_name;
		    $this->__unitCode = $userinfo->user_unit;
			$this->__useradress=$userinfo->user_address;
			$this->__uunit = $ret[1];
			$this->__udept = $userinfo->user_dept;			
			$this->__fpage = $userinfo->login_page;	
		}
		else
		{
			
		}
		
	}
	private function checkPagePrivacy($privacy,$is_friend){
		$is_display='Y';
		if(isset($privacy)){
			if($privacy!=1){
				if($privacy==2){
					if(!$is_friend){
						$is_display='N1';
					}
				}elseif ($privacy==3){
					$is_display='N2';
				}
			}
		}
		if($is_display!='Y'){
			$args['ty']='homepage';
			$args['privacy']=$is_display;
			$args['owner']=$this->id;
			Server::redirect('mainxterror',$args);
		}
	}
	
	/// [Summary]
	///  从POST中取出数据,放入页面类的成员中
	private function getPost()
	{		
		
		if (isset($_POST["__eventtarget"]))
		{
			$this->__eventtarget = $_POST["__eventtarget"];
			$this->__ispostback = true;
			
		}
		else
		{
			$this->__ispostback = false;
		}

		if (isset($_POST["__eventcontrol"]))
		{
			$this->__eventcontrol = $_POST["__eventcontrol"];
			
		}

		if (isset($_POST["__eventargument"]))
		{
			$this->__eventargument = $_POST["__eventargument"];
			
		}

		
		
		$this->DBdata = Globals::arrayToSafe($_POST);
		unset($this->DBdata['__eventtarget']);
		unset($this->DBdata['__eventargument']);
		unset($this->DBdata['__eventcontrol']);
		
		if ($this->__id == $this->__eventcontrol)
		{
			foreach ($this as $key => $value)
			{								
				if (isset($_POST[$key]))
				{										
					if(is_array($_POST[$key])){						
						
						$this->$key = $_POST[$key];
			
						
					}else{
						$this->$key = htmlspecialchars($_POST[$key]);
					}
					
				}
			}
		}
	}
	  //*****************************
	  //将页面参数从$_GET中取出并存入类成�?
	  //*****************************
	private function setPageGet(){
	 		foreach ($this as $member=>$memberValue){
	 			if(isset($_GET[$member])){
	 				$this->$member=$_GET[$member];
	 			}
	 	     }
	 } 
	/// [Summary]
	///     根据事件名称和事件参数在服务器端调用相应的事件处理函数。
	private function fireEvent()
	{				
		if ($this->__id == $this->__eventcontrol)
		{
			if (isset($this->__eventtarget) &&
				method_exists($this, $this->__eventtarget))
			{				
				$handle = $this->__eventtarget;				
				$this->$handle($this->__eventargument);
			}
		}
	}

	/// [Summary]
	///    用户登录
	/// [Remark]
	//		
	protected function User_Login()
	{
		Server::redirect("mbr020", array("returl" => $_SERVER["REQUEST_URI"]));
	}

	/// [Summary]
	///     用户注销
	/// [Remark]
	//
	protected function User_Logout()
	{
		Globals::setCurrentLoginUser();
	}

	/// [Summary]
	///     判断用户是否已经登录
	public function IsLogin()
	{
		$userinfo = Globals::getCurrentLoginUser();
		if (isset($userinfo))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	/// [Summary]
	///     获得当前访问用户ID
	public function getUserId()
	{
		return $this->__uid;
	}	
		/// [Summary]
	///     获得当前访问用户信息
	public function getUserInfo()
	{	
		return $this->login_userInfo;
	}	

	/// [Summary]
	///     获得当前访问用户姓名
	public function getUserName()
	{
		return $this->__uname;
	}	
	
	/// [Summary]
	///    获得当前访问用户集团单位名称
	public function getUserUnit()
	{
		return $this->__uunit;
	}
	
	/// [Summary]
	///    获得当前访问用户集团单位代码
	public function getUnitCode()
	{
		return $this->__unitCode;
	}

	/// [Summary]
	///     获得当前登录来源页面
	public function getFpage()
	{
		return $this->__fpage;
	}
	
	/// [Summary]
	///    获得当前访问用户部门id
	public function getUserDept()
	{
		return $this->__udept;
	}
	
	/// [Summary]
	///     获得当前访问用户用户名
	public function getUserUser()
	{
		return $this->__uuser;
	}
		/// [Summary]
	///     获得当前访问用户的住址
	public function getUserAdress()
	{
		return $this->__useradress;
	}
	
	//检测GET参数
	public function checkGetValid($arrayGets){
		if(count($arrayGets)){
			foreach ($arrayGets as $row){
				switch ($row['type']){
					case 'str':$this->checkStrValue($row['value']);break;
					default:$this->checkNumValue($row['value']);break;
				}
			}
		}
	}
	//检测字符串
	public function checkStrValue($str){
		if(empty($str)||!is_string($str)){
			$args['error']='参数传递不合法';
			Server::redirect('mainxterror',$args);
			exit();
		}
	}
	//检测数字
	public function checkNumValue($num){
		if(empty($num)||!is_numeric($num)){
			$args['error']='参数传递不合法';
			Server::redirect('mainxterror',$args);
			exit();
		}
	}
	
	/**
	 * 生成ajax链接
	 *
	 * @param string $function_name
	 * @return string
	 */
	public function makeAjaxUrl($function_name,$arg = NULL){
		$url = $_SERVER['PHP_SELF'];		
		$url = $url.'?af='.Globals::authcode($function_name,_KEY_);		
		if(!empty($arg)){
			$url = $this->Makeurl($url,$arg);
		}
		return $url;
	}
	
	/**
	 * 将关联数组变成成员变量
	 *
	 * @param array $data
	 */
	public function updateData($data){
		foreach ($this as $key => $value)
		{								
				if (isset($data[$key]))
				{					
						$this->$key = $data[$key];					
				}
		}	
	}
	
	
	
	/**
	 * 生产携带参数的url
	 * 他将替换已有的参数
	 *
	 * @param URI $uri
	 * @param 参数 $arg
	 * @return URI
	 */
	public  function Makeurl($uri,$arg){		
		$uri_a = explode('?',$uri);
		if($uri_a[1]){
				$arg_a = explode('&',$uri_a[1]);
				foreach ($arg_a as $v){
					$v= explode('=',$v);			
					$arg_o[$v[0]] = $v[1];			
				}
				$arg = array_merge($arg_o,$arg);
				$uri = $uri_a[0];
		}
		foreach ($arg as $key => $value){
		$str .= '&'.$key.'='.$value;
		}
		$str{0} = '?';
		$uri .=$str;	
		return $uri;
		
	}
}

?>
