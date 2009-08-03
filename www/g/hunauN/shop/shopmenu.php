<link rel="stylesheet" href="../css/stat.css" media="screen" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
	function hide(id){
			var element = document.getElementById(id);			
			element.style.display = (element.style.display=='block'||element.style.display == '')?'none':'block';
	}
</script>

<div class="leftRoundedCorner">
    <b class="rtop">
     <b class="r1"></b>
	 <b class="r2"></b>
	 <b class="r3"></b>
	 <b class="r4"></b>
   </b>
<div id="leftmenu"> 
			<div class="hand" onclick="hide('hideMenuFunc1')">商店模块管理</div>
			<div id="hideMenuFunc1">
				      <div><a href="shopsadd.php" target="main">添加商店</a> </div>
					  <div><a href="shopslist.php" target="main">商店管理</a>|<a href="shopstype.php" target="main">商店类型管理</a></div>
					  <div><a href="shopsdish.php" target="main">菜肴管理</a>|<a href="shopssd.php" target="main">餐馆菜谱管理</a></div>
				 	  <div><a href="shopsgadd.php" target="main">添加商品</a>|<a href="shopsglist.php" target="main">商品列表</a></div>		 	   				           
			</div>
			<div class="hand" onclick="hide('hideMenuFunc2')">超市模块管理</div>
			<div id="hideMenuFunc2">
				      <div><a href="shopadd.php" target="main" >添加超市</a>|<a href="shoplist.php" target="main" >超市列表</a> </div>
					  <div><a href="shopgoods.php?page=baseinfo" target="main">添加商品</a></div>	
					    <div><a href="shopglist.php" target="main">商品列表</a> </div>
					     <div><a href="shopcate.php?page=add" target="main">添加商品类别</a> </div>							  
					  <div><a href="shopcate.php?page=list" target="main">商品类别列表</a> </div>				 
					  <div><a href="shopslist.php" target="main">订单管理</a></div>
					  <div><a href="shopslist.php" target="main">评论管理</a></div>					  				 
			</div>
			<div class="hand" onclick="hide('hideMenuFunc3')">跳蚤市场模块管理</div>
			<div id="hideMenuFunc3">
				      <div><a href="shopsadd.php" target="main">跳蚤市场设置</a> </div>
					  <div><a href="shopslist.php" target="main">评论管理</a></div>					 
					  <div><a href="shopslist.php" target="main">分类管理</a></div>
					 		 
			</div>
			<div class="hand" onclick="hide('hideMenuFunc4')">其它管理</div>
			<div id="hideMenuFunc4">			
					 <div><a href="shopadm.php" target="main">广告管理</a></div>
			</div>		

 </div>
   	  <b class="rbottom">
         <b class="r4"></b>
         <b class="r3"></b>
         <b class="r2"></b>
         <b class="r1"></b>
      </b>
</div>

