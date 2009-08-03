<?php

//******************************************//
///		�û��ؼ����ࡣ
//*****************************************//

require_once("pagebase.class.php");

abstract class ControlBase
{
	protected $__id;			// �ؼ�ID
	protected $__children;		// �ӿؼ�
	
	private $__eventtarget;		// �¼���
	private $__eventcontrol;	// �¼��ؼ�
	private $__eventargument;	// �¼�����
	private $__ispostback;		// �Ƿ�Ϊҳ�����
	public $DBdata;

	function __construct($id =NUll)
	{
		
		$this->__id = $id;
		$this->__children = array();
		
		$this->getPost();
		
		$this->load();
	}
	
	function __destruct()
	{
		$this->unload();
	}
	
	abstract protected function load();
	
	abstract protected function prerend();
	
	abstract protected function unload();
	
	/// [Summary]
	///     ��ʼ���HTMLҳ������
	public function Rend()
	{
		$this->fireEvent();
		
		// ����prerend�������������HTMLҳ��ǰ��Ԥ����
		$this->prerend();

		// ���HTMLҳ��
		$class_name = get_class($this);
		$len = strlen($class_name);
		$basename = strtolower(substr($class_name, 0, $len - 7));
		
		global $page;
		// ����ҳ��php���HTML����
		
		include($basename . ".php");
	}
	
	/// [Summary]
	///     �����ӿؼ���
	/// [Parameter]
	///     �ӿؼ�������
	public function LoadControl($ctrl_class)
	{
		$len = strlen($ctrl_class);
		if ($len <= 7 || strtolower(substr($ctrl_class, $len - 7)) != "control")
		{
			return false;
		}
		
		// ����ӿؼ��Ŀؼ�ID.
		$ctrlid = "ctrl" . count($this->__children);
		if (strlen($this->__id) > 0)
		{
			$ctrlid = $this->__id . "\$" . $ctrlid;
		}
		
		// ���ؿؼ��࣬����ʼ���ؼ�ID
		$basename = strtolower(substr($ctrl_class, 0, $len - 7));
		
		require_once($basename . ".class.php");
		$ctrl = new $ctrl_class($ctrlid);
		$this->__children[$ctrlid] = $ctrl;
		
		return $ctrl;
	}
	
	/// [Summary]
	///     �ж�ҳ���Ƿ��һ�α��򿪡�
	/// [Return]
	///     true - ��һ�δ򿪣� false - �ǵ�һ�δ򿪡�
	protected function isPostBack()
	{
		return $this->__ispostback;
	}
	
	/// [Summary]
	///     ��POST��ȡ����ݣ�������ҳ����ĳ�Ա�С�
	private function getPost()
	{
		
		if (isset($_POST["__eventtarget"]))
		{
			$this->__eventtarget = $_POST["__eventtarget"];
			$this->__ispostback = true;
			unset($_POST["__eventtarget"]);
		}
		else
		{
			$this->__ispostback = false;
		}

		if (isset($_POST["__eventcontrol"]))
		{
			$this->__eventcontrol = $_POST["__eventcontrol"];
			unset($_POST["__eventcontrol"]);
		}

		if (isset($_POST["__eventargument"]))
		{
			$this->__eventargument = $_POST["__eventargument"];
			unset($_POST["__eventargument"]);
		}

		// �����¼��Ŀؼ����Ǳ��ؼ��������������ݽ���Ĺ���		
		if ($this->__id == $this->__eventcontrol)
		{
			foreach ($this as $key => $value)
			{				
				if (isset($_POST[$key]))
				{
					$this->$key = $_POST[$key];
				}				
			}
		}
		$this->DBdata = Globals::arrayToSafe($_POST);
	}
	
	/// [Summary]
	///     ����¼���ƺ��¼������ڷ�����˵�����Ӧ���¼����?��
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
	///     ��ȡ���ؼ���ID
	/// [Return]
	///     �ؼ�ID
	/// [Remark]
	///     �ؼ�ID�ĸ�ʽΪ�� ���ؼ�ID . "$" . "ctrl" . ˳���
	///     ���磺ctrl0$ctrl2
	public function getControlId()
	{
		return $this->__id;
	}

	/// [Summary]
	///     ��ȡ���ؼ���Form��ID
	/// [Return]
	///     FormID
	/// [Remark]
	///     FormID�ĸ�ʽΪ�� �ؼ�ID . "$" . "form"
	///     ���磺ctrl0$ctrl2$form
	public function getFormId()
	{
		return $this->__id ."\$form";
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
	 * 产生AjaxUrl
	 *
	 * @param 访问的函数名 $function_name
	 * @return URL
	 */
	public function makeAjaxUrl($function_name,$arg = NULL){
		$url = $_SERVER['PHP_SELF'];		
		$ctrl_class=get_class($this);
		$len = strlen($ctrl_class);
		$filename =substr($ctrl_class,0,$len - 7);
		/*加密*/
		$url = $url.'?af='.Globals::authcode($function_name,_KEY_).'&cl='.Globals::authcode($filename,_KEY_);
		if(!empty($arg)){
			$url = $this->Makeurl($url,$arg);
		}
		return $url;
	}
	
	/**
	 * 生产携带参数的url
	 * 他将替换已有的参数
	 *
	 * @param URI $uri
	 * @param 参数 $arg
	 * @return URI
	 */
	public  function Makeurl($uri = NULL,$arg){		
		if(!$uri){
			$uri = $_SERVER['REQUEST_URI'];
		}
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
