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

<h3>修改菜谱</h3>
	<form id="form1" method="POST">
	餐馆名：&nbsp;&nbsp;&nbsp;<?php echo $page->data1[0]['storename'];?><br><br>
	菜肴名：&nbsp;&nbsp;&nbsp;<?php echo $page->data4[0]['dname']?><br><br>
	价格：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="price" value="<?php echo $page->data3[0]['price']?>"><br><br>
	<?php if($page->data3[0]['ishot']==1):?>
	是否热卖：&nbsp;&nbsp;<input type="radio" name="ishot" value="1" checked>是<input type="radio" name="ishot" value="0">否<br><br>
	<?php else:?>
	是否热卖：&nbsp;&nbsp;<input type="radio" name="ishot" value="1">是<input type="radio" name="ishot" value="0" checked>否<br><br>
	<?php endif;?>
	<?php if($page->data3[0]['isnew']==1):?>
	是否新上市：<input type="radio" name="isnew" value="1" checked>是<input type="radio" name="isnew" value="0">否<br><br>
	<?php else:?>
	是否新上市：<input type="radio" name="isnew" value="1">是<input type="radio" name="isnew" value="0" checked>否<br><br>
	<?php endif;?>
	<input type="button" value="提交" onclick="return conf()" />

	<script language="JavaScript">
	function conf()
	{
		if(confirm("确定填写的信息无误？"))
		{
			__doPostBack('form1','doUpdate');
			window.location.href='shopssd.php?store_id=<?php echo $page->data1[0]['store_id']?>';
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