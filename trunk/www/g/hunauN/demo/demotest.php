<?php include_once("../../../prepend.include.php");?>

<h2>留言板</h2>
<?php foreach($page->data as $value):?>
<div style="color:#FF0000"><?php echo $value['name']?>:</div><div><?php echo $value['content']?></div>		
<?php endforeach;?>
<hr />
<form id="form1" >
姓名：<input type="text" name="name" /><br />
内容：<textarea name="content" ></textarea><br />
<input type='button' value="提交" onclick="__doPostBack('form1','doAction');" />
</form>









<?php include_once("append.include.php");?>