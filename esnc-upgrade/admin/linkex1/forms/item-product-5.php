<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->doctitle;?></title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
<link type="text/css" rel="stylesheet" href="images/rtestyle.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" src="js/rte.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function SHOW(id){
	var o = document.getElementById(id);
	if (o.clientWidth<154) o.style.width= '154px';
	if (o.style.visibility =='hidden'){
		o.style.visibility='visible';
	}
	else{
		o.style.visibility='hidden';
	}
}
</script>
<style type="text/css">
div#attribute{
	font-size:11px;
	visibility:hidden;
	position:absolute;
	border:1px solid #96969D;
	border-top:0px;
	background:#FFFFFF;	
}
div#attributetext{
	padding:5px 0px 0px 20px;
	font-size:11px;
	background:url(images/selectbox.gif);
	width:136px;
	height:17px;
}
#idimgImg1,#idimgImg2{
	width:80px;
}
</style>
</head>
<body class="text">
<form action="<?php echo "{$this->url}?act=".ACT_SAVE."&id={$this->id}&catid={$this->catid}" ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data" id="idfrmItem">	
<input name="type" type="hidden" value="<?php echo $this->type; ?>">
<?php if (isset($_GET['PDkeyword'])){ ?>
<input name="qkey" type="hidden" value="<?php echo $_GET['PDkeyword']; ?>">
<?php }?>
<table width="100%" border="0">
<tr>
	<td>
	<div class="title">M&#227; d&#7883;ch v&#7909;</div>
	<div><input type="text" name="code" value="<?php echo $this->code; ?>" style="width:150px;"></div>
	</td>
	<td>
	<div class="title">T&#234;n d&#7883;ch v&#7909;</div>
	<div><input type="text" name="name" value="<?php echo $this->name; ?>" style="width:500px;"></div>
	</td>
	<td>
		<div class="title">Gi&#225; d&#7883;ch v&#7909;</div>
		<div><input name="price" type="text" class="input" style="width:100px;"  value="<?php echo htmlspecialchars($this->price); ?>" title="Gi&aacute; l&agrave; m&#7897;t x&acirc;u k&yacute; t&#7921; bao g&#7891;m c&#7843; &#273;&#417;n v&#7883; ti&#7873;n t&#7879;"/></div>
	</td>
</tr>
<!--
<tr>
	<td>
		<div class="title">Th&#7901;i l&#432;&#7907;ng</div>
		<div><input name="manufacturer" type="text" class="input" style="width:150px;"  value="<?php echo htmlspecialchars($this->manufacturer); ?>" title="C&oacute; th&#7875; l&agrave; nh&agrave; s&#7843;n xu&#7845;t ho&#7863;c nh&agrave; nh&#7853;p kh&#7849;u"/></div>
	</td>
	<td colspan="2">
	<div style="float:left;width:314px;">
		<div class="title">&#272;i&#7875;m xu&#7845;t ph&#225;t</div>
		<div><input name="include" type="text" class="input" style="width:100%;"  value="<?php echo htmlspecialchars($this->include); ?>" title="Gi&aacute; l&agrave; m&#7897;t x&acirc;u k&yacute; t&#7921; bao g&#7891;m c&#7843; &#273;&#417;n v&#7883; ti&#7873;n t&#7879;"/></div>
	</div><div style="float:left;width:314px;margin-left:5px;">
		<div class="title">&#272;i&#7875;m k&#7871;t th&#250;c</div>
		<div><input name="unit" type="text" class="input" style="width:100%;"  value="<?php echo htmlspecialchars($this->unit); ?>" title="&#272;&#417;n v&#7883; t&iacute;nh c&#7911;a h&agrave;ng ho&aacute; d&ugrave;ng &#273;&#7875; hi&#7875;n th&#7883;"/></div>
	</div>
	</td>
	
</tr>
-->
<tr><td colspan="3">
	<div class="title">M&#244; t&#7843; t&#243;m t&#7855;t&nbsp;|&nbsp;<span onclick="showContent(this);" style="cursor:pointer;color:#0000FF; ">M&#244; t&#7843; chi ti&#7871;t</span></div>
	<div>
		<table style="width:790px;" cellpadding="0" cellspacing="0">
			<tr id="idrteToolbar"><td><?php $rte->showRTEToolbar();?></td></tr>
			<tr id='idtdContainFrameRte'><td width="100%" valign="top"><iframe name="frmRte" class="editor" frameborder="0" width="790" height="120px"></iframe></td></tr>
			<tr id='idtdContainTextArea' style="display:none "><td width="100%" valign="top"><textarea class="input" id='idname' name="summary" style="width:790px;height:120px;"><?php echo $this->summary; ?></textarea></td></tr>
		</table>
	</div>
</td></tr>
<tr>
	<td>
		<div class="title">&#272;&#7863;c t&#237;nh</div>
		<div>
			<div id="attributetext" onClick="SHOW('attribute');">&#272;&#259;c t&#237;nh hi&#7875;n th&#7883;</div>
			<div id="attribute">
			<?php 
			foreach($this->a_ctrl as $ctl=>$text){
				echo '<div><input type="checkbox" value="'.$ctl.'" name="ctrl[]" ';
				if($this->ctrl & $ctl) echo ' checked';
				echo ' />&nbsp;'.$text.'</div>';
			}?>
				<div style="text-align:right; "><a href="#" onClick="SHOW('attribute');return false;">&#272;&#243;ng</a></div>
			</div>
		</div>
	</td>
	<td>
		<div class="title">T&#7915; g&#7907;i nh&#7899;</div>
		<div><input name="keyword" class="input" type="input" value="<?php echo $this->keyword ?>" style="width:100%;"/></div>
	</td>
	<td>
		<div class="title">Th&#7913; t&#7921; hi&#7875;n th&#7883;</div>
		<div><input type="text" size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:98%;"/></div>
	</td>
</tr>
<tr>
	<td>		
		<div style="text-align:center;"><img src="images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG1,$this->img1 ? $this->img1:URL_ADMIN.'images/noimage.gif'," id='idimgImg1' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>"  style="width:99%;" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG2,$this->img2 ? $this->img2:URL_ADMIN.'images/noimage.gif'," id='idimgImg2' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>"  style="width:99%;" /></div>
	</td>
</tr>
</table>
<input type="hidden" name="contentfile" value="<?php echo $this->contentfile; ?>">
</form>
<?php RTE::loadRTEDialog();?>	
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var url_rte = URL_ADMIN + 'rte.php?filename=<?php echo $this->contentfile;?>';
var self_id = '<?php echo $this->id;?>';
var self_type = '<?php echo $this->type;?>';
var frmItem = document.getElementById("idfrmItem");
var imgImg1 = document.getElementById('idimgImg1');
var imgImg2 = document.getElementById('idimgImg2');
var imgImg = document.getElementById('idimgImg');
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo dirname(URL_SELF) ?>/item-list.php?<?php echo urlmodify($this->alias.'id',NULL,$this->catalias.'id',$this->catid); ?>';
var url_newitem=url_self + '?<?php echo urlmodify('catid',$this->catid,$this->alias.'id',0,'id',0,'type',$_GET['type']); ?>';
function showContent(o){
	window.open(url_rte, "subWindow",sParams);
}
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	oRte.rteToInput();
	return true;
}
</script>
<script language="javascript" src="js/item-script.js"></script>
<script language="javascript">var oRte=(!isIE?new RTE(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE):new RTEie(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE));</script>
