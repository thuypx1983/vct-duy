<?php 
require('../nonsign.php');
class product{//Phai sua ham addrow va update bo dau phay (,) truoc field dau tien,
	//ham fetch() phai chuyen $_POST['id'] thanh $_GET['id'] va $_POST['ctrl'] thanh @array_sum($_POST['ctrl']);
	var $id,$name,$code,$include,$price,$saleprice,$ctrl,$view,$groupid,$summary,$detail,$keyword,$img1,$alt1,$img2,$alt2,$warranty,$quantity,$weight,$model,$manufacturerid,$created,$modified,$available,$taxclassid,$mincartqty,$maxcartqty,$unit,$catproductid,$attribute,$ctrl2,$type,$class,$hit,$lastread,$manufacturer,$country,$countryid,$status,$tag,$urlrewrite;
	function __construct(){}
	function fetch(){
		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->name=(string)$_POST['name'];
		$this->code=(string)$_POST['code'];
		if(is_array($_POST['a_attr'])) 
			$this->include=serialize($_POST['a_attr']);
		else 
			$this->include=(string)$_POST['include'];
		$this->saleprice=$_POST['saleprice'];
		if(is_array($_POST['a_price'])){
			foreach($_POST['a_price'] as &$value){
				if(is_array($value))
					foreach($value as &$subvalue) $subvalue=currency_unformat($subvalue);
				else
					$value = currency_unformat($value);
			}
			$this->price=serialize($_POST['a_price']);
		}else{
			$this->price=(string)$_POST['price'];
			if($this->price=='') $this->price ='';
		}
		$this->ctrl=@array_sum($_POST['ctrl']);
		$this->view=(int)$_POST['view'];
		$this->groupid=(int)$_POST['groupid'];
		$this->summary=stripslashes($_POST['summary']);
		if($_POST['rte_word_autotag'] || $_POST['rte_tag_summary']) RTE::normalizeHTML($this->summary); 
		$this->detail=stripslashes($_POST['detail']);
		if($_POST['rte_tag_detail']) RTE::normalizeHTML($this->detail); 
		$this->keyword=(string)$_POST['keyword'];
		$this->img1=(string)$_POST['img1'];
		$this->alt1=(string)$_POST['alt1'];
		$this->img2=(string)$_POST['img2'];
		$this->alt2=(string)$_POST['alt2'];
		$this->warranty=(string)$_POST['warranty'];
		$this->quantity=(int)$_POST['quantity'];
		$this->weight=(real)$_POST['weight'];
		$this->model=(string)$_POST['model'];
		$this->manufacturerid=(int)$_POST['manufacturerid'];
		$this->created=(string)$_POST['created'];
		$this->modified=(string)$_POST['modified'];
		$this->available=(string)$_POST['available'];
		$this->taxclassid=(int)$_POST['taxclassid'];
		$this->mincartqty=(int)$_POST['mincartqty'];
		$this->maxcartqty=(int)$_POST['maxcartqty'];
		$this->unit=(string)$_POST['unit'];
		$this->catproductid=(int)$_POST['catproductid'];
		$this->attribute=(int)$_POST['attribute'];
		$this->ctrl2=(int)$_POST['ctrl2'];
		$this->type=(int)$_POST['type'];
		$this->class=(int)$_POST['class'];
		$this->hit=(int)$_POST['hit'];
		$this->lastread=(string)$_POST['lastread'];
		$this->manufacturer=(string)$_POST['manufacturer'];
		$this->country=(string)$_POST['country'];
		$this->countryid=(string)$_POST['countryid'];
		$this->status=(int)$_POST['status'];
		$this->tag=(string)$_POST['tag'];
		$this->urlrewrite=(string)$_POST['urlrewrite'];
		$this->cf=&$_POST['cf'];
		if(is_array($this->cf))
			foreach($this->cf as $key=>&$value)
				if($_POST['rte_tag_cf'][$key]) RTE::normalizeHTML($value);
	}
	function addrow(){
		if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'product`(`name`,`code`,`include`,`price`,`saleprice`,`ctrl`,`view`,`groupid`,`summary`,`detail`,`keyword`,`img1`,`alt1`,`img2`,`alt2`,`warranty`,`quantity`,`weight`,`model`,`manufacturerid`,`created`,`modified`,`available`,`taxclassid`,`mincartqty`,`maxcartqty`,`unit`,`catproductid`,`attribute`,`ctrl2`,`type`,`class`,`hit`,`lastread`,`manufacturer`,`country`,`countryid`,`status`,`tag`,`urlrewrite`) VALUES ('
		."'".mysql_real_escape_string(stripslashes($this->name))."'"
		.",'".mysql_real_escape_string(stripslashes($this->code))."'"
		.",'".mysql_real_escape_string(stripslashes($this->include))."'"
		.",'".mysql_real_escape_string(stripslashes($this->price))."'"
		.",".currency_unformat($this->saleprice)
		.",'".(int)$this->ctrl."'"
		.",'".(int)$this->view."'"
		.",'".(int)$this->groupid."'"
		.",'".mysql_real_escape_string(stripslashes($this->summary))."'"
		.",'".mysql_real_escape_string(stripslashes($this->detail))."'"
		.",'".mysql_real_escape_string(stripslashes($this->keyword))."'"
		.",'".mysql_real_escape_string(stripslashes($this->img1))."'"
		.",'".mysql_real_escape_string(stripslashes($this->alt1))."'"
		.",'".mysql_real_escape_string(stripslashes($this->img2))."'"
		.",'".mysql_real_escape_string(stripslashes($this->alt2))."'"
		.",'".mysql_real_escape_string(stripslashes($this->warranty))."'"
		.",'".$this->quantity."'"
		.",".$this->weight	
		.",'".mysql_real_escape_string(stripslashes($this->model))."'"
		.",'".(int)$this->manufacturerid."'"
		.",".SQL_NOW
		.",".SQL_NOW
		.",'".mysql_format_datetime($this->available)."'"
		.",'".(int)$this->taxclassid."'"
		.",'".(int)$this->mincartqty."'"
		.",'".$this->maxcartqty."'"
		.",'".mysql_real_escape_string(stripslashes($this->unit))."'"
		.",".($this->catproductid ? (int)$this->catproductid : 'NULL')
		.",'".(int)$this->attribute."'"
		.",'".(int)$this->ctrl2."'"
		.",'".(int)$this->type."'"
		.",'".(int)$this->class."'"
		.",0"
		.",'0000-00-00'"
		.",'".mysql_real_escape_string(stripslashes($this->manufacturer))."'"
		.",'".mysql_real_escape_string(stripslashes($this->country))."'"
		.",'".mysql_real_escape_string(stripslashes($this->countryid))."'"
		.",'".(int)$this->status."'"
		.",'".mysql_real_escape_string(stripslashes($this->tag))."'"
		.",'".mysql_real_escape_string(stripslashes($this->urlrewrite))."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			if(is_array($this->cf)){
				$sql = 'UPDATE `'.DB_TABLE_PREFIX.'product` SET ';
				foreach($this->cf as $key=>&$value){
					if($value === '')
						$sql .= ' `cf'.$key.'`=NULL,';//set to null if empty string
					else
						$sql .= " `cf".$key."`='".mysql_real_escape_string(stripslashes(stripslashes($value)))."',";
				}
				$sql = rtrim($sql,',').' WHERE `ID`='.$this->id;
				_trace($sql);			
				return mysql_query($sql);
			}
			return TRUE;
		}
		_trace(mysql_error().$sql);
	}
	function updaterow(){
		if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."product` SET"
		." `Name`='".mysql_real_escape_string(stripslashes($this->name))."'"
		.",`Code`='".mysql_real_escape_string(stripslashes($this->code))."'"
		.",`Include`='".mysql_real_escape_string(stripslashes($this->include))."'"
		.",`Price`='".mysql_real_escape_string(stripslashes($this->price))."'"
		.",`Saleprice`=".currency_unformat($this->saleprice)
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`View`='".(int)$this->view."'"
		.",`GroupID`='".(int)$this->groupid."'"
		.",`Summary`='".mysql_real_escape_string(stripslashes($this->summary))."'"
		.",`Detail`='".mysql_real_escape_string(stripslashes($this->detail))."'"
		.",`KeyWord`='".mysql_real_escape_string(stripslashes($this->keyword))."'"
		.",`Img1`='".mysql_real_escape_string(stripslashes($this->img1))."'"
		.",`Alt1`='".mysql_real_escape_string(stripslashes($this->alt1))."'"
		.",`Img2`='".mysql_real_escape_string(stripslashes($this->img2))."'"
		.",`Alt2`='".mysql_real_escape_string(stripslashes($this->alt2))."'"
		.",`Warranty`='".mysql_real_escape_string(stripslashes($this->warranty))."'"
		.",`Quantity`='".$this->quantity."'"
		.",`Weight`=".$this->weight	
		.",`Model`='".mysql_real_escape_string(stripslashes($this->model))."'"
		.",`ManufacturerID`='".(int)$this->manufacturerid."'"
		.",`Modified`=".SQL_NOW
		.",`Available`='".mysql_format_datetime($this->available)."'"
		.",`TaxClassID`='".(int)$this->taxclassid."'"
		.",`MinCartQty`='".(int)$this->mincartqty."'"
		.",`MaxCartQty`='".$this->maxcartqty."'"
		.",`Unit`='".mysql_real_escape_string(stripslashes($this->unit))."'"
		.",`CatProductID`=".($this->catproductid ? (int)$this->catproductid: 'NULL')
		.",`Attribute`='".(int)$this->attribute."'"
		.",`Ctrl2`='".(int)$this->ctrl2."'"
		.",`Type`='".(int)$this->type."'"
		.",`Class`='".(int)$this->class."'"
		.",`Manufacturer`='".mysql_real_escape_string(stripslashes($this->manufacturer))."'"
		.",`Country`='".mysql_real_escape_string(stripslashes($this->country))."'"
		.",`CountryID`='".mysql_real_escape_string(stripslashes($this->countryid))."'"
		.",`Status`='".(int)$this->status."'"
		.",`Tag`='".mysql_real_escape_string(stripslashes($this->tag))."'"
		.",`Urlrewrite`='".mysql_real_escape_string(stripslashes($this->urlrewrite))."'"
		." WHERE `id` = {$this->id}";
		if(mysql_query($sql)){
			if(is_array($this->cf)){
				$sql = 'UPDATE `'.DB_TABLE_PREFIX.'product` SET ';
				foreach($this->cf as $key=>&$value){
					if($value === '')
						$sql .= " `cf".$key."`= NULL,";
					else 
						$sql .= " `cf".$key."`='".mysql_real_escape_string(stripslashes(stripslashes($value)))."',";
				}
				$sql = rtrim($sql,',').' WHERE `ID`='.$this->id;
				_trace($sql);
				return mysql_query($sql);
			}
		}		
		_trace($sql);
		return FALSE;
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `code`, `include`, `price`, `saleprice`, `ctrl`, `view`, `summary`, `detail`, `keyword`, `img1`, `alt1`, `img2`, `alt2`, `warranty`, `quantity`, `weight`, `model`, `manufacturerid`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`modified`,'".FORMAT_DB_DATETIME."') as `modified`,DATE_FORMAT(`available`,'".FORMAT_DB_DATETIME."') as `available`, `taxclassid`, `mincartqty`, `maxcartqty`, `unit`, `catproductid`, `attribute`, `ctrl2`, `type`, `class`, `hit`,DATE_FORMAT(`lastread`,'".FORMAT_DB_DATETIME."') as `lastread`, `manufacturer`, `country`, `countryid`, `status`, `tag`, `urlrewrite` FROM `".DB_TABLE_PREFIX."product` WHERE `id` = {$this->id}";
		$rs=mysql_query($sql);
		_trace(mysql_error());
		$row = mysql_fetch_assoc($rs);
		$this->name = (string)$row['name'];
		$this->code = (string)$row['code'];
		$this->include = (string)$row['include'];
		$this->price = (string)$row['price'];
		$this->saleprice = (real)$row['saleprice'];
		$this->ctrl = (int)$row['ctrl'];
		$this->view = (int)$row['view'];
		$this->groupid = (int)$row['groupid'];
		$this->summary = (string)$row['summary'];
		$this->detail = (string)$row['detail'];
		$this->keyword = (string)$row['keyword'];
		$this->img1 = (string)$row['img1'];
		$this->alt1 = (string)$row['alt1'];
		$this->img2 = (string)$row['img2'];
		$this->alt2 = (string)$row['alt2'];
		$this->warranty = (string)$row['warranty'];
		$this->quantity = $row['quantity'];
		$this->weight = $row['weight'];
		$this->model = (string)$row['model'];
		$this->manufacturerid = (int)$row['manufacturerid'];
		$this->created = (string)$row['created'];
		$this->modified = (string)$row['modified'];
		$this->available = (string)$row['available'];
		$this->taxclassid = (int)$row['taxclassid'];
		$this->mincartqty = (int)$row['mincartqty'];
		$this->maxcartqty = $row['maxcartqty'];
		$this->unit = (string)$row['unit'];
		$this->catproductid = (int)$row['catproductid'];
		$this->attribute = (int)$row['attribute'];
		$this->ctrl2 = (int)$row['ctrl2'];
		$this->type = (int)$row['type'];
		$this->class = (int)$row['class'];
		$this->hit = (int)$row['hit'];
		$this->lastread = (string)$row['lastread'];
		$this->manufacturer = (string)$row['manufacturer'];
		$this->country = (string)$row['country'];
		$this->countryid = (string)$row['countryid'];
		$this->status = (int)$row['status'];
		$this->tag = (string)$row['tag'];
		$this->urlrewrite = (string)$row['urlrewrite'];
		
		mysql_free_result($rs);
		$this->a_attr=@unserialize($this->include);
		$this->a_price=@unserialize($this->price);
		
		if(N_PRODUCT_CF > 0) $this->loadcf();
		return TRUE;
	}
	function loadrow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `code`, `include`, `price`, `saleprice`, `ctrl`, `view`, `groupid`, `summary`, `detail`, `keyword`, `img1`, `alt1`, `img2`, `alt2`, `warranty`, `quantity`, `weight`, `model`, `manufacturerid`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`modified`,'".FORMAT_DB_DATETIME."') as `modified`,DATE_FORMAT(`available`,'".FORMAT_DB_DATETIME."') as `available`, `taxclassid`, `mincartqty`, `maxcartqty`, `unit`, `catproductid`, `attribute`, `ctrl2`, `type`, `class`, `hit`,DATE_FORMAT(`lastread`,'".FORMAT_DB_DATETIME."') as `lastread`, `manufacturer`, `country`, `countryid`, `status`, `tag`, `urlrewrite` FROM `".DB_TABLE_PREFIX."product` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	function loadcf(){
		global $sql;
		_trace(__FUNCTION__);
		$sql = 'SELECT ';
		for($i=0;$i < (int)N_PRODUCT_CF;++$i)
			$sql .= '`cf'.$i.'`,';
		$sql =  rtrim($sql,',').' FROM `'.DB_TABLE_PREFIX.'product` WHERE `id`='.$this->id;
		$rs = mysql_query($sql);
		$this->cf=mysql_fetch_row($rs);
		mysql_free_result($rs);
	}
}
?>