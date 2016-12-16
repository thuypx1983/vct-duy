<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->doctitle;?></title>
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
}
</style>
</head>
<?php require_once PATH_APPLICATION.'lang.php'?>
<body class="text" style="width:750px; ">
<form  action="<?php echo "{$this->url}?act=".ACT_SAVE."&id={$this->id}&catid={$this->catid}" ?>" method="post" onSubmit="return checkForm(this);" enctype="application/x-www-form-urlencoded" id="idfrmItem" autocomplete="off" autofill="off">	
<input name="type" type="hidden" value="<?php echo $this->type; ?>">
<table border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';" style="table-layout:fixed;width:750px; ">
<col width="200px" /><col width="60%" /><col />
<tr>
	<td>
		<div class="title">M&atilde;</div>
		<div><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->code); ?>" style="width:190px;" name="code" /></div>
	</td>
	<td>
		<div style="float:left; width:200px; ">
			<div class="title">T&ecirc;n</div>
			<div><input type="text" onFocus="HIDE('attribute');" name="name" value="<?php echo htmlspecialchars($this->name); ?>" style="width:100%;"></div>
		</div>
		<div style="float:left; width:200px; padding-left:10px; ">
			<div class="title">Gi&aacute; c&#417; b&#7843;n</div>
			<div><input type="text" onFocus="HIDE('attribute');" name="saleprice" value="<?php echo currency_format_number($this->saleprice); ?>" style="width:100%;"></div>
		</div>
	</td>
	<td>
		<div class="title">&#272;&#417;n v&#7883; t&iacute;nh</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="unit"  class="input" style="width:90px;"  value="<?php echo htmlspecialchars($this->unit); ?>" /></div>
	</td>
</tr>
<tr>
	<td><div class="title"><?php echo TEXT_SPECIFICATIONS;?></div></td>
	<td colspan="2"><div class="title">Gi&#225; (<?php echo CURRENCY_PREFIX.number_format(12345678.912,CURRENCY_DECIMAL_PLACE,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_THOUSAND_SEPERATOR).CURRENCY_SUFFIX;?>)</div></td>
