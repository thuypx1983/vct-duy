<?php
@define('REGEX_CHECK_EMAIL','/^[\w\-\.\+]+@(?:[\w\-]+\.)+[a-zA-Z0-9]{1,5}$/');
function subscribe($email,$ctrl=0x7FFFFFFF){
	global $sql;
	if(is_int($ctrl) && preg_match(REGEX_CHECK_EMAIL,$email)){
		$email=strtolower($email);
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'email` SET `ctrl`='.$ctrl.' WHERE `email`=\''.mysql_real_escape_string($email).'\'';		
		mysql_query($sql);
		if(mysql_affected_rows() >= 1) return TRUE;//update sucess for ctrl
		$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'email`(`email`,`ctrl`,`created`) VALUES (\''.mysql_real_escape_string($email).'\','.$ctrl.','.SQL_NOW.')';
		mysql_query($sql);
		return (bool)mysql_affected_rows();
	}
	return FALSE;
}
function unsubscribe($email,$ctrl=0){
	global $sql;
	if(is_int($ctrl) && preg_match(REGEX_CHECK_EMAIL,$email)){
		$email=strtolower($email);
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'email` SET `ctrl`='.(int)$ctrl.' WHERE `email`=\''.mysql_real_escape_string($email).'\'';
		return mysql_query($sql);
	}
	return FALSE;
}
?>