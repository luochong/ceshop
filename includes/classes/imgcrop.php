<?php 
/**
 * 图片裁剪类
 * www.cardii.com
 *luochong1987@gmail.com 
 */
class imgcrop{	
	/**
	 *裁剪缩放
	 *
	 * @param 文件路径 $oldfilename
	 * @param 文件路径 $newfilename
	 * @param 新文件宽高 $array_newfilewh
	 * @param 旧文件x、y、宽高 $array_oldfilexywh
	 * @return unknown
	 */	
	public  function cropper($oldfilename,$newfilename,$array_newfilewh,$array_oldfilexywh = null){
		if(!is_file($oldfilename)) return false;
		
		list($width, $height) = getimagesize($oldfilename);
		
		if($array_oldfilexywh == null){
			$array_oldfilexywh['width'] = $width;
			$array_oldfilexywh['height'] = $height;
			$array_oldfilexywh['x'] = $array_oldfilexywh['y'] = 0;
		}			
		elseif($width<$array_oldfilexywh['width']+$$array_oldfilexywh['x']||$height<$array_oldfilexywh['height']+$array_oldfilexywh['y']) return false;
		
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
	
	/**
	 * 按比例缩放
	 *
	 * @param 文件路径 $filename
	 * @param 文件路径 $newfilename
	 * @param 比例 $percent
	 */
	public  function smallImg($filename,$newfilename,$percent){		
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
   	    	 
   	 
	
}