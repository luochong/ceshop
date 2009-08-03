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
<h3>修改商店信息</h3>
<div style="clear:both"></div>
<hr />
	<form id="form1" method="POST">
	商店名称：<input name="storename" type="text" value="<?php echo $page->data1[0]['storename']?>">&nbsp;&nbsp;
	面积：&nbsp;&nbsp;&nbsp;&nbsp;<input name="area" type="text" value="<?php echo $page->data1[0]['area']?>"><br><br>
	商店类型：<select name="type_id" size="1">
			<option value="<?php echo $page->data2[0]['type_id']?>">
			<?php echo $page->data2[0]['typename']?>
			</option>
			<?php
			foreach ($page->data3 as $value):?>
			<option value="<?php echo $value['type_id']; ?>"> <?php echo $value['typename']; ?></option>
			<?php endforeach; ?>
	</select>&nbsp;&nbsp;
	<?php if($page->data1[0]['ismeal']==1):?>
	是否提供订餐：<input type="radio" name="ismeal" value="1" checked>是<input type="radio" name="ismeal" value="0">否<br><br>
	<?php else:?>
	是否提供订餐：<input type="radio" name="ismeal" value="1">是<input type="radio" name="ismeal" value="0" checked>否<br><br>
	<?php endif;?>
	负责人：&nbsp;&nbsp;<input name="boss" type="text" value="<?php echo $page->data1[0]['boss']?>">&nbsp;&nbsp;
	座机号码：<input name="tel" type="text" value="<?php echo $page->data1[0]['tel']?>"><br><br>
	手机号码：<input name="mobile" type="text" value="<?php echo $page->data1[0]['mobile']?>">&nbsp;&nbsp;
	QQ号码：&nbsp;&nbsp;<input name="qq" type="text" value="<?php echo $page->data1[0]['qq']?>"><br><br>
	电子邮箱：<input name="email" type="text" value="<?php echo $page->data1[0]['email']?>">&nbsp;&nbsp;
	商店地址：<input name="address" type="text" value="<?php echo $page->data1[0]['address']?>"><br><br>
	
	
	商店介绍：<textarea name="storeinfo"><?php echo $page->data1[0]['storeinfo']?></textarea><br><br>
	
	
	<input type="button" value="提交" onclick="return conf()" />

	<script language="JavaScript">
	function conf()
	{
		if(confirm("确定填写的信息无误？"))
		{
			__doPostBack('form1','doUpdate');
			if(confirm("是否上传新图片？"))
			{window.location.href='shopsnewlogo.php?store_id=<?php echo $_GET['store_id']?>';}
			else
			{window.location.href='shopslist.php';}
			return true;
		}
		else return false;
	}
	</script>
	
</form>

</div> <!--end content--> 
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>