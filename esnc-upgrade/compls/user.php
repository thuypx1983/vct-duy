<?php
function userlist($alert,$top=5){
	global $DB_R_NAME;
	$alert |= USER_ALERT_ENABLE;
	if(is_int($alert) && is_int($top)){
		if(@$DB_R_NAME){
			r_dbopen();//open remote
			return r_mysql_select('`a`.`name`,`a`.`email`','`#user` as `a`','`a`.`alert` & '.$alert.' = '.$alert,'',0,5);
		}else return mysql_select('`a`.`name`,`a`.`email`','`#user` as `a`','`a`.`alert` & '.$alert.' = '.$alert,'',0,5);
	}
}
?>