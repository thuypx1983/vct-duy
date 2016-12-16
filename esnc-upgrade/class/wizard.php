<?php //esnc template engine
class wizard{ 
	var $id,$name,$ctrl,$desc,$msg;
	function add(){ 
		dump(__METHOD__);
		$this->id=(int)$_POST['id'];
		$this->name=$_POST['name'];
		$this->ctrl=(int)$_POST['ctrl'];
		$this->desc=$_POST['desc']; 
		if ($this->addrow()) return TRUE;
		return FALSE;
	}
	function addrow(){
		global $sql,$debug;
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'wizard`(`name`,`ctrl`,`desc`) VALUES ('
		." '".mysql_real_escape_string($this->name)."'"		
		.",'".(int)$this->ctrl."'"
		.",'".mysql_real_escape_string($this->desc)."'"		
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
	} 
	function updaterow(){		
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."wizard` SET"
		." `name`='".mysql_real_escape_string($this->name)."'"		
		.",`ctrl`='".(int)$this->ctrl."'"		
		.",`desc`='".mysql_real_escape_string($this->desc)."'"
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	} 
	function loadonerow(){
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `ctrl`, `desc` FROM `".DB_TABLE_PREFIX."wizard` WHERE `id`=".$this->id;
		if ($rs = mysql_query($sql)) return $rs;
		return FALSE;
	}
	function loaditem(){
		settype($this->id,'int');
		$sql = "SELECT `id` AS `sid`, `name` AS `sname`,`view`,`catid` FROM `".DB_TABLE_PREFIX."wizarditem` WHERE `wid`=".$this->id." ORDER BY `view` ASC";
		if ($rs = mysql_query($sql)) return $rs;
		return FALSE;	
	}
	function loadrow(){
		$sql = "SELECT `id`, `name`, `ctrl`, `desc` FROM `".DB_TABLE_PREFIX."wizard`";
		if ($rs = mysql_query($sql)) return $rs;
		return FALSE;
	}
	function setCtrl($ids){
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."wizard` SET"
		." `ctrl`= `ctrl`|".(int)$this->ctrl		
		." WHERE `id` IN ($ids)";
		if (mysql_query($sql)) return TRUE;
		return FALSE;
	}
	function unsetCtrl($ids){
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."wizard` SET"
		." `ctrl`= `ctrl`&~".(int)$this->ctrl		
		." WHERE `id` IN ($ids)";
		if (mysql_query($sql)){
			$this->msg = $sql;
			return TRUE;
		}
		return FALSE;
	}

	function remove(){
		$sql = "DELETE FROM `".DB_TABLE_PREFIX."wizarditem` WHERE `wid` = $this->id";
		if (mysql_query($sql)){
			$sql1 = "DELETE FROM `".DB_TABLE_PREFIX."wizard` WHERE `id`  = $this->id";
			if (mysql_query($sql1)) return TRUE;
		}
		return FALSE;
	}
	function setName(){
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."wizard` SET"
		."`name`='".mysql_real_escape_string($this->name)."'"		
		." WHERE `id` = {$this->id}";
		if (mysql_query($sql)){
			$this->msg = $sql;
			return TRUE;
		}
		$this->msg = $sql;
		return FALSE;
	}
}
////////////////////////////////////////////////////////////////
class wizarditem{
	var $id,$name,$catid,$wid,$view,$msg;
	function fetch(){
		$this->id=(int)$_REQUEST['id'];
		$this->name=$_POST['name'];
		$this->catid=implode(',',$_POST['catid']);
		$this->view=(int)$_POST['view'];
		$this->wid=(int)$_POST['wid'];
		$this->ctrl=@array_sum($_POST['ctrl']);
	}
	function addrow(){
		global $sql,$debug;
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'wizarditem`(`name`,`catid`,`view`,`wid`,`ctrl`) VALUES ('
		." '".mysql_real_escape_string($this->name)."'"		
		.",'".mysql_real_escape_string($this->catid)."'"		
		.",'".(int)$this->view."'"		
		.",'".(int)$this->wid."'"
		.",'".(int)$this->ctrl."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}		
	}
	function updaterow(){		
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."wizarditem` SET"
		." `name`='".mysql_real_escape_string($this->name)."'"		
		.",`wid`=".(int)$this->wid
		.",`view`=".(int)$this->view		
		.",`catid`='".mysql_real_escape_string($this->catid)."'"
		.",`ctrl`=".(int)$this->ctrl
		." WHERE `id` = {$this->id}";
		if (mysql_query($sql)) {
			$this->msg = $sql;
			return TRUE;
		}
		return FALSE;
	}
	function loadonerow(){
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `catid`, `wid`,`view`,`ctrl` FROM `".DB_TABLE_PREFIX."wizarditem` WHERE `id`=".$this->id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_object($rs);
		$this->name = $row->name;
		$this->catid = $row->catid;
		$this->wid = $row->wid;
		$this->view = $row->view;
		$this->ctrl = $row->ctrl;
		return TRUE;
	}
	function loadrow(){
		$sql = "SELECT `id`, `name`, `catid`, `wid`,`view`,`ctrl` FROM `".DB_TABLE_PREFIX."wizarditem`";
		if ($rs = mysql_query($sql)) return $rs;
		return FALSE;
	}
	function remove(){
		settype($this->id,'int');
		$sql = 'DELETE  FROM `'.DB_TABLE_PREFIX.'wizarditem` WHERE `id`='.$this->id;
		if (mysql_query($sql)) return TRUE;
		return FALSE;
	}
	function setView(){
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."wizarditem` SET"
		.",`view`='".(int)$this->view."'"		
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function setName(){
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."` SET"
		.",`name`='".(int)$this->name."'"		
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function setCat(){
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."` SET"
		."`catid`='".mysql_real_escape_string($this->catid)."'"		
		." WHERE `id` = {$this->id}";
		if (mysql_query($sql)) return TRUE;
		return FALSE;
	}
	function goUpDown($id1,$id2,$view1,$view2){
	$sql1 = "UPDATE `".DB_TABLE_PREFIX."` SET `view`=$view2 WHERE `id` = $id1";
	$sql2 = "UPDATE `".DB_TABLE_PREFIX."wizarditem` SET `view`=$view1 WHERE `id` = $id2";
	if (mysql_query($sql1)) {
		if (mysql_query($sql2)) {
			$this->msg = $sql1.' | '.$sql2;
			return TRUE;
		}
	}
	return FALSE;
}
}
?>