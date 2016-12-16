<?php 
/* LAY NHOM SAN PHAM*/

//Lay nhom san pham luu thanh mang tuong ung ID=>NAME
// Khi rewrite se hien thi ten cua nhom co Id tuong ung.
function setArrCatproduct(){
	global $sql;
	$sql = 'SELECT `id`,`name`,`urlrewrite` FROM `'.DB_TABLE_PREFIX.'catproduct`';
	$rs = mysql_query($sql);
	while($row = mysql_fetch_assoc($rs)){	
		if($row['urlrewrite'] != ''){
			$catproduct[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['urlrewrite']);
		}else{
			$catproduct[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['name']);	
		}
	}
	mysql_free_result($rs);
	return $catproduct;
}
// Ham tra ve ID cua nhom san pham de truy van.
function getCatproductId(){	
	if((int)URL_CTRL == 4){
		$catproduct = setArrCatproduct();
		if(isset($_REQUEST['CPname'])){		
			$name = (string)$_REQUEST['CPname'];
			foreach($catproduct as $id=>$value){
				if($name == $value){				
					$CPid = $id;				
				}	
			}
		}		
	}else{
		@$CPid=(int)$_GET['CPid'];	
	}
	return (int)$CPid;
}

/* LAY DANH SACH SAN PHAM*/

// Lay tat ca san pham dua vao mang khong phan biet kieu san pham
function setArrProduct(){
	global $sql;
	$sql = 'SELECT `id`,`name`,`urlrewrite` FROM `'.DB_TABLE_PREFIX.'product`';
	$rs = mysql_query($sql);
	while($row = mysql_fetch_assoc($rs)){
		if($row['urlrewrite'] != ''){
			$product[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['urlrewrite']);		
		}else{
			$product[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['name']);
		}
	}
	mysql_free_result($rs);
	return $product;
}
// Ham tra ve ID cua san pham
function getProductId(){
	if((int)URL_CTRL == 4){
		$product = setArrProduct();
		if(isset($_REQUEST['PDname'])){		
			$name = (string)$_REQUEST['PDname'];	
			foreach($product as $id=>$value){
				if($name == $value){				
					$PDid = $id;				
				}	
			}
		}
	}else{
		$PDid=(int)$_GET['PDid'];
	}
	return (int)$PDid;
}

/* LAY NHOM TIN TUC */

/* lay ID va Ten cua nhom tin dua vao mang*/
function setArrCatnews(){	
	global $sql;
	$sql = 'SELECT `id`,`name`,`urlrewrite` FROM `'.DB_TABLE_PREFIX.'catnews`';
	$rs = mysql_query($sql);
	while($row = mysql_fetch_assoc($rs)){	
		if($row['urlrewrite'] != ''){
			$catnews[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['urlrewrite']);	
		}else{
			$catnews[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['name']);	
		}		
	}
	mysql_free_result($rs);
	return $catnews;
}
// Ham tra ve ID cua nhom de thuc hien truy van.
function getCatnewsId(){
	if((int)URL_CTRL == 4){
		$catnews = setArrCatnews();
		if(isset($_REQUEST['CNname'])){		
			$name = (string)$_REQUEST['CNname'];	
			foreach($catnews as $id=>$value){
				if($name == $value){				
					$CNid = $id;				
				}	
			}
		}
	}else{
		$CNid = $_GET['CNid'];
	}
	return (int)$CNid;
}

/* LAY DANH SACH TIN TUC*/

// Lay tin, bai viet thanh mang tham chieu.
function setArrNews(){
	global $sql;
	$sql = 'SELECT `id`,`name`,`urlrewrite` FROM `'.DB_TABLE_PREFIX.'news`';
	_trace($sql);
	$rs = mysql_query($sql);
	while($row = mysql_fetch_assoc($rs)){	
		if($row['urlrewrite'] != ''){
			$news[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['urlrewrite']);		
		}else{
			$news[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['name']);
		}	
	}
	mysql_free_result($rs);
	return $news;
}
// Ham tra ve ID cua tin de thuc hien truy van
function getNewsId(){
	if((int)URL_CTRL == 4){
		$news = setArrNews();
		if(isset($_REQUEST['NWname'])){		
			$name = (string)$_REQUEST['NWname'];	
			foreach($news as $id=>$value){
				if($name == $value){				
					$NWid = $id;				
				}	
			}
		}
	}else{
		$NWid = $_GET['NWid'];
	}
	return (int)$NWid;
}

/* LAY DANH SACH NHOM BANNER */

// Tra ve mang chua ID va NAME cua nhom banner
function setArrCatbanner(){
	global $sql;
	$sql = 'SELECT `id`,`name` FROM `'.DB_TABLE_PREFIX.'catbanner`';
	$rs = mysql_query($sql);
	while($row = mysql_fetch_assoc($rs)){	
		$catbanner[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['name']);	
	}
	mysql_free_result($rs);
	return $catbanner;
}
// Ham tra ve ID cua nhom banner
function getCatbannerId(){
	if((int)URL_CTRL == 4){
		$catbanner = setArrCatbanner();
		if(isset($_REQUEST['CBname'])){		
			$name = (string)$_REQUEST['CBname'];	
			foreach($catbanner as $id=>$value){
				if($name == $value){				
					$CBid = $id;					
				}	
			}
		}
	}else{
		$CBid = $_GET['CBid'];
	}
	return (int)$CBid;
}
/* LAY DANH SACH CO SO, DAI LY.*/
function setArrAgent(){
	global $sql;
	$sql = 'SELECT `id`,`name`,`urlrewrite` FROM `'.DB_TABLE_PREFIX.'agent`';
	$rs = mysql_query($sql);
	while($row = mysql_fetch_assoc($rs)){	
		if($row['urlrewrite'] != ''){
			$agent[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['urlrewrite']);	
		}else{
			$agent[$row['id']] = preg_replace('/\_|\-|\/|\W+/',URL_DELIMETER,$row['name']);	
		}		
	}
	mysql_free_result($rs);
	return $agent;
}
// Ham tra ve ID cua nhom banner
function getAgentId(){
	if((int)URL_CTRL == 4){
		$agent = setArrAgent();
		if(isset($_REQUEST['AGname'])){		
			$name = (string)$_REQUEST['AGname'];	
			foreach($agent as $id=>$value){
				if($name == $value){				
					$AGid = $id;				
				}	
			}
		}
	}else{
		$Agid = $_GET['AGid'];
	}
	return (int)$AGid;
}

//mang tu dinh nghia
$arr = array(
	1=>'term and condition',
	2=>'Privacy Policy',
	3=>'Payment Refund'
);
?>