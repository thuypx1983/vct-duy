<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Meta tag editor</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="images/style.css" />
<style>
</style>
</head>
<body style="margin: 5px 0px 0px 10px;line-height:14px;">
<div class="text">&#272;&#7883;nh ngh&#297;a meta cho &#273;&#7889;i t&#432;&#7907;ng <strong><?php echo $this->name;?></strong></div>
<form action="<?php echo URL_SELF ?>?id=<?php echo $this->id ?>&act=<?php echo ACT_SAVE;?>&go=" method="post" >
<table cellpadding="1" cellspacing="1" width="95%"><tbody class="text">
<tr><td>Meta title</td><td><input type="text" class="input" name="title" value="<?php echo htmlspecialchars($this->title); ?>" style="width:650px; " /></td></tr>
<tr><td>Meta keywords</td><td><input type="text" class="input" name="keywords" value="<?php echo htmlspecialchars($this->m['keywords']); ?>"  style="width:650px; " /></td></tr>
<tr><td>Meta description</td><td><textarea class="input" name="description"  style="width:650px; "><?php echo $this->m['description']; ?></textarea></td></tr>
<tr><td><input type="checkbox" class="input input_mini" name="default" /></td><td>S&#7917; d&#7909;ng l&agrave;m meta m&#7851;u</td></tr>
</tbody></table>
</form>
<div class="text" style="line-height:17px; ">
<a href="<?php echo URL_SELF ?>?id=<?php echo $this->id ?>&act=<?php echo ACT_REMOVE ?>&go=" onclick="this.href += encodeURIComponent(url_up);" class="item" style="color:blue; ">S&#7917; d&#7909;ng meta m&#7851;u</a><br/>
<br/>
<strong>L&#432;u &yacute;:</strong> &#273;&#7875; ch&egrave;n t&ecirc;n &#273;&#7889;i t&#432;&#7907;ng, t&#7915; kho&aacute;, ph&#7847;n t&oacute;m t&#7855;t c&#7911;a &#273;&#7889;i t&#432;&#7907;ng, b&#7841;n h&atilde;y s&#7917; d&#7909;ng c&aacute;c k&yacute; hi&#7879;u <strong>{{TITLE}}, {{KEYWORD}}, {{DESCRIPTION}}</strong><br />
<strong>V&iacute; d&#7909;</strong>: khi nh&#7853;p title l&agrave; <strong>{{TITLE}},abc,def</strong> th&igrave; khi hi&#7875;n th&#7883;, title c&#7911;a trang s&#7869; l&agrave; <strong>&lt;t&ecirc;n &#273;&#7889;i t&#432;&#7907;ng&gt;,abc,def.</strong><br />
T&#432;&#417;ng t&#7921;, khi nh&#7853;p keywords l&agrave; <strong>{{KEYWORD}},abc, def</strong> th&igrave; khi hi&#7875;n th&#7883; ph&#7847;n keywords s&#7869; tr&#7903; th&agrave;nh <strong>&lt;t&#7915; g&#7907;i nh&#7899; &#273;&atilde; nh&#7853;p&gt;,abc,def</strong><br />
Khi nh&#7853;p meta description l&agrave; <strong>{{DESCRIPTION}},abc,def </strong>th&igrave; khi hi&#7875;n th&#7883;, ph&#7847;n description c&#7911;a trang s&#7869; tr&#7903; th&agrave;nh <strong>&lt;ph&#7847;n t&oacute;m t&#7855;t c&#7911;a &#273;&#7889;i t&#432;&#7907;ng&gt;,abc,def</strong>.<br />
Ch&#7913;c n&#259;ng n&agrave;y cho ph&eacute;p b&#7841;n th&ecirc;m b&#7899;t t&#7915; v&agrave;o title, keywords, description r&#7891;i s&#7917; d&#7909;ng nh&#432; m&#7897;t template cho nhi&#7873;u &#273;&#7889;i t&#432;&#7907;ng.<br/>
&#272;&#7875; s&#7917; d&#7909;ng meta n&agrave;y l&agrave;m m&#7851;u cho c&aacute;c &#273;&#7889;i t&#432;&#7907;ng c&ugrave;ng lo&#7841;i (s&#7843;n ph&#7849;m, tin), h&atilde;y &#273;&aacute;nh d&#7845;u v&agrave;o &quot;<strong>S&#7917; d&#7909;ng l&agrave;m meta m&#7851;u</strong>&quot;<br />
Ch&#7913;c n&#259;ng: <strong>S&#7917; d&#7909;ng meta m&#7851;u</strong> cho ph&eacute;p b&#7841;n g&aacute;n cho &#273;&#7889;i t&#432;&#7907;ng n&agrave;y s&#7917; d&#7909;ng meta m&agrave; b&#7841;n &#273;&atilde; t&#7841;o m&#7851;u cho c&aacute;c &#273;&#7889;i t&#432;&#7907;ng c&ugrave;ng lo&#7841;i
</div>
</body>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
<script language="javascript">
var url_up = '<?php echo URL_CWD ?>item-list.php?<?php echo CATALIAS ?>id=<?php echo $this->catid;?>';
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
