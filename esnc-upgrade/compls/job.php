<?php
$ESNC_JOB_DONE=0;
function joblist($ctrl=1,$type=2,$top=5){
	global $sql;
	$sql = 'SELECT `id`,`cmd`,`param`,`ctrl`,`type`,`objectclass`,`objectid` FROM `'.DB_TABLE_PREFIX.'job` WHERE `type`='.(int)$type.' AND `ctrl` & '.$ctrl.'='.$ctrl.' AND ('.SQL_NOW.' > `scheduled` OR `ctrl` & '.JOB_CTRL_RUNOW.'='.JOB_CTRL_RUNOW.')';
	return mysql_query($sql);
}
function jobdone(&$j,$result=TRUE,$msg='OK'){
	global $sql,$ESNC_JOB_DONE;
	$t = FALSE;
	$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'job` WHERE `id`='.(int)$j->id.' AND `ctrl` & 4=4';//delete if job is auto delete
	mysql_query($sql);
	if(mysql_affected_rows()) return TRUE;//auto delete
	$sql = 'UPDATE `'.DB_TABLE_PREFIX.'job` SET  `lastrun`='.SQL_NOW.',`run`=`run` + 1,`msg`=\''.mysql_real_escape_string($msg).'\'';
	if(strpos($j->interval,' ') > 0){//have schedule
		$interval = mysql_real_escape_string($j->interval);
		$sql .=',`ctrl`='.((int)$j->ctrl & ~JOB_CTRL_RUNOW|($result ? 2: 0)).',`interval`=\''.$interval.'\' WHERE `id`='.(int)$j->id;//schedule to next run
		mysql_query($sql);//update schedule
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'job` SET `scheduled` = `scheduled` + INTERVAL '.$interval.' WHERE `scheduled` < '.SQL_NOW.' AND `id`='.(int)$j->id;
		for($i=0,mysql_query($sql);($i < 1000) && mysql_affected_rows();++$i)	mysql_query($sql);
		++$ESNC_JOB_DONE;
	}elseif($result){//no schedule disable on success
		$sql .= ',`ctrl` = '.((int)$j->ctrl & ~JOB_CTRL_RUNOW|2 & ~1).' WHERE `id`='.(int)$j->id;//disable if no schedule
		if(mysql_query($sql)) ++$ESNC_JOB_DONE;
	}else{//no schedule, failure
		$sql .=',`ctrl` = '.((int)$j->ctrl & ~JOB_CTRL_RUNOW).' WHERE `id`='.(int)$j->id;//disable if no schedule
		if(mysql_query($sql)) ++$ESNC_JOB_DONE;
	}
	echo ';window.status += "|'.$j->name.':'.$msg.'"';
}
function jobqueueready(){
	if((time() - @fileatime(FILE_JOB_CTRL) > JOB_INTERVAL) && @touch(FILE_JOB_CTRL)){
		register_shutdown_function('esnc_exec_system_job');
		return TRUE;
	}
	return FALSE;
}
function jobread($name){
	global $sql;
	$sql = 'SELECT `id`,`name`,`act`,`cmd`,`param`,`objectid`,`objectclass`, DATE_FORMAT(`scheduled`,\''.FORMAT_DB_DATETIME.'\') as `scheduled`,`ctrl`,`type`,`run`, DATE_FORMAT(`lastrun`,\''.FORMAT_DB_DATETIME.'\') as `lastrun`,`msg`,`interval` FROM `'.DB_TABLE_PREFIX.'job` WHERE `name`=\''.mysql_real_escape_string($name).'\' AND `type` IS NOT NULL AND `ctrl` & 1 = 1 AND  (('.SQL_NOW.' > `scheduled`) OR `ctrl` & '.JOB_CTRL_RUNOW.' <> 0)  LIMIT 1';
	$rs = mysql_query($sql);
	$j = mysql_fetch_object($rs);
	mysql_free_result($rs);
	return $j;
}
function esnc_exec_system_job(){
	dbopen();
	global $sql,$n_file,$n_folder,$max_filesize,$name_maxfilesize,$ESNC_JOB_DONE;
	$rs=joblist(1,0);//exec sql system job automatically: sql job, save counter, update statistic:database size, folder size
	while($row=mysql_fetch_object($rs)){
		$sql = $row->cmd.' '.$row->param;
		if(mysql_query($sql))	jobdone($row); else	jobdone($row,FALSE,'FAILED');
	}
	mysql_free_result($rs);
	if($ESNC_JOB_DONE > 0){
		require_once PATH_CLASS.'cache.php';
		cache::toggle(TRUE);//auto enable cache
		cache::clear();
		echo ';window.status += "|cache cleared"';
	}
	if($j = jobread('SAVE_COUNTER')){
		session::savecounter();//save counter
		jobdone($j,TRUE,'SAVED');
	}
	if($j = jobread('SYS_STATS')){//update statistic
	//1: calculate database size
		$total = 0;
		$sql = 'SHOW TABLE STATUS FROM `'.DB_NAME.'`';
		$rs = mysql_query($sql); // This is the result of executing the query
		$total = 0;
		while($row = mysql_fetch_assoc($rs))// Here we are to add the columns 'Index_length' and 'Data_length' of each row
			$total += $row['Data_length']+$row['Index_length'];
		mysql_free_result($rs);
		$total >>=10;//calculate as KB
	//2: calculate folder size
		$n_file = 0;
		$n_folder=0;
		$max_filesize=0;
		$name_maxfilesize='';
		$root_size = foldersize(rtrim(PATH_ROOT,'/')) >> 10;
		$name_maxfilesize=str_replace(PATH_ROOT,'/',$name_maxfilesize);
		$a = array('dbsize'=>$total,'foldersize'=>$root_size,'filecount'=>$n_file,'foldercount'=>$n_folder,'filesizemax'=>($max_filesize >> 10), 'filename_maxsize'=>$name_maxfilesize,'statdate'=>strftime(FORMAT_DATETIME));
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'fs` SET `content`= \''.serialize($a).'\' WHERE `name`=\'application/stat\'';
		mysql_query($sql);
		jobdone($j,TRUE,'UPDATED');
	}
	if($j = jobread('SYS_PURGE')){
		require_once PATH_CLASS.'cache.php';
		cache::toggle(TRUE);//auto enable cache
		cache::clear();
		jobdone($j);
	}
	if($j = jobread('SYS_UPDATE')){
		call_user_func(esnc_check_update,ESNC_VERSION);
		jobdone($j,TRUE,'UDPATED');
	}
	dbclose();
}
?>
