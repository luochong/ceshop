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
<h3>商店——商品列表</h3>
<form id='form2' action="#" method="GET" >
<img src="../images/icon_search.gif" />
超市：<select name='store_id'><?php echo Globals::writeSelectOpitions($page->store_data) ?></select>
分类:<select name='category_id'><?php echo Globals::writeSelectOpitions($page->cate_select_data) ?></select>
关键字:<input type="text" name="key" />
<input type="hidden" name="doact" value="search" />
<input type="submit" value="查询" />
</form>
<script>
function ck()
{
    var ckbox = document.getElementById('ckbox');
    b = ckbox.checked;
    
	var input = document.getElementsByTagName("input");

    for (var i=0;i<input.length ;i++ )
    {
        if(input[i].type=="checkbox")
            input[i].checked = b;
    }
}

</script>
<form id='form1'>
<table>
	<tr><th><input type="checkbox" id="ckbox" onclick="ck()" />图片</th><th>价格</th><th>商品名</th><th>积分</th><th>信息</th><th>操作</th></tr>
	<?php foreach ($page->DBdata as $g): ?>	
	<tr>
	<td><input type="checkbox" name='goodsinfo_id[]' value="<?php echo $g['goodsinfo_id'];?>" /><img src="<?php echo SGOODS_IMG_URL,'/',$g['logo']?>" width="50" height="50" /></td>
	<td><?php echo $g['goodsname']?></td>
	<td><?php echo $g['price']?></td>
	
	<td><?php echo $g['score']?></td>
	<td><?php echo Globals::strlimt($g['info'],6)?></td>
	<td><?php echo VIEW_IMG ?><a href="shopsgadd.php?act=update&id=<?php echo $g['goodsinfo_id']?>" ><?php echo EDIT_IMG?></a>
	<a href="javascript:__doPostBack('form1','delete','<?php echo $g['goodsinfo_id']?>')"><?php echo DEL_IMG?></a></td>	
	</tr>
	<?php endforeach;?>

</table>
<select name="doact"><option value="del">删除</option></select>
<input type="button" value="提交" onclick="__doPostBack('form1','doAction');" />
</form>
<?php $page->MakePageUrl()?>
</div> <!--end content--> 
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>