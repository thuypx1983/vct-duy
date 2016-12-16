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
<form method="post"  enctype="multipart/form-data" id="idfrmItem">
<?php
require_once(PATH_COMPLS.'product-package.php');
while(list($key,$val) = each($_POST[$obj->btnPackageEditID])){	
	$PackageName = $key;
	$packageclass = $_POST['PackageClass'];
	$productid = (int)$_POST['ProductID'];
	$ArrayPackageTypesAlias = $PRODUCT_PACKAGE_HOTEL_TYPE_ALIAS[0];
	$colspan = count($ArrayPackageTypesAlias);
?>
<table width="100%" border="0">
<tr>
	<th width="9%">
		T&#234;n	
	</th>
	<td colspan="<?php echo $colspan; ?>" width="30%">
		<input type="text" onFocus="HIDE('attribute');" name="o_name" value="<?php echo $PackageName; ?>" />
	</td>	
</tr>
<tr>
	<th>
		Lo&#7841;i
	</th>	
	<?php 
	$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$packageclass,'',-1,'','',-1,-1,-1,-1,'');
	while($tmp = mysql_fetch_assoc($AllTypeColection)){			
	 	echo '<td>'.$ArrayPackageTypesAlias[(int)$tmp['type']].'</td>';
	 }?>
</tr>
<tr>
	<?php 
	$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',$productid,$packageclass,'',-1,'','',-1,-1,-1,-1,'');
	$count = 0;
	echo '<td>&nbsp;</td>';
	while($tmp1 = mysql_fetch_assoc($AllTypeColection)){	
		$list = package_filter('PdPk','',$productid,$packageclass,'',(int)$tmp1['type'],'','',-1,-1,-1,-1,'');
		echo '<td><input type="checkbox" name="type['.$count.']" ';
		while($tmp2 = mysql_fetch_assoc($list)){
			if($tmp2['ctrl']==1)
				echo 'checked="checked"';
		}
		echo '/></td>';
		$count++;
	}
	mysql_free_result($AllTypeColection);
	?>
</tr>
<?php 
	$tmp = package_filter('PdPk','`PdPk`.`Desc`,`PdPk`.`Detail`,`PdPk`.`Img`,`PdPk`.`Alt`,`PdPk`.`Img1`,`PdPk`.`Alt1`',$productid,$packageclass,$PackageName,-1,'','',-1,-1,-1,1,'');
	while($tmp1 = mysql_fetch_assoc($tmp)){ 	
?>
<tr>
	<th>Thông tin phòng</th>
	<td colspan="<?php echo $colspan; ?>">
		<textarea  rows="10" name="o_desc" style="width:100%;" ><?php echo $tmp1['Desc']; ?></textarea>
	</td>
</tr>
<tr height="16px">
	<td valign="top" align="center">		
		<strong>Ti&#7879;n nghi ph&ograve;ng</strong>
	</td>
	<td >		
		<table border="0">
		<?php
			//lay id cua product package dung cho ham getcomfort() phia duoi
			$sql = "SELECT `id` FROM `".DB_TABLE_PREFIX."productpackage` WHERE `productid`=".$productid." AND `name`='".$PackageName."' AND `class`='".$packageclass."'";			
			$rs = mysql_query($sql);
			$a_id = array();
			while($a_id[] = mysql_fetch_assoc($rs));
			array_pop($a_id);
			mysql_free_result($rs);			
			//lay ra tat ca cac tien nghi phong da nhap vao
			$rs = comfortlist();
			if($rs){
				$a_list = array();
				while($a_list[] = mysql_fetch_assoc($rs));				
				array_pop($a_list);				
				mysql_free_result($rs);						
				//lay ra danh sach tien nghi cua tung loai phong
				$rs = getcomfort($productid,$a_id);
				$a_cf = array();				
				while($a_cf[] = mysql_fetch_assoc($rs));
				array_pop($a_cf);
				mysql_free_result($rs);
				$a_ot = array_diff_assoc($a_list,$a_cf);							
				$i=0;
				if(count($a_cf)!=0){
					foreach($a_cf as $row){
						echo '<tr>';
							echo '<td>';						
								echo '<input type="checkbox" name="l_type['.++$i.']" value="'.$row['Id'].'" checked="checked" />';
							echo '</td>';
							echo '<td >';
								echo '<input type="text" name="l_name['.++$i.']" value="'.$row['Name'].'" class="input" style="width:300px;"/>';
							echo '</td>';
						echo '</tr>';
					}
				}
				foreach($a_ot as $rw){
					echo '<tr>';
						echo '<td>';						
							echo '<input type="checkbox" name="l_type['.++$i.']" value="'.$rw['Id'].'"/>';
						echo '</td>';
						echo '<td >';
							echo '<input type="text" name="l_name['.++$i.']" value="'.$rw['Name'].'" class="input" style="width:301px;"/>';
						echo '</td>';
					echo '</tr>';
				}
			}else{			
		?>	
		<tr>
		  <td width="721">Chưa có tiện nghi phòng nào, hãy nhập vào trong mục thông tin hệ thống </td>
		</tr>
		<?php }?>	
		</table>
	</td>
</tr>
<tr>
	<td>		
		<div style="text-align:center;"><img src="images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_PACKAGE_IMG1,$tmp1['Img'] ? $tmp1['Img']:URL_ADMIN.'images/noimage.gif'," id='idimgImg1' align='absmiddle'");?></div>
	</td>
	<td colspan="<?php echo $colspan; ?>">		
		<div><input type="text" onFocus="HIDE('attribute');" name="o_img" class="input" value="<?php echo htmlspecialchars($tmp1['Img']); ?>" style="width:40%;" /><iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1&act=13"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="o_alt" class="input" value="<?php echo htmlspecialchars($tmp1['Alt']); ?>" style="width:90%" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_PACKAGE_IMG2,$tmp1['Img1'] ? $tmp1['Img1']:URL_ADMIN.'images/noimage.gif'," id='idimgImg2' align='absmiddle'");?></div>
	</td>
	<td colspan="<?php echo $colspan; ?>">		
		<div><input type="text" onFocus="HIDE('attribute');" name="o_img1" class="input" value="<?php echo htmlspecialchars($tmp1['Img1']); ?>" style="width:40%;" /><iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2&act=13"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="o_alt1" class="input" value="<?php echo htmlspecialchars($tmp1['Alt1']); ?>" style="width:90% "  /></div>
	</td>
</tr>
<?php }?>

</table>
<?php } ?>
<tr>
	<td>&nbsp;</td>
	<td colspan="<?php echo $colspan;?>">
		<input type="submit" class="button" value="Sửa" name="packagesavedetail" />
		<input type="submit" class="button" value="Nhập lại" name="pricereturn" />
	</td>	
</tr>
</form>
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
}

</script>