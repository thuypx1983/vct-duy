<?php /* vinhtx@esnadvanced.com 14-Mar-2006 */
$urlrewr='';
if(isset($_GET['url'])) $urlrewr=$_GET['url'];
function catnewslist($ctrl=CATNEWS_CTRL_SHOW,$parentid=NULL,$top=100000){
	/* list all catnews for specified ctrl, 
	$ctrl=CATNEWS_CTRL_HOME|CATNEWS_CTRL_MENU|CATNEWS_CTRL_SHOW */
	global $sql;
	if(!is_int($ctrl)) return FALSE;//at least CTRL_SHOW must be specified
	if($parentid == NULL)
		$sql = "SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`urlrewrite`,`a`.`parentid`,IF(`c`.`id` IS NULL,IF(`i`.`newsid` IS NULL,0,1),2) as `flag` FROM `".DB_TABLE_PREFIX."catnews` as `a` LEFT JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `a`.`id` = `c`.`parentid` AND `c`.`ctrl` & {$ctrl} = {$ctrl} LEFT JOIN `".DB_TABLE_PREFIX."catnewsnews` as `i` ON `a`.`id` = `i`.`catnewsid` WHERE `a`.`ctrl` & {$ctrl} = {$ctrl} ORDER BY `a`.`parentid`,`a`.`view` LIMIT {$top}";
	elseif($parentid == CAT_FLAG_ROOT)
		$sql = "SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`urlrewrite`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid`,IF(`c`.`id` IS NULL,IF(`i`.`newsid` IS NULL,0,1),2) as `flag` FROM `".DB_TABLE_PREFIX."catnews` as `a` LEFT JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `a`.`id` = `c`.`parentid` AND `c`.`ctrl` & {$ctrl} = {$ctrl} LEFT JOIN `".DB_TABLE_PREFIX."catnewsnews` as `i` ON `a`.`id` = `i`.`catnewsid` WHERE `a`.`ctrl` & {$ctrl} = {$ctrl} AND `a`.`parentid` IS NULL OR `a`.`parentid` = -1 OR `a`.`parentid`=0 ORDER BY `a`.`parentid`,`a`.`view` LIMIT {$top} ";
	else
		$sql = "SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`urlrewrite`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid`,IF(`c`.`id` IS NULL,IF(`i`.`newsid` IS NULL,0,1),2) as `flag` FROM `".DB_TABLE_PREFIX."catnews` as `a` LEFT JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `a`.`id` = `c`.`parentid` AND `c`.`ctrl` & {$ctrl} = {$ctrl} LEFT JOIN `".DB_TABLE_PREFIX."catnewsnews` as `i` ON `a`.`id` = `i`.`catnewsid` WHERE `a`.`ctrl` & {$ctrl} = {$ctrl} AND `a`.`parentid` = {$parentid} ORDER BY `a`.`parentid`,`a`.`view` LIMIT {$top} ";	
	return mysql_query($sql);
}
function catnewsopen(&$id,$ii=NULL){
	global $sql,$urlrewr;
	if(!$id && $ii > 0){
		$sql = 'SELECT `a`.`catnewsid` FROM `'.DB_TABLE_PREFIX.'catnewsnews` as `a` WHERE `newsid`='.(int)$ii;
		if($row = mysql_fetch_row($rs=mysql_query($sql))) $id = (int)$row[0];
		mysql_free_result($rs);
	}
	if($id!=NULL) {
	$sql = 'SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`view`,`a`.`desc`,`a`.`parentid`,`a`.`urlrewrite` FROM `'.DB_TABLE_PREFIX.'catnews` as `a` WHERE `id`='.(int)$id;
	} else {
	$sql = 'SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`view`,`a`.`desc`,`a`.`parentid`,`a`.`urlrewrite` FROM `'.DB_TABLE_PREFIX.'catnews` as `a` WHERE '.(trim($urlrewr)!=''?'`a`.`urlrewrite`="'.$urlrewr.'"':'');
	}
	@$o = mysql_fetch_object($rs = mysql_query($sql));
	mysql_free_result(@$rs);  // ????
	return @$o;
}
function newslist($catnewsid=NULL,$ctrl=NEWS_CTRL_SHOW,$num=1,$notctrl = 0){
	global $sql,$urlrewr;
	if(!is_int($ctrl)||!is_int($notctrl)) return FALSE;//at least CTRL_SHOW must be specified
	if($notctrl)
		$notctl = ' AND `nw`.`ctrl` & '.$notctrl.' = 0';
	else $notctl = '';
	if($catnewsid!=NULL && $catnewsid!=0){			
		$sql= 'select `id` from `'.DB_TABLE_PREFIX.'catnews` where `ctrl` & '.(0x00000400).' = '.(0x00000400).' and `id`='.$catnewsid;
		$rs = mysql_query($sql);
		if($row=mysql_fetch_row($rs)){
		// ngocdq sua order by theo truong `view` - ngay 1/7/2009
			$sql = "SELECT `nw`.`content`,`nw`.`id`,`nw`.`name`,`nw`.`ctrl`,`nw`.`summary`,`nw`.`urlrewrite`,`nw`.`creator`,DATE_FORMAT(`nw`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`nw`.`img1`,`nw`.`alt1`,`c`.`id` `catnewsid`,`c`.`name` `catnewsname`,`c`.`urlrewrite` `caturlrewrite` FROM  
					`".DB_TABLE_PREFIX."news` as `nw` INNER JOIN `".DB_TABLE_PREFIX."catnewsnews` as `nwcat`
					ON `nw`.`id` = `nwcat`.`newsid` INNER JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `nwcat`.`catnewsid` = `c`.`id` WHERE `nwcat`.`catnewsid` = {$catnewsid} AND `nw`.`ctrl` & {$ctrl} = {$ctrl} {$notctl} ORDER BY `nw`.`view` ASC, `nw`.`created` DESC LIMIT {$num}";
		}else{
			$sql = "SELECT `nw`.`content`,`nw`.`id`,`nw`.`name`,`nw`.`ctrl`,`nw`.`urlrewrite`,`nw`.`summary`,`nw`.`creator`,DATE_FORMAT(`nw`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`nw`.`img1`,`nw`.`alt1`,`c`.`id` `catnewsid`,`c`.`name` `catnewsname`,`c`.`urlrewrite` `caturlrewrite` FROM  
					`".DB_TABLE_PREFIX."news` as `nw` INNER JOIN `".DB_TABLE_PREFIX."catnewsnews` as `nwcat` 
					ON `nw`.`id` = `nwcat`.`newsid` INNER JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `nwcat`.`catnewsid` = `c`.`id` WHERE `nwcat`.`catnewsid` = {$catnewsid} AND `nw`.`ctrl` & {$ctrl} = {$ctrl} {$notctl} ORDER BY `nw`.`view` ASC,`nw`.`created` DESC LIMIT {$num}";
		}
	}else{
		$sql = "SELECT `nw`.`content`,`nw`.`id`,`nw`.`name`,`nw`.`ctrl`,`nw`.`summary`,`nw`.`creator`,DATE_FORMAT(`nw`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`nw`.`img1`,`nw`.`alt1`,`nw`.`urlrewrite`,`c`.`id` `catnewsid`,`c`.`name` `catnewsname`,`c`.`urlrewrite` `caturlrewrite` FROM `".DB_TABLE_PREFIX."news` as `nw`  INNER JOIN `".DB_TABLE_PREFIX."catnewsnews` as `b` ON `nw`.`id` = `b`.`newsid`  INNER JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `b`.`catnewsid` = `c`.`id` ".($catnewsid!=0 && trim($urlrewr)!=''?"and `c`.`urlrewrite`='{$urlrewr}'":"")." WHERE `nw`.`ctrl` & {$ctrl} = {$ctrl} {$notctl} ORDER BY `nw`.`view` ASC,`nw`.`created` DESC,`nw`.`id` DESC LIMIT {$num}";	
	}
	return mysql_query($sql);
}

