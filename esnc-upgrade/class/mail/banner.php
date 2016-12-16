<?php class banner{
	
	var $id,$name,$width,$height,$url,$view,$created,$ctrl,$status,$img,$alt,$desc,$detail,$target,$expires,$click,$mybanner,$contactid;
	function fetch(){
		_trace(__FUNCTION__);
		$this->id=(int)$_GET['id'];
		$this->name=(string)$_POST['name'];
		$this->width=(int)$_POST['width'];
		$this->height=(int)$_POST['height'];
		$this->url=(string)$_POST['url'];
		$this->view=(int)$_POST['view'];
		$this->created=(string)$_POST['created'];
		$this->ctrl=@(int)array_sum($_POST['ctrl']);
		$this->status=(int)$_POST['status'];
		$this->img=(string)$_POST['img'];
		$this->alt=(string)$_POST['alt'];
		$this->desc=(string)$_POST['desc'];
		$this->detail=(string)$_POST['detail'];
		$this->target=(string)$_POST['target'];
		$this->expires=(string)$_POST['expires'];
		$this->click=(int)$_POST['click'];
		$this->mybanner=(string)$_POST['mybanner'];
		$this->contactid=(int)$_POST['contactid'];		
	}
	function addrow(){
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'banner`(`name`,`width`,`height`,`url`,`view`,`created`,`ctrl`,`status`,`img`,`alt`,`desc`,`detail`,`target`,`expires`,`click`,`mybanner`,`contactid`) VALUES ('
		." '".mysql_real_escape_string($this->name)."'"
		.",'".(int)$this->width."'"
		.",'".(int)$this->height."'"
		.",'".mysql_real_escape_string($this->url)."'"
		.",'".(int)$this->view."'"
		.",".SQL_NOW
		.",'".(int)$this->ctrl."'"
		.",'".(int)$this->status."'"
		.",'".mysql_real_escape_string($this->img)."'"
		.",'".mysql_real_escape_string($this->alt)."'"
		.",'".mysql_real_escape_string($this->desc)."'"
		.",'".mysql_real_escape_string($this->detail)."'"
		.",'".mysql_real_escape_string($this->target)."'"
		.",'".mysql_format_datetime($this->expires)."'"
		.",'".(int)$this->click."'"
		.",'".mysql_real_escape_string($this->mybanner)."'"
		.",'".(int)$this->contactid."'"
		.')';
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			$sql='UPDATE `'.DB_TABLE_PREFIX.'banner` SET `view`=`id` WHERE `id`='.$this->id;
			mysql_query($sql);
			return TRUE;
		}
	}
	function updaterow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."banner` SET"
		." `Name`='".mysql_real_escape_string($this->name)."'"
		.",`Width`='".(int)$this->width."'"
		.",`Height`='".(int)$this->height."'"
		.",`URL`='".mysql_real_escape_string($this->url)."'"
		.",`View`='".(int)$this->view."'"
		.",`Created`=".SQL_NOW
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`Status`='".(int)$this->status."'"
		.",`Img`='".mysql_real_escape_string($this->img)."'"
		.",`Alt`='".mysql_real_escape_string($this->alt)."'"
		.",`Desc`='".mysql_real_escape_string($this->desc)."'"
		.",`Detail`='".mysql_real_escape_string($this->detail)."'"
		.",`Target`='".mysql_real_escape_string($this->target)."'"
		.",`Expires`='".mysql_format_datetime($this->expires)."'"
