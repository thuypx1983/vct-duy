<?php /* vinhtx@esnadvanced.com 18-Apr-2006 */
$er = error_reporting(E_ERROR|E_WARNING|E_PARSE);
define('SESSION_CTRL_GUEST',1);//customer session
define('SESSION_CTRL_CUSTOMER',2);//customer session
define('SESSION_CTRL_ADMIN',4);//admin session
define('SESSION_CTRL_SUPPERUSER',8);//supper user session

define('ACCESS_CREATE',1);//allow create
define('ACCESS_READ',2);//allow read 
define('ACCESS_WRITE',4);//allow to full update records, include ACCESS_WRITE_CTRL
define('ACCESS_REMOVE',8);//allow to remove
define('ACCESS_WRITE_CTRL',16);//allow to change control number of records
define('ACCESS_SORT',32);//allow to re-sort items
define('ACCESS_UPLOAD',64);
define('ACCESS_UPLOAD_FILE',ACCESS_UPLOAD);//allow upload file
define('ACCESS_REPORT',0x00000200);
define('ACCESS_DEVELOPPER',0x10000000);
define('ACCESS_OK',FALSE);//default to prevent access
//module definition, default to turn off all module
define('MODULE_ORDER',0);
define('MODULE_PRODUCT',0);
//define('MODULE_RESERVED',0);
define('MODULE_PROMOTION',0);
define('MODULE_NEWS',0);
define('MODULE_UTILITY',0);
define('MODULE_FAQ',0);
define('MODULE_AGENT',0);
define('MODULE_FEEDBACK',0);
define('MODULE_MARKETING',0);
define('MODULE_BANNER',0);
define('MODULE_USER',0);
define('MODULE_POLL',0);
define('MODULE_JOB',0);
define('MODULE_FILE',0);
define('MODULE_SYS',0x00002000);
define('MODULE_MEMBER',0);
define('MODULE_QUOTE',0);
define('MODULE_DEFAULT',0x40000000);
define('MODULE_WIZARD',0);
define('MODULE_CRM',MODULE_ORDER|MODULE_FAQ|MODULE_MEMBER|MODULE_POLL|MODULE_MARKETING|MODULE_FEEDBACK);

