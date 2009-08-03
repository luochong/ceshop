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

function getbyid(id){	
	return document.getElementById(id);	
}
function IDisNull(id){
	if(getbyid(id) == null){
		return true;
	}else{
		return false;
	}
}

function hiden(id){	
	getbyid(id).style.display = 'none';	
}

function show(id){	
	getbyid(id).style.display = 'block';	
}

function getdisplay(id){	
	return getbyid(id).style.display;
}

/*tab 控件*/
function TabEvent(box_id,menu_id){	
	var i = 1;
	var boxs_id =Array();
	while(!IDisNull('tabbox'+i)){		
		boxs_id[i] = 'tabbox'+i;
		i++;		
	}
  for(var i = 1;i<boxs_id.length;i++){		
		hiden(boxs_id[i]);
		getbyid('tabmenu'+i).className = "";
	}
		getbyid(menu_id).className = "selected";
		show(box_id);
}

function bingTabEvent(){
	var tabs_id =Array();
	var i = 1;
	while(!IDisNull('tabmenu'+i)){		
		tabs_id[i] = 'tabmenu'+i;		
		getbyid(tabs_id[i]).onclick = new Function('TabEvent(\'tabbox'+i+'\',\'tabmenu'+i+'\')');		
		i++;		
	}	
}
addLoadEvent(bingTabEvent);
 function getObject(id) {
	if (document.getElementById(id)) {
		return document.getElementById(id);
	} else if(document.all) {
		return document.all[id];
	} else if(document.layers) {
		return document.layers[id];
	}
}




