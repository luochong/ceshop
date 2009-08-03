<?php include_once("../../../prepend.include.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="../css/scrlContainer.js" type="text/javascript"></script>
<script language="javascript" src="../js/base.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/stat.css" media="screen" /></head>
<body>
<?php $mark = isset($_SESSION['store_id']); ?>
<script language="javascript">
function checkForm1(){
	var form1 = getbyid('form1');
	
	if(form1.store_name.value == ''||form1.store_account.value == ''||form1.store_password.value==''||form1.store_rpassword.value==''||form1.store_info.value==''){
		alert("请填写完整！");
		return false;
	}else{
		if(form1.store_password.value != form1.store_rpassword.value ){				
				alert('密码不一致');
				form1.store_password.value = form1.store_rpassword.value = '';
				return false;
		}else{
			    return true;
		}
	}	
}
</script>
<div class="clear"></div>
<div id="scrlContainer">系统公告：
   <div id="scrlContent">
	  <a href="">[管理员使用手册]湖南农业大学课程管理平台 <b>提供下载</b></a> ，教师使用手册已在前端通知发布！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <a href="">本科评估多媒体汇报材料模板第三版最终修改版 <b>提供下载</b></a>
   </div>
</div><!--end scrlcontainer-->
<div id="me">
<div id="content">
<h3>添加超市</h3> 
		  <ul id="stattab">
	        <li class="selected" id="tabmenu1"><a href="#"><span>添加基本信息</span></a></li>
	        <li  class="" id="tabmenu2"><a href="#"><span>上传logo</span></a></li>           
     	  </ul>
 <div style="clear:both"></div>
 <hr />

<div id="tabbox1" <?php if($mark) echo 'style="display:none"'?> >
	<form id="form1" name="form1" >
		
		<?php if($mark):?><input type="button" value="再添加" onclick="__doPostBack('form1','reStore')" /><br /><?php endif;?>
		超市名称：<input type="text" name="store_name" value="<?php echo $page->store_name;?>" /><br />
		超市帐号：<input type="text" name="store_account" value="<?php echo $page->store_account;?>" /><br />
		超市密码：<input type="password" name="store_password" value="<?php echo $page->store_password;?>" /><br />
		确认密码：<input type="password" name="store_rpassword" value="<?php echo $page->store_password;?>" /><br />	
		简介：<textarea name="store_info" ><?php echo $page->store_info;?></textarea><br />			
		<input type="button" value="<?php if($mark) echo '修改';else echo '添加'?>" onclick="if(checkForm1()) __doPostBack('form1','<?php if($mark) echo 'modifyStore';else echo 'addStore'?>')" />
		
	</form>
</div>
<!--  上传logo  -->
<div id="tabbox2" <?php if(!$mark) echo 'style="display:none"' ?>>
<?php if($mark):?>
<?php		
		$ctrl = $page->LoadControl("cimgcropControl");	
		$ctrl->sql_table_name = 'ce_store';
		$ctrl->sql_column = 'store_logo';
		$ctrl->sql_cond = array('store_id' => $_SESSION['store_id']);
		$ctrl->img_dir = STORE_LOGO_DIR;
		$ctrl->img_url = STORE_LOGO_URL;
		$ctrl->img_name_prex ='storelogo';
		
		$ctrl->Rend();
		unset($ctrl);
?>
<?php else : ?>
<p class="error">你还没有填写基本信息，你先填写基本信息</p>

<?php endif;?>
</div>

</div> <!--end content--> 
 </div><!--end me-->
<div style="clear: both;">&nbsp;</div> 
<div class="clear"></div>
</body>
</html>
<?php include_once("append.include.php");?>