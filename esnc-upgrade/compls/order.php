<?php
function orderpagelist(&$page,&$pagecount,$pagesize=2,$status=NULL,$minvalue=NULL, $maxvalue=NULL,$fromdate=NULL,$todate=NULL,$type=NULL,$productcode=NULL,$code=NULL){
	global $sql,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND,$session;
	$wh='`a`.`custid`='.$session->id;
	if (is_int($status)) {$wh .= " AND `a`.`status` = {$status}";} //Dunghm them vao ngay: 10/01/2007
	if (is_int($type)) {$wh .= " AND `a`.`type` = {$type}";} //Dunghm them vao ngay: 10/01/2007
	if(currency_value($minvalue)) $minvalue = " AND `a`.`value` > {$minvalue}"; else $minvalue="";
	if(currency_value($maxvalue))$maxvalue =" AND `a`.`value` <{$maxvalue}";else $maxvalue="";
	if(mysql_format_date($fromdate)!='0000-00-00')$fromdate=" AND `a`.`created` >{$fromdate}";
	if(mysql_format_date($todate)!='0000-00-00')$todate=" AND `a`.`created` <{$todate}";
	$fields = "`id`,`a`.`custid`,`a`.`code`,`a`.`seller`,`custtitle`,`a`.`custfirstname`,`a`.`custlastname`,`a`.`custcompany`,`a`.`custaddress`,`a`.`custgender`, ".
		"`custpostcode`,`a`.`custzonecode`,`a`.`custcity`,`a`.`custprovince`,`a`.`custcountryid`,`a`.`custcountry`,`a`.`custphone`,`a`.`custmobile`, ".
		"`custfax`,`a`.`custemail`,`a`.`custaddressformatid`,`a`.`shipfrom`,`a`.`shipvia`,`a`.`shipinfo`,`shiptotitle`,`a`.`shiptofirstname`,`a`.`shiptolastname`, ".
		"`shiptocompany`,`a`.`shiptoaddress`,`a`.`shiptogender`,`a`.`shiptopostcode`,`a`.`shiptozonecode`,`a`.`shiptocity`,`a`.`shiptoprovince`, ".
		"`shiptocountryid`,`a`.`shiptocountry`,`a`.`shiptophone`,`a`.`shiptomobile`,`a`.`shiptofax`,`a`.`shiptoemail`,`a`.`shiptoaddressformatid`, ".
		"`billtotitle`,`billtofirstname`,`a`.`billtolastname`,`a`.`billtocompany`,`a`.`billtoaddress`,`a`.`billtogender`,`a`.`billtopostcode`,`a`.`billtozonecode`, ".
		"`billtocity`,`a`.`billtoprovince`,`a`.`billtocountryid`,`a`.`billtocountry`,`a`.`billtophone`,`a`.`billtomobile`,`a`.`billtofax`,`a`.`billtoemail`, ".
		"`billtoaddressformatid`,`a`.`paymethod`,`a`.`payinfo`,`a`.`cardtype`,`a`.`cardowner`,`a`.`cardnumber`,DATE_FORMAT(`cardexpires`,'".FORMAT_DB_DATETIME."') as `cardexpires`, ".
		"`ccv`,`a`.`currency`,`a`.`currencyvalue`,`a`.`value`,DATE_FORMAT(`expireddate`,'".FORMAT_DB_DATE."') as `expireddate`,".
		"DATE_FORMAT(`begindate`,'".FORMAT_DB_DATE."') as `begindate`,`a`.`promotioncode`,`a`.`status`,`a`.`tax`,".
		"DATE_FORMAT(`delivereddate`,'".FORMAT_DB_DATE."') as `delivereddate`,`a`.`ip`,DATE_FORMAT(`created`,'".FORMAT_DB_DATE."') as `created`,".
		"DATE_FORMAT(`modified`,'".FORMAT_DB_DATE."') as `modified`,`a`.`ctrl`,`a`.`summary` ";
	return mysql_page_select($page,$pagecount,$pagesize,$fields,'`#order` as `a`',$wh.$minvalue.$maxvalue.$fromdate.$todate,' ORDER BY `a`.`id`');
}
function ordersetstatus($id,$status,$statusdata){
		global $ORDER_CTRL,$ORDER_STATUS,$sql,$session;
		settype($id,'int');
		settype($status,'int');
		if(isset($ORDER_CTRL[$status])){
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'order` SET `ctrl` = `ctrl` |'.$status.',`status`='.$status.' WHERE `id`='.$id.' AND `custid`='.$session->id;
		}else
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'order` SET `status`='.$status.' WHERE `id`='.$id.' AND `custid`='.$session->id;		
		mysql_query($sql);
		if(mysql_affected_rows() > 0){
			$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'orderhistory`(`userid`,`orderid`,`status`,`data`,`created`) VALUES('
				.'NULL'
				.','.$id
				.','.$status
				.",'".mysql_real_escape_string($statusdata)."'"
				.','.SQL_NOW.')';
			mysql_query($sql);
		}
	}

