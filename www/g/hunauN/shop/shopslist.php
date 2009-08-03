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
<h3>商店管理</h3>
<hr />
<form id="form1" method="POST" action="#">
	类型名：
			<select name="type_id" size="1">
			<option value="">——请选择——</option>
			<?php foreach ($page->data_StoreType as $value): ?>
				<option value="<?php echo $value['type_id']?>"><?php echo $value['typename']?></option>
			<?php endforeach;?>
			</select>
			<input type="submit" value="提交"/>
			
			
			
			
		<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="White">
		<?php if($page->data_StoreId):?>
			<tr>
				<td width="5%"><div align="center">选择</div></td>
				<td width="15%"><div align="center">商店名</div></td>
				<td width="45%"><div align="center">logo</div></td>
				<td width="15%"><div align="center">负责人</div></td>
				<td width="10%"></td>
				<td width="10%"></td>
			</tr>
		<?php foreach ($page->data_StoreId as $value):?>
			<tr>
				<td align="center"><input type="checkbox" name="check[]" value="<?php echo $value['store_id']?>"></td>
				<td align="center"><?php echo $value['storename']?></td>
				<td align="center"><img src="./storelogo/<?php echo $value['logo']?>" alt="图片"></td>
				<td align="center"><?php echo $value['boss']?></td>
				<td align="center"><a href="#" onclick="__doPostBack('form1','doDelete','<?php echo $value['store_id']?>')">删除</a>
				</td>
				<td align="center"><a href="shopsmodify.php?store_id=<?php echo $value['store_id']?>">修改</a></td>
			</tr>
		<?php endforeach;?>
		<?php endif;?>
		
</table>		
</form>
</div> <!--end content--> 
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>