</tr>
<tr>
	<td><div style="height:100px; overflow:auto; ">
		<table>
			<tr>
				<td><?php echo TEXT_COLOR; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['COLOR']); ?>" style="width:80px;" name="a_attr[COLOR]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_TRANSPARENCY; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['TRCY']); ?>" style="width:80px;" name="a_attr[TRCY]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_THERMAL_INSULATION; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['THER']); ?>" style="width:80px;" name="a_attr[THER]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_CONSTRAST; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['REFL']); ?>" style="width:80px;" name="a_attr[REFL]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_UV_PROTECTION; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['UV']); ?>" style="width:80px;" name="a_attr[UV]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_SPE_ONE; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['1']); ?>" style="width:80px;" name="a_attr[1]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_SPE_TWO; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['2']); ?>" style="width:80px;" name="a_attr[2]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_SPE_THR; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['3']); ?>" style="width:80px;" name="a_attr[3]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_SPE_FOU; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['4']); ?>" style="width:80px;" name="a_attr[4]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_SPE_FIV; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['5']); ?>" style="width:80px;" name="a_attr[5]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_SPE_SIX; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['6']); ?>" style="width:80px;" name="a_attr[6]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_SPE_SEV; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->a_attr['7']); ?>" style="width:80px;" name="a_attr[7]" /></td>
			</tr>
		</table></div>
	</td>
	<td colspan="2">
		<table>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo TEXT_WIND_SCREEN; ?></td>
				<td><?php echo TEXT_FONTSIDE_SCREEN; ?></td>
				<td><?php echo TEXT_BACKSIDE_SCREEN; ?></td>
				<td><?php echo TEXT_BACK_SCREEN; ?></td>
			</tr>
			<tr>
				<td><?php echo TEXT_SPECIAL; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['SPECIAL']['WS']); ?>" style="width:100px;" name="a_price[SPECIAL][WS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['SPECIAL']['FSS']); ?>" style="width:100px;" name="a_price[SPECIAL][FSS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['SPECIAL']['BSS']); ?>" style="width:100px;" name="a_price[SPECIAL][BSS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['SPECIAL']['BS']); ?>" style="width:100px;" name="a_price[SPECIAL][BS]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_DELUXE; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['DELUXE']['WS']); ?>" style="width:100px;" name="a_price[DELUXE][WS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['DELUXE']['FSS']); ?>" style="width:100px;" name="a_price[DELUXE][FSS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['DELUXE']['BSS']); ?>" style="width:100px;" name="a_price[DELUXE][BSS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['DELUXE']['BS']); ?>" style="width:100px;" name="a_price[DELUXE][BS]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_STANDARD; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['STANDARD']['WS']); ?>" style="width:100px;" name="a_price[STANDARD][WS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['STANDARD']['FSS']); ?>" style="width:100px;" name="a_price[STANDARD][FSS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['STANDARD']['BSS']); ?>" style="width:100px;" name="a_price[STANDARD][BSS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['STANDARD']['BS']); ?>" style="width:100px;" name="a_price[STANDARD][BS]" /></td>
			</tr>
			<tr>
				<td><?php echo TEXT_NORMAL; ?></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['NORMAL']['WS']); ?>" style="width:100px;" name="a_price[NORMAL][WS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['NORMAL']['FSS']); ?>" style="width:100px;" name="a_price[NORMAL][FSS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['NORMAL']['BSS']); ?>" style="width:100px;" name="a_price[NORMAL][BSS]" /></td>
				<td><input type="text" onFocus="HIDE('attribute');" value="<?php echo currency_format_number($this->a_price['NORMAL']['BS']); ?>" style="width:100px;" name="a_price[NORMAL][BS]" /></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
	<div class="title">Xu&#7845;t x&#7913; (qu&#7889;c gia)</div>
	<div><input type="text" onFocus="HIDE('attribute');" value="<?php echo htmlspecialchars($this->country); ?>" style="width:190px;" name="country" /></div>
	</td>
	<td >
		<div style="float:left; width:200px; ">
			<div class="title">Nh&agrave; s&#7843;n xu&#7845;t/nh&agrave; cung c&#7845;p</div>
			<div><input type="text" onFocus="HIDE('attribute');" name="manufacturer" value="<?php echo htmlspecialchars($this->manufacturer); ?>" style="width:100%;"></div>
		</div>
		<div style="float:left; width:200px; padding-left:10px; ">
			<div class="title">B&#7843;o h&agrave;nh</div>
			<div><input type="text" onFocus="HIDE('attribute');" name="warranty" value="<?php echo htmlspecialchars($this->warranty); ?>" style="width:100%;"></div>
		</div>
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
			<tr id='idtdContainTextArea' ><td width="100%" valign="top">
			<?php 
				$rte= new RTE('myrte',URL_ADMIN.'images/rteimages/',RTE_B_ALL);
				$rte->show('summary',$this->summary,'100px','100%');
			?>
			</td></tr>
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
		<div style="text-align:center;"><img src="images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG1,$this->img1,' id="idimgImg1" align="absmiddle"','<IMG SRC="images/noimage.gif" id="idimgImg1" align="absmiddle" />');?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch &#7843;nh</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>"  style="width:99%;" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG2,$this->img2,' id="idimgImg2" align="absmiddle"','<IMG SRC="images/noimage.gif" id="idimgImg2" align="absmiddle" />');?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch &#7843;nh</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>"  style="width:99%;" /></div>
	</td>
</tr>
</table>
<input type="hidden" name="contentfile" value="<?php echo $this->contentfile; ?>">
</form>
<?php RTE::loadRTEDialog();?>	

</body>
<script language="javascript" type="text/javascript" src="js/rte.js"></script>
<?php $rte->initRteObjectScript();?>
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
	myrte.rteToInput();
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	return true;
}
</script>
<script language="javascript" src="js/item-script.js"></script>
