<?php include_once PATH_APPLICATION.'lang.php';?>
<html><head><title><?php echo $this->doctitle;?></title>
<base href="<?php echo URL_BASE_ADMIN ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link href="images/rtestyle.css" type="text/css" rel="stylesheet" />
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
<script language="javascript" type="text/javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>

<style type="text/css">
#idimgImg1,#idimgImg2{
	width:80px;
	overflow:auto;
}
DIV.title{
	text-align:center;
}
DIV.code{
	text-align:left;
	width:100px;	
	float:left;
	margin:0px 5px 0px 0px;
}
DIV.saleprice{
	text-align:center;
	width:80px;	
	float:left;
	margin:0px 0px 0px 5px;
}
DIV.price{
	text-align:center;
	width:80px;	
	float:left;
	margin:0px 0px 0px 5px;
}
DIV.unit{
	text-align:center;
	width:70px;	
	float:left;
	margin:0px 0px 0px 5px;
}
DIV.quantity{
	text-align:center;
	width:70px;	
	float:left;
	margin:0px 0px 0px 5px;
	padding:0px 0px 0px 1px;
}

DIV.name{
	width:305px;
	text-align:left;
	float:left;
	margin:0px 0px 0px 0px;
}
FORM#idfrmItem{
	width:100%;
}
TABLE.table-layout{
	table-layout:fixed;
	width:800px;
}
DIV.input{
	text-align:center;
	float:left;
	margin:0px 5px 0px 5px;
}
DIV.text_area{
	width:712px;
}
DIV.rteToolbar{
	width:735px;
}
DIV.attr{
	float:left;
	font-weight:bold;
}
</style>
</head>
<body class="text" style="width:750px; ">
<form  action="<?php echo "{$this->url}?act=".ACT_SAVE."&id={$this->id}&catid={$this->catid}" ?>" method="post" onSubmit="return checkForm(this);" enctype="application/x-www-form-urlencoded" id="idfrmItem" autocomplete="off" autofill="off">	
<input name="type" type="hidden" value="<?php echo $this->type; ?>">
<table border="0" class="table-layout" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<tr>
	<td>
		<div class="code"><?php echo T_AD_CODE?></div>
		<div class="name"><?php echo T_AD_NAME?></div>
		<div class="saleprice"><?php echo T_AD_SALEPRICE; echo '('.CURRENCY_UNIT.')';?></div>
		<div class="price"><?php echo T_AD_PRICE?></div>	
		<div class="unit"><?php echo T_AD_UNIT?></div>
		<div class="quantity"><?php echo T_AD_QUANTITY?></div>
	</td>
</tr>
</table>
<table border="0" class="table-layout" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<tr>
	<td>	
		<div class="code"><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->code); ?>" style="width:100px;" name="code" /></div>
		<div class="name"><input type="text" onFocus="HIDE('attribute');" name="name" value="<?php echo htmlspecialchars($this->name); ?>" style="width:100%;"></div>
		<div class="saleprice"><input type="text" onFocus="HIDE('attribute');" name="saleprice" value="<?php echo currency_format_number($this->saleprice); ?>" style="width:100%;"></div>
		<div class="price"><input type="text" onFocus="HIDE('attribute');" name="price" value="<?php echo htmlspecialchars($this->price); ?>" style="width:100%;"></div>
		<div class="unit">
		<select onFocus="HIDE('attribute');" name="unit"  class="input" style="width:100%;" >
			<option value="<?php echo htmlspecialchars($this->unit); ?>" selected><?php echo ($this->unit); ?></option>
			<option value="cai">C&aacute;i</option>
			<option value="chiec">chi&#7871;c</option>
			<option value="bo">H&#7897;p</option>
			<option value="hop">B&#7897;</option>
		</select></div>
		<div class="quantity"><input type="text" onFocus="HIDE('attribute');" name="quantity"  class="input" style="width:100%;"  value="<?php echo $this->quantity; ?>" /></div>
	</td>
</tr>
</table>

<table border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';" style="table-layout:fixed;width:750px; ">
<tr>
	<td col="2"><div class="attr"><?php echo TEXT_SPECIFICATIONS;?></div></td>
</tr>
<tr>
	<td><div class="text_area">
		<table width="735px">
			<?php for($i=0;$i< N_ATTR;++$i){?>
			<tr>
				<td style="width:500px;"><?php echo @constant('T_ATTR_'.$i) ;?></td>
				<td style="width:230px;"><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr[$i]); ?>" style="width:635px;" name="a_attr[<?php echo $i?>]" /></td>
			</tr>
			<?php }?>
		</table></div>
	</td>
