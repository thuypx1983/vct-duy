<html>
<head>
<title>Feedback Detail</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../../images/style.css">
<script language="javascript" src="../js/library.js"></script>
<script language="javascript" type="text/javascript" src="../js.php"></script>
</head>

<body>
<form id="idfrmItem" action="<?php echo URL_SELF ?>?<?php echo urlformat($this->q,'act',ACT_SAVE,'catid',$this->catid,'id',$this->id,'FBid',$this->id,'CFid',$this->catid) ?>" method="post" enctype="multipart/form-data">
<table width="100%" cellpadding="0" cellspacing="3" style="border:1px solid #CCCCCC">
	<tr><td colspan="2" class="text" bgcolor="#DFDFDF" style="padding:5px">Tr&#7843; l&#7901;i</td></tr>
	<tr><td class="text">G&#7917;i t&#7899;i</td><td><input name="email" type="text" class="input" value="<?php echo $this->email; ?>" style="width:100%"></td></tr>
	<tr><td class="text">Ch&#7911; &#273;&#7873;</td><td><input name="subject" type="text" class="input" value="RE: <?php echo $this->subject; ?>" style="width:100% "></td></tr>	
	<tr><td class="text" colspan="2"><textarea name="body" style="width:100%" rows="20" class="input">
===<?php echo "{$this->created}  {$this->name} ({$this->email})"; ?> vi&#7871;t===
<?php echo $this->body ?></textarea></td></tr>
	<tr><td class="text" title="B&agrave;i tr&#7843; l&#7901;i n&agrave;y &#273;&#432;&#7907;c hi&#7875;n th&#7883; nh&#432; m&#7897;t b&agrave;i ph&#7843;n h&#7891;i b&igrave;nh th&#432;&#7901;ng" style="cursor:help ">Hi&#7875;n th&#7883; b&agrave;i tr&#7843; l&#7901;i n&agrave;y <strong>(?)</strong> </td><td class="text"><input name="flag" type="checkbox" class="input" value="1" checked title="B&agrave;i tr&#7843; l&#7901;i n&agrave;y &#273;&#432;&#7907;c hi&#7875;n th&#7883; nh&#432; m&#7897;t b&agrave;i ph&#7843;n h&#7891;i b&igrave;nh th&#432;&#7901;ng"> (B&agrave;i tr&#7843; l&#7901;i n&agrave;y &#273;&#432;&#7907;c hi&#7875;n th&#7883; nh&#432; m&#7897;t b&agrave;i ph&#7843;n h&#7891;i b&igrave;nh th&#432;&#7901;ng)</td></tr>	
	<tr><td>&nbsp;</td><td style="padding:5px "><input type="submit" value="G&#7917;i &#273;i" class="input">&nbsp;<input type="button" value="B&#7887; qua" class="input" onClick="javascript:window.history.back();"></td></tr>
</table>
</form>	
</body>
</html>
<script language="javascript" type="text/javascript">
var frmItem = document.getElementById('idfrmItem');
function doSave(){
	if(frmItem.subject == ''){
	}
}
</script>
<?php dbclose(); ?>