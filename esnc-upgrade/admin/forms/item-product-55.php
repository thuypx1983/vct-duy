﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<body class="text" onload="showTab('_summary',this);">
<form  action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id.'&catid='.$this->catid ?>" method="post" onSubmit="return checkForm(this)" enctype="multipart/form-data" id="idfrmItem">
<input name="type" type="hidden" value="<?php echo $this->type ?>">
<table width="98%" border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden'">
<tr>
	<td>
	<div class="title">At Airport</div>
	<div><input type="text" value="<?php echo $this->code ?>" style="width:150px;" name="code"></div>
	</td>
	
	<td>
		<div class="title">At Embassy</div>
		<div><input type="text" name="price" class="input" style="width:60%;" value="<?php echo htmlspecialchars($this->price) ?>"></div>
	</td>
	<td >
	<div class="title">T&#234;n </div>
	<div><input type="text" name="name" value="<?php echo $this->name ?>" style="width:95%;"></div>
	</td>
</tr>
<tr>
	<td>
		<div class="title"></div>
		<div></div></td>
	<td colspan="2">
	<div style="float:left;width:49%;">
		<div class="title"></div>
		<div>		
		<nobr></nobr> </div>
	</div><div style="float:left;width:49%;margin-left:5px;">
		<div class="title"></div>
		<div><nobr></nobr> </div>
	</div>
	</td>
	
</tr>
<tr>
	<td >
		<div class="title"></div>
		<div></div>
	</td>
	<td>
	    <div class="title"></div>
	    <div></div>	
	</td>
	<td>
		<div class="title"></div>
		<div></div>
	</td>
	
	
</tr>
<tr><td colspan="3">
	<table width="100%">
	<thead>
		<tr height="23" style="background-image:url(images/bg-product.gif);">
		  <td align="center">
			<span name="tabhead" class="tabhead" onClick="showTab('_summary',this);">Visa service  </span>&nbsp;|&nbsp;
			<span name="tabhead" class="tabhead" onClick="showTab('_detail',this);">Note</span>		
		</td>
		</tr>
	</thead>
	<tbody id="tab_summary" class="tab">
	<tr><td>
	<div style="width:100% ">
		<?php
		include_once("../fckeditor/fckeditor.php") ;
		$sBasePath = URL_ADMIN.'fckeditor/' ;
		//echo $sBasePath;
		$oFCKeditor = new FCKeditor('summary') ;
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Height = 300 ;
		//$oFCKeditor->Config[ 'ToolbarLocation' ] = 'Out:xToolbar' ;
		$oFCKeditor->Value		=  $this->summary;
		$oFCKeditor->Config['EnterMode'] = 'br';$oFCKeditor->Create() ;
		?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_detail" class="tab">
	<tr><td>
	<div style="width:100% ">
		<?php
		$oFCKeditor = new FCKeditor('detail') ;
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Height = 300 ;
		//$oFCKeditor->Config[ 'ToolbarLocation' ] = 'Out:xToolbar' ;
		$oFCKeditor->Value		=  $this->detail;
		$oFCKeditor->Config['EnterMode'] = 'br';$oFCKeditor->Create() ;
		?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf0" class="tab">
	<tr><td>
	<div style="width:100% ">

	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf1" class="tab">
	<tr><td>
	<div style="width:100% ">

	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf2" class="tab">
	<tr><td>
	<div style="width:100% ">

	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf3" class="tab">
	<tr><td>
	<div style="width:100% ">

	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf4" class="tab">
	<tr><td>
	<div style="width:100% ">	

	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf5" class="tab">
	<tr><td>
	<div style="width:100% ">	

	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf6" class="tab">
	<tr><td>
	<div style="width:100% ">	
	
	</div>
	</td></tr>
	</tbody>
	</table>
</td></tr>
<tr>
	<td>
		<div class="title">&#272;&#7863;c T&#237;nh</div>
		<div>
			<div id="attributetext" onClick="SHOW('attribute')">&#272;&#7863;c T&#237;nh Hi&#7875;n Th&#7883;</div>
			<div id="attribute">
			<?php 
			foreach($this->a_ctrl as $ctl=>$text){
				echo '<div><input type="checkbox" value="'.$ctl.'" name="ctrl[]"';
				if($this->ctrl & $ctl) echo ' checked';
				echo '>&nbsp;'.$text.'</div>';
			}?>
				<div style="text-align:right; "><a href="#" onClick="SHOW('attribute');return false;">&#272;&#243;ng</a></div>
			</div>
		</div>
	</td>
	<td>
		<div class="title">T&#7915; G&#7907;i Nh&#7899;</div>
		<div><input type="text"  name="keyword" class="input" value="<?php echo $this->keyword ?>" style="width:100%;"></div>
	</td>
	<td>
		<div class="title">Th&#7913; T&#7921; Hi&#7875;n Th&#7883;</div>
		<div><input type="text"  size="2" name="view" class="input" value="<?php echo $this->view ?>" style="width:30px;"></div>
	</td>
</tr>
<tr>
	<td>
		<div style="text-align:center;"><img src="images/picture1.gif" align="absmiddle">&nbsp;
		<?php htmlview(URL_PRODUCT_IMG1,$this->img1?$this->img1:URL_ADMIN.'images/noimage.gif'," id='idimgImg1' align='absmiddle'") ?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1) ?>" style="width:250px;">&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; Th&#237;ch</div>
		<div><input type="text" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1) ?>"  style="width:99%;"></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="images/picture2.gif" align="absmiddle">&nbsp;
		<?php htmlview(URL_PRODUCT_IMG2,$this->img2?$this->img2:URL_ADMIN.'images/noimage.gif'," id='idimgImg2' align='absmiddle'") ?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2) ?>" style="width:250px;">&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; Th&#237;ch</div>
		<div><input type="text" name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2) ?>" style="width:99%;"></div>
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
