<html>
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $this->doctitle ?></title>
<link type="text/css" rel="stylesheet" href="images/style.css" />
<style type="text/css">
img.rteBtNom,img.rteBtNom-hover{behavior:url(js/IEhover.htc);}
</style>
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
<link type="text/css" rel="stylesheet" href="images/rtestyle.css"/>
<script language="javascript" type="text/javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" type="text/javascript" src="js/rte.js"></script>
<script language="javascript" type="text/javascript" src="js/tooltip.js"></script>
<script language="javascript" type="text/javascript" src="js/tip.js"></script>
</head>
<body class="text">
<form action="<?php echo URL_SELF."?act=".ACT_SEND; ?>" method="post"  id="idfrmItem" onSubmit=" return checkForm(idfrmItem);">	
<table width="100%" border="0">
<tr>
	<td width="8%"><div>Ng&#432;&#7901;i G&#7917;i </div></td>
	<td width="92%"><input type="text" name="from" style="width:100% " value="<?php echo $this->sender; ?>"></td>
</tr>
<tr>
	<td width="8%"><div>Ng&#432;&#7901;i Nh&#7853;n </div></td>
	<td><textarea name="to" style="width:100% " class="input"><?php echo $this->recipient; ?></textarea></td>
</tr>
<tr>
	<td width="8%"><div>CC </div></td>
	<td><input type="text" name="cc" value="" style="width:100% "></td>
</tr>
<tr>
	<td width="8%"><div>Ti&ecirc;u &#273;&#7873; </div></td>
	<td><input type="text" name="subject" value=""  style="width:100% "></td>
</tr>

<tr><td colspan="2">
<?php
	$rte = new RTE('oRte','images/rteimages/',0x7FFFFFFF & ~ 0x00000020);				
	$rte->show('content',$this->content,'280px');
?>
</td></tr>
<tr>
	<td align="center" colspan="2"><input type="submit" name="bn_send" value="<?php echo BUTTON_SEND;?>" class="button" /></td>
</tr>
</table>
</form>
<?php RTE::loadRTEDialog();?>
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var self_id = '<?php echo $this->id;?>';
var frmItem = document.getElementById("idfrmItem");
var imgImg1 = document.getElementById('idimgImg1');
var imgImg2 = document.getElementById('idimgImg2');
var imgImg = document.getElementById('idimgImg');
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo  URL_ADMIN.'/email/item-list.php';?>';
var url_newitem='#';
function checkForm(f){
	oRte.rteToInput();
	if(f.from.value == ''){
		parent.banner.setStatus("ph&#7843;i nh&#7853;p ng&#432;&#7901;i g&#7917;i");
		f.from.focus();return false;
	}if(f.to.value == ''){
		parent.banner.setStatus("kh&ocirc;ng x&aacute;c &#273;&#7883;nh ng&#432;&#7901;i nh&#7853;n");
		f.to.focus();return false;
	}if(f.subject.value == ''){
		parent.banner.setStatus("th&#432; c&#7847;n c&oacute; ti&ecirc;u &#273;&#7873;");
		f.subject.focus();return false;
	}
	sender();
}
</script>
<script language="javascript" type="text/javascript">
function doSave(){
	doMail();
}
function doMail(){
	if(checkForm(frmItem)) frmItem.submit();

}
</script>
<?php 
$rte->initRteObjectScript();
dbclose(); ?>