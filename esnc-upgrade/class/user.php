<?php class user{//Phai sua ham addrow va update bo dau phay (,) truoc field dau tien,
	//ham fetch() phai chuyen $_POST['id'] thanh $_GET['id'] va $_POST['ctrl'] thanh @array_sum($_POST['ctrl']);
	var $id,$user,$password,$name,$email,$gender,$birthday,$address,$cityid,$city,$phone,$mobile,$ctrl,$alert,$online,$created,$expired,$lastupdate,$lastlogin,$visited;

	function fetch(){

		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->user=(string)$_POST['user'];
		$this->password=(string)$_POST['password'];
		$this->name=(string)$_POST['name'];
		$this->email=(string)$_POST['email'];
		@$this->gender=(int)array_sum($_POST['gender']);
		$this->birthday=(string)$_POST['birthday'];
		$this->address=(string)$_POST['address'];
		$this->cityid=(string)$_POST['cityid'];
		$this->city=(string)$_POST['city'];
		$this->phone=(string)$_POST['phone'];
		$this->mobile=(string)$_POST['mobile'];
		$this->ctrl=(int)@array_sum($_POST['ctrl']);
		$this->alert=(int)@array_sum($_POST['alert']);
		$this->online=(int)$_POST['online'];
		$this->created=(string)$_POST['created'];
		$this->expired=(string)$_POST['expired'];
		$this->lastupdate=(string)$_POST['lastupdate'];
		$this->lastlogin=(string)$_POST['lastlogin'];
		$this->visited=(int)$_POST['visited'];
	}
	function addrow(){
		global $sql,$DB_R_TABLE_PREFIX;
		_trace(__FUNCTION__);
		$t = mysql_format_datetime($this->expired);
		if(strpos($t,'0000') === 0) $t='2999-12-31 00:00:00';
		if(!$DB_R_TABLE_PREFIX) $DB_R_TABLE_PREFIX=DB_TABLE_PREFIX;
		$sql='INSERT INTO `'.$DB_R_TABLE_PREFIX.'user`(`user`,`password`,`name`,`email`,`gender`,`birthday`,`address`,`cityid`,`city`,`phone`,`mobile`,`ctrl`,`alert`,`online`,`created`,`expired`,`lastupdate`,`lastlogin`,`visited`) VALUES ('
		." '".mysql_real_escape_string($this->user)."'"
		.",'".mysql_real_escape_string(call_user_func(esnc_passwd_encode,$this->password))."'"
		.",'".mysql_real_escape_string($this->name)."'"
		.",'".mysql_real_escape_string($this->email)."'"
		.",'".(int)$this->gender."'"
		.",'".mysql_format_date($this->birthday)."'"
		.",'".mysql_real_escape_string($this->address)."'"
		.",'".mysql_real_escape_string($this->cityid)."'"
		.",'".mysql_real_escape_string($this->city)."'"
		.",'".mysql_real_escape_string($this->phone)."'"
		.",'".mysql_real_escape_string($this->mobile)."'"
		.",'".(int)$this->ctrl."'"
		.",'".(int)$this->alert."'"
		.",'".(int)$this->online."'"
		.",".SQL_NOW
		.",'".$t."'"
		.",".SQL_NOW
		.",'0000-00-00 00:00:00'"
		.",'".(int)$this->visited."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
	}
	function updaterow(){
		global $sql,$DB_R_TABLE_PREFIX;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		if(!$DB_R_TABLE_PREFIX) $DB_R_TABLE_PREFIX=DB_TABLE_PREFIX;
		$sql = "UPDATE `{$DB_R_TABLE_PREFIX}user` SET"
		." `User`='".mysql_real_escape_string($this->user)."'"
		.($this->password ? ",`Password`='".mysql_real_escape_string(call_user_func(esnc_passwd_encode,$this->password))."'" : '')
		.",`Name`='".mysql_real_escape_string($this->name)."'"
		.",`Email`='".mysql_real_escape_string($this->email)."'"
		.",`Gender`='".(int)$this->gender."'"
		.",`Birthday`='".mysql_format_date($this->birthday)."'"
		.",`Address`='".mysql_real_escape_string($this->address)."'"
		.",`CityID`='".mysql_real_escape_string($this->cityid)."'"
		.",`City`='".mysql_real_escape_string($this->city)."'"
		.",`Phone`='".mysql_real_escape_string($this->phone)."'"
		.",`Mobile`='".mysql_real_escape_string($this->mobile)."'"
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`Alert`='".(int)$this->alert."'"
		.",`Online`='".(int)$this->online."'"
		.",`Expired`='".mysql_format_datetime($this->expired)."'"
		.",`LastUpdate`=".SQL_NOW
		." WHERE `id` = {$this->id}";
//		echo $sql;
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql,$DB_R_TABLE_PREFIX;
		if(!$DB_R_TABLE_PREFIX) $DB_R_TABLE_PREFIX=DB_TABLE_PREFIX;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `user`  ,`password` , `name`, `email`, `gender`,DATE_FORMAT(`birthday`,'".FORMAT_DB_DATE."') as `birthday`, `address`, `cityid`, `city`, `phone`, `mobile`, `ctrl`, `alert`, `online`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`expired`,'".FORMAT_DB_DATETIME."') as `expired`,DATE_FORMAT(`lastupdate`,'".FORMAT_DB_DATETIME."') as `lastupdate`,DATE_FORMAT(`lastlogin`,'".FORMAT_DB_DATETIME."') as `lastlogin`, `visited` FROM `{$DB_R_TABLE_PREFIX}user` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->user = (string)$row['user'];
		$this->password = (string)$row['password'];
		$this->name = (string)$row['name'];
		$this->email = (string)$row['email'];
		$this->gender = (int)$row['gender'];
		$this->birthday = (string)$row['birthday'];
		$this->address = (string)$row['address'];
		$this->cityid = (string)$row['cityid'];
		$this->city = (string)$row['city'];
		$this->phone = (string)$row['phone'];
		$this->mobile = (string)$row['mobile'];
		$this->ctrl = (int)$row['ctrl'];
		$this->alert = (int)$row['alert'];
		$this->online = (int)$row['online'];
		$this->created = (string)$row['created'];
		$this->expired = (string)$row['expired'];
		$this->lastupdate = (string)$row['lastupdate'];
		$this->lastlogin = (string)$row['lastlogin'];
		$this->visited = (int)$row['visited'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql,$DB_R_TABLE_PREFIX;
		if(!$DB_R_TABLE_PREFIX) $DB_R_TABLE_PREFIX=DB_TABLE_PREFIX;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `user` /*, `password` */, `name`, `email`, `gender`,DATE_FORMAT(`birthday`,'".FORMAT_DB_DATE."') as `birthday`, `address`, `cityid`, `city`, `phone`, `mobile`, `ctrl`, `alert`, `online`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`expired`,'".FORMAT_DB_DATETIME."') as `expired`,DATE_FORMAT(`lastupdate`,'".FORMAT_DB_DATETIME."') as `lastupdate`,DATE_FORMAT(`lastlogin`,'".FORMAT_DB_DATETIME."') as `lastlogin`, `visited` FROM `{$DB_R_TABLE_PREFIX}user` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
}
?>