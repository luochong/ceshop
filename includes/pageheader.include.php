<?php
	global $page;
	$title = ($page->title!="") ? $page->title : APP_NAME;
	mb_check_encoding($title, "GB2312") and $title = mb_convert_encoding($title, "UTF-8", "GB2312");

	 $fpage = $page->getFpage();	
	switch($fpage){
		case "loginmr":  //研究生处
			$cssfile = "grey.css";
			break;				
		case "loginkc":  //教务处课程管理
			$cssfile = "blue.css";
			break;
		default:
			$cssfile = "main.css";
			break;			
	}
	
	$user_name = $page->getUserName();
	$user_unit = $page->getUserUnit();
	$user_adress= $page->getUserAdress();
	$login_user=$page->getUserInfo();
	
	
	//根据页面前缀确定TAB的当前选定
	$prepage = substr(basename($_SERVER['PHP_SELF']),0,4);
	//后缀修改过
	$posPoint=strpos(basename($_SERVER['PHP_SELF']),'.php');
	$pagepre_len=$posPoint-4;
	$pagepre = substr(basename($_SERVER['PHP_SELF']),4,$pagepre_len);
	//修改完
	$info_current=$pers_current=$cour_current='';
	switch($prepage)
	{
		case "infr":$info_current="class='current'";break;
		case "pers":$pers_current="class='current'";break;
		case "cour":$cour_current="class='current'";break;
		case "gtdm":$gtdm_current="class='current'";break;
		case "lett":$lett_current="class='current'";break;
		case "test":$test_current="class='current'";break;
		case "grop":$grop_current="class='current'";break;
		case "frie":$frie_current="class='current'";break;
		case "blog":$blog_current="class='current'";break;
		case "main":$main_current="class='current'";break;
		case "shop":$shop_current="class='current'";$cssfile = "smallmark.css";break;
       default:$main="class='current'";break;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="您的校园统一平台，您的人际交往聚集地，您的社会生活兴趣圈" />
<meta name="keywords" content="校园平台, 卡地, 人际交往, 社会生活, 卡片银行, 名片, 聚集地, 兴趣圈, 真实, cardii, cardii.com" />
<meta name="author" content="cardii.com" />
<meta name="y_key" content="2090ae156625602e" />
<meta name="robots" content="all" />
<title><?php echo $title;?></title>
<link rel="shortcut icon" href="<?php echo(APP_ROOT);?>/style/images/favicon.ico" />
<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/base.js'; ?>"></script>
<style type="text/css" media="screen">@import "<?php echo APP_SKIN.$cssfile;?>";</style>
<style type="text/css" media="screen">@import "<?php echo APP_SKIN."lightbox.css";?>";</style>

<script type="text/javascript">
function show_re( id ) {

	if(document.getElementById(id).style.display=="block"){
		document.getElementById(id).style.display = "none";
	}
	else{
		document.getElementById(id).style.display = "block";
	}
}
</script>
<script type="text/javascript" language="javascript">
	var app_root = "<?php echo(APP_ROOT); ?>";
	var app_head="<?php echo APP_HEAD?>";
	//设置ajax前端路径
	var AJAX_BASEURL = "<?php echo(AJAX_BASEURL); ?>";
	
	function __doPostBack(eventForm, eventTarget, eventArgument, action, target)
	{
		var theForm = document.getElementById(eventForm);
		
		if (!theForm.onsubmit || (theForm.onsubmit() != false))
		{		
			var pos = theForm.id.indexOf("$");
			if (pos > 0)
			{
				var eventControl = theForm.id.substr(0, theForm.id.length - 5);
				
				if (!theForm.__eventtarget)
				{
					var hidden = document.createElement("input");
					hidden.type = "hidden";
					hidden.name = "__eventcontrol";
					hidden.id = "__eventcontrol";
					hidden.value = "";
					theForm.appendChild(hidden);
				}
				theForm.__eventcontrol.value = eventControl;
			}
			
			if (!theForm.__eventtarget)
			{
				var hidden = document.createElement("input");
				hidden.type = "hidden";
				hidden.name = "__eventtarget";
				hidden.id = "__eventtarget";
				hidden.value = "";
				theForm.appendChild(hidden);
			}
			theForm.__eventtarget.value = eventTarget;
			
			if (!theForm.__eventargument)
			{
				var hidden = document.createElement("input");
				hidden.type = "hidden";
				hidden.name = "__eventargument";
				hidden.id = "__eventargument";
				hidden.value = "";
				theForm.appendChild(hidden);
			}
			theForm.__eventargument.value = eventArgument;
			
			if (action)
			{
				theForm.action = action;
			}
			else
			{
				theForm.action = "#";
			}
			
			if (target)
			{
				theForm.target = target;
			}
			else
			{
				theForm.target = "_self";
			}
			
			theForm.method = "post";
			
			
			theForm.submit();
		}
	}
	
	function jumpTo($page_code, $args)
	{
		if ($page_code  && $page_code != "")
		{
			var $sub = $page_code.substr(0, 4);
			var $url = "<?php echo(APP_ROOT); ?>/" + $sub + "/" + $page_code + ".php";
			if ($args)
			{
				$url += "?" + $args;
			}
			window.location.href = $url;
		}
		else
		{
			window.location.href = "<?php echo(APP_ROOT); ?>/";
		}
	}
			
	</script>


</head>
<body id="sns_all">
<!--信息框-->
<div id="messageBoxBg"></div>
 <div id="messageBox">
   <div id="messageHead">
    <span id="messageTitle">&nbsp;</span>
    <span id="messageCon"><a href="javascript:avoid();" class="a_grayLight" onclick="hiden('messageBox');">关闭</a>
    <span class="Boxclose" onclick="hiden('messageBox');">&nbsp;</span></span>
     <div style="clear:both;"></div></div>
     <div id="messageStatus">&nbsp;</div>
     <div id="messageBody">&nbsp;</div>
  </div>
  <!--信息框-->
  <?php 
     echo '<script language="javascript" type="text/javascript">';
     echo 'var friend_ty="'.Globals::frieTypeOption().'"';
     echo '</script>';
  ?>
<!--添加好友信息框-->  
<div id="logoline">
	<div id="logolinecontent">
		<!--Start Logo -->
		<div id="logo">
		   <span id="cardii"><a href="#" title="卡地"><img src="<?php echo APP_ROOT;?>/style/images/cardiilogo2.gif" alt="返回首页cardii.com" border="0" height="63" width="205" /></a></span>
		   <span id="cardiimr"><a href="#" title="硕博导师信息系统"><img src="<?php echo APP_ROOT;?>/style/images/grey/cardiilogo3.gif" alt="硕博导师信息系统" border="0" height="63" width="205" /></a></span>
           <span id="cardiikc"><a href="#" title="课程信息管理平台"><img src="<?php echo APP_ROOT;?>/style/images/blue/cardiilogo4.gif" alt="课程信息管理平台" border="0" height="63" width="205" /></a></span>
		</div>
		<!--Ende Logo -->
		<div id="logoheader">
		   <div id="logoheadercontent">
		    <?php
	         if(isset($user_unit)){
		      echo "<div id=\"welcome\">[$user_unit]";
	          }
	          if(isset($user_name))echo $user_name."，您好</div>" ;
              ?>
              <div id="logoheadercontentbg"><a href="#contentstart" title="直接跳到内容" class="contentskip">直接跳到内容</a>
			  <a href="#" title="用户反馈" onclick="jumpTo('mainback');" class="contentskip">用户反馈</a>
			  <a href="<?php echo APP_ROOT."/pers/persquit.php";?>" title="退出" class="contentskip">退出</a> 
              <a href="<?php echo APP_ROOT."/pers/persmodpw.php";?>" title="修改密码" class="contentskip">修改密码</a>
              </div>
		   <div style="clear:both;"></div>
            </div>
		   <div id="allsearch">
		    <?php //if($fpage=='logicardii'){?>
		      <?php  if($fpage!='loginkc'){?>
		    <select id="allsearch_sel" name="allsearch_sel">
		      <?php echo Globals::allsearchOption(1);?>
		    </select>
		     <input type="text" size="20" id="user_key" name="user_key" value="请输入关键字" onfocus="setEmpty(this);" onblur="setValue(this);"/><button style="cursor:pointer" onclick="dosearchUser();">搜 索</button>
		   <?php }?>
		     </div>
		 </div>
	
	</div>
</div>
<!--end logoline -->


<!--Start Navigation -->
<div id="dolphincontainer">
<div id="dolphinnav">
<ul>
 <?php  if($fpage!='loginkc'){?>
  <li><a href="<?php echo APP_ROOT;?>/main/mainindex.php" title="首页" <?php echo $main_current;?>><span>首页</span></a></li>
   <li><a href="<?php echo APP_ROOT;?>/blog/blogwrite.php" title="博客" <?php echo $blog_current;?> ><span>博客</span></a></li>
  <li><a href="<?php echo APP_ROOT;?>/gtdm/gtdmtask.php" title="时间管理" <?php echo $gtdm_current;?> ><span>日程</span></a></li>
  <li><a href="<?php echo APP_ROOT;?>/grop/groplist.php" title="我的群组" <?php echo $grop_current;?> ><span>群组</span></a></li>
   <li><a href="<?php echo APP_ROOT;?>/frie/frielist.php" title="我的好友" <?php echo $frie_current;?> ><span>好友</span></a></li>
  <li><a href="<?php echo APP_ROOT;?>/lett/lettget.php" title="站内信" <?php echo $lett_current;?> ><span>消息</span></a></li>
  <?php }?>
  <?php if($login_user->basic_role == '1') {?>
  <li><a href="<?php echo APP_ROOT;?>/cour/courdiscipline.php" title="课程信息填写" <?php echo $cour_current;?> ><span>课程卡片</span></a></li>
  <?php }?>
  <li><a href="<?php echo APP_ROOT;?>/infr/infrbase.php" title="信息填写" <?php echo $info_current;?> ><span>信息卡片</span></a></li>
   <li><a href="<?php echo APP_ROOT;?>/pers/persmodpw.php" title="个人设置" <?php echo $pers_current;?>><span>设置</span></a></li>
	<li><a href="<?php echo APP_ROOT;?>/process/process.php" title="课题申报" <?php echo $process_current;?>><span>课题申报</span></a></li>
  </ul>
</div>
</div>
<!--End Navigation -->
