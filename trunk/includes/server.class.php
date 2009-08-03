<?php
//**************************//
//������˳��ú���?
//www.cardii.com
//2008-04-05 wzq_pro@163.com
//*************************//

class Server
{
	static public function getPageUrl($page_code)
	{
		$sub = substr($page_code, 0, 4);
		$url = APP_ROOT . "/$sub/$page_code.php";
		return $url;
	}
	
	/// [Summary]
	///     ҳ����ת
	/// [Parameter]
	///     $page_code - ҳ����롣δָ��ҳ�����ʱ��ת����ҳ��
	static public function redirect($page_code = NULL, $args = NULL)
	{		
		
		if (isset($page_code))
		{
			$sub = substr($page_code, 0, 4);
			$url = APP_ROOT . "/$sub/$page_code.php";
		
			if (isset($args))
			{
				$tmp = "";
				foreach ($args as $key => $value)
				{
					$tmp .= "&" . $key . "=" . urlencode($value);
				}
				$url .= "?" . substr($tmp, 1);
			}
			
			
			header("HTTP/1.1 303 See Other");
			header("Location: $url");
			/*
			echo "<script language=javascript>\n";		
			echo "location.assign('$url')\n";
			echo "</script>\n";
			*/
		}
		else
		{
				
			header("HTTP/1.1 303 See Other");
			header("Location: " . APP_ROOT);
			/*
			$url = APP_ROOT;
			echo "<script language=javascript>\n";		
			echo "location.assign('$url')\n";
			echo "</script>\n";
			*/
		}
		
		exit;
		
	}

	/// [Summary]
	///     ҳ����ת
	/// [Parameter]
	///     $url - ֱ����ת��ָ����URL�����ܴ���GET����
	static public function redirectUrl($url, $args = NULL)
	{
		if (isset($url))
		{
			if (isset($args))
			{
				$tmp = "";
				foreach ($args as $key => $value)
				{
					$tmp .= "&" . $key . "=" . urlencode($value);
				}
				$url .= "?" . substr($tmp, 1);
			}
			/*
			header("HTTP/1.1 303 See Other");
			header("Location: $url");
			*/
			echo "<script language=javascript>\n";		
			echo "location.assign('$url')\n";
			echo "</script>\n";
		}
		else
		{
			/*
			header("HTTP/1.1 303 See Other");
			header("Location: " . APP_ROOT);
			*/
			echo "<script language=javascript>\n";		
			echo "location.assign('$url')\n";
			echo "</script>\n";
		}
		
		exit;
	}

	/// [Summary]
	///     ҳ��ˢ��
	static public function refresh($arg = NULL)
	{
		/*
		header("HTTP/1.1 303 See Other");
		header("Location: " . $_SERVER["REQUEST_URI"] . $arg);
		exit;
		*/		
		
		$url = $_SERVER["REQUEST_URI"];
		$p = '';		
		if($arg !=NULL){
				foreach ($arg as $key => $value){
					$p .= '&'.$key.'='.$value;			
				}
				$t = strpos($url,'?');
				if(!$t){
					
					$p{0} = '?';
				}
				$url = $url.$p;
		}	
		echo "<script language=javascript>\n";		
		echo "location.assign('$url')\n";
		echo "</script>\n";
		exit;
				
	  
	  /*
		if (!headers_sent()){    //If headers not sent yet... then do php redirect
        header("HTTP/1.1 303 See Other"); 
        header('Location: '.$url); 
        exit;
    }else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
        echo '<script type="text/javascript">\n';
        echo "location.assign('$url')\n";
        echo '</script>\n';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; 
        exit;
    }
    */
    
		/*
		 $url = $_SERVER["REQUEST_URI"];
		 echo   "<script language=javascript>"; 
  	 echo   "location.href='$url';";
  	 echo   "</script>"; 
		*/
	}

	/// [Summary]
	///     ��ת������ҳ�棬����ʾ������Ϣ
	/// [Parameter]
	///     $errmsg - ������Ϣ
	static public function showError($errmsg)
	{
		//header("HTTP/1.1 303 See Other"); 
		//header("Location: " . APP_ROOT . "/error.php?errmsg=" . urlencode($errmsg)); 
		self::redirectUrl("/error.php?errmsg=" . urlencode($errmsg));		
		exit;
	}
	
	static public function goTologIn(){
		self::redirectUrl('/index.php');		
	}
	
}
?>
