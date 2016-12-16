<?php //vinhtx@esndvanced.com 22-Feb-2006
/*common function for admin interface*/
@include_once('../resize-images.php');
@define('URL_SELF',$_SERVER['SCRIPT_NAME']);

function esnc_passwd_encode($s){ return base64_encode($s);}
function esnc_passwd_decode($s){ return base64_decode($s);}
function _esnc_check_update(){}

function esnc_strtoattribute($s,$sep='|',$pair='='){
	return unserialize($s);
	$attrib = explode($sep,$s);
	$attr=array();
	foreach($attrib as $att){
		$t = explode($pair,$att,2);
		$attr[$t[0]]=$t[1];
	}
	return $attr;
}
function esnc_attributetostr(&$a,$sep='|',$pair='='){
	return serialize($a);
	foreach($a as $key=>$value){
		$s .= $key.$pair.$value.$sep;
	}
	return rtrim($s,$sep);
}
function filesave($file,&$data){
	global $sql;
	$file=str_replace(PATH_MYIMAGES,'',strtr($file,'\\','/'));
	$sql = 'REPLACE INTO `'.DB_TABLE_PREFIX.'fs`(`name`,`content`) VALUES(\''.addslashes($file).'\',\''.mysql_real_escape_string($data).'\')';
	if(mysql_query($sql)) return TRUE;
	_trace(mysql_error());
}
function fileshow($file){
	if(@readfile($file)) return TRUE;
	global $rs,$row;
	$file=str_replace(PATH_MYIMAGES,'',$file);
	$rs = mysql_select('`content` as `c`','`#fs`','`name`=\''.mysql_real_escape_string($file).'\'');
	if($row = mysql_fetch_row($rs)){
		mysql_free_result($rs);
		echo $row[0];
		return TRUE;
	}
	return FALSE;
}
function fileread($file){
	if($s = @file_get_contents($file)) return $s;
	global $rs,$row;
	$file=str_replace(PATH_MYIMAGES,'',$file);
	$rs = mysql_select('`content` as `c`','`#fs`','`name`=\''.mysql_real_escape_string($file).'\'');
	if($row = mysql_fetch_row($rs)){
		mysql_free_result($rs);
		return $row[0];
	}
	mysql_free_result($rs);
	return FALSE;	
}
function fileremove($file){
	if(@unlink($file)) return TRUE;
	global $sql;
	$file=str_replace(PATH_MYIMAGES,'',$file);
	$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'fs` WHERE `name`=\''.$file.'\'';
	return mysql_query($sql);
}
function filemove(&$file,$path1,$path2,$size){
// sua boi dangtx  -> resize image

	if(is_file($t=$path1.$file)){
		resize_image($path1,$file,$size);
		if(is_file($tt=$path2.$file)) return @rename($t,$path2.($file=getuniquename().'_'.$file));//auto rename
		else return @rename($t,$tt);
	}
	return FALSE;//file doesnot exists
}
function ctrl_format($ctrl,$mask=0,$prefix='cl'){
	if($mask == 0){
		$c = $ctrl >> 1;//ctrl
		$stat = '';
	}
	else{
		$c = ($ctrl  & ~$mask) >> 1;
		$stat = strtoupper(base_convert(trim(base_convert($ctrl & $mask,10,2),'0'),2,36));
		if($stat == '0') $stat = '';
	}
	if($c == 0){
		if($stat == '') return '&nbsp;';
		else return '<span class="stat st'.$stat.'">'.$stat.'</span>';
	}
	$s = base_convert($c,10,2);
	$n = strlen($s)-1;
	$v = '';
	for($i=$n,$j=0;$i >=0; --$i,++$j)
		if($s{$i} == '1') $v .= '<span class="ctrl '.$prefix.$j.'" >|</span>&nbsp;';
//		else $v .='<span class="ctrl z0">|</span>&nbsp;';
	return $v.'<span class="stat st'.$stat.'">'.$stat.'</span>';
}
function status_format($sts,&$a_status){
	if($sts) return '<span class="stat st'.$sts.'" title="'.$a_status[$sts].'">'.chr(ord('A')-1 + $sts).'</span>';
}
function ctrl_filterbox(&$a_ctrl,$ctrl){?>
	<div id="attributetext" style="margin:1px 20px 1px 5px; " onClick="SHOW('filter');HIDE('attribute');"><span>L&#7885;c theo &#273;&#7863;c t&#237;nh</span></div>
		<div id="filter" style="margin:1px 0px 1px 0px; border-top:1px solid #96969D;border-right:0px;border-bottom:0px; width:200px;">
		<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>		
		<tr><td class="attribute">&nbsp;T&#7845;t c&#7843; c&#225;c m&#7909;c</td><td class="attribute" align="center"><input type="checkbox" name="ctrl0" value="0"></td></tr>
<?php		$i=1; 
			foreach($a_ctrl as $ctl=>$text){
				$checked =($ctrl & $ctl)?' checked':'';
				echo '<tr><td class="attribute">'.ctrl_format($ctl).'&nbsp;'.$text.'</td>
					<td class="attribute" align="center"><input id="'.$i.'" type="checkbox" name="ctrl" value="'.$ctl.'" '.$checked .'></td>
					</tr>';								
					$i=$i+1;	
			}
?>		<tr><td colspan="2" align="center"><input onClick="filterFeature('ctrl');" type="button" class="button" value="Th&#7921;c hi&#7879;n"><input class="button" onClick="HIDE('filter')" type="button" value="B&#7887; qua"></td></tr>
		</tbody></table>				
	</div>	
<?php }
function ctrl_setbox(&$a_ctrl,&$status=NULL){?>
<div id="attributetext" style="margin:1px 0px 1px 5px; " onClick="SHOW('attribute');HIDE('filter');"><span>Thi&#7871;t l&#7853;p &#273;&#7863;c t&#237;nh</span></div>
	<div id="attribute" style="margin:1px 0px 1px 5px; border-top:1px solid #96969D;border-right:0px;border-bottom:0px;width:250px">
	<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
	<tr><td width="60%" class="attribute">&nbsp;</td><td class="attribute" align="center">Thi&#7871;t l&#7853;p</td><td class="attribute" align="center">Hu&#7927; b&#7887;</td></tr>
		<?php
		$i=1; 
		foreach($a_ctrl as $ctl=>$text){
		echo '<tr><td class="attribute">'.ctrl_format($ctl).'&nbsp;'.$text.'</td>
			<td class="attribute" align="center"><input id="'.$i.'" type="checkbox" name="ctrl'.$i.'" value="'.$ctl.'" onClick="singleSelect(this);"></td>
			<td class="attribute" align="center"><input id="'.($i+1).'" type="checkbox" name="ctrl'.$i.'" value="'.$ctl.'" onClick="singleSelect(this);"></td></tr>';				
			$i=$i+2;	
		}
		if(is_array($status)){
			foreach($status as $ctl=>$text){
				echo '<tr><td class="attribute">&nbsp;&nbsp;'. status_format($ctl,$status).' '.$text.'</td>
					<td class="attribute" align="center"><input  type="radio" name="status" value="'.$ctl.'" ></td>
					<td class="attribute">&nbsp;</td>
					</tr>';								
				$i=$i+1;	
			}
		}
		?>
	<tr><td colspan="3" align="center"><input onClick="setCtrl(ACT_SETCTRL);" type="button" class="button" value="Th&#7921;c hi&#7879;n"><input class="button" onClick="HIDE('attribute')" type="button" value="B&#7887; qua"></td></tr>
	</tbody></table>				
</div>
<?php }
function getmeta(&$ss,&$title,&$base,&$a){
	$a=array();
	$s=strip_tags($ss,'<title><base><meta>');
	$t=strip_tags($s,'<title>');
	if(preg_match('/\>([^\<]+)\</m',$t,$m)) $title=$m[1];
	$t=strip_tags($s,'<meta>');
	if(preg_match_all('/<meta\s+([a-zA-Z\-]+)\=\"([^\"]+)\"\s+([a-zA-Z\-]+)\=\"([^\"]+)\"/m',$t,$m,PREG_SET_ORDER)){
		foreach($m as $v){
			if($v[1] == 'content'){
				$a[strtolower($v[4])]=$v[2];
			}else{
				$a[strtolower($v[2])]=$v[4];
			}
		}
	}
	$t=strip_tags($s,'<base>');
	if(preg_match('/<base href=\"([^\"]+)\"/i',$t,$m)) $base=$m[1];
}

