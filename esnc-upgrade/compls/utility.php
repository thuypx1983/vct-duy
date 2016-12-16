<?php /* vinhtx@esnadvanced.com 22-Mar-2006 */
function catutilitylist($ctrl=CATUTILITY_CTRL_SHOW,$parentid=NULL){
/* list all catutility for specified ctrl */
	global $sql;
	if(!is_int($ctrl)) return FALSE;//at least CTRL_SHOW must be specified
	$sql= ($parentid == NULL) ? 
		"SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`parentid`,IF(`c`.`id` IS NULL,IF(`i`.`utilityid` IS NULL,0,1),2) as `flag` FROM `".DB_TABLE_PREFIX."catutility` as `a` LEFT JOIN `".DB_TABLE_PREFIX."catutility` as `c` ON `a`.`id` = `c`.`parentid` AND `c`.`ctrl` & {$ctrl} = {$ctrl} LEFT JOIN `".DB_TABLE_PREFIX."catutilityutility` as `i` ON `a`.`id` = `i`.`catutilityid` WHERE `a`.`ctrl` & {$ctrl} = {$ctrl} ORDER BY `a`.`parentid`,`a`.`view`":
		"SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`parentid`,IF(`c`.`id` IS NULL,IF(`i`.`utilityid` IS NULL,0,1),2) as `flag` FROM `".DB_TABLE_PREFIX."catutility` as `a` LEFT JOIN `".DB_TABLE_PREFIX."catutility` as `c` ON `a`.`id` = `c`.`parentid` AND `c`.`ctrl` & {$ctrl} = {$ctrl} LEFT JOIN `".DB_TABLE_PREFIX."catutilityutility` as `i` ON `a`.`id` = `i`.`catutilityid` WHERE `a`.`ctrl` & {$ctrl} = {$ctrl} AND `a`.`parentid` = {$parentid} ORDER BY `a`.`parentid`,`a`.`view`";
	return mysql_query($sql);
}
function utilitypagelist(&$page,&$pagesize,&$pagecount,$hint=NULL,$catutilityid=NULL,$ctrl=UTILITY_CTRL_SHOW){
	global $sql;
	$ctrl |= UTILITY_CTRL_SHOW;
	$sql = "SELECT `ut`.`id`,`ut`.`name`,`ut`.`ctrl`,`ut`.`summary`,`ut`.`path`,`ut`.`filename`,`ut`.`img`,`ut`.`alt` FROM `".DB_TABLE_PREFIX."utility` as `ut`";
	$sql1 = "SELECT count(*) FROM `".DB_TABLE_PREFIX."utility` as `ut`";
	$suf = "";
	if(@$catutility != NULL)
		$suf .= " INNER JOIN `".DB_TABLE_PREFIX."catutilityutility` as `uu`	ON `ut`.`id` = `uu`.`utilityid` AND `uu`.`catutilityid` = {$catutility}";
	$suf .= " WHERE `ut`.`ctrl` & {$ctrl} = {$ctrl}";
	if($hint != NULL && strlen($hint) > 3 && strpos($hint,"'") === FALSE) $suf .= " AND `ut`.`keyword` LIKE '%{$hint}%' OR `ut`.`name` LIKE '%{$hint}%'";
	$sql .= $suf." ORDER BY `ut`.`view` ASC";
	if(is_int($page) && is_int($pagesize) && is_int($pagecount)){
		$sql1 .= $suf;
		$rs = mysql_query($sql1);
		$rw = mysql_fetch_row($rs);
		$rcount = (int)$rw[0];
		mysql_free_result($rs);
		if($pagesize < 5) $pagesize = 20;
		$pagecount = ceil($rcount / $pagesize);
		if($page < 1) $page = $pagecount;
		if($page > $pagecount) $page = 1;
		if($pagecount > 1) {
			$rcount=($page - 1) * $pagesize;
			$sql .= " LIMIT {$rcount}, {$pagesize}";
		}
	}
	return mysql_query($sql);
}
function utilitylist($catutilityid=NULL,$num=NULL,$ctrl=UTILITY_CTRL_SHOW){
	global $sql;
	$ctrl |= UTILITY_CTRL_SHOW;
	$sql = "SELECT `ut`.`id`,`ut`.`name`,`ut`.`ctrl`,`ut`.`summary`,`ut`.`path`,`ut`.`filename`,`ut`.`img`,`ut`.`alt` FROM `".DB_TABLE_PREFIX."utility` as `ut`";
	if($catutilityid != NULL)
		$sql .= " INNER JOIN `".DB_TABLE_PREFIX."catutilityutility` as `uu` ON `ut`.`id` = `uu`.`utilityid` AND `uu`.`catutilityid` = {$catutilityid}";
	$sql .= " WHERE `ut`.`ctrl` & {$ctrl} = {$ctrl}";
	$sql .= " ORDER BY `ut`.`view` ASC";
	if($num != NULL){
		$sql .= " LIMIT {$num}";
	}
	return mysql_query($sql);
}
function utilitylink(&$o,$style='class="download"'){
if(!is_object($o)) trigger_error('you must use mysql_fetch_object and pass object to utilitylink',E_USER_ERROR);
	if(strpos($o->path,':')){
		$href=$o->path;
		$param='';
	}else{
		$href = 'download.php?'.http_build_query(array('UTid'=>$o->id,'UTpath'=>$o->path,'title'=>$o->filename));
		$param='toolbar=no,scroll=no,location=no,top=100,left=100,width=150,height=100';
	}
	if($style){
		echo '<a href="'.$href.'" onclick="window.open(\''.$href.'\',\''.$param.'\');return false;" '.$style.'>'.T_LINK_DOWN.'</a>';
		return 'please do not use <b>echo utilityshow</b>,just call utilityshow';
	}
	return $href;
}
function showdownload($filename,$path=PATH_GALLERY,&$var=NULL){//force browser to download file
//error checking
if(headers_sent())
    trigger_error('showdownload phai su dung trong mot file rieng o phan bat dau code, khong the su dung o lan trong code html',E_USER_ERROR);
    if(strpos($filename,':') !== FALSE){//not in our site
        echo '<html><head><meta http-equiv="refresh" content="1;'.$filename.'" /><script language="javascript" defer>window.location.href="'.$filename.'";</script></head></html>';
        //we cannot use header: redirection since the protocol maybe ftp://, must use refresh and javascript to redirect browser
    }
    @define('FILE_TYPE_CODE','|php|asp|asa|inc|ini|');//type code defined in config.php but we redefine to make sure it exists
    $ext = pathinfo($filename,PATHINFO_EXTENSION);
    if(empty($ext) || strpos(FILE_TYPE_CODE,$ext) !== FALSE) exit();//prevent download code file
    if($var) $content_length=strlen($var);
    else $content_length=@filesize($file=$path.$filename);//allow to download variable
    header('Content-Type: application/octet-stream',TRUE);
    header('Content-Length: '.$content_length,TRUE);
    header('Content-Disposition: attachment; filename="'.basename($filename).'"',TRUE);
	header('Cache-Control: public',TRUE);
    if($var) echo $var;//allow to download variable content
    else @readfile($file);
}
?>
