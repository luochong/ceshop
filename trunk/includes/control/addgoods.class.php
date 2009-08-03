<?php 
require_once('controlbase.class.php');
require_once("daofactory.class.php");
class addgoodscontrol extends ControlBase {
	private $_demo_dao;
	public $store_data;
	public $brand_data;
	public $page;
	public $cate_select_data;
	public $select = array();
	/*类别属性*/
	public $attribute;//类别属性
	public $gattr;//商品属性
	
		
	

	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getNamedDao('category');
		$this->_demo_dao->setTableName("ce_store");
	
	}
	
	public function prerend()
	{
		switch ($this->page){
				case 'baseinfo' :{
					$this->setStoreData();
					$this->setBaseInfoData();
					$this->setCateData();													
					$this->select[0] = 'selected'; break;
				}
				case 'detailinfo' :{
					$this->getGoodsAttribute();
					$this->getAttributeByType();						
					$this->select[1] = 'selected'; break;
				}
				case 'imginfo' :{	
					
					
					$this->select[2] = 'selected'; break;	
				}
		}
	}	
	public function unload()
	{
		
	}
	/*********************页面加载********************************/
	private function setStoreData(){		
		$data = $this->_demo_dao->simpleFetchList('ce_store',array('store_id','store_name'));		
		foreach ($data as $value){
			$this->store_data[$value[0]] = $value[1];
		}
	
	}
	private function setBaseInfoData(){
		if(!empty($_GET['gid'])){
			$this->_demo_dao->setTableName("ce_goods");
			$temp = $this->_demo_dao->selectA(array('goods_id'=>$_GET['gid']));			
			$this->DBdata = $temp[0];			
		}	
	}	

	/******属性继承****/
	private function getAttributeByType(){
		$tempdata = $this->_demo_dao->simpleFetchList('ce_goods',array('category_id'),array('goods_id' => $_GET['gid']));		
		$cate_id = $tempdata[0][0];
		$node = $this->_demo_dao->getFather($cate_id);		
		$sql = 'select * from ce_category_attribute where 0 or category_id = ?';
		$arg[]=$cate_id;
		foreach ($node as $value){
			$sql .= " or category_id = ? ";
			$arg[]=$value['id'];			
		}			
		$this->attribute = $this->_demo_dao->executeQueryA($sql,$arg);
		
	}
	private function getGoodsAttribute(){		
		$this->gattr = $this->_demo_dao->executeQueryA('select ce_category_attribute.attribute_name,ce_goods_attribute.attribute_value 
			from ce_goods_attribute,ce_category_attribute 
			where ce_goods_attribute.attribute_id = ce_category_attribute.attribute_id 
			and goods_id = ? and goods_type = 1',array($_GET['gid']));		
		
	}
	
	
	/*******************************生产HTML***************************************************/
	/******加载类别数据*****/
	private function setCateData(){		
		$this->cate_select_data = $this->_demo_dao->getCateSelect();
		
	}	
	/**根据数据库类型字段生成表单*/
	public function echoAttrFrom(){		
		foreach ($this->attribute as $value){		
			switch ($value['attribute_type']){
				case 'enum': {						
					echo "{$value['attribute_name']}:<select name=\"atrr[{$value['attribute_id']}]\">";
					echo '<option value="" >...</option>';
					$ary = explode('|',$value['attribute_value']);
						foreach ($ary as $v){
							echo "<option value='$v'>$v</option>";
						}					
					echo '</select>';
					break;					
				}	//end enum			
				
				case 'date':{					
					echo "{$value['attribute_name']}:<input type='text' name='atrr[{$value['attribute_id']}]' onfocus=\"MyCalendar.SetDate(this)\"  onchange=\"check_date(this);\" \>";
					break;
				} //end date
				case 'text':{
					echo "{$value['attribute_name']}:<input type='text' name='atrr[{$value['attribute_id']}]' value = '{$value['attribute_value']}' />";
					break;				
				}		
				
			}		
			echo '<br />';			
		}	
	}	
	//********************事件处理**********************************************//
	public function addBaseInfo(){		
		require_once(_INCLUDE_CLASS_DIR__.'/imgcrop.php');	
		$this->_demo_dao->setTableName("ce_goods");
		
		/**********裁剪生产小图片*********/
		if($this->DBdata['big_img'] == '' || !empty($_FILES['file_img']['name'])){
				$this->DBdata['big_img'] = $this->upload(GOODS_IMG_DIR,true);
				$this->DBdata['small_img'] = 'small'.$this->DBdata['big_img'];
				$imgcrop = new imgcrop();				
				$imgcrop->cropper(GOODS_IMG_DIR.'/'.$this->DBdata['big_img'],GOODS_IMG_DIR.'/'.$this->DBdata['small_img'],array('width'=>GOODS_SMALL_IMG_W,'height'=>GOODS_SMALL_IMG_H));		
		}		
		if(isset($this->DBdata['promote_price'])&&$this->DBdata['promote_price']!=0){
			$this->DBdata['is_promotion'] = 1;
		}elseif(isset($this->DBdata['goods_discount'])&&$this->DBdata['goods_discount']!=0){
			$this->DBdata['is_discount'] = 1;
		}		
		if(empty($_GET['gid'])){//插入			
			
			$this->_demo_dao->insert($this->DBdata);
			Server::refresh(array('gid'=>$this->_demo_dao->getInsertId()));		
		}else{//更新
			$temp = $this->_demo_dao->simpleFetchList('ce_goods',array('small_img','big_img'),array('goods_id'=>$_GET['gid']));
			/*删除原来的图片*/			
			if(!empty($_FILES['file_img']['name'])){	
				unlink(GOODS_IMG_DIR.'/'.$temp[0][0]);
				unlink(GOODS_IMG_DIR.'/'.$temp[0][1]);	
			}		
			$this->_demo_dao->update($this->DBdata,array('goods_id'=>$_GET['gid']));
			Server::refresh();					
		}
				
		
	}
	
	public function addDetailInfo(){
		$this->_demo_dao->setTableName('ce_goods_attribute');
		$temp_attr_id = $this->_demo_dao->simpleFetchList('ce_goods_attribute',array('attribute_id'),array('goods_id'=>$_GET['gid']));
		$attr_id = array();
		foreach ($temp_attr_id as $id){
			$attr_id[] = $id[0];			
		}		
		$data = array();
		foreach ($this->DBdata['atrr'] as $id => $value ){
			if(in_array($id,$attr_id)){
				$data['attribute_value'] = $value;
				$this->_demo_dao->update($data,array('goods_id'=>$_GET['gid'],'attribute_id'=>$id));				
			}else{
				$data['attribute_id'] = $id;
				$data['attribute_value'] = $value;
				$data['goods_type'] = 1;	
				$data['goods_id'] = $_GET['gid'];			
				$this->_demo_dao->insert($data);
			}			
		}
		$this->_demo_dao->setTableName('ce_goods');
		//$this->_demo_dao->update(array('goods_intro'=>$this->DBdata['goods_intro']),array('goods_id'=>$_GET['gid']));
			
	}

	public function addImgInfo(){
		
		$photo_sn = $this->upload(GOODS_IMG_DIR);
		$this->_demo_dao->setTableName("ce_goods");
		$this->_demo_dao->update(array('photo_sn'=>$photo_sn),array('goods_id'=>$_GET['gid']));
	}
	
	/************************ajax事件************************************/
	/*public function getAttribute(){
		$cate_id = $_GET['cid'];
		$this->_demo_dao->setTableName("ce_category_attribute");
		$temp = $this->_demo_dao->selectA(array('category_id'=>$cate_id));
		header('Content-type: application/JSON');
		echo  json_encode($temp);		
	}*/
	
	public function CreateSN(){	
		echo 'CE'.$this->_demo_dao->getNewCode('ce_goods','goods_id',8);	
		
	}
	/*************************工具函数*****************************************/
	/*上传*/
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