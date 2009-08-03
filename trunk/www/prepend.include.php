<?php
//************************************//
//PHPҳ��ִ��֮ǰ��Ԥ����
//***********************************//
error_reporting(E_ALL ^ E_NOTICE);
define('PAGE_PARSE_START_TIME', microtime());
/** 定义根目录 */
define('_ROOT_DIR__', dirname(__FILE__));
define('_INCLUDE_ROOT_DIR__',_ROOT_DIR__.'/../includes');

define('_INCLUDE_DAO_DIR__',_INCLUDE_ROOT_DIR__ . '/dao');
define('_INCLUDE_CONTROL_DIR__',_INCLUDE_ROOT_DIR__ . '/control');
define('_INCLUDE_STATIC_DIR__',_INCLUDE_ROOT_DIR__ . '/static');
define('_INCLUDE_CLASS_DIR__',_INCLUDE_ROOT_DIR__ . '/classes');
/*加密密钥*/
define('_KEY_','2009Y7M22D');
/** 设置包含路径 */
@set_include_path(get_include_path() . PATH_SEPARATOR .
_INCLUDE_ROOT_DIR__ . PATH_SEPARATOR .
_INCLUDE_ROOT_DIR__ . '/dao'. PATH_SEPARATOR .
_INCLUDE_ROOT_DIR__ . '/control'. PATH_SEPARATOR .
_INCLUDE_ROOT_DIR__ . '/static'. PATH_SEPARATOR .
_INCLUDE_ROOT_DIR__ . '/classes'. PATH_SEPARATOR .
_INCLUDE_ROOT_DIR__ . '/auth'
);

require_once(_INCLUDE_ROOT_DIR__.'/registry.include.php');



if(isset($_GET['test'])&&$_GET['test'] == 'apd') {
	apd_set_pprof_trace();
}
$pre_process = true;              
function initApp()
{		
 	
	if(@function_exists('session_cache_limiter')){
		session_cache_limiter("private, must-revalidate"); 
	}	
	session_start();	
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
	 $app_root = implode("/", array_slice($pieces, 0, $count)); 
	 //$realpath = str_replace('\\','/',realpath($app_root));
	 $realpath=$_SERVER['DOCUMENT_ROOT'];	
	//************
	//ajax路径
	//************
	$ajax_baseurl=$app_root.'/ajax.php/';
	define("AJAX_BASEURL", $ajax_baseurl);
	//*******************	
	define("APP_PATH",$realpath);
	define("APP_ROOT", $app_root);
	define("APP_CFGFILE", $cfgfile);
	define("APP_NAME", "校园平台 卡地");
	//头像文件路径
	define("APP_HEAD", "/p/");
	define("APP_HEAD_PATH",$realpath."/p/");
	define("APP_SKIN", APP_ROOT."/style/");
	define('APP_UPLOAD','D:/updocu_file');
	Global $pre_process;
	$piececount = count($pieces);
	if ($piececount > 1)
	{		 
		$folder = strtolower($pieces[$piececount - 2]);
		$pre_process = ($folder == "pubc" || $folder == "fpdf" || strtolower($_SERVER["PHP_SELF"]) == APP_ROOT."/error.php") ? false : true;
	}
	require_once(_INCLUDE_ROOT_DIR__.'/constant.include.php');

}
initApp();

$page = NULL;

if ($pre_process)
{
	
	try
	{				
		$curr_url = strtolower($_SERVER["PHP_SELF"]);
		$pos = strrpos($curr_url, "/");
		$pos = ($pos >= 0) ? ($pos + 1) : 0;
		$page_name = substr($curr_url, $pos);
		$len = strlen($page_name);
		if ($len > 4 && substr($page_name, $len - 4) == ".php")
		{
			 
			$page_name = substr($page_name, 0, $len - 4)  . ".class.php";			
			if (file_exists($page_name))
			{
				
				require_once($page_name);
				$class_name = PAGE_CODE . "Page";
				
						//echo PAGE_CODE;
				$pre_page=substr(PAGE_CODE,0,4);			
				/*注册变量*/
				Registry::set('page_module' , $pre_page);				
				
				/*加载前端控制类*/
				require('frontCtrl.include.php');		
				
				//参数：页面代码，默认头部；doAction、权限控制
				$frontCtrl = new frontCtrl(PAGE_CODE,'pageheader.include.php');		
				
				/*允许不登陆访问的页面   使用page_code*/
				$allowVisit = array('index','testmysql','test02','demotest');
				
				//$frontCtrl->setVisitRule($allowVisit);		
				/*根据不同模块 加载权限，检测权限 执行模块共有数据查询*/				
				$frontCtrl->doAction();
				/*加载页面类*/
				$page = new $class_name();
								
				Registry::set('page' , $page);
				
				$frontCtrl->processAjax();	
				//echo $page_name;
			}
		}	
		//$frontCtrl->startCache();	
		//$frontCtrl->startDebug();		
		
		/*页面头部设置 优先级别： 当个文件名字 、 4个字符的模块名字 、 默认头部   */
		$perpage_header = array(
			'home'=>'homeheader.include.php',
			'gphv'=>'homeheader.include.php',//模块gohv 加载头部homeheader.include.php
			'logi'=>'',//模块不加载头部
			'blogress' =>'',//页面blogress不加载头部
			'index'=>'',
			'demotest'=>'header.include.php',
			'shop'=>'',
		);
		/*头部的文件名决定尾部     home header .include.php  系统加载的尾部文件名为: home footer .include.php */
		$frontCtrl->setHeaderRule($perpage_header);
		$frontCtrl->loadHeader();
	}
	catch(DaoException $ex)
	{		
		echo $ex->getMessage();
	}
	
}
?>
