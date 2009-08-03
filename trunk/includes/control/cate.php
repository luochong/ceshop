<?php switch ($this->page): ?>
<?php case 'add': ?>
<script>
function checkFormCtr(){
	if(getbyid('category_name').value == '')
	{
		alert('类型名称不能为空！');
		return false;
	}else{
		return true;
	}	
}
</script>
	 
<h3>添加商品类别</h3> 		 
<ul id="stattab">
	   <li class="selected" id="tabmenu1" ><a href="#" ><span>添加类别</span></a></li>
	   <li  class="" id="tabmenu2" ><a href="#" ><span>添加属性</span></a></li>           
</ul>
<div style="clear:both" ></div>
<hr />
<form id="<?php echo $this->getFormId();?>">
		
	  <div id="tabbox1">
			类别名称：<input type="text" name="category_name" id="category_name" value="<?php echo $this->DBdata[0]['category_name'] ?>" /><br />
			所属类别：<select name="far_id" >					
					<?php echo Globals::writeSelectOpitions($this->cate_select_data,$this->DBdata[0]['far_id']) ?>
					
					</select><br />
		</div>
		
		<div id="tabbox2" style="display:none">
			<div id="attrform">
			<?php if(isset($_GET['act'])&&$_GET['act'] == 'update'):
				foreach ($this->DBdata as $value):?>
				属性名：<input type="text" name="attribute_name[]"  value="<?php echo $value['attribute_name'] ?>" /><br />
				属性类型：<select name="attribute_type[]">
						<?php echo Globals::writeSelectOpitions(						
									array('text' => '文本',
										   'enum' => '枚举',
										   'date' =>'时间'		
									),$value['attribute_type'])
						?>
					     </select><br />
			    属性默认值:<input type="text" name="attribute_value[]" value="<?php echo $value['attribute_value']?>"/><br />
			    <input type="hidden" name="attribute_id[]" value="<?php echo $value['attribute_id']?>" />			
				<?php endforeach;?>
			<?php else :?>
			属性名：<input type="text" name="attribute_name[]" value="" /><br />
			属性类型：<select name="attribute_type[]">
					<option value="">...</option>
					 <option value="text">文本</option>
					 <option value="enum">枚举</option>
					 <option value="date">时间</option>
					 </select><br />
			属性默认值:<input type="text" name="attribute_value[]" /><br />
			<br />
			属性名：<input type="text" name="attribute_name[]" value="" /><br />
			属性类型：<select name="attribute_type[]">
					<option value="">...</option>
					 <option value="text">文本</option>
					 <option value="enum">枚举</option>
					 <option value="date">时间</option>
					 </select><br />
			属性默认值:<input type="text" name="attribute_value[]" /><br />
			<br />
			属性名：<input type="text" name="attribute_name[]" value="" /><br />
			属性类型：<select name="attribute_type[]">
					<option value="">...</option>
					 <option value="text">文本</option>
					 <option value="enum">枚举</option>
					 <option value="date">时间</option>
					 </select><br />
			属性默认值:<input type="text" name="attribute_value[]" /><br />
			<br />
			属性名：<input type="text" name="attribute_name[]" value="" /><br />
			属性类型：<select name="attribute_type[]">
					<option value="">...</option>
					 <option value="text">文本</option>
					 <option value="enum">枚举</option>
					 <option value="date">时间</option>
					 </select><br />
			属性默认值:<input type="hidden" name="attribute_value[]" /><br />
			<br />
			<?php endif;?>
			</div>
			<a id='addform' href="#">[+]</a>	<br />
		</div>
		
<script>
		Event.observe($('addform'), 'click', function(event){
			$('attrform').insert(
			{'Bottom' : '属性名：<input type="text" name="attribute_name[]" value="" /><br />	属性类型：<select name="attribute_type[]"><option value="">...</option><option value="text">文本</option><option value="enum">枚举</option><option value="date">时间</option></select><br />属性默认值:<input type="text" name="attribute_value[]" /><br /><br />'}
			);		
		}); 

</script>
		<input type="button" value="提交" onclick="if(checkFormCtr()) __doPostBack('<?php echo $this->getFormId()?>','<?php echo $_GET['act']=='update' ?'updateCate':'addCate'?>')"  />
</form>
<?php break;?>
<?php case 'list':?>
<h3>商品类别列表</h3> 
	<?php $this->echoCateList();?>


<?php break;?>
<?php endswitch;?>
