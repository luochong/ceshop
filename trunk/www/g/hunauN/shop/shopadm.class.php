<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopadm");
class shopadmPage extends PageBase
{
	private $_demo_dao;
	public $sstore_data;
	public $store_data;
	public $adss;
	public $type;
	
	
	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_advertisement");
	}
	
	public function prerend()
	{	
		
		$this->setSStoreData();
		$this->setStoreData();
		if(isset($_GET['ftype'])&&$_GET['ftype']=='0'){
			
			$type = intval($_GET['type']);
			$this->getSAD("AND ad_type = '$type'");	
			$this->getAD('');		
		}elseif($_GET['ftype']==1){
			$type = intval($_GET['type']);
			$this->getAD("AND ad_type = '$type'");
			$this->getSAD('');	
		}else{			
			$this->getSAD('');	
			$this->getAD("");
		}
		
		
		
		
		
		
		
		
	}
	
	public function unload()
	{
		
	
	}
	
	public function getSAD($cond){
		$sql = 'select ce_advertisement.*,ce_smallstore.storename AS store_name from ce_advertisement LEFT JOIN ce_smallstore
ON ce_advertisement.store_id = ce_smallstore.store_id where ad_ftype = 0 '.$cond.' order by sort ASC ';
		$this->adss = $this->_demo_dao->executeQueryA($sql);		
		
	}
	public function getAD($cond){
		$sql = 'select ce_advertisement.*,ce_store.store_name  from ce_advertisement LEFT JOIN ce_store
ON ce_advertisement.store_id = ce_store.store_id where ad_ftype = 1 '.$cond.' order by sort ASC ';
		$this->ads = $this->_demo_dao->executeQueryA($sql);	
		
		
	}
	private function setSStoreData(){		
		$data = $this->_demo_dao->simpleFetchList('ce_smallstore',array('store_id','storename'));		
		foreach ($data as $value){
			$this->sstore_data[$value[0]] = $value[1];
		}
	
	}
	
	private function setStoreData(){		
		$data = $this->_demo_dao->simpleFetchList('ce_store',array('store_id','store_name'));		
		foreach ($data as $value){
			$this->store_data[$value[0]] = $value[1];
		}
	
	}
	
	public function addAD(){
		if($this->DBdata['ad_type'] === '0'){
			require_once _INCLUDE_CLASS_DIR__."/Upload.php";
			$upload = new HTTP_Upload("cn");
			$file = $upload->getFiles("info");			
			if ($file->isValid()) {
			    if($file->getProp('size')>1048576){
						echo '<p class="error">出错了，文件超过了1M</p>';
						return ;
					}			    	
				$file->setValidExtensions(array('gif','jpeg','png','jpg'),'accept');
				$file->setName("uniq");
				$moved = $file->moveTo(AD_IMG_DIR);
			    if (!PEAR::isError($moved)) {
			        $this->DBdata['info'] =  $file->getProp('name');
			    	$this->_demo_dao->insert($this->DBdata);
			    }
			    else {
			        echo $moved->getMessage();
			    }
			} elseif ($file->isMissing()) {
			    echo "No file was provided.";
			} elseif ($file->isError()) {
			    echo $file->errorMsg();
			}			
		}else{			
			$this->_demo_dao->insert($this->DBdata);
			
		}
	}
	public function msort($id){
		$a = explode(':',$id);
		$this->_demo_dao->update(array('sort'=>$a[0]),array('adver_id'=>$a[1]));
		
	}
	

	
	
}

?>
