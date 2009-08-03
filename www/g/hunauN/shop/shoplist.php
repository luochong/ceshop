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
<h3>超市列表</h3>
<form id ="form1">
<table>
	<tr><th>超市名称</th><th>超市帐号</th><th>超市logo</th><th>操作</th></tr>
	<?php foreach ($page->store_data as $v):?>
		<tr>
			<td><?php echo $v['store_name']?></td>
			<td><?php echo $v['store_account']?></td>
			<td><img src="/<?php echo STORE_LOGO_URL ?>/<?php echo $v['store_logo']?>" /></td>
			<td><a href="#" onclick="__doPostBack('form1','doModify','<?php echo $v['store_id']?>')">修改</a></td>
		</tr>
	<?php endforeach;?>
</table>
</form>
</div> <!--end content--> 
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>