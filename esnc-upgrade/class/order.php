<?php 
/*if(strpos(URL_SELF,'thangdu') !==FALSE ){
	return include 'd:/wwwroot/mobileworld/class/order.php';
}else {*/
class order{//Phai sua ham addrow va update bo dau phay (,) truoc field dau tien,
	//ham fetch() phai chuyen $_POST['id'] thanh $_GET['id'] va $_POST['ctrl'] thanh @array_sum($_POST['ctrl']);
	var $id,$custid,$code,$seller,$custfirstname,$custlastname,$custcompany,$custaddress,$custgender,$custpostcode,$custzonecode,$custcity,$custprovince,$custcountryid,$custcountry,$custphone,$custmobile,$custfax,$custemail,$custaddressformatid,$shipfrom,$shipvia,$shipinfo,$shiptofirstname,$shiptolastname,$shiptocompany,$shiptoaddress,$shiptogender,$shiptopostcode,$shiptozonecode,$shiptocity,$shiptoprovince,$shiptocountryid,$shiptocountry,$shiptophone,$shiptomobile,$shiptofax,$shiptoemail,$shiptoaddressformatid,$billtofirstname,$billtolastname,$billtocompany,$billtoaddress,$billtogender,$billtopostcode,$billtozonecode,$billtocity,$billtoprovince,$billtocountryid,$billtocountry,$billtophone,$billtomobile,$billtofax,$billtoemail,$billtoaddressformatid,$paymethod,$payinfo,$cardtype,$cardowner,$cardnumber,$cardexpires,$ccv,$currency,$currencyvalue,$value,$expireddate,$begindate,$promotioncode,$status,$tax,$delivereddate,$ip,$created,$modified,$ctrl,$summary;

