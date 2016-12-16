<?php //module guide
//define classes:catlinkexchange,linkexchange,linkexchangeuser
//define functions:catlinkexchangelist,linkexchangelist
?>
<?php //tienpd@esnadvanced.com
//--------module config--------
define('CATLINKEXCHANGE_CTRL_SHOW',1);
define('LINKEXCHANGE_CTRL_SHOW',1);
define('CATLINKEXCHANGE_CTRL_SHOW',	0x00000001);
$CATLINKEXCHANGE_CTRL=array(
	CATLINKEXCHANGE_CTRL_SHOW=>'Hien thi',
);
?>
<?php
class ctrl_object{
	var $ID;
	var $arr_ctrl_name;
	var $cssClass;
	var $text_set,$text_unset;
	var $text_ok,$text_cancel;	
	var $showHeader,$showFooter;
	function ctrl_object(){}
	function validData(){
		if($this->ID==NULL)return false;
		if(!is_array($this->arr_ctrl_name))return false;
		if(($this->cssClass==NULL)||($this->cssClass==''))$this->cssClass='listctrl';
		if(($this->text_set==NULL)||($this->text_set==''))$this->text_set='Set';
		if(($this->text_unset==NULL)||($this->text_unset==''))$this->text_unset='Unset';
		if(($this->text_ok==NULL)||($this->text_ok==''))$this->text_ok='Ok';
		if(($this->text_cancel==NULL)||($this->text_cancel==''))$this->text_cancel='Cancel';				
		if($this->showHeader==NULL)$this->showHeader=true;
		if($this->showFooter==NULL)$this->showFooter=true;		
		return true;
	}
	function show(){
		if($this->validData()==false)return;
		echo '<div id="'.$this->ID.'" class="'.$this->cssClass.'">';
		echo '<table width="100%" border="1px" cellpadding="2px" cellspacing="0px">';
		if($this->showHeader)echo '<thead><tr><td>&nbsp;</td><td style="text-align:center;">'.$this->text_set.'</td><td style="text-align:center;">'.$this->text_unset.'</td></tr></thead>';
		$idx=0;
		$temp = $this->arr_ctrl_name;
		while(list($i,$val) = each($temp)){
			echo '<tr><td><div class="ctrl ctrl_'.$i.'">&nbsp;</div>'.$val.'</td><td style="text-align:center;"><input name="ck_set[]" id="'.$i.'" value="'.$i.'" onclick="setcheck('.$idx.');" type="checkbox" /></td><td style="text-align:center;"><input name="ck_unset[]" id="'.$i.'" value="'.$i.'" onclick="unsetcheck('.$idx.');" type="checkbox" /></td></tr>';
			$idx++;
		}
		if($this->showFooter)echo '<tr><td>&nbsp;</td><td style="text-align:center;"><input type="submit" class="button" name="ACT_SET" value="'.$this->text_ok.'" /></td><td style="text-align:center;"><input type="button" class="button" value="'.$this->text_cancel.'" onclick="showObject(\'listctrl\')" /></td></tr>';
		echo '</table>';
		echo '</div>';		
	}
}
class catlinkexchange{
	public static function get_type($id){
		global $sql;
		if(is_int($id)){
			$sql = "SELECT `id` FROM `".DB_TABLE_PREFIX."catlinkexchange` WHERE `parentid`=".$id;
			mysql_query($sql);
			if(mysql_affected_rows()>0){
				return 0;
			}else{		
				$sql = "SELECT `linkexchangeid` FROM `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` WHERE `catlinkexchangeid`=".$id;
				mysql_query($sql);
				if(mysql_affected_rows()>0){
					return 1;
				}else{
					return NULL;
				}
			}
			mysql_free_result();
		}else{
			return -1;
		}
	}
	public static function listitem($ctrl=NULL,$parentid=NULL,$top=100000,$view=NULL,$hint=NULL){
		global $sql;
		if((is_int($ctrl))&&($ctrl<0)) {
			$sql= (!is_int($parentid)) ? 
				"SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid` FROM `".DB_TABLE_PREFIX."catlinkexchange` as `a` WHERE `a`.`ctrl` & {$ctrl} = {$ctrl} AND `a`.`parentid` IS NULL ORDER BY `a`.`view`,`a`.`id` LIMIT {$top}"
			   :"SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid` FROM `".DB_TABLE_PREFIX."catlinkexchange` as `a` WHERE `a`.`ctrl` & {$ctrl} = {$ctrl} AND `a`.`parentid` = {$parentid} ORDER BY `a`.`view`,`a`.`id` LIMIT {$top}";
			return mysql_query($sql);
		}else{
			$sql= (!is_int($parentid)) ? 
				"SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid` FROM `".DB_TABLE_PREFIX."catlinkexchange` as `a` WHERE `a`.`parentid` IS NULL ORDER BY `a`.`view`,`a`.`id` LIMIT {$top}"
			   :"SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid` FROM `".DB_TABLE_PREFIX."catlinkexchange` as `a` WHERE `a`.`parentid` = {$parentid} ORDER BY `a`.`view`,`a`.`id` LIMIT {$top}";
			return mysql_query($sql);
		}
	}
	public static function open($id){
		global $sql;
		$o=NULL;
		if(is_int($id)){
			$sql = 'SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`view`,`a`.`desc`,`a`.`parentid` FROM `'.DB_TABLE_PREFIX.'catlinkexchange` as `a` WHERE `id`='.(int)$id;
			$o = mysql_fetch_object($rs = mysql_query($sql));
			mysql_free_result($rs);  // ????
		}
		return $o;
	}

