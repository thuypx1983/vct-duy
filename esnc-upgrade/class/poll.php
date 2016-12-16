<?php class poll{//Phai sua ham addrow va update bo dau phay (,) truoc field dau tien,
	//ham fetch() phai chuyen $_POST['id'] thanh $_GET['id'] va $_POST['ctrl'] thanh @array_sum($_POST['ctrl']);
	var $id,$name,$question,$thisdate,$enddate,$num,$ctrl,$type,$view,$a_vote;

	function fetch(){

		_trace(__FUNCTION__);
		$this->id=(int)$_REQUEST['id'];
		$this->name=(string)$_POST['name'];
		$this->question=(string)$_POST['question'];
		$this->thisdate=(string)$_POST['thisdate'];
		$this->enddate=(string)$_POST['enddate'];
		$this->num=(int)$_POST['num'];
		$this->ctrl=(int)@array_sum($_POST['ctrl']);
		$this->type=(int)$_POST['type'];
		$this->view=(int)$_POST['view'];
	}
	function addrow(){
		global $sql;
		_trace(__FUNCTION__);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'poll`(`name`,`question`,`thisdate`,`enddate`,`num`,`ctrl`,`type`,`view`) VALUES ('
		." '".mysql_real_escape_string($this->name)."'"
		.",'".mysql_real_escape_string($this->question)."'"
		.",'".mysql_format_date($this->thisdate)." 00:00:00'"
		.",'".mysql_format_date($this->enddate)." 23:59:59'"
		.",0"
		.",'".(int)$this->ctrl."'"
		.",'".(int)$this->type."'"
		.",'".(int)$this->view."'"
		.')';
		_trace($sql);
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			return TRUE;
		}
	}
	function updaterow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."poll` SET"
		." `Name`='".mysql_real_escape_string($this->name)."'"
		.", `Ctrl`='".(int)$this->ctrl."'"
		.",`EndDate`='".mysql_format_date($this->enddate)." 23:59:59'"
		.",`View`='".(int)$this->view."'";
		if($this->num <=0) //only update below if nobody participates
		$sql .= 
			",`Type`='".(int)$this->type."'"
			.",`Question`='".mysql_real_escape_string($this->question)."'"
			.",`Thisdate`='".mysql_format_date($this->thisdate)." 00:00:00'";
		$sql .=" WHERE `id` = {$this->id}";
		_trace($sql);
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `question`,DATE_FORMAT(`thisdate`,'".FORMAT_DB_DATE."') as `thisdate`,DATE_FORMAT(`enddate`,'".FORMAT_DB_DATE."') as `enddate`, `num`, `ctrl`, `type`, `view` FROM `".DB_TABLE_PREFIX."poll` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->name = (string)$row['name'];
		$this->question = (string)$row['question'];
		$this->thisdate = (string)$row['thisdate'];
		$this->enddate = (string)$row['enddate'];
		$this->num = (int)$row['num'];
		$this->ctrl = (int)$row['ctrl'];
		$this->type = (int)$row['type'];
		$this->view = (int)$row['view'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `question`,DATE_FORMAT(`thisdate`,'".FORMAT_DB_DATE."') as `thisdate`,DATE_FORMAT(`enddate`,'".FORMAT_DB_DATE."') as `enddate`, `num`, `ctrl`, `type`, `view` FROM `".DB_TABLE_PREFIX."poll` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	function loadvote(){
		global $sql;
		_trace(__FUNCTION__);
		$sql = 'SELECT `id`,`name`,`num`,`percent`,`view` FROM `'.DB_TABLE_PREFIX.'vote` WHERE `pollID`='.(int)$this->id.' ORDER BY `view` ASC';
		_trace($sql);
		$rs = mysql_query($sql);
		$this->a_vote = array();
		while($this->a_vote[]=mysql_fetch_assoc($rs));array_pop($this->a_vote);
		mysql_free_result($rs);		
	}
	function updatevote(){
		global $sql;
		settype($this->id,'int');
		$d='';
		foreach($this->a_vote as $row){
			switch($row['flag']){
			case 'del'://remove existing
				$d .= ','.(int)$row['id'];
				break 1;
			case 'add':
				if($this->num > 0 || $row['name'] == '') continue 2;//go to foreach
				$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'vote` (`name`,`view`,`pollid`) VALUES (\''.mysql_real_escape_string($row['name']).'\','.(int)$row['view'].','.$this->id.')';
				break 1;
			default: //default to save
				$sql = 'UPDATE `'.DB_TABLE_PREFIX.'vote` SET '
				.' `view`=\''.mysql_real_escape_string($row['view']).'\'';
				if($this->num <=0) $sql .=',`name`=\''.mysql_real_escape_string($row['name']).'\'';//only update vote name if nobody
				$sql .= ' WHERE `id`='.(int)$row['id'];
			}
			_trace($sql);
			mysql_query($sql);
		}
		if($d){//remove some votes
			$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'vote` WHERE `id` IN('.ltrim($d,',').')';
			_trace($sql);
			mysql_query($sql);
		}
	}
}
?>