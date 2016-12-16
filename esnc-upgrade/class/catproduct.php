<?php 
require('../nonsign.php');
class catproduct{//Phai sua ham addrow va update bo dau phay (,) truoc field dau tien,
	//ham fetch() phai chuyen $_POST['id'] thanh $_GET['id'] va $_POST['ctrl'] thanh @array_sum($_POST['ctrl']);
	var $id,$parentid,$name,$desc,$view,$ctrl,$img1,$alt1,$extra,$layout;

	function fetch(){

		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->parentid=(int)$_GET['parentid'];
		$this->name=(string)$_GET['name'];
		$this->desc=(string)$_GET['desc'];
		$this->view=(int)$_GET['view'];
		$this->ctrl=(int)@array_sum($_GET['ctrl']);
		$this->img1=(string)$_GET['img1'];
		$this->alt1=(string)$_GET['alt1'];
		$this->extra=(string)$_GET['extra'];
		$this->layout=(int)$_GET['layout'];
		$this->urlrewrite=(string)$_GET['urlrewrite'];
	}
	function addrow(){
		if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'catproduct`(`parentid`,`name`,`desc`,`view`,`ctrl`,`img1`,`alt1`,`extra`,`layout`,`urlrewrite`) VALUES ('
		.($this->parentid > 0 ? $this->parentid: 'NULL')
		.",'".mysql_real_escape_string(stripslashes($this->name))."'"
		.",'".mysql_real_escape_string(stripslashes($this->desc))."'"
		.",'".(int)$this->view."'"
		.",'".(int)$this->ctrl."'"
		.",'".mysql_real_escape_string(stripslashes($this->img1))."'"
		.",'".mysql_real_escape_string(stripslashes($this->alt1))."'"
		.",'".mysql_real_escape_string(stripslashes($this->extra))."'"
		.",'".(int)$this->layout."'"
		.",'".mysql_real_escape_string(stripslashes($this->urlrewrite))."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
	}
	function updaterow(){
		if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."catproduct` SET"
		." `ParentID`=".($this->parentid > 0 ? $this->parentid: 'NULL')
		.",`Name`='".mysql_real_escape_string(stripslashes($this->name))."'"
		.",`Desc`='".mysql_real_escape_string(stripslashes($this->desc))."'"
		.",`View`='".(int)$this->view."'"
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`Img1`='".mysql_real_escape_string(stripslashes($this->img1))."'"
		.",`Alt1`='".mysql_real_escape_string(stripslashes($this->alt1))."'"
		.",`Extra`='".mysql_real_escape_string(stripslashes($this->extra))."'"
		.",`Layout`='".(int)$this->layout."'"
		.",`Urlrewrite`='".mysql_real_escape_string(stripslashes($this->urlrewrite))."'"
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `parentid`, `name`, `desc`, `view`, `ctrl`, `img1`, `alt1`, `extra`, `layout`, `urlrewrite` FROM `".DB_TABLE_PREFIX."catproduct` WHERE `id` = {$this->id}";
		_trace($sql);
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->parentid = (int)$row['parentid'];
		$this->name = (string)$row['name'];
		$this->desc = (string)$row['desc'];
		$this->view = (int)$row['view'];
		$this->ctrl = (int)$row['ctrl'];
		$this->img1 = (string)$row['img1'];
		$this->alt1 = (string)$row['alt1'];
		$this->extra = (string)$row['extra'];
		$this->layout = (int)$row['layout'];
		$this->urlrewrite = (string)$row['urlrewrite'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `parentid`, `name`, `desc`, `view`, `ctrl`, `img1`, `alt1`, `extra`, `layout`, `urlrewrite` FROM `".DB_TABLE_PREFIX."catproduct` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
}
?>