function newslistthaibinh($catnewsid=NULL,$ctrl=NEWS_CTRL_SHOW,$num=1,$notctrl = 0,$date=NULL,$key=''){
	global $sql,$urlrewr;
	if(!is_int($ctrl)||!is_int($notctrl)) return FALSE;//at least CTRL_SHOW must be specified
	if($notctrl) $notctl = ' AND `nw`.`ctrl` & '.$notctrl.' = 0';
	else $notctl = '';
	if($date!=NULL) $dateq = ' AND `nw`.`created` <= "'.$date.'"';
	if($catnewsid!=NULL){			
		$sql= 'select `id` from `'.DB_TABLE_PREFIX.'catnews` where `ctrl` & '.(0x00000400).' = '.(0x00000400).' and `id`='.$catnewsid;
		$rs = mysql_query($sql);
		if($row=mysql_fetch_row($rs)){
		// ngocdq sua order by theo truong `view` - ngay 1/7/2009
			$sql = "SELECT `nw`.`id`,`nw`.`name`,`nw`.`ctrl`,`nw`.`tag`,`nw`.`summary`,`nw`.`urlrewrite`,`nw`.`creator`,DATE_FORMAT(`nw`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`nw`.`img1`,`nw`.`alt1`,`c`.`id` `catnewsid`,`c`.`name` `catnewsname`,`c`.`urlrewrite` `caturlrewrite` FROM  
					`".DB_TABLE_PREFIX."news` as `nw` INNER JOIN `".DB_TABLE_PREFIX."catnewsnews` as `nwcat`
					ON `nw`.`id` = `nwcat`.`newsid` INNER JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `nwcat`.`catnewsid` = `c`.`id` WHERE `nwcat`.`catnewsid` = {$catnewsid} ".($key!=""?"AND `nw`.`name` like '%{$key}%'":"")." AND `nw`.`ctrl` & {$ctrl} = {$ctrl} {$notctl}  {$dateq} ORDER BY `nw`.`view` ASC, `nw`.`created` DESC LIMIT {$num}";
		}else{
			$sql = "SELECT `nw`.`id`,`nw`.`name`,`nw`.`ctrl`,`nw`.`tag`,`nw`.`urlrewrite`,`nw`.`summary`,`nw`.`creator`,DATE_FORMAT(`nw`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`nw`.`img1`,`nw`.`alt1`,`c`.`id` `catnewsid`,`c`.`name` `catnewsname`,`c`.`urlrewrite` `caturlrewrite` FROM  
					`".DB_TABLE_PREFIX."news` as `nw` INNER JOIN `".DB_TABLE_PREFIX."catnewsnews` as `nwcat` 
					ON `nw`.`id` = `nwcat`.`newsid` INNER JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `nwcat`.`catnewsid` = `c`.`id` WHERE `nwcat`.`catnewsid` = {$catnewsid} ".($key!=""?"AND `nw`.`name` like '%{$key}%'":"")." AND `nw`.`ctrl` & {$ctrl} = {$ctrl} {$notctl}  {$dateq} ORDER BY `nw`.`created` DESC,`nw`.`created` DESC LIMIT {$num}";
		}
	}else{
		$sql = "SELECT `nw`.`id`,`nw`.`name`,`nw`.`ctrl`,`nw`.`summary`,`nw`.`tag`,`nw`.`creator`,DATE_FORMAT(`nw`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`nw`.`img1`,`nw`.`alt1`,`nw`.`urlrewrite`,`c`.`id` `catnewsid`,`c`.`name` `catnewsname`,`c`.`urlrewrite` `caturlrewrite` FROM `".DB_TABLE_PREFIX."news` as `nw`  INNER JOIN `".DB_TABLE_PREFIX."catnewsnews` as `b` ON `nw`.`id` = `b`.`newsid`  INNER JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `b`.`catnewsid` = `c`.`id` ".($catnewsid!=0 && trim($urlrewr)!=''?"and `c`.`urlrewrite`='{$urlrewr}'":"")." WHERE `nw`.`ctrl` & {$ctrl} = {$ctrl} ".($key!=""?"AND `nw`.`name` like '%{$key}%'":"")." {$notctl} {$dateq} ORDER BY `nw`.`created` DESC,`nw`.`view` ASC,`nw`.`id` DESC LIMIT {$num}";	
		
	}
	return mysql_query($sql);
}
function newsopen($id,$object=FALSE){
	global $sql,$urlrewr;
	if(!$object) @trigger_error('Parameter $object should be TRUE',@E_USER_NOTICE);
	$sql = "SELECT `nw`.`id`,`nw`.`name`,`nw`.`content`,`nw`.`ctrl`,`nw`.`keyword`,`nw`.`tag`,`nw`.`summary`,`nw`.`creator`,DATE_FORMAT(`nw`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`nw`.`img1`,`nw`.`alt1`,`nw`.`img2`,`nw`.`alt2`,`nw`.`urlrewrite`,`c`.`id` `catnewsid`,`c`.`name` `catnewsname`,`c`.`urlrewrite` `caturlrewrite` FROM `".DB_TABLE_PREFIX."news` as `nw` INNER JOIN `".DB_TABLE_PREFIX."catnewsnews` as `b` ON `nw`.`id` = `b`.`newsid` INNER JOIN `".DB_TABLE_PREFIX."catnews` as `c` ON `b`.`catnewsid` = `c`.`id` WHERE ".($id==NULL?"`nw`.`urlrewrite`='{$urlrewr}'":"`nw`.`id` = {$id}");
	if($object){
		$rs = mysql_query($sql);
		$o = mysql_fetch_object($rs);
		mysql_free_result($rs);
		return $o;
	}
	return mysql_query($sql);
}

