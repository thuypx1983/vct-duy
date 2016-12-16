<?php
class jobitem{
	function search(){
		global $sql;
		$sql='SELECT `id`,`name`,DATE_FORMAT(`firsttime`,\''.FORMAT_DB_DATETIME.'\') as `firsttime`,DATE_FORMAT(`scheduled`,\''.FORMAT_DB_DATETIME.'\') as `scheduled`,DATE_FORMAT(`lastrun`,\''.FORMAT_DB_DATETIME.'\') as `lastrun`,`interval`,`msg`,`type`,`run`,`ctrl` FROM `'.DB_TABLE_PREFIX.'job` WHERE `type` <> 0 LIMIT 100';
		return mysql_query($sql);
	}
	function add(){
		global $sql;
		$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'job`(`name`,`cmd`,`param`,`scheduled`,`interval`,`type`,`ctrl`,`firsttime`) VALUES ('
			.'\''.mysql_real_escape_string($this->name).'\''
			.',\''.mysql_real_escape_string($this->cmd).'\''
			.',\''.mysql_real_escape_string($this->param).'\''
			.',\''.mysql_format_datetime($this->scheduled).'\''
			.',\''.mysql_real_escape_string($this->interval).'\''
			.',2,1' //default to be enable,user job
			.',\''.mysql_format_datetime($this->scheduled).'\''
			.')';
		return mysql_query($sql);
	}
	function update(){
		global $sql;
		$sql= 'UPDATE `'.DB_TABLE_PREFIX.'job` SET `firsttime` =\''.($t=mysql_format_datetime($this->scheduled)).'\', `scheduled`=\''.$t.'\', `interval`=\''.mysql_real_escape_string($this->interval).'\' WHERE `id`='.(int)$this->id;
		mysql_query($sql);
	}
	function remove($id){
		if(preg_match(REGEX_CHECK_ID_SERIES,$id)){
			global $sql;
			$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'job` WHERE `id` IN ('.$id.')';
			return mysql_query($sql);
		}
	}
	function reboot(){
		@touch(FILE_JOB_CTRL,100);
	}
	function setctrl($id,$ctrl){
		if(preg_match(REGEX_CHECK_ID_SERIES,$id)){
			global $sql;
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'job` SET `ctrl` = `ctrl` | '.(int)$ctrl.' WHERE `id` IN ('.$id.')';
			return mysql_query($sql);
		}
	}
}
?>
