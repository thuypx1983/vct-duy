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

</style>
</head>
<body class="text" style="overflow:hidden;width:97%; ">
<?php
//require fckeditor.
include_once("../fckeditor/fckeditor.php") ;
$sBasePath = URL_ADMIN.'fckeditor/' ;
?>

<form action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id.'&catid='.$this->catid ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data" id="idfrmItem">	
<input name="type" type="hidden" value="<?php echo $this->type; ?>" />
<table width="100%" border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<tr>
	<td width="16%">
	<div class="title">M&#227; hotel</div>
	<div><input type="text" onFocus="HIDE('attribute');" value="<?php echo $this->code; ?>" style="width:150px;" name="code" /></div>
	</td>
	<td colspan="2">
	<table width="100%"><tr>
	<td width="40%">
		<div class="title">T&#234;n hotel</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="name" id="name" value="<?php echo $this->name; ?>" style="width:100%;" onblur="getUrlRewrite();"></div>
	</td>
	<td width="10%">
		<div class="title">Sao</div>
		<div><select onFocus="HIDE('attribute');" name="manufacturer" style="width:100%;font-family:Tahoma;font-size:11px; ">
		<option value="<?php echo $this->manufacturer ?>"><?php echo $this->manufacturer ?></option>
		<?php readfile(PATH_APPLICATION.'hotelstar.htm');?>
		</select></div>
	</td>
	<td >
		<div class="title">Gi&#225; hotel</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="price" class="input" style="120px"  value="<?php echo htmlspecialchars($this->price); ?>" /></div>
	</td>
	<td >
		<div class="title">Qu&#7889;c gia</div>
		<div><nobr><input type="text" onFocus="HIDE('attribute');" name="country" class="input" style="width:50%;"  value="<?php echo htmlspecialchars($this->country); ?>" /><select name="countryid" onchange="this.previousSibling.value=this.options[this.selectedIndex].text" class="input">		<option value="<?php echo $this->countryid ?>" selected><?php echo $this->country ?></option><?php echo @readfile(PATH_APPLICATION.'countrycodes.htm'); ?></select></nobr></div>
	</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>
		<div class="title">&#272;i&#7879;n tho&#7841;i</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="unit" class="input" style="width:150px;"  value="<?php echo htmlspecialchars($this->unit); ?>" /></div>
	</td>
	<td colspan="2">
	<div style="float:left;width:60%;">
		<div class="title">&#272;&#7883;a ch&#7881;</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="include" class="input" style="width:100%;"  value="<?php echo htmlspecialchars($this->include); ?>" /></div>
	</div>
	<div style="float:left;width:35%;margin-left:5px;">
		<div class="title">T&#7881;nh/Th&#224;nh ph&#7889;</div>
		<div><nobr><input type="text" onFocus="HIDE('attribute');" name="model" class="input" style="width:50%;"  value="<?php echo htmlspecialchars($this->model); ?>" /><select onchange="this.previousSibling.value=this.options[this.selectedIndex].text">		<option value="<?php echo $this->model ?>" selected><?php echo $this->model ?></option><?php echo @readfile(PATH_APPLICATION.'citycodes.htm'); ?></select></nobr></div>
	</div>
	</td>
</tr>
<tr>
	<td>
		<div class="title">V&#7883; tr&iacute; kh&aacute;ch s&#7841;n</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="cf[5]" class="input" style="width:150px;"  value="<?php echo htmlspecialchars($this->cf[5]); ?>" /></div>
	</td>
	<td colspan="2">
		<div class="title">Url khi rewrite</div>
		<div><input type="text"  name="urlrewrite" id ="urlrewrite" value="<?php echo $this->urlrewrite; ?>" style="width:500px;" /></div>
	</td>
