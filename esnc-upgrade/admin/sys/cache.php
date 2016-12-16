<?php define('MAGIC_QUOTES_OFF',TRUE);
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
//for administrative console configuration
require '../config.php';
require PATH_CLASS.'cache.php';
$cache = (int)$_GET['cache'];
switch($act){
case ACT_MOVE://change and clear
	cache::clear();
	cache::toggle($cache==1);
	$rs = glob(PATH_ESNC.'*.php');
	//recompiled all templates exept index.php
	foreach($rs as $ff)
		if(strpos($ff,'index.php') === FALSE || !defined('FILE_DEFAULT')){	chmod($ff,0700);touch($ff,1000);}
	break;
case ACT_DEL://clear temporary file
	cache::clear();
	break;
case ACT_SAVE: //no remove cache
	cache::toggle($cache==1);//no clear cache
	break;
}
?><html>
<head><title>&#272;i&#7873;u khi&#7875;n b&#7897; &#273;&#7879;m</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link href="images/style.css" rel="stylesheet" type="text/css" />
<style>
</style>
</head>
<body class="text" style="margin-left:10px; ">
<table><tr><td valign="top">
<fieldset style="width:400px;margin-top:30px;line-height:18px;font-size:12px; ">
<legend style="padding-left:15px;padding-right:15px">&#272;i&#7873;u khi&#7875;n b&#7897; &#273;&#7879;m</legend>
Sau khi x&#7917; l&#253; xong m&#7897;t trang web, m&#225;y ch&#7911; s&#7869; l&#432;u trang &#273;&oacute; l&#7841;i v&agrave;o b&#7897; &#273;&#7879;m. N&#7871;u m&#7897;t ng&#432;&#7901;i d&ugrave;ng kh&aacute;c
y&ecirc;u c&#7847;u ngay trang &#273;&oacute;, m&aacute;y ch&#7911; s&#7869; l&#7845;y ngay b&#7897; &#273;&#7879;m ra m&agrave; kh&ocirc;ng x&#7917; l&yacute; l&#7841;i n&#7919;a. &#272;i&#7873;u n&agrave;y s&#7869; l&agrave;m t&#259;ng t&#7889;c
truy c&#7853;p c&#7911;a kh&aacute;ch h&agrave;ng. B&#7841;n c&oacute; th&#7875; &#273;i&#7875;u khi&#7875;n b&#7897; &#273;&#7879;m n&agrave;y theo &yacute; m&igrave;nh. Khi b&#7897; &#273;&#7879;m &#273;ang b&#7853;t, b&#7841;n kh&ocirc;ng th&#7875; th&#7845;y
c&aacute;c thay &#273;&#7893;i c&#7911;a m&igrave;nh cho t&#7899;i khi b&#7841;n tho&aacute;t kh&#7887;i h&#7879; qu&#7843;n tr&#7883;, b&#7903;i v&igrave; m&aacute;y ch&#7911; s&#7869; &#273;&#7885;c trang web t&#7915; b&#7897; &#273;&#7879;m ch&#7913; kh&ocirc;ng l&#7845;y d&#7919; li&#7879;u b&#7841;n &#273;ang c&#7853;p nh&#7853;t. Khi b&#7897; &#273;&#7879;m t&#7855;t, c&aacute;c s&#7889; li&#7879;u b&#7841;n &#273;ang c&#7853;p nh&#7853;t s&#7869; &#273;&#432;&#7907;c nh&igrave;n th&#7845;y ngay.
<form action="<?php echo URL_SELF ?>" style="display:block; padding-top:30px;" id="idfrmCache">
<input type="hidden" name="act" value="<?php echo ACT_MOVE ?>"/>
<?php if(CACHE_OFF & 1){?>
<br/><strong style="color:red ">&#272;&#7879;m hi&#7879;n kh&ocirc;ng s&#7917; d&#7909;ng, t&#7889;c &#273;&#7897; ch&#7841;y  s&#7869; gi&#7843;m. B&#7841;n c&oacute; th&#7875; thay &#273;&#7893;i trong c&#7845;u h&igrave;nh h&#7879; th&#7889;ng
</strong>
<?php } else{ ?>
<span style="vertical-align:middle; display:block "><input class="input" type="radio" value="1" name="cache" <?php if(is_writable(PATH_CACHE)) echo 'checked';?> />  B&#7853;t, c&#225;c thay &#273;&#7893;i ch&#7881; c&#243; t&#225;c d&#7909;ng khi b&#7841;n tho&#225;t ra.</span>
<?php }?>
<span style="vertical-align:middle; display:block "><input class="input" type="radio" value="0" name="cache" <?php if(!is_writable(PATH_CACHE) || (CACHE_OFF & 1)) echo 'checked';?> />  T&#7855;t, b&#7841;n s&#7869; xem &#273;&#432;&#7907;c ngay nh&#7919;ng thay &#273;&#7893;i &#273;ang th&#7921;c hi&#7879;n</span>
<span style="text-align:center;vertical-align:middle; display:block;padding:10px; "><input type="submit" class="button" value="Th&#7921;c hi&#7879;n thay &#273;&#7893;i v&#224; xo&#225; b&#7897; &#273;&#7879;m"/></span>
</fieldset>
</form>
</td><td valign="top">
<form action="<?php echo URL_SELF ?>" style="display:block; ">
<input type="hidden" name="act" value="<?php echo ACT_DEL ?>"/>
<fieldset style="width:250px;margin-top:30px; line-height:18px;font-size:12px;">
<legend style="padding-left:15px;padding-right:15px">Th&#432; m&#7909;c t&#7841;m th&#7901;i</legend>
Th&#432; m&#7909;c t&#7841;m th&#7901;i l&agrave; n&#417;i l&#432;u c&aacute;c d&#7919; li&#7879;u trung gian. V&iacute; d&#7909; khi b&#7841;n t&#7843;i l&ecirc;n (upload) &#7843;nh, &#273;&#7847;u ti&ecirc;n, &#7843;nh &#273;&#432;&#7907;c l&#432;u v&agrave;o th&#432; m&#7909;c t&#7841;m th&#7901;i tr&#432;&#7899;c r&#7891;i khi b&#7841;n th&#7921;c s&#7921; ch&#7845;p nh&#7853;n (save) l&#7841;i th&igrave; &#7843;nh m&#7899;i chuy&#7875;n sang th&#432; m&#7909;c &#7843;nh th&#7921;c (nh&#432; th&#432; m&#7909;c &#7843;nh s&#7843;n ph&#7849;m, &#7843;nh tin t&#7913;c...). N&#7871;u b&#7841;n t&#7843;i &#7843;nh kh&aacute;c l&ecirc;n, th&igrave; &#7843;nh c&#361; v&#7851;n n&#7857;m trong th&#432; m&#7909;c t&#7841;m th&#7901;i. Sau m&#7897;t th&#7901;i gian ho&#7841;t &#273;&#7897;ng, th&#432; m&#7909;c t&#7841;m th&#7901;i c&oacute; th&#7875; &#273;&#7847;y d&#7919; li&#7879;u r&aacute;c v&agrave; b&#7841;n n&ecirc;n xo&aacute; &#273;i. 
<span style="text-align:center;vertical-align:middle; display:block;padding:10px; "><input type="submit" class="button" value="X&oacute;a n&#7897;i dung th&#432; m&#7909;c t&#7841;m th&#7901;i"/></span>
</fieldset>
</form>
</td></tr>
</table>
</body>
</html>
<script language="javascript">
function doSave(){
	f=document.getElementById('idfrmCache');
	f.act.value = ACT_SAVE;
	f.submit();
}
function doNew(){};
function doMove(){};
function doDel(){};
var ACT_SAVE = '<?php echo ACT_SAVE; ?>';
window.top.document.title=self.document.title;
</script>
