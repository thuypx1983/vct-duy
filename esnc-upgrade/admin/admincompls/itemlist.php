<?php 
class itemlist{
var $rs,$page,$pagecount,$pagesize,$sortby,$keyword,$table,$idvalue,$catid,$grandparentid;
	function setctrl(){
		global $sql;
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id) ){
			if(is_int($this->ctrl) && $this->ctrl > 0){
				$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `ctrl` = `ctrl` | {$this->ctrl} WHERE `id` IN ({$this->id})";
				_trace($sql);
				if(!mysql_query($sql)) return FALSE;
			}
			if(is_int($this->nctrl) && $this->nctrl){
				$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `ctrl` = `ctrl` & ~{$this->nctrl} WHERE `id` IN ({$this->id})";
				_trace($sql);
				if(!mysql_query($sql)) return FALSE;
			}
			if(is_int($this->status)){
				$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `status` = {$this->status} WHERE `id` IN ({$this->id})";
				_trace($sql);
				if(!mysql_query($sql)) return FALSE;
			}
		}
		return FALSE;
	}
	function unsetctrl(){
		global $sql;
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id) && is_int($this->ctrl)){
			$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `ctrl` = `ctrl` & ~{$this->ctrl} WHERE `id` IN ({$this->id})";
			_trace($sql);
			return mysql_query($sql);
		}
		return FALSE;
	}
	function setstatus(){
		global $sql;
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id) && is_int($this->status)){
			$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `status` = {$this->status} WHERE `id` IN ({$this->id})";
			_trace($sql);
			return mysql_query($sql);
		}
		return FALSE;	
	}
	function reorder(){
		global $sql;
		$v = explode((string)ID_VALUE_SEPERATOR,$this->idvalue);
		foreach($v as $pair){
			$vv = explode('bb',$pair);
			settype($vv[1],"int");
			settype($vv[0],"int");
			$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `view` = {$vv[1]} WHERE `id`={$vv[0]}";
			_trace($sql);
			if(!mysql_query($sql)) return FALSE;
		}
		return TRUE;
	}	
	function ren(){
		global $sql;
		settype($this->id,"int");
		$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `name` = '".mysql_escape_string($this->name)."' WHERE `id` = {$this->id}";
		_trace($sql);
		return mysql_query($sql);
	}
	function del(){
		global $sql;
		$tbcatitem = "cat{$this->table}{$this->table}";
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)&& is_int($this->catid)){
			$sql = "DELETE FROM `".DB_TABLE_PREFIX."{$tbcatitem}` WHERE `{$this->table}id` IN ({$this->id}) AND `cat{$this->table}id` = {$this->catid}";//detach from category
			_trace($sql);
			if(!mysql_query($sql)) return FALSE;
			$sql = "SELECT DISTINCT `{$this->table}id` FROM `".DB_TABLE_PREFIX."{$tbcatitem}` WHERE `{$this->table}id` IN ({$this->id})";//find id in cat
			_trace($sql);
			$this->rs=mysql_query($sql); 
			$this->id .= ',';
			while($row=mysql_fetch_row($this->rs)){
				$this->id=str_replace($row[0].',','',$this->id);//chop out id
			}
			mysql_free_result($this->rs);
			if($this->id != ''){
				$this->id=chop($this->id,',');//remove trailing ,
				$sql = "DELETE FROM `".DB_TABLE_PREFIX."{$this->table}` WHERE `id` IN ({$this->id})";
				_trace($sql);
				return mysql_query($sql);
			}
			return FALSE;
		}
	}
	function delall(){
        global $sql;
		$tbcatitem = "cat{$this->table}{$this->table}";
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)&& is_int($this->catid)){
			$sql = "DELETE FROM `".DB_TABLE_PREFIX."{$tbcatitem}` WHERE `{$this->table}id` IN ({$this->id})";//detach from category
			_trace($sql);
			if(!mysql_query($sql)) return FALSE;
			/*$sql = "SELECT DISTINCT `{$this->table}id` FROM `{$tbcatitem}` WHERE `{$this->table}id` IN ({$this->id})";//find id in cat
			_trace($sql);
			$this->rs=mysql_query($sql); 
			$this->id .= ',';
			while($row=mysql_fetch_row($this->rs)){
				$this->id=str_replace($row[0].',','',$this->id);//chop out id
			}
			mysql_free_result($this->rs);*/
			if($this->id != ''){
				$this->id=chop($this->id,',');//remove trailing ,
				$sql = "DELETE FROM `".DB_TABLE_PREFIX."{$this->table}` WHERE `id` IN ({$this->id})";
				_trace($sql);
				if (mysql_query($sql)){
                    return TRUE;
                }				
			}
			return FALSE;
		}
    }
	function copyto(){
		global $sql;
		$a_id = explode(',',$this->id);
		$a = &$a_id;
		foreach($a as $id){
			settype($id,"int");
			settype($this->catid,"int");
			$sql = "INSERT INTO `".DB_TABLE_PREFIX."cat{$this->table}{$this->table}`(`cat{$this->table}id`,`{$this->table}id`) SELECT {$this->catid},{$id}";
			_trace($sql);
			mysql_query($sql);
		}
		return TRUE;
	}
	function moveto(){
		global $sql;
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)&& is_int($this->catid)){
			$this->copyto();//copy to new category
			$sql = "DELETE FROM `".DB_TABLE_PREFIX."cat{$this->table}{$this->table}` WHERE `{$this->table}id` IN ({$this->id}) AND `cat{$this->table}id` <> {$this->catid}";
			_trace($sql);
			return mysql_query($sql);			
		}
		return FALSE;
	}
	function open($fields,$search=''){
		global $sql;
		switch($this->sortby){
			case SORTBY_NAME_ASC:       $sr = ' ORDER BY `tb`.`name` ASC'; break;
			case SORTBY_NAME_DESC:      $sr = ' ORDER BY `tb`.`name` DESC'; break;
			case SORTBY_VIEW_DESC:      $sr = ' ORDER BY `tb`.`view` DESC, `tb`.`id` DESC'; break;
			case SORTBY_CREATED_DESC:   $sr = ' ORDER BY `tb`.`created` DESC';break;
			case SORTBY_CREATED_ASC: 	$sr = 'ORDER BY `tb`.`created` ASC';break;
			case SORTBY_ID_DESC: 	    $sr = 'ORDER BY `tb`.`id` DESC';break;
			case SORTBY_ID_ASC: 	    $sr = 'ORDER BY `tb`.`id` ASC';break;
			default:
				$this->sortby=SORTBY_VIEW_ASC;//default to sort by view ascending
				$sr = ' ORDER BY `tb`.`view` ASC,`tb`.`id` DESC';
		}
		$wh = 'WHERE '. $search;
		if($this->catid > 0){ 
			$l = "INNER JOIN `".DB_TABLE_PREFIX."cat{$this->table}{$this->table}` as `l` ON `tb`.`id` = `l`.`{$this->table}id`"; 
			$wh .= " AND (`l`.`cat{$this->table}id` = {$this->catid})";
		}else $l='';//filter by catid
		if($this->ctrl){
			if($this->ctrl_){
				$wh .= " AND `tb`.`ctrl` & {$this->ctrl} = 0";
			}else{
				$wh .= " AND `tb`.`ctrl` & {$this->ctrl} = {$this->ctrl}";
			}
		}
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->status)) $wh .= ' AND `tb`.`status` IN ('.$this->status.')';
		if($wh == 'WHERE ') $wh = '';
		else $wh = str_replace('WHERE  AND',' WHERE ',$wh);
		$sql = "SELECT `parentid` FROM `".DB_TABLE_PREFIX."cat{$this->table}` WHERE `id`={$this->catid}";//find grandparentid
		_trace($sql);
		$row = mysql_fetch_row($this->rs=mysql_query($sql));
		$this->grandparentid = (int)$row[0];
		mysql_free_result($this->rs);
		if($this->pagesize > 200 || $this->pagesize < 5) $this->pagesize=18;
		/*here we have to locate to page which containt object if this->id > 0.
		if($this->id >0){
			$sql = "SELECT `id` FROM `".DB_TABLE_PREFIX."{$this->table}` as `tb` {$l} {$wh} {$sr}";
			$this->rs = mysql_query($sql);
			$this->page=1;
			for($i=0;$row = mysql_fetch_row($this->rs);++$i){
				if($this->id == $row[0]) break;
				if($this->pagesize + 1 == $i){
					++$this->page;
					$i=0;
				}
			}
			mysql_free_result($this->rs);
		}*/
		if($this->page <1) $this->page=1;
		if($this->page == 1) 
			$this->startrow = 0;
		else
 			$this->startrow=$this->pagesize * ($this->page - 1);
		$sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT {$fields} FROM `".DB_TABLE_PREFIX."{$this->table}` as `tb` {$l} {$wh} {$sr} LIMIT {$this->startrow},{$this->pagesize}";
		_trace($sql);
		$this->rs= mysql_query($sql);
		$sql = 'SELECT FOUND_ROWS()';
		$t_rs = mysql_query($sql);
		$row = mysql_fetch_row($t_rs);
		mysql_free_result($t_rs);
		$this->rowcount = (int)$row[0];
		$this->pagecount = ceil($this->rowcount/$this->pagesize);
		$this->endrow = (++$this->startrow) + $this->pagesize;
		if($this->endrow > $this->rowcount) $this->endrow = $this->rowcount;
		return true; //open
	}
}
class itemflatlist extends itemlist{ //item without category
	function del(){
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)){
			global $sql;
			$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.$this->table.'` WHERE `id` IN ('.$this->id.')';
			_trace($sql);
			return mysql_query($sql);
		}
	}
	function open($fields,$search=''){
		global $sql;
		switch($this->sortby){
			case SORTBY_NAME_ASC:       $sr = ' ORDER BY `tb`.`name` ASC'; break;
			case SORTBY_NAME_DESC:      $sr = ' ORDER BY `tb`.`name` DESC'; break;
			case SORTBY_VIEW_DESC:      $sr = ' ORDER BY `tb`.`view` DESC'; break;
			case SORTBY_CREATED_DESC:   $sr = ' ORDER BY `tb`.`created` DESC';break;
			case SORTBY_CREATED_ASC: 	$sr = 'ORDER BY `tb`.`created` ASC';break;
			case SORTBY_ID_DESC: 	    $sr = 'ORDER BY `tb`.`id` DESC';break;
			case SORTBY_ID_ASC: 	    $sr = 'ORDER BY `tb`.`id` ASC';break;
			default:
				$this->sortby=SORTBY_VIEW_ASC;//default to sort by view ascending
				$sr = ' ORDER BY `tb`.`view` ASC';
		}
		$wh = 'WHERE '. $search;
		if($this->ctrl){
			if($this->ctrl_){
				$wh .= " AND `tb`.`ctrl` & {$this->ctrl} = 0";
			}else{
				$wh .= " AND `tb`.`ctrl` & {$this->ctrl} = {$this->ctrl}";
			}
		}
		if($wh == 'WHERE ') $wh = '';
		else $wh = str_replace('WHERE  AND',' WHERE ',$wh);
		if($this->pagesize > 200 || $this->pagesize < 5) $this->pagesize=20;
		if($this->page <1) $this->page=1;
		if($this->page == 1) 
			$this->startrow = 0;
		else
 			$this->startrow=$this->pagesize * ($this->page - 1);
		$sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT  {$fields} FROM `".DB_TABLE_PREFIX."{$this->table}` as `tb` {$wh} {$sr} LIMIT {$this->startrow},{$this->pagesize}";
		_trace($sql);	
		$this->rs= mysql_query($sql);
		$sql = 'SELECT FOUND_ROWS()';
		$t_rs = mysql_query($sql);
		$row = mysql_fetch_row($t_rs);
		mysql_free_result($t_rs);
		$this->rowcount = (int)$row[0];
		$this->pagecount = ceil($this->rowcount/$this->pagesize);
		$this->endrow = (++$this->startrow) + $this->pagesize;
		if($this->endrow > $this->rowcount) $this->endrow = $this->rowcount;
		$this->grandparentid = -1;
		return true; //open	
	}
//kiem tra ten trung nhau
/*	function checkSameName(dbname){
		global $sql;
		$sql = 'SELECT `name` FROM `'.DB_TABLE_PREFIX.dbname'`';
		$rs = mysql_query($sql);
		while($row = mysql_fetch_assoc($rs)){
			
		}
	}*/
}
?>