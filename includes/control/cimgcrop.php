<?php  $formid = $this->getFormId();?>
<?php if($this->_is_upload):?>
<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/new_prototype.js'; ?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/cropper/scriptaculous.js?load=builder,dragdrop';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/cropper/cropper.js'; ?>"></script>
<script language="javascript">
var position=new Array();
function onEndCrop(opic){position[0]=opic.x1;position[1]=opic.y1;position[2]=opic.x2;position[3]=opic.y2;}
Event.observe(window,'load',function(){new Cropper.ImgWithPreview('opic',{minWidth:<?php echo $this->img_width?>,minHeight:<?php echo $this->img_height?>,ratioDim:{x:<?php echo $this->img_width?>,y:<?php echo $this->img_height?>},displayOnInit:true,onEndCrop:onEndCrop,previewWrap:'preview'})});
function docrop(){
  var xywh=position[0]+","+position[1]+","+position[2]+","+position[3];
  $('xywh').value=xywh; 
  return true;  
}
</script>
<?php endif;?>
<script language="javascript" >
   function checkForm(){
   	var file=document.getElementById('uesr_logo').value;
  	if(file == ''){
  	  	alert('您还没有指定要上传的文件！');
  	   return false;
	}else{
		return true;
	}
  }
</script>
<div id="upload">
<?php if($this->_is_cropper):?>
		<p>图片上传成功！</p>
		<img src ="/<?php echo $this->img_url,'/',$this->img_file;?>" />
<?php else: ?>
		<p>支持小于1M的gif,jpeg,png,jpg格式的图片;建议图片上传的尺寸为<?php echo $this->img_width?>*<?php echo $this->img_height?>！</p>
		<form id="<?php echo $formid;?>" method="POST" enctype="multipart/form-data">
		<label for="uesr_logo">文件名：</label><input type="file" name="uesr_logo" id="uesr_logo" />
		<input type="button" name="up" onclick="if(checkForm()){__doPostBack('<?php echo $formid;?>', 'doupload','');}" value="上传"  />
		<input name="token" type="hidden" value="<?php echo Globals::CreateUniq()?>" />
		<?php if($this->_is_upload) :?>
		<input type="hidden" id="xywh" name="xywh" value="" />		
		<p>预览图：</p>
		<div id="preview"></div>
		<p>您上传的原图:</p>
		<div id="resource_pic" style="width:100px"><img id="opic" src="<?php echo $this->makeImgUrl() ?>" /></div>
		<input name="img_file" type="hidden" value="<?php echo $this->img_file ?> " />
		<input name="cropper" id="cropper" type="button" class="button" value="裁剪" onclick="if(docrop()){__doPostBack('<?php echo $formid;?>', 'docropper','');} "/>
		<?php endif; ?>
		</form>
<?php endif;?>
</div>

