<?php //vinhtx@esndvanced.com 22-Feb-2006
include_once(PATH_APPLICATION.'lang.php');
if(!is_file(PATH_COMPONENT.'commonguest.php')) touch(PATH_COMPONENT.'commonguest.php');
include PATH_COMPONENT.'commonguest.php';

@define('URL_SELF',	str_replace(PATH_ROOT,URL_ROOT,$_SERVER['SCRIPT_FILENAME']));//calculate absolute url under rewrite engine
define('FILE_SELF',basename(URL_SELF,'.php'));
ini_set('default_charset',CHARSET);

function esnc_passwd_encode($s){ return $s;}
function esnc_passwd_decode($s){ return $s;}
function esnc_check_update(){}

function esnc_span(&$s,$tag_text,$closetag='</span>',$tag='<span class="hilight">',$return=FALSE){
	$r = $tag.$tag_text.$closetag;
	if($return) 
		return str_ireplace($tag_text,$r,$s);
	else 
		echo str_ireplace($tag_text,$r,$s);
		
}
function esnc_noaccent($s){
	global $char_accent,$char_no_accent;
	return str_replace($char_accent,$char_no_accent,$s);
}
function esnc_strtoattribute($s,$sep='|',$pair='='){
	return @unserialize($s);
} 
function fileshow($rfile){
	global $sql;
	$file=str_replace(PATH_MYIMAGES,'',$rfile);
	$rs = mysql_select('`a`.`content` as `c`','`#fs` as `a`','`name`=\''.mysql_real_escape_string($file).'\'');
	if($row = mysql_fetch_row($rs)){
		mysql_free_result($rs);
		echo $row[0];
		return TRUE;
	}
	return @readfile($rfile);
}
function fileread($rfile){
	$file=str_replace(PATH_MYIMAGES,'',$rfile);
	global $sql;
	$rs = mysql_select('`content` as `c`','`#fs`','`name`=\''.mysql_real_escape_string($file).'\'');
	if($row = mysql_fetch_row($rs)){
		mysql_free_result($rs);
		return $row[0];
		mysql_free_result($rs);
	}else{
		return @file_get_contents($rfile);
	}
}
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
if(!function_exists('getallheaders')){
	function getallheaders(){
		$h = array();
		foreach($_SERVER as $header=>$value) if(strpos($header,'HTTP_') !== FALSE) $h[$header]=$value;
		$h['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR'];
		return $h;
	}
}
function totimestamp($d){//convert time $d to timestamp
	$d = preg_replace('/(?=\D(\d)(?=\D)/','0$1',$d);
	return strtotime(preg_replace(REGEX_DATETIME,S_DB_DATETIME, $d.' 00:00:00'));
}
function getuniquename($name=NULL){
     	$tem = strtoupper(base_convert(time(),10,35).base_convert(rand(1,100000),10,35));
		if($name == NULL) return $tem;
		else	return $tem.'_'.preg_replace((string)REGEX_NORMAL_FILENAME,'_',(string)$name);
}
function savecookie($cookie,$v,$expires,$url){
	$_COOKIE[$cookie] = $v;//for the rest of script to regcognize cookie set
	if(headers_sent()){
		echo '<script language="javascript">document.cookie = "'.$cookie.'='.urlencode($v).';path='.$url.';expires="+'.($expires > 0 ? '(new Date('.$expires.')).toGMTString()':'"31 Dec 2099 23:59:59 UTC+00"').';</script>';
	}else{
		setcookie($cookie,$v,$expires,$url);
	}
}
function mysql_format_datetime($datetime){
@define('S_DB_DATETIME','$3-$2-$1 $4:$5:$6');
	$count=0;
	$datetime = preg_replace(REGEX_DATETIME,S_DB_DATETIME,$datetime.':00:00:00:000',1,$count);
	if($count) return $datetime; else return '0000-00-00 00:00:00';
}
function mysql_format_date($datetime){
@define('S_DB_DATE','$3-$2-$1');
	$count=0;
	$datetime = preg_replace(REGEX_DATE,S_DB_DATE,$datetime,1,$count);
	if($count) return $datetime; else return '0000-00-00';
}
function redirect($url,$quit=TRUE,$js=FALSE){
	$reg='/^'.preg_quote(URL_ROOT,'/').'/';
	if($url{0}=='.' && $url{1}=='.'){//redirect to parent directory
		$url = URL_BASE.trim(dirname(dirname(preg_replace($reg,'',URL_SELF),'/'))).'/'.ltrim($url,'.');
	}elseif($url{0}=='/'){//to base url
		$url = URL_BASE.preg_replace($reg,'',$url);
	}elseif(strpos($url,':') === FALSE){//to current directory
		$url = URL_BASE.trim(dirname(preg_replace($reg,'',URL_SELF)),'/').'/'.ltrim($url,'./');
	}
	if($js || (!@header('HTTP/1.1 303 See Other',TRUE,303) and !@header('Location:'.$url))){
		echo '<head><meta http-equiv="Refresh" content="0;url=\''.$url.'\'"/>';
		echo '<script language="javascript">window.location.href="'.$url.'";</script></head>';
	}
	if($quit){
		@mysql_close();
		exit();
	}
}
function currency_format_number($f,$curid=CURRENCY){
	if($f==0 || $f==NULL) return TEXT_NO_PRICE;
	if($curid==0){
		return number_format($f,CURRENCY_DECIMAL_PLACE,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_THOUSAND_SEPERATOR);
	}else{
		$cur=&$GLOBALS['CURRENCY'][$curid];//VALUE,PREFIX,THOUSAND,DECIMAL,DECIMAL_PLACE,SUFFIX,CTRL
		return number_format(($cur[6] ? $f*$cur[0]: $f/$cur[0]),$cur[4],$cur[3],$cur[2]);
	}
}
function currency_format($f,$curid=CURRENCY){
	if($f==0 || $f==NULL) return TEXT_NO_PRICE;
	if($curid==0){
		return CURRENCY_PREFIX.number_format($f,CURRENCY_DECIMAL_PLACE,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_THOUSAND_SEPERATOR).CURRENCY_SUFFIX;
	}else{
		$cur=&$GLOBALS['CURRENCY'][$curid];//VALUE,PREFIX,THOUSAND,DECIMAL,DECIMAL_PLACE,SUFFIX,CTRL
		return $cur[1].number_format(($cur[6] ? $f*$cur[0]: $f/$cur[0]),$cur[4],$cur[3],$cur[2]).$cur[5];
	}
}
function currency_value($s,$curid=CURRENCY){
	if($s=='') return NULL;
	$s = preg_replace('/(?:^\D+|\D+$)/','',$s);
	if($curid==0){
			$s = str_replace(array(CURRENCY_THOUSAND_SEPERATOR,CURRENCY_DECIMAL_SEPERATOR),	array(',','.'),	$s);
		return floatval($s);
	}
	$cur = &$GLOBALS['CURRENCY'][$curid];
	$s = str_replace(array($cur[2],$cur[3]),array(',','.'),$s);
	$v = floatval($s);
	return $cur[6] ? $v*$cur[0] : $v/$cur[0];
}
function currency_ratetable(&$rtb){//return current exchange rate table
	global $CURRENCY,$ORDER_CURRENCY;
	static $tb=NULL,$c=0;
	if($tb !== NULL){
		$rtb = $tb;
		return $c;
	}
	$tb = array();
	foreach($CURRENCY as $cur){
		$tb[]=array($ORDER_CURRENCY[$c],$cur[0]);
		++$c;
	}
	$rtb = $tb;
	return ($c=strftime(FORMAT_DATETIME,filemtime(PATH_GLOBAL.'currency.php')));
}
function htmlview($path,$file,$style='',$txt='',$return = FALSE){
//debug markeing support
if(strpos($style,'alt="') === FALSE)	@trigger_error('&quot;Alt&quot; should be present in image display',@E_USER_NOTICE);
//debug end
	if ((string)$file=="") $code = $txt;
	else{
		$tag=array('width="0"'=>'','height="0"'=>'','width=0'=>'','height=0'=>'',"width='0'"=>'',"height='0'"=>'','alt=""'=>'','title=""'=>'');
		$style=strtr($style,$tag);
		if(strpos($file,'/>') !== FALSE){
			$code = str_replace('/>',' '.$style.'/>',$file);
		}elseif(strpos($file,'>') !== FALSE){
			$code = str_replace('>',' '.$style.'>',$file);
		}else{
			$f = ($file{4} == ':' || $file{0} == '/' ? $file : $path.$file);
			switch(strtolower(pathinfo($file,PATHINFO_EXTENSION))){
			case 'swf':
			case 'wav':
			case 'mid':
			case 'midi':
			case 'mmf':
			case 'amr':
			case 'wma':
			case 'wmv':
			case 'mp3':
			case 'avi':
				$code = "<embed  src=\"{$f}\" {$style} />";
				break;
			default:
				$code = "<img src=\"{$f}\" $style />";
			}//switch
		}
	}
	if($return) return $code;
	echo $code;
	return ($file !='');
}
function urlrel($rel,$file){
	if(strpos($file,':') !== FALSE || $file{0} == '/'){
		return $file;
	}
	return $rel.$file;
}
function strleft($s,$len,$pad='..',$strip=FALSE){
/*trim vietnamese char $s by $len left */
	if($len < 10 || strlen($s) <= $len) if($strip) return strip_tags($s); else return $s;
	$t=substr(strip_tags($s),0,$len);//remove all HTML tag
	$pos = strrpos($t,' ');
	return substr_replace($t,$pad,$pos+1);
}
switch(@(int)URL_CTRL){//function definition on the fly
case 4:
	include PATH_COMPONENT.'urlrewrite.php';
	break;
case 0:
		function urlBuild($file,$a=NULL,$hint=NULL){
			if($file{0} != '/') $file = URL_BASE.$file;
			$a['title'] = $hint;
			$a['PHPSESSIONIDESNC']=1;
			/*if(!$hint){
				if(isset($a['NWid']) && !@$a['NWname'] || isset($a['PDid']) && !@$a['PDname'])
					trigger_error('Can bo sung NWname la ten cua tin, ten PDname la ten cua san pham trong ham urlBuild');
				if(isset($a['CNid']) && !@$a['CNname']  || isset($a['CPid']) && !@$a['CPname'])
					trigger_error('Can bo sung CNname (ten nhom tin) hoac CPname (ten nhom san pham) trong mang truyen vao ham urlBuild');
			}*/						
			if($a!= NULL ) return $file.'?'.http_build_query($a);
		}
		function urlSet($file,$a){
			if($file{0} != '/') $file = URL_BASE.$file;
			$a['PHPSESSIONIDESNC']=1;
			return $file.'?'.http_build_query($a+$_GET);
		}
	break;
default:
	include PATH_COMPONENT.'urlrewrite.php';
}
function html_check(){
if(strpos(URL_SELF,'js')) return;
?>
<script language="javascript" defer>
var a_href = document.getElementsByTagName('a');
var a_n = a_href.length;
var i;
var s,node;
for(s="",i = 0; i < a_n; ++i){
	if(a_href.item(i).href.indexOf('#') < 0 && a_href.item(i).href.indexOf('mailto:') < 0 && a_href.item(i).href.indexOf('PHPSESSIONIDESNC') < 0){
		s += a_href.item(i).href + "<br/>";
	}
}
if(s != ""){
	node=document.createElement('strong');
	node.innerHTML="please use urlBuild to build href for following links: <br/>" + s;
	document.body.appendChild(node);
}
a_href = document.getElementsByTagName('img');
a_n = a_href.length;
for(s="",i = 0; i < a_n; ++i){
	if(a_href.item(i).lang !="en"){
		s += a_href.item(i).src + "<br/>";
	}
}
a_href = document.getElementsByTagName('input');
a_n = a_href.length;
for(s="",i = 0; i < a_n; ++i){
	if(a_href.item(i).type == 'text' && a_href.item(i).className.indexOf("input") < 0){
		s += a_href.item(i).name + "<br/>";
	}
}
if(s != ""){
	node=document.createElement('strong');
	node.innerHTML="please use class input and 1 subclass to display input for following input: <br/>" + s;
	document.body.appendChild(node);
}
a_href = document.getElementsByTagName('b');
a_n = a_href.length;
for(s=0,i = 0; i < a_n; ++i){
	if(a_href.item(i).innerText == 'Notice'){
		++s;
	}
}
if(s > 0){
	node=document.createElement('strong');
	node.innerHTML="Notice:" + s;
	document.body.appendChild(node);
}

</script>
<?php	
}
function _trace(){}
_trace('==='.strftime(FORMAT_DATETIME).' '.$_SERVER['REQUEST_METHOD'].'==='.URL_SELF.'?'.@$_SERVER['QUERY_STRING'].'====');
?>