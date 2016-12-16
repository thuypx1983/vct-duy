<?php
//vinhtx@esnadvanced.com
class productphotoitem extends productphoto{
	var $rs;
	function search(){
		global $sql;
		global $PPpage,$PPpagesize,$PPpagecount,$PPstartrow,$PProwcount,$PPhint;
		$wh = ' WHERE';
		if($PPhint){
			$t = '%'.mysql_real_escape_string($PPhint).'%';
			$wh .= ' AND (`img` LIKE \''.$t.'\' OR `name` LIKE \''.$t.'\' OR `alt` LIKE \''.$t.'\')';
		}
		if(is_int($this->productid)){
			$wh .= ' AND `productid`='.$this->productid;
		}
		if($wh == ' WHERE') $wh = ''; else $wh = str_replace(' WHERE AND',' WHERE ',$wh);
		if($PPpage < 1) $PPpage = 1;
		if($PPpagesize < 30) $PPpagesize = 30;
		$PPstartrow = ($PPpage - 1) * $PPpagesize;
		$sql = 'SELECT SQL_CALC_FOUND_ROWS  `name`,`img`, `alt`, `productid`, `view`, `url`, `ctrl` FROM `'.DB_TABLE_PREFIX.'productphoto` '. $wh. ' ORDER BY `productid`,`view` LIMIT '.$PPstartrow.','.$PPpagesize;
		$this->rs = mysql_exec($sql);
		$sql = 'SELECT FOUND_ROWS()';
		$row = mysql_fetch_row($rs1 = mysql_query($sql));
		$PProwcount = (int)$row[0];
		mysql_free_result($rs1);
	}
	function setctrl(){
	}
	function reorder(&$a_imgview){
		global $sql;
		asort($a_imgview);
		$view=1;
		foreach($a_imgview as $img=>$vv){
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'productphoto` SET `view` = '.(int)$view.' WHERE `productid`='.(int)$this->productid.' AND `img`=\''.mysql_real_escape_string($img).'\'';
			mysql_exec($sql);
			++$view;
		}
	}
	function remove($img){
		global $sql;
		$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'productphoto` WHERE `productid`='.(int)$this->productid.' AND `img`=\''.mysql_real_escape_string($img).'\'';
		return mysql_exec($sql);
	}
}
?>