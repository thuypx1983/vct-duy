<?php //tienpd@esnadvanced.com 
//modify ngocdq@esnadvanced.com
//ham lay ngay thang cua 1 package khi biet id cua package do
//neu nhu co bang gia trong thang thi no se lay thay bang do, con neu nhu ko co bang cua thang no se lay bang cua thang truoc do gan nhat
function getPackageDate($PDid,$PGid){
	$sql = 'select `StartDate`, MONTH(StartDate)-MONTH(now()) as `date` from `'.DB_TABLE_PREFIX.'quotation` where `ProductPackageID`='.$PGid.' AND `ProductID`='.$PDid.' group by `StartDate`';
	_trace($sql);
	$rs = mysql_query($sql);
	$arr = array();
	while($row = mysql_fetch_assoc($rs)){
		if($row['date'] == 0){
			return $row['StartDate'];
		}elseif($row['date'] < 0){
			array_push($arr,$row['date'],$row['StartDate']);			
		}
	}		
	$arr = max($arr);
	return $arr;
}
	

function price_load_markers($PDid=-1,$PGClass='',$PGid=-1,$isASC=true){
	global $sql;
	if(!is_int($PDid)) return FALSE;
	if($PDid < 0)return FALSE;
	$wh = "WHERE `{0}`.`productid` = {$PDid} ";
	if ($PGClass != '') {$wh .= "AND `{0}`.`productpackageclass` = '{$PGClass}' ";}
	if ((is_int($PGid))&&($PGid >= 0)) {$wh .= "AND `{0}`.`productpackageid` = {$PGid} ";} 
	if($isASC==true)
		$sql ="SELECT DISTINCT `{0}`.`name`,DATE_FORMAT(`{0}`.`startdate`,'".FORMAT_DB_DATETIME."') as `startdate` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ORDER BY `{0}`.`startdate` asc";
	else
		$sql ="SELECT DISTINCT `{0}`.`name`,DATE_FORMAT(`{0}`.`startdate`,'".FORMAT_DB_DATETIME."') as `startdate` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ORDER BY `{0}`.`startdate` desc";
	$sql = str_replace('{0}','quotation',$sql);
	return mysql_query($sql);
}