function newsread($NWid,&$NWcontent,$rs=NULL){
	global $sql,$urlrewr;
	$sql = "SELECT `nw`.`content` as `_` FROM `".DB_TABLE_PREFIX."news` as `nw` WHERE `nw`.`id` = {$NWid}";
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	if($NWcontent = $row[0]) return;
	$NWcontent = @file_get_contents(PATH_NEWS_CONTENT.'news-'.$NWid.'.htm');
}

function newsopenex(&$id,$cid){// open news or first news of group
	global $sql,$urlrewr;
	settype($id,'int');
	settype($cid,'int');
	if(!$id && $cid > 0){
		$sql='SELECT `id` FROM `'.DB_TABLE_PREFIX.'news` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catnewsnews` as `b` ON `a`.`id`=`b`.`newsid` WHERE `b`.`catnewsid`='.$cid.' ORDER BY `a`.`created` LIMIT 1';//get first news
		_trace($sql);
		$rs = mysql_query($sql);
		$row=mysql_fetch_row($rs);
		mysql_free_result($rs);
		$id=(int)$row[0];
	}
	$sql = "SELECT `nw`.`id`,`nw`.`name`,`nw`.`ctrl`,`nw`.`keyword`,`nw`.`summary`,`nw`.`creator`,DATE_FORMAT(`nw`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`nw`.`img1`,`nw`.`alt1`,`nw`.`img2`,`nw`.`alt2` FROM `".DB_TABLE_PREFIX."news` as `nw` WHERE `nw`.`id` = {$id}";
	$rs = mysql_query($sql);
	$o = mysql_fetch_object($rs);
	mysql_free_result($rs);
	return $o;
}