//		.",`Click`='".(int)$this->click."'"
		.",`MyBanner`='".mysql_real_escape_string($this->mybanner)."'"
		.",`ContactID`='".(int)$this->contactid."'"
		." WHERE `id` = {$this->id}";
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `width`, `height`, `url`, `view`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`, `ctrl`, `status`, `img`, `alt`, `desc`, `detail`, `target`,DATE_FORMAT(`expires`,'".FORMAT_DB_DATETIME."') as `expires`, `click`, `mybanner`, `contactid` FROM `".DB_TABLE_PREFIX."banner` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->name = (string)$row['name'];
		$this->width = (int)$row['width'];
		$this->height = (int)$row['height'];
		$this->url = (string)$row['url'];
		$this->view = (int)$row['view'];
		$this->created = (string)$row['created'];
		$this->ctrl = (int)$row['ctrl'];
		$this->status = (int)$row['status'];
		$this->img = (string)$row['img'];
		$this->alt = (string)$row['alt'];
		$this->desc = (string)$row['desc'];
		$this->detail = (string)$row['detail'];
		$this->target = (string)$row['target'];
		$this->expires = (string)$row['expires'];
		$this->click = (int)$row['click'];
		$this->mybanner = (string)$row['mybanner'];
		$this->contactid = (int)$row['contactid'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `width`, `height`, `url`, `view`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`, `ctrl`, `status`, `img`, `alt`, `desc`, `detail`, `target`,DATE_FORMAT(`expires`,'".FORMAT_DB_DATETIME."') as `expires`, `click`, `mybanner`, `contactid` FROM `".DB_TABLE_PREFIX."banner` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	function islinked($desc){//check wether link is linked
		if(preg_match('/(http:\/\/[^\"\']+)(?:\'|\"|$)/i',$desc,$ss)){
			global $sql;
			$sql = 'SELECT `id` FROM `'.DB_TABLE_PREFIX.'banner` WHERE `url` LIKE \'%'.$ss[1].'%\' OR `desc` LIKE \'%'.$ss[1].'%\' LIMIT 1';
//			_trace($sql);
			if(mysql_num_rows($rs=mysql_query($sql))){
				mysql_free_result($rs);
				return TRUE;
			}
		}return FALSE;
	}
	function addtocat(){
		global $sql;
		$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'catbannerbanner` WHERE `bannerid`='.(int)$this->id;
		mysql_query($sql);
		if(is_array($this->a_cat)){
			$sql = 'REPLACE INTO `'.DB_TABLE_PREFIX.'catbannerbanner` (`catbannerid`,`bannerid`) VALUES ';
			foreach($this->a_cat as $cat)		$sql .= '('.(int)$cat.','.$this->id.'),';
			$sql=rtrim($sql,',');
		}else{
			$sql = 'REPLACE INTO `'.DB_TABLE_PREFIX.'catbannerbanner` (`catbannerid`,`bannerid`) VALUES ('.(int)$this->a_cat.','.$this->id.')';
		}
		return mysql_query($sql);
	}
	function isduplicated(){
		if(preg_match('/http:\/\/([^\"\']+)(?:\'|\"|$)/i',$this->desc.' '.$this->url,$ss)){
			$ss[1]=rtrim($ss[1],'/');
			global $sql;
			$sql = 'SELECT `id` FROM `'.DB_TABLE_PREFIX.'banner` WHERE (`url` LIKE \'%'.$ss[1].'%\' OR `desc` LIKE \'%'.$ss[1].'%\' '.($this->id > 0 ? ') AND `id` <> '.$this->id:')').' LIMIT 1';
			_trace($sql);
			#if(mysql_num_rows($rs=mysql_query($sql))){
			if(mysql_numrows($rs=mysql_query($sql))){
				mysql_free_result($rs);
				return TRUE;
			}
		}return FALSE;
	}
}
class bannerlink extends banner{
	function addoverwrite(){
		if(is_array($this->a_cat))$catid=(int)$this->a_cat[0];
		else $catid=(int)$this->a_cat;
		$sql='SELECT `a`.`id`,`a`.`view` FROM `'.DB_TABLE_PREFIX.'banner` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catbannerbanner` as `b` ON `a`.`id`=`b`.`bannerid` WHERE `b`.`catbannerid`='.(int)$catid.' AND `a`.`status`=5 ORDER BY `a`.`id` ASC LIMIT 1';

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
	function lookup($pagesize=BANNER_PAGESIZE_LINKEXCHANGE){
		$sql = 'SELECT `b`.`id`,`b`.`name` FROM `'.DB_TABLE_PREFIX.'catbannerbanner` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catbanner` as `b` ON `b`.`id`=`a`.`catbannerid`  WHERE `a`.`bannerid`='.(int)$this->id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		$this->a_cat = (int)$row[0];
		$this->a_catname = (string)$row[1];
		mysql_free_result($rs);
		$sql = 'SELECT DISTINCT `a`.`id` FROM `'.DB_TABLE_PREFIX.'banner` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catbannerbanner` as `b` ON `a`.`id` = `b`.`bannerid` AND `b`.`catbannerid` ='.$this->a_cat. ' ORDER BY `a`.`view` ASC';
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
		if (strpos($this->mybanner, 'http://')===false){
			return false;
		}
		$homepage = file_get_contents($this->mybanner);
		$pos = strpos($homepage,$_SERVER['HTTP_HOST']);
		if ($pos === false) { return false;} else return true;
	}
}
?>
