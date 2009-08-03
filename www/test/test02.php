<?php include_once("../prepend.include.php");?>




<?php
$ctrl = $page->LoadControl('testauthControl');
$ctrl->Rend();
unset($ctrl);

$ctrl = $page->LoadControl('testcontrol');
$ctrl->Rend();
unset($ctrl);


?>


<a href="<?php echo $page->makeAjaxUrl('show')?>">testajax</a>











<?php include_once("append.include.php");?>