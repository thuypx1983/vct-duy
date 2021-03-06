<?php 
require (PATH_ROOT.'config_price.php');
global $PRODUCT_PACKAGE_CLASS;
global $PRODUCT_PACKAGE_TYPE_ALIAS;
	$Class = 'HotelRoom';
	$temp = $PRODUCT_PACKAGE_CLASS[$this->type];	
	while(list($i,$val) = each($temp ))	if($val==$Class)$TypeAlias = $PRODUCT_PACKAGE_TYPE_ALIAS[$this->type][$i];
	$obj = new PackageView();
	$obj->ID = $Class;
	$obj->load($this->id,$Class);
	$obj->ArrayPackageTypesAlias = $TypeAlias;
	$obj->EnablePackageEdit = true;
	//$obj->EnablePackageSave= true;
	$obj->EnablePackageDel = true;

	if($_POST[$obj->btnPackageDeleteID] != null){
		echo '<form method="post">';
		while(list($key,$val) = each($_POST[$obj->btnPackageDeleteID])){
			$pkg = new	package_group();
			$pkg->productid = $this->id;
			$pkg->class = $Class;
			$pkg->o_name = $key;
			$pkg->name = $key;
			$pkg->remove();
		}
		$obj->show();
		echo '<input type="submit" class="button" value="Add new" name="packageadd" />
			<input type="submit" class="button" value="Save" name="packagesave" />
			<input type="submit" class="button" value="Price" name="price" />
			<!--input type="submit" class="button" value="Return" name="packagereturn" /-->';
		echo '</form>';
	}elseif($_POST[$obj->btnPackageEditID] != null){		
		//form edit
		include(PATH_ADMIN_PRICEFORM.'item-price-edit.php');
						
	}elseif($_POST[$obj->btnPackageSaveID] != null){
		echo '<form method="post">';
		while(list($key,$val) = each($_POST[$obj->btnPackageDeleteID])){
			$pkg = new	package_group();
			$pkg->productid = $this->id;
			$pkg->class = $Class;
			$pkg->o_name = $key;
			$pkg->name = $key;
		}
		$obj->show();
		echo '<input type="submit" class="button" value="Add new" name="packageadd" />
			<input type="submit" class="button" value="Save" name="packagesave" />
			<input type="submit" class="button" value="Price" name="price" />
			<!--input type="submit" class="button" value="Return" name="packagereturn" /-->';
		echo '</form>';
	}elseif($_POST[$obj->btnPriceDeleteID] != null){
		echo '<form method="post">';
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
		echo '<input type="submit" class="button" value="Save" name="pricesave" />
			<input type="submit" class="button" value="Return" name="pricereturn" />';
		echo '</form>';
	}elseif($_POST['price']!=''){
		echo '<form method="post">';
		$obj->EnablePriceDel = true;
		$obj->showPrice();
		$obj->showAddPriceForm();
		echo '<input type="submit" class="button" value="Save" name="pricesave" />
			<input type="submit" class="button" value="Return" name="pricereturn" />';
		echo '</form>';
	}elseif($_POST['packageadd']!=''){
	//form add
		include(PATH_ADMIN_PRICEFORM.'item-price-add.php');		
	}elseif($_POST['packagesavedetail']!=''){
		echo '<form method="post">';
		$pkg = new	package_group();
		$pkg->productid = $this->id;
		$pkg->class = $Class;	
		if(($_POST['o_name']!='')&&($_POST['type']!=null)){
			$pkg->name = (string)$_POST['o_name'];
			$pkg->desc = (string)$_POST['o_desc'];
			$pkg->detail = (string)$_POST['o_detail'];
			$pkg->img = (string)$_POST['o_img'];
			$pkg->alt = (string)$_POST['o_alt'];
			$pkg->img1 = (string)$_POST['o_img1'];
			$pkg->alt1 = (string)$_POST['o_alt1'];
			while(list($i,$val) = each($_POST['type'])){
				$pkg->type .= $i.',';
			}
			if($_POST['l_type']!=NULL){
				while(list($index,$value) = each($_POST['l_type'])){
					$pkg->l_type .= $value.',';
				}				
			}
			$pkg->save();
			$pkg->addcomfort();	
			$obj->show();
			echo '<input type="submit" class="button" value="Add new" name="packageadd" />
				<input type="submit" class="button" value="Save" name="packagesave" />
				<input type="submit" class="button" value="Price" name="price" />
				<!--input type="submit" class="button" value="Return" name="packagereturn" /-->';
			echo '<br/>Thay doi thanh cong';		
			echo '</form>';		
		}else{
			$obj->showAddNameForm();
			echo '<input type="submit" class="button" value="Save" name="packagesavenew" />
				<input type="submit" class="button" value="Return" name="pricereturn" />';
			echo '<br/>ban nhap thieu du lieu';
			echo '</form>';
		}
	}elseif($_POST['packagesavenew']!=''){
		echo '<form method="post">';		
		$pkg = new	package_group();
		$pkg->productid = $this->id;
		$pkg->class = $Class;
		$l_type = '';
		if(($_POST['name']!='')&&($_POST['type']!=null)){
			$pkg->name = (string)$_POST['name'];
			$pkg->desc = (string)$_POST['desc'];
			$pkg->detail = (string)$_POST['detail'];
			$pkg->img = (string)$_POST['img'];
			$pkg->alt = (string)$_POST['alt'];
			$pkg->img1 = (string)$_POST['img1'];
			$pkg->alt1 = (string)$_POST['alt1'];
			while(list($i,$val) = each($_POST['type'])){
				$pkg->type .= $i.',';
			}
			while(list($index,$value) = each($_POST['l_type'])){
				$pkg->l_type .= $value.',';
			}						
			$pkg->save();
			$pkg->addcomfort();						
			$obj->show();
			echo '<input type="submit" class="button" value="Add new" name="packageadd" />
				<input type="submit" class="button" value="Save" name="packagesave" />
				<input type="submit" class="button" value="Price" name="price" />
				<!--input type="submit" class="button" value="Return" name="packagereturn" /-->';
			echo '<br/>Tao moi thanh cong';				
		echo '</form>';
		}else{
			/*echo '<form method="post">';
			$obj->showAddNameForm();
			echo '<input type="submit" class="button" value="Save" name="packagesavenew" />
				<input type="submit" class="button" value="Return" name="pricereturn" />';
			echo '<br/>ban nhap thieu du lieu';
			echo '</form>';	*/
			include(PATH_ADMIN_PRICEFORM.'item-price-add.php');
		}
	}elseif($_POST['packagesave']!=''){
		echo '<form method="post">';		
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
		echo '<input type="submit" class="button" value="Add new" name="packageadd" />
			<input type="submit" class="button" value="Save" name="packagesave" />
			<input type="submit" class="button" value="Price" name="price" />
			<!--input type="submit" class="button" value="Return" name="packagereturn" /-->';
		echo '</form>';
	}elseif($_POST['pricesave']!=''){
		echo '<form method="post">';
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
		echo '<input type="submit" class="button" value="Save" name="pricesave" />
			<input type="submit" class="button" value="Return" name="pricereturn" />';
		echo '</form>';
	}elseif($_POST['pricereturn']!=''){		
		echo '<form method="post">';
		$obj->show();
		echo '<input type="submit" class="button" value="Add new" name="packageadd" />
			<input type="submit" class="button" value="Save" name="packagesave" />
			<input type="submit" class="button" value="Price" name="price" />
			<!--input type="submit" class="button" value="Return" name="packagereturn" /-->';
		echo '</form>';
	}elseif($_POST['packagereturn']!=''){
		echo 'ban da thoat roi day';
	}else{		
		include(PATH_ADMIN_PRICEFORM.'item-price-list.php');
	}
?>