function orderread($id){
	$sql = "SELECT `a`.`id`,`a`.`custid`,`a`.`code`,`a`.`seller`,`a`.`custtitle`,`a`.`custfirstname`,`a`.`custlastname`,`a`.`custcompany`,`a`.`custaddress`,`a`.`custgender`, ".
		"`custpostcode`,`a`.`custzonecode`,`a`.`custcity`,`a`.`custprovince`,`a`.`custcountryid`,`a`.`custcountry`,`a`.`custphone`,`a`.`custmobile`, ".
		"`custfax`,`a`.`custemail`,`a`.`custaddressformatid`,`a`.`shipfrom`,`a`.`shipvia`,`a`.`shipinfo`,`a`.`shiptotitle`,`a`.`shiptofirstname`,`a`.`shiptolastname`, ".
		"`shiptocompany`,`a`.`shiptoaddress`,`a`.`shiptogender`,`a`.`shiptopostcode`,`a`.`shiptozonecode`,`a`.`shiptocity`,`a`.`shiptoprovince`, ".
		"`shiptocountryid`,`a`.`shiptocountry`,`a`.`shiptophone`,`a`.`shiptomobile`,`a`.`shiptofax`,`a`.`shiptoemail`,`a`.`shiptoaddressformatid`, ".
		"`billtotitle`,`billtofirstname`,`a`.`billtolastname`,`a`.`billtocompany`,`a`.`billtoaddress`,`a`.`billtogender`,`a`.`billtopostcode`,`a`.`billtozonecode`, ".
		"`billtocity`,`a`.`billtoprovince`,`a`.`billtocountryid`,`a`.`billtocountry`,`a`.`billtophone`,`a`.`billtomobile`,`a`.`billtofax`,`a`.`billtoemail`, ".
		"`billtoaddressformatid`,`a`.`paymethod`,`a`.`payinfo`,`a`.`cardtype`,`a`.`cardowner`,`a`.`cardnumber`,DATE_FORMAT(`cardexpires`,'".FORMAT_DB_DATETIME."') as `cardexpires`, ".
		"`ccv`,`a`.`currency`,`a`.`currencyvalue`,`a`.`value`,DATE_FORMAT(`expireddate`,'".FORMAT_DB_DATE."') as `expireddate`,".
		"DATE_FORMAT(`begindate`,'".FORMAT_DB_DATE."') as `begindate`,`a`.`promotioncode`,`a`.`status`,`a`.`tax`,".
		"DATE_FORMAT(`delivereddate`,'".FORMAT_DB_DATE."') as `delivereddate`,`a`.`ip`,DATE_FORMAT(`created`,'".FORMAT_DB_DATE."') as `created`,".
		"DATE_FORMAT(`modified`,'".FORMAT_DB_DATE."') as `modified`,`a`.`ctrl`,`a`.`summary` FROM `".DB_TABLE_PREFIX."order` as `a` WHERE `a`.`id`=".(int)$id;
	$o = mysql_fetch_object($rs=mysql_query ($sql));
	mysql_free_result($rs);
	$sql = 'SELECT  `a`.`orderid` ,`a`.`ordercode` ,`a`.`productid`,`a`.`name`,`a`.`class`,`a`.`code`,`a`.`parentid`,`a`.`qty`,`a`.`qty2`,`a`.`qty3`,`a`.`qty4`,`a`.`saleprice`,`a`.`finalprice`,`a`.`tax`,`a`.`start`,`a`.`stop`,`a`.`notes`,`a`.`subtotal`,`a`.`onetimecharge`,`a`.`productctrl`,`a`.`promotiontype`,`a`.`promotionfrom` FROM `'.DB_TABLE_PREFIX.'orderdetail` as `a` WHERE `a`.`orderid`='.(int)$id;	

	$o->rsdetail=mysql_query($sql);
	return $o;
}
function orderdetail($id){
	$sql = 'SELECT  `a`.`orderid` ,`a`.`ordercode` ,`a`.`productid`,`a`.`name`,`a`.`class`,`a`.`code`,`a`.`parentid`,`a`.`qty`,`a`.`qty2`,`a`.`qty3`,`a`.`qty4`,`a`.`saleprice`,`a`.`finalprice`,`a`.`tax`,`a`.`start`,`a`.`stop`,`a`.`notes`,`a`.`subtotal`,`a`.`onetimecharge`,`a`.`productctrl`,`a`.`promotiontype`,`a`.`promotionfrom` FROM `'.DB_TABLE_PREFIX.'orderdetail` as `a` WHERE `a`.`orderid`='.(int)$id;	
	$o = mysql_fetch_object($rs=mysql_query ($sql));
	return $o;
}
function orderopen($id){
	$sql='SELECT `id`,`name`,`code` FROM `'.DB_TABLE_PREFIX.'order` WHERE `id` = '.(int)$id;
	$o = mysql_fetch_object($rs=mysql_query ($sql));
	mysql_free_result($rs);
	return $o;
}
?>