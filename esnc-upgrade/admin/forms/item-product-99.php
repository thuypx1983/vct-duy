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
	<div class="title">M&#227; Tour</div>
	<div><input type="text"  value="<?php echo $this->code; ?>" style="width:150px;" name="code" /></div>
	</td>
	<td width="66%">
	<div class="title">T&#234;n Tour</div>
	<div><input type="text"  name="name" value="<?php echo $this->name; ?>" style="width:95%;" /></div>
	</td>
	<td>
		<div class="title">Gi&aacute;</div>
		<div><input type="text"  name="price"  class="input" style="width:97%;"  value="<?php echo htmlspecialchars($this->price); ?>" /></div>
	</td>
</tr>
<tr>
	<td>
		<div class="title">Th&#7901;i L&#432;&#7907;ng</div>
		<div><input type="text"  name="manufacturer" class="input" style="width:150px;"  value="<?php echo htmlspecialchars($this->manufacturer); ?>" /></div>
	</td>
	<td colspan="2">
	<div style="float:left;width:49%;">
		<div class="title">Đi&#7875;m Xu&#7845;t Ph&#225;t</div>
		<div><input type="text" name="include" class="input" style="width:150px"  value="<?php echo htmlspecialchars($this->include); ?>" /><select onchange="this.previousSibling.value=this.options[this.selectedIndex].text">
		<option selected><?php echo $this->include ?></option>
		<?php echo @readfile(PATH_APPLICATION.'citycodes.htm'); ?>
		</select>
		</div>
	</div><div style="float:left;width:49%;margin-left:5px;">
		<div class="title">Đi&#7875;m K&#7871;t Th&#250;c</div>
		<div><input type="text" name="unit" class="input" style="width:150px;"  value="<?php echo htmlspecialchars($this->unit); ?>" /><select onchange="this.previousSibling.value=this.options[this.selectedIndex].text">
		<option selected><?php echo $this->unit ?></option>
		<?php echo @readfile(PATH_APPLICATION.'citycodes.htm'); ?>
		</select>		
		</div>
	</div>
	</td>
	
</tr>
<tr><td colspan="3">
	<table width="100%">
	<thead>
		<tr height="23" style="background-image:url(images/bg-product.gif);"><td align="center">
			<span name="tabhead" class="tabhead" onClick="showTab('_summary',this);">T&oacute;m T&#7855;t</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_detail',this);">Lịch Trình Tour</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf5',this);">Thông Tin Gói Tour</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf6',this);">Dịch Vụ Gia Tăng</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf7',this);">Dịch Vụ Kèm Theo</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf8',this);">Điểm Đến Nỗi Bật</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf9',this);">Sự Kiện Nỗi Bật</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf10',this);">Khác</span>
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
	<tbody id="tab_cf5" class="tab">
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
	<tbody id="tab_cf6" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf6');
	$rte->show('cf[6]',$this->cf[6],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf7" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf7');
	$rte->show('cf[7]',$this->cf[7],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf8" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf8');
	$rte->show('cf[8]',$this->cf[8],'200px');
	$rte->initRteObjectScript(FALSE);
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf9" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$rte->rename('rte_cf9');
	$rte->show('cf[9]',$this->cf[9],'200px');
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
		<div class="title">&#272;&#7863;c T&#237;nh</div>
		<div>
			<div id="attributetext" onClick="SHOW('attribute');">&#272;&#259;c T&#237;nh Hi&#7875;n Th&#7883;</div>
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
		<div class="title">T&#7915; G&#7907;i Nh&#7899;</div>
		<div><input type="text"  name="keyword" class="input" value="<?php echo $this->keyword ?>" style="width:100%;"/></div>
	</td>
	<td>
		<div class="title">Th&#7913; T&#7921; Hi&#7875;n Th&#7883;</div>
		<div><input type="text"  size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:30px;"/></div>
	</td>
</tr>
<tr>
	<td>		
		<div style="text-align:center;"><img src="images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG1,$this->img1 ? $this->img1:URL_ADMIN.'images/noimage.gif'," id='idimgImg1' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text"  name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; Th&#237;ch </div>
		<div><input type="text"  name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>"  style="width:99%;" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG2,$this->img2 ? $this->img2:URL_ADMIN.'images/noimage.gif'," id='idimgImg2' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text"  name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; Th&#237;ch </div>
		<div><input type="text"  name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>"  style="width:99%;" /></div>
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
		f.name.focus();return false;
	}
	if(rte_summary) rte_summary.rteToInput();
	if(rte_detail) 	rte_detail.rteToInput();
	if(rte_cf5) 	rte_cf5.rteToInput();
	if(rte_cf6) 	rte_cf6.rteToInput();
	if(rte_cf7) 	rte_cf7.rteToInput();
	if(rte_cf8) 	rte_cf8.rteToInput();
	if(rte_cf9) 	rte_cf9.rteToInput();
	if(rte_cf10) 	rte_cf10.rteToInput();
	return true;
}
function showTab(id,o){
	a = document.getElementsByTagName('tbody');
	n = a.length;
	for(i=0;i < n; ++i){
		if(a.item(i).className == 'tabactive'){
			a.item(i).className='tab';
		}
	}
	document.getElementById('tab' + id).className='tabactive';
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
	case '_cf5':
		if(!rte_cf5 ) rte_cf5_init();break;
	case '_cf6':
		if(!rte_cf6 ) rte_cf6_init();break;
	case '_cf7':
		if(!rte_cf7 ) rte_cf7_init();break;
	case '_cf8':
		if(!rte_cf8 ) rte_cf8_init();break;
	case '_cf9':
		if(!rte_cf9 ) rte_cf9_init();break;
	case '_cf10':
		if(!rte_cf10 ) rte_cf10_init();break;
	}
}
</script>
<script language="javascript" src="js/item-script.js"></script>