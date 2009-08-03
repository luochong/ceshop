<h3>超市——商品列表</h3>
<form id='form1' action="#" method="GET" >
<img src="../images/icon_search.gif" />
超市：<select name='store_id'><?php echo Globals::writeSelectOpitions($this->store_data) ?></select>
分类:<select name='category_id'><?php echo Globals::writeSelectOpitions($this->cate_select_data) ?></select>
关键字:<input type="text" name="key" />
<input type="hidden" name="act" value="search" />
<input type="submit" value="查询" />
</form>
<form id="<?php echo $this->getFormId()?>">
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
<table>
<tr><th><input type="checkbox" id="ckbox" onclick="ck()" />照片</th><th>编号</th><th>名称</th><th>库存</th><th>价格</th><th>促销</th><th>打折</th><th>推荐</th><th>操作</th></tr>
<?php foreach ($this->DBdata as $g):?>	
	<tr>
		<td><input type="checkbox" name='goods_id[]' value="<?php echo $g['goods_id'];?>" /><img src="<?php echo GOODS_IMG_URL,'/',$g['small_img']?>" width="50" height="50" /></td>
		<td><?php echo $g['goods_sn']?></td>
		<td><?php echo $g['goods_name']?></td>
		<td><?php echo $g['goods_quantity']?></td>
		<td><?php echo $g['shop_price']?></td>
		<td><img src="<?php echo APP_ROOT;?>/g/hunauN/images/<?php echo $g['is_promotion']?'yes.gif':'no.gif' ?>" /></td>
		<td><img src="<?php echo APP_ROOT;?>/g/hunauN/images/<?php echo $g['is_discount']?'yes.gif':'no.gif' ?>" /></td>
		<td><a href="javascript:__doPostBack('<?php echo $this->getFormId()?>','<?php echo $g['is_best']?'doNoBest':'doBest' ?>','<?php echo $g['goods_id'];?>');"><img src="<?php echo APP_ROOT;?>/g/hunauN/images/<?php echo $g['is_best']?'yes.gif':'no.gif' ?>" /></a></td>
		<td><a href="#"><?php echo VIEW_IMG ?></a>			
			<a href="<?php echo $this->MakeUrl($this->editpage,array('page'=>'baseinfo','gid'=>$g['goods_id']))?>"><?php echo EDIT_IMG ?></a>
			<a href="javascript:if(confirm('你确定删除吗？'))__doPostBack('<?php echo $this->getFormId()?>','doDelete','<?php echo $g['goods_id'];?>');"><?php echo DEL_IMG ?></a></td>
		</tr>
		
<?php endforeach;?>
</table> 
<select name="doact"><option value="del">删除</option><option value="best">推荐</option></select>
<input type="button" value="提交" onclick="__doPostBack('<?php echo $this->getFormId()?>','doAction');" />
<div><?php $this->MakePageUrl(); ?></div>
</form>


