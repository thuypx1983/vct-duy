<?php
//vinhtx@esnadvanced.com
function bannerlist($ctrl=BANNER_CTRL_SHOW,$catid=NULL,$top=NULL){
	global $sql;
	if(!is_int($ctrl)) return FALSE;
	if(is_int($catid)) $tbcat = " INNER JOIN `".DB_TABLE_PREFIX."catbannerbanner` as `b` ON `a`.`id` = `b`.`bannerid` AND `b`.`catbannerid` = {$catid}";else $tbcat='';
	$wh = " WHERE `a`.`ctrl` & {$ctrl} = {$ctrl}";
	if(is_int($top)) $lm = " LIMIT {$top}";else $lm="";
	$sql="SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`width`,`a`.`mybanner`,`a`.`height`,`a`.`url`,`a`.`view`,`a`.`created`,`a`.`ctrl`,`a`.`img`,`a`.`alt`,`a`.`target`,`a`.`click`,`a`.`desc`		FROM `".DB_TABLE_PREFIX."banner` as `a` {$tbcat} {$wh} ORDER BY `a`.`view` ASC {$lm}";
	return mysql_query($sql);
}
function catbannerlist($ctrl=CATBANNER_CTRL_SHOW,$parentid=NULL,$top=100000,$view=NULL,$hint=NULL){
	global $sql;
	if(!is_int($ctrl)) return FALSE;
	$sql= (!is_int($parentid)) ? 
		"SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid` FROM `".DB_TABLE_PREFIX."catbanner` as `a` WHERE `a`.`ctrl` & {$ctrl} = {$ctrl}  ORDER BY `a`.`view`,`a`.`id` LIMIT {$top}"
		:"SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid` FROM `".DB_TABLE_PREFIX."catbanner` as `a` WHERE `a`.`ctrl` & {$ctrl} = {$ctrl} AND `a`.`parentid` = {$parentid} ORDER BY `a`.`view`,`a`.`id` LIMIT {$top}";
	return mysql_query($sql);
}

function catbannerread($id){
	global $sql;
	$sql="SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid` FROM `".DB_TABLE_PREFIX."catbanner` as `a` WHERE `a`.`id` = {$id} ORDER BY `a`.`view`,`a`.`id`";
	return mysql_query($sql);
}
function bannerpagelist(&$page,&$pagecount,$pagesize=100,$catid=NULL,$ctrl=BANNER_CTRL_SHOW,$hint=NULL){
	global $sql,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND;
	if(is_int($catid))
		$tbcat = ' INNER JOIN `'.DB_TABLE_PREFIX.'catbannerbanner` as `b` ON `a`.`id`=`b`.`bannerid` AND `b`.`catbannerid` = '.$catid;
	else 
		$tbcat = '';
	if(is_int($ctrl) && $ctrl){
		$wh = ' WHERE `a`.`ctrl` & '.$ctrl.'='.$ctrl;
	}else
		$wh = '';
	if($page <1) $page=1;
	$ESNC_ROWSTART=($page-1) * $pagesize;
	if(!is_int($pagesize) || $pagesize < 1)
		trigger_error('Tham s&#7889; pagesize ph&#7843;i l&agrave; m&#7897;t s&#7889; nguy&ecirc;n &gt; 0',E_USER_ERROR);
	$sql = 'SELECT SQL_CALC_FOUND_ROWS DISTINCT `a`.`id`,`name`,`a`.`url`,`a`.`mybanner`,`a`.`width`,`a`.`height`,`a`.`target`,`a`.`view`,`a`.`img`,`a`.`alt`,`a`.`created`,`a`.`expires`,`a`.`desc`,`a`.`ctrl`,`a`.`status`,`a`.`click`
FROM `'.DB_TABLE_PREFIX.'banner` as `a`'.$tbcat.$wh. ' ORDER BY `a`.`view` ASC,`a`.`ID` ASC LIMIT '.$ESNC_ROWSTART.','.$pagesize;
	_trace($sql);
	$rs = mysql_query($sql);
	$sql = 'SELECT FOUND_ROWS()';
	$rs1 = mysql_query($sql);
	$row = mysql_fetch_row($rs1);
	$ESNC_ROWCOUNT = (int)$row[0];
	$pagecount = (int)ceil($ESNC_ROWCOUNT/$pagesize);
	$ESNC_ROWEND = $ESNC_ROWCOUNT + $pagesize;
	return $rs;
}
function bannerread($id){
	if(is_int($id)){
        $sql="SELECT `id`,`name`,`width`,`height`,`url`,`view`,`created`,`ctrl`,`img`,`alt`,`target`,`desc`,`detail`,`click`,`expires`,`mybanner`,`contactid` FROM `".DB_TABLE_PREFIX."banner` WHERE `id`=".$id;
		return mysql_fetch_object(mysql_query ($sql));
	}
	return FALSE;
}
function bannerclick($id){
	if(is_int($id)){
		$sql = "UPDATE `".DB_TABLE_PREFIX."banner` SET `click` = `click` + 1 WHERE `id` = ".$id;
		return mysql_query ($sql);
	}
	return FALSE;
}
function catbannertrack($ids){
	if(is_int($ids)){
		$sql = 'SELECT `id`,`name` FROM `'.DB_TABLE_PREFIX.'catbanner` WHERE `id` = '.$ids;
	}else{
		$a_id = explode(',',$ids);
		$a_sql = array();
		foreach($a_id as $id)	$a_sql[] = 'SELECT `id`,`name` FROM `'.DB_TABLE_PREFIX.'catbanner` WHERE `id` = '.(int)$id;
		$sql = join($a_sql,' UNION ');
	}
	return mysql_query($sql);
}
function bannershow(&$o,$style='',$name=TRUE,$onclick=''){
/*showbanner($o): show the banner and make link if any
	$o: banner object with properties
*/
	if($o->url){
		echo '<a href="';echo $o->url;echo '" title="';echo $o->name;echo '" target="';echo $o->target;
		echo '" onclick="bannerClick(';
		echo $o->id;
		echo ');';
		echo $onclick;
		echo '" >';
	}
	if($o->width) $style .= ' width="'.$o->width.'"';
	if($o->height) $style .= ' height="'.$o->height.'"';
	$style .= ' alt="'.$o->alt.'"';
	if($o->name) $style .= ' title="'.$o->name.'"';
	htmlview(URL_BANNER_IMG,$o->img,$style,$name ? $o->name: '');
	if($o->url) echo '</a>';
}
function catbannerpage($catid,$pagesize=40,$ctrl = 0){
	global $sql;
	$sql = 'SELECT count(DISTINCT bannerid) FROM '.DB_TABLE_PREFIX.'catbannerbanner as a WHERE catbannerid='.(int)$catid;
	_trace($sql);
	$rs=mysql_query($sql);
	$row = mysql_fetch_row($rs);
	mysql_free_result($rs);
	return ceil($row[0]/$pagesize);
}
function bannercount($catid,$ctrl = 0){
	global $sql;
	$sql = 'SELECT count(DISTINCT bannerid) FROM '.DB_TABLE_PREFIX.'catbannerbanner as a WHERE catbannerid='.(int)$catid;
	_trace($sql);
	$rscount=mysql_query($sql);
	$row = mysql_fetch_row($rscount);
	mysql_free_result($rscount);
	return (int)$row[0];
}


?>