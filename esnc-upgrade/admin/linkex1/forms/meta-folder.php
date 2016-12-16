<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Meta tag editor</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../images/style.css">
<style>
</style>
</head>
<body style="margin: 5px 0px 0px 10px;line-height:12px;">
<div class="text">&#272;&#7883;nh ngh&#297;a meta &#273;&#7889;i t&#432;&#7907;ng <strong><?php echo $this->name;?></strong></div>
<form action="<?php echo URL_SELF ?>?id=<?php echo $this->id ?>&act=<?php echo ACT_SAVE;?>&go=" method="post" >
<table cellpadding="1" cellspacing="1" width="95%"><tbody class="text">
<tr><td>Meta title</td><td><input type="text" class="input" name="title" value="<?php echo htmlspecialchars($this->title); ?>" style="width:650px; " /></td></tr>
<tr><td>Meta keywords</td><td><input type="text" class="input" name="keywords" value="<?php echo htmlspecialchars($this->m['keywords']); ?>"  style="width:650px; " /></td></tr>
<tr><td>Meta description</td><td><textarea class="input" name="description"  style="width:650px; "><?php echo $this->m['description']; ?></textarea></td></tr>
<tr><td><input type="checkbox" class="input input_mini" name="default" /></td><td>S&#7917; d&#7909;ng l&agrave;m meta m&#7851;u</td></tr>
</tbody></table>
</form>
<div class="text">
<a href="<?php echo URL_SELF ?>?id=<?php echo $this->id ?>&act=<?php echo ACT_REMOVE ?>&go=" onclick="this.href += encodeURIComponent(url_up);" class="item" style="color:blue; ">S&#7917; d&#7909;ng meta ng&#7847;m &#273;&#7883;nh</a><br/>

</div>
</body>
<script language="javascript" src="../js/library.js"></script>
<script language="javascript" src="../js.php"></script>
<script language="javascript">
var url_up =  '<?php echo URL_CWD ?>index.php?<?php echo CATALIAS ?>parentid=<?php echo $this->parentid;?>';
var url_del ='<?php echo URL_SELF ?>?id=<?php echo $this->id ?>&act=<?php echo ACT_REMOVE ?>&go=' + encodeURIComponent(url_up);
function doUp(){
	self.location.href=url_up;
}
function doSave(){
	f=document.getElementsByTagName('form').item(0);
	f.action += encodeURIComponent(url_up);
	f.submit();
}
function doDel(){
	self.location.href=url_del;
}
window.top.document.title=self.document.title;
</script>
</html>
