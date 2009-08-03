<html>
<head>
<script type="text/javascript"> 
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

</script>
</head>
<body>
<?php echo __FILE__?>






