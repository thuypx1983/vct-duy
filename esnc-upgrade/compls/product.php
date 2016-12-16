<?php
$urlrewr='';
if(isset($_GET['url'])) $urlrewr=$_GET['url'];
function catproductlist($ctrl=CATPRODUCT_CTRL_SHOW,$parentid=NULL,$allfields=TRUE,$count=CAT_FLAG_ITEM,$top=100,$pctrl=PRODUCT_CTRL_SHOW){
	global $sql,$urlrewr;
	if(!is_int($ctrl)) return FALSE;
	if($count == CAT_FLAG_ITEM){
		if(is_int($pctrl)){//only join product if passing product ctrl
			$cnt  = ',count(DISTINCT `c`.`id`) as `cnt`';
			$pdtb = ' LEFT JOIN (`'.DB_TABLE_PREFIX.'catproductproduct` as `b` LEFT JOIN `'.DB_TABLE_PREFIX.'product` as `c` ON `b`.`productid` = `c`.`id` AND `c`.`ctrl` & '.$pctrl.' = '.$pctrl.') ON `a`.`id`=`b`.`catproductid`';
			$gr   = ' GROUP BY `a`.`id`';
		}else{
			$cnt=',count(DISTINCT `b`.`productid`) as `cnt`';
			$dtb=' LEFT JOIN `'.DB_TABLE_PREFIX.'catproductproduct` as `b` ON `a`.`id`=`b`.`catproductid`';
			$gr = ' GROUP BY `a`.`id`';
		}
	}elseif($count=CAT_FLAG_SUBCAT|CAT_FLAG_ITEM){//check flag only
		$cnt=',IF(`b`.`id` IS NOT NULL,'.CAT_FLAG_SUBCAT.','.CAT_FLAG_ITEM.') as `cnt`';
		$pdtb = ' LEFT JOIN `'.DB_TABLE_PREFIX.'catproduct` as `b` ON `a`.`id`=`b`.`parentid`';
		$gr='';
	}else{
		$cnt='';
		$pdtb='';
		$gr = '';
	}
	if($parentid!=NULL) $wh = ' WHERE `a`.`ctrl` & '.$ctrl.' = '.$ctrl.' AND `a`.`parentid` = '.$parentid;
	else $wh = ' WHERE `a`.`ctrl` & '.$ctrl.' = '.$ctrl;
	if($allfields)
		$sql='SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`urlrewrite`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid`'.$cnt.',`a`.`name` as `title`,`a`.`layout` FROM `'.DB_TABLE_PREFIX.'catproduct` as `a` '.$pdtb.$wh.$gr.'  ORDER BY `a`.`parentid`, `a`.`view`,`a`.`id` LIMIT '.(int)$top;
	else $sql = 'SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`layout`,`a`.`urlrewrite`,`a`.`parentid`'.$cnt.' FROM `'.DB_TABLE_PREFIX.'catproduct` as `a` '.$pdtb.$wh.$gr.'  ORDER BY `a`.`parentid`, `a`.`view`,`a`.`id` LIMIT '.(int)$top;
	return @mysql_query($sql);
}


