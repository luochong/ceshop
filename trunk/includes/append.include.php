<?php
//*******************************//
///		����PHPҳ��ִ����Ϻ���ƺ��?
//******************************//

if ($pre_process)
{
	
	
	$frontCtrl->loadFooter();
	
	if($pre_page=='home' ||$pre_page=='gphv'){
		include("homefooter.include.php");
	}else {
		include("pagefooter.include.php");
	}
	
	// ���Page����(����unload����)
	if (isset($page))
	{		
		unset($page);
	}	
	
	$frontCtrl->endCache();
	
}










?>
