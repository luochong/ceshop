<?php
require_once("controlbase.class.php");
require_once("daofactory.class.php");
require_once("globals.class.php");
require_once("upload.class.php");
require_once("img.class.php");
class ImgcropControl extends ControlBase
{
	public $call='person';
	
	public $user_id;
	public $group_id;
	
	public $user_picture;
	public $img_dir;//图片路径
	public $now_img_dir;//当前头像路径
	public $upload_errors;
	public $userPic_state;
	public $minW=100;
	public $minH=105;
	public $xywh;
	public $file_Prefix;
	public $init_logo;
	public $initsmall_logo;
	public $app_dir;//基础路径
	public $dir_name;//文件夹名称
	public $member_dao;
	public $gp_dao;
	public function load()
	{		
	    $factory = DaoFactory::getFactory();
		$this->member_dao = $factory->getNamedDao("member");
		$this->gp_dao = $factory->getNamedDao("gp");		
        
	}
	
	public function prerend()
	{
		
	    //$this->init_logo=$this->dir_name.;

		$this->ini();
	    $this->userPic_state=$this->isDocropAndShow();
	     
	}
	
	
	public function unload()
	{
		
	}
	//初始化设置
	public function ini(){
		if($this->call=='group'){
			$this->user_picture=$this->gp_dao->getGroupInfo($this->group_id);
		}else {
			$this->user_picture=$this->member_dao->getUserPic($this->user_id);
		}
		$this->init_logo=$this->dir_name.'userlogo.jpg';
	    $this->initsmall_logo=$this->dir_name.'usersmalllogo.jpg';
	    $this->img_dir=$this->user_picture->basic_bigpic;
	    $this->now_img_dir=$this->user_picture->basic_bigpic;
	}
	//是否需要裁剪
	public function isDocropAndShow(){	
		//$realpath = str
		$img_file=$this->app_dir.$this->user_picture->basic_bigpic;
		if($this->user_picture->basic_bigpic!=$this->init_logo and is_file($img_file)){
		list($img_w,$img_H)=getimagesize($img_file);
		if($img_w < $this->minW || $img_H < $this->minH){
			$this->upload_errors[]="您上传的原图小于".$this->minW.'*'.$this->minH.'像素，为不影响显示效果建议重新上传！';
		}
		if($img_w > $this->minW && $img_H > $this->minH){
			//echo $this->now_img_dir=$this->init_logo;
			$this->upload_errors[]='您上传的图片大于'.$this->minW.'*'.$this->minH.'像素，需要裁剪';
			return '2';
		}else {
			return '1';
		}
		}else {
			$this->upload_errors[]='您还没有上传真实头像！';
			return '0';
		}
	}
	function doupload(){
		   if(empty($_FILES['userhead']['name'])){
		      $this->upload_errors[]='您没有指定上传文件！';
		      return ;
		   }
		    $this->ini();
		    $up_load=new upload();
		    $config['uploadType']='logo';
   	   		$config['fileDir']= $this->app_dir.$this->dir_name;
   	   	
   	   		$config['maxSize']=4000000;
   	   		$config['maxWidth']='500';
   	   		$config['maxHight']='500';
   	   		$config['fileType']='gif|jpeg|png|jpg';
   	   		$config['user_id']=$this->user_id;
   	   		if($this->call=='group'){
   	   			$config['file_Prefix']=$this->group_id.'logo';
   	   		}else {
   	   			$config['file_Prefix']=$this->user_id.'logo';
   	   		}
   	   		$up_load->initialization($config);
   	   		$result=$up_load->do_upload('userhead');
   	   		$this->upload_errors=$up_load->errors;
   	   		if($result){
   	   			$fileName=$up_load->getFileName();
   	   			$oldFile=$this->app_dir.$this->now_img_dir;
   	   			//echo $this->user_picture->basic_bigpic;
   	   			//echo $this->init_logo;
   	   			//上传成功，如原文件不等于初始文件，不等于当前上传文件，删除
   	   			if(is_file($oldFile) && $this->user_picture->basic_bigpic!=$this->init_logo){	   				
   	   				unlink($oldFile);
   	   			}
   	   			$oldsmallFile=$this->app_dir.$this->user_picture->basic_smallpic;
   	   			
   	   			if(is_file($oldsmallFile) && $this->user_picture->basic_smallpic!=$this->initsmall_logo){   	   				
   	   				unlink($oldsmallFile);
   	   			}
		        $newData['basic_bigpic']=$this->dir_name.$fileName;
		        $newData['basic_smallpic']=$this->dir_name.$fileName;
		           }
		           if($this->call=='group'){
		           		$where['group_id']=$this->group_id;
            	        $addresult=$this->gp_dao->updateLogo($newData,$where);   
		           }else {
		           	$where['id']=$this->user_id;
            	    $addresult=$this->member_dao->updateUserPic($newData,$where);   
		           }
            		   		
   	   		   if (!$result){
   	   		      $this->upload_errors[]='发生异常错误，请重试！';
   	   		   }else {
   	   		   	 //Server::refresh();
   	   		   }
   	   		
   	   }

	
	function docrop(){
        $this->ini();
		$xywh=explode(',',$this->xywh);
		$xywh[2]=$xywh[2]-$xywh[0];
		$xywh[3]=$xywh[3]-$xywh[1];
		$config['user_id']=$this->user_id;
		$config['file_dir']=$this->app_dir.$this->dir_name;
		$img=new img();
		$img->ini($config);
		
		
	    $old_big_file=$this->app_dir.$this->user_picture->basic_bigpic;
	    $old_small_file=$this->app_dir.$this->user_picture->basic_smallpic;
	   
		$imgSize=$img->getImgSize($old_file); 
		
		//裁剪并缩略
		$small[0]=50;
		$small[1]=50;
		$small[2]=$this->minW;
		$small[3]=$this->minH;
		$filename=$img->docropAndSmallImg($old_big_file,$old_small_file,$xywh,$small);
		$newData['basic_bigpic']=$this->dir_name.$filename['big'];
		$newData['basic_smallpic']=$this->dir_name.$filename['small'];      
		if($this->call=='group'){
		   $where['group_id']=$this->group_id;
           $result=$this->gp_dao->updateLogo($newData,$where);   
		}else {
		   $where['id']=$this->user_id;
           $result=$this->member_dao->updateUserPic($newData,$where);   
		 }
		 //if($result)
		  // Server::refresh();
		 //上传成功，如原文件不等于初始文件，不等于当前上传文件，删除
   	  /*  	if(is_file($old_big_file) && $this->user_picture->basic_bigpic!=$this->init_logo && $this->user_picture->basic_bigpic!=$newData['basic_bigpic']){
   	   				echo $this->user_picture->basic_bigpic;
   	    			echo $this->init_logo;
   	    			unlink($old_big_file);
   	   				
   	   			}
   	     if(is_file($old_small_file) && $this->user_picture->basic_smallpic!=$this->initsmall_logo && $this->user_picture->basic_smallpic!=$newData['basic_smallpic']){

   	     			unlink($old_small_file);
   	   			}*/
   	  // 	if($result)
		// Server::refresh();
	}
	
	
	
}

?>