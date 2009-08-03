<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopsgadd");

class shopsgaddPage extends PageBase
{
	public $store_data;
	public $cate_select_data;
	public $_demo_dao;
	public $g;
	public $id;


	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getNamedDao('category');
		$this->_demo_dao->setTableName("ce_goodsinfo");
	}
	
	public function prerend()
	{
		$this->setCateData();
		$this->setStoreData();
		if($_GET['act'] == 'update'){			
			$this->id= intval($_GET['id']);
			$t = $this->_demo_dao->selectA(array('goodsinfo_id'=>$this->id));		
		}	$this->g = $t[0];
	}
	
	public function unload()
	{
		
	}
	/***********************页面加载**************************/
	private function setStoreData(){		
		$data = $this->_demo_dao->simpleFetchList('ce_smallstore',array('store_id','storename'));		
		foreach ($data as $value){
			$this->store_data[$value[0]] = $value[1];
		}
	
	}
	private function setCateData(){		
		$this->cate_select_data = $this->_demo_dao->getCateSelect();
		
	}	
	/******************事件处理***************************/
	public  function  addGoods(){
		
		$this->DBdata['score'] = 0;
		 if(isset($this->DBdata['f']))	 unset($this->DBdata['f']);
		if(!empty($_FILES['picture']['name'])){
				$this->DBdata['picture'] = $this->upload(SGOODS_IMG_DIR,true);
				$this->DBdata['logo'] = 'small'.$this->DBdata['picture'];
				require_once(_INCLUDE_CLASS_DIR__.'/imgcrop.php');				
				$imgcrop = new imgcrop();				
				$imgcrop->cropper(SGOODS_IMG_DIR.'/'.$this->DBdata['picture'],SGOODS_IMG_DIR.'/'.$this->DBdata['logo'],array('width'=>GOODS_SMALL_IMG_W,'height'=>GOODS_SMALL_IMG_H));		
		}
		if(is_file(SGOODS_IMG_DIR.'/'.$this->DBdata['logo'])){ 
			$this->_demo_dao->insert($this->DBdata);
			Server::redirectUrl('shopsglist.php');
		}
		
	}	
	
	public function updateGoods(){		
		 if(!empty($_FILES['picture']['name'])){
		 			if(isset($this->DBdata['f'])&&$this->DBdata['f']!=''){	 	
						 	if(is_file(SGOODS_IMG_DIR.'/'.$this->DBdata['f'])){
							 	unlink(SGOODS_IMG_DIR.'/'.$this->DBdata['f']);
								unlink(SGOODS_IMG_DIR.'/'.'small'.$this->DBdata['f']);	
						 	}
						 	unset($this->DBdata['f']);		
		 			}
					$this->DBdata['picture'] = $this->upload(SGOODS_IMG_DIR,true);
					$this->DBdata['logo'] = 'small'.$this->DBdata['picture'];
					require_once(_INCLUDE_CLASS_DIR__.'/imgcrop.php');				
					$imgcrop = new imgcrop();				
					$imgcrop->cropper(SGOODS_IMG_DIR.'/'.$this->DBdata['picture'],SGOODS_IMG_DIR.'/'.$this->DBdata['logo'],array('width'=>GOODS_SMALL_IMG_W,'height'=>GOODS_SMALL_IMG_H));		
		}
		if(is_file(SGOODS_IMG_DIR.'/'.$this->DBdata['logo'])){ 
			
			$this->_demo_dao->update($this->DBdata,array('goodsinfo_id'=>$this->id));			
			Server::redirectUrl('shopsglist.php');
		}
	
	}

	/*******************工具函数**********************/
	/**
	 * 多文件上传
	 *
	 * @param 上传目录 $img_dir
	 * @param 是一个文件吗？ $is_one
	 * @return unknown
	 */
	public function upload($img_dir,$is_one = false){		
			require_once(_INCLUDE_CLASS_DIR__.'/Upload.php');
			$upload = new HTTP_Upload("cn");
			$files = $upload->getFiles();			
			$photo_file = '';
			$photo_sn = '';
			$i = 0;
			foreach($files as $file){
			     $i++;
				if (PEAR::isError($file)) {
			        echo $file->getMessage();
			    }			
			    if ($file->isValid()) {
			   	   	if($file->getProp('size')>1048576){
						echo '<p class="error">出错了，文件超过了1M</p>';
						return ;
					}
			    	if($i == 1)	
			 		  $photo_file =   $file->setName("uniq");
			 		  $photo_sn = current(explode('.',$photo_file));			 	   
			 	   	$file->setName($photo_sn."$i");		    	  
			    	$file->setValidExtensions(array('gif','jpeg','png','jpg'),'accept');
			        $dest_name = $file->moveTo($img_dir);
			
			        if (PEAR::isError($dest_name)) {
			            echo $dest_name->getMessage();
			        }
			
			        $real = $file->getProp("real");
			
			    } elseif ($file->isMissing()) {
			        echo "没有文件被选中";
			    } elseif ($file->isError()) {
			        echo $file->errorMsg();
			    }			
			
			}
			if($is_one){
				return $file->getProp('name');
			}else{
				return $photo_file;
			}
			
	}
	
}