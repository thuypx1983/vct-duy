<?php /* vinhtx@esnadvanced.com 18-Apr-2006 */
define('SESSION_CTRL_GUEST',1);//customer session
define('SESSION_CTRL_CUSTOMER',2);//customer session
define('SESSION_CTRL_ADMIN',4);//admin session
define('SESSION_CTRL_SUPPERUSER',8);//supper user session
define('SESSION_CTRL_AGENT',16);//agent session
define('SESSION_CTRL_MEMBER',64);//member session
define('SESSION_CTRL_ASSOC',32);//association member
define('SESSION_CTRL_ORG',128);//customer association

define('ACCESS_CREATE',1);//allow create
define('ACCESS_READ',2);//allow read 
define('ACCESS_WRITE',4);//allow to full update records, include ACCESS_WRITE_CTRL
define('ACCESS_REMOVE',8);//allow to remove
define('ACCESS_WRITE_CTRL',16);//allow to change control number of records
define('ACCESS_SORT',32);//allow to re-sort items

class session{
	var $ctrl,$id,$name,$email,$lastlogin,$priv,$logontries;
	function session(){ //constructor, start the session
		$t = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(strpos($t,'esnc.net') !== FALSE || strpos($t,'search') !== FALSE || strpos($t,'bot') !== FALSE || strpos($t,'spider') !== FALSE || strpos($t,'crawler') !== FALSE) return;//exclude search engine and other browser
		session_save_path(PATH_SESSION);
		session_cache_limiter(SESSION_CACHE);
		session_cache_expire(SESSION_TIMEOUT);
		session_name(SESSION_NAME);
		session_set_cookie_params(0,URL_ROOT);
		session_start();
		if(!isset($_SESSION['ctrl'])){
			$_SESSION['USip'] = $t=$_SERVER['REMOTE_ADDR'];
			$_SESSION['UA'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['ctrl']=1;//guest session start
			$_SESSION['USid']=-1;
			$_SESSION['USname']='';
			$_SESSION['USemail']='';
			$_SESSION['USlastlogin']='';
			$_SESSION['priv']=0;
			$_SESSION['logontries'] = 0;
			/* implement hit counter	
			exclude ip from 192.168.0.x,10.x.x.x,
			*/
			if(strpos($t,'192.') !== 0 && strpos($t,'10.') !== 0 && ($visit=(int)@file_get_contents(PATH_GLOBAL.'visit.txt')))
				file_put_contents(PATH_GLOBAL.'visit.txt',++$visit,LOCK_EX);
		};
		$this->load();
	}
	function logon($user,$pass,$ctrl=SESSION_CTRL_CUSTOMER){
		global $sql,$sql2;
		$sql = "SELECT `a`.`id`,CONCAT_WS(' ',`firstname`,`lastname`) as `name`,`a`.`email`,`a`.`ctrl`,DATE_FORMAT(`a`.`lastlogon`,'".FORMAT_DB_DATETIME."') as `lastlogon`,`a`.`type`,`a`.`agentid` FROM `".DB_TABLE_PREFIX."customer` as `a` WHERE (LOWER(`email`) = '".mysql_real_escape_string(strtolower($user))."') AND (`password`='".call_user_func(esnc_passwd_encode,$pass)."')";
		$rs = mysql_query($sql);
		_trace(mysql_error());
		if(!$rs) {
			++$_SESSION['logontries'];
			return false;
		}
		if(!($rw = mysql_fetch_assoc($rs))) {
			++$_SESSION['logontries'];
			return false;
		}
		mysql_free_result($rs);
		$_SESSION['USid']=(int)$rw['id'];
		$_SESSION['USname']=(string)$rw['name'];
		$_SESSION['USemail']=(string)$rw['email'];
		$_SESSION['USctrl']=(int)$rw['ctrl'];
		$_SESSION['USlastlogin']=$rw['lastlogon'];
		$_SESSION['priv'] = 0;
		$_SESSION['logontries'] = 0;
		$_SESSION['USagentid'] = (int)$rw['agentid'];
		$_SESSION['UStype'] = (int)$rw['type'];
		switch($_SESSION['UStype']){
		case SESSION_CTRL_AGENT: $_SESSION['ctrl']=SESSION_CTRL_AGENT;break;
		case SESSION_CTRL_MEMBER: $_SESSION['ctrl'] = SESSION_CTRL_MEMBER;break;
		case SESSION_CTRL_ASSOC: $_SESSION['ctrl'] = SESSION_CTRL_ASSOC;break;
		default:
			$_SESSION['ctrl'] = SESSION_CTRL_CUSTOMER;
		}
		$sql2 = "UPDATE `".DB_TABLE_PREFIX."customer` SET `visited`= `visited`+1,`lastlogon`=".SQL_NOW." WHERE `id`= ".(int)$rw['id'];
		mysql_query($sql2);
		$this->load();
		return TRUE;
	}
	function logoff(){
		unset($_SESSION);//unregister all session varialbes
		session_destroy();
		unset($this);
		return;
	}
	function getaccess($ctrl=SESSION_CTRL_CUSTOMER,$module=0,$priv=0){//get access to a module
		$this->release();
		return $this->ctrl == $ctrl;
	}
	function load(){//internal function to load information into object properties
		$this->ctrl = (int)$_SESSION['ctrl'];
		$this->id = (int)$_SESSION['USid'];
		$this->name = (string)$_SESSION['USname'];
		$this->email = (string)$_SESSION['USemail'];
		$this->lastlogin = (string)$_SESSION['USlastlogin'];
		$this->priv = (int)$_SESSION['priv'];
		$this->logontries = (int)$_SESSION['logontries'];
		$this->agentid = @(int)$_SESSION['USagentid'];
	}
	function release(){ //release session as soon as possible for other to load
		session_write_close();
	}
	/*bool passwd($pass,$newpass): change password
		$pass: current password
		$newpass: new password
		return value: true - successfully changed
			false - password unchanged */
	function passwd($pass,$newpass){
		if($this->ctrl == SESSION_CTRL_CUSTOMER){
			$pass = call_user_func(esnc_passwd_encode,$pass);
			$newpass = call_user_func(esnc_passwd_encode,$newpass);
			$sql = "UPDATE `".DB_TABLE_PREFIX."customer` SET `password` = '{$newpass}' WHERE `id`={$this->id} AND `email`='{$this->email}' AND `password`='{$pass}'";
			mysql_query($sql);
			return (bool)(mysql_affected_rows());
		}
	}
	function getpassword($email){
		$email=mysql_real_escape_string($email);
		$sql = "SELECT `password` FROM `".DB_TABLE_PREFIX."customer` WHERE `email`='{$email}'";
		if($rw = mysql_fetch_row($rs=mysql_query($sql))){
			mysql_free_result($rs);
			return call_user_func(esnc_passwd_decode,(string)$rw[0]);
		}else
			return NULL;
	}
	function online(){
		$cwd = getcwd();
		chdir(PATH_SESSION);
		$rs = glob('sess_*',GLOB_NOSORT|GLOB_NOESCAPE);
		$tt = time() - SESSION_TIMEOUT *60;
		$cnt = 0;
		foreach($rs as $f){
			if(filemtime($f) > $tt) ++$cnt;
		}
		chdir($cwd);
		return $cnt + @SESSION_ONLINE_INIT;
	}
	function visit(){
		return (int)@file_get_contents(PATH_GLOBAL.'visit.txt') + (int)@APP_VISIT_INIT;
	}
	# hanhnd@esnadvanced.com
	# calculate how many people was visited website to-day
	# parameter: null
	# return: total people was visited website to-day
	function today(){
		$query= 'select sum(`a`.`online`) from `'.DB_TABLE_PREFIX.'counter` as `a` 
		where (date(`a`.`created`)= curdate())';
		$record= mysql_query($query);
		$result= mysql_fetch_assoc($record);
		return $result['sum(`a`.`online`)'];
	}
	# today function end
	function member(){
		return 0;
	}
	function savecounter(){
		global $sql;
		$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'counter`(`created`,`online`,`visit`,`member`) VALUES( '.SQL_NOW.','
			.(session::online()-@SESSION_ONLINE_INIT).','.(session::visit() - @APP_VISIT_INIT).','.session::member().')';
		_trace($sql);
		return mysql_query($sql);
	}
	function sync(){}
}//end class
?>
