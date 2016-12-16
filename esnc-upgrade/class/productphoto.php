<?php class productphoto{
	var $name,$img,$alt,$productid,$view,$url,$ctrl;
	function fetch(){
		_trace(__FUNCTION__);
		$this->name=(string)$_POST['name'];
		$this->img=(string)$_POST['img'];
		$this->alt=(string)$_POST['alt'];
		$this->productid=(int)$_GET['productid'];
		$this->view=(int)$_POST['view'];
		$this->url=(string)$_POST['url'];
		$this->ctrl=@(int)array_sum($_POST['ctrl']);
	}
	function addrow(){
		global $sql;
		_trace(__FUNCTION__);
		if($this->img == '') return FALSE;
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'productphoto`(`img`,`name`,`alt`,`productid`,`view`,`url`,`ctrl`) VALUES ('
		." '".mysql_real_escape_string(stripslashes($this->img))."'"
		.",'".mysql_real_escape_string(stripslashes($this->name))."'"
		.",'".mysql_real_escape_string(stripslashes($this->alt))."'"
		.",'".(int)$this->productid."'"
		.",'".(int)$this->view."'"
		.",'".mysql_real_escape_string(stripslashes($this->url))."'"
		.",'".(int)$this->ctrl."'"
		.')';		
		_trace($sql);
		if(mysql_query($sql)){			
			return TRUE;
		}
	}
	function updaterow(){
		global $sql;
		_trace(__FUNCTION__);
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'productphoto` SET'
		." `name`='".mysql_real_escape_string(stripslashes($this->name))."'"
		.",`alt`='".mysql_real_escape_string(stripslashes($this->alt))."'"
		.",`view`='".(int)$this->view."'"
		.",`url`='".mysql_real_escape_string(stripslashes($this->url))."'"
		.",`ctrl`='".(int)$this->ctrl."'"
		." WHERE `img` = '".mysql_real_escape_string(stripslashes($this->img))."' AND `productid`=".(int)$this->productid;
		_trace($sql);
		return mysql_query($sql);
	}
	function loadonerow(){
	}
	function loadrow(){
	}
}?>