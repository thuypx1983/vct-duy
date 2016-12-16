<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title>Chi ti&#7871;t nh&oacute;m</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="images/rtestyle.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" type="text/javascript" src="js/rte.js"></script>
<style type="text/css">
DIV.colorSelect,DIV.colorSelect-hover,DIV.rteButton,DIV.rteButton-hover,DIV.rteButtonBlock,DIV.rteButtonBlock-hover{behavior:url(js/IEhover.htc);}
</style>
</head>
<body class="text">
<form action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id ?>" method="post" onSubmit="return checkForm(this);"  id="idfrmItem" class="text">
<input type="hidden" name="parentid" value="<?php echo $this->parentid; ?>"/>
<table width="100%" border="0" class="text"><tbody>
	<tr>
		<td class="text" width="10%">Ti&ecirc;u &#273;&#7873;</td>
		<td><input name="name" type="text" class="input" size="120" value="<?php echo htmlspecialchars($this->name); ?>"  style="width:100%" /></td>
	</tr>
	<tr><td class="text">T&oacute;m t&#7855;t</td>
		<td><?php 
		$rte = new RTE('rte_desc',URL_ADMIN.'images/rteimages/',RTE_B_ALL);
		$rte->show('desc',$this->desc,'200px');?>
	</td></tr>
	<tr><td class="text">Th&#7913; t&#7921;</td><td><input type="text" size="2" name="view" class="input" value="<?php echo $this->view ?>" /></td></tr>
	<tr><td class="text">&#272;&#7863;c t&iacute;nh</td><td class="text"><?php $i=0;foreach($this->a_ctrl as $ctl=>$text){
	echo '<input type="checkbox" value="'.$ctl.'" name="a_ctrl" ';
	if($this->ctrl & $ctl) echo ' checked';
	echo ' />'.$text.'&nbsp;&nbsp;';++$i;
	if($i == 3) { echo '<br/>'; $i=0;}
	}?></td></tr>
	<tr><td>&#7842;nh</td><td><input type="text" name="img1" class="input" id="idImg1" style="width:100%" value="<?php echo htmlspecialchars($this->img1); ?>"/></td></tr>
	<tr><td>Ch&uacute; th&iacute;ch</td><td><input type="text" name="alt1" class="input" style="width:100%" value="<?php echo htmlspecialchars($this->alt1); ?>"/></td></tr>
	<tr><td>T&#7843;i l&ecirc;n</td><td><iframe align="bottom" height="40" width="100%" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1&FLid=<?php echo $this->catid; ?>&FFflag=<?php echo (int)$_GET['FFflag'] ?>"></iframe></td></tr>
	<tr><td>&nbsp;</td><td><?php htmlview($this->url_img1,$this->img1,'border=1 id=idimgImg1','<img src="images/noimage.gif" id="idimgImg1" border="1" />');?></td></tr>
</tbody>
</table>
<input type="hidden" name="ctrl" value="" />
</form>	
<?php RTE::loadRTEDialog();?>
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var self_id = '<?php echo $this->id;?>';
var self_type = '<?php echo $this->type;?>';
var frmItem = document.getElementById("idfrmItem");
var imgImg1 = document.getElementById('idimgImg1');
var imgImg = document.getElementById('idimgImg');
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo URL_CWD ?>/index.php?<?php echo urlmodify($this->alias.'id',NULL,$this->alias.'parentid',$this->parentid); ?>';
var url_newitem=url_self + '?<?php echo urlmodify('catid',$this->id,$this->alias.'id',0,'id',0); ?>';
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	a = document.getElementsByName('a_ctrl');
	v = 0;
	for(i = 0;i < a.length; ++i){
		if(a.item(i).checked) v += parseInt(a.item(i).value);
	}
	f.ctrl.value = v;
	rte_desc.rteToInput();
	return true;
}
</script>
<script language="javascript" src="js/item-script.js"></script>
<?php $rte->initRteObjectScript();?>
