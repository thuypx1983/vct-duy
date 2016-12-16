<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
global $PRODUCT_PACKAGE_CLASS;
global $PRODUCT_PACKAGE_TYPE_ALIAS;
?>
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
<body class="text">
<form  method="post">
<?php
	$Class = 'TourService';
	$temp = $PRODUCT_PACKAGE_CLASS[$this->type];while(list($i,$val) = each($temp ))	if($val==$Class)$TypeAlias = $PRODUCT_PACKAGE_TYPE_ALIAS[$this->type][$i];
	$obj = new PackageView();
	$obj->ID = $Class;
	$obj->load($this->id,$Class);
	$obj->ArrayPackageTypesAlias = $TypeAlias;
	$obj->EnablePackageEdit = true;
	//$obj->EnablePackageSave= true;
	$obj->EnablePackageDel = true;

	if($_POST[$obj->btnPackageDeleteID] != null){
		while(list($key,$val) = each($_POST[$obj->btnPackageDeleteID])){
			$pkg = new	package_group();
			$pkg->productid = $this->id;
			$pkg->class = $Class;
			$pkg->o_name = $key;
			$pkg->name = $key;
			$pkg->remove();
		}
		$obj->show();
		echo '<input type="submit" value="Add new" name="packageadd" />
			<input type="submit" value="Save" name="packagesave" />
			<input type="submit" value="Price" name="price" />';
	}
	elseif($_POST[$obj->btnPackageEditID] != null){
		while(list($key,$val) = each($_POST[$obj->btnPackageEditID])){
			$obj->showEditPackageForm($key);
		}
		echo '<input type="submit" value="Save" name="packagesavedetail" />
			<input type="submit" value="Return" name="pricereturn" />';
	}
	elseif($_POST[$obj->btnPackageSaveID] != null){
		while(list($key,$val) = each($_POST[$obj->btnPackageDeleteID])){
			$pkg = new	package_group();
			$pkg->productid = $this->id;
			$pkg->class = $Class;
			$pkg->o_name = $key;
			$pkg->name = $key;
		}
		$obj->show();
		echo '<input type="submit" value="Add new" name="packageadd" />
			<input type="submit" value="Save" name="packagesave" />
			<input type="submit" value="Price" name="price" />';
	}
	elseif($_POST[$obj->btnPriceDeleteID] != null){
		while(list($i,$val) = each($_POST[$obj->btnPriceDeleteID])){
			$price_qr = new price_group();
			$price_qr->productid = $this->id;
			$price_qr->productpackageclass = $Class;
			$price_qr->o_startdate = $_POST[$obj->txtPriceOldStartDate][$i];
			$price_qr->o_name = $_POST[$obj->txtPriceOldName][$i];
			$price_qr->startdate = $_POST[$obj->txtPriceStartDate][$i];
			$price_qr->name = $_POST[$obj->txtPriceName][$i];
			$price_qr->remove();
		}
		$obj->EnablePriceDel = true;
		$obj->showPrice();
		$obj->showAddPriceForm();
		echo '<input type="submit" value="Save" name="pricesave" />
			<input type="submit" value="Return" name="pricereturn" />';
	}
	elseif($_POST['price']!=''){
		$obj->EnablePriceDel = true;
		$obj->showPrice();
		$obj->showAddPriceForm();
		echo '<input type="submit" value="Save" name="pricesave" />
			<input type="submit" value="Return" name="pricereturn" />';
		}
	elseif($_POST['packageadd']!=''){
		$pkg = new	package_group();
		$pkg->productid = $this->id;
		$pkg->class = $Class;
		$obj->showAddPackageForm();
		echo '<input type="submit" value="Save" name="packagesavenew" />
			<input type="submit" value="Return" name="pricereturn" />';
		}
	elseif($_POST['packagesavedetail']!=''){
		$pkg = new	package_group();
		$pkg->productid = $this->id;
		$pkg->class = $Class;
		if(($_POST['name']!='')&&($_POST['type']!=null)){
			$pkg->o_name = (string)$_POST['o_name'];
			$pkg->o_desc = (string)$_POST['o_desc'];
			$pkg->o_desc1 = (string)$_POST['o_desc1'];
			$pkg->o_desc2 = (string)$_POST['o_desc2'];
			$pkg->o_extra = (string)$_POST['o_extra'];
			$pkg->o_img = (string)$_POST['o_img'];
			$pkg->o_alt = (string)$_POST['o_alt'];
			$pkg->o_img1 = (string)$_POST['o_img1'];
			$pkg->o_alt1 = (string)$_POST['o_alt1'];

			$pkg->name = (string)$_POST['name'];
			$pkg->desc = (string)$_POST['desc'];
			$pkg->desc1 = (string)$_POST['desc1'];
			$pkg->desc2 = (string)$_POST['desc2'];
			$pkg->extra = (string)$_POST['extra'];
			$pkg->img = (string)$_POST['img'];
			$pkg->alt = (string)$_POST['alt'];
			$pkg->img1 = (string)$_POST['img1'];
			$pkg->alt1 = (string)$_POST['alt1'];
			while(list($i,$val) = each($_POST['type'])){
				$pkg->type .= $i.',';
				}
			$pkg->save();
			$obj->show();
			echo '<input type="submit" value="Add new" name="packageadd" />
				<input type="submit" value="Save" name="packagesave" />
				<input type="submit" value="Price" name="price" />';
			echo '<br/>da tao moi thanh cong';				
			}
		else{
			$obj->showAddNameForm();
			echo '<input type="submit" value="Save" name="packagesavenew" />
				<input type="submit" value="Return" name="pricereturn" />';
			echo '<br/>ban nhap thieu du lieu';
			}
		}
	elseif($_POST['packagesavenew']!=''){
		$pkg = new	package_group();
		$pkg->productid = $this->id;
		$pkg->class = $Class;
		if(($_POST['name']!='')&&($_POST['type']!=null)){
			$pkg->name = (string)$_POST['name'];
			$pkg->desc = (string)$_POST['desc'];
			$pkg->desc1 = (string)$_POST['desc1'];
			$pkg->desc2 = (string)$_POST['desc2'];
			$pkg->extra = (string)$_POST['extra'];
			$pkg->img = (string)$_POST['img'];
			$pkg->alt = (string)$_POST['alt'];
			$pkg->img1 = (string)$_POST['img1'];
			$pkg->alt1 = (string)$_POST['alt1'];
			while(list($i,$val) = each($_POST['type'])){
				$pkg->type .= $i.',';
				}
			$pkg->save();
			$obj->show();
			echo '<input type="submit" value="Add new" name="packageadd" />
				<input type="submit" value="Save" name="packagesave" />
				<input type="submit" value="Price" name="price" />';
			echo '<br/>da tao moi thanh cong';				
			}
		else{
			$obj->showAddNameForm();
			echo '<input type="submit" value="Save" name="packagesavenew" />
				<input type="submit" value="Return" name="pricereturn" />';
			echo '<br/>ban nhap thieu du lieu';
			}
		}
	elseif($_POST['packagesave']!=''){
		$pkg = new	package_group();
		$pkg->productid = $this->id;
		$pkg->class = $Class;
		$temp = $_POST[$Class];
		$pkg->setHideAll();
		if($temp != null)
			while(list($class,$arr) = each($temp)){
				$pkg->o_name = $class;
				$pkg->name = $class;
				$pkg->type = '';
				while(list($idx,$val) = each($arr)){
					$pkg->type .= $idx.',';
					}
				$pkg->save();
				}
		$obj->show();
		echo '<input type="submit" value="Add new" name="packageadd" />
			<input type="submit" value="Save" name="packagesave" />
			<input type="submit" value="Price" name="price" />';
		}
	elseif($_POST['pricesave']!=''){
		if(($_POST[$obj->txtPriceNewName]!='')&&($_POST[$obj->txtPriceNewStartDate]!='')){
			$price_qr = new price_group();
			$price_qr->productid = $this->id;
			$price_qr->productpackageclass = $Class;
			$price_qr->startdate = $_POST[$obj->txtPriceNewStartDate];
			$price_qr->name = $_POST[$obj->txtPriceNewName];
			while(list($i,$val) = each($_POST[$obj->txtPriceNewValue])){
				$price_qr->productpackageid .= $i.';';
				$price_qr->price .= $val.';';
				}
			$price_qr->save();
			}
		if(($_POST[$obj->txtPriceName]!=null)&&($_POST[$obj->txtPriceStartDate]!=null)){
			for($i=0;$i<count($_POST[$obj->txtPriceStartDate]);$i++){
				if(($_POST[$obj->txtPriceName][$i]!='')&&($_POST[$obj->txtPriceStartDate][$i]!='')){
					$price_qr = new price_group();
					$price_qr->productid = $this->id;
					$price_qr->productpackageclass = $Class;
					$price_qr->o_startdate = $_POST[$obj->txtPriceOldStartDate][$i];
					$price_qr->o_name = $_POST[$obj->txtPriceOldName][$i];
					$price_qr->startdate = $_POST[$obj->txtPriceStartDate][$i];
					$price_qr->name = $_POST[$obj->txtPriceName][$i];
					while(list($j,$val) = each($_POST[$obj->txtPriceValue][$i])){
						$price_qr->productpackageid .= $j.';';
						$price_qr->price .= $val.';';
						}
					$price_qr->save();
					}
				}
			}
		$obj->EnablePriceDel = true;
		$obj->showPrice();
		$obj->showAddPriceForm();
		echo '<input type="submit" value="Save" name="pricesave" />
			<input type="submit" value="Return" name="pricereturn" />';
		}
	elseif($_POST['pricereturn']!=''){
		$obj->show();
		echo '<input type="submit" value="Add new" name="packageadd" />
			<input type="submit" value="Save" name="packagesave" />
			<input type="submit" value="Price" name="price" />';
		}
	elseif($_POST['packagereturn']!=''){
		echo 'ban da thoat roi day';
		}
	else{
		$obj->show();
		echo '<input type="submit" value="Add new" name="packageadd" />
			<input type="submit" value="Save" name="packagesave" />
			<input type="submit" value="Price" name="price" />';
		}
?>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var url_rte = URL_ADMIN + 'rte.php?filename=<?php echo $this->contentfile;?>';
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
	oRte.rteToInput();
	return true;
}
</script>
<script language="javascript" src="../js/item-script.js"></script>
<script language="javascript">var oRte=(!isIE?new RTE(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE):new RTEie(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE));</script>
<?php dbclose(); ?>