function newspagelist(&$page,$pagesize,&$pagecount,$hint=NULL,$catid=NULL,$ctrl=NEWS_CTRL_SHOW){  
	global $ESNC_ROWSTART,$ESNC_ROWEND,$ESNC_ROWCOUNT;
	global $sql,$urlrewr;
	$sql = "SELECT SQL_CALC_FOUND_ROWS `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`summary`,`a`.`content`,`a`.`urlrewrite`,`a`.`tag`,`a`.`keyword`,`a`.`creator`,DATE_FORMAT(`a`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`a`.`img1`,`a`.`alt1`,`c`.`id` `catnewsid`,`c`.`name` `catnewsname`,`c`.`urlrewrite` `caturlrewrite` FROM `".DB_TABLE_PREFIX."news` as `a`";
	$wh = '';
	if($catid!=NULL){
		$sql .= ' INNER JOIN  `'.DB_TABLE_PREFIX.'catnewsnews`  as `b`	ON `a`.`id` = `b`.`newsid` INNER JOIN `'.DB_TABLE_PREFIX.'catnews` as `c` ON `b`.`catnewsid` = `c`.`id`';
		$wh .= ' AND `b`.`catnewsid` = '.$catid;
	} else 
	{	
		$sql .= ' INNER JOIN  `'.DB_TABLE_PREFIX.'catnewsnews`  as `b`	ON `a`.`id` = `b`.`newsid` INNER JOIN `'.DB_TABLE_PREFIX.'catnews` as `c` ON `b`.`catnewsid` = `c`.`id` '.(trim($urlrewr)!=''?'and `c`.`urlrewrite`="'.$urlrewr.'"':'');
	}
	if($ctrl > 0)
		$wh .= ' AND `a`.`ctrl` & '.$ctrl.' = '.$ctrl;
	if($hint != NULL && strlen($hint) > 2) {
		$hint = strtr($hint,array('\''=>' '));
//		$hint = preg_replace(array('/^\W*/','/\s+/','/\W*$/'),array('[[:<:]]','[[:>:]].+[[:<:]]','[[:>:]]'),addslashes(mysql_real_escape_string($hint)));
		$wh .= " AND (`a`.`keyword` like '%{$hint}%' OR  `a`.`name` LIKE '%{$hint}%' OR `a`.`summary` LIKE '%{$hint}%' OR `a`.`tag` LIKE '%{$hint}%') ";
	}
	if($wh) $wh = ' WHERE '.substr($wh,4);
	$sql .= $wh.' ORDER BY `a`.`view` ASC,`a`.`created` DESC, `a`.`id` DESC';
	if($page < 1) $page = 1;
	if($pagesize < 2) $pagesize = 2;
	$ESNC_ROWSTART = $pagesize * ($page -1);
	$sql .= ' LIMIT '.$ESNC_ROWSTART.','.$pagesize;
	$ESNC_ROWEND = ++$ESNC_ROWSTART + 1;
	$rs = mysql_query($sql);
	$rs1 = mysql_query('SELECT FOUND_ROWS()');
	$row = mysql_fetch_row($rs1);
	mysql_free_result($rs1);
	$ESNC_ROWCOUNT = (int)$row[0];
	$pagecount = ceil($ESNC_ROWCOUNT/$pagesize);
	if($ESNC_ROWEND > $ESNC_ROWCOUNT) $ESNC_ROWEND = $ESNC_ROWCOUNT;
	return $rs;
}



