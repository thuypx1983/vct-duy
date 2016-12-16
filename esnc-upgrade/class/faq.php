<?php 
class faq{//Phai sua ham addrow va update bo dau phay (,) truoc field dau tien,
	//ham fetch() phai chuyen $_POST['id'] thanh $_GET['id'] va $_POST['ctrl'] thanh @array_sum($_POST['ctrl']);
	var $id,$question,$customername,$answer,$view,$ctrl,$keyword;

	function fetch(){

		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->question=(string)$_POST['question'];
		$this->customername=(string)$_POST['customername'];
		$this->answer=(string)$_POST['answer'];
		$this->view=(int)$_POST['view'];
		$this->ctrl=(int)@array_sum($_POST['ctrl']);
		$this->keyword=(string)$_POST['keyword'];
	}
	function addrow(){
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'faq`(`question`,`customername`,`answer`,`view`,`ctrl`,`keyword`) VALUES ('
		."'".mysql_real_escape_string($this->question)."'"
		.",'".mysql_real_escape_string($this->customername)."'"
		.",'".mysql_real_escape_string($this->answer)."'"
		.",'".(int)$this->view."'"
		.",'".(int)$this->ctrl."'"
		.",'".mysql_real_escape_string($this->keyword)."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
	}
	function updaterow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."faq` SET"
		." `Question`='".mysql_real_escape_string($this->question)."'"
		.",`CustomerName`='".mysql_real_escape_string($this->customername)."'"
		.",`Answer`='".mysql_real_escape_string($this->answer)."'"
		.",`View`='".(int)$this->view."'"
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`KeyWord`='".mysql_real_escape_string($this->keyword)."'"
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `question`, `customername`, `answer`, `view`, `ctrl`, `keyword` FROM `".DB_TABLE_PREFIX."faq` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->question = (string)$row['question'];
		$this->customername = (string)$row['customername'];
		$this->answer = (string)$row['answer'];
		$this->view = (int)$row['view'];
		$this->ctrl = (int)$row['ctrl'];
		$this->keyword = (string)$row['keyword'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `question`, `customername`, `answer`, `view`, `ctrl`, `keyword` FROM `".DB_TABLE_PREFIX."faq` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
}
?>