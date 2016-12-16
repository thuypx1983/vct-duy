<?php 
abstract class tool{
	var $id,$name,$file,$view,$type,$ctrl,$data,$created,$lastrun,$run,$cfg,$fn;
	abstract function setup();//setup the tool , fn=setup
	abstract function remove();//uninstall
	abstract function run();
	abstract function about();//show information about the tool
	function markrun(){
		global $sql;
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'tool` SET `lastRun`='.SQL_NOW.', `run`=`run`+1 WHERE `ID`='.$this->id;
		mysql_query($sql);
	}
	final function save(){//save tool information
		return $this->id > 0 ? $this->updaterow(): $this->addrow();
	}
	final function cleanup(){
		global $sql,$session;
		if($session->getAccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){
			$sql='DELETE FROM `'.DB_TABLE_PREFIX.'tool` WHERE `id`='.(int)$this->id;
			return mysql_query($sql);
		}
	}
	final function addrow(){
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'tool`(`name`,`file`,`view`,`type`,`ctrl`,`data`,`created`,`lastrun`,`run`,`access`) VALUES ('
		." '".mysql_real_escape_string($this->name)."'"
		.",'".mysql_real_escape_string(basename($this->file,'.php'))."'"
		.",'".(int)$this->view."'"
		.",'".(int)$this->type."'"
		.",'".(int)$this->ctrl."'"
		.",'".mysql_real_escape_string($this->data)."'"
		.",".SQL_NOW
		.",NULL"
		.",".(int)$this->run
		.",".(int)$this->access
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
		_trace(mysql_error());
		_trace($sql);
	}
	final function updaterow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$this->file=basename($this->file,'.php');
		$sql = "UPDATE `".DB_TABLE_PREFIX."tool` SET"
		." `name`='".mysql_real_escape_string($this->name)."'"
		.",`file`='".mysql_real_escape_string($this->file)."'"
		.",`view`=".(int)$this->view
		.",`type`=".(int)$this->type
		.",`ctrl`=".(int)$this->ctrl
		.",`data`='".mysql_real_escape_string($this->data)."'"
		.",`created`=".SQL_NOW
		.",`lastRun`=".SQL_NOW
		.",`run`=`run` + 1"
		.",`access`=".(int)$this->access
		." WHERE `id` = {$this->id}";
		_trace($sql);
		return mysql_query($sql);
	}
	final function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `file`, `view`, `type`, `ctrl`, `data`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`lastrun`,'".FORMAT_DB_DATETIME."') as `lastrun`, `run` FROM `".DB_TABLE_PREFIX."tool` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->name = (string)$row['name'];
		$this->file = (string)$row['file'];
		$this->view = (int)$row['view'];
		$this->type = (int)$row['type'];
		$this->ctrl = (int)$row['ctrl'];
		$this->data = (string)$row['data'];
		$this->created = (string)$row['created'];
		$this->lastrun = (string)$row['lastrun'];
		$this->run = (int)$row['run'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	final function loadrow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `file`, `view`, `type`, `ctrl`, `data`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`,DATE_FORMAT(`lastrun`,'".FORMAT_DB_DATETIME."') as `lastrun`, `run` FROM `".DB_TABLE_PREFIX."tool` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	final function startForm($act,$q=NULL,$fn=NULL,$style='',$method='POST'){
		echo '<form action="'.URL_SELF;
		$q['act']=$act;
		$q['-']=$this->file;
		$q['@']=(int)$this->id;
		$q['()'] = $fn?$fn:$this->fn;
		if($method=='POST'){ echo '?'.http_build_query($q); $q=array(); echo '" method="POST';}
		echo '" '.$style.' >';
		foreach($q as $key=>$value)
		echo '<input type="hidden" name="'.$key.'" value="'.$value.'"/>';
	}
	final function endForm(){ echo '</form>';}
	final function makeUrl($act,$q=NULL,$fn=NULL){$q['act']=$act;$q['-']=$this->file;$q['@']=$this->id;$q['()']=$fn?$fn:$this->fn; return URL_SELF.'?'.http_build_query($q);}
	final function adjustUrl($act,$q=NULL,$fn=NULL){$q['act']=$act;$q['-']=$this->file;$q['@']=$this->id;$q['()']=$fn?$fn:$this->fn;return URL_SELF.'?'.http_build_query($q+$_GET);}
	final static function absToolUrl($file,$act,$q,$fn,$codefile,$id){ $q['act']=$act;$q['-']=$codefile;$q['@']=$id;$q['()']=$fn;return $file.'?'.http_build_query($q);}
	final function startPage($title,$xcode=NULL){
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="'.URL_BASE_ADMIN.'" />
<title>'.$title.'</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css">
<comment><link type="text/css" rel="stylesheet" href="images/style-nonie.css" /></comment>
';
		echo $xcode;
		echo '<body>';
	}
	final function endPage($xcode=NULL){
		echo '<script src="js.php" type="text/javascript"></script><script src="js/library.php" type="text/javascript"></script>
<script type="text/javascript">function doUp(){self.location.href="'.URL_UP.'";};window.top.document.title=self.document.title;</script>';
		echo $xcode;
		echo '</body></html>';
	}
}
?>