function newspageSearch(&$page,&$pagesize,&$pagecount,$hint=NULL,$catid=NULL,$ctrl=NEWS_CTRL_SHOW){  
	global $ESNC_ROWSTART,$ESNC_ROWEND,$ESNC_ROWCOUNT;
	global $sql,$urlrewr;
	$sql = "SELECT SQL_CALC_FOUND_ROWS `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`summary`,`a`.`urlrewrite`,`a`.`tag`,`a`.`keyword`,`a`.`creator`,DATE_FORMAT(`a`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`a`.`img1`,`a`.`alt1`,`c`.`id` `catnewsid`,`c`.`name` `catnewsname`,`c`.`urlrewrite` `caturlrewrite` FROM `".DB_TABLE_PREFIX."news` as `a`";
	$wh = '';
	if($catid!=NULL){
		$sql .= ' INNER JOIN  `'.DB_TABLE_PREFIX.'catnewsnews`  as `b`	ON `a`.`id` = `b`.`newsid` INNER JOIN `'.DB_TABLE_PREFIX.'catnews` as `c` ON `b`.`catnewsid` = `c`.`id`';
		$wh .= ' AND `b`.`catnewsid` = '.$catid;
	} else 
	{	
		$sql .= ' INNER JOIN  `'.DB_TABLE_PREFIX.'catnewsnews`  as `b`	ON `a`.`id` = `b`.`newsid` INNER JOIN `'.DB_TABLE_PREFIX.'catnews` as `c` ON `b`.`catnewsid` = `c`.`id` '.(trim($urlrewr)!=''?'and `c`.`urlrewrite`="'.$urlrewr.'"':'');
	}
	if($ctrl > 0)
		$wh .= ' AND `a`.`ctrl` & '.$ctrl.' = '.$ctrl;
	if($hint != NULL && strlen($hint) > 2) {
		$hint = strtr($hint,array('\''=>' '));
//		$hint = preg_replace(array('/^\W*/','/\s+/','/\W*$/'),array('[[:<:]]','[[:>:]].+[[:<:]]','[[:>:]]'),addslashes(mysql_real_escape_string($hint)));
		$wh .= " AND (`a`.`keyword` like '%{$hint}%' OR  `a`.`name` LIKE '%{$hint}%' OR `a`.`summary` LIKE '%{$hint}%' OR `a`.`tag` LIKE '%{$hint}%') ";
	}
	if($wh) $wh = ' WHERE '.substr($wh,4);
	$sql .= $wh.' ORDER BY `a`.`created` DESC, `a`.`view` ASC,`a`.`id` DESC';
	if($page < 1) $page = 1;
	if($pagesize < 4) $pagesize = 4;
	$ESNC_ROWSTART = $pagesize * ($page -1);
	$sql .= ' LIMIT '.$ESNC_ROWSTART.','.$pagesize;
	$ESNC_ROWEND = ++$ESNC_ROWSTART + 1;
	$rs = mysql_query($sql);
	$rs1 = mysql_query('SELECT FOUND_ROWS()');
	$row = mysql_fetch_row($rs1);
	mysql_free_result($rs1);
	$ESNC_ROWCOUNT = (int)$row[0];
	$pagecount = ceil($ESNC_ROWCOUNT/$pagesize);
	if($ESNC_ROWEND > $ESNC_ROWCOUNT) $ESNC_ROWEND = $ESNC_ROWCOUNT;
	return $rs;
}


