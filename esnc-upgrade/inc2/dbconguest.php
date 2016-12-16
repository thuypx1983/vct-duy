<?php
$CON = $con = mysql_connect (DB_HOST,DB_USER,DB_PWD) or die (mysql_error());
mysql_select_db(DB_NAME,$con) or die (mysql_error());
$sql=NULL;
$rs=NULL;
$row=NULL;
$ESNC_ROWCOUNT=0;
$ESNC_ROWSTART=0;
$ESNC_ROWEND=0;
function dbclose(){
	global $con;
	mysql_close($con);
}
function dbopen(){
	global $CON,$con;
	$CON = $con = mysql_connect (DB_HOST,DB_USER,DB_PWD) or die (mysql_error());
	mysql_select_db(DB_NAME,$con) or die (mysql_error());
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
	$sql = 'SELECT DISTINCT '.$fields.' FROM '.str_replace('#',DB_TABLE_PREFIX,$from);
	if($where) $sql .= ' WHERE '.$where;
	if($param) $sql .= ' '.$param.' ';
	$sql .=' LIMIT '.(int)$startrow.','.(int)$limit;
	_trace(__FUNCTION__);
	_trace($sql);
	return mysql_query($sql);
	
}
function mysql_page_select(&$page,&$pagecount,$pagesize,$fields,$from,$where='',$param=''){
	global $sql,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND;
	if(strpos($from,'`#') === FALSE){
		trigger_error('t&ecirc;n c&aacute;c b&#7843;ng ph&#7843;i c&oacute; d&#7845;u # &#273;&#7913;ng tr&#432;&#7899;c. T&ecirc;n c&aacute;c b&#7843;ng, c&aacute;c tr&#432;&#7901;ng ph&#7843;i vi&#7871;t trong d&#7845;u `',E_USER_ERROR);
		die();
	}
	if(stripos($from,'` as `') === FALSE){
		trigger_error('N&ecirc;n d&ugrave;ng b&iacute; danh b&#7843;ng, v&iacute; d&#7909; `#catnews` as `a`',E_USER_NOTICE);	
	}
	if(strpos($fields,'`.`') === FALSE){
		trigger_error('N&ecirc;n vi&#7871;t t&ecirc;n b&#7843;ng (b&iacute; danh b&#7843;ng) tr&#432;&#7899;c t&ecirc;n tr&#432;&#7901;ng, v&iacute; d&#7909;: SELECT `a` .`id`,`a`.`name`',E_USER_NOTICE);	
	}
	if(is_int($page) && is_int($pagesize)){
		$sql = 'SELECT SQL_CALC_FOUND_ROWS DISTINCT '.$fields.' FROM '.str_replace('#',DB_TABLE_PREFIX,$from);
		if($where) $sql .= ' WHERE '.$where;
		if($param) $sql .= $param;
		if($page < 1) $page = 1;
		if($pagesize < 2) $pagesize = 2;
		$ESNC_ROWSTART = ($page-1)*$pagesize;
		$sql .=' LIMIT '.$ESNC_ROWSTART.','.$pagesize;
		_trace(__FUNCTION__);
		_trace($sql);
		$rs = mysql_query($sql);
		$row=mysql_fetch_row($rs1 = mysql_query('SELECT FOUND_ROWS()'));
		$ESNC_ROWCOUNT=(int)$row[0];
		mysql_free_result($rs1);
		$pagecount = max(1,ceil($ESNC_ROWCOUNT / $pagesize));
		++$ESNC_ROWSTART;
		$ESNC_ROWEND=$ESNC_ROWSTART + $pagesize;
		return $rs;
	}
}
function ESNC_SQL_NOW(){ //this function is replacement for SQL NOW(). support timezone
	return strftime('\'%Y-%m-%d %H:%M:%S\'');
}
function r_dbopen(){
	global $r_cn,$DB_R_HOST,$DB_R_USER,$DB_R_PWD,$DB_R_NAME;
	$r_cn = mysql_connect($DB_R_HOST,$DB_R_USER,$DB_R_PWD);
	return mysql_select_db($DB_R_NAME);
}
function r_dbclose(){
	@mysql_close($r_cn);
}
function r_mysql_select($fields,$from,$where='',$param='',$startrow=0,$limit=50){
	global $sql,$DB_R_TABLE_PREFIX,$r_cn;
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
	$sql = 'SELECT DISTINCT '.$fields.' FROM '.str_replace('#',$DB_R_TABLE_PREFIX,$from);
	if($where) $sql .= ' WHERE '.$where;
	if($param) $sql .= $param;
	$sql .=' LIMIT '.(int)$startrow.','.(int)$limit;
	_trace(__FUNCTION__);
	_trace($sql);
	return mysql_query($sql,$r_cn);
	
}
?>