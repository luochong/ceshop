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
<h3>添加菜肴信息</h3>
<ul id="stattab">
<?php if(!$m):?>
	        <li class="selected" id="tabmenu1"><a href="#"><span>添加菜肴</span></a></li>
	        <li class="" id="tabmenu2"><a href="#"><span>管理菜肴</span></a></li>
	        <li  class="" id="tabmenu3"><a href="#"><span>上传logo</span></a></li>       
<?php else: ?>	           
			<li class="" id="tabmenu1"><a href="#"><span>添加菜肴</span></a></li>
			<li class="" id="tabmenu2"><a href="#"><span>管理菜肴</span></a></li>
	        <li  class="selected" id="tabmenu3"><a href="#"><span>上传logo</span></a></li>  
<?php endif;?>     
</ul>
<div style="clear:both"></div>
<hr />

<div id="tabbox1" style="<?php if($m) echo 'display:none;';else  echo 'display:block;'?>" >
<form id="form1" method="POST" action="#">
	菜肴名称：<input type="text" name="DName">
	<input type="button" value="添加" onclick="__doPostBack('form1','doInsert')" />
	<br>
</form>
</div>


<div id="tabbox2" style="display:none">
<form id="form2" action="#" method="POST">
<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="White">
<tr>
	<td width="5%"><div align="center">选择</div></td>
	<td width="20%"><div align="center">序号</div></td>
	<td width="13%"><div align="center">图片</div></td>
	<td width="62%"><div align="center">菜肴名称</div></td>
</tr>
<?php $index=0;	foreach($page->data as $value):  $index++;?>
<tr>
<td><input type="checkbox" name="check[]" value="<?php echo $value['dish_id']?>"></td>
<td align="center"><?php echo $index?></td>
<td align="center"><img src="dishlogo/<?php echo $value['dpic']?>" alt="图片"></td>
<td align="center"><?php echo $value['dname']?></td>
</tr>
<?php endforeach;?>
<tr>
	<td colspan="4"><input type="button" name="del" value="删除" onclick="return conf()">
	<script language="JavaScript">
	function conf()
	{
		if(confirm("真的删除吗？"))
		{
			__doPostBack('form2','doDelete');
			return alert('删除成功！');
		}
	}
	</script>
	</td>
</tr>
</table>
</form>
</div>

<div id="tabbox3" style="<?php if($m) echo 'display:block;'; else echo 'display:none;' ;?>">


<?php if($m) :?>


<?php
		$ctrl = $page->LoadControl("cimgcropControl");	
		$ctrl->sql_table_name = 'ce_dishes';
		$ctrl->sql_column = 'dpic';
		$ctrl->sql_cond = array('dish_id' =>$_GET['dish_id']);
		$ctrl->img_dir = 'dishlogo';
		$ctrl->img_name_prex ='dishlogo';
		
		$ctrl->Rend();
?>

<?php else : ?>
<p><h2>请您先填写菜肴！</h2></p>
<?php endif;?>
</div>
</div> <!--end content--> 
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>