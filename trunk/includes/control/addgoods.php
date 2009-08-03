<?php 

$formid = $this->getFormId() 

?>

<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/calender.js'; ?>"></script>
<h3>添加商品</h3>
		  <ul id="stattab">
	        <li class="<?php echo $this->select[0]?>" id="menu1"><a href="?page=baseinfo<?php if(isset($_GET['gid'])) echo '&gid=',$_GET['gid']?>"><span>商品基本信息</span></a></li>
	        <li  class="<?php echo $this->select[1]?>" id="menu2"><a href="?page=detailinfo<?php if(isset($_GET['gid'])) echo '&gid=',$_GET['gid']?>"><span>商品详细信息</span></a></li>
	        <li class="<?php echo $this->select[2]?>"  id="menu3"><a href="?page=imginfo<?php if(isset($_GET['gid'])) echo '&gid=',$_GET['gid']?>"><span>商品图片信息</span></a></li>           
     	  </ul>     	 
 <div style="clear:both"></div>
 <hr />
 
<!--基本信息-->


<?php switch ($this->page): ?>
<?php case 'baseinfo' :?>

<div id="box1" >
		<form id="<?php echo $formid ?>" enctype="multipart/form-data">
			超市名称：<select name="store_id">			
					<?php echo Globals::writeSelectOpitions($this->store_data, $this->DBdata['store_id']);?>			
					</select><br />					
			商品名称：<input type="text" name="goods_name" value="<?php echo $this->DBdata['goods_name']?>" /><br />
			商品编号：<input type="text" name="goods_sn" id="goods_sn" value="<?php echo $this->DBdata['goods_sn']?>" /><input type="button" onclick="CreateSN();"  value="系统生成" /><br />	
			商品类别：<select name="category_id" id="category" >				
					<?php echo Globals::writeSelectOpitions($this->cate_select_data, $this->DBdata['category_id']); ?>
					</select><br />
			商品重量：<input type="text" name="goods_weight" value="<?php echo $this->DBdata['goods_weight']?>" /><br />
			市场价格：<input type="text" name="market_price" value="<?php echo $this->DBdata['market_price']?>" /><br />
			本店价格：<input type="text" name="shop_price" value="<?php echo $this->DBdata['shop_price']?>" /><br />
			商品数量：<input type="text" name="goods_quantity" value="<?php echo $this->DBdata['goods_quantity']?>" /><br />
			商品实物图：<input type="file" name="file_img" /><br />			
			<input type="hidden" name="big_img" value="<?php echo $this->DBdata['big_img']?>" />
			商品品牌：<select name="brand_id">			
					<?php echo Globals::writeSelectOpitions($page->brand_data,$this->DBdata['brand_id']);?>			
					</select><br />
			
			优惠活动：<a href="#" id="tabmenu3" >无</a>|<a href="#" id="tabmenu1" >促销</a>|<a href="#" id="tabmenu2" >打折</a>
					<div id="tabbox1" style="display:<?php if($this->DBdata['is_promotion'] == 1):?>block<?php else:?>none<?php endif?>">
					促销价格：<input type="text" name="promote_price"  value="<?php echo $this->DBdata['promote_price']?>"/><br />
					促销时间：<input type="text" name="promotion_stime" id="promotion_stime" value="<?php echo current(explode('-',$this->DBdata['promotion_stime']))==0?'':$this->DBdata['promotion_stime']?>" onfocus="MyCalendar.SetDate(this)"  onchange="check_date(this);"  />-<input type="text" name="promotion_etime" id="promotion_etime" value="<?php echo current(explode('-',$this->DBdata['promotion_stime']))==0?'':$this->DBdata['promotion_etime']?>" onfocus="MyCalendar.SetDate(this);"  onchange="check_date(this);"  />										
					</div>
					<div id="tabbox2" style="display:<?php if($this->DBdata['is_discount'] == 1):?>block<?php else:?>none<?php endif?>" >
					打折折扣：<input type="text" name="goods_discount" value="<?php echo $this->DBdata['goods_discount']?>" /><br />					
					</div>
					<div id="tabbox3"></div>
			<input type="checkbox" name="is_best" value="1" <?php if($this->DBdata['is_best'] == 1):?>checked="checked" <?php endif?>  />是否推荐<br />
			商品介绍：<textarea name="goods_intro"><?php echo $this->DBdata['goods_intro']?></textarea><br />
			<input type="button" value="添加"  onclick="if(check_end_date('promotion_stime','promotion_etime'))__doPostBack('<?php echo $formid ?>','addBaseInfo');" />		
		</form>
</div>
<script>
function CreateSN(){
	var url = '<?php echo $this->makeAjaxUrl('CreateSN')?>';
	new Ajax.Request(url, 
		{   
			method: 'get',   
			onSuccess: function(transport) {  
				   $('goods_sn').value=transport.responseText;	   
				   
			}
		}
	);
	
	
}
</script>
<?php break;?>
<?php case 'detailinfo': ?>
<!--详细信息-->
<div id="box2">
	
	    <?php if(!empty($this->gattr)):?>
			<?php foreach ($this->gattr as $value):?>
			 	<?php echo $value['attribute_name'],':', $value['attribute_value'],'<br />';?>
			<?php endforeach;?>
		<hr />
		<?php endif?>
		
		<form id="<?php echo $formid ?>">						

		<?php $this->echoAttrFrom() ?>
		
		
		<input type="button" value="确定" onclick="__doPostBack('<?php echo $formid ?>','addDetailInfo');"" />

			
			
			
<script language="javascript">
/*Event.observe($('category'), 'change', function(event){   getAttribute($('category').value) }); 
Event.observe(window, 'load', function() { getAttribute($('category').value)}); 
function getAttribute(cid){
	if(cid == '') $('attribute').update() ;
	var url = '<?php echo $this->makeAjaxUrl('getAttribute')?>' +  '&cid='+cid;
	new Ajax.Request(url, 
		{   
			method: 'get',   
			onSuccess: function(transport) {  
				   var attribute = $('attribute'); 				 
				   var attr = transport.responseText.evalJSON();			 
				   var html = '';
				   for(var i = 0;i<attr.length;i++){
				   			html += attr[i].attribute_name+'：<input type ="text" name="artt['+attr[i].attribute_id+']"/>'	
				   	}				   
				   attribute.update(html);     
			}
		}
	);
}*/



</script>		
		</form>

</div>
<?php break;?>
<?php case 'imginfo':?>
<!--图片信息-->
<div id="box3" >
		<form id="<?php echo $formid ?>" enctype="multipart/form-data" >
		<div id='fileform'>
		商品图片：<br />
		<input type="file" name="f[]"  /><br />
		</div>
		<a id='addimgform' href="#">[+]</a>	<br />
		
		<input type="button" value="提交" onclick="__doPostBack('<?php echo $formid ?>','addImgInfo')" />	
		</form>
<script>
Event.observe($('addimgform'), 'click', function(event){
	$('fileform').insert({'Bottom' : '<input type="file" name="f[]" /><br />'});

}); 

</script>

</div>
<?php break;?>
<?php endswitch;?>