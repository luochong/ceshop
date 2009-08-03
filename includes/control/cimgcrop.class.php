<?php 
/**
 * www.cardii.com
 * 图片裁剪控件
 * QQ:65771534
 * 7.25  12:28
 */
require_once('controlbase.class.php');
require_once(_INCLUDE_CLASS_DIR__.'/Upload.php');

/**
 * 使用方法
 * 		$ctrl = $page->LoadControl("cimgcropControl");	
		//绑定数据库表
 		$ctrl->sql_table_name = 'ce_store';
		$ctrl->sql_column = 'store_logo';
		$ctrl->sql_cond = array('store_id' => 1);
		//图片名称前缀名
		$ctrl->img_name_prex ='storelogo';
		$ctrl->img_dir = 'storelogo';
		//其它设置
		$ctrl->Rend();
		unset($ctrl);
 *
 */
class cimgcropcontrol extends ControlBase {
	/*控件参数*/
	public $sql_table_name;  //数据库字段绑定
	public $sql_column;
	public $sql_cond = array();
	public $img_name_prex = ''; //文件前缀
	public $img_dir = '';//存储路径
	public $img_url = '';
	public $img_width = 110;
	public $img_height = 50;	
	public $img_max_width =400 ;
	public $img_max_height=300 ;	
	/*end 控件参数*/
	
	
	private $_demo_dao;
	
	
	/*流程控制*/
	public  $_is_upload = false;//标记
	public  $_is_cropper = false;
	/*post*/
	public  $img_file;
	public $xywh;
	public $token;
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		

	}
	
	public function prerend()
	{	//防止重复提交
		if($this->img_url == ''){$this->img_url == $this->img_dir;}
		if(isset($this->token))		$_SESSION['token'] = $this->token;
		
		if(!($this->_is_upload||$this->_is_cropper)){
			$img_file = $this->getImgForDB();
			if(is_file($this->img_dir.'/'.$img_file)&&$this->imageIsBig($this->img_dir.'/'.$img_file)){
				$this->_is_upload = true;
				$this->img_file = $img_file;	
			}
					
		}
		
	}
	
	public function unload()
	{
		
	}

	public function doupload(){	
		if($_SESSION['token']==$this->token)
		 	return false;		
		$upload = new HTTP_Upload('cn');		
		$file = $upload->getFiles("uesr_logo");
		$file->setValidExtensions(array('gif','jpeg','png','jpg'),'accept');
		if ($file->isValid()){			
			if($file->getProp('size')>1048576){
				echo '<p class="error">出错了，文件超过了1M</p>';
				return ;
			}
			$file->setName('uniq',$this->img_name_prex);

			$moved = $file->moveTo($this->img_dir);

			if (!PEAR::isError($moved)) {			  				       
			       	$this->_is_upload = true;
					switch ($this->checkImageSize($this->img_dir.'/'.$file->getProp('name'))){
				 	case 'error':
				 				echo "<p class=\"error\">出错了，文件尺寸小于$this->img_width*$this->img_height</p>";
				 				$this->_is_upload = false;
				 				unlink($this->img_dir.'/'.$file->getProp('name'));
				 				return;
				 	case 'update':
				 				$this->_is_upload = false;//不裁剪
				 				$this->_is_cropper = true;				 			       
			       }
				   $this->img_file = $file->getProp('name');
			      /*图片大了缩放*/				  
			      if($this->_is_upload) echo '图片过大请您裁剪';			     
					       //更新入数据库
				  $this->updateData();				      
			 } else {
			       echo $moved->getMessage();
			 }
		} elseif ($file->isMissing()) {
		    echo '<p class="error">出错了，没有选择文件！</p>';
		} elseif ($file->isError()) {
		    echo $file->errorMsg();
		}		
	}
	
	public function docropper(){		
		if($_SESSION['token']==$this->token)
		 	return false;
		$tmp_array = explode(',',$this->xywh);
		$oxywh['x'] = $tmp_array[0];
		$oxywh['y'] = $tmp_array[1];
		$oxywh['width'] = $tmp_array[2] - $tmp_array[0];
		$oxywh['height'] = $tmp_array[3] - $tmp_array[1];
		$nwh['width'] = $this->img_width;
		$nwh['height'] = $this->img_height;		
		$this->_is_cropper = $this->cropper("$this->img_dir//$this->img_file","$this->img_dir//$this->img_file",$nwh,$oxywh);
	}	
	public function makeImgUrl(){		
		return "/$this->img_url/$this->img_file";		
	}
	
	
	public function updateData(){
		if(isset($this->sql_table_name)){			
			$img = $this->getImgForDB();
			/*删除原来的文件*/
			if($img !=NULL && is_file($this->img_dir.'/'.$img)){				
				unlink($this->img_dir.'/'.$img);
			}
			$data[$this->sql_column] = $this->img_file; 
			$this->_demo_dao->setTableName($this->sql_table_name);
			$this->_demo_dao->update($data,$this->sql_cond);		
		}		
	}	
	public function getImgForDB(){
			$imgary = $this->_demo_dao->simpleFetchList($this->sql_table_name,array($this->sql_column),$this->sql_cond);
			return  $imgary[0][0];
	}	
	/*裁剪缩放*/
	private function cropper($oldfilename,$newfilename,$array_newfilewh,$array_oldfilexywh){
		if(!is_file($oldfilename)) return false;
		
		list($width, $height) = getimagesize($oldfilename);
		
		if($width<$array_oldfilexywh['width']+$$array_oldfilexywh['x']||$height<$array_oldfilexywh['height']+$array_oldfilexywh['y']) return false;
		
		$thumb = imagecreatetruecolor($array_newfilewh['width'], $array_newfilewh['height']);
		
		$source = $this->createImgFromFileName($oldfilename);
		/*php 图片裁剪函数 */
		imagecopyresized($thumb, $source, 0, 0, $array_oldfilexywh['x'],$array_oldfilexywh['y'] , $array_newfilewh['width'], $array_newfilewh['height'], $array_oldfilexywh['width'], $array_oldfilexywh['height']);
		
		$type = exif_imagetype($oldfilename);
		/*按类型保存图片*/
		$this->saveImgFromFileName($thumb,$newfilename,$type);	
		
		imagedestroy($thumb);
		imagedestroy($source);
		return true;	
	}	
	
	/*缩放图片*/
	private  function smallImg($filename,$newfilename,$percent){		
		list($width, $height) = getimagesize($filename);
		$newwidth = $width * $percent;
		$newheight = $height * $percent;
	    $thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = $this->createImgFromFileName($filename);
		
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		$type = exif_imagetype($filename);
		/*按类型保存图片*/
		$this->saveImgFromFileName($thumb,$newfilename,$type);		
		imagedestroy($source);
		imagedestroy($thumb);
	}	
 	/*从文件名 中 创建图像资源*/
	private  function createImgFromFileName($filename){   	  	 
   	  	$imgtype = exif_imagetype($filename); 		 
 		switch ($imgtype){
   	  	  	case IMAGETYPE_GIF:$img=imagecreatefromgif($filename);
   	  	  	   break;
   	  	  	case IMAGETYPE_JPEG:$img=imagecreatefromjpeg($filename);
   	  	  	   break;
   	  	  	case IMAGETYPE_PNG:$img=imagecreatefrompng($filename);
   	  	  	   break;
   	  	  }
   	  	return $img;
   	}
   	/**/
   	/**
   	 * 将图像资源 保存为特定类型的图片
   	 *
   	 * @param 图片资源 $new_img
   	 * @param string $filename
   	 * @param 图片类型 $imgtype
   	 */
   	private function saveImgFromFileName($new_img,$filename,$imgtype){   	  
   		switch ($imgtype){
   	  	  	case IMAGETYPE_GIF:imagegif($new_img,$filename);
   	  	  	   break;
   	  	  	case IMAGETYPE_JPEG:imagejpeg($new_img,$filename);
   	  	  	   break;
   	  	  	case IMAGETYPE_PNG:imagepng($new_img,$filename);
   	  	  	   break;
   	  	  }
   	 }
   	    	 
   	 
   	 /********************************************/
   	 private function checkImageSize($filename){
   	 	list($width, $height) = getimagesize($filename);
   	 	/*尺寸小于就出错，大于就裁剪*/
   	 	if($width<$this->img_width||$height<$this->img_height){
   	 		return 'error';
   	 		
   	 	}elseif($width>$this->img_max_width||$height>$this->img_max_height){
   	 			$min_percent  =  $this->img_max_width/$width<$this->img_max_height/$height?$this->img_max_width/$width:$this->img_max_height/$height;
   	 			$this->smallImg($filename,$filename,$min_percent);
   	 	/*等于直接写入数据库*/
   	 	}elseif($width==$this->img_width&&$height==$this->img_height){
   	 		
   	 		return 'update';
   	 	}
   	 	return 'crapper';	
   	 }
   	 
   	 private function imageIsBig($filename){
   	 	list($width, $height) = getimagesize($filename);
   	 	return !($width<=$this->img_width||$height<=$this->img_height);
   	 }
}