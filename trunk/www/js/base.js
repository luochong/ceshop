var net = new Object();
 function getObject(id) {
	if (document.getElementById(id)) {
		return document.getElementById(id);
	} else if(document.all) {
		return document.all[id];
	} else if(document.layers) {
		return document.layers[id];
	}
}
function hiden(elementId){
	getObject(elementId).style.display='none';
	if(getObject('messageBoxBg')){
		getObject('messageBoxBg').style.display='none';
	}
	showOrhidenSelect('visible');
}
function show(elementId){
	getObject(elementId).style.display='block';
}
function toggle(el) {
	var e = getObject(el);
	if(e.style.display == "none" || e.style.display == '' ) {
		show(el);
	} else {
		hiden(el);
	}
}
  function avoid(){}
  function is_empty(str){
   		if(str.length===0){
		return true;
	}else{
		return false;
	}
   }
   //限制输入字的个数
    function checkLen(obj,maxChars,count_id) {
     if (obj.value.length > maxChars)
     obj.value = obj.value.substring(0,maxChars);
     var curr = maxChars - obj.value.length;
     if(getObject(count_id)){
     	 getObject(count_id).innerHTML = curr.toString();
     }
    }	
 //select页面跳转
 function selectJumpTo(obj,page_code,para){
 	var sel=obj.value;
 	if(sel=='0'){
 		return;
 	}else{
 		var Parameter=para+sel;
 		jumpTo(page_code,Parameter);
 	}
 }
   	//获得标签对象

 function addLoadListener(fn){
    if ( typeof window.addEventListener != 'undefined'){
        window.addEventListener('load',fn,false);
    }else if( typeof document.addEventListener != 'undefined'){
        document.addEventListener('load',fn,false);
    }else if (typeof window.attachEvent != 'undefined') {
        window.attachEvent('onload',fn);
    }else{
        var oldfn = window.onload;
        if(typeof window.onload != 'function'){
            window.onload = fn;
        }else{
            window.onload = function (){
                oldfn();
                fn();
            };
        }
    }
}
//获得指定元素的左上角坐标位置
   function getElementPos(elementId) {
 var ua = navigator.userAgent.toLowerCase();
 var isOpera = (ua.indexOf('opera') != -1);
 var isIE = (ua.indexOf('msie') != -1 && !isOpera); // not opera spoof
 var el = document.getElementById(elementId);
 if(el.parentNode === null || el.style.display == 'none') {
  return false;
 }     
 var parent = null;
 var pos = [];    
 var box;    
 if(el.getBoundingClientRect)    //IE
 {         
  box = el.getBoundingClientRect();
  var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
  var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
  return {x:box.left + scrollLeft, y:box.top + scrollTop};
 }else if(document.getBoxObjectFor)    // gecko   
 {
  box = document.getBoxObjectFor(el);
  var borderLeft = (el.style.borderLeftWidth)?parseInt(el.style.borderLeftWidth):0;
  var borderTop = (el.style.borderTopWidth)?parseInt(el.style.borderTopWidth):0;
  pos = [box.x - borderLeft, box.y - borderTop];
 } else    // safari & opera   
 {
  pos = [el.offsetLeft, el.offsetTop]; 
  parent = el.offsetParent;    
  if (parent != el) {
   while (parent) { 
    pos[0] += parent.offsetLeft;
    pos[1] += parent.offsetTop;
    parent = parent.offsetParent;
   } 
  }  
  if (ua.indexOf('opera') != -1 || ( ua.indexOf('safari') != -1 && el.style.position == 'absolute' )) {
   pos[0] -= document.body.offsetLeft;
   pos[1] -= document.body.offsetTop;        
  }   
 }             
 if (el.parentNode) {
    parent = el.parentNode;
   } else {
    parent = null;
   }
 while (parent && parent.tagName != 'BODY' && parent.tagName != 'HTML') { // account for any scrolled ancestors
  pos[0] -= parent.scrollLeft;
  pos[1] -= parent.scrollTop;
  if (parent.parentNode) {
   parent = parent.parentNode;
  } else {
   parent = null;
  }
 }
 return {x:pos[0], y:pos[1]};
}
//获取页面窗口相对body顶部的距离<br>
function   WebForm_GetScrollY()  
{
if   (typeof  window.pageYOffset!='undefined')   {
return   window.pageYOffset;
}
else   {
if   (document.documentElement   &&   document.documentElement.scrollTop)   {
return   document.documentElement.scrollTop;
}
else   if   (document.body)   {
return   document.body.scrollTop;
}
}
return   0;
}
function getEditorHTMLContents(EditorName) {
    var oEditor = FCKeditorAPI.GetInstance(EditorName);
    return(oEditor.GetXHTML(true));
   }
   

