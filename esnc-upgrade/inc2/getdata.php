<?php
/* function getExchangeRate($code1,$code2){
	$source=array(array('http://www.vietcombank.com.vn/en/Exchange%20Rate.asp'));
	if($text = file_load_contents($source,PATH_TEMP.'vietcombank1.htm',3600,60)){
		$bg=strpos($text,$code1);
		$end=strpos($text,$code2);
		$str=substr($text,$bg, $end - $bg);
		$str=strip_tags($str,"<table>");
		$fields=explode("\n",$str);
		$s='<tr><td class="code">'.$fields[0].'</td><td class="transfer">'.$fields[4].'</td></tr>';
		return $s;
	}
} */
function getExchangeRate(){
	$source=array(array('http://www.vietcombank.com.vn/en/Exchange%20Rate.asp'));
	if($text = file_load_contents($source,PATH_TEMP.'vietcombank1.htm',3600,60)){
		$re1=' /\<font[^\>]+\>([^\<]+)\<br\>/i';
		preg_match_all($re1,$text,$m);
		$rate = $m[1];
		$n = count($rate);
		$a=array();
		for($i=0,$length=0;$i < $n;++$i,++$length){
			$a[]=array('code'=>$rate[$i],'name'=>$rate[++$i],'buy'=>$rate[++$i],'transfer'=>$rate[++$i],'sell'=>$rate[++$i]);
		}
		return $a;
	}
}
function getWeather($a_code){
	$weather=array();
	foreach($a_code as $code=>$name){
		$d = new DOMDocument();
		$a_url=array(array('http://www.wunderground.com/auto/rss_full/global/stations/'.$code.'.xml'));
		$s=file_load_contents($a_url,PATH_TEMP.'weather_'.$code.'.xml',3600,60);
		$d->loadXML($s);
		$desc = $d->getElementsByTagName('description');
		$p1 = '/\s*Temperature\s*\:\s*(\d+)\D+(\d+).+Conditions\s*\:\s*([^\|]+)\|/';
		preg_match($p1,$desc->item(1)->firstChild->nodeValue,$mat);
		$weather[]=array('code'=>$code,'name'=>$name,'tempF'=>$mat[1],'tempC'=>$mat[2],'cond'=>trim($mat[3]));
		unset($d);
	}
	return $weather;
}
?>
