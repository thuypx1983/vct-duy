<?php class agent{//Phai sua ham addrow va update bo dau phay (,) truoc field dau tien,
	//ham fetch() phai chuyen $_POST['id'] thanh $_GET['id'] va $_POST['ctrl'] thanh @array_sum($_POST['ctrl']);
	var $id,$code,$name,$address,$cityid,$city,$detail,$phone,$img,$alt,$contact,$email,$contactphone,$ctrl,$type,$website,$fax,$countryid,$country,$view,$urlrewrite;

	function fetch(){

		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->code=(string)$_POST['code'];
		$this->name=(string)$_POST['name'];
		$this->urlrewrite=(string)$_POST['urlrewrite'];
		$this->address=(string)$_POST['address'];
		$this->cityid=(string)$_POST['cityid'];
		$this->city=(string)$_POST['city'];
		$this->detail=(string)$_POST['detail'];
		$this->phone=(string)$_POST['phone'];
		$this->img=(string)$_POST['img'];
		$this->alt=(string)$_POST['alt'];
		$this->contact=(string)$_POST['contact'];
		$this->email=(string)$_POST['email'];
		$this->contactphone=(string)$_POST['contactphone'];
		$this->ctrl=(int)array_sum(@$_POST['ctrl']);
		$this->type=(int)$_POST['type'];
		$this->website=(string)$_POST['website'];
		$this->fax=(string)$_POST['fax'];
		$this->countryid=(string)$_POST['countryid'];
		$this->country=(string)$_POST['country'];
		$this->view=(int)$_POST['view'];
	}
	function addrow(){
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'agent`(`code`,`name`,`urlrewrite`,`address`,`cityid`,`city`,`detail`,`phone`,`img`,`alt`,`contact`,`email`,`contactphone`,`ctrl`,`type`,`website`,`fax`,`countryid`,`country`,`view`) VALUES ('
		." '".mysql_real_escape_string($this->code)."'"
		.",'".mysql_real_escape_string($this->name)."'"
		.",'".mysql_real_escape_string($this->urlrewrite)."'"
		.",'".mysql_real_escape_string($this->address)."'"
		.",'".mysql_real_escape_string($this->cityid)."'"
		.",'".mysql_real_escape_string($this->city)."'"
		.",'".mysql_real_escape_string($this->detail)."'"
		.",'".mysql_real_escape_string($this->phone)."'"
		.",'".mysql_real_escape_string($this->img)."'"
		.",'".mysql_real_escape_string($this->alt)."'"
		.",'".mysql_real_escape_string($this->contact)."'"
		.",'".mysql_real_escape_string($this->email)."'"
		.",'".mysql_real_escape_string($this->contactphone)."'"
		.",'".(int)$this->ctrl."'"
		.",'".(int)$this->type."'"
		.",'".mysql_real_escape_string($this->website)."'"
		.",'".mysql_real_escape_string($this->fax)."'"
		.",'".mysql_real_escape_string($this->countryid)."'"
		.",'".mysql_real_escape_string($this->country)."'"
		.",'".(int)$this->view."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
		_trace($sql);
		_trace(mysql_error());
	}
	function updaterow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."agent` SET"
		." `Code`='".mysql_real_escape_string($this->code)."'"
		.",`Name`='".mysql_real_escape_string($this->name)."'"
		.",`Urlrewrite`='".mysql_real_escape_string($this->urlrewrite)."'"
		.",`Address`='".mysql_real_escape_string($this->address)."'"
		.",`CityID`='".mysql_real_escape_string($this->cityid)."'"
		.",`City`='".mysql_real_escape_string($this->city)."'"
		.",`Detail`='".mysql_real_escape_string($this->detail)."'"
		.",`Phone`='".mysql_real_escape_string($this->phone)."'"
		.",`Img`='".mysql_real_escape_string($this->img)."'"
		.",`Alt`='".mysql_real_escape_string($this->alt)."'"
		.",`Contact`='".mysql_real_escape_string($this->contact)."'"
		.",`Email`='".mysql_real_escape_string($this->email)."'"
		.",`ContactPhone`='".mysql_real_escape_string($this->contactphone)."'"
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`Type`='".(int)$this->type."'"
		.",`Website`='".mysql_real_escape_string($this->website)."'"
		.",`Fax`='".mysql_real_escape_string($this->fax)."'"
		.",`CountryId`='".mysql_real_escape_string($this->countryid)."'"
		.",`Country`='".mysql_real_escape_string($this->country)."'"
		.",`View`='".(int)$this->view."'"
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `code`, `name`, `urlrewrite`, `address`, `cityid`, `city`, `detail`, `phone`, `img`, `alt`, `contact`, `email`, `contactphone`, `ctrl`, `type`, `website`, `fax`, `countryid`, `country`, `view` FROM `".DB_TABLE_PREFIX."agent` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->code = (string)$row['code'];
		$this->name = (string)$row['name'];
		$this->urlrewrite = (string)$row['urlrewrite'];
		$this->address = (string)$row['address'];
		$this->cityid = (string)$row['cityid'];
		$this->city = (string)$row['city'];
		$this->detail = (string)$row['detail'];
		$this->phone = (string)$row['phone'];
		$this->img = (string)$row['img'];
		$this->alt = (string)$row['alt'];
		$this->contact = (string)$row['contact'];
		$this->email = (string)$row['email'];
		$this->contactphone = (string)$row['contactphone'];
		$this->ctrl = (int)$row['ctrl'];
		$this->type = (int)$row['type'];
		$this->website = (string)$row['website'];
		$this->fax = (string)$row['fax'];
		$this->countryid = (string)$row['countryid'];
		$this->country = (string)$row['country'];
		$this->view = (int)$row['view'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow($id){
		global $sql;
		_trace(__FUNCTION__);
		settype($id,'int');
		$sql = "SELECT `id`, `code`, `name`, `urlrewrite`, `address`, `cityid`, `city`, `detail`, `phone`, `img`, `alt`, `contact`, `email`, `contactphone`, `ctrl`, `type`, `website`, `fax`, `countryid`, `country`, `view`, `password` FROM `".DB_TABLE_PREFIX."agent` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	function fetchex(){

		_trace(__FUNCTION__);
		$this->id=(int)$_GET['AGid'];
		$this->code=(string)$_POST['AGcode'];
		$this->name=(string)$_POST['AGname'];
//		$this->urlrewrite=(string)$_POST['AGurlrewrite'];
		$this->address=(string)$_POST['AGaddress'];
		$this->cityid=(string)$_POST['AGcityid'];
		$this->city=(string)$_POST['AGcity'];
		$this->detail=(string)$_POST['AGdetail'];
		$this->phone=(string)$_POST['AGphone'];
		$this->img=(string)$_POST['AGimg'];
		$this->alt=(string)$_POST['AGalt'];
		$this->contact=(string)$_POST['AGcontact'];
		$this->email=(string)$_POST['AGemail'];
		$this->contactphone=(string)$_POST['AGcontactphone'];
		$this->ctrl=(int)array_sum(@$_POST['AGctrl']);
		$this->type=(int)$_POST['AGtype'];
		$this->website=(string)$_POST['AGwebsite'];
		$this->fax=(string)$_POST['AGfax'];
		$this->countryid=(string)$_POST['AGcountryid'];
		$this->country=(string)$_POST['AGcountry'];
		$this->view=(int)$_POST['AGview'];
	}
	function register(){
		
	}
	function update(){
	}
}
?>