function newsshow($NWid,$NWctrl=NULL){
	if(!@readfile(PATH_NEWS_CONTENT.'news-'.$NWid.'.htm')){
		global $sql,$urlrewr;
		$sql = "SELECT `nw`.`content` FROM `".DB_TABLE_PREFIX."news` as `nw` WHERE `nw`.`id` = {$NWid}";
		$rs = mysql_query($sql);
		$row=mysql_fetch_row($rs);
		mysql_free_result($rs);
		echo $row[0];
	}
}
function newslistmore($id,$date,$top,&$catid,$ctrl=NEWS_CTRL_SHOW){
	global $sql,$urlrewr;
	if($catid===0){
		$sql = 'SELECT `catnewsid` FROM `'.DB_TABLE_PREFIX.'catnewsnews` WHERE `newsid`='.$id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		$catid = (int)$row[0];
		mysql_free_result($rs);
	}
	$str= 'select `id` from `'.DB_TABLE_PREFIX.'catnews` where `ctrl` & '.(0x00000400).' = '.(0x00000400).' and `id`='.$catid;
	$srs = mysql_query($str);
	$wh ='';
	if($rw = mysql_fetch_row($srs)){
		if(is_int($id) && is_int($top) && is_int($ctrl)){
			$sql = 'SELECT `view` FROM `'.DB_TABLE_PREFIX.'news` WHERE `id`='.$id;
			$rs = mysql_query($sql);
			$row = mysql_fetch_row($rs);
			mysql_free_result($rs);
			$view = (int)$row[0];
			$sql = 'SELECT `a`.`id`,`a`.`name`,`a`.`creator`,DATE_FORMAT(`a`.`created`,\''.FORMAT_DB_DATETIME.'\') as `created`,`a`.`summary`,`a`.`img1`,`a`.`alt1`,`a`.`ctrl` FROM `'.DB_TABLE_PREFIX.'news` as `a`';
			if(is_int($catid)){			
				$sql .= ' INNER JOIN `'.DB_TABLE_PREFIX.'catnewsnews` as `b` ON `a`.`id`=`b`.`newsid`';
				$wh .= ' `b`.`catnewsid`='.$catid.' AND ';
			}
			$sql .= 'WHERE '.$wh.'  `a`.`view` >= '.$view.' AND `a`.`id` <> '.$id.' AND `a`.`ctrl` & '.$ctrl.' = '.$ctrl.' ORDER BY `a`.`view` ASC,`a`.`id` DESC LIMIT '.$top;		
			return mysql_query($sql); 
		}
	}else{
		if(is_int($id) && is_int($top) && is_int($ctrl)){
			$sql = 'SELECT `created` FROM `'.DB_TABLE_PREFIX.'news` WHERE `id`='.$id;
			$rs = mysql_query($sql);
			$row = mysql_fetch_row($rs);
			mysql_free_result($rs);
			$created = $row[0];
			$sql = 'SELECT `a`.`id`,`a`.`name`,`a`.`creator`,DATE_FORMAT(`a`.`created`,\''.FORMAT_DB_DATETIME.'\') as `created`,`a`.`summary`,`a`.`img1`,`a`.`alt1`,`a`.`ctrl`,`a`.`urlrewrite` FROM `'.DB_TABLE_PREFIX.'news` as `a`';
			//if(is_int($catid)){			
			if($catid){			
				$sql .= ' INNER JOIN `'.DB_TABLE_PREFIX.'catnewsnews` as `b` ON  `a`.`id`=`b`.`newsid`';
				$wh = ' `b`.`catnewsid`='.$catid.' AND ';
			}else
				$wh = '';
			$sql .= ' WHERE '.$wh.' `a`.`created` < \''.$created.'\' AND `a`.`id` <> '.$id.' AND `a`.`ctrl` & '.$ctrl.' = '.$ctrl.' ORDER BY `a`.`created` DESC,`a`.`view` ASC LIMIT '.$top;		
			return mysql_query($sql);
		}
	}
}
function newslistless($id,$date,$top,&$catid,$ctrl=NEWS_CTRL_SHOW){
	global $sql,$urlrewr;
	settype($id,'int');
	settype($top,'int');
	settype($ctrl,'int');
	if($catid===0){
		$sql = 'SELECT `catnewsid` FROM `'.DB_TABLE_PREFIX.'catnewsnews` WHERE `newsid`='.$id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		$catid = (int)$row[0];
		mysql_free_result($rs);
	}// tim ra nhom tin hien thoi 
	$wh = ' `a`.`ctrl` & '.$ctrl.'='.$ctrl;
	$tb = '`'.DB_TABLE_PREFIX.'news` as `a`';
	if($catid > 0){//check if sort by date or sort by view
		$sql = 'SELECT `id` from `'.DB_TABLE_PREFIX.'catnews` WHERE `ctrl` & '.(0x00000400).' = '.(0x00000400).' and `id`='.$catid;
		$rs = mysql_query($sql);
		$row=mysql_fetch_row($rs);
		mysql_free_result($rs);
		if($row){
			$sql = 'SELECT `view` FROM `'.DB_TABLE_PREFIX.'news` WHERE `id`='.$id;
			$rs = mysql_query($sql);
			$row = mysql_fetch_row($rs);
			mysql_free_result($rs);
			$view = (int)$row[0];
			$sortby = ' ORDER BY `a`.`view` ASC,`a`.`id` ASC';
			$wh .= ' AND `a`.`view` < '.$view;
		}
		$tb .= ' INNER JOIN `'.DB_TABLE_PREFIX.'catnewsnews` as `b` ON `a`.`id`=`b`.`newsid`';
		$wh .= ' AND `b`.`catnewsid`='.$catid;
	}
	if(!@$sortby){//default to sort by date descendent
		$sortby = ' ORDER BY `a`.`created` DESC,`a`.`id` DESC';
		$sql = 'SELECT `created` FROM `'.DB_TABLE_PREFIX.'news` WHERE `id`='.$id;
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		mysql_free_result($rs);
		$date = $row[0];
		$wh .= ' AND `a`.`created` > \''.$date.'\'';
	}
	$sql = 'SELECT `a`.`id` FROM '.$tb.' WHERE '.$wh.$sortby;//select full news 
	$rs = mysql_query($sql);
	$rcount=0;
	while($row=mysql_fetch_row($rs)){
		if($row[0] == $id) break;
		++$rcount;
	}
	$sql = 'SELECT `a`.`id`,`a`.`name`,`a`.`creator`,DATE_FORMAT(`a`.`created`,\''.FORMAT_DB_DATETIME.'\') as `created`,`a`.`summary`,`a`.`img1`,`a`.`alt1`,`a`.`ctrl` FROM '.$tb.' WHERE '.$wh.' AND `a`.`id` <> '.$id.$sortby.' LIMIT '.(max($rcount - $top,0)).','.$top;
	return mysql_query($sql);
}
function catnewspath(&$CNid,$NWid=NULL,	$level = 20){
	global $sql,$urlrewr;
	if($CNid <= 0)
		if($NWid > 0){
			$sql = 'SELECT `a`.`catnewsid` FROM `'.DB_TABLE_PREFIX. 'catnewsnews` as `a` WHERE `a`.`newsid` = '.(int)$NWid;
			$rs = mysql_query($sql);
			$row = mysql_fetch_row($rs);
			mysql_free_result($rs);
			if(($CNid = (int)$row[0]) <= 0) return FALSE;
		}else
			return FALSE;
	$ancestor = array();
	$myID = $CNid;
	$sqli = 'SELECT `a`.`id`,`a`.`name`,`a`.`parentid`,`a`.`view`,`a`.`ctrl` FROM `'.DB_TABLE_PREFIX. 'catnews` as `a` WHERE `ID`=';
	while($myID >0 && $level){
		$sql = $sqli.$myID;
		$rs = mysql_query($sql);
		if($row = mysql_fetch_assoc($rs)){
			array_unshift($ancestor,$row);
			--$level;//count down
			$myID = (int)$row['parentid'];
		}else
			break;//quit from loop
	}
	return $ancestor;
}
function catnewssibling($CNid,$top,$ctrl=CATNEWS_CTRL_SHOW){
	global $sql,$urlrewr;
	$sql = 'select `a`.`parentid` from `'.DB_TABLE_PREFIX. 'catnews` as `a` where `id`='.(int)$CNid;
	$rs=mysql_query($sql);
	if($row=mysql_fetch_assoc($rs)){
		$parentid=(int)$row['parentid'];
		if($parentid <= 0){
			$sql1='select `a`.`id`,`a`.`name` from `'.DB_TABLE_PREFIX. 'catnews` as `a` where (`a`.`parentid` IS NULL OR `a`.`parentid` <= 0) AND `a`.`ctrl` & '.$ctrl.' = '.$ctrl.' AND `a`.`id` <> '.(int)$CNid.' ORDER BY `a`.`view` ASC LIMIT '.(int)$top;
			return mysql_query($sql1);	
		}else{
			$sql1='select `a`.`id`,`a`.`name` from `'.DB_TABLE_PREFIX. 'catnews` as `a` where `a`.`parentid` = '.$parentid.' AND `a`.`ctrl` & '.$ctrl.' = '.$ctrl.' AND `a`.`id` <> '.(int)$CNid.'  ORDER BY `a`.`view` ASC LIMIT '.(int)$top;
			return mysql_query($sql1);	
		}
	}
	return FALSE;				
}
//ngocdq@esnadvanced.com
/* Cac ham giup cho viec lay thong tin 1 tin hay 1 san pham lien quan toi 1 tin */

