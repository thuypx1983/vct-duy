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
function selectCity(o){
	var v =	o.options[o.selectedIndex].text;
	document.getElementsByName('warranty')[0].value = v;
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
	background:url(../images/selectbox.gif);
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
<table width="100%" border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<tr>
	<td width="20%">
	<div class="title">M&#227; v&eacute;</div>
	<div><input type="text" onFocus="HIDE('attribute');" name="code" value="<?php echo $this->code; ?>" style="width:100%;"></div>
	</td>
	<td width="40%">
		<div class="title">&#272;i&#7875;m xu&#7845;t ph&aacute;t</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="name" value="<?php echo $this->name; ?>" style="width:100%;"></div>
	</td>
	<td width="40%">
		<div class="title">&#272;i&#7875;m &#273;&#7871;n</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="unit" value="<?php echo $this->unit; ?>" style="width:100%;"></div>
	</td>
	</tr><tr>	
	<td>
		<div class="title">Gi&#225; v&eacute;</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="price" class="input" style="width:100%;"  value="<?php echo htmlspecialchars($this->price); ?>" title="Gi&aacute; l&agrave; m&#7897;t x&acirc;u k&yacute; t&#7921; bao g&#7891;m c&#7843; &#273;&#417;n v&#7883; ti&#7873;n t&#7879;"/></div>
	</td>
	<td width="20%">
		<div class="title">H&atilde;ng</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="manufacturer" class="input" style="width:100%;"  value="<?php echo htmlspecialchars($this->manufacturer); ?>"/></div>
	</td>
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
</tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
var frmItem = document.getElementById("idfrmItem");
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}	
	return true;
}
var url_newitem=url_self + '?<?php echo urlmodify('catid',$this->catid,$this->alias.'id',0,'id',0,'type',$_GET['type']); ?>';
function doSave(){
	alert("Hello");
}
</script>
<script language="javascript" src="../js/item-script.js"></script>
<?php dbclose(); ?>