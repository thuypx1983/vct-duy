<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<head><title><?php echo $this->doctitle;?></title>
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
.tab{display:none;}
.tabactive{display:table-header-group;}
.tabhead{cursor:pointer;font-size:11px;font-weight:normal;color:black;}
.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;}
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
</tr>
<tr>	
<?php //thay doi phan gia ve thanh thoi gian cua chuyen bay tho du an giatriviet ?>
	<td>
		<div class="title">th&#7901;i gian</div>
		<div><textarea onFocus="HIDE('attribute');" rows="10" name="cf[0]" class="input" style="width:100%;"><?php echo htmlspecialchars($this->cf[0]); ?></textarea></div>
	</td>
	<td width="20%">
		<div class="title">Ng&agrave;y(th&#7913;)</div>
		<div><textarea  onFocus="HIDE('attribute');" rows="10" name="cf[1]" class="input" style="width:100%;"><?php echo htmlspecialchars($this->cf[1]); ?></textarea></div>
	</td>		
    <td valign="top">
		<div class="title">Gi&#225;</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="price" class="input" style="150px"  value="<?php echo htmlspecialchars($this->price); ?>" /></div>
	</td>
</tr>
<tr><td colspan="3">
	<table width="97%">
	<thead>
		<tr height="23" style="background-image:url(images/bg-product.gif);"><td align="center">
			<span name="tabhead" class="tabheadactive" onClick="showTab('_summary',this);">T&oacute;m t&#7855;t</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_detail',this);">Chi ti&#7871;t</span>
		</td></tr>
	</thead>
	<tbody id="tab_summary" class="tabactive">
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
    </table>
    </td>
</tr>
<tr>	
	<td width="20%">
		<div class="title">H&atilde;ng</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="model" class="input" style="width:100%;"  value="<?php echo htmlspecialchars($this->model); ?>"/></div>
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
	<td>
		<div>&nbsp;</div>
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
	}
}

</script>
<script language="javascript" src="js/item-script.js"></script>
<script language="javascript" src="<?php echo URL_BASE ?>'js/admin-overload.js"></script>
<?php dbclose(); ?>