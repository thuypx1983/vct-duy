<?php /* 
 */
function agentlist($type=NULL,$top=NULL,$ctrl=AGENT_CTRL_SHOW){
	global $sql;
	if(!is_int($ctrl)) return FALSE;
	$wh = ' WHERE `a`.`ctrl` & '.$ctrl.' = '.$ctrl;
	if(is_int($type)) $wh .= ' AND `a`.`type`='.$type;
	if(is_int($top)) $lm = 'LIMIT '.$top;else $lm='';
	$sql = 'SELECT `a`.`id`,`a`.`name`,`a`.`address`,`a`.`cityid`,`a`.`city`,`a`.`detail`,`a`.`phone`,`a`.`img`,`a`.`alt`,`a`.`contact`,`a`.`email`,`a`.`contactphone`,`a`.`ctrl`,`a`.`fax`,`a`.`website`
        FROM `'.DB_TABLE_PREFIX.'agent` as `a`  '.$wh.'  ORDER BY `a`.`view` ASC  '.$lm;
	return mysql_query($sql);
 }
function agentopen($id=NULL){
	global $sql;
 	if(!is_int($id)) $id = (int)@$_SESSION['USid'];
	$sql = 'SELECT `id`,`name`, `address`, `cityid`, `city`, `detail`, `phone`, `img`, `alt`, `contact`, `email`, `contactphone`, `ctrl`, `website`, `fax`, `countryid`, `country`, `password` FROM `'.DB_TABLE_PREFIX.'agent` WHERE `id` = '.$id; 
	
  $o = mysql_fetch_object($rs=mysql_query($sql));
	mysql_free_result($rs);
	return $o;
}
function agentsave(&$ag){
	$ag->id = (int)@$_SESSION['USagentid'];
	return $ag->updaterow();
}
function agentpagelist($page,&$pagecount,$pagesize,$type=NULL,$ctrl=AGENT_CTRL_SHOW,$filter=NULL){
	global $sql,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND;
	if(!is_int($ctrl)) return FALSE;
	$wh = ' WHERE `a`.`ctrl` & '.$ctrl.' = '.$ctrl;
	if($filter) $wh .= ' AND ('.$filter.')';
	if(is_int($type)) $wh .= ' AND `a`.`type`='.$type;
	if(is_int($page) && is_int($pagesize) && $pagesize >= 1){//must be number
		$ESNC_ROWSTART=$pagesize * ($page -1);
		$lm = ' LIMIT '.$ESNC_ROWSTART.','.$pagesize;
	}else
		$lm='';
	$sql = 'SELECT SQL_CALC_FOUND_ROWS `a`.`id`,`a`.`name`,`a`.`address`,`a`.`cityid`,`a`.`city`,`a`.`detail`,`a`.`phone`,`a`.`img`,`a`.`alt`,`a`.`contact`,`a`.`email`,`a`.`contactphone`,`a`.`ctrl`,`a`.`fax`,`a`.`website`
    FROM `'.DB_TABLE_PREFIX.'agent` as `a`  '.$wh.'  ORDER BY `a`.`view` ASC  '.$lm;
	
	$rs = mysql_query($sql);
	$sql = 'SELECT FOUND_ROWS()';
	$rs1 = mysql_query($sql);
	$row = mysql_fetch_row($rs1);
	mysql_free_result($rs1);
	$ESNC_ROWCOUNT=(int)$row[0];
	$ESNC_ROWEND = (++$ESNC_ROWSTART) + $pagesize;
	if($ESNC_ROWEND > $ESNC_ROWCOUNT) $ESNC_ROWEND = $ESNC_ROWCOUNT;
	$pagecount = ceil($ESNC_ROWCOUNT/$pagesize);
	return $rs;
 }

function agentpagelistlocal($page,&$pagecount,$pagesize,$type=NULL,$cityid,$ctrl=AGENT_CTRL_SHOW){
	global $sql,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND;
	if(!is_int($ctrl)) return FALSE;
	if(!isset($cityid)) return FALSE;
	$wh = ' WHERE `a`.`ctrl` & '.$ctrl.' = '.$ctrl.' AND `a`.`cityid`='.$cityid;
	if(is_int($type)) $wh .= ' AND `a`.`type`='.$type;
	if(is_int($page) && is_int($pagesize) && $pagesize >= 1){//must be number
		$ESNC_ROWSTART=$pagesize * ($page -1);
		$lm = ' LIMIT '.$ESNC_ROWSTART.','.$pagesize;
	}else
		$lm='';
	$sql = 'SELECT SQL_CALC_FOUND_ROWS `a`.`id`,`a`.`name`,`a`.`address`,`a`.`cityid`,`a`.`city`,`a`.`detail`,`a`.`phone`,`a`.`img`,`a`.`alt`,`a`.`contact`,`a`.`email`,`a`.`contactphone`,`a`.`ctrl`,`a`.`fax`,`a`.`website`
    FROM `'.DB_TABLE_PREFIX.'agent` as `a`  '.$wh.'  ORDER BY `a`.`view` ASC  '.$lm;
	
	$rs = mysql_query($sql);
	$sql = 'SELECT FOUND_ROWS()';
	$rs1 = mysql_query($sql);
	$row = mysql_fetch_row($rs1);
	mysql_free_result($rs1);
	$ESNC_ROWCOUNT=(int)$row[0];
	$ESNC_ROWEND = (++$ESNC_ROWSTART) + $pagesize;
	if($ESNC_ROWEND > $ESNC_ROWCOUNT) $ESNC_ROWEND = $ESNC_ROWCOUNT;
	$pagecount = ceil($ESNC_ROWCOUNT/$pagesize);
	return $rs;
 }

?>