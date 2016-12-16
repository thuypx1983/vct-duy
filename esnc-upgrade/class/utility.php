<?php
//vinhtx@esnadvanced.com
class utility{
	var $id,$name,$summary,$path,$filename,$img,$alt,$view,$ctrl,$keyword;
	function addrow(){
		global $sql;
		$sql = "INSERT INTO `".DB_TABLE_PREFIX."utility`(
		`name`,
		`summary`,
		`path`,
		`filename`,
		`img`,
		`alt`,
		`view`,
		`ctrl`,
		`keyword`
		) VALUES ("
			."'".mysql_escape_string($this->name)."'"
			.",'".mysql_escape_string($this->summary)."'"
			.",'".mysql_escape_string($this->path)."'"
			.",'".mysql_escape_string($this->filename)."'"
			.",'".mysql_escape_string($this->img)."'"
			.",'".mysql_escape_string($this->alt)."'"
			.",".(int)$this->view	
			.",".(int)$this->ctrl	
			.",'".mysql_escape_string($this->keyword)."'"
			.")";
		if(mysql_query($sql)){ $this->id = mysql_insert_id();return TRUE;}
		_trace($sql); return FALSE;
	}
	function updaterow(){
		global $sql;
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."utility` SET"
			." `Name`='".mysql_escape_string($this->name)."'"
			.",`Summary`='".mysql_escape_string($this->summary)."'"
			.",`Path`='".mysql_escape_string($this->path)."'"
			.",`Filename`='".mysql_escape_string($this->filename)."'"
			.",`Img`='".mysql_escape_string($this->img)."'"
			.",`Alt`='".mysql_escape_string($this->alt)."'"
			.",`View`=".(int)$this->view	
			.",`Ctrl`=".(int)$this->ctrl	
			.",`KeyWord`='".mysql_escape_string($this->keyword)."'"
			." WHERE `id` = {$this->id}";
		if(mysql_query($sql)) return TRUE;
		_trace($sql); return FALSE;
	}
	function loadonerow(){
		global $sql;
		settype($this->id,'int');
		$sql = "SELECT `name`, `summary`, `path`, `filename`, `img`, `alt`, `view`, `ctrl`, `keyword` FROM `".DB_TABLE_PREFIX."utility` WHERE `id` = {$this->id}";
		if($row=mysql_fetch_assoc($rs=mysql_query($sql))){
			$this->name = (string)$row['name'];
			$this->summary = (string)$row['summary'];
			$this->path = (string)$row['path'];
			$this->filename = (string)$row['filename'];
			$this->img = (string)$row['img'];
			$this->alt = (string)$row['alt'];
			$this->view = (int)$row['view'];
			$this->ctrl = (int)$row['ctrl'];
			$this->keyword = (string)$row['keyword'];
			mysql_free_result($rs);
			return TRUE;
		}
		_trace($sql);return FALSE;
	}
}
?>