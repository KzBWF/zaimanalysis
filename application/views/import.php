<!-- 
<form action="import/read" method="post" enctype="multipart/form-data">
 -->
<?php echo form_open_multipart('import/read');?>
<p>
ファイルを選択して下さい<br />
<input type="file" name="filename" />
</p>
<input type="submit" name="read" value="読込" />
</form>
