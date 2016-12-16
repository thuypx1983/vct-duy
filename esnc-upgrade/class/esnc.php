<?php //esnc template engine
class esnc{
	static $x_append=array(),$x_script=array();
	static function postHtmlCode($t){ self::$x_append[]=$t;}
	static function postScriptCode($t){ self::$x_script[]=$t;}
	function process($f,$c){
		include PATH_CLASS.'template-tag.php';
		@chmod($c,0700);//make writable
		file_put_contents($c,preg_replace('/\s*\?\>\s*\<\?php\s*/',';',strtr(file_get_contents($f),$tag)));
		@chmod($c,0500);//make readonly
	}
	function parse($delim,&$s,&$part,&$line,$tag='<tr',$tagend='/tr>'){
		$part = explode($delim,$s);
		if(sizeof($part) == 2){//2 parts
			$tr = strrpos($part[0],$tag);
			$tr2 = strpos($s,$tagend,$tr) + strlen($tagend);
			$line=substr($s, $tr,$tr2-$tr);
			$part[0] = substr($s,0,$tr);//first parts
			$part[1] = substr($s,$tr2);
			return TRUE;
		}
		return FALSE;
	}
	function tr($f,$c,&$tag){
	}
}
$urlrewr='';
if(isset($_GET['url'])) $urlrewr=$_GET['url'];
function metaBuild($id, $name){
	global $urlrewr;
	$rs = mysql_select('`a`.`id`','`#'.$name.'` as `a`',($id==NULL?'`a`.`urlrewrite`="'.$urlrewr.'"':'`a`.`id`='.(int)$id));
	if($row = mysql_fetch_row($rs)){$id=$row['0']; }
	settype($id,'int');
	if($id < 0) return FALSE;
	switch($name){
	case 'product':
		define('METADATA',PATH_PRODUCT_META.'product-'.$id.'.html');
		$field = '`a`.`name`,`a`.`keyword`,`a`.`summary`';
		Esnc::postHtmlCode('<script src="'.URL_ROOT.'js/stat.php?act=prdhit&PDid='.$id.'" defer></script>');
		break;
	case 'news':
		define('METADATA',PATH_NEWS_META.'news-'.$id.'.html');
		$field = '`a`.`name`,`a`.`keyword`,`a`.`summary`';
		Esnc::postHtmlCode('<script src="'.URL_ROOT.'js/stat.php?act=newshit&NWid='.$id.'" defer></script>');
		break;
	case 'utility':
		define('METADATA',@PATH_UTILITY_META.'utility-'.$id.'.html');
		$field = '`a`.`name`,`a`.`keyword`,`a`.`summary`';
		break;
	case 'catutility':
		define('METADATA',@PATH_CATUTILITY_META.'catutility-'.$id.'.html');
		$field = '`a`.`name`,\'\',`a`.`desc`';
		break;
	case 'catproduct':
		define('METADATA',PATH_CATPRODUCT_META.'catproduct-'.$id.'.html');
		$field = '`a`.`name`,\'\',`a`.`desc`';
		break;
	case 'catnews':
		define('METADATA',PATH_CATNEWS_META.'catnews-'.$id.'.html');
		$field = '`a`.`name`,\'\',`a`.`desc`';
		break;
	case 'catbanner':
		define('METADATA',@PATH_CATBANNER_META.'catbanner-'.$id.'.html');
		$field = '`a`.`name`,`a`.`name`,`a`.`desc`';
		break;
	default:
		return FALSE;
	}
	global $title,$keyword,$description;
	$rs = mysql_select($field,'`#'.$name.'` as `a`',($id==NULL?'`a`.`urlrewrite`="'.$urlrewr.'"':'`a`.`id`='.(int)$id));
	
	
	if($row = mysql_fetch_row($rs)){
		if($row[0]) $title = $row[0];
		if($row[1]) $keyword = $row[1];
		if($row[2]) $description = strip_tags($row[2]);
		mysql_free_result($rs);
		return TRUE;
	}
	return FALSE;
}
function footerText(){		
	$sql = 'SELECT `Url`,`Text` FROM `'.DB_TABLE_PREFIX.'footer`';
	_trace($sql);
	$rs = mysql_query($sql);
	while($row = mysql_fetch_assoc($rs)){
		if(URL_CTRL!=0){
			if(strtolower($row['Url'])==strtolower($_SERVER['REQUEST_URI'])){
				echo '<div class="text">'.$row['Text'].'</div>';
			}
		}elseif(URL_CTRL==0){
			if(strtolower($row['Url'])==strtolower(basename(URL_SELF))){
				echo '<div class="text">'.$row['Text'].'</div>';
			}
		}
	}
}

?>
