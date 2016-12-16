<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	echo "<script language='javascript'>window.top.location='../';</script>";
	exit();
}
require '../config.php';
function showsysmenuitem($ctrl,$href,$key,$text,$tip='',$target='content'){ 
if(!$ctrl) return;
if($key != '') $text = str_replace($key,"<FONT STYLE='text-decoration:underline'>{$key}</font>",$text);
	if(strpos($href,'javascript:') === FALSE){ //only show <a> tag for none script
?><li class="sysmenu"><a  HREF="<?php echo URL_ADMIN.$href ?>"  class="item" ACCESSKEY="<?php echo $key ?>" target="<?php echo $target ?>" title="<?php echo $tip ?>"><?php echo $text ?></a></li>
<?php }//if $href not containt javascript
	else {?><li class="sysmenu"><a href="#"  onclick="<?php echo $href ?>;return false;"  class="item" title="<?php echo $tip ?>"><?php echo $text ?></a></li>
<?php	}
}//function showmenubaritem
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Customer Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link type="text/css" rel="stylesheet" href="images/style.css">
</head>
<body bgcolor="#688BDC" style=" margin:5px 2px 5px 12px">
<strong class="text">Quan h&#7879; kh&aacute;ch h&agrave;ng</strong><ul class="sysmenu">
<?php
	showsysmenuitem(MODULE_ORDER,"order/item-list.php",'D',"&#272;&#417;n h&agrave;ng",'Qu&#7843;n l&yacute; &#273;&#417;n h&agrave;ng &#273;&atilde; &#273;&#7863;t tr&ecirc;n website');	
if(MODULE_MEMBER){
	if(isset($CUSTOMER_TYPE)){
		foreach($CUSTOMER_TYPE as $key=>$value){
			showsysmenuitem(1,'customer/item-list.php?CStype='.$key,'',$value);
		}
	}
	else
		showsysmenuitem(1,'customer/item-list.php','','Th&agrave;nh vi&ecirc;n','C&aacute;c th&agrave;nh vi&ecirc;n &#273;&atilde; &#273;&#259;ng k&yacute; qua web');
}
showsysmenuitem(MODULE_FEEDBACK,'feedback/item-list.php?FBkeyword=INBOX','','Ph&#7843;n h&#7891;i nh&#7853;n','C&aacute;c ph&#7843;n h&#7891;i &#273;&atilde; nh&#7853;n t&#7915; kh&aacute;ch h&agrave;ng');
showsysmenuitem(MODULE_FEEDBACK,'feedback/item-list.php?FBkeyword=Re:','','Ph&#7843;n h&#7891;i &#273;&atilde; g&#7917;i','C&aacute;c ph&#7843;n h&#7891;i &#273;&atilde; g&#7917;i cho kh&aacute;ch h&agrave;ng');
?></ul>
</body>
</html>