	function fetch(){

		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->custid=(int)$_POST['custid'];
		$this->code=(string)$_POST['code'];
		$this->seller=(string)$_POST['seller'];
		$this->custtitle=(string)$_POST['custtitle'];
		$this->custfirstname=(string)$_POST['custfirstname'];
		$this->custlastname=(string)$_POST['custlastname'];
		$this->custcompany=(string)$_POST['custcompany'];
		$this->custaddress=(string)$_POST['custaddress'];
		$this->custgender=(int)$_POST['custgender'];
		$this->custpostcode=(string)$_POST['custpostcode'];
		$this->custzonecode=(string)$_POST['custzonecode'];
		$this->custcity=(string)$_POST['custcity'];
		$this->custprovince=(string)$_POST['custprovince'];
		$this->custcountryid=(string)$_POST['custcountryid'];
		$this->custcountry=(string)$_POST['custcountry'];
		$this->custphone=(string)$_POST['custphone'];
		$this->custmobile=(string)$_POST['custmobile'];
		$this->custfax=(string)$_POST['custfax'];
		$this->custemail=(string)$_POST['custemail'];
		$this->custaddressformatid=(int)$_POST['custaddressformatid'];
		$this->shipfrom=(string)$_POST['shipfrom'];
		$this->shipvia=(string)$_POST['shipvia'];
		$this->shipinfo=(string)$_POST['shipinfo'];
		$this->shiptotitle=(string)$_POST['shiptotitle'];
		$this->shiptofirstname=(string)$_POST['shiptofirstname'];
		$this->shiptolastname=(string)$_POST['shiptolastname'];
		$this->shiptocompany=(string)$_POST['shiptocompany'];
		$this->shiptoaddress=(string)$_POST['shiptoaddress'];
		$this->shiptogender=(int)$_POST['shiptogender'];
		$this->shiptopostcode=(string)$_POST['shiptopostcode'];
		$this->shiptozonecode=(string)$_POST['shiptozonecode'];
		$this->shiptocity=(string)$_POST['shiptocity'];
		$this->shiptoprovince=(string)$_POST['shiptoprovince'];
		$this->shiptocountryid=(string)$_POST['shiptocountryid'];
		$this->shiptocountry=(string)$_POST['shiptocountry'];
		$this->shiptophone=(string)$_POST['shiptophone'];
		$this->shiptomobile=(string)$_POST['shiptomobile'];
		$this->shiptofax=(string)$_POST['shiptofax'];
		$this->shiptoemail=(string)$_POST['shiptoemail'];
		$this->shiptoaddressformatid=(int)$_POST['shiptoaddressformatid'];
		$this->shiptotitle=(string)$_POST['billtotitle'];
		$this->billtofirstname=(string)$_POST['billtofirstname'];
		$this->billtolastname=(string)$_POST['billtolastname'];
		$this->billtocompany=(string)$_POST['billtocompany'];
		$this->billtoaddress=(string)$_POST['billtoaddress'];
		$this->billtogender=(int)$_POST['billtogender'];
		$this->billtopostcode=(string)$_POST['billtopostcode'];
		$this->billtozonecode=(string)$_POST['billtozonecode'];
		$this->billtocity=(string)$_POST['billtocity'];
		$this->billtoprovince=(string)$_POST['billtoprovince'];
		$this->billtocountryid=(string)$_POST['billtocountryid'];
		$this->billtocountry=(string)$_POST['billtocountry'];
		$this->billtophone=(string)$_POST['billtophone'];
		$this->billtomobile=(string)$_POST['billtomobile'];
		$this->billtofax=(string)$_POST['billtofax'];
		$this->billtoemail=(string)$_POST['billtoemail'];
		$this->billtoaddressformatid=(int)$_POST['billtoaddressformatid'];
		$this->paymethod=(string)$_POST['paymethod'];
		$this->payinfo=(string)$_POST['payinfo'];
		$this->cardtype=(string)$_POST['cardtype'];
		$this->cardowner=(string)$_POST['cardowner'];
		$this->cardnumber=(string)$_POST['cardnumber'];
		$this->cardexpires=(string)$_POST['cardexpires'];
		$this->ccv=(string)$_POST['ccv'];
		$this->currency=(string)$_POST['currency'];
		$this->currencyvalue=(real)$_POST['currencyvalue'];
		$this->value=(real)$_POST['value'];
		$this->expireddate=(string)$_POST['expireddate'];
		$this->begindate=(string)$_POST['begindate'];
		$this->promotioncode=(string)$_POST['promotioncode'];
		$this->status=(int)$_POST['status'];
		$this->tax=(real)$_POST['tax'];
		$this->delivereddate=(string)$_POST['delivereddate'];
		$this->ip=(string)$_POST['ip'];
		$this->created=(string)$_POST['created'];
		$this->modified=(string)$_POST['modified'];
		$this->ctrl=(int)$_POST['ctrl'];
		$this->summary=(string)$_POST['summary'];
	}
	function addrow(){
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'order`(`custid`,`code`,`seller`,`custtitle`,`custfirstname`,`custlastname`,`custcompany`,'.
		'`custaddress`,`custgender`,`custpostcode`,`custzonecode`,`custcity`,`custprovince`,`custcountryid`,`custcountry`,'.
		'`custphone`,`custmobile`,`custfax`,`custemail`,`custaddressformatid`,`shipfrom`,`shipvia`,`shipinfo`,`shiptotitle`,`shiptofirstname`,'.
		'`shiptolastname`,`shiptocompany`,`shiptoaddress`,`shiptogender`,`shiptopostcode`,`shiptozonecode`,`shiptocity`,'.
		'`shiptoprovince`,`shiptocountryid`,`shiptocountry`,`shiptophone`,`shiptomobile`,`shiptofax`,`shiptoemail`,'.
		'`shiptoaddressformatid`,`billtotitle`,`billtofirstname`,`billtolastname`,`billtocompany`,`billtoaddress`,`billtogender`,`billtopostcode`,'.
		'`billtozonecode`,`billtocity`,`billtoprovince`,`billtocountryid`,`billtocountry`,`billtophone`,`billtomobile`,`billtofax`,'.
		'`billtoemail`,`billtoaddressformatid`,`paymethod`,`payinfo`,`cardtype`,`cardowner`,`cardnumber`,`cardexpires`,`ccv`,`currency`,'.
		'`currencyvalue`,`value`,`expireddate`,`begindate`,`promotioncode`,`status`,`tax`,`delivereddate`,`ip`,`created`,`modified`,`ctrl`,`summary`) '.
		'VALUES ('
		.($this->custid > 0? (int)$this->custid : 'NULL')
		.",'".mysql_real_escape_string($this->code)."'"
		.",'".mysql_real_escape_string($this->seller)."'"
		.",'".mysql_real_escape_string($this->custtitle)."'"
		.",'".mysql_real_escape_string($this->custfirstname)."'"
		.",'".mysql_real_escape_string($this->custlastname)."'"
		.",'".mysql_real_escape_string($this->custcompany)."'"
		.",'".mysql_real_escape_string($this->custaddress)."'"
		.",'".(int)$this->custgender."'"
		.",'".mysql_real_escape_string($this->custpostcode)."'"
		.",'".mysql_real_escape_string($this->custzonecode)."'"
		.",'".mysql_real_escape_string($this->custcity)."'"
		.",'".mysql_real_escape_string($this->custprovince)."'"
		.",'".mysql_real_escape_string($this->custcountryid)."'"
		.",'".mysql_real_escape_string($this->custcountry)."'"
		.",'".mysql_real_escape_string($this->custphone)."'"
		.",'".mysql_real_escape_string($this->custmobile)."'"
		.",'".mysql_real_escape_string($this->custfax)."'"
		.",'".mysql_real_escape_string($this->custemail)."'"
		.",'".(int)$this->custaddressformatid."'"
		.",'".mysql_real_escape_string($this->shipfrom)."'"
		.",'".mysql_real_escape_string($this->shipvia)."'"
		.",'".mysql_real_escape_string($this->shipinfo)."'"
		.",'".mysql_real_escape_string($this->shiptotitle)."'"
		.",'".mysql_real_escape_string($this->shiptofirstname)."'"
		.",'".mysql_real_escape_string($this->shiptolastname)."'"
		.",'".mysql_real_escape_string($this->shiptocompany)."'"
		.",'".mysql_real_escape_string($this->shiptoaddress)."'"
		.",'".(int)$this->shiptogender."'"
		.",'".mysql_real_escape_string($this->shiptopostcode)."'"
		.",'".mysql_real_escape_string($this->shiptozonecode)."'"
		.",'".mysql_real_escape_string($this->shiptocity)."'"
		.",'".mysql_real_escape_string($this->shiptoprovince)."'"
		.",'".mysql_real_escape_string($this->shiptocountryid)."'"
		.",'".mysql_real_escape_string($this->shiptocountry)."'"
		.",'".mysql_real_escape_string($this->shiptophone)."'"
		.",'".mysql_real_escape_string($this->shiptomobile)."'"
		.",'".mysql_real_escape_string($this->shiptofax)."'"
		.",'".mysql_real_escape_string($this->shiptoemail)."'"
		.",'".(int)$this->shiptoaddressformatid."'"
		.",'".mysql_real_escape_string($this->billtotitle)."'"
		.",'".mysql_real_escape_string($this->billtofirstname)."'"
		.",'".mysql_real_escape_string($this->billtolastname)."'"
		.",'".mysql_real_escape_string($this->billtocompany)."'"
		.",'".mysql_real_escape_string($this->billtoaddress)."'"
		.",'".(int)$this->billtogender."'"
		.",'".mysql_real_escape_string($this->billtopostcode)."'"
		.",'".mysql_real_escape_string($this->billtozonecode)."'"
		.",'".mysql_real_escape_string($this->billtocity)."'"
		.",'".mysql_real_escape_string($this->billtoprovince)."'"
		.",'".mysql_real_escape_string($this->billtocountryid)."'"
		.",'".mysql_real_escape_string($this->billtocountry)."'"
		.",'".mysql_real_escape_string($this->billtophone)."'"
		.",'".mysql_real_escape_string($this->billtomobile)."'"
		.",'".mysql_real_escape_string($this->billtofax)."'"
		.",'".mysql_real_escape_string($this->billtoemail)."'"
		.",'".(int)$this->billtoaddressformatid."'"
		.",'".mysql_real_escape_string($this->paymethod)."'"
		.",'".mysql_real_escape_string($this->payinfo)."'"
		.",'".mysql_real_escape_string($this->cardtype)."'"
		.",'".mysql_real_escape_string($this->cardowner)."'"
		.",'".mysql_real_escape_string($this->cardnumber)."'"
		.",'".mysql_format_datetime($this->cardexpires)."'"
		.",'".mysql_real_escape_string($this->ccv)."'"
		.",'".mysql_real_escape_string($this->currency)."'"
		.",".(real)$this->currencyvalue	
		.",".(real)$this->value	
		.",'".mysql_format_datetime($this->expireddate)."'"
		.",'".mysql_format_datetime($this->begindate)."'"
		.",'".mysql_real_escape_string($this->promotioncode)."'"
		.",'".(int)$this->status."'"
		.",".(real)$this->tax	
		.",'".mysql_format_datetime($this->delivereddate)."'"
		.",'".mysql_real_escape_string($this->ip? $this->ip: $_SERVER['REMOTE_ADDR'])."'"
		.",".SQL_NOW
		.",".SQL_NOW
		.",'".(int)$this->ctrl."'"
		.",'".mysql_real_escape_string($this->summary)."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
		_trace(mysql_error());
	}
	function updaterow(){
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);		
		settype($this->id,'int');
		$sql = "SELECT `id`, `custid`, `code`, `seller`,`custtitle`, `custfirstname`, `custlastname`, `custcompany`, `custaddress`, `custgender`, ".
		"`custpostcode`, `custzonecode`, `custcity`, `custprovince`, `custcountryid`, `custcountry`, `custphone`, `custmobile`, ".
		"`custfax`, `custemail`, `custaddressformatid`, `shipfrom`, `shipvia`, `shipinfo`,`shiptotitle`, `shiptofirstname`, `shiptolastname`, ".
		"`shiptocompany`, `shiptoaddress`, `shiptogender`, `shiptopostcode`, `shiptozonecode`, `shiptocity`, `shiptoprovince`, ".
		"`shiptocountryid`, `shiptocountry`, `shiptophone`, `shiptomobile`, `shiptofax`, `shiptoemail`, `shiptoaddressformatid`, ".
		"`billtotitle`,`billtofirstname`, `billtolastname`, `billtocompany`, `billtoaddress`, `billtogender`, `billtopostcode`, `billtozonecode`, ".
		"`billtocity`, `billtoprovince`, `billtocountryid`, `billtocountry`, `billtophone`, `billtomobile`, `billtofax`, `billtoemail`, ".
		"`billtoaddressformatid`, `paymethod`, `payinfo`, `cardtype`, `cardowner`, `cardnumber`,DATE_FORMAT(`cardexpires`,'".FORMAT_DB_DATETIME."') as `cardexpires`, ".
		"`ccv`, `currency`, `currencyvalue`, `value`,DATE_FORMAT(`expireddate`,'".FORMAT_DB_DATETIME."') as `expireddate`,".
		"DATE_FORMAT(`begindate`,'".FORMAT_DB_DATETIME."') as `begindate`, `promotioncode`, `status`, `tax`,".
		"DATE_FORMAT(`delivereddate`,'".FORMAT_DB_DATETIME."') as `delivereddate`, `ip`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,".
		"DATE_FORMAT(`modified`,'".FORMAT_DB_DATETIME."') as `modified`, `ctrl`, `summary` ".
		"FROM `".DB_TABLE_PREFIX."order` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->custid = (int)$row['custid'];
		$this->code = (string)$row['code'];
		$this->seller = (string)$row['seller'];
		$this->custtitle = (string)$row['custtitle'];
		$this->custfirstname = (string)$row['custfirstname'];
		$this->custlastname = (string)$row['custlastname'];
		$this->custcompany = (string)$row['custcompany'];
		$this->custaddress = (string)$row['custaddress'];
		$this->custgender = (int)$row['custgender'];
		$this->custpostcode = (string)$row['custpostcode'];
		$this->custzonecode = (string)$row['custzonecode'];
		$this->custcity = (string)$row['custcity'];
		$this->custprovince = (string)$row['custprovince'];
		$this->custcountryid = (string)$row['custcountryid'];
		$this->custcountry = (string)$row['custcountry'];
		$this->custphone = (string)$row['custphone'];
		$this->custmobile = (string)$row['custmobile'];
		$this->custfax = (string)$row['custfax'];
		$this->custemail = (string)$row['custemail'];
		$this->custaddressformatid = (int)$row['custaddressformatid'];
		$this->shipfrom = (string)$row['shipfrom'];
		$this->shipvia = (string)$row['shipvia'];
		$this->shipinfo = (string)$row['shipinfo'];
		$this->shiptotitle = (string)$row['shiptotitle'];
		$this->shiptofirstname = (string)$row['shiptofirstname'];
		$this->shiptolastname = (string)$row['shiptolastname'];
		$this->shiptocompany = (string)$row['shiptocompany'];
		$this->shiptoaddress = (string)$row['shiptoaddress'];
		$this->shiptogender = (int)$row['shiptogender'];
		$this->shiptopostcode = (string)$row['shiptopostcode'];
		$this->shiptozonecode = (string)$row['shiptozonecode'];
		$this->shiptocity = (string)$row['shiptocity'];
		$this->shiptoprovince = (string)$row['shiptoprovince'];
		$this->shiptocountryid = (string)$row['shiptocountryid'];
		$this->shiptocountry = (string)$row['shiptocountry'];
		$this->shiptophone = (string)$row['shiptophone'];
		$this->shiptomobile = (string)$row['shiptomobile'];
		$this->shiptofax = (string)$row['shiptofax'];
		$this->shiptoemail = (string)$row['shiptoemail'];
		$this->shiptoaddressformatid = (int)$row['shiptoaddressformatid'];
		$this->billtotitle = (string)$row['billtotitle'];
		$this->billtofirstname = (string)$row['billtofirstname'];
		$this->billtolastname = (string)$row['billtolastname'];
		$this->billtocompany = (string)$row['billtocompany'];
		$this->billtoaddress = (string)$row['billtoaddress'];
		$this->billtogender = (int)$row['billtogender'];
		$this->billtopostcode = (string)$row['billtopostcode'];
		$this->billtozonecode = (string)$row['billtozonecode'];
		$this->billtocity = (string)$row['billtocity'];
		$this->billtoprovince = (string)$row['billtoprovince'];
		$this->billtocountryid = (string)$row['billtocountryid'];
		$this->billtocountry = (string)$row['billtocountry'];
		$this->billtophone = (string)$row['billtophone'];
		$this->billtomobile = (string)$row['billtomobile'];
		$this->billtofax = (string)$row['billtofax'];
		$this->billtoemail = (string)$row['billtoemail'];
		$this->billtoaddressformatid = (int)$row['billtoaddressformatid'];
		$this->paymethod = (string)$row['paymethod'];
		$this->payinfo = (string)$row['payinfo'];

