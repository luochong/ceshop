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
<h3>添加商店类型</h3>
<hr />
<form id="form1">
	类型名称：<input type="text" name="typename">
	<input type="button" value="添加" onclick="__doPostBack('form1','doInsert')" />
</form>
<table width="100%" border="1" cellpadding="2" cellspacing="2" bgcolor="White">
<form id="form2" method="POST" action="#">
<tr>
<td width="18"><div align="center">选择</div></td>
<td width="20%"><div align="center">编号</div></td>
<td width="62%"><div align="center">商店类型名称</div></td>
</tr>
<?php $index=0;	foreach($page->data as $value):  $index++;?>
<tr>
<td><input type="checkbox" name="check[]" value="<?php echo $value['type_id']?>"></td>
<td align="center"><?php echo $index?></td>
<td align="center"><?php echo $value['typename']?></td>
</tr>
<?php endforeach;?>
<tr>
<td colspan="3"><input type="button" name="del" value="删除" onclick="return conf()">
<script language="JavaScript">
function conf()
{
	if(confirm("真的删除吗？"))
	{
		__doPostBack('form2','doDelete');
		return true;
	}
	else return false;
}
</script>
</td>
</tr>
</form>
</div> <!--end content--> 
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>