function redirect($url){
	$host = 'http://'.$_SERVER['HTTP_HOST'];
	@header('HTTP/1.1 303 See Other',TRUE,303);
	if(strpos($url,':') !== FALSE) @header('Location:'.$url);//absolute url
	elseif(strpos($url,'/') === 0) @header('Location:'.$host.$url);//relative to base url
	elseif(strpos($url,'../') === 0){ //relative to parent directory
		$d = dirname(URL_SELF);//current directory
		$d = dirname($d);//parent directory
		@header('Location:'.$host.$d.substr($url,2));
	}elseif(strpos($url,'./') === 0){ //relative to current directory
		$d = dirname(URL_SELF);//current directory
		@header('Location:'.$host.$d.substr($url,1));
	}else{
		$d = dirname(URL_SELF);//current directory
		@header('Location:'.$host.$d.'/'.$url);
	}
	exit('<html><head><meta http-equiv="refresh" content="0;url='.$url.'" /><script language="javascript" type="text/javascript">self.location.href="'.$url.'";</script></head></html>');
}
function currency_format_number($f,$curid=0){//convert number to currency
	if($curid){
		$cur=&$GLOBALS['CURRENCY'][$curid];//VALUE,PREFIX,THOUSAND,DECIMAL,DECIMAL_PLACE,SUFFIX,CTRL
		return number_format(($cur[6] ? $f*$cur[0]: $f/$cur[0]),$cur[4],$cur[3],$cur[2]);
	}
	return number_format($f,CURRENCY_DECIMAL_PLACE,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_THOUSAND_SEPERATOR);
}
function currency_format($f,$curid=0){//convert number to currency
	if($curid){
		$cur=&$GLOBALS['CURRENCY'][$curid];//VALUE,PREFIX,THOUSAND,DECIMAL,DECIMAL_PLACE,SUFFIX,CTRL
		return $cur[1].number_format(($cur[6] ? $f*$cur[0]: $f/$cur[0]),$cur[4],$cur[3],$cur[2]).$cur[5];
	}return CURRENCY_PREFIX.number_format($f,CURRENCY_DECIMAL_PLACE,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_THOUSAND_SEPERATOR).CURRENCY_SUFFIX;
}
function currency_unformat($s){//convert currency to number for storage
	$s = preg_replace('/(?:^\D+|\D+$)/','',$s);
	$s = str_replace(array(CURRENCY_THOUSAND_SEPERATOR,CURRENCY_DECIMAL_SEPERATOR),array('','.'),$s);
	return floatval($s);
}

