<?php 
class linkexchange{
	var $id,$name,$url,$src,$desc,$created,$lastupdate,$view,$ctrl;
	function fetch(){
		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->name=(string)$_POST['name'];
		$this->url=(string)$_POST['url'];
		$this->src=(string)$_POST['src'];
		$this->desc=(string)$_POST['desc'];
		$this->created=(string)$_POST['created'];
		$this->lastupdate=(string)$_POST['lastupdate'];
		$this->view=(int)$_POST['view'];
		$this->ctrl=(int)$_POST['ctrl'];
	}
	function addrow(){
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'linkexchange`(`name`,`url`,`src`,`desc`,`created`,`lastupdate`,`ctrl`) VALUES ('
		." '".mysql_real_escape_string(stripslashes($this->name))."'"
		." '".mysql_real_escape_string(stripslashes($this->url))."'"
		." '".mysql_real_escape_string(stripslashes($this->src))."'"
		.",'".mysql_real_escape_string(stripslashes($this->desc))."'"
		.",".SQL_NOW
		.",".SQL_NOW
		.",'".(int)$this->ctrl."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			$sql='UPDATE `'.DB_TABLE_PREFIX.'linkexchange` SET `view`=`id` WHERE `id`='.$this->id;
			mysql_query($sql);
			return TRUE;
		}
	}
	function updaterow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."linkexchange` SET"
		." `name`='".mysql_real_escape_string(stripslashes($this->name))."'"
		.",`url`='".mysql_real_escape_string(stripslashes($this->url))."'"
		.",`src`='".mysql_real_escape_string(stripslashes($this->src))."'"
		.",`desc`='".mysql_real_escape_string(stripslashes($this->desc))."'"
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
			foreach($this->a_cat as $cat)		$sql .= '('.(int)$cat.','.$this->id.'),';
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
}
class linkexchangelink extends linkexchange{
	function addoverwrite(){
		if(is_array($this->a_cat))$catid=(int)$this->a_cat[0];
		else $catid=(int)$this->a_cat;
		$sql='SELECT `a`.`id`,`a`.`view` FROM `'.DB_TABLE_PREFIX.'linkexchange` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catlinkexchangelinkexchange` as `b` ON `a`.`id`=`b`.`linkexchangeid` WHERE `b`.`catlinkexchangeid`='.(int)$catid.' AND `a`.`status`=5 ORDER BY `a`.`id` ASC LIMIT 1';

		_trace($sql);
		$rs = mysql_query($sql);
		$row=mysql_fetch_row($rs);
		mysql_free_result($rs);
		if($row){
			$this->id=$row[0];
			$this->view=$row[1];
			$this->click=0;
			return $this->updaterow();
		}else return $this->addrow() && $this->addtocat();
	}
	function lookup($pagesize=linkexchange_PAGESIZE_LINKEXCHANGE){
		$sql = 'SELECT `b`.`id`,`b`.`name` FROM `'.DB_TABLE_PREFIX.'catlinkexchangelinkexchange` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catlinkexchange` as `b` ON `b`.`id`=`a`.`catlinkexchangeid`  WHERE `a`.`linkexchangeid`='.(int)$this->id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		$this->a_cat = (int)$row[0];
		$this->a_catname = (string)$row[1];
		mysql_free_result($rs);
		$sql = 'SELECT DISTINCT `a`.`id` FROM `'.DB_TABLE_PREFIX.'linkexchange` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catlinkexchangelinkexchange` as `b` ON `a`.`id` = `b`.`linkexchangeid` AND `b`.`catlinkexchangeid` ='.$this->a_cat. ' ORDER BY `a`.`view` ASC';
		$rs=mysql_query($sql);
		$page=1;
		for($i=1;$row=mysql_fetch_row($rs);++$i){
			if($i>$pagesize) {++$page;$i=1;}
			if($row[0] == $this->id){
				mysql_free_result($rs);	
				return $page;
			}
		}
		mysql_free_result($rs);	
		return 0;
	}
	function checker(){
		if (strpos($this->mylinkexchange,'http://') !== 0){
			return FALSE;
		}
		$url = array(array($this->mylinkexchange));
		if($f  = file_load_contents($url,PATH_TEMP.'linkback.xml',5,60,'<a>')){
			$doc = new DOMdocument();
			if(@$doc->loadXML($f)){
				$a   = $doc->getElementsByTagName('a');
				$len = $a->length;
				for ($i=0;$i<$len;$i++){
					$href = chop($a->item($i)->getAttribute('href'));
					if (!empty($href) && (strpos($href, URL_LINKEXCHANGE) === 0)){
						return TRUE;
					}
				}
			}
		}
		return FALSE;
	}
}
?>
