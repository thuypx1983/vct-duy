<html><head><title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../images/style.css" />
<comment>
<link type="text/css" rel="stylesheet" href="../images/style-nonie.css" />
</comment>
<link type="text/css" rel="stylesheet" href="../images/rtestyle.css"/>
<script language="javascript" src="../js/library.js"></script>
<script language="javascript" type="text/javascript" src="../js.php"></script>
<script language="javascript" src="../js/rte.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function SHOW(id){	
	var o = document.getElementById(id);	
	if (o.style.visibility =='hidden' || o.style.visibility ==''){
		o.style.visibility='visible';
	}
	else{
		o.style.visibility='hidden';
	}
	if (o.clientWidth<154) o.style.width= '154px';
}
function HIDE(id){
	var o = document.getElementById(id);	
	o.style.visibility ='hidden';
}
</script>
<style type="text/css">
#idimgImg1,#idimgImg2{
	width:80px;
}
</style>
</head>
<body class="text">
<form  style="display:inline;" action="<?php echo "{$this->url}?act=".ACT_SAVE."&id={$this->id}&catid={$this->catid}" ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data" id="idfrmItem">	
<input name="type" type="hidden" value="<?php echo $this->type; ?>">
<?php if (isset($_GET['PDkeyword'])){ ?>
<input name="qkey" type="hidden" value="<?php echo $_GET['PDkeyword']; ?>">
<?php }?>
<table width="100%" border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<tr>
	<td width="66%">
	<div class="title">T&#234;n</div>
	<div><input type="text" onFocus="HIDE('attribute');" name="name" value="<?php echo $this->name; ?>" style="width:100%;"></div>
	</td>
</tr>
<tr><td colspan="3">
	<div class="title">M&#244; t&#7843; t&#243;m t&#7855;t&nbsp;</div>
	<div>
		<table style="width:100%;" cellpadding="0" cellspacing="0">
			<tr id="idrteToolbar"><td><?php $rte->showRTEToolbar();?></td></tr>
			<tr id='idtdContainFrameRte'><td width="100%" valign="top"><iframe name="frmRte" class="editor" frameborder="0" width="99%" height="120px" onClick="HIDE('attribute');"></iframe></td></tr>
			<tr id='idtdContainTextArea' style="display:none "><td width="100%" valign="top"><textarea  class="input" id='idname' name="summary" style="width:99%;height:120px;"><?php echo $this->summary; ?></textarea></td></tr>
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
		<div><input type="text" onFocus="HIDE('attribute');" name="keyword" class="input" value="<?php echo $this->keyword ?>" style="width:100%;"/></div>
	</td>
	<td>
		<div class="title">Th&#7913; t&#7921; hi&#7875;n th&#7883;</div>
		<div><input type="text" onFocus="HIDE('attribute');" size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:98%;"/></div>
	</td>
</tr>
<tr>
	<td>		
		<div style="text-align:center;"><img src="../images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG1,$this->img1 ? $this->img1:'../../../admin/images/noimage.gif'," id='idimgImg1' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="../document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>"  style="width:99%;" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="../images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG2,$this->img2 ? $this->img2:'../../../admin/images/noimage.gif'," id='idimgImg2' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="../document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>"  style="width:99%;" /></div>
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
<script language="javascript" src="../js/item-script.js"></script>
<script language="javascript">var oRte=(!isIE?new RTE(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE):new RTEie(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE));</script>
<?php dbclose(); ?>