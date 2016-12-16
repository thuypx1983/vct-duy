<?php
global $session;
if(!$session->getaccess(SESSION_CTRL_ADMIN)) exit();
$APP_CONFIG_TABLE=array();
$APP_CONFIG_FILE=FALSE;
function app_config_get($name){
	unset($GLOBALS['APP_CONFIG_TABLE'][$name]);
	return defined($name) ? constant($name):FALSE;
}
function app_config_add($name,$params,$flag=1){
	if(preg_match('/^[A-Z][A-Z0-9_]+$/',$name)){
		if(!is_array($GLOBALS['CFG'])) $GLOBALS['CFG']=parse_ini_file(PATH_APPLICATION.'config_desc.ini',TRUE);
		$GLOBALS['CFG'][$name]=&$params;
		save_ini_file(PATH_APPLICATION.'config_desc.ini',$GLOBALS['CFG']);
	}
}
function app_config_remove($name){
	if(!is_array($GLOBALS['CFG'])) $GLOBALS['CFG']=parse_ini_file(PATH_APPLICATION.'config_desc.ini',TRUE);
	unset($GLOBALS['CFG'][$name]);
	save_ini_file(PATH_APPLICATION.'config_desc.ini',$GLOBALS['CFG']);
}

function app_config_put($name,$value,$type){
	global $APP_CONFIG_FILE;
	if(preg_match('/^[A-Z][A-Z0-9_]+$/',$name)){
		fwrite($APP_CONFIG_FILE,'define(\''.$name.'\',');
		switch($type){
		case 'int':
		case 'float':
		case 'real':
			if(is_numeric($value)) fwrite($APP_CONFIG_FILE,$value);
			else fwrite($APP_CONFIG_FILE,0);
			break;
		case 'hex':
			if(is_numeric($value)) fprintf($APP_CONFIG_FILE,'0x%08X',$value);
			else fwrite($APP_CONFIG_FILE,0);
			break;
		default:
			fwrite($APP_CONFIG_FILE, '\'');
			fwrite($APP_CONFIG_FILE,str_replace(array('\'','\\'),array('\\\'','\\\\'),$value));
			fwrite($APP_CONFIG_FILE, '\'');
		}
		fwrite($APP_CONFIG_FILE, ");\r\n");
		unset($_POST['C'][$name]);//skip process this param by default processing
		return TRUE;
	}
}
function app_config_write(){
	global $APP_CONFIG_FILE,$CFG; 
	$trigger_save=FALSE;
	$t=$_POST['C']['EMAIL_MASTER'];
	$t = strtolower(substr($t,0,strpos($t,'@')));
	if(!$t) unset($_POST['C']['EMAIL_MASTER']);
	else $_POST['C']['EMAIL_MASTER'] = $t.'@'.strtolower(str_replace('www.','',$_SERVER['HTTP_HOST']));
	$_POST['C']['JOB_INTERVAL'] = max((int)$_POST['C']['JOB_INTERVAL'],300);
	if($_POST['C']['BANNER_PAGESIZE_LINKEXCHANGE'] && $_POST['C']['BANNER_PAGESIZE_LINKEXCHANGE'] != '!!DELETE!!'){
			$_POST['C']['BANNER_PAGESIZE_LINKEXCHANGE'] = ($t=(int)$_POST['C']['BANNER_PAGESIZE_LINKEXCHANGE']) > 5 ? $t: 40;
	}
	$c=PATH_ESNC.'index.php';//recompile template index.php
	if(is_file(PATH_APPLICATION.$_POST['C']['FILE_DEFAULT'])){
		chmod($c,0700);//make writable
		file_put_contents($c,'<?php readfile(\''.PATH_APPLICATION.$_POST['C']['FILE_DEFAULT'].'\');?>');// recompile template index.php
		chmod($c,0500);//make readonly
	}elseif(defined('FILE_DEFAULT')){
		unset($_POST['C']['FILE_DEFAULT']);//ignore setting if no file found;
		chmod($c,0700);//make writable
		touch($c,100);//tell compiler to recompile template
	}
	$seperator = $_POST['C']['DATE_SEPERATOR'];
	if($seperator == '%' ) $seperator = '%%';
	switch($_POST['C']['DATE_FORMAT']){
	case '%Y-%m-%d':
		$_POST['C']['FORMAT_DATE']='%Y'.$seperator.'%m'.$seperator.'%d';
		$_POST['C']['FORMAT_DATETIME']='%Y'.$seperator.'%m'.$seperator.'%d %H:%M:%S';
		$_POST['C']['FORMAT_DB_DATE']='%Y'.$seperator.'%m'.$seperator.'%d';
		$_POST['C']['FORMAT_DB_DATETIME'] = '%Y'.$seperator.'%m'.$seperator.'%d %T' ;
		$_POST['C']['REGEX_DATE'] = '/^[^\d]*(\d{4}|\d{2})[^\d]+(\d{1,2})[^\d]+(\d{1,2}).*$/' ;
		$_POST['C']['REGEX_DATETIME'] = '/^[^\d]*(\d{4}|\d{2})[^\d]+(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{0,3}).*$/' ;
		$_POST['C']['S_DB_DATE']='$1-$2-$3';
		$_POST['C']['S_DB_DATETIME']='$1-$2-$3 $4:$5:$6';
		break;
	case '%m-%d-%Y':
		$_POST['C']['FORMAT_DATE']='%m'.$seperator.'%d'.$seperator.'%Y';
		$_POST['C']['FORMAT_DATETIME']='%m'.$seperator.'%d'.$seperator.'%Y %H:%M:%S';
		$_POST['C']['FORMAT_DB_DATE']='%m'.$seperator.'%d'.$seperator.'%Y';
		$_POST['C']['FORMAT_DB_DATETIME'] = '%m'.$seperator.'%d'.$seperator.'%Y %T' ;
		$_POST['C']['REGEX_DATE'] = '/^[^\d]*(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{4}|\d{2}).*$/' ;
		$_POST['C']['REGEX_DATETIME'] = '/^[^\d]*(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{4}|\d{2})[^\d]+(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{0,3}).*$/' ;
		$_POST['C']['S_DB_DATE']='$3-$1-$2';
		$_POST['C']['S_DB_DATETIME']='$3-$1-$2 $4:$5:$6';
		break;
	default:
		$_POST['C']['FORMAT_DATE']='%d'.$seperator.'%m'.$seperator.'%Y';
		$_POST['C']['FORMAT_DATETIME']='%d'.$seperator.'%m'.$seperator.'%Y %H:%M:%S';
		$_POST['C']['FORMAT_DB_DATE']='%d'.$seperator.'%m'.$seperator.'%Y';
		$_POST['C']['FORMAT_DB_DATETIME'] = '%d'.$seperator.'%m'.$seperator.'%Y %T' ;
		$_POST['C']['REGEX_DATE'] = '/^[^\d]*(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{4}|\d{2}).*$/' ;
		$_POST['C']['REGEX_DATETIME'] = '/^[^\d]*(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{4}|\d{2})[^\d]+(\d{1,2})[^\d]+(\d{1,2})[^\d]+(\d{0,3}).*$/' ;
		$_POST['C']['S_DB_DATE']='$3-$2-$1';
		$_POST['C']['S_DB_DATETIME']='$3-$2-$1 $4:$5:$6';
	}
//end of standard configuration validation
	$tmp_file=PATH_TEMP.getuniquename().'.txt';
	if($APP_CONFIG_FILE = fopen($tmp_file,'w')){
		fwrite($APP_CONFIG_FILE,
'<?php /*created by system configuration editor*/ 
$EE = error_reporting(E_ALL & ~E_NOTICE);define(\'APPLICATION_CONFIG_FILE\',__FILE__);
');
		if(function_exists('app_config_save')) app_config_save();
		if(!$_POST['C']['SQL_NOW']){
			fwrite($APP_CONFIG_FILE,"\r\ndefine('SQL_NOW','\\''.strftime('%Y-%m-%d %H:%M:%S').'\\'');");
			unset($_POST['C']['SQL_NOW']);
		}
		$trigger_save=FALSE;
		foreach($_POST['C'] as $name=>$value){
			if(preg_match('/^[A-Z][A-Z0-9_]+$/',$name)){
				if($value === '!!DELETE!!'){
					unset($CFG[$name]);
					$trigger_save=TRUE;
				}else{
					if(is_array($value)){
						$vv=0;
						foreach($value as $v) $vv +=hexdec(substr($v,2));
						$value=$vv;
						$hex=TRUE;
					}elseif(stripos($value,'0x')===0){
						$value=hexdec(substr($value,2));
						$hex=TRUE;
					}else
						$hex=FALSE;
					if(array_key_exists($name,$CFG)){
						$cfg=&$CFG[$name];
						switch($cfg['type']){
						case 'int':
						case 'real':
							settype($value,$cfg['type']);
							if(strlen($cfg['min']) > 0 && $value < (int)$cfg['min']) $value=$cfg['min'];
							elseif(strlen($cfg['max']) > 0 && $value > (int)$cfg['max'])$value=$cfg['max'];
						break;
						default://string
							if($cfg['checktype']=='or'){
								if((strlen($cfg['re1']) > 2 ? !preg_match($cfg['re1'],$value):FALSE) 
								&& (strlen($cfg['re2']) > 2 ? !preg_match($cfg['re1'],$value):FALSE)
								&& (strlen($cfg['re3']) > 2 ? !preg_match($cfg['re3'],$value):FALSE)
								)
									$value=constant($name);
							}else{
								if((strlen($cfg['re1']) > 2 ? !preg_match($cfg['re1'],$value):FALSE) 
								 || (strlen($cfg['re2']) > 2 ? !preg_match($cfg['re1'],$value): FALSE)
								|| (strlen($cfg['re3']) > 2 ? !preg_match($cfg['re3'],$value) : FALSE)
								)
									$value=constant($name);
							}
						}
					}
					if(is_numeric($value)){
						if($hex) fprintf($APP_CONFIG_FILE,"\r\ndefine('{$name}',0x%08X);",$value);
						else fwrite($APP_CONFIG_FILE,"\r\ndefine('{$name}',{$value});");
					}else fwrite($APP_CONFIG_FILE,"\r\ndefine('{$name}','".addcslashes($value,'\\\'')."');");
				}
			}
		}
		fwrite($APP_CONFIG_FILE,"\r\ndate_default_timezone_set('{$_POST['L_TIME_ZONE']}');error_reporting(\$EE);?>");
		fclose($APP_CONFIG_FILE);
		chmod(APPLICATION_CONFIG_FILE,0700);
		if(rename(APPLICATION_CONFIG_FILE,PATH_TEMP.time().'~'.basename(APPLICATION_CONFIG_FILE))){
			rename($tmp_file,APPLICATION_CONFIG_FILE);
			include PATH_ADMIN.'inc/dbcon.php';
			$t=file_get_contents(APPLICATION_CONFIG_FILE);
			$sql='REPLACE INTO `'.DB_TABLE_PREFIX.'fs`(`name`,`content`) VALUES(\'application/config.php\',\''.mysql_real_escape_string($t).'\')';
			mysql_query($sql);
			dbclose();
		}
		chmod(APPLICATION_CONFIG_FILE,0500);
	}
	rename(PATH_APPLICATION.'config.js',PATH_TEMP.time().'~config.js');
	$fp = fopen(PATH_APPLICATION.'config.js','w');
	fwrite($fp,
'/* created by system configuration editor */
var URL_BASE="'.URL_BASE.'";
var URL_ROOT="'.URL_ROOT.'";
var FORMAT_DATE="'.$_POST['C']['FORMAT_DATE'].'";
var FORMAT_DATETIME="'.$_POST['C']['FORMAT_DATETIME'].'";
var DATE_FORMAT="'.$_POST['C']['DATE_FORMAT'].'";
var DATE_SEPERATOR="'.$_POST['C']['DATE_SEPERATOR'].'";
var REGEX_EMAIL='.REGEX_EMAIL.';
var REGEX_HREF='.REGEX_HREF.';
var REGEX_DATE='.$_POST['C']['REGEX_DATE'].';
var REGEX_DATETIME='.$_POST['C']['REGEX_DATETIME'].';
var TIME_ZONE="'.$_POST['C']['TIME_ZONE'].'";
var S_DB_DATETIME="'.$_POST['C']['S_DB_DATETIME'].'";
String.prototype.toDate = function(){	return eval("new Date(" + ((this + " 00:00:00:000").replace(REGEX_DATETIME,S_DB_DATETIME)).replace(/\D+/g,",").replace(/(\d{4})\,(\d{2})/,"$1,$2-1") + ")");}
String.prototype.trim = function(){  return this.replace(/(?:^\s*)|(?:\s*$)/g, "");}
/*@cc_on @if(1)	$=document.getElementById; @else@*/ function $(id){return document.getElementById(id);}/*@end@*/'
	);
	fclose($fp);
	if($name=$_POST['C_NAME']){
		$CFG[$name]=&$_POST['ini'];
		$CFG[$name]['default']=$_POST['C'][$name];
		if(is_array($_POST['opt']) && $_POST['opt'][0]){
			$CFG[$name]['option.count']=count($_POST['opt']);
			foreach($_POST['opt'] as $i=>$v)
				if($v){
					$CFG[$name]['option.value.'.$i]=$v;
					$CFG[$name]['option.text.'.$i]=$_POST['value'][$i];
				}
		}
		$trigger_save=TRUE;
	}
	if($trigger_save)	save_ini_file(PATH_APPLICATION.'config_desc.ini',$CFG);
}
function app_config_table_build(){//build APP_CONFIG_TABLE containing all constants as key name 
	if(filemtime(PATH_APPLICATION.'config.js') >= filemtime(APPLICATION_CONFIG_FILE) && $GLOBALS['CFG'])
		$GLOBALS['APP_CONFIG_TABLE'] = &$GLOBALS['CFG'];//using ini settting, otherwise, build from constant definition file
	else{
		global $APP_CONFIG_TABLE;
		$noedit='/^(?:CURRENCY|APPLICATION|FORMAT|DATE|EMAIL|SESSION|APP|S_DB|TIME|SQL|URL|REGEX|CACHE|JOB)_[A-Z0-9_]+$/';
		$fp = fopen(APPLICATION_CONFIG_FILE,'r');
		for($j=0;$j < 5000 && !feof($fp);++$j){
			$s = fgets($fp);
			if(preg_match('/^define\(\'([A-Z0-9_]+)\'/',$s,$m)){
				$c=$m[1];
				if($c=='URL_LINKEXCHANGE' || !preg_match($noedit,$c) && $c != 'CHARSET' && $c != 'MAX_LOGON_TRIES')	$APP_CONFIG_TABLE[$c]=TRUE;
			}
		}
		fclose($fp);
	}
}
function app_config_show_auto(){
	global $CFG,$APP_CONFIG_TABLE;
	echo '<table width="100%" cellspacing="0" cellpadding="2" id="config_auto"><col class="col_text" /><col class="col_input"/><tbody class="text">';
	foreach($APP_CONFIG_TABLE as $c=>$t){
		$v=constant($c);
		if($cfg=&$CFG[$c]){
			echo '<tr><td width="50%" style="cursor:help" title="'.$c.'">'.$cfg['name'].'</td><td>';
			switch($cfg['type']){
			case 'radio':
				$vv=$cfg['default'];
				echo '<input type="hidden" name="C['.$c.']" value="'.(is_numeric($vv) ? 0: '').'" />';
				$optioncount = (int)$cfg['option.count'];
				for($k=0;$k<$optioncount;++$k){
					$vv=$cfg['option.value.'.$k];
					echo '<input type="radio" class="input_mini" name="C['.$c.']" value="'.$vv.'"';
					if($vv==$v) echo ' checked';
					echo ' /> ';
					if($vt=$cfg['option.text.'.$k]) echo $vt; else echo $vv;
				}
				break;
			case 'dropdown':
				$optioncount = (int)$cfg['option.count'];
				echo '<select class="input" name="C['.$c.']">';
				for($k=0;$k<$optioncount;++$k){
					$vv=$cfg['option.value.'.$k];
					echo '<option value="'.$vv.'"';
					if($vv==$v) echo ' selected';
					echo ' > ';
					if($vt=$cfg['option.text.'.$k]) echo $vt; else echo $vv;
					echo '</option>';
				}
				echo '</select>';
				break;
			case 'checkbox':
				$optioncount = (int)$cfg['option.count'];
				$vv=$cfg['default'];
				echo '<input type="hidden" name="C['.$c.']" value="'.(is_numeric($vv) ? 0: '').'" />';
				if($optioncount > 0){//multi-select box, allow only for bit set
					for($k=0;$k<$optioncount;++$k){
						$vv=hexdec(substr($cfg['option.value.'.$k],2));
						echo '<label><input type="checkbox" class="input_mini" name="C['.$c.'][]" value="'.$cfg['option.value.'.$k].'"';
						if(($v & $vv)) echo ' checked';
						echo ' />';
						if($vt=$cfg['option.text.'.$k]) echo $vt; else echo $vv;
						echo '</label>';
					}
				}else{
					echo '<input type="checkbox" class="input_mini" name="C['.$c.']" value="'.$vv.'"';
					if($v == $vv) echo ' checked';
					echo ' />';
				}
				break;
			case 'int':
			case 'real':
			default:
				echo '<input class="input" name="C['.$c.']" onFocus="this.select();" value="'.htmlspecialchars($v).'" />';
			}
			echo '</td></tr>';
		}else
			echo '<tr><td width="50%">'.$c.'</td><td><input class="input" name="C['.$c.']" onFocus="this.select();" value="'.htmlspecialchars($v).'" /></td></tr>';
	}
	echo '</tbody></table>';
}

?>