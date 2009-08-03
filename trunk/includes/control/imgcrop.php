<?php
///图片裁剪控件
   $formid = $this->getFormId();
	if($this->userPic_state=='2'){
?>
<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/new_prototype.js'; ?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/cropper/scriptaculous.js?load=builder,dragdrop';?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/cropper/cropper.js'; ?>"></script>

<script language="javascript">
  var position=new Array();
function onEndCrop(opic){position[0]=opic.x1;position[1]=opic.y1;position[2]=opic.x2;position[3]=opic.y2;}
Event.observe(window,'load',function(){new Cropper.ImgWithPreview('opic',{minWidth:100,minHeight:105,ratioDim:{x:10,y:10},displayOnInit:true,onEndCrop:onEndCrop,previewWrap:'preview'})});		
function docrop(){
  var xywh=position[0]+","+position[1]+","+position[2]+","+position[3];
  getObject('xywh').value=xywh;
  return true;
}
</script>	
 <?php }?>
 <script language="javascript">
   function checkForm(){
   	var file=getObject('userhead').value;
  	if(is_empty(file)){
  	  	alert('您还没有指定要上传的文件！');
  	   return false;
	}else{
		return true;
	}
  }
</script>
<div id="now_pic">
   <h1>现在的头像：</h1><img src="<?php echo APP_HEAD.$this->now_img_dir;?>"/>
   </div>
   <?php if($this->userPic_state=='2'){?>
   <div id="preview_div"><h1>预览图：</h1><div id="preview"></div></div>
   
   <?php }?>
   <div style="clear: both; height: 1px;">&nbsp;</div>
<p>支持小于1M的gif,jpeg,png,jpg格式的图片;图片大于500*500像素将被剪切！</p>
<div id="upload"><form id="<?php echo $formid;?>" method="POST" enctype="multipart/form-data">
<label for="userhead">上传真实头像：</label><input type="file" name="userhead" id="userhead" />
<input type="button" name="up" onclick="if(checkForm()){__doPostBack('<?php echo $formid;?>', 'doupload','');}" value="上传" class="formsubmit" />
<input type="hidden" id="xywh" name="xywh" value="" />
<?php if($this->userPic_state=='2'){?>
<input name="cropper" id="cropper" type="button" class="button" onclick="if(docrop()){__doPostBack('<?php echo $formid;?>', 'docrop','');}" value="运行裁图"/>
<?php }?>
</p>
</form></div>
<p class="red"><!--错误-->
<?php if(isset($this->upload_errors)){foreach ($this->upload_errors as $value){echo $value;}}?>
</p>
<?php if($this->userPic_state=='2'){?>
<h3>您上传的原图:</h3>
<div id="resource_pic" style="width:500px;height:500px;border:1px #ccc solid;"><img id="opic"src="<?php echo APP_HEAD.$this->img_dir;?>"/></div>
<?php }?>