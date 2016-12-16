<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $this->doctitle ?></title>
<link type="text/css" rel="stylesheet" href="images/style.css">
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css">
</comment>
<link type="text/css" rel="stylesheet" href="images/rtestyle.css">
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" src="js/rte.js" type="text/javascript"></script>
<script language="javascript" src="js/item-script.js"></script>
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
<body class="text" >
<form  action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id.'&catid='.$this->catid ?>" method="post" onSubmit="return checkForm(this)" enctype="multipart/form-data" id="idfrmItem">
<input name="type" type="hidden" value="<?php echo $this->type ?>">
<table width="80%" border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden'">
<tr>
	<td>
		<div class="title">Hãng hàng không</div>
		<div><input type="text" name="price" class="input" style="width:60%;" value="<?php echo htmlspecialchars($this->price) ?>"></div>
	</td>
	<td>
		<div class="title">T&#234;n </div>
		<div><input type="text" name="name" value="<?php echo $this->name ?>" style="width:95%;"></div>
	</td>
	<td>
		<div class="title">Th&#7901;i l&#432;&#7907;ng bay </div>
		<div><input type="text" name="manufacturer" value="<?php echo $this->manufacturer ?>" style="width:95%;"></div>
	</td>
</tr>
<tr>
	<td>
		<div style="float:left;width:49%;">
			<div class="title">&#272;i&#7875;m Xu&#7845;t Ph&#225;t</div>
			<div>		
			<nobr><input type="text" onfocus="HIDE('attribute')" name="include" class="input" style="width:60%" value="<?php echo htmlspecialchars($this->include) ?>"><select onchange="this.previousSibling.value=this.options[this.selectedIndex].text"><option value="<?php echo $this->include ?>" selected><?php echo $this->include ?></option><?php echo @readfile(PATH_APPLICATION.'citycodes.htm') ?></select></nobr>
			</div>
		</div>
	</td>	
	<td colspan="2">
		<div style="float:left;width:49%;margin-left:5px;">
			<div class="title">&#272;i&#7875;m K&#7871;t Th&#250;c</div>
			<div><nobr><input type="text" onfocus="HIDE('attribute')" name="unit" class="input" style="width:60%" value="<?php echo htmlspecialchars($this->unit) ?>"><select onchange="this.previousSibling.value=this.options[this.selectedIndex].text"><option value="<?php echo $this->unit ?>" selected><?php echo $this->unit ?></option><?php echo @readfile(PATH_APPLICATION.'citycodes.htm') ?></select></nobr>	
		</div>
	</div>
	</td>
</tr>
<tr>
	<td >
		<div class="title">Ngày đi</div>
		<div>
		<textarea onFocus="HIDE('attribute');" rows="10" name="warranty" class="input" style="width:100%;"><?php echo htmlspecialchars($this->warranty); ?></textarea></div>
	</td>
	<td>
	    <div class="title">Giờ đi</div>
	    <div>
		<textarea onFocus="HIDE('attribute');" rows="10" name="model" class="input" style="width:100%;"><?php echo htmlspecialchars($this->model); ?></textarea>
		</div>	
	</td>	
	<td>
	    <div class="title">Giờ đến</div>
	    <div>
		<textarea onFocus="HIDE('attribute');" rows="10" name="country" class="input" style="width:100%;"><?php echo htmlspecialchars($this->country); ?></textarea>
		</div>	
	</td>	
</tr>
<tr>
	<td colspan="3">
		<div class="title">Th&#244;ng tin v&#233; </div>
		<div><textarea onFocus="HIDE('attribute');" rows="5" name="summary" class="input" style="width:90%;"><?php echo htmlspecialchars($this->summary); ?></textarea></div>
	</td>
</tr>
<tr>
	<td>
		<div class="title">T&#7915; G&#7907;i Nh&#7899;</div>
		<div><input type="text"  name="keyword" class="input" value="<?php echo $this->keyword ?>" style="width:100%;"></div>
	</td>
	<td colspan="2">
		<div class="title">Th&#7913; T&#7921; Hi&#7875;n Th&#7883;</div>
		<div><input type="text"  size="2" name="view" class="input" value="<?php echo $this->view ?>" style="width:30px;"></div>
	</td>
</tr>
<tr>
	<td colspan="3">
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
<?php RTE::loadRTEDialog() ?>	
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title= self.document.title;
var self_id= '<?php echo $this->id ?>';
var self_type= '<?php echo $this->type ?>';
var frmItem= document.getElementById("idfrmItem");
var imgImg1= document.getElementById('idimgImg1');
var imgImg2= document.getElementById('idimgImg2');
var imgImg= document.getElementById('idimgImg');
var url_self= '<?php echo URL_SELF ?>';
var url_up= '<?php echo dirname(URL_SELF) ?>/item-list.php?<?php echo urlmodify($this->alias.'id',NULL,$this->catalias.'id',$this->catid) ?>';
var url_newitem=url_self+ '?<?php echo urlmodify('catid',$this->catid,$this->alias.'id',0,'id',0,'type',$_GET['type']) ?>';
function showContent(o){
	window.open(url_rte, "subWindow", sParams);
}
function checkForm(f){
	if(f.name.value== ''){
		parent.banner.setStatus("Ph&#7843;i nh&#7853;p t&#234;n c&#7911;a s&#7843;n ph&#7849;m");
		f.name.focus();return false;
	}
	return true;
}
function showTab(id,o){
	a= document.getElementsByTagName('tbody');
	n= a.length;
	for(i= 0; i< n; ++i){
		if(a.item(i).className== 'tabactive'){
			a.item(i).className= 'tab';
		}
	}
	document.getElementById('tab'+ id).className= 'tabactive';
	a= document.getElementsByTagName('span');
	n= a.length;
	for(i= 0; i< n; ++i){
		if(a.item(i).className== 'tabheadactive') {
			a.item(i).className= 'tabhead';
		}
	}
	o.className= 'tabheadactive';
}

function SHOW(id){
	var o= document.getElementById(id);	
	if(o.style.visibility =='hidden' || o.style.visibility ==''){
		o.style.visibility='visible';
	}
	else{
		o.style.visibility='hidden';
	}
	if (o.clientWidth< 154) o.style.width= '154px';
}
function HIDE(id){
	var o= document.getElementById(id);
	o.style.visibility ='hidden';
}
</script>
