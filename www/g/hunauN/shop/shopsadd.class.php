<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");

define("PAGE_CODE", "shopsadd");

class shopsaddPage extends PageBase
{
	private $_demo_dao;
	public $data;
	public $data1;
	public $store_id;
	public $storename;
	public $area;
	public $boss;
	public $ismeal;
	public $type_id;
	public $tel;
	public $mobile;
	public $qq;
	public $email;
	public $address;
	public $storeinfo;
	public $productinfo;
	public $typename;

	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_smallstore");
		
	}
	
	public function prerend()
	{
		//$this->data = $this->_demo_dao->selectA();
		$this->doSelect();
	}
	
	public function unload()
	{
		
	}
	
	public function doInsert()
	{	
		$this->_demo_dao->setTableName("ce_smallstore");	
		
		$data['storename'] = $this->storename;
		$data['area'] = $this->area;
		$data['boss'] = $this->boss;
		$data['ismeal'] = $this->ismeal;
		$data['type_id'] = $this->type_id;
		$data['tel'] = $this->tel;
		$data['mobile'] = $this->mobile;
		$data['qq'] = $this->qq;
		$data['email'] = $this->email;
		$data['address'] = $this->address;
		$data['storeinfo'] = $this->storeinfo;
		
		
		
		
		require_once _INCLUDE_CLASS_DIR__."/Upload.php";
		$upload = new HTTP_Upload("cn");
		$file = $upload->getFiles("up_file");
		
		if ($file->isValid()) {
		    if($file->getProp('size')>1048576){
								echo '<p class="error">出错了，文件超过了1M</p>';
								return ;
				}			    	
			$file->setValidExtensions(array('gif','jpeg','png','jpg'),'accept');
			$file->setName("uniq");
			$moved = $file->moveTo('./storepicture/');
		    if (!PEAR::isError($moved)) {
		        $filename =  $file->getProp('name');
		    }
		    else {
		        echo $moved->getMessage();
		    }
		} elseif ($file->isMissing()) {
		    echo "No file was provided.";
		} elseif ($file->isError()) {
		    echo $file->errorMsg();
		}
		$data['picture'] = $filename;
		$this->_demo_dao->insert($data);
		$id = $this->_demo_dao->getInsertId();
		
		
		Server::refresh(array('store_id'=>$id,'upimg'=>1 ));		
	}
	
	public function doSelect()
	{
		$this->_demo_dao->setTableName("ce_smallstore_type");
		$this->data1 = $this->_demo_dao->selectA();
		
	}
	
	/*
	
	<?php
require_once "HTTP/Upload.php";

$upload = new HTTP_Upload("cn");
$file = $upload->getFiles("f");

if ($file->isValid()) {
    if($file->getProp('size')>1048576){
						echo '<p class="error">出错了，文件超过了1M</p>';
						return ;
		}			    	
	$file->setValidExtensions(array('gif','jpeg','png','jpg'),'accept');
	$file->setName("uniq");
	$moved = $file->moveTo('uploads/');
    if (!PEAR::isError($moved)) {
        $filename =  $file->getProp('name');
    } else {
        echo $moved->getMessage();
    }
} elseif ($file->isMissing()) {
    echo "No file was provided.";
} elseif ($file->isError()) {
    echo $file->errorMsg();
}
?> 
	
	
	
	
	
	
	
	
	
	*/
	
}