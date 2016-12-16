<?php /* vinhtx@esnadvanced.com 19-May-2005 */
class folderlist{
	var $rs,$pagecount,$grandparentid,$id,$ctrl,$idvalue,$parentid,$keyword,$ctrl_;
	var $table,$tbitem;
	function del(){
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)){
			$sql = "DELETE FROM `".DB_TABLE_PREFIX."{$this->table}` WHERE `id` IN ({$this->id})";
			_trace($sql);
			return mysql_query($sql);
		}
		return FALSE;
	}
	function setctrl(){
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)){
			if( is_int($this->ctrl)){
				$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `ctrl` = `ctrl` | {$this->ctrl} WHERE `id` IN ({$this->id})";
				_trace($sql);
				if(!mysql_query($sql)) return FALSE;
			}
			if( is_int($this->nctrl)){
				$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `ctrl` = `ctrl` & ~{$this->nctrl} WHERE `id` IN ({$this->id})";
				_trace($sql);
				if(!mysql_query($sql)) return FALSE;
			}
		}
		return TRUE;
	}
	function unsetctrl(){
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id) && is_int($this->ctrl)){
			$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `ctrl` = `ctrl` & ~{$this->ctrl} WHERE `id` IN ({$this->id})";
			_trace($sql);
			return mysql_query($sql);
		}
		return FALSE;
	}
	function moveto(){
		settype($this->parentid,'int');
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)){
			if($this->id != $this->parentid){
				if(strpos($this->id,$this->parentid.',') === FALSE){
					$sql = "SELECT `l`.`{$this->tbitem}id` FROM `".DB_TABLE_PREFIX."{$this->table}{$this->tbitem}` as `l` WHERE `l`.`{$this->table}id`".($this->parentid <=0 ? " IS NULL" : " = {$this->parentid}") ." LIMIT 1";//check if parent id containt product
					_trace($sql);
					if(mysql_fetch_row($this->rs = mysql_query($sql))) { mysql_free_result($this->rs); return false; }//contain product
					$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `parentid` = ".($this->parentid <=0 ? 'NULL': $this->parentid). " WHERE `id` IN ({$this->id}) ";
					_trace($sql);
					return mysql_query($sql);
				}
			}
		}
		return FALSE;
	}
	function reorder(){
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
		settype($this->id,"int");
		$sql = "UPDATE `".DB_TABLE_PREFIX."{$this->table}` SET `name` = '".mysql_escape_string($this->name)."' WHERE `id` = {$this->id}";
		_trace($sql);
		return mysql_query($sql);
	}
	function open(){
		switch($this->sortby){
			case SORTBY_NAME_ASC: $sr = ' ORDER BY `tb`.`name` ASC'; break;
			case SORTBY_NAME_DESC: $sr = ' ORDER BY `tb`.`name` DESC'; break;
			case SORTBY_VIEW_DESC: $sr = ' ORDER BY `tb`.`view` DESC'; break;
/*			case SORTBY_CREATED_DESC: $sr = ' ORDER BY `tb`.`created` DESC';break;
			case SORTBY_CREATED_ASC: 	$sr = 'ORDER BY `tb`.`created` ASC';break;*/
			default:
				$this->sortby=SORTBY_VIEW_ASC;//default to sort by view ascending
				$sr = ' ORDER BY `tb`.`view` ASC,`tb`.`id` ASC';
		}
		$hint = str_replace('*','%',mysql_escape_string($this->keyword));
		if($this->parentid === NULL || $this->parentid == -1 || $this->parentid == 0){ $wh = 'WHERE (`tb`.`parentid` IS NULL  OR `tb`.`parentid` = -1 OR `tb`.`parentid` = 0)';}//root folder
		else if(isset($_GET[$this->alias.'parentid'])) { $wh = 'WHERE `tb`.`parentid` = '.(int)$this->parentid; }//dont care if not set
		if($hint != ''){
			if($wh != '') $wh .= " AND `tb`.`name` LIKE '{$hint}'";
			else $wh = "WHERE `tb`.`name` LIKE '{$hint}'";
		}
		if($this->ctrl){
			if($this->ctrl_){
				if($wh != '') $wh .= " AND `tb`.`ctrl` & {$this->ctrl} = 0";
				else $wh = " WHERE `tb`.`ctrl` & {$this->ctrl} = 0";
			}else{
				if($wh != '') $wh .= " AND `tb`.`ctrl` & {$this->ctrl} = {$this->ctrl}";
				else $wh = " WHERE `tb`.`ctrl` & {$this->ctrl} = {$this->ctrl}";
			}
		}
		if($this->pagesize < 200 && $this->pagesize > 19){ //only count if valid request
			$sql = "SELECT COUNT(*) FROM `".DB_TABLE_PREFIX."{$this->table}` as `tb` {$wh}";
			_trace($sql);
			if($row = mysql_fetch_row($this->rs=mysql_query($sql))) $this->pagecount = ceil((int)$row[0] / $this->pagesize);
			else	$this->pagecount =1;
			mysql_free_result($this->rs);
			if($this->page > $this->pagecount) $this->page = $this->pagecount;
			elseif($this->page < 1) $this->page = 1;
			if($this->page > 1){
				$pagestart = $this->page > 1 ? ($this->page - 1) * $this->pagesize : 0;
				$limit = "LIMIT {$pagestart}, {$this->pagesize}";
			}
			else $limit = "LIMIT {$this->pagesize}";
		}else $limit='';
		if($this->parentid !== NULL){
			$sql = "SELECT `parentid` FROM `".DB_TABLE_PREFIX."{$this->table}` WHERE `id`={$this->parentid}";
			_trace($sql);
			if($row = mysql_fetch_row($this->rs=mysql_query($sql)))	$this->grandparentid = (int)$row[0];
			else $this->grandparentid = NULL;
			mysql_free_result($this->rs);
		}else $this->grandparentid = NULL;
		$sql = "SELECT DISTINCT `tb`.`id`,`tb`.`name`,`tb`.`view`,`tb`.`ctrl`, IF(`c`.`id` IS NULL, IF(`l`.`{$this->tbitem}id` IS NULL, 0, 1),2) as `flag` FROM `".DB_TABLE_PREFIX."{$this->table}` as `tb` LEFT JOIN `".DB_TABLE_PREFIX."{$this->table}` as `c` ON `tb`.`id` = `c`.`parentid` LEFT JOIN `".DB_TABLE_PREFIX."{$this->table}{$this->tbitem}` as `l` ON `tb`.`id` = `l`.`cat{$this->tbitem}id` {$wh} {$sr} {$limit}";
		_trace($sql);
		$this->rs= mysql_query($sql);
		return true; //open
	}
	function check(){
		$id = (int)$this->parentid;
		if($id == -1) return CAT_FLAG_ROOT;
		$sql='SELECT 3 as `flag`  FROM `'.DB_TABLE_PREFIX.$this->table.'` WHERE `id` = '.$id.' UNION SELECT 1 as `flag` FROM `'.DB_TABLE_PREFIX.$this->table.$this->tbitem.'` WHERE `cat'.$this->tbitem.'id` = '.$id.' UNION SELECT 2 as `flag`  FROM `'.DB_TABLE_PREFIX.$this->table.'` WHERE `parentid`='.$id;
		_trace($sql);
		$rs = mysql_query($sql);
		if($row=mysql_fetch_row($rs)){
			if($row[0] == 3){ // this category must exists
				$flag=CAT_FLAG_EMPTY;
				if($row=mysql_fetch_row($rs)){//
					if($row[0] == 1) $flag |=CAT_FLAG_ITEM;
					elseif($row[0] == 2) $flag |=CAT_FLAG_SUBCAT;
					if($row=mysql_fetch_row($rs)){
						if($row[0] == 2) $flag |=CAT_FLAG_SUBCAT;
					}
				}
				mysql_free_result($rs);
				return $flag;//empty category
			}
		}
		return CAT_FLAG_NOEXIST;//this is not valid category
	}
}//class
?>