//Lay tin lien quan toi 1 tin
function newsrelate($NWid,$top,$ctrl=NEWS_CTRL_SHOW){
	global $sql,$urlrewr;
$sql = 'SELECT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`summary`,`a`.`urlrewrite`,`a`.`creator`,DATE_FORMAT(`a`.`created`,"'.FORMAT_DB_DATETIME.'") as `created`,`a`.`img1`,`a`.`alt1`,`c`.`urlrewrite` `caturlrewrite` FROM `'.DB_TABLE_PREFIX.'news` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'newslink` as `b` ON `a`.`id` = `b`.`linkid` INNER JOIN `'.DB_TABLE_PREFIX.'catnewsnews` as `ba` ON `a`.`id` = `ba`.`newsid`  INNER JOIN `'.DB_TABLE_PREFIX.'catnews` as `c` ON `ba`.`catnewsid` = `c`.`id` WHERE 	`b`.`newsid`='.(int)$NWid.' AND `a`.`ctrl`&'.$ctrl.'='.$ctrl.' ORDER BY `a`.`created`';


	if($top > 0){
		$sql.=' LIMIT 0,'.(int)$top;
	}else{
		$sql.=' LIMIT 0,10000';	
	}
	_trace($sql);
	return mysql_query($sql);
}

//Lay san pham lien quan toi 1 tin
function productrelate($NWid,$top,$ctrl=PRODUCT_CTRL_SHOW){
	global $sql,$urlrewr;
	$sql = 'SELECT `a`.`id`,`a`.`name`,a.`code`,a.`unit`,a.`include`,a.`manufacturer`,a.`saleprice`,`a`.`price`,a.`ctrl`,a.`view`,a.`summary`,a.`keyword`,a.`img1`,a.`alt1`,a.`img2`,a.`alt2`,a.`warranty`,a.`type`,a.`country` FROM `'.DB_TABLE_PREFIX.'product` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'productnewslink` as `b` ON `a`.`id` = `b`.`productid` WHERE `b`.`newsid`='.(int)$NWid.' AND `b`.`ctrl`=1 AND `a`.`ctrl`&'.$ctrl.'='.$ctrl.' AND `b`.`from`=1';
	if($top >= 0){
		$sql.=' LIMIT 0,'.(int)$top;
	}elseif($top==NULL){
		$sql.=' LIMIT 0,10000';	
	}
	_trace($sql);
	return mysql_query($sql);
}
//Ham phuc vu cho viec tim kiem tin - ham se tim theo 1 so truong da xac dinh trong CSDL
function searchnews(&$page,&$pagesize,&$pagecount,$key=NULL,$where=NULL,$order_by=NULL,$sort='DESC',$catid=NULL,$ctrl=NEWS_CTRL_SHOW){  
	global $ESNC_ROWSTART,$ESNC_ROWEND,$ESNC_ROWCOUNT;
	global $sql;
	$sql = "SELECT SQL_CALC_FOUND_ROWS `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`summary`,`a`.`creator`,DATE_FORMAT(`a`.`created`,'".FORMAT_DB_DATETIME."') as `created`,`a`.`img1`,`a`.`alt1` FROM `".DB_TABLE_PREFIX."news` as `a`";
	$wh = '';
	if($catid > 0){
		$sql .= ' INNER JOIN  `'.DB_TABLE_PREFIX.'catnewsnews`  as `b`	ON `a`.`id` = `b`.`newsid`';
		$wh .= ' AND `b`.`catnewsid` = '.$catid;
	}
	if($ctrl > 0)
		$wh .= ' AND `a`.`ctrl` & '.$ctrl.' = '.$ctrl;
	if($key != NULL && strlen($key) > 2) {
		$key = strtr($key,array('\''=>' '));
		$key = preg_replace(array('/^\W*/','/\s+/','/\W*$/'),array('[[:<:]]','[[:>:]].+[[:<:]]','[[:>:]]'),addslashes(mysql_real_escape_string($key)));
		$wh .= " AND (`a`.`keyword` REGEXP '{$key}' OR  `a`.`name` REGEXP '{$key}' OR `a`.`summary` REGEXP '{$key}') ";
	}
	if($wh) $wh = ' WHERE '.substr($wh,4);
	
	$whe='';
	if($where !== NULL)
	{
		$t= array();
		$t = explode('|', $where);
		for($i=0; $i<count($t); $i++)
		{
		$whe.= "AND {$t[$i]}";
		}
	}
	if($order_by == NULL)
	{
		$order_by=''; 
		$sort='';
	}
	
	$sql .= $wh.' '.$whe.' ORDER BY a.'.$order_by.' '.$sort.',`a`.`view` ASC,`a`.`id` DESC';
	if($page < 1) $page = 1;
	if($pagesize < 5) $pagesize = 5;
	$ESNC_ROWSTART = $pagesize * ($page -1);
	$sql .= ' LIMIT '.$ESNC_ROWSTART.','.$pagesize;
	$ESNC_ROWEND = ++$ESNC_ROWSTART + 1;
	$rs = mysql_query($sql);
	$rs1 = mysql_query('SELECT FOUND_ROWS()');
	$row = mysql_fetch_row($rs1);
	mysql_free_result($rs1);
	$ESNC_ROWCOUNT = (int)$row[0];
	$pagecount = ceil($ESNC_ROWCOUNT/$pagesize);
	if($ESNC_ROWEND > $ESNC_ROWCOUNT) $ESNC_ROWEND = $ESNC_ROWCOUNT;
	return $rs;
}
?>