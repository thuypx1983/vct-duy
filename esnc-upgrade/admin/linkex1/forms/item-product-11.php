<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<head><title>Chi ti&#7871;t doanh nghi&#7879;p</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<comment><link type="text/css" rel="stylesheet" href="images/style-nonie.css" /></comment>
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
	background:url(images/selectbox.gif);
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
table{width:95%;margin:0px 0px 0px 2px;}
</style>
</head>
<body class="text" >
<form action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id.'&catid='.$this->catid ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data" id="idfrmItem">	
<input name="type" type="hidden" value="<?php echo $this->type; ?>" />
<table>
	<tr><td width="150px">
	<div class="title">M&#227;</div>
	<div><input type="text" onFocus="HIDE('attribute');" value="<?php echo $this->code; ?>" style="width:150px;" name="code" /></div>
	</td><td>
	<div class="title">T&#234;n</div>
	<div><input type="text" onFocus="HIDE('attribute');" name="name" value="<?php echo $this->name; ?>" style="width:100%;"></div>
	</td></tr>
</table>
<table>
	<tr>
		<td><div class="title">Qu&#7889;c gia</div>	
			<div><nobr>
					<input type="text" onFocus="HIDE('attribute');" name="country" class="input" style="width:150px;"  value="<?php echo htmlspecialchars($this->country); ?>" /><?php 
				  ?><select name="countryid" onchange="this.previousSibling.value=this.options[this.selectedIndex].text" class="input">
					<option value="<?php echo $this->countryid ?>" selected><?php echo $this->country ?></option>
				<?php echo @readfile(PATH_APPLICATION.'countrycodes.htm'); ?></select>
				</nobr>
			</div>
	</td><td>
		<div class="title">T&#7881;nh/Th&#224;nh ph&#7889;</div>
		<div><nobr><input type="text" onFocus="HIDE('attribute');" name="manufacturer" class="input" style="width:150px"  value="<?php echo htmlspecialchars($this->manufacturer); ?>" /><?php //no extra blank in firefox
			?><select onchange="this.previousSibling.value=this.options[this.selectedIndex].text">
			<option value="<?php echo $this->manufacturer ?>" selected><?php echo $this->manufacturer ?></option>
			<?php echo @readfile(PATH_APPLICATION.'citycodes.htm'); ?>
			</select>
		</div>
	</td><td width="300px">
		<div class="title">&#272;&#7883;a ch&#7881;</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="model" class="input" style="width:100%;"  value="<?php echo htmlspecialchars($this->model); ?>" /></div>
	</td>
	</tr>
</table>
<table>
	<tr>
		<td><div class="title">&#272;i&#7879;n tho&#7841;i/Fax</div>
			<div><input type="text" onFocus="HIDE('attribute');" name="unit" class="input" style="width:150px;"  value="<?php echo htmlspecialchars($this->unit); ?>" /></div>
		</td><td>
			<div class="title">Email</div>
			<div><input type="text" onFocus="HIDE('attribute');" name="warranty" class="input" style="width:300px"  value="<?php echo htmlspecialchars($this->warranty); ?>" /></div>
		</td><td>
			<div class="title">website</div>
			<div><input type="text" onFocus="HIDE('attribute');" name="include" class="input" style="width:100%;"  value="<?php echo htmlspecialchars($this->include); ?>" /></div>
		</td>
	</tr>
</table>
<table>
	<thead>
		<tr height="23" style="background-image:url(images/bg-product.gif);"><td align="center">
			<span name="tabhead" class="tabhead" onClick="showTab('_summary',this);">T&oacute;m t&#7855;t</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_detail',this);">Chi ti&#7871;t</span>
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
</table>
<table>
	<tr><td width="140px">
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
	</td><td >
		<div class="title">T&#7915; g&#7907;i nh&#7899;</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="keyword" class="input" value="<?php echo $this->keyword ?>" style="width:95%"/></div>
	</td><td width="62px">
		<div class="title">Th&#7913; t&#7921;</div>
		<div><input type="text" onFocus="HIDE('attribute');" size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:60px;"/></div>
	</td></tr>
</table>
<table>
	<tr><td width="150px">
		<div style="text-align:center;"><img src="images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG1,$this->img1 ? $this->img1:URL_ADMIN.'images/noimage.gif'," id='idimgImg1' align='absmiddle'");?></div>
	</td><td>
		<div><input type="text" onFocus="HIDE('attribute');" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:40%;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>" style="width:90%" /></div>
	</td></tr>
</table>
<table>
	<tr><td width="150px">
		<div style="text-align:center;"><img src="images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG2,$this->img2 ? $this->img2:URL_ADMIN.'images/noimage.gif'," id='idimgImg2' align='absmiddle'");?></div>
	</td><td>
		<div><input type="text" onFocus="HIDE('attribute');" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:40%;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>" style="width:90% "  /></div>
	</td></tr>
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
	}
}
</script>
<script language="javascript" src="js/item-script.js"></script>
<script language="javascript" src="<?php echo URL_BASE ?>js/admin-overload.js"></script>