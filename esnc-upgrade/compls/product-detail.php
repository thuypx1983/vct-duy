<?php
$urlrewr='';
if(isset($_GET['url'])) $urlrewr=$_GET['url'];
function reviewList($pid=null,$top=null,$ctrl=1,$wh=''){
	_trace(__FUNCTION__);
	global $sql,$ESNC_ROWCOUNT;
	$sql = 'SELECT DISTINCT SQL_CALC_FOUND_ROWS `a`.`id`,`a`.`custName`,`a`.`content`,`a`.`productID` FROM `'.DB_TABLE_PREFIX.'review` as `a` WHERE ';
	if($pid) $sql .= " `a`.`productID`='{$pid}'";
	else $sql .= " `a`.`productID` > 0";
	$sql .= ' AND `a`.`ctrl` & '.$ctrl.'='.$ctrl;
	if($wh) $sql .= ' AND ('.$wh.')';
	$sql .= ' ORDER BY `id` DESC';
	if($top) $sql .= ' LIMIT '.$top;
	_trace($sql);
	$rs = mysql_query($sql);
	$sql = 'SELECT FOUND_ROWS()';
	$rs1 = mysql_query($sql);
	$row = mysql_fetch_row($rs1);
	mysql_free_result($rs1);
	$ESNC_ROWCOUNT=(int)$row[0];
	return $rs;
}
function reviewRead($id){
	_trace(__FUNCTION__);
	global $sql;
	$sql = 'SELECT DISTINCT `a`.`custName`,`a`.`email`,`a`.`summary`,`a`.`content`,DATE_FORMAT(`a`.`created`,\''.FORMAT_DB_DATETIME.'\') as `created`,`a`.`ctrl` FROM `'.DB_TABLE_PREFIX.'review` as `a` WHERE `a`.`ID`='.$id;
	_trace($sql);
	$rs = mysql_query($sql);
	$row = mysql_fetch_object($rs);
	mysql_free_result($rs);
	return $row;
}
function reviewAdd(&$o,$pid){
	_trace(__FUNCTION__);
	if(@$o->custname == '' || @$o->content == '' || $pid <= 0) return FALSE;
	$o->custname=strleft($o->custname,50,'');
	$o->summary=strleft($o->summary,250,'');
	$o->content=strip_tags(@$o->content);
	global $sql;
	$sql = 'SELECT `id` FROM `'.DB_TABLE_PREFIX.'review` WHERE `productid` IS NULL ORDER BY `id` ASC LIMIT 1';//try to find deleted item
	//echo $sql;
	$rs = mysql_query($sql);
	if($row=mysql_fetch_row($rs)){
		mysql_free_result($rs);
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'review` SET '
		."`custName`='".mysql_real_escape_string(stripslashes($o->custname))."'"
		.",`email`=".(@$o->email ? "'".mysql_real_escape_string($o->email)."'":'NULL')
		.",`summary`='".mysql_real_escape_string(stripslashes($o->summary))."'"
		.",`content`=".(@$o->content ? "'".mysql_real_escape_string(stripslashes($o->content))."'":'NULL')
		.",`rate`=".(@$o->rate ? (int)$o->rate:'NULL')
		.",`created`=".SQL_NOW
		.",`productid`=".(int)$pid
		.",`ctrl`=0"
		.",`extra`=".(@$o->extra ? "'".mysql_real_escape_string($o->extra)."'":'NULL')
		." WHERE `id`=".(int)$row[0];
		_trace($sql);
//		echo $sql.'<br />';
		return mysql_query($sql);
	}
	$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'review`(`custName`,`email`,`summary`,`content`,`rate`,`productID`,`created`,`extra`) VALUES ('
	."'".mysql_real_escape_string($o->custname)."'"
	.(@$o->email ? ",'".mysql_real_escape_string($o->email)."'" : ',NULL')
	.",'".mysql_real_escape_string($o->summary)."'"
	.(@$o->content ? ",'".mysql_real_escape_string($o->content)."'" : ',NULL')
	.",".(@$o->rate  ? $o->rate:'NULL')
	.",".(int)$pid
	.",".SQL_NOW
	.(@$o->extra ? ",'".mysql_real_escape_string($o->extra)."'" : ',NULL')
	.')';
	_trace($sql);
//	echo $sql;
	return mysql_query($sql);
}
function productRate($pid){
//dangtx@esnadvance.com
//tra ve so diem cua san pham

	global $sql;
	$sql = 'SELECT `a`.`rate` FROM `'.DB_TABLE_PREFIX.'review` as `a` WHERE `a`.`productid`='.(int)$pid;
	$number = 0;
	$dem=0;
	$rs = mysql_query($sql);
	while($row = mysql_fetch_row($rs))
	{
	//print_r($row);
		if ($row[0]!=NULL)
		{
		$dem++;
		$number= $number + (int)$row[0];
		}
	}
	mysql_free_result($rs);
	$rate= round($number/$dem);
	if ($rate ==0) $rate=1;
	return $rate;
}

?>