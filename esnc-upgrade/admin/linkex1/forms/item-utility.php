<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>T&#7853;p tin t&#7843;i v&#7873;</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="images/style.css">
<link type="text/css" rel="stylesheet" href="images/rtestyle.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" src="js/rte.js" type="text/javascript"></script>
<style type="text/css">
#idimgImg{
	width:100px;
}
</style>
</head>
<body>
<form id="idfrmItem"  method="post" action="<?php echo URL_SELF.'?'.urlformat($this->q,'id',$this->id,'UTid',$this->id,'CUid',$this->catid,'catid',$this->catid,'act',ACT_SAVE) ?>" onsubmit="return checkForm(this);">
<table width="750px" cellpadding="0" cellspacing="5">
	<tr>
		<td class="text" width="12%">T&ecirc;n</td>
		<td><input name="name" type="text" class="input" value="<?php echo htmlspecialchars($this->name); ?>" style="width:98%" /></td>
	</tr>
	<tr>
		<td class="text" title="L&agrave; k&yacute; hi&#7879;u v&#259;n b&#7843;n ho&#7863;c m&atilde; s&#7889;, ng&agrave;y th&aacute;ng ban h&agrave;nh .v.v." style="cursor:help ">T&ecirc;n h&igrave;nh th&#7913;c <strong>(?)</strong></td>
		<td class="text"><input name="filename" type="text" class="input" value="<?php echo htmlspecialchars($this->filename); ?>" style="width:30%" title="L&agrave; k&yacute; hi&#7879;u v&#259;n b&#7843;n ho&#7863;c m&atilde; s&#7889;, ng&agrave;y th&aacute;ng ban h&agrave;nh .v.v."/>&nbsp;&nbsp;Th&#7913; t&#7921; hi&#7875;n th&#7883; <input type="text" class="input" name="view" value="<?php echo $this->view ?>" size="5" /></td>
	</tr>
	<tr>
		<td class="text">T&oacute;m t&#7855;t</td>
		<td>
		<div class="title">M&#244; t&#7843; t&#243;m t&#7855;t</div>
		<div style="width:100%;clear:both ">
<?php	$rte=new RTE(NULL,NULL,RTE_B_ALL);
	$rte->rename('rte_summary');
	$rte->show('summary',$this->summary,'120px');
	$rte->initRteObjectScript(TRUE);
?>
		</div>
		</td>
	</tr>
	<tr>
		<td class="text" title="L&agrave; c&aacute;c t&#7915; g&#7907;i ra n&#7897;i dung v&#259;n b&#7843;n, d&ugrave;ng &#273;&#7875; t&igrave;m ki&#7871;m v&#259;n b&#7843;n" style="cursor:help ">T&#7915; g&#7907;i nh&#7899; <strong>(?)</strong></td>
		<td><input type="text" name="keyword" class="input" value="<?php echo htmlspecialchars($this->keyword); ?>" style="width:98%" title="L&agrave; c&aacute;c t&#7915; g&#7907;i ra n&#7897;i dung v&#259;n b&#7843;n, d&ugrave;ng &#273;&#7875; t&igrave;m ki&#7871;m v&#259;n b&#7843;n"/></td>
	</tr>
	<tr><td class="text">Ngu&#7891;n</td>
		<td class="text"><input type="text" name="path" class="input" value="<?php echo $this->path ?>" style="width:40%" />
		<iframe height="20px" style="vertical-align:bottom " width="340px" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSavePath"></iframe>
		</td>
	</tr>
	</tr>
	<tr><td colspan="2"><table width="100%"><tr><td>
	<img src="images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_UTILITY_IMG,$this->img ? $this->img:URL_ADMIN.'images/noimage.gif'," id='idimgImg' align='absmiddle'");?>
	</td><td>
	<div><input type="text"  name="img" class="input" value="<?php echo htmlspecialchars($this->img); ?>" style="width:250px;" />&nbsp;<iframe height="22" style="vertical-align:bottom" width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg"></iframe></div>
	<div class="title">Ch&#250; th&#237;ch </div>
	<div><input type="text"  name="alt" class="input" value="<?php echo htmlspecialchars($this->alt); ?>"  style="width:99%;" /></div>
	</td></tr></table>
	</td></tr>
</table>
<input type="hidden" value="1" name="ctrl[]" />
</form>
<?php RTE::loadRTEDialog();?>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
var frmItem = document.getElementById('idfrmItem');
var imgImg = document.getElementById('idimgImg');
function doSavePath(newPath){
	if(newPath!=null) frmItem.path.value = newPath;
}
function doDownload(path){	
	window.top.open('<?php echo URL_ROOT ?>download.php?UTpath=' + path);
}
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	rte_summary.rteToInput();
	return true;
}
var url_up='<?php echo URL_CWD.'item-list.php?CUid='.$this->catid	?>';
</script>
<script src="js/item-script.js" language="javascript" type="text/javascript"></script>