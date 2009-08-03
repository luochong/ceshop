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
<h3>添加商店</h3>
<form id='form1' enctype="multipart/form-data" >
	商店名称：<select name="store_id">
			<?php echo Globals::writeSelectOpitions($page->store_data,$page->g['store_id']) ?>
			</select><br />
	商品名称：<input type="text" name="goodsname" value="<?php echo $page->g['goodsname']?>" /><br />
	商品类型：<select name="type_id">
			<?php echo Globals::writeSelectOpitions($page->cate_select_data,$page->g['type_id']) ?>
			</select><br />
	价格：<input type="text" name="price" value="<?php echo $page->g['price']?>" /><br />
	图片：<input type="file" name="picture"  /><br />
		 <input type="hidden" name="f" value="<?php echo $page->g['picture']?>" />
	信息：<textarea name="info"><?php echo $page->g['info']?></textarea>
	<input type="button" onclick="__doPostBack('form1','<?php echo $_GET['act']=='update'?'updateGoods':'addGoods' ;?>');" value="<?php echo $_GET['act']=='update'?'修改':'添加' ;?>" />
</form>
</div> <!--end content--> 
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>