<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
$session->getaccess(SESSION_CTRL_ADMIN) OR exit();
require '../config.php';
require PATH_ADMIN.'inc/dbcon.php';
require PATH_CLASS.'tool.php';
$sql = 'SELECT `id`,`name`,`access`,`file` FROM `'.DB_TABLE_PREFIX.'tool` WHERE `ctrl` & 1073741824=1073741824';//0x40000000: show on system menu 40000000
$rs = mysql_query($sql);
$a_tool=array();
while($a_tool[]=@mysql_fetch_object($rs));
array_pop($a_tool);//fetch all tool
dbclose();
function showsysmenuitem($ctrl,$href,$key,$text,$tip='',$target='content'){ 
if(!$ctrl) return;
if($key != '') $text = str_replace($key,"<FONT STYLE='text-decoration:underline'>{$key}</font>",$text);
	if(strpos($href,'javascript:') === FALSE){ //only show <a> tag for none script
?><li class="sysmenu"><a  href="<?php echo URL_ADMIN.$href ?>"  class="item" accesskey="<?php echo $key ?>" target="<?php echo $target ?>" title="<?php echo $tip ?>"><?php echo $text ?></a></li>
<?php }//if $href not containt javascript
	else {?><li class="sysmenu"><a href="#"  onClick="<?php echo $href ?>;return false;"  class="item" title="<?php echo $tip ?>"><?php echo $text ?></a></li>
<?php	}
}//function showmenubaritem
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>H&#7879; th&#7889;ng</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link type="text/css" rel="stylesheet" href="images/style.css">
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
</head>
<body bgcolor="#688BDC" style=" margin:5px 2px 5px 12px">
<br/><strong class="text">H&#7879; th&#7889;ng</strong><ul class="sysmenu" >
<?php
	showsysmenuitem(1,'sys/cache.php','','&#272;i&#7873;u khi&#7875;n b&#7897; &#273;&#7879;m'.(CACHE_OFF & 1 ? ' (off)':''),'B&#7897; &#273;&#7879;m l&#224; n&#417;i l&#432;u c&#225;c trang web sau khi x&#7917; l&#253; xong &#273;&#7875; ng&#432;&#7901;i d&#249;ng v&#224;o nhanh h&#417;n');
	showsysmenuitem(1,'myaccount.php','','Th&ocirc;ng tin t&agrave;i kho&#7843;n','Thay &#273;&#7893;i m&#7853;t kh&#7849;u,t&ecirc;n,&#273;i&#7879;n tho&#7841;i....c&#7911;a ban');
	showsysmenuitem($session->getaccess(SESSION_CTRL_ADMIN,MODULE_USER,ACCESS_READ),'user/item-list.php','','Ban qu&#7843;n tr&#7883;');
	showsysmenuitem(1,'files/item-list.php?FLid=0&FFext=0','','Th&ocirc;ng tin t&#7841;m th&#7901;i','C&aacute;c t&#7853;p tin t&#7841;m th&#7901;i trong qu&aacute; tr&igrave;nh x&#7917; l&yacute;');
	showsysmenuitem(1,'files/explorer.php?FLid=3','','Th&#432; vi&#7879;n d&ugrave;ng chung','C&aacute;c t&#7853;p tin, &#7843;nh...d&ugrave;ng chung');
	showsysmenuitem($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_READ|ACCESS_WRITE),'files/item-list-sysfile.php','','Th&ocirc;ng tin h&#7879; th&#7889;ng','Thay &#273;&#7893;i th&ocirc;ng tin li&ecirc;n h&#7879;,b&#7843;n quy&#7873;n....');
	showsysmenuitem(1,'files/item-list-metafile.php','','Th&ocirc;ng tin &#273;&#7863;c bi&#7879;t','Meta, title, keywords...');
	showsysmenuitem($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_READ) ,'sys/sce.php','','C&#7845;u h&igrave;nh h&#7879; th&#7889;ng','Thay &#273;&#7893;i c&#7845;u h&igrave;nh h&#7879; th&#7889;ng (ch&#7881; d&agrave;nh cho chuy&ecirc;n gia)');
	showsysmenuitem($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_READ),'sys/lte.php','','Thay &#273;&#7893;i t&#7915; ng&#7919;','&#272;&#7893;i c&aacute;c t&#7915; nh&#432;: &#273;&#259;ng nh&#7853;p, &#273;&#259;ng k&yacute;, trang ch&#7911;, xin ch&agrave;o...');
	showsysmenuitem($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_READ),'sys/ale.php','','C&aacute;c th&ocirc;ng b&aacute;o','Thay &#273;&#7893;i c&aacute;c th&ocirc;ng b&aacute;o tr&ecirc;n tr&igrave;nh duy&#7879;t: nh&#7853;p email...');
	showsysmenuitem($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_READ),'pte.php?FLid=1&filename=style.css&title=Thay+%26%23273%3B%26%237893%3Bi+tr%26igrave%3Bnh+b%26agrave%3By&mode=embed','','Thay &#273;&#7893;i tr&igrave;nh b&agrave;y','Thay &#273;&#7893;i m&agrave;u s&#7855;c,...');
foreach($a_tool as $tool)
		showsysmenuitem($session->getAccess(SESSION_CTRL_ADMIN,MODULE_SYS,$tool->access),Tool::absToolUrl('tool/item.php',NULL,NULL,NULL,$tool->file,$tool->id),'',$tool->name);
	showsysmenuitem($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_BACKUP),'sys/bkup.php','','Sao l&#432;u d&#7919; li&#7879;u');		
	showsysmenuitem($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_READ),'sys/footer.php','','Quản lý footer','Quản lý footer cho mỗi trang-dành cho marketing online');
	?>
</ul>
</body>
</html>