define('USER_CTRL_ACTIVE',			0x01);//allow logon
define('USER_CTRL_ROOT',			0x20);//root user
define('USER_CTRL_PASSWD_EXPIRES',	0x40);//password has been expired
$USER_CTRL = array(
	USER_CTRL_ACTIVE => 'Cho ph&eacute;p &#273;&#259;ng nh&#7853;p',
	USER_CTRL_ROOT => 'Qu&#7843;n tr&#7883; c&#7845;p cao (root)',
	USER_CTRL_PASSWD_EXPIRES =>'M&#7853;t kh&#7849;u h&#7871;t h&#7841;n'
);
//define('PATH_ADMIN_SESSION',session_save_path());
class appsession{
	var $ctrl,$id,$name,$email,$lastlogin,$priv,$logontries;
	function __construct(){ //constructor, start the session
		session_cache_limiter('nocache');
		session_name('ESNCID');
		session_set_cookie_params(0,URL_ADMIN);
		session_cache_expire(SESSION_TIMEOUT);
		session_save_path(PATH_ADMIN_SESSION);
		@session_start();
		if(!isset($_SESSION['ctrl'])){
			$_SESSION['ctrl']=1;//guest session start
			$_SESSION['USid']=-1;
			$_SESSION["USname"]='';
			$_SESSION["USemail"]='';
			$_SESSION["USlastlogin"]='';
			$_SESSION['priv']=0;
			$_SESSION['logontries'] = 0;
			$_SESSION['USvisited'] = 0;
			$_SESSION['IP']=$_SERVER['REMOTE_ADDR'];
		}
		$this->load();
	}
	function logon($user,$pass,$ctrl=SESSION_CTRL_ADMIN){
		if((int)$_SESSION['logontries'] >= 5) {
			echo '<html><head><meta http-equiv="Refresh" content="0;url=\''.URL_ADMIN.'locked.htm\'"/><script type="text/javascript" language="javascript">window.location.href="'.URL_ADMIN.'locked.htm";</script></head></html>';
			dbclose();
			exit();
		}
		if($ctrl == SESSION_CTRL_ADMIN){
			global $sql;
			$sql = "SELECT `id`,`name`,`email`,`ctrl`,DATE_FORMAT(`lastlogin`,'".FORMAT_DB_DATETIME."'),IF((`lastupdate` + INTERVAL 30 DAY <= ".SQL_NOW.") OR (`lastlogin` + INTERVAL 15 DAY <=".SQL_NOW.") OR (`ctrl` & ". USER_CTRL_PASSWD_EXPIRES." <> 0),1,0) as `pwdexprires`,`visited`   FROM `".DB_TABLE_PREFIX."user` WHERE (LOWER(`email`) = LOWER('".mysql_real_escape_string($user)."')) AND (`ctrl` & 1 <> 0) AND (".SQL_NOW." <= `expired` OR `expired` IS NULL OR `expired` = '0000-00-00')	AND (`password` = '".mysql_real_escape_string(call_user_func(esnc_passwd_encode,$pass))."')";
//			die($sql);
//echo $sql.'/1';
			if(!(list($_SESSION['USid'],$_SESSION['USname'],$_SESSION['USemail'],$_SESSION['USctrl'],$_SESSION['USlastlogin'],$_SESSION['pwdexpires'],$_SESSION['USvisited'])	 = mysql_fetch_row($rs = mysql_query($sql)))) {
				++$_SESSION['logontries'];
//			die($sql);
//				echo $sql.'/2';
				return false;
			}
			mysql_free_result($rs);
			$_SESSION['ctrl']=SESSION_CTRL_ADMIN;
			$_SESSION['priv'] = 0;
			$_SESSION['logontries'] = 0;
			$sql = "UPDATE `".DB_TABLE_PREFIX."user` SET `lastlogin`= ".SQL_NOW.", `visited`= `visited`+1 WHERE `id`= {$_SESSION['USid']}";
//			die($sql);
			mysql_query($sql);
			$this->load();
			if(rand(0,$this->visited+1) == 0 ){
				$_SESSION['pwdexpires'] = 1;
				$this->pwdexpires = 1;
			}
			return true;
		}
	}
	function logoff(){
		setcookie('ESNCID',"",time() - 42000,URL_ADMIN);//tell browser to discard session cookie
		unset($_SESSION);//unregister session varialbes
		session_destroy();
		unset($this);
		return;
/*		$this->ctrl = 0;
		$this->id = -1;
		$this->name = '';
		$this->email = '';
		$this->lastlogin = '';
		$this->priv = 0;*/
	}
	function getaccess($ctrl=SESSION_CTRL_ADMIN,$module=MODULE_DEFAULT,$access=0){//get access to any module,any privilegde
		$this->release();
		if($this->ctrl == $ctrl){
			if($access==0x10000000){
				return ($this->USctrl & 0x10000020) == 0x10000020;
			}elseif(($module & MODULE_SYS) || ($module & MODULE_USER) || ($module & MODULE_JOB)){
				return (bool)($this->USctrl & USER_CTRL_ROOT);
			}else
				return (bool)$module;
		}		
		return FALSE;
	}
	function getobjectaccess(){}
	function release(){ //release session as soon as possible for other to load
		session_write_close();
	}
	/*bool passwd($pass,$newpass): change password
		$pass: current password
		$newpass: new password
		return value: true - successfully changed
			false - password unchanged */
	function passwd($pass,$newpass){
		if($this->ctrl == SESSION_CTRL_ADMIN){
			$pass = call_user_func(esnc_passwd_encode,$pass);
			$newpass = call_user_func(esnc_passwd_encode,$newpass);
			$sql = "UPDATE `".DB_TABLE_PREFIX."user` SET `password` = '{$newpass}',`lastupdate`=".SQL_NOW.",`ctrl` = `ctrl` &~".USER_CTRL_PASSWD_EXPIRES." WHERE `id`={$this->id} AND `email`='{$this->email}' AND `password`='{$pass}'";
			mysql_query($sql);
			return (bool)(mysql_affected_rows());		
		}
		return false;
	}
	function getpassword($email){
		$email=mysql_real_escape_string(strtolower($email));
		$sql = "SELECT `password` FROM `".DB_TABLE_PREFIX."user` WHERE LOWER(`email`)='{$email}'";
		if($rw = mysql_fetch_row($rs=mysql_query($sql))){
			mysql_free_result($rs);
			return call_user_func(esnc_passwd_decode,(string)$rw[0]);
		}else
			return NULL;
	}
	function load(){//internal function to load information into object properties
		$this->ctrl = (int)$_SESSION['ctrl'];
		$this->id = (int)$_SESSION['USid'];
		$this->name = (string)$_SESSION['USname'];
		$this->email = (string)$_SESSION['USemail'];
		$this->lastlogin = (string)$_SESSION['USlastlogin'];
		$this->priv = (int)$_SESSION['priv'];
		$this->logontries = (int)$_SESSION['logontries'];
		$this->USctrl = 1;
		$this->pwdexpires = (int)$_SESSION['pwdexpires'];
		$this->visited = (int)$_SESSION['USvisited'];
		$this->USctrl = (int)$_SESSION['USctrl'];
	}
}//end class
$session = new appsession();
?>