</tr>
<tr><td colspan="3">
	<table width="97%">
	<thead>
		<tr height="23" style="background-image:url(images/bg-product.gif);"><td align="center">
			<span name="tabhead" class="tabhead" onClick="showTab('_summary',this);">T&oacute;m t&#7855;t</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_detail',this);">Chi ti&#7871;t</span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_warranty',this);"><?php echo T_PRICE;?></span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf0',this);"><?php echo T_FACILITY ?></span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf1',this);"><?php echo T_ROOM; ?></span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf2',this);"><?php echo T_LOCATION; ?></span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf3',this);"><?php echo T_PROMOTION;?></span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf4',this);"><?php echo T_OVERVIEW;?></span>
			<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf5',this);"><?php echo T_CONTENT_RELATE;?></span>
		</td></tr>
	</thead>
	<tbody id="tab_summary" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$oFCKeditor = new FCKeditor('summary') ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->Height = 300 ;
	$oFCKeditor->Value = $this->summary;
	$oFCKeditor->Create() ;
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_detail" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$oFCKeditor = new FCKeditor('detail') ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->Height = 300 ;
	$oFCKeditor->Value = $this->detail;
	$oFCKeditor->Create() ;
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_warranty" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$oFCKeditor = new FCKeditor('warranty') ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->Height = 300 ;
	$oFCKeditor->Value = $this->warranty;
	$oFCKeditor->Create() ;
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf0" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$oFCKeditor = new FCKeditor('cf[0]') ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->Height = 300 ;
	$oFCKeditor->Value = $this->cf[0];
	$oFCKeditor->Create() ;
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf1" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$oFCKeditor = new FCKeditor('cf[1]') ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->Height = 300 ;
	$oFCKeditor->Value = $this->cf[1];
	$oFCKeditor->Create() ;
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf2" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$oFCKeditor = new FCKeditor('cf[2]') ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->Height = 300 ;
	$oFCKeditor->Value = $this->cf[2];
	$oFCKeditor->Create() ;
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf3" class="tab">
	<tr><td>
	<div style="width:100% ">
<?php
	$oFCKeditor = new FCKeditor('cf[3]') ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->Height = 300 ;
	$oFCKeditor->Value = $this->cf[3];
	$oFCKeditor->Create() ;
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf4" class="tab">
	<tr><td>
	<div style="width:100% ">	
<?php
	$oFCKeditor = new FCKeditor('cf[4]') ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->Height = 300 ;
	$oFCKeditor->Value = $this->cf[4];
	$oFCKeditor->Create() ;
?>
	</div>
	</td></tr>
	</tbody>
	<tbody id="tab_cf5" class="tab">
	<tr><td>
	<div style="width:100% ">	
<?php
	$oFCKeditor = new FCKeditor('cf[5]') ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->Height = 300 ;
	$oFCKeditor->Value = $this->cf[5];
	$oFCKeditor->Create() ;
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
	<td width="59%">
		<div class="title">T&#7915; g&#7907;i nh&#7899;</div>
		<div><input type="text" onFocus="HIDE('attribute');" name="keyword" class="input" value="<?php echo $this->keyword ?>" style="width:100%;"/></div>
	</td>
	<td width="25%" style="padding:0px 5px 0px 0px; ">
		<div class="title">Th&#7913; t&#7921;</div>
		<div><input type="text" onFocus="HIDE('attribute');" size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:30px;"/></div>
	</td>
</tr>
<tr>
	<td>		
		<div style="text-align:center;"><img src="images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG1,$this->img1 ? $this->img1:URL_ADMIN.'images/noimage.gif'," id='idimgImg1' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:40%;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>" style="width:90%" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG2,$this->img2 ? $this->img2:URL_ADMIN.'images/noimage.gif'," id='idimgImg2' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:40%;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>" style="width:90% "  /></div>
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
	case '_cf2':
		if(!rte_cf2 ) rte_cf2_init();break;
	case '_cf3':
		if(!rte_cf3 ) rte_cf3_init();break;
	case '_cf4':
		if(!rte_cf4 ) rte_cf4_init();break;
	case '_cf5':
		if(!rte_cf5 ) rte_cf5_init();break;
	}
}
function removeMark(str){ 
	var delimeter = "<?php echo URL_DELIMETER?>";
    //str= str.toLowerCase();  
    str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");  
    str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
    str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");  
    str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");  
    str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
    str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
    str= str.replace(/đ/g,"d");  
	str= str.replace(/Đ/g,"D");  
    str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_|-/g,delimeter); 
 /* repalce special character -> '-' */ 
    str= str.replace(/-+-/g,delimeter); //thay thế 2- thành 1- 
	str= str.replace(/_+_/g,delimeter); //thay the 2_ thanh 1_
    str= str.replace(/^\-+|\-+$/g,"");
	str= str.replace(/^\_+|\_+$/g,"");    
 //cắt bỏ ký tự - ở đầu và cuối chuỗi  
   return str;  
}   

function getUrlRewrite(){
	var name = document.getElementById('name');
	var urlrewrite = document.getElementById('urlrewrite');		
	urlrewrite.value = removeMark(name.value);		
}
</script>
<script language="javascript" src="js/item-script.js"></script>
<script language="javascript" src="<?php echo URL_BASE ?>'js/admin-overload.js"></script>
<?php dbclose(); ?>