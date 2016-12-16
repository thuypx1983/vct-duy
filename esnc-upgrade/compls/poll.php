<?php //vinhtx@esnadvanced.com
function polllist($ctrl=1,$top=1){
	settype($ctrl,'int');
	$sql='SELECT `id`,`name`,`question`,`ctrl`,`type`, DATE_FORMAT(`thisdate`,\''.FORMAT_DB_DATE.'\') as `thisdate`,DATE_FORMAT(`enddate`,\''.FORMAT_DB_DATE.'\') as `enddate`,`num` + 0 as `num`,IF(CURRENT_DATE > `enddate`,1,0) as `expires` FROM `'.DB_TABLE_PREFIX.'poll` WHERE `ctrl` & '.$ctrl.' = '.$ctrl.' ORDER BY `view` ASC,`enddate` DESC,`id` DESC LIMIT '.(int)$top;
	return mysql_query($sql);
}
function pollread($id,&$o,$sortvote=FALSE){
	if($o === NULL){
		$sql='SELECT `id`,`name`,`question`,`ctrl`,`type`, DATE_FORMAT(`thisdate`,\''.FORMAT_DB_DATE.'\') as `thisdate`,DATE_FORMAT(`enddate`,\''.FORMAT_DB_DATE.'\') as `enddate`,`num` + 0 as `num`,IF(CURRENT_DATE > `enddate`,1,0) as `expires` FROM `'.DB_TABLE_PREFIX.'poll` WHERE `id`='.(int)$id;
			$rs = mysql_query($sql);
		$o = mysql_fetch_object($rs);
		mysql_free_result($rs);
	}
	$sql='SELECT `id`,`name`,`num`,`percent`,`view` FROM `'.DB_TABLE_PREFIX.'vote` WHERE `pollid` = '.(int)$id.' ORDER BY '.($sortvote ? ' `percent` DESC': ' `view` ASC');
	return 	mysql_query($sql);
}
function vote($id,&$ans){//array of choice answer
//	$cookie='ESNCPOLL'.$id;
	if(is_array($ans) /* && (int)@$_COOKIE[$cookie] == 0*/){//client must keep cookie until expires and not yet vote
		//savecookie($cookie,1,0,URL_ROOT);//mark as voted
		foreach($ans as $ansid){
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'vote` SET `num` = `num` + 1 WHERE `id`='.(int)$ansid. ' AND `pollid`='.(int)$id;
					mysql_query($sql);
		}
		$sql = 'SELECT SUM(`num`) FROM `'.DB_TABLE_PREFIX.'vote` WHERE `pollid`='.(int)$id;
			$row = mysql_fetch_row($rs=mysql_query($sql));mysql_free_result($rs);
		$count = (int)$row[0];
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'poll` SET `num` = `num` + 1 WHERE `id`='.(int)$id;
			mysql_query($sql);
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'vote` SET `percent` = ('.POLL_PERCENT_UNIT.' * 100 * `num` / '.$count.') WHERE `pollid`='.(int)$id;
			mysql_query($sql);
		return TRUE;
	}
	return FALSE;
}
function parsepollform($s,&$part,&$option){
	$part = explode('{{OPTION_NAME}}',$s);
	$tr = strrpos($part[0],'<tr');
	$tr2 = strpos($s,'/tr>',$tr) +3;
	$option=substr($s, $tr,$tr2-$tr+1);
	
	$part[0] = substr($s,0,$tr);//first parts
	$part[1] = substr($s,$tr2+1);
	
}
function esnc_pollform($s,&$part,&$part_1,&$option){
	$part=explode('{{1}}',$s);
	$part_1=explode('{{2}}',$part[1]);
	$option=$part_1[0];
}
?>