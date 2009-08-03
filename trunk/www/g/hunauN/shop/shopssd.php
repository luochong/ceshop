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

<h3>餐馆菜谱管理</h3>
<ul id="stattab">

	        <li class="selected" id="tabmenu1"><a href="#"><span>管理菜谱</span></a></li>
	        <li  class="" id="tabmenu2"><a href="#"><span>添加菜谱</span></a></li>       
<div style="clear:both"></div>
<hr />

<div id="tabbox1" style="display:block;" >
<form id="form1" method="POST" action="#">
	餐馆名称：<select name="store_id">
	<option value="">——请选择——</option>
	<?php foreach ($page->data1 as $value):?>
		<option value="<?php echo $value['store_id']?>"><?php echo $value['storename']?></option>
	<?php endforeach;?>
	</select>
	<input type="submit" value="提交"/>
	<?php if($page->data4):?>
	<input type="button" name="del" value="删除" onclick="return cf()">
	<script language="JavaScript">
	function cf()
	{
		if(confirm("真的删除吗？"))
		{
			__doPostBack('form1','doDeletes')
			return alert('删除成功！');
		}
	}
	</script>
	<?php endif;?>

	<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="White">
			
			<?php if($page->data4):?>
			
			<br><br>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $page->data[0]['storename']?>
			
			<tr>
				<td><div align="center">选择</div></td>
				<td><div align="center">菜肴名</div></td>
				<td><div align="center">价格</div></td>
				<td><div align="center">是否热卖</div></td>
				<td><div align="center">是否新上市</div></td>
				<td></td>
				<td></td>
			</tr>
		<?php foreach ($page->data4 as $value):?>
			<tr>
				<td align="center"><input type="checkbox" name="check[]" value="<?php echo $value['sd_id']?>"></td>
				<td align="center"><?php echo $value['dname']?></td>
				<td align="center"><?php echo $value['price']?></td>
				<td align="center"><?php echo $value['ishot']?></td>
				<td align="center"><?php echo $value['isnew']?></td>
				<td align="center"><a href="#" onclick="__doPostBack('form1','doDelete','<?php echo $value['sd_id']?>')">删除</a>
				
				</td>
				<td align="center"><a href="shopssdmodify.php?sd_id=<?php echo $value['sd_id']?>">修改</a></td>
			</tr>
		<?php endforeach;?>	
		<?php endif;?>
</table>		
	</form>
	
</div>

<div id="tabbox2" style="display:none;">
	<form id="form2" method="POST">
	餐馆名称：&nbsp;<select name="store_id" size="1">
			<option value="">——请选择——</option>
			<?php foreach ($page->data1 as $value):?>
			<option value="<?php echo $value['store_id']?>"><?php echo $value['storename']?></option>
			<?php endforeach;?>
			</select><br><br>
	菜肴名：&nbsp;&nbsp;
		<select name="dish_id">
		<option value="">——请选择——</option>
		<?php foreach ($page->data2 as $value):?>
		<option value="<?php echo $value['dish_id']?>"><?php echo $value['dname']?></option>
		<?php endforeach;?>
		</select><br><br>
	价格：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="price"><br><br>
	是否热卖：&nbsp;&nbsp;<input type="radio" name="ishot" value="1">是<input type="radio" name="ishot" value="0" checked>否<br><br>
	是否新上市：<input type="radio" name="isnew" value="1">是<input type="radio" name="isnew" value="0" checked>否<br><br>
	<input type="button" value="提交" onclick="return conf()" />

	<script language="JavaScript">
	function conf()
	{
		if(confirm("确定填写的信息无误？"))
		{
			__doPostBack('form2','doInsert');
			return true;
		}
		else return false;
	}
	</script>
</form>
</div>
</div> <!--end content-->
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>