</tr>
</table>
</table>
<table border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';" style="table-layout:fixed;width:750px; ">
<col width="26%" /><col width="26%" /><col width="26%" /><col width=""/>
<tr>
	<td>
		<div class="title">Xu&#7845;t x&#7913; (qu&#7889;c gia)</div>
	</td>
	<td>
		<div class="title">Nh&agrave; s&#7843;n xu&#7845;t/nh&agrave; cung c&#7845;p</div>
	</td>		
	<td>
		<div class="title">B&#7843;o h&agrave;nh(th&aacute;ng)</div>
	</td>
	<td>
		<div class="title">Th&#7913; t&#7921; hi&#7875;n th&#7883;</div>
	</td>
</tr>
<tr>
	<td>
		<input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->country); ?>" style="width:190px;" name="country" />
	</td>
	<td>
		<input type="text" onFocus="HIDE('attribute');" name="manufacturer" value="<?php echo htmlspecialchars($this->manufacturer); ?>" style="width:95%;">
	</td>
	<td>
		<input type="text" onFocus="HIDE('attribute');" size="2" name="warranty" class="input" value="<?php echo htmlspecialchars ($this->warranty); ?>" style="width:100%;"/>
	</td>
	<td>
		<input type="text" onFocus="HIDE('attribute');" size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:150px;"/>
	</td>
</tr>
<tr>
</table>

<table>
<tr>
	<td><div class="title">M&#244; t&#7843; t&#243;m t&#7855;t&nbsp;|&nbsp;<span onClick="showContent(this);" style="cursor:pointer;color:#0000FF; ">M&#244; t&#7843; chi ti&#7871;t</span></div></td>
</tr>
</table>

<table>	
	<tr>
		<td colspan="2">
			<?php 
				$rte= new RTE('myrte',URL_ADMIN.'images/rteimages/',RTE_B_PREVIEW|RTE_B_DEFAULT);
				$rte->show('summary',$this->summary,'100px','735px');
			?>
		</td>
	</tr>
	<tr>
		<td>
			<div class="title">&#272;&#7863;c t&#237;nh </div>
		</td>
		<td>
			<div class="title">T&#7915; g&#7907;i nh&#7899; / T&#7915; kho&aacute;</div>
		</td>
	</tr>
	<tr>
		<td>	
			<div id="attributetext" onClick="SHOW('attribute');">&#272;&#259;c t&#237;nh</div>
			<div id="attribute">
			<?php 
			foreach($this->a_ctrl as $ctl=>$text){
				echo '<div><input type="checkbox" value="'.$ctl.'" name="ctrl[]" ';
				if($this->ctrl & $ctl) echo ' checked';
				echo '  />&nbsp;'.$text.'</div>';
			}?>
			<div style="text-align:right; "><a href="#" onClick="SHOW('attribute');return false;">&#272;&#243;ng</a></div>
			</div>
		</td>
		<td width="515px">
			<input type="text" onFocus="HIDE('attribute');" name="keyword" class="input" value="<?php echo htmlspecialchars($this->keyword) ?>" style="width:578px;"/>
		</td>
	</tr>
	<tr>
		<td>		
			<div style="text-align:center;"><img src="images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG1,$this->img1,' id="idimgImg1" align="absmiddle"','<IMG SRC="images/noimage.gif" id="idimgImg1" align="absmiddle" />');?></div>
		</td>
		<td>		
			<div style="clear:both; margin:0px 0px 0px 0px;"><input type="text" onFocus="HIDE('attribute');" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:578px; height:20px;" />&nbsp;<br/><iframe height="35" style="padding-top:5px; " width="300" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1"></iframe></div>
		</td>
	</tr>
	<tr>
		<td><div class="title" style="margin:5px 0px 10px 0px; clear:both;">Ch&#250; th&#237;ch &#7843;nh 1</div></td>
		<td><div style="margin:0px 0px 0px 0px;"><input type="text" onFocus="HIDE('attribute');" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>"  style="width:578px; height:20px;" /></div></td>
	</tr>
	<tr>
		<td valign="middle">		
			<div style="text-align:center;"><img src="images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG2,$this->img2,' id="idimgImg2" align="absmiddle"','<IMG SRC="images/noimage.gif" id="idimgImg2" align="absmiddle" />');?></div>
		</td>
		<td>		
			<div style="clear:both; margin:0px 0px 0px 0px;"><input type="text" onFocus="HIDE('attribute');" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:578px; height:20px" />&nbsp;<br/><iframe height="35" style="padding-top:5px; " width="300" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2"></iframe></div>
		</td>
	</tr>
	<tr>
		<td><div class="title" style="margin:5px 0px 10px 0px; clear:both;">Ch&#250; th&#237;ch &#7843;nh 2</div></td>
		<td><div><input type="text" onFocus="HIDE('attribute');" name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>"  style="width:578px;" /></div></td>
	</tr>
</table>
<input type="hidden" name="contentfile" value="<?php echo $this->contentfile; ?>">
<?php RTE::loadRTEDialog();?>	
<script language="javascript" type="text/javascript" src="js/rte.js"></script>
<?php $rte->initRteObjectScript();?>
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
	myrte.rteToInput();
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	return true;
}
</script>
<script language="javascript" src="js/item-script.js"></script>
</form>
</body>
</html>
