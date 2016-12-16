<?php //system report
function HitCounter(){//current hit
include_once(PATH_CLASS.'session.php');
return array(array(session::visit()-APP_VISIT_INIT,session::online()-SESSION_ONLINE_INIT));
}
function WeekHit(){//last 7 day hits
global $sql;
$sql = 'SELECT `created`,`visit`,`online` FROM `'.DB_TABLE_PREFIX.'counter` WHERE `created` + INTERVAL 7 DAY >= '.SQL_NOW.' ORDER BY `created` DESC';
return mysql_query($sql);
}
function WeekContentItem($interval = 7){//last 7 day content item
global $sql;
$sql = 'SELECT `created`,`name` FROM `'.DB_TABLE_PREFIX.'news` WHERE `created` + INTERVAL '.$interval.' DAY >= '.SQL_NOW.' ORDER BY `created` DESC';
return mysql_query($sql);
}
function WeekFeedBack(){
global $sql;
$sql = 'SELECT `created`, `Name`, `Subject` FROM `'.DB_TABLE_PREFIX.'feedback` WHERE `created` + INTERVAL 7 DAY >= '.SQL_NOW.' ORDER BY `created` DESC';	
return mysql_query($sql);
}
function WeekMember(){
global $sql;
$sql = 'SELECT `created`, `Name`, `Email`, `Visited` FROM `'.DB_TABLE_PREFIX.'customer` WHERE `created` + INTERVAL 7 DAY >= '.SQL_NOW.' ORDER BY `created` DESC';	
return mysql_query($sql);	
}
?>
