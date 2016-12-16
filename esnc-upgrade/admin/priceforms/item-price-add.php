<?php require('../../compls/product-package.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
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
<script>
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
input.button {
background:#C9464A none repeat scroll 0 0;
border:1px solid #FFFFFF;
color:#FFFFFF;
font-size:11px;
font-weight:bold;
height:30px;
margin:7px 0 0;
padding:1px;
width:80px;
}
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
	background:url(../forms/images/selectbox.gif);
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
<body>
<form method="post" name="f_add" onsubmit="return checkForm(f_add);"  enctype="multipart/form-data" id="idfrmItem">
<?php
$pkg = new	package_group();
$pkg->productid = $this->id;
$pkg->class = $Class;
if($pkg->productid<0) return false;
if($pkg->class=='') return false;
$ArrayPackageTypesAlias = $PRODUCT_PACKAGE_HOTEL_TYPE_ALIAS[0];
$colspan = count($ArrayPackageTypesAlias);
echo '<input type="hidden" value="'.$pkg->class.'" name="PackageClass" />';
?>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
<tr>
	<th width="14%">
		T&#234;n	</th>
	<td width="86%" colspan="<?php echo $colspan;?>">
		<input type="text" onFocus="HIDE('attribute');" name="name" value="" style="width:500px;">
	</td>	
</tr>
<tr>
	<th>
		Lo&#7841;i
	</th>	
	<?php 
	foreach($ArrayPackageTypesAlias as $type){
	 	echo '<td width="100px">'.$type.'</td>';
	 }
	 ?>
</tr>
<tr>
	<?php 	
	$count = 0;
	echo '<td>&nbsp;</td>';
	foreach($ArrayPackageTypesAlias as $type){
		echo '<td><input type="checkbox" name="type['.$count.']" /></td>';
		$count++;
	}
	?>
</tr>
<tr>
	<th>Thông tin phòng</th>
	<td colspan="<?php echo $colspan;?>">
		<textarea  rows="10" name="desc" style="width:500px;" ></textarea>
	</td>
</tr>
<tr>
	<td valign="top">		
		<strong>Ti&#7879;n nghi ph&ograve;ng</strong>
	</td>
	<td colspan="<?php echo $colspan;?>">		
		<table border="0">
		<?php
			$i=0;	
			$rs = comfortlist();
			if($rs){
				while($row = mysql_fetch_assoc($rs)){
					echo '<tr>';
						echo '<td>';
							echo '<input type="checkbox" name="l_type['.++$i.']" value="'.$row['Id'].'" checked="checked" />';
						echo '</td>';
						echo '<td >';
							echo '<input type="text" name="l_name['.++$i.']" value="'.$row['Name'].'" class="input" style="width:300px;"/>';
						echo '</td>';
					echo '</tr>';
				}
				mysql_free_result($rs);
			}else{?>
			<tr><td width="545"><span class="style1">* Cần thêm các tiện nghi phòng trong phần thông tin hệ thống</span></td>
			</tr>	
		<?php }?>		
		</table>
	</td>
</tr>
<tr>
	<td>		
		<div style="text-align:center;"><img src="/esnc/images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_ROOM_IMG1,$this->img1 ? $this->img1:URL_ADMIN.'images/noimage.gif'," id='idimgImg1' align='absmiddle'");?></div>
	</td>
	<td colspan="<?php echo $colspan;?>">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:40%;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>" style="width:90%" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="/esnc/images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_ROOM_IMG2,$this->img2 ? $this->img2:URL_ADMIN.'images/noimage.gif'," id='idimgImg2' align='absmiddle'");?></div>
	</td>
	<td colspan="<?php echo $colspan;?>">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img1" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:40%;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>" style="width:90% "  /></div>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="<?php echo $colspan;?>">
		<input type="submit" class="button" value="Th&ecirc;m m&#7899;i" name="packagesavenew" />
		<input type="submit" class="button" value="Nh&#7853;p l&#7841;i" name="pricereturn" />
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
function showContent(o){
	window.open(url_rte, "subWindow",sParams);
}
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p T&#234;n");
		f.name.focus();
		return false;
	}	
	return true;
}
</script>