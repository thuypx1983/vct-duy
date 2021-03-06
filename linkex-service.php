<?php //generated by linkbuilding.esnc.net setup wizard
require 'config.php';
define('DOMAIN_ID',60);
define('USER_EMAIL','guest@esnadvanced.com');
define('USER_PASS','WjNWbGMzUT0=');
define('URL_LINKEXCHANGE_SERVICES','http://links.esnc.net/services.php');

define('SATELLITE_SETUP',							0);
define('SATELLITE_CAT_ITEMS_UPDATE',				1);
define('SATELLITE_CATS_UPDATE',						2);
define('SATELLITE_ITEMS_UPDATE',					3);
define('SATELLITE_CATS_DELETE',						4);
define('SATELLITE_ITEMS_DELETE',					5);
define('SATELLITE_ACT_GET_ALL_CATLINKEXCHANGE',	6);
define('SATELLITE_ACT_GET_LINKEXCHANGE',			7);
define('SATELLITE_ACT_SETUP_LINKEXCHANGE_PAGE',			8);

define('ACT_GET_ALL_CATLINKEXCHANGE',				0);
define('ACT_GET_ALL_LINKEXCHANGE',					1);
define('ACT_GET_ALL_CATLINKEXCHANGELINKEXCHANGE',	2);
define('ACT_GET_CATLINKEXCHANGE',					3);
define('ACT_GET_LINKEXCHANGE',						4);
define('ACT_GET_CATLINKEXCHANGELINKEXCHANGE',		5);
define('ACT_OPEN_CATLINKEXCHANGE',					6);
define('ACT_OPEN_LINKEXCHANGE',						7);
define('ACT_SETUP_LINKEXCHANGE_PAGE',				9);

define('CATLINKEXCHANGE_CTRL_SHOW',		1);
define('LINKEXCHANGE_CTRL_WAIT1',		1);
define('LINKEXCHANGE_CTRL_WAIT2',		2);
define('LINKEXCHANGE_CTRL_WAIT3',		4);
define('LINKEXCHANGE_CTRL_SHOW',		8);
define('LINKEXCHANGE_CTRL_OVERWRITE',	16);

function redirect($url,$quit=true,$js=false){
	global $message;
	$reg='/^'.preg_quote(URL_ROOT,'/').'/';
	if($url{0}=='.' && $url{1}=='.'){//redirect to parent directory
		$url = URL_BASE.trim(dirname(dirname(preg_replace($reg,'',URL_SELF),'/'))).'/'.ltrim($url,'.');
	}elseif($url{0}=='/'){//to base url
		$url = URL_BASE.preg_replace($reg,'',$url);
	}elseif(strpos($url,':') === false){//to current directory
		$url = URL_BASE.trim(dirname(preg_replace($reg,'',URL_SELF)),'/').'/'.ltrim($url,'./');
	}
	if($js || (!@header('HTTP/1.1 303 See Other',true,303) and !@header('Location:'.$url))){
		echo '<head><meta http-equiv="Refresh" content="0;url=\''.$url.'\'"/>';
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.$url.'";';			
		echo '</script></head>';
	}
	if($quit){
		@mysql_close();
		exit();
	}
}
function dblink_open(){global $link_con;$link_con = mysql_connect(DB_HOST,DB_USER_ADMIN,DB_PWD_ADMIN) or die (mysql_error());mysql_select_db(DB_NAME,$link_con ) or die (mysql_error());}
function dblink_close(){global $link_con;mysql_close($link_con);}
function esnc_encode($s){ return base64_encode($s);}
function esnc_decode($s){ return base64_decode($s);}
function get_objects($url,$tagName,&$arr_item,$decode=null){
	$xml_parser = xml_parser_create();
	if($decode==true)$data = htmlspecialchars_decode(file_get_contents($url));else $data = file_get_contents($url);
	xml_parse_into_struct($xml_parser, $data, $doc, $index);
	xml_parser_free($xml_parser);
	$arr_item=array();$i=0;
	foreach ($doc as $elem) {
		if((($elem['type']=='open')||($elem['type']=='complete'))&&($elem['tag']==$tagName)){
			$arr_item[$i]=$elem['attributes'];
			$i++;
		}
	}
}
/*******************************************************************************************************************/
$link_con = mysql_connect(DB_HOST,DB_USER_ADMIN,DB_PWD_ADMIN) or die (mysql_error());
mysql_select_db(DB_NAME,$link_con ) or die (mysql_error());

