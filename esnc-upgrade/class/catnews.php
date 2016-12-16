<?php 
require('../nonsign.php');
class catnews{
	var $id,$parentid,$name,$desc,$view,$ctrl,$img1,$alt1,$extra,$urlrewrite;
	function addrow(){
		if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
		if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
		global $sql;
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'catnews`(`parentid`,`name`,`desc`,`view`,`ctrl`,`img1`,`alt1`,`extra`,`urlrewrite`) VALUES ('
		.($this->parentid > 0 ? $this->parentid: 'NULL')
		.",'".mysql_real_escape_string(stripslashes($this->name))."'"
		.",'".mysql_real_escape_string(stripslashes($this->desc))."'"
		.",'".(int)$this->view."'"
		.",'".(int)$this->ctrl."'"
		.",'".mysql_real_escape_string(stripslashes($this->img1))."'"
		.",'".mysql_real_escape_string(stripslashes($this->alt1))."'"
		.",'".mysql_real_escape_string(stripslashes($this->extra))."'"
		.",'".mysql_real_escape_string(stripslashes($this->urlrewrite))."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
		_trace(mysql_error());
		_trace($sql);
	}
	function updaterow(){
	if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
	if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
		global $sql;
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."catnews` SET"
		." `ParentID`=".($this->parentid > 0 ? $this->parentid: 'NULL')
		.",`Name`='".mysql_real_escape_string(stripslashes($this->name))."'"
		.",`Desc`='".mysql_real_escape_string(stripslashes($this->desc))."'"
		.",`View`='".(int)$this->view."'"
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`Img1`='".mysql_real_escape_string(stripslashes($this->img1))."'"
		.",`Alt1`='".mysql_real_escape_string(stripslashes($this->alt1))."'"
		.",`Extra`='".mysql_real_escape_string(stripslashes($this->extra))."'"
		.",`Urlrewrite`='".mysql_real_escape_string(stripslashes($this->urlrewrite))."'"
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		settype($this->id,'int');
		$sql = "SELECT `id`, `parentid`, `name`, `desc`, `view`, `ctrl`, `img1`, `alt1`, `extra`, `urlrewrite` FROM `".DB_TABLE_PREFIX."catnews` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->parentid = (int)$row['parentid'];
		$this->name = (string)$row['name'];
		$this->desc = (string)$row['desc'];
		$this->view = (int)$row['view'];
		$this->ctrl = (int)$row['ctrl'];
		$this->img1 = (string)$row['img1'];
		$this->alt1 = (string)$row['alt1'];
		$this->extra = (string)$row['extra'];
		$this->urlrewrite = (string)$row['urlrewrite'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		settype($this->id,'int');
		$sql = "SELECT `id`, `parentid`, `name`, `desc`, `view`, `ctrl`, `img1`, `alt1`, `extra`, `urlrewrite` FROM `".DB_TABLE_PREFIX."catnews` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
}
?>
