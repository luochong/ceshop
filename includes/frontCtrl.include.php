<?php
/**
 *  www.cardii.com
 * 
 *  管理页面头部和尾部的加载、缓存、模块页面加载前的action、 
 * 	
 *  2009年7月17日 luochong
 **/
require_once(_INCLUDE_ROOT_DIR__.'/action/actionbase.class.php');
require_once(_INCLUDE_CLASS_DIR__.'/Cache/Lite/Output.php');
class frontCtrl {
	private  $_header = array();
	private  $_footer = '';	
	private  $_default_header_file = '';
	private  $_pagecode = '';
	private  $_pre_page;//模块名称

	
	private  $_cache ;
	private  $_have_cache = false;
	private  $_start_cache = false;	
	
	private $_debug = false;
	
	
	/**
	 * 构造函数
	 *
	 * @param unknown_type $pagecode
	 * @param unknown_type $default_header_file
	 */
	function __construct($pagecode,$default_header_file){
		
		$this->_pagecode = $pagecode;		
		$this->_pre_page =substr($this->_pagecode,0,4);	
		$this->_default_header_file = $default_header_file;		

	}	
	/**
	 * 添加模块与头部关系
	 *
	 * @param array $pagecode_header
	 * $pagecode_header = array('prepage(4个字母)' => 'header_file')
	 */
	public function setHeaderRule($prepage_header){
		if(is_array($prepage_header)){		
			$this->_header = $prepage_header;		
		}		
	}
	/**
	 * 根据页面代码来加载头部
	 *
	 * @param string $pagecode
	 */
	public function loadHeader(){		
		/*先包含特殊文件要求*/	
		$page_name = $this->_pagecode;				
		if(isset($this->_header[$this->_pre_page])||isset($this->_header[$page_name])){		
			if(is_file(_INCLUDE_ROOT_DIR__.'/'.$this->_header[$page_name])){
						require_once($this->_header[$page_name]);
						$this->setFooterByHeader($this->_header[$page_name]);			
			}elseif($this->_header[$page_name]==''){
						$this->setFooterByHeader('');
			}			 
			elseif(is_file(_INCLUDE_ROOT_DIR__.'/'.$this->_header[$this->_pre_page])){
				
					require_once($this->_header[$this->_pre_page]);
					$this->setFooterByHeader($this->_header[$this->_pre_page]);		
			}
							
		}else{		
			 	require_once($this->_default_header_file);
			 	$this->setFooterByHeader($this->_default_header_file);		
		}	
	}
	
	public function setFooterByHeader($str){
		if($str != '')
			$this->_footer = str_replace('header','footer',$str);
	}	
	public function loadFooter(){		
		if(is_file(_INCLUDE_ROOT_DIR__.'/'.$this->_footer)){
						require_once($this->_footer);
		}					
		
		
	}	
	/**
	 * 页面缓存
	 *
	 */
	public function startCache($second = 10){		
		$this->_start_cache = true;
		$options = array(
		    'cacheDir' =>  _INCLUDE_ROOT_DIR__."/cache/",
		    'lifeTime' => $second,//10秒失效时间
		    'pearErrorMode' => CACHE_LITE_ERROR_DIE
		);
		$this->_cache = new Cache_Lite_Output($options);
		$cache_id = $this->_pagecode;
		$this->_have_cache =$this->_cache->start($cache_id);
		if($this->_have_cache) exit();
	}
	
	
	public function endCache(){		
		if((!$this->_have_cache)&&$this->_start_cache ){			
			$this->_cache->end();			
		}		
	}
	/**
	 *debug  
	 *
	 */
	public function startDebug(){		
		$this->_debug = true;
	}	
	
	public function testValue($mixvar){		
		if($this->_debug){
			flush();
			ob_start();
			print_r($mixvar);
			$str = ob_get_clean();			
			file_put_contents(_INCLUDE_ROOT_DIR__.'/debug/debug.txt',$this->_pagecode.':'.$str."\n",FILE_APPEND);		
		}	
		
	}

	
	
	
	protected function IsLogin(){
		return  isset($_SESSION['user_id']);		
	}	
	
	public function setVisitRule($especial,$all = true){		
		$_visit_map = array();
		$_visit_map['all'] = $all;
		foreach ($especial as $value){			
			$_visit_map[$value] =!$_visit_map['all'];
		}
		//检测模块
		if(isset($_visit_map[$this->_pagecode])?$_visit_map[$this->_pagecode] : $all){
			if(!$this->IsLogin())
					Server::goTologIn();					
		}else{
			//donotting
		}
	}
	/**
	 *根据不同模块执行不同action
	 * 
	 */	
	public function doAction(){		
		$fron_action = _INCLUDE_ROOT_DIR__.'/action/'.$this->_pre_page.'.action.php';
		if(is_file($fron_action)){
				require_once($fron_action);		
				$classname = $this->_pre_page.'Action';
				$this->runAction(new $classname);
		}else{
				require_once(_INCLUDE_ROOT_DIR__.'/action/actionbase.class.php');			
				$this->runAction(new ActionBase);		
		}
	}	
	/**
	 * 调用 action 
	 **/
	protected function runAction(ActionBase $action){		
		$action->doAction();			
	}
	
	/*加密的方法名 rel*/
	public function processAjax(){		
		if(isset($_GET['af'])){
			$function = Globals::authcode($_GET['af'],_KEY_);		
			
			/* 控件  load 之后 的ajax处理*/
			if(isset($_GET['cl'])){
					$control = Globals::authcode($_GET['cl'],_KEY_);		
					require_once(_INCLUDE_CONTROL_DIR__.'\\'.$control.'.class.php');
					$class_name = $control.'control';
					$obj = new $class_name();
					method_exists($obj,$function)?$obj->$function():die('函数不存在');
				/*页面类的ajax调用  prerend 之后*/		
			}elseif(method_exists(Registry::get('page'),$function) or die('函数不存在'))				
					Registry::get('page')->$function();								
			exit();					
		}
	}
	
}