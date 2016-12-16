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
<form action="<?php echo URL_SELF."?act=".ACT_SAVE."&id={$this->id}&go=".urlencode(URL_GO); ?>" method="post" onSubmit="return checkForm(this);" enctype="application/x-www-form-urlencoded" id="idfrmItem">	
<table width="100%" border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<tr>
	<td colspan="3">
	<div class="title">C&acirc;u h&#7887;i</div>
	<div><textarea class="input" name="question" style="width:98%;height:80px; "><?php echo $this->question; ?></textarea></div>
	</td>
</tr>
<tr><td colspan="3">
	<div class="title">C&acirc;u tr&#7843; l&#7901;i</div>
	<div>
		<table style="width:100%;" cellpadding="0" cellspacing="0">
			<tr id="idrteToolbar"><td><?php $rte->showRTEToolbar();?></td></tr>
			<tr id='idtdContainFrameRte'><td width="100%" valign="top"><iframe name="frmRte" class="editor" frameborder="0" width="99%" height="150px" onClick="HIDE('attribute');"></iframe></td></tr>
			<tr id='idtdContainTextArea' style="display:none "><td width="100%" valign="top"><textarea  class="input" id='idname' name="answer" style="width:99%;height:120px;"><?php echo $this->answer; ?></textarea></td></tr>
		</table>
	</div>
</td></tr>
<tr>
	<td width="15%">
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
	<td width="75%">
		<div class="title">T&#7915; g&#7907;i nh&#7899;</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="keyword" class="input" value="<?php echo $this->keyword ?>" style="width:100%;"/></div>
	</td>
	<td>
		<div class="title">Th&#7913; t&#7921;</div>
		<div><input type="text" onFocus="HIDE('attribute');" size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:98%;"/></div>
	</td>
</tr>
<tr>
	<td colspan="3">
	<div class="title">Ng&#432;&#7901;i h&#7887;i</div>
	<div><input type="text" class="input" value="<?php echo htmlspecialchars($this->customername); ?>" name="customername" style="width:300px "/></div>
	</td>
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
var url_up = '<?php echo  URL_GO;?>';
var url_newitem=url_self + '?<?php echo urlmodify($this->alias.'id',0,'id',0); ?>';
function checkForm(f){
	if(f.question.value == ''){
		parent.banner.setStatus("Ph&#7843;i nh&#7853;p c&acirc;u h&#7887;i");
		f.question.focus();return false;
	}
	oRte.rteToInput();
	return true;
}
function SHOW(id){	
	var o = document.getElementById(id);	
	if (!o) return;
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
	if (!o) return;
	o.style.visibility ='hidden';	
}
</script>
<script language="javascript" src="js/item-script.js"></script>
<script language="javascript">var oRte=(!isIE?new RTE(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE):new RTEie(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE));</script>
<?php dbclose(); ?>