function createXmlHttpRequestObject() 
{	
  // will store the reference to the XMLHttpRequest object
  var xmlHttp;
  // if running Internet Explorer
  if(window.ActiveXObject)
  {
    try
    {
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch (e) 
    {
      xmlHttp = false;
    }
  }
  // if running Mozilla or other browsers
  else
  {
    try 
    {
      xmlHttp = new XMLHttpRequest();
    }
    catch (e) 
    {
      xmlHttp = false;
    }
  }
  // return the created object or display an error message
  if (!xmlHttp)
 
    alert("Error creating the XMLHttpRequest object.");
  else 
    return xmlHttp;
}
var xmlHttp=createXmlHttpRequestObject();

net.contentLoader = function(url,onload,onerror,method,params,contentType){
	this.req = null;
	this.onload = onload;
	this.onerror = (onerror) ? onerror : this.defaultError;
	this.loadXMLDoc(url,method,params,contentType);
}
net.contentLoader.prototype = {
	loadXMLDoc:function(url,method,params,contentType){
		if(!method) {
			method = "GET";
		}
		
		if(!contentType && method == "POST") {
			contentType = 'application/x-www-form-urlencoded';
		}
		/*
		if(window.XMLHttpRequest) {
			this.req = new XMLHttpRequest();
		} else if (window.ActiveXOject) {
			this.req = new ActiveXObject("Microsoft.XMLHTTP");
		}
		*/
		this.req = createXmlHttpRequestObject();
		if(this.req) {
			try {
				var loader = this;
				this.req.onreadystatechange = function() {
					loader.onReadyState.call(loader);
				}
				this.req.open(method,url,true);
				if(contentType) {
					this.req.setRequestHeader('Content-Type',contentType);
				}
			this.req.send(params);
			} catch (err){
				this.onerror.call(this);
			}
		}
	},
	
	onReadyState:function(){
		if(this.req.readyState == 4) {
			var httpStatus = this.req.status;
			if(httpStatus == 200 || httpStatus == 0) {
				this.onload.call(this);
			} else {
				this.onerror.call(this);
			}
		}
		
	},
	
	defaultError:function(){
		alert("error fetching data!"
			+"\n\nreadyState:" + this.req.readyState
			+"\nstatus:" + this.req.status
			+"\nheaders:" + this.req.getAllResponseHeaders());
	}
};
function selectall(){	
	var select = document.getElementsByName("post_id[]");
	for(var i=0;i<select.length;i++){
		select[i].checked == true ? select[i].checked = false : select[i].checked = true;	
	}
}
//通用
function selectallorconcal(tagname){	
	var select = document.getElementsByName(tagname);
	for(var i=0;i<select.length;i++){
		select[i].checked == true ? select[i].checked = false : select[i].checked = true;	
	}
}
//隐藏第一个显示第二个
function showOrhiden(id1,id2){
	hiden(id1);
	show(id2);
}
//居中定位并div层
function positionAndShow(id,width,left,top,isgray){
   var contentId;
   	width=(typeof(width)=="undefined")?440:width;
    top=(typeof(top)=="undefined")?180:top;  
    isgray=(typeof(isgray)=="undefined")?1:isgray;  
   if(document.getElementById('maincontent')){
   	   contentId='maincontent';
   }else if(document.getElementById('maincontent2')){
   	 contentId='maincontent2';
   }else{
   	  contentId='container';
   }
	var mainpos=getElementPos(contentId);
	var otherleft=(960-width)/2;
	var Pleft=mainpos.x+otherleft;
	var Ptop=WebForm_GetScrollY()+top;
	var showDiv=getObject(id);
	showDiv.style.position='absolute';
	showDiv.style.top=Ptop+'px';
	showDiv.style.left=Pleft+'px';
	showDiv.style.width=width+'px';
	//showDiv.style.z-index=7777;
	showOrhidenSelect('hidden');
	//document.write(hidensel);
	if(isgray==1){
		var bgheghit=document.getElementById('sns_all').offsetHeight;
		var messageBoxBg=document.getElementById('messageBoxBg');
		messageBoxBg.style.height=bgheghit;
		messageBoxBg.style.display='block';
	}
	showDiv.style.display='block';
}
function showOrhidenSelect(state){
	if(getObject('maincontent')){
		var div=getObject('maincontent');
	}
	if(getObject('maincontent2')){
		var div=getObject('maincontent2');
	}
	if(getObject('content')){
		var div=getObject('content');
	}
	var sels=div.getElementsByTagName("select");
	for(var i=0;i<sels.length;i++){
		sels[i].style.visibility=state;
	}
}
function addFriendEdit(user_id,frieName,frie_id){
	if(user_id==frie_id){
		var conf=confirm('您不能加自己为好友');	
		return;
	}
      	var messageBox=getObject('messageBox');
	    var messageTitle=getObject('messageTitle');
	    var messageBody=getObject('messageBody');
	messageTitle.innerHTML="将<span class=\"darkgreen\">"+frieName+"</span>加为好友?";
	var bodyHtml="<p class=\"con_listbig\">发送好友申请后，对方会收到提示，经对方确认后，你们即可成为好友!</p>";
	    bodyHtml+="<div class=\"con_listbig\"><span class=\"con_left\">添加附加信息<span class=\"small_gray\">(选填，限45字内)";
	    bodyHtml+="<span class=\"red \" id=\"count_mes\"></span>：</span></span><span class=\"con_rightmargin\">"+'选择分组：<select name="frieType" id="frieType" >'+friend_ty+"</select></span><div style=\"clear:both;\"></div></div>";
	    bodyHtml+='<div><textarea id="message" name="message" onkeyup="checkLen(this,45,\'count_mes\');" cols="35"></textarea></div>';
	    bodyHtml+='<div id="mesFoot">'+"<input style=\"margin-right:10px;\" type=\"button\" value=\"确定\" onclick=\"addFriend("+user_id+","+frie_id+");\"><input type=\"button\" value=\"取消\" onclick=\"hiden('messageBox');\"/></div>";
	messageBody.innerHTML=bodyHtml;
	messageBox.style.width='440px';
	positionAndShow('messageBox');	
}
function addFriend(user_id,frie_id){
	var message=document.getElementById('message').value;
	var frieType=document.getElementById('frieType').value;
	var params='user_id='+user_id+'&frie_id='+frie_id+'&message='+message+'&frieType='+frieType;
	var url = AJAX_BASEURL+"frie/addFriend";
		var loader = new net.contentLoader(url,callbackaddFriend,'','POST',params);
}
function callbackaddFriend() {
	 var messageBody=getObject('messageBody');
	messageBody.innerHTML = this.req.responseText;
	setTimeout(function hendin(){hiden("messageBox");},1000);
}
//添加关注
function addGuanzhu(user_id,friend_id){
	if(user_id==friend_id){
		alert('不能添加自己！');
		return;
	}
	var params='user_id='+user_id+'&friend_id='+friend_id;
	var url = AJAX_BASEURL+"frie/addGuanzhu";
	var loader = new net.contentLoader(url,callbackaddGuanzhu,'','POST',params);
}
//取消关注
function concallAddition(record_id){
	var conf=confirm('确定要取消吗？');
	if(!conf){
		return;
	}else{
	  //invUerInfo_div='UI_'+record_id;
	  var params='record_id='+record_id;
	  var url=AJAX_BASEURL+"frie/concallAddition";
	  var loader = new net.contentLoader(url,callbackAct,'','POST',params);
	}
}

function callbackaddGuanzhu(){
	var state=this.req.responseText;
	alert(state);
}
function callbackAct(){
	var state=this.req.responseText;
	if(state=='1'){
		alert("操作成功！");
		location.reload();//刷新本页	
	}else{
		alert("操作失败！");
	}
}
/************************************站内信弹出框****************************************************/
function postLetterBox(user_id,toName,to_id){
	if(user_id==to_id){    
		var conf=confirm('你不能给自己发站内信');	
		return;
	}
	var messageBox=getObject('messageBox');
	var messageTitle=getObject('messageTitle');
	var messageBody=getObject('messageBody');
	messageTitle.innerHTML='发站内信';
	var html="<div class=\"con_listbig\">给<span class=\"darkgreen\">"+toName+"</span>发站内信</div>";
	html+="<div class=\"con_listbig\"><span>主题：</span><input id=\"subject_field\" name=\"letter_title\" style=\"width:340px;\" value=\"\" type=\"text\" /></div>";
	  html+="<div class=\"con_listbig\"><span class=\"con_left\">内容：</span>";
	html+="<div class=\"con_left\"><textarea name=\"letter_content\" id=\"message\" rows=\"8\" cols=\"40\" style=\"width:340px;height:175px; margin-left:10px;\"></textarea></div></div>";
	  html+="<div style=\"clear:both;\"></div><div id=\"mesFoot\"><input  type=\"button\" value=\"发 送\" onclick=\"postLetter("+user_id+","+to_id+");\" />";
	  html+="<input type=\"button\" value=\"取 消\" onclick=\"hiden('messageBox');\" /></div>";
    messageBody.innerHTML=html;
	positionAndShow('messageBox');
}
function postLetter(user_id,to_id){
	var message=document.getElementById('message').value;
	var letter_title=document.getElementById('subject_field').value;
	var params='user_id='+user_id+'&to_user_id='+to_id+'&letter_content='+message+'&letter_title='+letter_title;
	var url = AJAX_BASEURL+"letter/sendLetter";
	if(message!=''&&letter_title!=''){
	var loader = new net.contentLoader(url,callbackpostLetter,'','POST',params);	
	var messageBody=getObject('messageBody').innerHTML='请等待  正在发送...';
	}
	else alert("出错了，请输入完全！");
}
function callbackpostLetter() {
	var messageBox=getObject('messageBox');
	var messageBody=getObject('messageBody');
	messageBody.innerHTML = this.req.responseText;
	setTimeout(function hendin(){hiden("messageBox");},2000);
}
function dosearchUser(){
	var user_key=getObject('user_key').value;
	var search_ty=getObject('allsearch_sel').value;
	if(is_empty(user_key) || user_key=='关键字'){
		alert("您还没有输入关键字！");
	}else{
		var pars="sty=base&keyone="+encodeURI(user_key)+"&page=1";
		var page='frieserc';
		switch(search_ty){
			case '2':{page='gropsearch';pars="name_key="+encodeURI(user_key);}break;
			case '3':{page='gtdmsearch';pars="key="+encodeURI(user_key);}break;
			case '4':{page='gropspeak';pars="topic="+encodeURI(user_key);}break;
			default:break;
		}
		jumpTo(page,pars);
	}
}
function setEmpty(obj){
	if(obj.value=='请输入关键字'){
		obj.value='';
	}
}
function setValue(obj){
		if(is_empty(obj.value)){
		obj.value='请输入关键字';
	}
}
function show_search(){
	var pos=getElementPos('search_one');
	var left=pos.x;
	var top=pos.y+20;
	var div=getObject('more_search');
	div.style.position='absolute';
	div.style.top=top+'px';
	div.style.left=left+'px';
	show('more_search');
}

/********************************************留言************************************************************/
/*function $(str){
	return document.getElementById(str);
}*/
//首页好友动态id集合
var frienewIds= new Array('blog','task','friemood','relations','groupnewlist');
var right_side_top= new Array('comlist','golist','friendlist');
var right_side_bottom=new Array('group_list','heat_degreet');
//接受一个id数组，显示其中一个，隐藏其他
function showOneHidenOther(idarray,showid){
	
	var i=0;
	for(i;i<idarray.length;i++){
		if(idarray[i]==showid){
            setClass(showid+'_a','nav_li')
			show(showid);
		}else{
			//alert(idarray[i]+'_a');
			setClass(idarray[i]+'_a','')
			
			hiden(idarray[i]);
		}
	}
}
//
//设置class的css通过id
function setClass(obj_id,_class)
{
var obj=document.getElementById(obj_id);
obj.setAttribute("class",_class);//此句可无
obj.setAttribute("className",_class);
}
//设置class的css通过this
function setClassbythis(obj,_class)
{
obj.setAttribute("class",_class);//此句可无
obj.setAttribute("className",_class);
}
var getNewType;//task,friemood,relations
var is_load = new Array();
 is_load['task']='0';
 is_load['friemood']='0';
 is_load['relations']='0';
 is_load['groupnewlist']='0';
function getFrieNew(user_id,getType){
	 //alert(getType);
	var params='user_id='+user_id+'&getType='+getType;
	getNewType=getType;
	if(getType=='blog'){
		showOneHidenOther(frienewIds,getType);
	}else if(is_load[getType]=='1'){
		showOneHidenOther(frienewIds,getType);
	}else{
	var url = AJAX_BASEURL+"frie/getFrieNew";
	var loader = new net.contentLoader(url,callbackgetFrieNew,'','POST',params);
	getObject(getType).innerHTML='<div class="loading"></div>';
	showOneHidenOther(frienewIds,getType);
	}
}
function callbackgetFrieNew(){
	getObject(getNewType).innerHTML=this.req.responseText;
    is_load[getNewType]='1';
}
//首页好友动态id集合

var getListType;//task,friemood,relations
var sidebar_load = new Array();
 sidebar_load['comlist']='1';
 sidebar_load['golist']='0';
 sidebar_load['friendlist']='0';
 sidebar_load['grouplist']='0';
//获取好友圈信息列表
function getsidebarlist(getType,user_id){
    // alert(getType);
	var params='user_id='+user_id+'&getType='+getType;
     getListType=getType;
	if(getType=='comlist'){
		showOneHidenOther(right_side_top,getType);
	}else if(sidebar_load[getType]=='1'){
		showOneHidenOther(right_side_top,getType);
	}else{
	var url = AJAX_BASEURL+"frie/getsidebarlist";
	var loader = new net.contentLoader(url,callbackgetsidebarlist,'','POST',params);
	getObject(getType).innerHTML='<div class="loading"></div>';
	showOneHidenOther(right_side_top,getType);
	}
}
//回调函数
function callbackgetsidebarlist(){
	getObject(getListType).innerHTML=this.req.responseText;
    sidebar_load[getListType]='1';
}
var blog_load = new Array();
blog_load['comblog']='0';
blog_load['hotblog']='1';
var blog_side=new Array('comblog','hotblog');
function gethotblog(getType,user_id){
	
     getListType=getType;
	if(getType=='comlist'){
		showOneHidenOther(blog_side,getType);
	}else if(blog_load[getType]=='1'){
		showOneHidenOther(blog_side,getType);
	}else{
	var url = AJAX_BASEURL+"blog/getcomblog";
	var loader = new net.contentLoader(url,callbackgethotblog,'','GET','');
	getObject(getType).innerHTML='<div class="loading"></div>';
	showOneHidenOther(blog_side,getType);
	}
	
	
}
function callbackgethotblog(){
	getObject(getListType).innerHTML=this.req.responseText;
    blog_load[getListType]='1';
}



//群组相关
//var gpsitbarlistIds= new Array('heat_degreet','heat_topic_list','newgp_list');
var gpsitbarType;
var gpsitbar_load = new Array();
 gpsitbar_load['group_list']='0';
 gpsitbar_load['heat_degreet']='0';
 //gpsitbar_load['heat_topic_list']='0';
 //gpsitbar_load['newgp_list']='0';
function getgpsitbarlist(getType,user_id){	
	var params='user_id='+user_id+'&getType='+getType;
     gpsitbarType=getType;
    if(gpsitbar_load[getType]=='1'){
    	showOneHidenOther(right_side_bottom,getType);
	}else{
	var url = AJAX_BASEURL+"group/getgpsitbarlist";
	var loader = new net.contentLoader(url,callbackgetgpsitbarlist,'','POST',params);
	getObject(getType).innerHTML='<div class="loading"></div>';
	showOneHidenOther(right_side_bottom,getType);
	}
}
//回调函数
function callbackgetgpsitbarlist(){
	getObject(gpsitbarType).innerHTML=this.req.responseText;
    gpsitbar_load[gpsitbarType]='1';
}
//显示或隐藏
function showORhidenId(id){
	var state=getObject(id).style.display;
	  if(state=='none'){
	  	getObject(id).style.display='block';
	  }else{
	  	getObject(id).style.display='none';
	  }
}
//发邮件
function showEmailDiv(fromname,toname){
	var user_id;
	var to_id;
	var messageBox=getObject('messageBox');
	var messageTitle=getObject('messageTitle');
	var messageBody=getObject('messageBody');
	messageTitle.innerHTML='发邮件邀请朋友';
	var html="";
	html+="<div class=\"con_listbig\"><span class=\"formlable\"><span class=\"darkgreen\">"+toname+"</span>的邮箱:</span>";
	html+="<span style=\"display:block;\" class=\"con_left\"><input id=\"toemail\" name=\"toemail\" style=\"width:200px;\" value=\"\" type=\"text\" /></span></div><div style=\"clear:both;\"></div>";
	html+="<div class=\"con_listbig\"><span class=\"formlable\">邮件内容：</span>";
	html+="<div class=\"con_left\"><textarea name=\"message\" id=\"message\" rows=\"8\" cols=\"40\" style=\"width:300px;height:175px; margin-left:10px;\">";
	html+="我的几个朋友开发了一个网站，叫卡地，现在正在进行测试。我的几个好友已经在上面激活了他们的账号。您还没有激活哦！如果你在卡地成为我的好友，你可以查看我的日程、日志、了解我的最新动态...赶快激活吧！";
	html+="</textarea></div><div style=\"clear:both;\"></div></div>";
	html+="<div id=\"mesFoot\"><input  type=\"button\" value=\"发 送\" onclick=\"postEmail('"+fromname+"','"+toname+"');\" />";
	  html+="<input type=\"button\" value=\"取 消\" onclick=\"hiden('messageBox');\" /></div>";
    messageBody.innerHTML=html;
	positionAndShow('messageBox');
}
function checkEmailValid(email){
	 var pattern = /[a-z0-9-]+(\.[a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
	 
	 if(!pattern.test(email)){
		return '0';
	}else{
		return '1';
	}
}
//发送邮件
function postEmail(fromname,toname){
	var toemail=getObject('toemail').value;
	var message=getObject('message').value;
	if(is_empty(toemail)){
		alert('您没有输入对方的电子邮箱！');
		return false;
	}
	/*
	if(checkEmailValid(toemail)=='0'){
		alert('您输入的电子邮箱不合法！');
		return false;
	}
	*/
	var params='toemail='+toemail+'&message='+message+'&fromname='+fromname+'&toname='+toname;
	var url = AJAX_BASEURL+"frie/postEmail";
	var loader = new net.contentLoader(url,callbackpostEmail,'','POST',params);
	getObject('messageBody').innerHTML='<div class="loading"></div>';
}
function callbackpostEmail(){
	getObject('messageBody').innerHTML=this.req.responseText;
	 setTimeout(function hendin(){hiden('messageBox');},2000);
}
//验证码部分//
/////////////////加载页面函数///////////////////
function addLoadEvent(func) 
{
  var oldonload = window.onload;
  if (typeof window.onload != 'function') 
  {
    window.onload = func;
  } 
  else 
  {
    window.onload = function() 
	{
      oldonload();
      func();
    }
  }	
}
function insertAfter(newElement,targetElement){
var parent = targetElement.parentNode;
if (parent.lastChild == targetElement) {
	parent.appendChild(newElement);
} else{
	parent.insertBefore(newElement,targetElement.nextSibling);
}
}
//获取列表
function checkCaptcha(){	
	if(getObject("yzm_captcha").value!=''){
	var params='Captcha='+getObject("yzm_captcha").value;    
	var url = AJAX_BASEURL+"user/checkCaptcha";
	new net.contentLoader(url,callbackcheckCaptcha,'','POST',params);	
    }
}

//回调函数
function callbackcheckCaptcha(){
	getObject("info_captcha").innerHTML=this.req.responseText;
    
}
function addCaptcha(){	
if(getObject("yzm_captcha")){
	getObject("yzm_captcha").onfocus=function(){			
			if(getObject("captchaimg")) return;
			var newimg=document.createElement("img");
			newimg.setAttribute("id","captchaimg");    
     		newimg.setAttribute("src",app_root+'/yzm/yazm.php?'+Math.random()); 
     		newimg.setAttribute("alt",'看不清楚，换一张');      		
     		newimg.setAttribute("title",'看不清楚，换一张');         		  		
     		newimg.style.marginLeft="10px";    	
     		insertAfter(newimg,this);
     		newimg.onclick=function(){     			
     			this.setAttribute("src",app_root+'/yzm/yazm.php?'+Math.random());     
     		}
	}
	getObject("yzm_captcha").onblur=checkCaptcha;	
  }
}
addLoadEvent(addCaptcha);
//////////////////////////////////////////////
