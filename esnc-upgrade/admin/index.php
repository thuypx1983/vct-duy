<?php require('../config.php');
require_once('./inc/common.php');
require('./inc/session.php');
require './config.php';
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	echo "<script language='javascript'>
        window.top.location='../';</script>";
	exit();
}
function showmenubaritem($ctrl,$href,$key,$text,$tip='',$target='content'){
	if($ctrl){
		echo '<a href="';
		if(strpos($href,'javascript') !== FALSE) {
			echo '#" onclick="';echo $href;echo 'return false;"';
		}else{
			echo $href;echo '" target="'.$target.'"';//only show target for pure link
		}
		echo ' CLASS="menu" title="'.$tip.'">';
		echo str_replace($key,"<FONT STYLE='text-decoration:underline'>{$key}</font>",$text);
		echo '</a>';
	}
}
function showtoolbaritem($img,$action,$tip,$ctrl=1,$style='class="imgbutton" style="float:left;width:22px;height:22px;"'){ 
	global $st;
	$t = basename($img);
	$t{0} = strtoupper($t{0});
	$t = preg_replace('/\.[^\.]+/','',$t);
	$action= str_replace('parent.content.','window.top.content.',$action);
	if($ctrl)	echo '<DIV onClick="try{ '.$action.' }catch(EE){window.top.banner.setStatus(\'Ch&#7913;c n&#259;ng kh&ocirc;ng h&#7895; tr&#7907;\');}" title="'.$tip.'" id="bn'.$t.'" '.$style.' >&nbsp;</div>';
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title>ESNC.Net - h&#7879; th&#7889;ng xu&#7845;t b&#7843;n th&ocirc;ng tin &#273;i&#7879;n t&#7917;</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css">
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css">
</comment>
<script language="javascript" src="js/csseventselector-rule.js"></script>
<script language="javascript">
var ie = document.all?true:false;
iens6=document.all||document.getElementById;
ns4=document.layers;
function showLeftPane(){
	if(leftPane.style.display == '') { leftPane.style.display = 'none'; leftPane.style.width = 0; rightPane.style.width = '100%';}
	else{leftPane.style.display = ''; leftPane.style.width = '20%'; rightPane.style.width = '80%';}
}
function showmodule(url1,url2){
	left.location.href = URL_ADMIN + url1;
	content.location.href = URL_ADMIN + url2;
}
function ClipBoard(){
	this.id="";//keep id list
	this.name="";//keep name
	this.type=0;//null
	this.cut = false;//normal action is cut
	this.setPasteMessage = function(msg){
		btnPaste.title = msg;
	}
}
function BANNER(){
	this.setStatus = function (msg,autoclose){
		statusLine.innerHTML = msg + '&nbsp;&nbsp;<strong class="textbutton" title="&#272;&oacute;ng d&ograve;ng th&ocirc;ng b&aacute;o"  onclick="statusLine.innerHTML=\'&nbsp;Xin ch&agrave;o <?php echo $_SESSION['USname'];?>\'">X</strong>';
		if(autoclose == false) return;
		try{self.clearTimeout(this.activeTimeout);}catch(e){}
		this.activeTimeout=self.setTimeout("document.getElementById('idstatusLine').innerHTML ='&nbsp;Xin ch&agrave;o <?php echo $_SESSION['USname'];?>'",10000);
	}
	this.ask = function(msg){
		return window.top.confirm(msg);
	}
}
function hide(o){
	if (o.style.width == '20px'){
		o.parentNode.style.width = "20%";
		o.style.width = '100%';
		o.innerHTML = 'Kh&#233;p';
	}else{
		o.parentNode.style.width="1%";
		o.style.width='20px';
		o.innerHTML = 'M&#7903;&nbsp;';
	}
}
function hover(o,bcolor,fcolor){
	o.style.backgroundColor = bcolor;
	o.style.color = fcolor
}
</script>
<style>
body{overflow:auto;}
tr#toolbar,tr#menubar{background-color:#F2F1EB;height:25px;}
tr#toolbar td{border-bottom:1px ridge #ACA899}
tr#menubar td{border-bottom:1px solid #CCCCCC;}
tr#menubar td a{padding-right:15px;}
#idstatusLine{color:red; text-align:right; display:inline;width:300px;float:right;padding-right:40px;}
.textbutton,.textbutton-hover,.imgbutton,.imgbutton-hover,.flatbutton,.flatbutton-hover{
behavior:url('js/IEhover.htc');
}
</style>
</head>
<body style="margin:0px auto 0px auto" class="text">
<table cellpadding="0" cellspacing="0" width="100%" align="center" border=0>
<tr id="menubar"><td colspan="2" valign="middle" onclick="document.getElementById('newitemmenu').style.visibility='hidden';">
<?php showmenubaritem(1,URL_ROOT,'a','Trang ch&#7911;','Xem trang ngo&agrave;i','_blank'); 
showmenubaritem(1,'index.php','a','Admin-home','Xem trang ngo&agrave;i','');
showmenubaritem(MODULE_NEWS,"javascript:parent.showmodule('news/tree.php','news/index.php?CNparentid=-1');","h",MENU_NEWS,'Qu&#7843;n l&yacute; n&#7897;i dung th&ocirc;ng tin website');
showmenubaritem(MODULE_PRODUCT,"javascript:parent.showmodule('product/tree.php','product/index.php?CPparentid=-1');","S",MENU_PRODUCT,'Qu&#7843;n l&yacute; s&#7843;n ph&#7849;m');
showmenubaritem(MODULE_BANNER,"javascript:parent.showmodule('banner/tree.php','banner/index.php?CBparentid=-1');","L",MENU_BANNER,'C&aacute;c li&ecirc;n k&#7871;t th&#432;&#7901;ng d&ugrave;ng (v&#7899;i site kh&aacute;c v&agrave; trong n&#7897;i b&#7897; site)');
showmenubaritem(MODULE_FILE,"javascript:parent.showmodule('files/tree.php','files/index.php');","n","So&#7841;n th&#7843;o","C&aacute;c n&#7897;i dung t&#297;nh nh&#432;: b&#7843;n quy&#7873;n, th&ocirc;ng tin li&ecirc;n h&#7879;....");
showmenubaritem(1,"javascript:parent.showmodule('sys/tree.php','sys/index.php');","&#7879;","H&#7879; th&#7889;ng","C&#225;c ch&#7913;c n&#259;ng h&#7879; th&#7889;ng");
showmenubaritem(1,"logoff.php","o","Tho&#225;t",'Tho&aacute;t kh&#7887;i h&#7879; th&#7889;ng','_top');
showmenubaritem(0,"javascript:openSupport(window.location.host);",'H','H&#7895; tr&#7907;','K&#7871;t n&#7889;i v&#7899;i h&#7879; th&#7889;ng h&#7895; tr&#7907; tr&#7921;c tuy&#7871;n c&#7911;a ESNC.NET');
showmenubaritem(0,'http://www.esnc.net/help/esnc-c.html','',"<font color='#FF0000' style='font-weight:bold '>H&#432;&#7899;ng d&#7851;n qu&#7843;n tr&#7883;</font>",'Xem h&#432;&#7899;ng d&#7851;n s&#7917; d&#7909;ng','_blank');
?></td></tr>
<tr id="toolbar"><td>&nbsp;</td><td valign="middle" style="padding-left:20px " nowrap><div style="float:left ">
<?php
echo '<span>'; 
showtoolbaritem('images/new.gif','parent.content.doNewItem();','T&#7841;o &#273;&#7889;i t&#432;&#7907;ng m&#7899;i');
echo '<div id="newitemmenu" style="visibility:hidden;border:1px solid #CCCCCC;background:#FFFFFF;position:absolute;z-index:1"><ul class="itemMenu">';
foreach($PRODUCT_TYPE as $key=>$value){
echo '<li onMouseOver="hover(this,\'#0066CC\',\'#FFFFFF\');" onMouseOut = "hover(this,\'#FFFFFF\',\'#000000\');" class="submenu" onClick="parent.content.doNewItemByType('.$key.');" ><span>T&#7841;o m&#7899;i '.$value.'</span></li>';
}
echo '</ul></div></span>';
showtoolbaritem('images/newfolder.gif','parent.content.doNew();','T&#7841;o nh&oacute;m m&#7899;i');
showtoolbaritem('images/print.gif','','',0);
showtoolbaritem('images/up.gif','parent.content.doUp();','Chuy&#7875;n l&ecirc;n 1 m&#7913;c, n&#7871;u &#7903; m&#7913;c ngo&agrave;i c&ugrave;ng th&igrave; s&#7869; li&#7879;t k&ecirc; t&#7845;t c&#7843;');
showtoolbaritem('images/moveto.gif','parent.content.doCut(clipboard);','Xo&aacute; v&agrave; chuy&#7875;n c&aacute;c &#273;&#7889;i t&#432;&#7907;ng &#273;&#432;&#7907;c &#273;&aacute;nh d&#7845;u v&agrave;o b&#7897; nh&#7899; &#273;&#7879;m');
showtoolbaritem('images/copy.gif','parent.content.doCopy(clipboard);','L&#432;u m&#7897;t b&#7843;n sao c&#7911;a c&aacute;c &#273;&#7889;i t&#432;&#7907;ng &#273;&#432;&#7907;c &#273;&aacute;nh d&#7845;u v&agrave;o b&#7897; &#273;&#7879;m');
showtoolbaritem('images/paste.gif','parent.content.doPaste(clipboard);','');
showtoolbaritem('images/delete.gif','parent.content.doDel();','Xo&aacute; c&aacute;c &#273;&#7889;i t&#432;&#7907;ng &#273;&#432;&#7907;c &#273;&aacute;nh d&#7845;u');
showtoolbaritem('images/search.gif','window.top.content.doSearch();','T&igrave;m ki&#7871;m');
showtoolbaritem('images/hyperlink.gif','parent.content.doLink(clipboard);','Qu&#7843;n l&yacute; c&aacute;c &#273;&#7889;i t&#432;&#7907;ng li&ecirc;n k&#7871;t',0);
showtoolbaritem('images/btn_leftrefresh.gif','parent.left.location=parent.left.location;','&#272;&#7891;ng b&#7897; ho&aacute; d&#7919; li&#7879;u');
showtoolbaritem('images/save.gif','parent.content.doSave();','Ghi l&#7841;i thay &#273;&#7893;i');
showtoolbaritem('images/mail.gif','parent.content.doMail();','G&#7917;i Email',MODULE_MARKETING);
showtoolbaritem('images/x-button.gif','parent.content.doUp();','&#272;&oacute;ng n&#7897;i dung l&agrave;m vi&#7879;c, tr&#7903; v&#7873; m&#7909;c tr&#432;&#7899;c');
showtoolbaritem('ymsupport.gif',"window.top.open('ymsgr:sendIM?esncteam');",'YM!',1,'class="imgbutton" style="float:left;width:80px;height:22px;"');
?></div><div id="idstatusLine" title="D&ograve;ng hi&#7875;n th&#7883; th&ocirc;ng b&aacute;o h&#7879; th&#7889;ng">&nbsp;</div>
</td></tr>
<tr height="781">
	<td onclick="document.getElementById('newitemmenu').style.visibility='hidden';" width="200px" style="border-right:1px ridge #C0C0C0;border-bottom:1px ridge #C0C0C0; background-color:#FCFCF9;" marginheight="0" marginwidth="0"  valign="top" id="idleftPane" height="520px">
		<div style="background-color:#ECE9D8;height:20px;text-align:right;cursor:pointer;width:100%;" onclick="hide(this);">Kh&#233;p</div><iframe style="overflow-y:visible; " marginheight="0" marginwidth="0"   name="left" src="sys/tree.php" scrolling="auto" frameborder="0" height="760" width="199px"></iframe>
	</td>
	<td valign="top" id='idrightPane' style="padding:0px;border-bottom:1px ridge #C0C0C0;margin:0px;" ><iframe src="forms/item-home.php" style="overflow-y:visible;overflow-x:hidden;padding:0px;margin:0px;" marginheight="0" marginwidth="0" height="760" name="content" src="about:blank" scrolling="auto" frameborder="0" width="100%"></iframe></td>
</tr>
</table>

<script type="text/javascript">
if (iens6){
document.write("<div id='viewer' style='background-color:#FFFFCC;visibility:hidden;position:absolute;bottom:0px;left:0;width:0;height:0;z-index:1;overflow:hidden;border:0px ridge white'></div>")
}
if (ns4){
	hideobj = eval("document.nsviewer")
	hideobj.visibility="hidden"
}
</script>
<script language="javascript" src="js.php"></script>
<script language="javascript" type="text/javascript" defer>
var leftPane = document.getElementById('idleftPane'),rightPane=document.getElementById('idrightPane');
var statusLine = document.getElementById('idstatusLine');
var btnPaste = document.getElementById('bnPaste');
var banner = new BANNER;
var	clipboard = new ClipBoard();
<?php if( $session->getAccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){?>
var i = new Image();
window.setInterval("i.src='touch.php?' + Math.random();",960000);//this is to keep the session alive
<?php } ?>
</script>
</body>
</html>