		$this->cardtype = (string)$row['cardtype'];
		$this->cardowner = (string)$row['cardowner'];
		$this->cardnumber = (string)$row['cardnumber'];
		$this->cardexpires = (string)$row['cardexpires'];
		$this->ccv = (string)$row['ccv'];
		$this->currency = (string)$row['currency'];
		$this->currencyvalue = (real)$row['currencyvalue'];
		$this->value = (real)$row['value'];
		$this->expireddate = (string)$row['expireddate'];
		$this->begindate = (string)$row['begindate'];
		$this->promotioncode = (string)$row['promotioncode'];
		$this->status = (int)$row['status'];
		$this->tax = (real)$row['tax'];
		$this->delivereddate = (string)$row['delivereddate'];
		$this->ip = (string)$row['ip'];
		$this->created = (string)$row['created'];
		$this->modified = (string)$row['modified'];
		$this->ctrl = (int)$row['ctrl'];
		$this->summary = (string)$row['summary'];
		_trace($sql);
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `custid`, `code`, `seller`, `custfirstname`,`custtitle`, `custlastname`, `custcompany`, `custaddress`, `custgender`, ".
				"`custpostcode`, `custzonecode`, `custcity`, `custprovince`, `custcountryid`, `custcountry`, `custphone`, `custmobile`, ".
				"`custfax`, `custemail`, `custaddressformatid`, `shipfrom`, `shipvia`, `shipinfo`,`shiptotitle`, `shiptofirstname`, `shiptolastname`, ".
				"`shiptocompany`, `shiptoaddress`, `shiptogender`, `shiptopostcode`, `shiptozonecode`, `shiptocity`, `shiptoprovince`, ".
				"`shiptocountryid`, `shiptocountry`, `shiptophone`, `shiptomobile`, `shiptofax`, `shiptoemail`, `shiptoaddressformatid`, ".
				"`billtotitle`,`billtofirstname`, `billtolastname`, `billtocompany`, `billtoaddress`, `billtogender`, `billtopostcode`, `billtozonecode`, ".
				"`billtocity`, `billtoprovince`, `billtocountryid`, `billtocountry`, `billtophone`, `billtomobile`, `billtofax`, `billtoemail`, ".
				"`billtoaddressformatid`, `paymethod`, `payinfo`, `cardtype`, `cardowner`, `cardnumber`,DATE_FORMAT(`cardexpires`,'".FORMAT_DB_DATETIME."') as `cardexpires`, ".
				"`ccv`, `currency`, `currencyvalue`, `value`,DATE_FORMAT(`expireddate`,'".FORMAT_DB_DATETIME."') as `expireddate`,DATE_FORMAT(`begindate`,'".FORMAT_DB_DATETIME."') as `begindate`, ".
				"`promotioncode`, `status`, `tax`,DATE_FORMAT(`delivereddate`,'".FORMAT_DB_DATETIME."') as `delivereddate`, `ip`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`modified`,'".FORMAT_DB_DATETIME."') as `modified`, `ctrl`, `summary`".
				"FROM `".DB_TABLE_PREFIX."order` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
}
//}
?>