function showloadscreen($url,$time=3,$topmsg='&#272;ang x&#7917; l&yacute;...',$base=URL_BASE_ADMIN){?>
<html>
<head><base href="<?php echo $base;?>" />
<meta http-equiv="refresh" content="<?php echo $time ?>;url='<?php echo $url ?>'" />
<link rel="stylesheet" type="text/css" href="images/style.css" />
</head>
<body leftmargin="0" rightmargin="0">
<table width="300" cellpadding="0" cellspacing="0" align="center" style="margin-top:50px; ">
	<tr>
	  <td width="1"><img src="images/leftbox.gif"></td><td bgcolor="#566FF0" align="center" style="color:#FFFFFF;font-family:tahoma;font-size:11px;font-weight:bold"><?php echo $topmsg ?></td><td width="1"><img src="images/rightbox.gif"></td>
	</tr>
	<tr><td style="border-left:1px solid #566FF0">&nbsp;</td><td align="center"><img src="images/load.gif"></td><td style="border-right:1px solid #566FF0">&nbsp;</td></tr>
	<tr><td style="border-left:1px solid #566FF0;border-bottom:1px solid #566FF0">&nbsp;</td>
	<td align="center" style="border-bottom:1px solid #566FF0; font-family:tahoma;font-size:11px">N&#7871;u h&#7879; th&#7889;ng kh&ocirc;ng t&#7921; chuy&#7875;n, xin m&#7901;i <a href="<?php echo $url ?>" style="text-decoration:none;font-weight:bold" class="item">nh&#7845;n v&agrave;o &#273;&acirc;y</a></td>
	<td style="border-right:1px solid #566FF0;border-bottom:1px solid #566FF0">&nbsp;</td></tr>
</table>
</body>
<script language="javascript" type="text/javascript">
window.setTimeout('self.location.href="<?php echo $url ?>";',<?php echo $time*1000; ?>);
</script>
</html>
<?php }
function urlchop($q){
/*remove var_name from query string $q
        use: $s=urlchop($q,$var_name1,$var_name2,....)
*/
        $s = '&'.$q.'&';
        $argc=func_num_args();
        for($i=1; $i<$argc;++$i){
                $name=(string)func_get_arg($i);
                $pattern='/&'.$name.'\=[^&]*(?=&)/i';
                $s=preg_replace($pattern,'&',$s);
        }
        return preg_replace(array('/&{2,}/','/(^&|&$)/'),array('&',''),$s);
}
function urlformat($q){
/*append $name=$value to query string $q
        use: $s=urlformat($q,$name,$value,$name,$value...);
*/
        $s='&'.$q.'&';
        $argc=func_num_args();
        for($i = 1;$i < $argc;++$i){
                $name=(string)func_get_arg($i);
                $value=(string)func_get_arg(++$i);
                $pattern = '/&'.$name.'\=[^&]*(?=&)/i';
                $s=preg_replace($pattern,'&',$s);
                $s .= '&'.$name.'='.urlencode($value).'&';
        }
        $s = preg_replace(array('/&{2,}/','/(^&|&$)/'),array('&',''),$s);
        return $s;
}
function urltohidden($q){
        $t = explode('&',$q);
        foreach($t as $pair){
                $tt = explode('=',$pair);
                if($tt[0] != '') { $ttt=urldecode($tt[1]);//decode value
                        echo "<input type='hidden' name='{$tt[0]}' value='{$ttt}'>\r\n";
                }
        }
}
function urlmodify(){
	$argn=func_num_args();
	$s = '';
	$a_name=array();
	for($i = 0; $i < $argn; ++$i){
		$name=$a_name[] = func_get_arg($i);
		$value = func_get_arg(++$i);
		if($value !== NULL){
			$s .= '&'.$name.'='.urlencode($value);
		}
	}
	$ss = '';
	foreach($_GET as $name=>$value){
		if(!in_array($name,$a_name)) $ss .='&'.$name.'='.urlencode($value);
	}
	return ltrim($ss.$s,'&');
}
function pushdir($dir){
	global $OLDDIR;
	array_push($OLDDIR,getcwd());
	chdir($dir);
}
function popdir(){
	global $OLDDIR;
	$dir = array_pop($OLDDIR);
	chdir($dir);
}
function strleft($s,$len){
/*trim vietnamese char $s by $len left */
	return $len < 10 ?$s : preg_replace('/\s+[^\s]*$/','...',substr(preg_replace('/(\<[^\>]+\>|[\x00-\x1F]|\s{2,})/',' ',$s),0,$len));
}
function htmlview($path,$file,$style='',$txt=''){
	if ((string)$file==""){ if($txt != '') echo $txt; return; }
	if(strpos($file,'/>') !== FALSE){
		echo str_replace('/>',' '.$style.'/>',$file); return;
	}elseif(strpos($file,'>') !== FALSE){
		echo str_replace('>',' '.$style.'>',$file); return;
	}
	$f = strpos($file,':') !== FALSE || strpos($file,'/') === 0 ? $file : $path.$file;
	switch(strtolower(substr($f,strrpos($f,'.') + 1))){
	case 'wma':
	case 'wmv':
	case 'mp3':
	case 'avi':
	case 'swf': echo "<embed src=\"{$f}\"  {$style} />";	return;
	default:
		echo "<img src=\"{$f}\" {$style} />";
	}//switch
}
function relpath($path,$file){
	return strpos($file,':') !== FALSE ? $file : $path.$file;
}
function getuniquename($name=NULL){
     	$tem = strtoupper(base_convert(time(),10,35).base_convert(rand(1,100000),10,35));
		if($name) return $tem.'_'.preg_replace('/[^a-zA-Z\.]+|_{2,}|(?:\.+(?=\.))/','_',(string)$name);
		else return $tem;
}
function _trace($s){
	//file_put_contents(PATH_TEMP.'trace1.txt',print_r($s,TRUE)."\r\n",FILE_APPEND);
}
_trace('========'.$_SERVER['REQUEST_METHOD'].' '.rtrim(URL_SELF.'?'.@$_SERVER['QUERY_STRING'],'?').'===='.strftime(FORMAT_DATETIME).'=====');
_trace($_POST,'$_POST:');
//dbclose();
?>
