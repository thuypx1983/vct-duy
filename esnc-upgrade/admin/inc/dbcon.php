<?php
$ER = error_reporting(0);
define('SQL_NOW',strftime('\'%Y-%m-%d %H:%M:%S\''));
define('tbBanner',DB_TABLE_PREFIX.'Banner');
define('tbCatBanner',DB_TABLE_PREFIX.'CatBanner');
define('tbCatBannerBanner',DB_TABLE_PREFIX.'CatBannerBanner');
define('tbNews',DB_TABLE_PREFIX.'News');
define('tbNewsLink',DB_TABLE_PREFIX.'NewsLink');
define('tbCatNews',DB_TABLE_PREFIX.'CatNews');
define('tbCatNewsNews',DB_TABLE_PREFIX.'CatNewsNews');
define('tbProduct',DB_TABLE_PREFIX.'Product');
define('tbOption',DB_TABLE_PREFIX.'Option');
define('tbCatOption',DB_TABLE_PREFIX.'CatOption');
define('tbProductLink',DB_TABLE_PREFIX.'ProductLink');
define('tbProductNews',DB_TABLE_PREFIX.'ProductNews');
define('tbProductPhoto',DB_TABLE_PREFIX.'ProductPhoto');
define('tbProductType',DB_TABLE_PREFIX.'ProductType');
define('tbReview',DB_TABLE_PREFIX.'Review');
define('tbManufacturer',DB_TABLE_PREFIX.'Manufacturer');
define('tbQuote',DB_TABLE_PREFIX.'Quote');
define('tbCatProduct',DB_TABLE_PREFIX.'CatProduct');
define('tbCatProductProduct',DB_TABLE_PREFIX.'CatProductProduct');
define('tbCatProductProductType',DB_TABLE_PREFIX.'CatProductProductType');
define('tbUtility',DB_TABLE_PREFIX.'Utility');
define('tbCatUtility',DB_TABLE_PREFIX.'CatUtility');
define('tbCatUtilityUtility',DB_TABLE_PREFIX.'CatCatUtilityUtility');
define('tbCatUtilityUtility',DB_TABLE_PREFIX.'CatCatUtilityUtility');
define('tbFeature',DB_TABLE_PREFIX.'Feature');
define('tbObjectFeature',DB_TABLE_PREFIX.'ObjectFeature');
define('tbObjectLink',DB_TABLE_PREFIX.'ObjectLink');
define('tbAgent',DB_TABLE_PREFIX.'Agent');
define('tbCity',DB_TABLE_PREFIX.'City');
define('tbCountry',DB_TABLE_PREFIX.'Country');
define('tbZone',DB_TABLE_PREFIX.'Zone');
define('tbCustomer',DB_TABLE_PREFIX.'Customer');
define('tbFeedback',DB_TABLE_PREFIX.'Feedback');
define('tbPoll',DB_TABLE_PREFIX.'Poll');
define('tbVote',DB_TABLE_PREFIX.'Vote');
define('tbEmail',DB_TABLE_PREFIX.'Email');
define('tbFaq',DB_TABLE_PREFIX.'Faq');
define('tbShopCart',DB_TABLE_PREFIX.'ShopCart');
define('tbCurrency',DB_TABLE_PREFIX.'Currency');
define('tbPromotion',DB_TABLE_PREFIX.'Promotion');
define('tbOrder',DB_TABLE_PREFIX.'Order');
define('tbOrderDetail',DB_TABLE_PREFIX.'OrderDetail');
define('tbOrderHistory',DB_TABLE_PREFIX.'OrderHistory');
define('tbOrderStatus',DB_TABLE_PREFIX.'OrderStatus');
define('tbTaxClass',DB_TABLE_PREFIX.'TaxClass');
define('tbTaxRate',DB_TABLE_PREFIX.'TaxRate');
define('tbFs',DB_TABLE_PREFIX.'Fs');
define('tbJob',DB_TABLE_PREFIX.'Job');
define('tbReport',DB_TABLE_PREFIX.'Report');
define('tbSetting',DB_TABLE_PREFIX.'Setting');
define('tbResource',DB_TABLE_PREFIX.'Resource');
define('tbUser',DB_TABLE_PREFIX.'User');
define('tbAccess',DB_TABLE_PREFIX.'Access');
define('tbPartner',DB_TABLE_PREFIX.'Partner');
define('tbCounter',DB_TABLE_PREFIX.'Counter');
define('tbPartner',DB_TABLE_PREFIX.'Partner');
function mysql_db_size(){
	global $sql;
	static $total = 0;//cache database size
	if($total) return $total;
	$sql = 'SHOW TABLE STATUS FROM `'.DB_NAME.'`';
	$rs = mysql_query($sql); // This is the result of executing the query
	$total = 0;
	while($row = mysql_fetch_assoc($rs))// Here we are to add the columns 'Index_length' and 'Data_length' of each row
		$total += $row['Data_length']+$row['Index_length'];
	mysql_free_result($rs);
	return	($total >>=10);//calculate as KB
}
function mysql_exec(&$sql){
	_trace($sql);
	return mysql_query($sql);
}
function dbopen(){
	global $con;
	$con = mysql_connect (DB_HOST,DB_USER_ADMIN,DB_PWD_ADMIN) or exit (mysql_error());
	return mysql_select_db(DB_NAME,$con);
}
function dbclose($rs=FALSE){
	@mysql_free_result($rs);
	@mysql_close();
}
function mysql_select($fields,$from,$where='',$param='',$startrow=0,$limit=50){
	global $sql;
	if(strpos($from,'`#') === FALSE){
		trigger_error('t&ecirc;n c&aacute;c b&#7843;ng ph&#7843;i c&oacute; d&#7845;u # &#273;&#7913;ng tr&#432;&#7899;c. T&ecirc;n c&aacute;c b&#7843;ng, c&aacute;c tr&#432;&#7901;ng ph&#7843;i vi&#7871;t trong d&#7845;u `',E_USER_ERROR);
		die();
	}
	if(strpos($from,'` as `') === FALSE){
		trigger_error('N&ecirc;n d&ugrave;ng b&iacute; danh b&#7843;ng, v&iacute; d&#7909; `#catnews` as `a`',E_USER_NOTICE);	
	}
	if(strpos($fields,'`.`') === FALSE){
		trigger_error('N&ecirc;n vi&#7871;t t&ecirc;n b&#7843;ng (b&iacute; danh b&#7843;ng) tr&#432;&#7899;c t&ecirc;n tr&#432;&#7901;ng, v&iacute; d&#7909;: SELECT `a` .`id`,`a`.`name`',E_USER_NOTICE);	
	}
	$sql = 'SELECT '.$fields.' FROM '.str_replace('#',DB_TABLE_PREFIX,$from);
	if($where) $sql .= ' WHERE '.$where;
	if($param) $sql .= $param;
	$sql .=' LIMIT '.(int)$startrow.','.(int)$limit;
	_trace(__FUNCTION__);
	_trace($sql);
	return mysql_query($sql);
	
}
function r_open($host,$user,$pwd,$db){
	global $r_con;
	$r_cn = mysql_connect($host,$user,$pwd);
	return mysql_select_db($db);
}
function r_exec($sql){
	global $r_con;
	return mysql_query($sql,$r_con);
}
function r_close($cn=NULL){
	global $r_con;
	return mysql_close($r_con);
}
function mysql_format_datetime($datetime){
@define('S_DB_DATETIME','$3-$2-$1 $4:$5:$6');
	$count=0;
	$datetime = preg_replace(REGEX_DATETIME,S_DB_DATETIME,$datetime.':00:00:00:000',1,$count);
	if($count) return $datetime; else return '0000-00-00 00:00:00';
}
function mysql_format_date($datetime){
@define('S_DB_DATE','$3-$2-$1');
	$count=0;
	$datetime = preg_replace(REGEX_DATE,S_DB_DATE,$datetime,1,$count);
	if($count) return $datetime; else return '0000-00-00';
}
function ESNC_SQL_NOW(){
	return strftime('\'%Y-%m-%d %H:%M:%S\'');
}
dbopen();
error_reporting($ER);
?>