$act=null;if(!empty($_GET['act']))$act=(int)$_GET['act'];

$usermail=esnc_decode(@$_GET['usermail']);
$userpass=esnc_decode(@$_GET['userpass']);
$text="";
if(($usermail==USER_EMAIL)&&($userpass==USER_PASS)){
	switch($act){
		case SATELLITE_ACT_SETUP_LINKEXCHANGE_PAGE:
			$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_SETUP_LINKEXCHANGE_PAGE.'&DMid='.DOMAIN_ID;
			$content=file_get_contents($url);
			if(strpos($content,"<?php")===0){
				file_put_contents(PATH_ROOT.'linkexchange.php',$content);
			}
			echo '<script type="text/javascript">parent.nextUrl();</script>';	
			break;
		case SATELLITE_SETUP:
			$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_SETUP_LINKEXCHANGE_PAGE.'&DMid='.DOMAIN_ID;
			$content=file_get_contents($url);
			if(strpos($content,"<?php")===0){
				file_put_contents(PATH_ROOT.'linkexchange.php',$content);
			}
			$sql="DROP TABLE IF EXISTS `".DB_TABLE_PREFIX."catlinkexchange`";
			if(!mysql_query($sql))echo $sql."<br/>";
			$sql="CREATE TABLE `".DB_TABLE_PREFIX."catlinkexchange`(
					`id` bigint unsigned NOT null,`name` varchar(255) null default '',`desc` varchar(255) default null,`img1` varchar(255) default null,
					`alt1` varchar(255) default null,`view` bigint unsigned default null,`ctrl` bigint unsigned default null,`extra` varchar(255) default null,
					`parentid` bigint unsigned default null)";
			if(!mysql_query($sql))echo $sql."<br/>";
			$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_GET_ALL_CATLINKEXCHANGE.'&DMid='.DOMAIN_ID;	
			get_objects($url,'CATEGORY',$arr_item);
			if(count($arr_item)>0){
				$sql="INSERT INTO `".DB_TABLE_PREFIX."catlinkexchange`(`id`,`name`,`desc`,`img1`,`alt1`,`view`,`ctrl`,`parentid`) VALUES ";
				for($i=0;$i<count($arr_item)-1;$i++){
					$sql.="(".$arr_item[$i]['ID'].",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['NAME']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['DESC']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['IMG1']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['ALT1']))."',".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").",".((($arr_item[$i]['CTRL']!=null)&&($arr_item[$i]['CTRL']!=''))?$arr_item[$i]['CTRL']:"null").",".((($arr_item[$i]['PARENTID']!=null)&&($arr_item[$i]['PARENTID']!=''))?$arr_item[$i]['PARENTID']:"null")."),";
				}
				$sql.="(".$arr_item[$i]['ID'].",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['NAME']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['DESC']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['IMG1']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['ALT1']))."',".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").",".((($arr_item[$i]['CTRL']!=null)&&($arr_item[$i]['CTRL']!=''))?$arr_item[$i]['CTRL']:"null").",".((($arr_item[$i]['PARENTID']!=null)&&($arr_item[$i]['PARENTID']!=''))?$arr_item[$i]['PARENTID']:"null").")";
				if(!mysql_query($sql))echo $sql."<br/>";
			}
			$sql="DROP TABLE IF EXISTS `".DB_TABLE_PREFIX."linkexchange`";
			if(!mysql_query($sql))echo $sql."<br/>";
			$sql="CREATE TABLE  `".DB_TABLE_PREFIX."linkexchange` (
					`id` bigint unsigned NOT null,`name` varchar(255) default '',`title` varchar(255) default '',`url` varchar(255) default '',
					`src` varchar(255) default null,`desc` text,`created` datetime NOT null default '0000-00-00 00:00:00',`lastupdate` datetime NOT null default '0000-00-00 00:00:00',
					`view` int unsigned default '0',`type` bigint unsigned not null default '0',`status` bigint unsigned not null default '0',`email` varchar(255) default null,
					`phone` varchar(255) default null,`address` varchar(255) default null,`extra` text,`ctrl` bigint unsigned not null default '0')";
			if(!mysql_query($sql))echo $sql."<br/>";
			$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_GET_ALL_LINKEXCHANGE.'&DMid='.DOMAIN_ID;	
			get_objects($url,'ITEM',$arr_item);
			if(count($arr_item)>0){
				$sql="INSERT INTO `".DB_TABLE_PREFIX."linkexchange`(`id`,`name`,`title`,`url`,`src`,`desc`,`created`,`lastupdate`,`view`,`type`,`status`,`email`,`phone`,`address`,`extra`,`ctrl`) VALUES ";
				for($i=0;$i<count($arr_item)-1;$i++){
					$sql.="(".$arr_item[$i]['ID'].",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['NAME']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['TITLE']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['URL']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['SRC']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['DESC']))."','".mysql_real_escape_string($arr_item[$i]['CREATED'])."','".mysql_real_escape_string($arr_item[$i]['LASTUPDATE'])."',".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").",".((($arr_item[$i]['TYPE']!=null)&&($arr_item[$i]['TYPE']!=''))?$arr_item[$i]['TYPE']:"null").",".((($arr_item[$i]['STATUS']!=null)&&($arr_item[$i]['STATUS']!=''))?$arr_item[$i]['STATUS']:"null").",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['EMAIL']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['PHONE']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['ADDRESS']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['EXTRA']))."',".((($arr_item[$i]['CTRL']!=null)&&($arr_item[$i]['CTRL']!=''))?$arr_item[$i]['CTRL']:"null")."),";
				}
					$sql.="(".$arr_item[$i]['ID'].",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['NAME']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['TITLE']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['URL']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['SRC']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['DESC']))."','".mysql_real_escape_string($arr_item[$i]['CREATED'])."','".mysql_real_escape_string($arr_item[$i]['LASTUPDATE'])."',".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").",".((($arr_item[$i]['TYPE']!=null)&&($arr_item[$i]['TYPE']!=''))?$arr_item[$i]['TYPE']:"null").",".((($arr_item[$i]['STATUS']!=null)&&($arr_item[$i]['STATUS']!=''))?$arr_item[$i]['STATUS']:"null").",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['EMAIL']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['PHONE']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['ADDRESS']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['EXTRA']))."',".((($arr_item[$i]['CTRL']!=null)&&($arr_item[$i]['CTRL']!=''))?$arr_item[$i]['CTRL']:"null").")";
				if(!mysql_query($sql))echo 'linkexchange'."<br/>";
			}
			$sql="DROP TABLE IF EXISTS `".DB_TABLE_PREFIX."catlinkexchangelinkexchange`";
			if(!mysql_query($sql))echo $sql."<br/>";
			$sql="CREATE TABLE  `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` (
					`catlinkexchangeid` bigint unsigned NOT null,
					`linkexchangeid` bigint unsigned NOT null,
					`view` bigint unsigned default null)";
			if(!mysql_query($sql))echo 'catlinkexchangelinkexchange'."<br/>";
			$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_GET_ALL_CATLINKEXCHANGELINKEXCHANGE.'&DMid='.DOMAIN_ID;	
			get_objects($url,'RELATION',$arr_item);
			if(count($arr_item)>0){
				$sql="INSERT INTO `".DB_TABLE_PREFIX."catlinkexchangelinkexchange`(`catlinkexchangeid`,`linkexchangeid`,`view`) VALUES ";
				for($i=0;$i<count($arr_item)-1;$i++){
					$sql.="(".$arr_item[$i]['CATLINKEXCHANGEID'].",".$arr_item[$i]['LINKEXCHANGEID'].",".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null")."),";
				}
				$sql.="(".$arr_item[$i]['CATLINKEXCHANGEID'].",".$arr_item[$i]['LINKEXCHANGEID'].",".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").")";
				if(!mysql_query($sql))echo $sql."<br/>";
			}
			break;	
		case SATELLITE_CATS_UPDATE:
			$CDid=null;if(!empty($_GET['CDid']))$CDid=explode(",",$_GET['CDid']);
			$CDName=null;if(!empty($_GET['CDName']))$CDName=explode(",",$_GET['CDName']);
			if($CDid!=null){
				for($i=0;$i<count($CDid);$i++){
					$sql="SELECT `id`,`name` FROM `".DB_TABLE_PREFIX."catlinkexchange` WHERE `id`=".$CDid[$i]." limit 1";
					if($row=mysql_fetch_assoc(mysql_query($sql))){
						$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_OPEN_CATLINKEXCHANGE.'&DMid='.DOMAIN_ID.'&CDid='.$CDid[$i];
						get_objects($url,'CATEGORY',$arr_item);
						if(count($arr_item)>0){
							$sql="UPDATE `".DB_TABLE_PREFIX."catlinkexchange` SET 
									`name`='".mysql_real_escape_string(utf8_decode($arr_item[0]['NAME']))."',
									`desc`='".mysql_real_escape_string(utf8_decode($arr_item[0]['DESC']))."',
									`img1`='".mysql_real_escape_string(utf8_decode($arr_item[0]['IMG1']))."',
									`alt1`='".mysql_real_escape_string(utf8_decode($arr_item[0]['ALT1']))."',
									`view`=".((($arr_item[0]['VIEW']!=null)&&($arr_item[0]['VIEW']!=''))?$arr_item[0]['VIEW']:"null").",
									`ctrl`=".((($arr_item[0]['CTRL']!=null)&&($arr_item[0]['CTRL']!=''))?$arr_item[0]['CTRL']:"null").",
									`parentid`=".((($arr_item[0]['PARENTID']!=null)&&($arr_item[0]['PARENTID']!=''))?$arr_item[0]['PARENTID']:"null")."
									WHERE `id`=".$arr_item[0]['ID']."";
							if(!mysql_query($sql))echo $sql."<br/>";
						}
					}else{
						$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_OPEN_CATLINKEXCHANGE.'&DMid='.DOMAIN_ID.'&CDid='.$CDid[$i];
						get_objects($url,'CATEGORY',$arr_item);
						if(count($arr_item)>0){
							$sql="INSERT INTO `".DB_TABLE_PREFIX."catlinkexchange`(`id`,`name`,`desc`,`img1`,`alt1`,`view`,`ctrl`,`parentid`) VALUES ";
							$sql.="(".$arr_item[0]['ID'].",'".mysql_real_escape_string(utf8_decode($arr_item[0]['NAME']))."','".mysql_real_escape_string(utf8_decode($arr_item[0]['DESC']))."','".mysql_real_escape_string(utf8_decode($arr_item[0]['IMG1']))."','".mysql_real_escape_string(utf8_decode($arr_item[0]['ALT1']))."',".((($arr_item[0]['VIEW']!=null)&&($arr_item[0]['VIEW']!=''))?$arr_item[0]['VIEW']:"null").",".((($arr_item[0]['CTRL']!=null)&&($arr_item[0]['CTRL']!=''))?$arr_item[0]['CTRL']:"null").",".((($arr_item[0]['PARENTID']!=null)&&($arr_item[0]['PARENTID']!=''))?$arr_item[0]['PARENTID']:"null").")";
							if(!mysql_query($sql))echo $sql."<br/>";
						}
					}
				}
			}
			break;	
		case SATELLITE_CAT_ITEMS_UPDATE:
			$CDid=null;if(!empty($_GET['CDid']))$CDid=(int)$_GET['CDid'];
			$CDName=null;if(!empty($_GET['CDName']))$CDName=$_GET['CDName'];
			if($CDid!=null){
				$sql="SELECT `id`,`name` FROM `".DB_TABLE_PREFIX."catlinkexchange` WHERE `id`=".$CDid." limit 1";
				$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_OPEN_CATLINKEXCHANGE.'&DMid='.DOMAIN_ID.'&CDid='.$CDid;	
				get_objects($url,'CATEGORY',$arr_item);
				if($row=mysql_fetch_assoc(mysql_query($sql))){
					if(count($arr_item)>0){
						$sql="UPDATE `".DB_TABLE_PREFIX."catlinkexchange` SET 
								`name`='".mysql_real_escape_string(utf8_decode($arr_item[0]['NAME']))."',
								`desc`='".mysql_real_escape_string(utf8_decode($arr_item[0]['DESC']))."',
								`img1`='".mysql_real_escape_string(utf8_decode($arr_item[0]['IMG1']))."',
								`alt1`='".mysql_real_escape_string(utf8_decode($arr_item[0]['ALT1']))."',
								`view`=".((($arr_item[0]['VIEW']!=null)&&($arr_item[0]['VIEW']!=''))?$arr_item[0]['VIEW']:"null").",
								`ctrl`=".((($arr_item[0]['CTRL']!=null)&&($arr_item[0]['CTRL']!=''))?$arr_item[0]['CTRL']:"null").",
								`parentid`=".((($arr_item[0]['PARENTID']!=null)&&($arr_item[0]['PARENTID']!=''))?$arr_item[0]['PARENTID']:"null")."
								WHERE `id`=".$arr_item[0]['ID']."";
						if(!mysql_query($sql))echo $sql."<br/>";
					}
				}else{
					if(count($arr_item)>0){
						$sql="INSERT INTO `".DB_TABLE_PREFIX."catlinkexchange`(`id`,`name`,`desc`,`img1`,`alt1`,`view`,`ctrl`,`parentid`) VALUES ";
						$sql.="(".$arr_item[0]['ID'].",'".mysql_real_escape_string(utf8_decode($arr_item[0]['NAME']))."','".mysql_real_escape_string(utf8_decode($arr_item[0]['DESC']))."','".mysql_real_escape_string(utf8_decode($arr_item[0]['IMG1']))."','".mysql_real_escape_string(utf8_decode($arr_item[0]['ALT1']))."',".((($arr_item[0]['VIEW']!=null)&&($arr_item[0]['VIEW']!=''))?$arr_item[0]['VIEW']:"null").",".((($arr_item[0]['CTRL']!=null)&&($arr_item[0]['CTRL']!=''))?$arr_item[0]['CTRL']:"null").",".((($arr_item[0]['PARENTID']!=null)&&($arr_item[0]['PARENTID']!=''))?$arr_item[0]['PARENTID']:"null").")";
						if(!mysql_query($sql))echo $sql."<br/>";
					}
				}
				$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_GET_LINKEXCHANGE.'&DMid='.DOMAIN_ID.'&CDid='.$CDid;
				get_objects($url,'ITEM',$arr_item);
				if(count($arr_item)>0){
					$sql="";
					for($i=0;$i<count($arr_item);$i++){
						$sql="SELECT `id` FROM `".DB_TABLE_PREFIX."linkexchange` WHERE `id`=".$arr_item[$i]['ID']." limit 1";
						if($row=mysql_fetch_assoc(mysql_query($sql))){
							$sql="UPDATE `".DB_TABLE_PREFIX."linkexchange` SET 
									`name`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['NAME']))."',
									`title`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['TITLE']))."',
									`url`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['URL']))."',
									`src`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['SRC']))."',
									`desc`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['DESC']))."',
									`created`='".mysql_real_escape_string($arr_item[$i]['CREATED'])."',
									`lastupdate`='".mysql_real_escape_string($arr_item[$i]['LASTUPDATE'])."',
									`view`=".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").",
									`type`=".((($arr_item[$i]['TYPE']!=null)&&($arr_item[$i]['TYPE']!=''))?$arr_item[$i]['TYPE']:"null").",
									`status`=".((($arr_item[$i]['STATUS']!=null)&&($arr_item[$i]['STATUS']!=''))?$arr_item[$i]['STATUS']:"null").",
									`email`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['EMAIL']))."',
									`phone`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['PHONE']))."',
									`address`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['ADDRESS']))."',
									`extra`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['EXTRA']))."',
									`ctrl`=".((($arr_item[$i]['CTRL']!=null)&&($arr_item[$i]['CTRL']!=''))?$arr_item[$i]['CTRL']:"null")." 
									WHERE `id`=".$arr_item[$i]['ID']."";
							if(!mysql_query($sql))echo $sql."<br/>";
						}else{
							$sql="INSERT INTO `".DB_TABLE_PREFIX."linkexchange`(`id`,`name`,`title`,`url`,`src`,`desc`,`created`,`lastupdate`,`view`,`type`,`status`,`email`,`phone`,`address`,`extra`,`ctrl`) VALUES ";
							$sql.="(".$arr_item[$i]['ID'].",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['NAME']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['TITLE']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['URL']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['SRC']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['DESC']))."','".mysql_real_escape_string($arr_item[$i]['CREATED'])."','".mysql_real_escape_string($arr_item[$i]['LASTUPDATE'])."',".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").",".((($arr_item[$i]['TYPE']!=null)&&($arr_item[$i]['TYPE']!=''))?$arr_item[$i]['TYPE']:"null").",".((($arr_item[$i]['STATUS']!=null)&&($arr_item[$i]['STATUS']!=''))?$arr_item[$i]['STATUS']:"null").",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['EMAIL']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['PHONE']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['ADDRESS']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['EXTRA']))."',".((($arr_item[$i]['CTRL']!=null)&&($arr_item[$i]['CTRL']!=''))?$arr_item[$i]['CTRL']:"null").")";
							if(!mysql_query($sql))echo $sql."<br/>";
						}						
					}
				}
				$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_GET_CATLINKEXCHANGELINKEXCHANGE.'&DMid='.DOMAIN_ID.'&CDid='.$CDid;
				get_objects($url,'RELATION',$arr_item);
				if(count($arr_item)>0){
					$sql="DELETE FROM `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` WHERE `catlinkexchangeid`=".$CDid;
					if(!mysql_query($sql))echo $sql."<br/>";
					for($i=0;$i<count($arr_item);$i++){
						$sql="INSERT INTO `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` (`catlinkexchangeid`,`linkexchangeid`,`view`) VALUES ";
						$sql.="(".$arr_item[$i]['CATLINKEXCHANGEID'].",".$arr_item[$i]['LINKEXCHANGEID'].",".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").")";
						if(!mysql_query($sql))echo $sql."<br/>";
					}
				}
			}
			break;	
		case SATELLITE_ITEMS_UPDATE:
			$CDid=null;if(!empty($_GET['CDid']))$CDid=(int)$_GET['CDid'];
			$LXid=null;if(!empty($_GET['LXid']))$LXid=explode(",",$_GET['LXid']);
			if($CDid!=null){
				$sql="SELECT `id`,`name` FROM `".DB_TABLE_PREFIX."catlinkexchange` WHERE `id`=".$CDid." limit 1";
				if($row=mysql_fetch_assoc(mysql_query($sql))){}
				else{
					$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_OPEN_CATLINKEXCHANGE.'&DMid='.DOMAIN_ID.'&CDid='.$CDid;
					get_objects($url,'CATEGORY',$arr_item);
					if(count($arr_item)>0){
						$sql="INSERT INTO `".DB_TABLE_PREFIX."catlinkexchange`(`id`,`name`,`desc`,`img1`,`alt1`,`view`,`ctrl`,`parentid`) VALUES ";
						$sql.="(".$arr_item[0]['ID'].",'".mysql_real_escape_string(utf8_decode($arr_item[0]['NAME']))."','".mysql_real_escape_string(utf8_decode($arr_item[0]['DESC']))."','".mysql_real_escape_string(utf8_decode($arr_item[0]['IMG1']))."','".mysql_real_escape_string(utf8_decode($arr_item[0]['ALT1']))."',".((($arr_item[0]['VIEW']!=null)&&($arr_item[0]['VIEW']!=''))?$arr_item[0]['VIEW']:"null").",".((($arr_item[0]['CTRL']!=null)&&($arr_item[0]['CTRL']!=''))?$arr_item[0]['CTRL']:"null").",".((($arr_item[0]['PARENTID']!=null)&&($arr_item[0]['PARENTID']!=''))?$arr_item[0]['PARENTID']:"null").")";
						if(!mysql_query($sql))echo $sql."<br/>";
					}
				}
				$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_GET_LINKEXCHANGE.'&DMid='.DOMAIN_ID.'&CDid='.$CDid.'&item='.$_GET['LXid'];
				get_objects($url,'ITEM',$arr_item);
				for($i=0;$i<count($arr_item);$i++){
					$sql="SELECT `id` FROM `".DB_TABLE_PREFIX."linkexchange` WHERE `id`=".$arr_item[$i]['ID']." limit 1";
					if($row=mysql_fetch_assoc(mysql_query($sql))){
						$sql="UPDATE `".DB_TABLE_PREFIX."linkexchange` SET 
								`name`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['NAME']))."',
								`title`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['TITLE']))."',
								`url`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['URL']))."',
								`src`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['SRC']))."',
								`desc`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['DESC']))."',
								`created`='".mysql_real_escape_string($arr_item[$i]['CREATED'])."',
								`lastupdate`='".mysql_real_escape_string($arr_item[$i]['LASTUPDATE'])."',
								`view`=".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").",
								`type`=".((($arr_item[$i]['TYPE']!=null)&&($arr_item[$i]['TYPE']!=''))?$arr_item[$i]['TYPE']:"null").",
								`status`=".((($arr_item[$i]['STATUS']!=null)&&($arr_item[$i]['STATUS']!=''))?$arr_item[$i]['STATUS']:"null").",
								`email`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['EMAIL']))."',
								`phone`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['PHONE']))."',
								`address`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['ADDRESS']))."',
								`extra`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['EXTRA']))."',
								`ctrl`=".((($arr_item[$i]['CTRL']!=null)&&($arr_item[$i]['CTRL']!=''))?$arr_item[$i]['CTRL']:"null")." 
								WHERE `id`=".$arr_item[$i]['ID']."";
						if(!mysql_query($sql))echo $sql."<br/>";
					}else{
						$sql="INSERT INTO `".DB_TABLE_PREFIX."linkexchange`(`id`,`name`,`title`,`url`,`src`,`desc`,`created`,`lastupdate`,`view`,`type`,`status`,`email`,`phone`,`address`,`extra`,`ctrl`) VALUES ";
						$sql.="(".$arr_item[$i]['ID'].",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['NAME']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['TITLE']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['URL']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['SRC']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['DESC']))."','".mysql_real_escape_string($arr_item[$i]['CREATED'])."','".mysql_real_escape_string($arr_item[$i]['LASTUPDATE'])."',".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").",".((($arr_item[$i]['TYPE']!=null)&&($arr_item[$i]['TYPE']!=''))?$arr_item[$i]['TYPE']:"null").",".((($arr_item[$i]['STATUS']!=null)&&($arr_item[$i]['STATUS']!=''))?$arr_item[$i]['STATUS']:"null").",'".mysql_real_escape_string(utf8_decode($arr_item[$i]['EMAIL']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['PHONE']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['ADDRESS']))."','".mysql_real_escape_string(utf8_decode($arr_item[$i]['EXTRA']))."',".((($arr_item[$i]['CTRL']!=null)&&($arr_item[$i]['CTRL']!=''))?$arr_item[$i]['CTRL']:"null").")";
						if(!mysql_query($sql))echo $sql."<br/>";
					}						
					$sql="DELETE FROM `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` WHERE `linkexchangeid`=".$arr_item[$i]['ID'];
					if(!mysql_query($sql))echo $sql."<br/>";
					$sql="INSERT INTO `".DB_TABLE_PREFIX."catlinkexchangelinkexchange` (`catlinkexchangeid`,`linkexchangeid`,`view`) VALUES ";
					$sql.="(".$CDid.",".$arr_item[$i]['ID'].",null)";
					if(!mysql_query($sql))echo $sql."<br/>";
				}
			}else{
				$url=URL_LINKEXCHANGE_SERVICES.'?usermail='.USER_EMAIL.'&userpass='.esnc_decode(USER_PASS).'&act='.ACT_GET_LINKEXCHANGE.'&DMid='.DOMAIN_ID.'&item='.$_GET['LXid'];
				get_objects($url,'ITEM',$arr_item);
				for($i=0;$i<count($arr_item);$i++){
					$sql="SELECT `id` FROM `".DB_TABLE_PREFIX."linkexchange` WHERE `id`=".$arr_item[$i]['ID']." limit 1";
					if($row=mysql_fetch_assoc(mysql_query($sql))){
						$sql="UPDATE `".DB_TABLE_PREFIX."linkexchange` SET 
								`name`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['NAME']))."',
								`title`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['TITLE']))."',
								`url`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['URL']))."',
								`src`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['SRC']))."',
								`desc`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['DESC']))."',
								`created`='".mysql_real_escape_string($arr_item[$i]['CREATED'])."',
								`lastupdate`='".mysql_real_escape_string($arr_item[$i]['LASTUPDATE'])."',
								`view`=".((($arr_item[$i]['VIEW']!=null)&&($arr_item[$i]['VIEW']!=''))?$arr_item[$i]['VIEW']:"null").",
								`type`=".((($arr_item[$i]['TYPE']!=null)&&($arr_item[$i]['TYPE']!=''))?$arr_item[$i]['TYPE']:"null").",
								`status`=".((($arr_item[$i]['STATUS']!=null)&&($arr_item[$i]['STATUS']!=''))?$arr_item[$i]['STATUS']:"null").",
								`email`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['EMAIL']))."',
								`phone`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['PHONE']))."',
								`address`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['ADDRESS']))."',
								`extra`='".mysql_real_escape_string(utf8_decode($arr_item[$i]['EXTRA']))."',
								`ctrl`=".((($arr_item[$i]['CTRL']!=null)&&($arr_item[$i]['CTRL']!=''))?$arr_item[$i]['CTRL']:"null")." 
								WHERE `id`=".$arr_item[$i]['ID']."";
						if(!mysql_query($sql))echo $sql."<br/>";
					}						
				}
			}
			break;
		case SATELLITE_ACT_GET_ALL_CATLINKEXCHANGE:
			$sql="SELECT `id`,`name`,`img1`,`alt1`,`desc`,`view`,`parentid` FROM `".DB_TABLE_PREFIX."catbanner` 
					WHERE `ctrl`&".CATBANNER_CTRL_LINK."=".CATBANNER_CTRL_LINK." ORDER BY `id`";
			$rs =mysql_query($sql);
			if($row=mysql_fetch_assoc($rs)){
				$text="<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?>";
				$text.="<DOCUMENT>\n";
				do{
					$text.="<CATEGORY ID=\"".$row['id']."\" NAME=\"".htmlspecialchars(utf8_encode($row['name']))."\" DESC=\"".htmlspecialchars(utf8_encode($row['desc']))."\" IMG1=\"".htmlspecialchars(utf8_encode($row['img1']))."\" ALT1=\"".htmlspecialchars(utf8_encode($row['alt1']))."\" VIEW=\"".$row['view']."\" CTRL=\"".CATLINKEXCHANGE_CTRL_SHOW."\" PARENTID=\"\">";
					$sql="SELECT DISTINCT `a`.`id`,`a`.`name`,`a`.`url`,`a`.`view`,`a`.`ctrl`,`a`.`desc`,`a`.`mybanner`
							FROM `".DB_TABLE_PREFIX."banner` as `a`
							INNER JOIN `".DB_TABLE_PREFIX."catbannerbanner` as `b` on `a`.`id`=`b`.`bannerid` AND `b`.`catbannerid`=".$row['id']."
							WHERE `a`.`ctrl`&".BANNER_CTRL_LINK."=".BANNER_CTRL_LINK." 
							ORDER BY `a`.`id`";
					$rs1=mysql_query($sql);
					if($row1=mysql_fetch_assoc($rs1)){
						do{
							$text.="<ITEM CATID=\"".$row['id']."\" TITLE=\"".htmlspecialchars(utf8_encode($row1['name']))."\" URL=\"".htmlspecialchars(utf8_encode($row1['url']))."\" SRC=\"".htmlspecialchars(utf8_encode($row1['mybanner']))."\" DESC=\"".htmlspecialchars(utf8_encode($row1['desc']))."\" VIEW=\"".$row1['view']."\" CTRL=\"".(((int)$row1['ctrl']&BANNER_CTRL_SHOW==BANNER_CTRL_SHOW)?LINKEXCHANGE_CTRL_SHOW:LINKEXCHANGE_CTRL_OVERWRITE)."\"/>\n";
						}while($row1=mysql_fetch_assoc($rs1));
					}
					$text.="</CATEGORY>\n";
				}while($row=mysql_fetch_assoc($rs));
				$text.="</DOCUMENT>\n";
			break;
		}			
	}
	echo $text;
}else echo "hihi";
dblink_close();
redirect('http://links.esnc.net/');
?>