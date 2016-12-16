<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $this->doctitle;?></title>
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
.tab{display:none;}
.tabactive{display:table-header-group;}
.tabhead{cursor:pointer;font-size:11px;font-weight:normal;color:black;}
.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;}
</style>
</head>
<body class="text">
<form  action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id.'&catid='.$this->catid ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data" id="idfrmItem">	
<input name="type" type="hidden" value="<?php echo $this->type; ?>" />
<table width="98%" border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<tr>
	<td>
	<div class="title">M&atilde; c&acirc;u h&#7887;i  </div>
	<div><input type="text"  value="<?php echo $this->code; ?>" style="width:150px;" name="code" /></div>
	</td>
	<td width="66%">
	<div class="title">T&ecirc;n c&acirc;u h&#7887;i </div>
	<div><input type="text"  name="name" value="<?php echo $this->name; ?>" style="width:95%;" /></div>
	</td>
</tr>
<tr><td colspan="3">
	<table width="100%">
	<thead>
		<tr height="23" style="background-image:url(images/bg-product.gif);"><td align="center">
			<span name="tabhead" class="tabhead" onClick="showTab('_summary',this);">&#272;&#7847;u b&agrave;i </span>
			<!--<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_warranty',this);">&#272;&aacute;p &aacute;n   1</span>-->
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf0',this);">&#272;&aacute;p &aacute;n  1</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf1',this);">&#272;&aacute;p &aacute;n  2</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf2',this);">&#272;&aacute;p &aacute;n   3</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf3',this);">&#272;&aacute;p &aacute;n   4</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf4',this);">&#272;&aacute;p &aacute;n   5</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf5',this);">&#272;&aacute;p &aacute;n   6</span>
			<!--<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf10',this);">&#272;&aacute;p &aacute;n   7</span>-->
		</td></tr>
	</thead>
	<tbody id="tab_summary" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_summary');
	$rte->show('summary',$this->summary,'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_detail" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_detail');
	$rte->show('detail',$this->detail,'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_warranty" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_warranty');
	$rte->show('warranty',$this->warranty,'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf0" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf0');
	$rte->show('cf[0]',$this->cf[0],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf1" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf1');
	$rte->show('cf[1]',$this->cf[1],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf2" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf2');
	$rte->show('cf[2]',$this->cf[2],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf3" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf3');
	$rte->show('cf[3]',$this->cf[3],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf4" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf4');
	$rte->show('cf[4]',$this->cf[4],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf9" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf5');
	$rte->show('cf[5]',$this->cf[5],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf10" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf10');
	$rte->show('cf[10]',$this->cf[10],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	</table>
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
		<div><input type="text"  name="keyword" class="input" value="<?php echo $this->keyword ?>" style="width:100%;"/></div>
	</td>
	<td>
		<div class="title">Th&#7913; t&#7921; hi&#7875;n th&#7883;</div>
		<div><input type="text"  size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:30px;"/></div>
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
		f.name.focus();return false;uh
	}
	if(rte_summary) rte_summary.rteToInput();
	if(rte_detail) 	rte_detail.rteToInput();
	if(rte_warranty) 	rte_warranty.rteToInput();
	if(rte_cf0) 	rte_cf0.rteToInput();
	if(rte_cf1) 	rte_cf1.rteToInput();
	if(rte_cf2) 	rte_cf2.rteToInput();
	if(rte_cf3) 	rte_cf3.rteToInput();
	if(rte_cf4) 	rte_cf4.rteToInput();
	if(rte_cf5) 	rte_cf5.rteToInput();
	if(rte_cf10) 	rte_cf10.rteToInput();
	return true;
}
function showTab(id,o){
	a = document.getElementsByTagName('tbody');
	n = a.length;
	for(i=0;i < n; ++i){
		if(a.item(i).className == 'tabactive'){
			a.item(i).className='tab';
//			a.item(i).style.display='none';
		}
	}
	document.getElementById('tab' + id).className='tabactive';
//	document.getElementById('tab' + id).style.display='table-header-group';
	a = document.getElementsByTagName('span');
	n = a.length;
	for(i=0;i < n; ++i){
		if(a.item(i).className == 'tabheadactive') {
			a.item(i).className = 'tabhead';
		}
	}
	o.className='tabheadactive';
	switch(id){
	case '_summary':
		if(!rte_summary ) rte_summary_init();break;
	case '_detail':
		if(!rte_detail ) rte_detail_init();break;
	case '_warranty':
		if(!rte_warranty ) rte_warranty_init();break;
	case '_cf0':
		if(!rte_cf0 ) rte_cf0_init();break;
	case '_cf1':
		if(!rte_cf1 ) rte_cf1_init();break;
	case '_cf4':
		if(!rte_cf4 ) rte_cf4_init();break;
	case '_cf2':
		if(!rte_cf2 ) rte_cf2_init();break;
	case '_cf3':
		if(!rte_cf3 ) rte_cf3_init();break;
	case '_cf9':
		if(!rte_cf5 ) rte_cf5_init();break;
	case '_cf10':
		if(!rte_cf10 ) rte_cf10_init();break;
	}
}
</script>
<script language="javascript" src="js/item-script.js"></script>