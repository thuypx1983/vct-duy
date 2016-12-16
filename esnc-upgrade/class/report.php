<?php class report{
	var $id,$name,$summary,$type,$ctrl,$columns,$detail,$lastrun;

	function fetch(){
		$this->id=(int)$_GET['id'];
		$this->name=(string)$_POST['name'];
		$this->summary=(string)$_POST['summary'];
		$this->type=(int)@array_sum($_POST['type']);
		$this->ctrl=(int)@array_sum($_POST['ctrl']);
		$this->columns=(string)$_POST['columns'];
		$this->detail=(string)$_POST['detail'];
		$this->lastrun=(string)$_POST['lastrun'];
	}
	function addrow(){
		global $sql;
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'report`(`name`,`summary`,`type`,`ctrl`,`columns`,`detail`,`lastrun`) VALUES ('
		." '".mysql_real_escape_string($this->name)."'"
		.",'".mysql_real_escape_string($this->summary)."'"
		.",'".(int)$this->type."'"
		.",'".(int)$this->ctrl."'"
		.",'".mysql_real_escape_string($this->columns)."'"
		.",'".mysql_real_escape_string($this->detail)."'"
		.",'".mysql_format_datetime($this->lastrun)."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
		_trace($sql);
	}
	function updaterow(){
		global $sql;
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."report` SET"
		." `name`='".mysql_real_escape_string($this->name)."'"
		.",`summary`='".mysql_real_escape_string($this->summary)."'"
		.",`type`='".(int)$this->type."'"
		.",`ctrl`='".(int)$this->ctrl."'"
		.",`columns`='".mysql_real_escape_string($this->columns)."'"
		.",`detail`='".mysql_real_escape_string($this->detail)."'"
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `summary`, `type`, `ctrl`, `columns`, `detail`,DATE_FORMAT(`lastrun`,'".FORMAT_DB_DATETIME."') as `lastrun` FROM `".DB_TABLE_PREFIX."report` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->name = (string)$row['name'];
		$this->summary = (string)$row['summary'];
		$this->type = (int)$row['type'];
		$this->ctrl = (int)$row['ctrl'];
		$this->columns = (string)$row['columns'];
		$this->detail = (string)$row['detail'];
		$this->lastrun = (string)$row['lastrun'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `summary`, `type`, `ctrl`, `columns`, `detail`,DATE_FORMAT(`lastrun`,'".FORMAT_DB_DATETIME."') as `lastrun` FROM `".DB_TABLE_PREFIX."report` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
}
?>