function productlinklist($id,$top,$ctrl=PDLINK_CTRL_LINK,$type=NULL,$fields='`a`.`id`,`a`.`name`,`a`.`ctrl`'){
	_trace(__FUNCTION__);
	global $sql;
	settype($id,'int');
	settype($ctrl,'int');
	settype($top,'int');
	$sql = 'SELECT DISTINCT '.$fields.' FROM `'.DB_TABLE_PREFIX.'product` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'productlink` as `b` ON `a`.`id`=`b`.`linkID` AND `a`.`ctrl`&'.PRODUCT_CTRL_SHOW.'='.PRODUCT_CTRL_SHOW.' WHERE `b`.`productID`='.$id.($type?' AND `a`.`type` = "'.$type.'" ':'').' LIMIT '.$top;
	_trace($sql);
	return mysql_query($sql);
}


function productcf($pid,$field){
	_trace(__FUNCTION__);
	global $sql;
	$sql = 'SELECT '.$field.' FROM `'.DB_TABLE_PREFIX.'product` as `a` WHERE `a`.`id`='.(int)$pid;
	_trace($sql);
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	mysql_free_result($rs);
	return $row;
}


function productpagelist(&$page,&$pagecount,$pagesize=2,$catid=NULL,$ctrl=PRODUCT_CTRL_SHOW,$hint=NULL,$minprice=NULL,$maxprice=NULL,$exid=NULL,$getcatid=TRUE,$type=NULL){
	global $sql,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND,$urlrewr;
	if(!is_int($ctrl)) return FALSE;
	$wh = " WHERE `a`.`ctrl` & {$ctrl} = {$ctrl}";
	if(is_int($exid)){ $wh .= " AND `a`.`id` <> {$exid}";}
	if(is_int($type)){ $wh .= " AND `a`.`type` = {$type}";}
	$tbcat='';
	if($catid!=NULL){//filter by cat
		$tbcat = " INNER JOIN `".DB_TABLE_PREFIX."catproductproduct` as `b` ON `a`.`id` = `b`.`productid` AND `b`.`catproductid` = {$catid}  INNER JOIN `".DB_TABLE_PREFIX."catproduct` as `c` ON `b`.`catproductid` = `c`.`id`";
	}else {$tbcat = " INNER JOIN `".DB_TABLE_PREFIX."catproductproduct` as `b` ON `a`.`id` = `b`.`productid`  INNER JOIN `".DB_TABLE_PREFIX."catproduct` as `c` ON `b`.`catproductid` = `c`.`id` ".(trim($urlrewr)!=''?"and `c`.`urlrewrite`='{$urlrewr}'":""); }
	if($hint !== NULL){
		$hint = mysql_escape_string(str_replace(array('*','?'),array('%','_'),$hint));
		if(strpos($hint,'%') === FALSE && strpos('_',$hint) === FALSE) $hint='%'.$hint.'%';
		$wh .= " AND (`a`.`name` LIKE '{$hint}' OR `a`.`keyword` LIKE '{$hint}' OR `a`.`code` LIKE '{$hint}' OR `a`.`summary` LIKE '{$hint}'  OR `a`.`tag` LIKE '{$hint}')";
	}
	$lm='';
	if(is_int($page) && is_int($pagesize) && $pagesize >= 1){//must be number
		$ESNC_ROWSTART=$pagesize * ($page -1);
		$lm = ' LIMIT '.$ESNC_ROWSTART.','.$pagesize;
	}
	$sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT a.`id`,a.`name`,a.`code`,a.`quantity`,a.`maxcartqty`,a.`unit`,a.`include`,a.`manufacturer`,a.`saleprice`,`a`.`price`,`a`.`urlrewrite`,a.`ctrl`,a.`view`,`c`.`name` catname,  c.`id` catnameid,`c`.`urlrewrite` caturlrewrite, a.`summary`,a.`keyword`,a.`img1`,a.`alt1`,a.`img2`,a.`alt2`,a.`warranty`,a.`type`,a.`class`,a.`country` ,`a`.`model`  FROM `".DB_TABLE_PREFIX."product` as `a` {$tbcat} {$wh} ORDER BY `a`.`view` ASC,`a`.`id` DESC {$lm}";
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
function productlist($catid=NULL,$top=NULL,$ctrl=PRODUCT_CTRL_SHOW,$exid=NULL,$type=NULL){
	global $sql,$urlrewr;
	if(!is_int($ctrl)) return FALSE;
	if($catid!=NULL)
		{
			$tbcat = " INNER JOIN `".DB_TABLE_PREFIX."catproductproduct` as `b` ON `a`.`id` = `b`.`productid` AND `b`.`catproductid` = {$catid}  INNER JOIN `".DB_TABLE_PREFIX."catproduct` as `c` ON `b`.`catproductid` = `c`.`id`"; }
	else {
		$tbcat = " INNER JOIN `".DB_TABLE_PREFIX."catproductproduct` as `b` ON `a`.`id` = `b`.`productid`  INNER JOIN `".DB_TABLE_PREFIX."catproduct` as `c` ON `b`.`catproductid` = `c`.`id` ".(trim($urlrewr)!='' && $catid!=0?"and `c`.`urlrewrite`='{$urlrewr}'":"");
		}
	$wh = " WHERE `a`.`ctrl` & {$ctrl} = {$ctrl}";
	if (is_int($type)) {$wh .= " AND `a`.`type` = {$type}";} //Dunghm them vao ngay: 10/01/2007
	if(is_int($exid)){ $wh .= " AND `a`.`id` <> {$exid}";}
	if(is_int($top)) $lm = "LIMIT {$top}";else $lm="";
	$sql = "SELECT a.`id`,a.`name`,a.`code`,a.`include`,a.`manufacturer`,a.`saleprice`,`a`.`price`,`a`.`class`,a.`ctrl`, `a`.`urlrewrite`, a.`view`,a.`summary`,a.`img1`,a.`alt1`,a.`warranty`,a.`country`,a.`unit`,a.`type`,`a`.`model`,`c`.`name` catname, c.`id` catnameid,`c`.`urlrewrite` caturlrewrite,`a`.`quantity`  FROM `".DB_TABLE_PREFIX."product` as `a` {$tbcat} {$wh} ORDER BY `a`.`view` ASC,`a`.`id` DESC {$lm}";
	return mysql_query($sql);
}
function productread($id=NULL){
	global $urlrewr;
	$sql='SELECT a.`id`,a.`name`,a.`cf4`,a.`code`,a.`include`,a.`manufacturer`,a.`saleprice`,a.`price`,a.`ctrl`,a.`view`,a.`unit`,a.`summary`,a.`weight`,a.`mincartqty`,a.`maxcartqty`,a.`quantity`,a.`detail`,a.`keyword`,a.`img1`,a.`alt1`,a.`img2`,a.`alt2`,a.`warranty`,a.`country`,a.`type`,a.`model`,a.`quantity`,a.`urlrewrite`,`c`.`name` catname, c.`id` catnameid,`c`.`urlrewrite` caturlrewrite  FROM `'.DB_TABLE_PREFIX.'product` a INNER JOIN `'.DB_TABLE_PREFIX.'catproductproduct` as `b` ON `a`.`id` = `b`.`productid` INNER JOIN `'.DB_TABLE_PREFIX.'catproduct` as `c` ON `b`.`catproductid` = `c`.`id` WHERE '.($id==NULL?'a.`urlrewrite`="'.$urlrewr.'"':'a.`id` = '.(int)$id.'').' AND a.`ctrl`&'.PRODUCT_CTRL_SHOW.'='.PRODUCT_CTRL_SHOW;
	$o = mysql_fetch_object($rs=mysql_query ($sql));
	mysql_free_result($rs);
	if(@is_file($file=PATH_PRODUCT_DETAIL.'product-'.$o->id.'.htm')) $o->detail=file_get_contents($file);
	return $o;
}
function productopen($id){
	global $urlrewr;
	$sql='SELECT `id`,`name`,`code`,`include`,`manufacturer`,`saleprice`,`price`,`ctrl`,`view`,`unit`,  `urlrewrite`,`summary`,`keyword`,`img1`,`alt1`,`img2`,`alt2`,`warranty`,`country`,`type`,`model`   FROM `'.DB_TABLE_PREFIX.'product` WHERE `id` = '.(int)$id.' AND `ctrl`&'.PRODUCT_CTRL_SHOW.'='.PRODUCT_CTRL_SHOW;
	$o = mysql_fetch_object($rs=mysql_query ($sql));
	mysql_free_result($rs);
	return $o;
}
function catproducttrack($ids){
	global $urlrewr;
	trigger_error('please use <b>catproductpath</b> to build path way',E_USER_NOTICE);
	global $sql;
	$a_id = explode(',',$ids);
	$a_sql=array();
	foreach($a_id as $id){
		$a_sql[] = 'SELECT `id`,`name` FROM `'.DB_TABLE_PREFIX.'catproduct` WHERE `id`='.(int)$id;
	}
	$sql = implode($a_sql,' UNION ');
	return mysql_query($sql);
}
function catproductopen(&$id,$pid=NULL){
	global $sql,$urlrewr;
	if($id == 0 && $pid > 0){
		$sql='SELECT `catproductid` FROM `'.DB_TABLE_PREFIX.'catproductproduct` WHERE `productid` = '.(int)$pid.' LIMIT 1';
		if($row = mysql_fetch_row($rs=mysql_query($sql)))	$id = (int)$row[0]; else return FALSE;
		mysql_free_result($rs);
	}	
	if($id!=NULL) { $sql='SELECT `id`,`parentid`,`name`,`view`,`desc`,`ctrl`,`img1`,`alt1`,`urlrewrite` FROM `'.DB_TABLE_PREFIX.'catproduct` WHERE `id` = '.(int)$id.' AND `ctrl`&'.CATPRODUCT_CTRL_SHOW.'='.CATPRODUCT_CTRL_SHOW; } else {
		$sql='SELECT `id`,`parentid`,`name`,`view`,`desc`,`ctrl`,`img1`,`alt1`,`urlrewrite` FROM `'.DB_TABLE_PREFIX.'catproduct` WHERE '.(trim($urlrewr)!=''?'`urlrewrite`="'.$urlrewr.'"':'').' AND `ctrl`&'.CATPRODUCT_CTRL_SHOW.'='.CATPRODUCT_CTRL_SHOW; }
	$o = mysql_fetch_object(mysql_query($sql));	
	mysql_free_result($rs);
	return $o;
}

function catproductread($id,$pid=NULL){
	global $sql,$urlrewr;
	if($id == 0 && $pid > 0){
		$sql='SELECT `catproductid` FROM `'.DB_TABLE_PREFIX.'catproductproduct` WHERE `productid` = '.(int)$pid.' LIMIT 1';
		if($row = mysql_fetch_row($rs=mysql_query($sql)))	$id = (int)$row[0]; else return FALSE;
		mysql_free_result($rs);
	}
	if($id!=NULL) { $sql='SELECT `id`,`parentid`,`name`,`view`,`desc`,`ctrl`,`img1`,`alt1`,`urlrewrite` FROM `'.DB_TABLE_PREFIX.'catproduct` WHERE `id` = '.(int)$id.' AND `ctrl`&'.CATPRODUCT_CTRL_SHOW.'='.CATPRODUCT_CTRL_SHOW; } else {
		$sql='SELECT `id`,`parentid`,`name`,`view`,`desc`,`ctrl`,`img1`,`alt1`,`urlrewrite` FROM `'.DB_TABLE_PREFIX.'catproduct` WHERE '.(trim($urlrewr)!=''?'`urlrewrite`="'.$urlrewr.'"':'').' AND `ctrl`&'.CATPRODUCT_CTRL_SHOW.'='.CATPRODUCT_CTRL_SHOW; }
	@$o = mysql_fetch_object($rs=mysql_query ($sql));
	@mysql_free_result(@$rs);
	return @$o;
}

/* function catproductlistex($ctrl=CATPRODUCT_CTRL_SHOW,$parentid=NULL,$allfields=FALSE,$flag=CAT_FLAG_ITEM,$top=100,$reserved=NULL){
($ctrl & CATPRODUCT_CTRL_SHOW) or trigger_error('Ctrl c&#7911;a catproduct thi&#7871;u CATPRODUCT_CTRL_SHOW s&#7869; hi&#7875;n th&#7883; c&#7843; nh&oacute;m &#7849;n');
	global $sql;
	if(!is_int($ctrl)) return FALSE;
	if(is_int($parentid)) $wh = ' WHERE `a`.`ctrl` & '.$ctrl.' = '.$ctrl.' AND `a`.`parentid` = '.$parentid;
	else $wh = ' WHERE `a`.`ctrl` & '.$ctrl.' = '.$ctrl;
	if($allfields) $f =' `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`parentid`,`a`.`view`,`a`.`desc`,`a`.`alt1`,`a`.`img1`';
		$f =' `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`parentid`';
	if($flag==CAT_FLAG_ITEM){//filter cat with no subcat
		$b=' LEFT JOIN `'.DB_TABLE_PREFIX.'catproduct` AS `b` ON `b`.`parentid`=`a`.`id`';
		$wh .= ' AND `b`.`id` IS NULL';
	}elseif($flag == CAT_FLAG_SUBCAT){//filter cat with subcat
		$b=' LEFT JOIN `'.DB_TABLE_PREFIX.'catproduct` AS `b` ON `b`.`parentid`=`a`.`id`';
		$wh .= ' AND `b`.`id` IS NOT NULL';
	}else{
		$b=' LEFT JOIN `'.DB_TABLE_PREFIX.'catproduct` AS `b` ON `b`.`parentid`=`a`.`id`';
		$f .= ',IF(`b`.`id` IS NULL,'.CAT_FLAG_ITEM.','.CAT_FLAG_SUBCAT.') as `flag`';
	}
	$sql='SELECT DISTINCT '.$f.'  FROM `'.DB_TABLE_PREFIX.'catproduct` as `a` '.$b.$wh.'  ORDER BY `a`.`parentid`, `a`.`view`,`a`.`id` LIMIT '.(int)$top;
	return mysql_query($sql);
}*/
function productshow($id){
	global $sql;
	if(!@readfile(PATH_PRODUCT_DETAIL.'product-'.$id.'.htm')){
    $sql = 'SELECT `detail` FROM `'.DB_TABLE_PREFIX.'product` WHERE `id`='.(int)$id;
    $rs=mysql_query($sql);
    $row = mysql_fetch_row($rs);
    echo $row[0];
    mysql_free_result($rs);
	}
}
function productphotolist($productid,$top=20,$ctrl=NULL){
	global $sql;
	$sql ='SELECT `img`,`name`,`alt`,`view`,`url`,`ctrl` FROM `'.DB_TABLE_PREFIX.'productphoto` WHERE `productid`='.(int)$productid.' ORDER BY `view` LIMIT '.(int)$top;
	return mysql_query($sql);
}
function productsamelist($PDid,&$CPid=NULL,&$page=1,&$pagecount=0,$pagesize=2,$ctrl=PRODUCT_CTRL_SHOW,$type=NULL){
	global $sql,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND;
	settype($ctrl,'int');
	settype($PDid,'int');
	$wh = ' WHERE `a`.`ctrl` & '.$ctrl.' = '.$ctrl;
	if(is_int($type)){ $wh .= ' AND `a`.`type` = '.$type;}
	$tbcat='';
	if($CPid > 0){//filter by cat
		$tbcat = ' INNER JOIN `'.DB_TABLE_PREFIX.'catproductproduct` as `b` ON `a`.`id` = `b`.`productid`  INNER JOIN `".DB_TABLE_PREFIX."catproduct` as `c` ON `b`.`catproductid` = `c`.`id`';
		$wh .= ' AND `b`.`catproductid` = '.(int)$CPid;
	}else {
		$sql = 'SELECT `catproductid` FROM `'.DB_TABLE_PREFIX.'catproductproduct` WHERE `productid`='.$PDid;
		$rs = mysql_query($sql);
		$row = mysql_fetch_row($rs);
		$CPid = (int)$row[0];
		mysql_free_result($rs);
		$tbcat = ' INNER JOIN `'.DB_TABLE_PREFIX.'catproductproduct` as `b` ON `a`.`id` = `b`.`productid` INNER JOIN `".DB_TABLE_PREFIX."catproduct` as `c` ON `b`.`catproductid` = `c`.`id`';
		$wh .= ' AND `b`.`catproductid` = '.(int)$CPid;
	}
	$ESNC_ROWSTART = ($page-1) * $pagesize;
	$lm = 'LIMIT '.$ESNC_ROWSTART.','.$pagesize;
	$ESNC_ROWEND = (++$ESNC_ROWSTART) + $pagesize;
	$sql = 'SELECT SQL_CALC_FOUND_ROWS DISTINCT a.`id`,a.`name`,a.`code`,a.`unit`,a.`include`,a.`manufacturer`,a.`saleprice`,`a`.`price`,`c`.`name` catname,  c.`id` catnameid, a.`ctrl`,a.`view`,	a.`summary`,a.`keyword`,a.`img1`,a.`alt1`,a.`img2`,a.`alt2`,a.`warranty`,a.`type`,a.`country`   FROM `'.DB_TABLE_PREFIX.'product` as `a` '.$tbcat.' '.$wh.' AND `a`.`id` <> '.$PDid.' ORDER BY `view` ASC '.$lm;
	$rs = mysql_query($sql);
	$sql = 'SELECT FOUND_ROWS()';
	$rs1  = mysql_query($sql);
	$row = mysql_fetch_row($rs1);
	$ESNC_ROWCOUNT = (int)$row[0];
	$pagecount = ceil($ESNC_ROWCOUNT / $pagesize);
	mysql_free_result($rs1);
	return $rs;
}
function catproductpath(&$cid,$id=NULL,$level=20){
	global $sql;
	if($cid <= 0)
		if($id > 0){
			$sql = 'SELECT `a`.`catproductid` FROM `'.DB_TABLE_PREFIX. 'catproductproduct` as `a` WHERE `a`.`productid` = '.(int)$id;
			$rs = mysql_query($sql);
			$row = mysql_fetch_row($rs);
			mysql_free_result($rs);
			if(($cid = (int)$row[0]) <= 0) return FALSE;
		}else
			return FALSE;
	$ancestor = array();
	$myID = $cid;
	$sqli = 'SELECT `a`.`id`,`a`.`name`,`a`.`parentid`,`a`.`view`,`a`.`ctrl` FROM `'.DB_TABLE_PREFIX. 'catproduct` as `a` WHERE `ID`=';
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
//ngocdq@esnadvanced.com	
//lay danh sach tin lien quan den san pham
function productnewsrelate($PDid,$top,$ctrl=PRODUCT_CTRL_SHOW){
	global $sql;
	$sql = 'SELECT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`summary`,`a`.`content`,`a`.`creator`,DATE_FORMAT(`a`.`created`,"'.FORMAT_DB_DATETIME.'") as `created`,`a`.`img1`,`a`.`alt1`,`a`.`urlrewrite`,`c`.`urlrewrite` `caturlrewrite` FROM `'.DB_TABLE_PREFIX.'news` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'productnewslink` as `b` ON `a`.`id` = `b`.`newsid` INNER JOIN `'.DB_TABLE_PREFIX.'catnewsnews` as `d` ON `a`.`id` = `d`.`newsid` INNER JOIN `'.DB_TABLE_PREFIX.'catnews` as `c` ON `d`.`catnewsid` = `c`.`id` WHERE `b`.`productid`='.(int)$PDid.' AND `b`.`ctrl`=1 AND `b`.`from`=2 AND `a`.`ctrl`&'.$ctrl.'='.$ctrl.' ORDER BY `a`.`created`';
	if($top >= 0){
		$sql.=' LIMIT 0,'.(int)$top;
	}elseif($top==NULL){
		$sql.=' LIMIT 0,10000';	
	}
	_trace($sql);
	return mysql_query($sql);
}
//ngocdq
// list product with number star have paging.
// add parameter $star in condition where of statement sql.
function productpagelistwithstar(&$page,&$pagecount,$pagesize=2,$catid=NULL,$ctrl=PRODUCT_CTRL_SHOW,$star=NULL,$hint=NULL,$minprice=NULL,$maxprice=NULL,$exid=NULL,$getcatid=TRUE,$type=NULL){
	global $sql,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND;
	if(!is_int($ctrl)) return FALSE;
	$wh = " WHERE `a`.`ctrl` & {$ctrl} = {$ctrl}";
	if(is_int($exid)){ $wh .= " AND `a`.`id` <> {$exid}";}
	if(is_int($type)){ $wh .= " AND `a`.`type` = {$type}";}
	$tbcat='';
	if(is_int($catid)){//filter by cat
		$tbcat = " INNER JOIN `".DB_TABLE_PREFIX."catproductproduct` as `b` ON `a`.`id` = `b`.`productid` AND `b`.`catproductid` = {$catid}  INNER JOIN `".DB_TABLE_PREFIX."catproduct` as `c` ON `b`.`catproductid` = `c`.`id`";
	}else {$tbcat = " INNER JOIN `".DB_TABLE_PREFIX."catproductproduct` as `b` ON `a`.`id` = `b`.`productid`  INNER JOIN `".DB_TABLE_PREFIX."catproduct` as `c` ON `b`.`catproductid` = `c`.`id`";}
	if($star != NULL){
		$wh .= " AND `a`.`manufacturer`={$star}";
	}
	if($hint !== NULL){
		$hint = mysql_escape_string(str_replace(array('*','?'),array('%','_'),$hint));
		if(strpos($hint,'%') === FALSE && strpos('_',$hint) === FALSE) $hint='%'.$hint.'%';
		$wh .= " AND (`a`.`name` LIKE '{$hint}' OR `a`.`keyword` LIKE '{$hint}' OR `a`.`code` LIKE '{$hint}' OR `a`.`summary` LIKE '{$hint}')";
	}
	$lm='';
	if(is_int($page) && is_int($pagesize) && $pagesize >= 1){//must be number
		$ESNC_ROWSTART=$pagesize * ($page -1);
		$lm = ' LIMIT '.$ESNC_ROWSTART.','.$pagesize;
	}
	$sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT a.`id`,a.`name`,a.`code`,a.`unit`,a.`include`,a.`manufacturer`,a.`saleprice`,`a`.`price`,`a`.`class`,a.`ctrl`,a.`view`,`a`.`urlrewrite`, c.`name` catname,c.`id` catnameid,`c`.`urlrewrite` caturlrewrite,   a.`summary`, a.`detail`,a.`keyword`,a.`img1`,a.`alt1`,a.`img2`,a.`alt2`,a.`warranty`,a.`type`,a.`country` ,`a`.`model`".($getcatid ? ',`b`.`catproductid` as `catid`':'')."  FROM `".DB_TABLE_PREFIX."product` as `a` {$tbcat} {$wh} ORDER BY `a`.`view` ASC,`a`.`id` DESC {$lm}";
	//echo $sql;
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
