<html><head><title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../images/style.css" />
<comment>
<link type="text/css" rel="stylesheet" href="../images/style-nonie.css" />
</comment>
<script language="javascript" type="text/javascript" src="../js/library.js"></script>
<script language="javascript" type="text/javascript" src="../js.php"></script>
<style type="text/css">
#idimgImg1,#idimgImg2{
	width:80px;
}
</style>
</head>
<body class="text">
<form  action="<?php echo "{$this->url}?act=".ACT_SAVE."&id={$this->id}&catid={$this->catid}" ?>" method="post" onSubmit="return checkForm(this);" enctype="application/x-www-form-urlencoded" id="idfrmItem" autocomplete="off" autofill="off">	
<input name="type" type="hidden" value="<?php echo $this->type; ?>">
<?php if (isset($_GET['PDkeyword'])){ ?>
<input name="qkey" type="hidden" value="<?php echo $_GET['PDkeyword']; ?>">
<?php }?>
<table border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';" style="table-layout:fixed;width:790px; ">
<col width="160px" /><col width="60%" /><col />
<tr>
	<td>
	<div class="title">M&atilde;</div>
	<div><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->code); ?>" style="width:150px;" name="code" /></div>
	</td>
	<td>
	<div class="title">T&ecirc;n</div>
	<div><input type="text" onFocus="HIDE('attribute');" name="name" value="<?php echo htmlspecialchars($this->name); ?>" style="width:100%;"></div>
	</td>
	<td>
		<div class="title">Gi&#225; (<?php echo CURRENCY_PREFIX.number_format(12345678.912,CURRENCY_DECIMAL_PLACE,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_THOUSAND_SEPERATOR).CURRENCY_SUFFIX;?>)</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="saleprice"  class="input" style="width:97%;"  value="<?php echo currency_format_number($this->saleprice); ?>" /></div>
	</td>
</tr>
<tr>
	<td>
	<div class="title">Ch&#7845;t li&#7879;u</div>
	<div><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->include); ?>" style="width:150px;" name="include" /></div>
	</td>
	<td>
	<div class="title">H&igrave;nh d&aacute;ng v&agrave; k&iacute;ch th&#432;&#7899;c</div>
	<div><input type="text" onFocus="HIDE('attribute');" name="model" value="<?php echo htmlspecialchars($this->model); ?>" style="width:100%;" /></div>
	</td>
	<td>
		<div class="title">&#272;&#417;n v&#7883; t&iacute;nh</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="unit"  class="input" style="width:97%;"  value="<?php echo htmlspecialchars($this->unit); ?>" /></div>
	</td>
</tr>
<tr>
	<td>
	<div class="title">Xu&#7845;t x&#7913; (qu&#7889;c gia)</div>
	<div><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->country); ?>" style="width:150px;" name="country" /></div>
	</td>
	<td >
			<div class="title">Nh&agrave; s&#7843;n xu&#7845;t/nh&agrave; cung c&#7845;p</div>
			<div><input type="text" onFocus="HIDE('attribute');" name="manufacturer" value="<?php echo htmlspecialchars($this->manufacturer); ?>" style="width:100%;"></div>
	</td>
	<td >
			<div class="title">Th&#7913; t&#7921; hi&#7875;n th&#7883;</div>
			<div><input type="text" onFocus="HIDE('attribute');" size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:98%;"/></div>
	</td>
</tr>
<tr><td colspan="3">
	<div class="title">M&#244; t&#7843; t&#243;m t&#7855;t&nbsp;|&nbsp;<span onclick="showContent(this);" style="cursor:pointer;color:#0000FF; ">M&#244; t&#7843; chi ti&#7871;t</span></div>
	<div>
		<table style="width:100%;" cellpadding="0" cellspacing="0">
			<tr id='idtdContainTextArea' ><td width="100%" valign="top"><textarea  class="input" id='idname' name="summary" style="width:99%;height:80px;"><?php echo $this->summary; ?></textarea></td></tr>
		</table>
	</div>
</td></tr>
<tr>
	<td>
		<div class="title">&#272;&#7863;c t&#237;nh</div>
		<div>
			<div id="attributetext" onClick="SHOW('attribute');">&#272;&#259;c t&#237;nh</div>
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
	<td colspan="2">
		<div class="title">T&#7915; g&#7907;i nh&#7899; / T&#7915; kho&aacute;</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="keyword" class="input" value="<?php echo htmlspecialchars($this->keyword) ?>" style="width:100%;"/></div>
	</td>
</tr>
<tr>
	<td>		
		<div style="text-align:center;"><img src="../images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG1,$this->img1,' id="idimgImg1" align="absmiddle"','<IMG SRC="../images/noimage.gif" id="idimgImg1" align="absmiddle" />');?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="../document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch &#7843;nh</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>"  style="width:99%;" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="../images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG2,$this->img2,' id="idimgImg2" align="absmiddle"','<IMG SRC="../images/noimage.gif" id="idimgImg2" align="absmiddle" />');?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="../document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch &#7843;nh</div>
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
	return true;
}
</script>
<script language="javascript" src="../js/item-script.js"></script>
<?php dbclose(); ?>