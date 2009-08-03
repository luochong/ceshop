

<p><span>发帖区</span>已有<?php echo $this->sum ?>人跟帖</p>
<form id="<?php echo $this->getFormId()?>">
		<textarea name="comment_content" ></textarea>
		<input type="button" value="马上发表" onclick="__doPostBack('<?php echo $this->getFormId()?>','addComment')" />
		
</form>

