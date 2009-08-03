<?php include_once("../../../prepend.include.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="../css/scrlContainer.js" type="text/javascript"></script>
<script language="javascript" src="../js/base.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/stat.css" media="screen" /></head>
<body>
<div class="clear"></div>
<div id="scrlContainer">系统公告：
   <div id="scrlContent">
	  <a href="">[管理员使用手册]湖南农业大学课程管理平台 <b>提供下载</b></a> ，教师使用手册已在前端通知发布！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <a href="">本科评估多媒体汇报材料模板第三版最终修改版 <b>提供下载</b></a>
   </div>
</div><!--end scrlcontainer-->
<div id="me">
<div id="content">
<?php $m = isset($_GET['upimg'])&&isset($_GET['upimg']) == 1; ?>
<h3>添加商店</h3>
<ul id="stattab">
<?php if(!$m):?>
	        <li class="selected" id="tabmenu1"><a href="#"><span>添加基本信息</span></a></li>
	        <li  class="" id="tabmenu2"><a href="#"><span>上传logo</span></a></li>       
<?php else: ?>	           
			<li class="" id="tabmenu1"><a href="#"><span>添加基本信息</span></a></li>
	        <li  class="selected" id="tabmenu2"><a href="#"><span>上传logo</span></a></li>  
<?php endif;?>     
</ul>
<div style="clear:both"></div>
<hr />

<div id="tabbox1" style="<?php if($m) echo 'display:none;';else  echo 'display:block;'?>" >
	<form id="form1" method="POST" enctype="multipart/form-data">
	商店名称：<input name="storename" type="text">&nbsp;&nbsp;
	面积：&nbsp;&nbsp;&nbsp;&nbsp;<input name="area" type="text"><br><br>
	商店类型：<select name="type_id" size="1">
			<option value="">——请选择——</option>
		<?php 
		foreach ($page->data1 as $value):?>
		<option value="<?php echo $value['type_id']; ?>"> <?php echo $value['typename']; ?></option>
		<?php endforeach; ?>
	</select>&nbsp;&nbsp;
	是否提供订餐：<input type="radio" name="ismeal" value="1">是<input type="radio" name="ismeal" value="0" checked>否<br><br>
	负责人：&nbsp;&nbsp;<input name="boss" type="text">&nbsp;&nbsp;
	座机号码：<input name="tel" type="text"><br><br>
	手机号码：<input name="mobile" type="text">&nbsp;&nbsp;
	QQ号码：&nbsp;&nbsp;<input name="qq" type="text"><br><br>
	电子邮箱：<input name="email" type="text">&nbsp;&nbsp;
	商店地址：<input name="address" type="text"><br><br>
	上传图片：<input name="up_file" type="file"/><br><br>
	
	商店介绍：<textarea name="storeinfo"></textarea><br><br>
	
	<input type="button" value="提交" onclick="return conf()" />

	<script language="JavaScript">
	function conf()
	{
		if(confirm("确定填写的信息无误？"))
		{
			__doPostBack('form1','doInsert');
			return true;
		}
		else return false;
	}
	</script>
</form>
</div>

<div id="tabbox2" style="<?php if($m) echo 'display:block;'; else echo 'display:none;' ;?>">


<?php if($m) :?>


<?php
		$ctrl = $page->LoadControl("cimgcropControl");
		$ctrl->sql_table_name = 'ce_smallstore';
		$ctrl->sql_column = 'logo';
		$ctrl->sql_cond = array('store_id' =>$_GET['store_id']);
		$ctrl->img_dir = 'storelogo';
		$ctrl->img_name_prex ='storelogo';
		
		$ctrl->Rend();
?>
	
<?php else : ?>
<p><h2>请您先填写基本信息！</h2></p>
<?php endif;?>
</div>
</div> <!--end content-->
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>