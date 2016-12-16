<?php
//vinhtx@esnadvanced.com
//compability	
@define('USER_CTRL_ALERT_FEEDBACK',4);
@define('FEEDBACK_CTRL_READ',4);
//@define('EMAIL_WEBMASTER','webmaster@esnadvanced.com');
@define('EMAIL_WEBMASTER','tienpd@esnadvanced.com');
@define('FORMAT_DB_DATETIME','%d-%m-%Y %T');//format date time from mysql date time
//end compability

class feedback{
	var $id;
	var $email;
	var $name;
	var $subject;
	var $body;
	var $created;
	var $ctrl;
	var $msg;
	function feedback($id=null){
	}
	function initfeedback($email,$name,$subject,$body,$created,$ctrl){
		$this->email=$email;
		$this->name=$name;
		$this->subject=$subject;
		$this->body=$body;
		$this->created=$created;
		$this->ctrl=$ctrl;
		$this->msg = "Init success";
	}
	function initnewsletter($email,$name,$subject,$body,$created,$ctrl){
		$this->email=$email;
		$this->name=$name;
		$this->subject=$subject;
		$this->body=$body;
		$this->created=$created;
		$this->ctrl=$ctrl;
		$this->msg = "Init success";
	}
	function addrow(){
		global $sql;
		$sql='INSERT INTO `feedback`(`email`,`name`,`subject`,`body`,`created`,`ctrl`) VALUES ('
		."'".mysql_real_escape_string($this->email)."'"
		.",'".mysql_real_escape_string($this->name)."'"
		.",'".mysql_real_escape_string($this->subject)."'"
		.",'".mysql_real_escape_string($this->body)."'"
		.",NOW()"
		.",'".(int)$this->ctrl."'"
		.")";
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
		_trace($sql);
		return FALSE;
	}
	function deleterow(){
		$sql="DELETE FROM `feedback` WHERE `id` = ".(int)$this->id;
		return mysql_query ($sql);
	}
	function updaterow(){
		$sql="UPDATE `feedback` SET "
			."`email`='".mysql_real_escape_string($this->email)."'"
			.",`name`='".mysql_real_escape_string($this->name)."'"
			.",`subject`='".mysql_real_escape_string($this->subject)."'"
			.",`body`='".mysql_real_escape_string($this->body)."'"
			.",`created`=NOW()"
			.",`ctrl`='".(int)$this->ctrl."'"
			."  WHERE `id` = ".(int)$this->id;
		return mysql_query ($sql);
	}
	function loadonerow(){
		$sql="SELECT `id`,`email`,`name`,`subject`,`body`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,`ctrl` FROM `feedback` WHERE `id` = ".(int)$this->id;
		$row = mysql_fetch_array($rs = mysql_query ($sql));
		$this->id = $row['id'];
		$this->email = $row['email'];
		$this->name = $row['name'];
		$this->subject = $row['subject'];
		$this->body = $row['body'];
		$this->created = $row['created'];
		$this->ctrl = $row['ctrl'];
		mysql_free_result($rs);
		return true;
	}
	function sqlexcute($sql){
		$sql=mysql_escape_string($sql);
		return mysql_query ($sql);
	}
	function alert($extra=''){
		$mr = new mailer();
		$sql = "SELECT `email` FROM `user` WHERE (`alert` & ".USER_CTRL_ALERT_FEEDBACK.") <> 0";
		$rs = mysql_query($sql);
		for($mr->recipient=EMAIL_CONTACT;$rw=mysql_fetch_row($rs);$mr->recipient .= ",{$rw[0]}");
		mysql_free_result($rs);
		$sql="SELECT `id`,`email`,`subject`,`body` FROM `feedback` WHERE `ctrl`=0";
		$rs = mysql_query($sql);
		while($row=mysql_fetch_object($rs)){
			$mr->sender=($row->email=="" ? EMAIL_WEBMASTER: $row->email);
			$mr->cc = $row->email;
			$mr->subject=$row->subject;
			$mr->body=$row->body.$extra;
			$mr->send();
			$sql = "UPDATE `feedback` SET `ctrl` = ".FEEDBACK_CTRL_READ." WHERE `id`={$row->id}";
			mysql_query($sql);
		}
		mysql_free_result($rs);
	}
}
?>