<?php include_once("../prepend.include.php");?>
<div id='maincontent'>
/*comment_id int(10)  user_id int(10) from_id int(10)   from_type varchar(6) comment_content text   support_no int(8)  fight_no int(10)        
is_report int(5)  publish_time datetime   far_id int(10)*/
<script language="javascript" type="text/javascript" src="<?php echo APP_ROOT.'/js/new_prototype.js'; ?>"></script>
<script>
var ReplyClass = Class.create({
  /*
	initialize: function(name, sound) {
    this.name  = name;
    this.sound = sound;
  },
*/
  quote: function(id) {
    alert(id);
  },
  addToFav:function(id){
  	
  	
  },
  support:function(id){
  	
  },
  against:function(id){
  	
  },
  report:function(id){
  	
  	
  },
  
});

var Reply = new ReplyClass();
</script>
<style>
ul{
list-style-type:none;
}
ul.operations li {
float:left;
padding-left:1.2em;
}
</style>
<div style="border:1px solid #ccc;padding:5px;width:510px;">
<?php foreach ($page->data as  $v) :?>
	<div style="border:1px solid #666;padding:5px;margin:2px;">
	<div style="color:#1E50A2;font-size:12px;padding:2px">网友<?php echo $v['user_name']?>:</div>
	<div><?php echo $v['comment_content'] ?> </div>
	<ul class="operations">
                    <li><a href="#" onclick="return Reply.quote('<?php echo $v['comment_id']?>');">回复</a></li>
                    <li><a href="#" onclick="return Reply.addToFav('<?php echo $v['comment_id']?>');">转贴</a></li>
                    <li class="support"><a href="#" onclick="return Reply.support('<?php echo $v['comment_id']?>');">支持</a>[<span><?php echo $v['support_no'] ?></span>]</li>
                    <li class="against"><a href="#" onclick="return Reply.against('<?php echo $v['comment_id']?>');">反对</a>[<span><?php echo $v['fight_no'] ?></span>]</li>
                    <li><a href="#" onclick="return Reply.report('<?php echo $v['comment_id']?>');">举报</a></li>
     </ul>
	<div style="clear:both"></div>
	
	</div>
<?php endforeach;?>

</div>












<?php
$ctrl = $page->LoadControl('commentControl');

$ctrl->setoption($page->form,$page->form_id);
$ctrl->Rend();
unset($ctrl);
?>






</div><!--end maincontent-->





<?php include_once("append.include.php");?>