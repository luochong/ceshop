<?php include_once("../../../prepend.include.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="../css/scrlContainer.js" type="text/javascript"></script>
<script language="javascript" src="../js/base.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/new_prototype.js'; ?>"></script>
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

<h3>广告管理</h3>
<h4>商店广告[<a href="?type=0&ftype=0">图片</a>、<a href=""><a href="?type=1&ftype=0">文字</a>]</h4>
<table cellpadding="0" cellspacing="0" border="1">
<tr><th>广告类型</th><th>广告内容</th><th>广告商店</th><th>排序</th><th>链接</th></tr>

<?php foreach ($page->adss as $adss):?>
<tr>
	<td><?php echo $adss['ad_type']==0?'图片':'文字' ?></td>
	<td><?php echo $adss['ad_type']==0?"<img src=\"".AD_IMG_URL."/{$adss['info']}\" width='200px' height='80px' />":$adss['info'] ?></td>
	<td><?php echo $adss['store_name']?></td>
	<td><input type="text" value="<?php echo $adss['sort']?>" size="2" onchange="changeSort(this,'<?php echo $adss['adver_id']?>')"></td>
	<td><?php echo $adss['ad_url']?></td>
</tr>	
<?php endforeach;?>

</table>
<!-- test  -->
<form id='noform'></form>

<h4>超市广告[<a href="?type=0&ftype=1">图片</a>、<a href=""><a href="?type=1&ftype=1">文字</a>]</h4>
<table cellpadding="0" cellspacing="0" border="1">

<tr><th>广告类型</th><th>广告内容</th><th>广告超市</th><th>排序</th><th>链接</th></tr>


<?php foreach ($page->ads as $ads):?>
<tr>
	<td><?php echo $ads['ad_type']==0?'图片':'文字' ?></td>
	<td><?php echo $ads['ad_type']==0?"<img src=\"".AD_IMG_URL."/{$ads['info']}\" width='200px' height='80px' />":$ads['info'] ?></td>
	<td><?php echo $ads['store_name']?></td>
	<td><input type="text" value="<?php echo $ads['sort']?>" size="2" onchange="changeSort(this,'<?php echo $ads['adver_id']?>')"></td>
	<td><?php echo $ads['ad_url']?></td>
</tr>	
<?php endforeach;?>

</table>
<hr />
<h4>添加</h4>
<script>
	function changeSort(obj,id){
		var str = obj.value+':'+id;		
		__doPostBack('noform','msort',str);		
	}

	function showform(obj){
		if(obj.value == 0){
			document.getElementById('formbox').innerHTML = 	'图片：<input name="info" type="file" />';
		
		}else if(obj.value == 1){
			
			document.getElementById('formbox').innerHTML = 	'文字：<input name="info" type="text" />';
			
		}else{
			document.getElementById('formbox').innerHTML = '';
		}	
	}
	function showform2(obj){
		if(obj.value == 1){
			document.getElementById('formbox2').innerHTML = "超市：<select name=\"store_id\"><?php echo Globals::writeSelectOpitions($page->store_data) ?></select>";
		
		}else if(obj.value == 0){
			
			document.getElementById('formbox2').innerHTML = "商店:<select name=\"store_id\"><?php echo Globals::writeSelectOpitions($page->sstore_data) ?></select>";
			
		}else{
			document.getElementById('formbox2').innerHTML = '';
		}	
	}


</script>
<form id='form1' enctype="multipart/form-data">
	广告类型：<select name='ad_type'  onchange="showform(this)"  ><option value="2">...</option><option value="0">图片</option><option value="1">文字</option></select><br />
	<div id='formbox'></div>
	广高所属：<select name='ad_ftype'  onchange="showform2(this)"><option selected='selected' value="1">超市</option><option value="0">商店</option></select>	
	<div id='formbox2'>超市：<select name="store_id"><?php echo Globals::writeSelectOpitions($page->store_data) ?></select> </div>
	广告链接：<input type="text" name="ad_url" /><br />
	
	<input type="button" onclick="__doPostBack('form1','addAD');" value="提交" />	

</form>
</div> <!--end content--> 
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>