function price_load_arr_markdates($PDid=-1,$PGClass='',$PGid=-1,$isASC=true){
	global $sql;
	if(!is_int($PDid)) return FALSE;
	if($PDid < 0)return FALSE;
	$wh = "WHERE `{0}`.`productid` = {$PDid} ";
	if ($PGClass != '') {$wh .= "AND `{0}`.`productpackageclass` = '{$PGClass}' ";}
	if ((is_int($PGid))&&($PGid >= 0)) {$wh .= "AND `{0}`.`productpackageid` = {$PGid} ";} 
	if($isASC==true)$sql ="SELECT DISTINCT `{0}`.`name`,DATE_FORMAT(`{0}`.`startdate`,'".FORMAT_DB_DATETIME."') as `startdate` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ORDER BY `{0}`.`startdate` asc";
	else $sql ="SELECT DISTINCT `{0}`.`name`,DATE_FORMAT(`{0}`.`startdate`,'".FORMAT_DB_DATETIME."') as `startdate` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ORDER BY `{0}`.`startdate` desc";
	$sql = str_replace('{0}','quotation',$sql);	
	$rs = mysql_query($sql);
	$times = array();
	while($times[] = mysql_fetch_assoc($rs));
	array_pop($times);
	return $times;
}
function price_load($PDid=-1,$PGClass='',$PGid=-1,$startdate,$ctrl=-1){
	global $sql;
	if(!is_int($PDid)) return 0;
	if($PDid < 0)return 0;
	if(!is_int($PGid)) return 0;
	if($PGid < 0)return 0;
	if($PGClass == '')return 0;
	if ($startdate == null) $startdate = mysql_format_datetime(date(FORMAT_DB_DATETIME));
	//$startdate = price_load_arr_markdates($PDid,$PGClass,$PGid,true);
	if(count($startdate)<=0)return 0;
	$wh = "WHERE `{0}`.`productid` = {$PDid} ";
	$wh .= "AND `{0}`.`productpackageclass` = '{$PGClass}' ";
	$wh .= "AND `{0}`.`productpackageid` = {$PGid} ";
	$wh .= "AND `{0}`.`startdate` = '{$startdate}' ";
	if ((is_int($ctrl))&&($ctrl >= 0)) {$wh .= "AND `{0}`.`ctrl` = {$ctrl} ";}
	$sql ="SELECT `{0}`.`price` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ";
	$sql = str_replace('{0}','quotation',$sql);	
	$row = mysql_fetch_row(mysql_query($sql));
	if($row){
		return $row[0];
	}else return 0;
}
function package_filter($tb_Alias='PdPk',$filter_fields='',$PDid=-1,$PGClass='',$name='',$type=-1,$code='',$desc='',$rank=-1,$status=-1,$ctrl=-1,$top=-1,$sort=''){
	global $sql;
	if(!is_int($PDid)) return FALSE;
	$wh = '';
	if	($PDid >= 0){
		if	($filter_fields == '') $filter_fields = '`{0}`.`id`,`{0}`.`productid`,`{0}`.`class`,`{0}`.`name`,`{0}`.`code`,`{0}`.`desc`,`{0}`.`extra`,`{0}`.`img`,`{0}`.`alt`,`{0}`.`img1`,`{0}`.`alt1`,`{0}`.`rank`,`{0}`.`rate`,`{0}`.`ratecount`,`{0}`.`packageno`,`{0}`.`type`,`{0}`.`status`,`{0}`.`ctrl`,`{0}`.`view`';
		else $filter_fields = '`{0}`.`productid`,`{0}`.`class`,'.$filter_fields;
		$wh .= "AND `{0}`.`productid` = {$PDid} ";	
	}
	else{
		if ($filter_fields == '') $filter_fields = '`{0}`.`id`,`{0}`.`productid`,`{0}`.`class`,`{0}`.`name`,`{0}`.`code`,`{0}`.`desc`,`{0}`.`extra`,`{0}`.`img`,`{0}`.`alt`,`{0}`.`img1`,`{0}`.`alt1`,`{0}`.`rank`,`{0}`.`rate`,`{0}`.`ratecount`,`{0}`.`packageno`,`{0}`.`type`,`{0}`.`status`,`{0}`.`ctrl`,`{0}`.`view`';
		else $filter_fields = '`{0}`.`class`,'.$filter_fields;
	}
	if	($PGClass != '') {$wh .= "AND `{0}`.`class` = '{$PGClass}' ";}
	if	($name != '') {$wh .= "AND `{0}`.`name` = '{$name}' ";}
	if	((is_int($type))&&($type >= 0)) {$wh .= "AND `{0}`.`type` = {$type} ";} 
	if	($code != '') {$wh .= "AND `{0}`.`code` = '{$code}' ";}
	if	($desc != '') {$wh .= "AND `{0}`.`desc` = '{$desc}' ";}
	if	((is_int($rank))&&($rank >= 0)) {$wh .= "AND `{0}`.`rank` = {$rank} ";} 
	if	((is_int($status))&&($status >= 0)) {$wh .= "AND `{0}`.`status` = {$status} ";} 
	if	((is_int($ctrl))&&($ctrl >= 0)) {$wh .= "AND `{0}`.`ctrl` & {$ctrl} = {$ctrl} ";}
	if	($wh!='')$wh = 'WHERE '.substr($wh,4);
	if	($top <= 0)$sql =  'SELECT DISTINCT '.$filter_fields." FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ";
	else $sql =  'SELECT DISTINCT '.$filter_fields." FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} LIMIT {$top} ";
	if	($tb_Alias!=''){
		$sql = str_replace($tb_Alias,'{0}',$sql);
		$sql = str_replace('{0}','productpackage',$sql);
	}
	_trace($sql);
//	echo $sql.'<br/>';
	return mysql_query($sql);
}

