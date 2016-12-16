<?php
class customer{//Phai sua ham addrow va update bo dau phay (,) truoc field dau tien,
	//ham fetch() phai chuyen $_POST['id'] thanh $_GET['id'] va $_POST['ctrl'] thanh @array_sum($_POST['ctrl']);
	var $id,$code,$firstname,$lastname,$email,$password,$type,$organ,$gender,$birthdate,$birthplace,$address,$cityid,$city,$countryid,$country,$phone,$mobile,$fax,$created,$modified,$lastlogon,$ctrl,$visited,$summary,$addressformatid;

	function fetch(){

		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->code=(string)$_POST['code'];
		$this->title=(string)$_POST['title'];
		$this->firstname=(string)$_POST['firstname'];
		$this->lastname=(string)$_POST['lastname'];
		$this->email=(string)$_POST['email'];
		$this->password=(string)$_POST['password'];
		if($this->password{0} == '*') $this->password='';
		$this->type=(int)$_POST['type'];
		$this->organ=(string)$_POST['organ'];
		$this->gender=(int)@array_sum($_POST['gender']);
		$this->birthdate=(string)$_POST['birthdate'];
		$this->birthplace=(string)$_POST['birthplace'];
		$this->address=(string)$_POST['address'];
		$this->cityid=(string)$_POST['cityid'];
		$this->city=(string)$_POST['city'];
		$this->countryid=(string)$_POST['countryid'];
		$this->country=(string)$_POST['country'];
		$this->phone=(string)$_POST['phone'];
		$this->mobile=(string)$_POST['mobile'];
		$this->fax=(string)$_POST['fax'];
		$this->created=(string)$_POST['created'];
		$this->modified=(string)$_POST['modified'];
		$this->lastlogon=(string)$_POST['lastlogon'];
		$this->ctrl=(int)@array_sum($_POST['ctrl']);
		$this->visited=(int)$_POST['visited'];
		$this->summary=(string)$_POST['summary'];
		$this->addressformatid=(int)$_POST['addressformatid'];
	}
	function addrow(){
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'customer`(`code`,`title`,`firstname`,`lastname`,`email`,`password`,`type`,`organ`,`gender`,`birthdate`,`birthplace`,`address`,`cityid`,`city`,`countryid`,`country`,`phone`,`mobile`,`fax`,`created`,`modified`,`ctrl`,`visited`,`summary`,`addressformatid`,`agentid`) VALUES ('
		." '".mysql_real_escape_string($this->code)."'"
		.", '".mysql_real_escape_string($this->title)."'"
		.",'".mysql_real_escape_string($this->firstname)."'"
		.",'".mysql_real_escape_string($this->lastname)."'"
		.",'".mysql_real_escape_string($this->email)."'"
		.",'".mysql_real_escape_string(call_user_func(esnc_passwd_encode,$this->password))."'"
		.",'".(int)$this->type."'"
		.",'".mysql_real_escape_string($this->organ)."'"
		.",'".(int)$this->gender."'"
		.",'".mysql_format_datetime($this->birthdate)."'"
		.",'".mysql_real_escape_string($this->birthplace)."'"
		.",'".mysql_real_escape_string($this->address)."'"
		.",'".mysql_real_escape_string($this->cityid)."'"
		.",'".mysql_real_escape_string($this->city)."'"
		.",'".mysql_real_escape_string($this->countryid)."'"
		.",'".mysql_real_escape_string($this->country)."'"
		.",'".mysql_real_escape_string($this->phone)."'"
		.",'".mysql_real_escape_string($this->mobile)."'"
		.",'".mysql_real_escape_string($this->fax)."'"
		.",".SQL_NOW
		.",".SQL_NOW
		.",'".(int)$this->ctrl."'"
		.",'".(int)$this->visited."'"
		.",'".mysql_real_escape_string($this->summary)."'"
		.",".($this->addressformatid ? (int)$this->addressformatid: 'NULL')
		.",".($this->agentid ? (int)$this->agentid : 'NULL')
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
		_trace(mysql_error());
		_trace($sql);
	}
	function updaterow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."customer` SET"
		." `Code`='".mysql_real_escape_string($this->code)."'"
		.", `Title`='".mysql_real_escape_string($this->title)."'"
		.",`FirstName`='".mysql_real_escape_string($this->firstname)."'"
		.",`LastName`='".mysql_real_escape_string($this->lastname)."'"
		.",`Email`='".mysql_real_escape_string($this->email)."'"
	//	.",`Password`='".mysql_real_escape_string($this->password)."'"
		.",`Type`='".(int)$this->type."'"
		.",`Organ`='".mysql_real_escape_string($this->organ)."'"
		.",`Gender`='".(int)$this->gender."'"
		.",`BirthDate`='".mysql_format_datetime($this->birthdate)."'"
		.",`BirthPlace`='".mysql_real_escape_string($this->birthplace)."'"
		.",`Address`='".mysql_real_escape_string($this->address)."'"
		.",`CityID`='".mysql_real_escape_string($this->cityid)."'"
		.",`City`='".mysql_real_escape_string($this->city)."'"
		.",`CountryID`='".mysql_real_escape_string($this->countryid)."'"
		.",`Country`='".mysql_real_escape_string($this->country)."'"
		.",`Phone`='".mysql_real_escape_string($this->phone)."'"
		.",`Mobile`='".mysql_real_escape_string($this->mobile)."'"
		.",`Fax`='".mysql_real_escape_string($this->fax)."'"
		.",`Modified`=".SQL_NOW
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`Visited`='".(int)$this->visited."'"
		.",`Summary`='".mysql_real_escape_string($this->summary)."'"
		.",`AddressFormatID`='".(int)$this->addressformatid."'"
		." WHERE `id` = {$this->id}";
		if( mysql_query($sql) ) return TRUE;
		_trace(mysql_error());
		_trace($sql);
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `code`, `title`, `password`, `firstname`, `lastname`, `email`, `type`, `organ`, `gender`,DATE_FORMAT(`birthdate`,'".FORMAT_DB_DATETIME."') as `birthdate`, `birthplace`, `address`, `cityid`, `city`, `countryid`, `country`, `phone`, `mobile`, `fax`,DATE_FORMAT(`created`,'".FORMAT_DB_DATE."') as `created`,DATE_FORMAT(`modified`,'".FORMAT_DB_DATETIME."') as `modified`,DATE_FORMAT(`lastlogon`,'".FORMAT_DB_DATETIME."') as `lastlogon`, `ctrl`, `visited`, `summary`, `addressformatid`,`agentid` FROM `".DB_TABLE_PREFIX."customer` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->code = (string)$row['code'];
		$this->title = (string)$row['title'];
		$this->password = (string)$row['password'];
		$this->firstname = (string)$row['firstname'];
		$this->lastname = (string)$row['lastname'];
		$this->email = (string)$row['email'];
		$this->type = (int)$row['type'];
		$this->organ = (string)$row['organ'];
		$this->gender = (int)$row['gender'];
		$this->birthdate = (string)$row['birthdate'];
		$this->birthplace = (string)$row['birthplace'];
		$this->address = (string)$row['address'];
		$this->cityid = (string)$row['cityid'];
		$this->city = (string)$row['city'];
		$this->countryid = (string)$row['countryid'];
		$this->country = (string)$row['country'];
		$this->phone = (string)$row['phone'];
		$this->mobile = (string)$row['mobile'];
		$this->fax = (string)$row['fax'];
		$this->created = (string)$row['created'];
		$this->modified = (string)$row['modified'];
		$this->lastlogon = (string)$row['lastlogon'];
		$this->ctrl = (int)$row['ctrl'];
		$this->visited = (int)$row['visited'];
		$this->summary = (string)$row['summary'];
		$this->addressformatid = (int)$row['addressformatid'];
		$this->agentid=(int)$row['agentid'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow($id){
		global $sql;
		_trace(__FUNCTION__);
		$sql = "SELECT `id`,`code`, `title`, `firstname`, `lastname`, `email`, `type`, `organ`, `gender`,DATE_FORMAT(`birthdate`,'".FORMAT_DB_DATETIME."') as `birthdate`, `birthplace`, `address`, `cityid`, `city`, `countryid`, `country`, `phone`, `mobile`, `fax`,DATE_FORMAT(`created`,'".FORMAT_DB_DATE."') as `created`,DATE_FORMAT(`modified`,'".FORMAT_DB_DATETIME."') as `modified`,DATE_FORMAT(`lastlogon`,'".FORMAT_DB_DATETIME."') as `lastlogon`, `ctrl`, `visited`, `summary`, `addressformatid` FROM `".DB_TABLE_PREFIX."customer` WHERE `id` = ".(int)$id;
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	function register(){
		global $sql;
		$sql = 'SELECT `id` FROM `'.DB_TABLE_PREFIX.'customer` WHERE LOWER(`email`)=LOWER(\''.mysql_real_escape_string($this->email).'\')';
		if($row=mysql_fetch_row($rs=mysql_query($sql))){
			mysql_free_result($rs);
			_trace('duplicate email address');
			return FALSE;
		}
		return $this->addrow();
	}
	function update(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."customer` SET"
		." `Title`='".mysql_real_escape_string($this->title)."'"
		.",`FirstName`='".mysql_real_escape_string($this->firstname)."'"
		.",`LastName`='".mysql_real_escape_string($this->lastname)."'"
		.",`Type`=".(int)$this->type
		.",`Organ`='".mysql_real_escape_string($this->organ)."'"
		.",`Gender`=".(int)$this->gender
		.($this->password ? ",`Password`='".mysql_real_escape_string(call_user_func(esnc_passwd_encode,$this->password))."'":'')
		.",`BirthDate`='".mysql_format_datetime($this->birthdate)."'"
		.",`BirthPlace`='".mysql_real_escape_string($this->birthplace)."'"
		.",`Address`='".mysql_real_escape_string($this->address)."'"
		.",`CityID`='".mysql_real_escape_string($this->cityid)."'"
		.",`City`='".mysql_real_escape_string($this->city)."'"
		.",`CountryID`='".mysql_real_escape_string($this->countryid)."'"
		.",`Country`='".mysql_real_escape_string($this->country)."'"
		.",`Phone`='".mysql_real_escape_string($this->phone)."'"
		.",`Mobile`='".mysql_real_escape_string($this->mobile)."'"
		.",`Fax`='".mysql_real_escape_string($this->fax)."'"
		.",`Modified`=".SQL_NOW
		.",`Summary`='".mysql_real_escape_string($this->summary)."'"
		.",`AddressFormatID`=".(int)$this->addressformatid
		." WHERE `id` = {$this->id}";
		if( mysql_query($sql) ) return TRUE;
		_trace(mysql_error());
		_trace($sql);
	}
	function fetchex($prefix){
		_trace(__FUNCTION__);
		if(is_array($_POST[$prefix])){
			$P=&$_POST[$prefix];
			$this->id=(int)$P['id'];
			$this->code=(string)$P['code'];
			$this->title=(string)$P['title'];
			$this->firstname=(string)$P['firstname'];
			$this->lastname=(string)$P['lastname'];
			$this->email=(string)$P['email'];
			$this->password=(string)$P['password'];
			if($this->password{0} == '*') $this->password='';
			$this->type=(int)$P['type'];
			$this->organ=(string)$P['organ'];
			$this->gender=(int)@array_sum($P['gender']);
			$this->birthdate=(string)$P['birthdate'];
			$this->birthplace=(string)$P['birthplace'];
			$this->address=(string)$P['address'];
			$this->cityid=(string)$P['cityid'];
			$this->city=(string)$P['city'];
			$this->countryid=(string)$P['countryid'];
			$this->country=(string)$P['country'];
			$this->phone=(string)$P['phone'];
			$this->mobile=(string)$P['mobile'];
			$this->fax=(string)$P['fax'];
			$this->created=(string)$P['created'];
			$this->modified=(string)$P['modified'];
			$this->lastlogon=(string)$P['lastlogon'];
			$this->ctrl=(int)@array_sum($P['ctrl']);
			$this->visited=(int)$P['visited'];
			$this->summary=(string)$P['summary'];
			$this->addressformatid=(int)$P['addressformatid'];			
		}else{
			$this->id=(int)$_GET[$prefix.'id'];
			$this->code=(string)$_POST[$prefix.'code'];
			$this->title=(string)$_POST[$prefix.'title'];
			$this->firstname=(string)$_POST[$prefix.'firstname'];
			$this->lastname=(string)$_POST[$prefix.'lastname'];
			$this->email=(string)$_POST[$prefix.'email'];
			$this->password=(string)$_POST[$prefix.'password'];
			if($this->password{0} == '*') $this->password='';
			$this->type=(int)$_POST[$prefix.'type'];
			$this->organ=(string)$_POST[$prefix.'organ'];
			$this->gender=(int)@array_sum($_POST[$prefix.'gender']);
			$this->birthdate=(string)$_POST[$prefix.'birthdate'];
			$this->birthplace=(string)$_POST[$prefix.'birthplace'];
			$this->address=(string)$_POST[$prefix.'address'];
			$this->cityid=(string)$_POST[$prefix.'cityid'];
			$this->city=(string)$_POST[$prefix.'city'];
			$this->countryid=(string)$_POST[$prefix.'countryid'];
			$this->country=(string)$_POST[$prefix.'country'];
			$this->phone=(string)$_POST[$prefix.'phone'];
			$this->mobile=(string)$_POST[$prefix.'mobile'];
			$this->fax=(string)$_POST[$prefix.'fax'];
			$this->created=(string)$_POST[$prefix.'created'];
			$this->modified=(string)$_POST[$prefix.'modified'];
			$this->lastlogon=(string)$_POST[$prefix.'lastlogon'];
			$this->ctrl=(int)@array_sum($_POST[$prefix.'ctrl']);
			$this->visited=(int)$_POST[$prefix.'visited'];
			$this->summary=(string)$_POST[$prefix.'summary'];
			$this->addressformatid=(int)$_POST[$prefix.'addressformatid'];
		}
	}
}
//}
?>