	var $id,$parentid,$name,$desc,$view,$ctrl,$img1,$alt1,$extra;
	function catlinkexchange(){}
	function addrow(){
		global $sql;
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'catlinkexchange`(`parentid`,`name`,`desc`,`view`,`ctrl`,`img1`,`alt1`,`extra`) VALUES ('
		.($this->parentid > 0 ? $this->parentid: 'NULL')
		.",'".mysql_real_escape_string($this->name)."'"
		.",'".mysql_real_escape_string($this->desc)."'"
		.",'".(int)$this->view."'"
		.",'".(int)$this->ctrl."'"
		.",'".mysql_real_escape_string($this->img1)."'"
		.",'".mysql_real_escape_string($this->alt1)."'"
		.",'".mysql_real_escape_string($this->extra)."'"
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
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."catlinkexchange` SET"
		." `ParentID`=".($this->parentid > 0 ? $this->parentid: 'NULL')
		.",`Name`='".mysql_real_escape_string($this->name)."'"
		.",`Desc`='".mysql_real_escape_string($this->desc)."'"
		.",`View`='".(int)$this->view."'"
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`Img1`='".mysql_real_escape_string($this->img1)."'"
		.",`Alt1`='".mysql_real_escape_string($this->alt1)."'"
		.",`Extra`='".mysql_real_escape_string($this->extra)."'"
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		settype($this->id,'int');
		$sql = "SELECT `id`, `parentid`, `name`, `desc`, `view`, `ctrl`, `img1`, `alt1`, `extra` FROM `".DB_TABLE_PREFIX."catlinkexchange` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->parentid = (int)$row['parentid'];
		$this->name = (string)$row['name'];
		$this->desc = (string)$row['desc'];
		$this->view = (int)$row['view'];
		$this->ctrl = (int)$row['ctrl'];
		$this->img1 = (string)$row['img1'];
		$this->alt1 = (string)$row['alt1'];
		$this->extra = (string)$row['extra'];
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		settype($this->id,'int');
		$sql = "SELECT `id`, `parentid`, `name`, `desc`, `view`, `ctrl`, `img1`, `alt1`, `extra` FROM `".DB_TABLE_PREFIX."catlinkexchange` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	function deleterow(){
		global $sql;
		settype($this->id,'int');
		$type = catlinkexchange::get_type($this->id);
		if($type===NULL){
			$sql = "DELETE FROM `".DB_TABLE_PREFIX."catlinkexchange` WHERE `id` = {$this->id}; ";
			mysql_query($sql);
		}
	}
}
?>
<?php 
class linkexchange{
	public static function listitem($ctrl=NULL,$catid=NULL,$top=NULL){
		global $sql;
		if($ctrl!=NULL){
			if(!is_int($ctrl)) return FALSE;
			if(is_int($catid)) $tbcat = " INNER JOIN `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` as `b` ON `a`.`id` = `b`.`linkexchangeid` AND `b`.`catlinkexchangeid` = {$catid}";else $tbcat='';
			$wh = " WHERE `a`.`ctrl` & {$ctrl} = {$ctrl}";
			if(is_int($top)) $lm = " LIMIT {$top}";else $lm="";
			$sql="SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`url`,`a`.`src`,`a`.`desc`,`a`.`created`,`a`.`lastupdate`,`a`.`view`,`a`.`ctrl` FROM `".DB_TABLE_PREFIX."linkexchange` as `a` {$tbcat} {$wh} ORDER BY `a`.`view` ASC {$lm}";
		}else{
			if(is_int($catid)) $tbcat = " INNER JOIN `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` as `b` ON `a`.`id` = `b`.`linkexchangeid` AND `b`.`catlinkexchangeid` = {$catid}";else $tbcat='';
			$wh = "";
			if(is_int($top)) $lm = " LIMIT {$top}";else $lm="";
			$sql="SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`url`,`a`.`src`,`a`.`desc`,`a`.`created`,`a`.`lastupdate`,`a`.`view`,`a`.`ctrl` FROM `".DB_TABLE_PREFIX."linkexchange` as `a` {$tbcat} {$wh} ORDER BY `a`.`view` ASC {$lm}";
		}
		return mysql_query($sql);
	}
	public static function pagelist(&$page,&$pagecount,$pagesize=100,$catid=NULL,$ctrl=NULL){
		global $sql,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND;
		if(is_int($catid))
			$tbcat = ' INNER JOIN `'.DB_TABLE_PREFIX.'catlinkexchangelinkexchange` as `b` ON `a`.`id`=`b`.`linkexchangeid` AND `b`.`catlinkexchangeid` = '.$catid;
		else 
			$tbcat = '';
		if(is_int($ctrl) && $ctrl){
			$wh = ' WHERE `a`.`ctrl` & '.$ctrl.'='.$ctrl;
		}else
			$wh = '';
		if($page <1) $page=1;
		$ESNC_ROWSTART=($page-1) * $pagesize;
		if(!is_int($pagesize) || $pagesize < 1)
			trigger_error('Tham s&#7889; pagesize ph&#7843;i l&agrave; m&#7897;t s&#7889; nguy&ecirc;n &gt; 0',E_USER_ERROR);
		$sql = 'SELECT SQL_CALC_FOUND_ROWS DISTINCT `a`.`id`,`a`.`name`,`a`.`url`,`a`.`src`,`a`.`desc`,`a`.`created`,`a`.`lastupdate`,`a`.`view`,`a`.`ctrl`
	FROM `'.DB_TABLE_PREFIX.'linkexchange` as `a`'.$tbcat.$wh. ' ORDER BY `a`.`view` ASC,`a`.`ID` ASC LIMIT '.$ESNC_ROWSTART.','.$pagesize;
		_trace($sql);
		$rs = mysql_query($sql);
		$sql = 'SELECT FOUND_ROWS()';
		$rs1 = mysql_query($sql);
		$row = mysql_fetch_row($rs1);
		$ESNC_ROWCOUNT = (int)$row[0];
		$pagecount = (int)ceil($ESNC_ROWCOUNT/$pagesize);
		$ESNC_ROWEND = $ESNC_ROWCOUNT + $pagesize;
		return $rs;
	}
	public static function getcatfield($itemid,$field){
		settype($itemid,'int');
		global $sql;
		$catid = NULL;
		$sql = "SELECT `catlinkexchangeid` FROM `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` WHERE `linkexchangeid` = {$itemid} limit 1";
		$rs = mysql_query($sql);
		if($row = mysql_fetch_assoc($rs))$catid = (int)$row['catlinkexchangeid'];
		mysql_free_result($rs);
		if($catid!=NULL){
			$sql = "SELECT `".$field."` FROM `".DB_TABLE_PREFIX."catlinkexchange` WHERE `id` = {$catid}";
			$rs = mysql_query($sql);
			$row = mysql_fetch_assoc($rs);
			return $row[$field];
		}
		return NULL;
	}
	var $id,$name,$url,$src,$desc,$created,$lastupdate,$view,$ctrl;
	var $a_cat;
	function linkexchange(){}
	function addrow(){
		global $sql;
		if($this->a_cat!=NULL){
			$sql='INSERT INTO `'.DB_TABLE_PREFIX.'linkexchange`(`name`,`url`,`src`,`desc`,`created`,`lastupdate`,`ctrl`) VALUES ('
			."'".mysql_real_escape_string($this->name)."'"
			.",'".mysql_real_escape_string($this->url)."'"
			.",'".mysql_real_escape_string($this->src)."'"
			.",'".mysql_real_escape_string($this->desc)."'"
			.",".SQL_NOW
			.",".SQL_NOW
			.",'".(int)$this->ctrl."'"
			.')';
			if(mysql_query($sql)){
				$this->id = mysql_insert_id();
				$sql='UPDATE `'.DB_TABLE_PREFIX.'linkexchange` SET `view`=`id` WHERE `id`='.$this->id;
				mysql_query($sql);
				$this->addtocat();
				return TRUE;
			}
		}
		return FALSE;
	}
	function updaterow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."linkexchange` SET"
		." `name`='".mysql_real_escape_string($this->name)."'"
		.",`url`='".mysql_real_escape_string($this->url)."'"
		.",`src`='".mysql_real_escape_string($this->src)."'"
		.",`desc`='".mysql_real_escape_string($this->desc)."'"
		.",`view`='".(int)$this->view."'"
		.",`lastupdate`=".SQL_NOW
		.",`ctrl`='".(int)$this->ctrl."'"
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`,`url`,`src`,`desc`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`lastupdate`,'".FORMAT_DB_DATETIME."') as `lastupdate`,`view`,`ctrl` FROM `".DB_TABLE_PREFIX."linkexchange` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->name = (string)$row['name'];
		$this->url = (string)$row['url'];
		$this->src = (string)$row['src'];
		$this->desc = (string)$row['desc'];
		$this->created = (string)$row['created'];
		$this->lastupdate = (string)$row['lastupdate'];		
		$this->view = (int)$row['view'];
		$this->ctrl = (int)$row['ctrl'];
		mysql_free_result($rs);
		$sql = "SELECT `catlinkexchangeid` FROM `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` WHERE `linkexchangeid` = {$this->id}";		
		$rs = mysql_query($sql);
		if(mysql_affected_rows()>0){
			$a_cat = array();
			$i = 0;
			while($row = mysql_fetch_assoc($rs)){
				$a_cat[$i] = (int)$row['catlinkexchangeid'];
				$i = $i+1;
			}
		}
		return TRUE;
	}
	function loadrow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`,`url`,`src`,`desc`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`lastupdate`,'".FORMAT_DB_DATETIME."') as `lastupdate`,`view`,`ctrl` FROM `".DB_TABLE_PREFIX."linkexchange` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	function islinked($desc){
		if(preg_match('/(http:\/\/[^\"\']+)(?:\'|\"|$)/i',$desc,$ss)){
			global $sql;
			$sql = 'SELECT `id` FROM `'.DB_TABLE_PREFIX.'linkexchange` WHERE `url` LIKE \'%'.$ss[1].'%\' OR `desc` LIKE \'%'.$ss[1].'%\' LIMIT 1';
			if(mysql_num_rows($rs=mysql_query($sql))){
				mysql_free_result($rs);
				return TRUE;
			}
		}return FALSE;
	}
	function addtocat(){
		global $sql;
		$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'catlinkexchangelinkexchange` WHERE `linkexchangeid`='.(int)$this->id;
		mysql_query($sql);
		if(is_array($this->a_cat)){
			$sql = 'REPLACE INTO `'.DB_TABLE_PREFIX.'catlinkexchangelinkexchange` (`catlinkexchangeid`,`linkexchangeid`) VALUES ';
			foreach($this->a_cat as $cat)$sql .= '('.(int)$cat.','.$this->id.'),';
			$sql=rtrim($sql,',');
		}else{
			$sql = 'REPLACE INTO `'.DB_TABLE_PREFIX.'catlinkexchangelinkexchange` (`catlinkexchangeid`,`linkexchangeid`) VALUES ('.(int)$this->a_cat.','.$this->id.')';
		}
		return mysql_query($sql);
	}
	function isduplicated(){
		if(preg_match('/http:\/\/([^\"\']+)(?:\'|\"|$)/i',$this->desc.' '.$this->url,$ss)){
			$ss[1]=rtrim($ss[1],'/');
			global $sql;
			$sql = 'SELECT `id` FROM `'.DB_TABLE_PREFIX.'linkexchange` WHERE (`url` LIKE \'%'.$ss[1].'%\' OR `desc` LIKE \'%'.$ss[1].'%\' '.($this->id > 0 ? ') AND `id` <> '.$this->id:')').' LIMIT 1';
			_trace($sql);
			if(mysql_num_rows($rs=mysql_query($sql))){
				mysql_free_result($rs);
				return TRUE;
			}
		}return FALSE;
	}
	function deleterow(){
		global $sql;
		settype($this->id,'int');
		if($type===NULL){
			$sql = "DELETE FROM `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` WHERE `linkexchangeid` = {$this->id}; ";
			mysql_query($sql);
			$sql = "DELETE FROM `".DB_TABLE_PREFIX."linkexchange` WHERE `id` = {$this->id}; ";
			mysql_query($sql);
		}
	}
}
?>
<?php 
class linkexchangeuser{
	var $id,$user,$password,$name,$email,$gender,$birthday,$address,$cityid,$city,$phone,$mobile,$ctrl,$alert,$online,$created,$expired,$lastupdate,$lastlogin,$visited;
	function fetch(){
		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->user=(string)$_POST['user'];
		$this->password=(string)$_POST['password'];
		$this->name=(string)$_POST['name'];
		$this->email=(string)$_POST['email'];
		$this->gender=(int)array_sum($_POST['gender']);
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
		$sql='INSERT INTO `'.$DB_R_TABLE_PREFIX.'linkexchangeuser`(`user`,`password`,`name`,`email`,`gender`,`birthday`,`address`,`cityid`,`city`,`phone`,`mobile`,`ctrl`,`alert`,`online`,`created`,`expired`,`lastupdate`,`lastlogin`,`visited`) VALUES ('
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
		$sql = "UPDATE `{$DB_R_TABLE_PREFIX}linkexchangeuser` SET"
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
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql,$DB_R_TABLE_PREFIX;
		if(!$DB_R_TABLE_PREFIX) $DB_R_TABLE_PREFIX=DB_TABLE_PREFIX;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `user`  ,`password` , `name`, `email`, `gender`,DATE_FORMAT(`birthday`,'".FORMAT_DB_DATE."') as `birthday`, `address`, `cityid`, `city`, `phone`, `mobile`, `ctrl`, `alert`, `online`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`expired`,'".FORMAT_DB_DATETIME."') as `expired`,DATE_FORMAT(`lastupdate`,'".FORMAT_DB_DATETIME."') as `lastupdate`,DATE_FORMAT(`lastlogin`,'".FORMAT_DB_DATETIME."') as `lastlogin`, `visited` FROM `{$DB_R_TABLE_PREFIX}linkexchangeuser` WHERE `id` = {$this->id}";
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
		$sql = "SELECT `id`, `user` /*, `password` */, `name`, `email`, `gender`,DATE_FORMAT(`birthday`,'".FORMAT_DB_DATE."') as `birthday`, `address`, `cityid`, `city`, `phone`, `mobile`, `ctrl`, `alert`, `online`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`expired`,'".FORMAT_DB_DATETIME."') as `expired`,DATE_FORMAT(`lastupdate`,'".FORMAT_DB_DATETIME."') as `lastupdate`,DATE_FORMAT(`lastlogin`,'".FORMAT_DB_DATETIME."') as `lastlogin`, `visited` FROM `{$DB_R_TABLE_PREFIX}linkexchangeuser` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	function checkaccess($access = 1){
		global $sql;
		if(!$DB_R_TABLE_PREFIX) $DB_R_TABLE_PREFIX=DB_TABLE_PREFIX;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		settype($access,'int');
		$sql = "SELECT `id` FROM `{$DB_R_TABLE_PREFIX}linkexchangeuser`  WHERE `email` like '".mysql_real_escape_string($this->email)."' and `password` like '".mysql_real_escape_string($this->password)."' and `ctrl`&{$access}={$access} limit 1";
		$rs=mysql_query($sql);
		if(mysql_affected_rows()>0){
			$row = mysql_fetch_assoc($rs);
			$this->id = (int)$row['id'];
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>