function showPackageTable($PDid,$PGClass,$arr_TypeAlias,$currencyType=0,$EnableBookAll=true,$go='',$CssClass=''){
	if($PDid < 0) return false;
	if($PGClass == '') return false;
	if($arr_TypeAlias == null )$arr_TypeAlias = array(0,1,2,3,4,5,6,7,8,9);	
	$StartDate = array();
	$StartDate = price_load_arr_markdates($PDid,$PGClass,-1,true);
	if(count($StartDate)<=0) return 'Hien tai chua co bang gia';
	$arr_AllType = array();
	$AllType = package_filter('PdPk','`PdPk`.`type`',$PDid,$PGClass,'',-1,'','',-1,-1,-1,-1,'');
	while($row = mysql_fetch_assoc($AllType)) $arr_AllType[] = $row['type'];
	$arr_AllName = array();
	$AllName = package_filter('PdPk','`PdPk`.`name`',$PDid,$PGClass,'',-1,'','',-1,-1,-1,-1,'');
	while($row = mysql_fetch_assoc($AllName)) $arr_AllName[] = $row['name'];
	for($i=0;$i<count($StartDate);$i++){	
	echo '<div class="detail_hotel_month_price">'.T_TABLE_PRICE.''.$StartDate[$i]['name'].'</div>';
	echo '<table class="'.$CssClass.'">';	
		echo '<tr><td class="title_detail_hotel_1"><strong>'.@T_PACKAGE.'</strong></td>';
		for($j=0;$j<count($arr_AllType);$j++) echo '<td class="title_detail_hotel_'.($j+2).'"><strong>'.$arr_TypeAlias[$arr_AllType[$j]].'</strong></td>';
		if($EnableBookAll==true)echo '<td></td>';
		echo '</tr>';
		$id=-1;
		for($j=0;$j<count($arr_AllName);$j++){
			echo '<tr><td class="title_detail_hotel_6">'.$arr_AllName[$j].'</td>';
			for($k=0;$k<count($arr_AllType);$k++){
				echo '<td class="title_detail_hotel_7">';
				$list = package_filter('PdPk','',$PDid,$PGClass,$arr_AllName[$j],$k,'','',-1,-1,-1,-1,'');
				while($tmp = mysql_fetch_assoc($list)){
					if($go==''){
						echo currency_format(price_load($PDid,$PGClass,(int)$tmp['id'],$StartDate[$i]['startdate']),$currencyType);
					}else{
						echo '<a href="'.$go.'act=add&PDqty=1&PDid='.$PDid.'&PGClass='.$PGClass.'&PGid='.$tmp['id'].'&typeht='.$arr_AllName[$j].'&styleht='.$arr_AllType[$k].'&date='.$StartDate[$i]['startdate'].'" class="detail_hotel_price">'.currency_format(price_load($PDid,$PGClass,(int)$tmp['id'],mysql_format_datetime($StartDate[$i]['startdate'])),$currencyType).'</a>';
					}
					$id = $tmp['id'];
				}
				echo '</td>';
			}
			if($EnableBookAll==true)echo '<td class="bookall"><a href="'.$go.'?PDid='.$PDid.'&PGClass='.$PGClass.'&PGid='.$id.'&date='.$StartDate[$i]['startdate'].'">'.@T_BOOKING.'</a></td>';
			echo '</tr>';
		}
	echo '</table>';
	}
	
}
//ham lay gia nho nhat minPrice()
//$PGClass = "HotelRoom","TourPackage"..
//$FieldAlias la bi danh cho truong min lay ra VD:"min" hoac "minprice"...
function minPrice($PDid,$PGClass,$FieldAlias=NULL){
	if($FieldAlias != NULL){
		$sql='SELECT MIN(price) as `'.$FieldAlias.'` FROM `'.DB_TABLE_PREFIX.'quotation` WHERE `productid`='.(int)$PDid.' AND `Productpackageclass`="'.$PGClass.'" AND `Price` != 0';
		$rs = mysql_query($sql);
		while($row = mysql_fetch_assoc($rs));
		return $row[$FieldAlias];
	}else{
		$sql='SELECT MIN(price) as `min` FROM `'.DB_TABLE_PREFIX.'quotation` WHERE `productid`='.(int)$PDid.' AND `Productpackageclass`="'.$PGClass.'" AND `Price` != 0';
		$rs = mysql_query($sql);
		$row = mysql_fetch_assoc($rs);
		return $row['min'];
	}	
}
//lay lay gia tri lon nhat
function maxPrice($PDid,$PGClass,$FieldAlias=NULL){
	if($FieldAlias != NULL){
		$sql='SELECT MAX(price) as `'.$FieldAlias.'` FROM `'.DB_TABLE_PREFIX.'quotation` WHERE `productid`='.(int)$PDid.' AND `Productpackageclass`="'.$PGClass.'"';
		$rs = mysql_query($sql);
		while($row = mysql_fetch_assoc($rs));
		return $row[$FieldAlias];
	}else{
		$sql='SELECT MAX(price) as `max` FROM `'.DB_TABLE_PREFIX.'quotation` WHERE `productid`='.(int)$PDid.' AND `Productpackageclass`="'.$PGClass.'"';
		$rs = mysql_query($sql);
		$row = mysql_fetch_assoc($rs);
		return $row['max'];
	}	
}

//lay ten cac goi co trong du lieu theo cac loai khac nhau
//ham chi lay ten vi dung ham distinct
//them CPid vao de phan biet cac nhom khac nhau nhung co chung loai san pham VD nhu ve tau va ve may bay
function getClassName($PGClass,$CPid=NULL){
	if($CPid==NULL){
		$sql = 'SELECT DISTINCT `Name` as `name` FROM `'.DB_TABLE_PREFIX.'productpackage` WHERE `class`="'.$PGClass.'"';
		_trace($sql);
		return mysql_query($sql);
	}else{
		$sql='SELECT DISTINCT `pk`.`Name` AS `name` FROM `'.DB_TABLE_PREFIX.'productpackage` as `pk` INNER join `'.DB_TABLE_PREFIX.'product` as `p` on `pk`.`productid`=`p`.`id` left join `'.DB_TABLE_PREFIX.'catproductproduct` as `cpp` on `p`.id=`cpp`.`productid` where `cpp`.`catproductid`='.(int)$CPid.' AND `pk`.`Class`="'.$PGClass.'"';
		_trace($sql);
		return mysql_query($sql);
	}
}
?>
