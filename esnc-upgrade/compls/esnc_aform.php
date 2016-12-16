<?php //algorithm 1: reverse order
//algorithm 2: ascii encode
//algorithm 3: ascii encode with increament/decrement
//echo 'v='.rtrim(dirname($_SERVER['SCRIPT_NAME']),'/js').'/';
function reverseorder(){
	global $h;
	echo 'var v=new Array(), i,s;';
	$n = strlen($h)-1;
	for($i = $n;$i >=0;--$i){
		echo 'v['.$i.']='.ord($h{$i}).';';
	}
	echo 'for(s="",i=0;i<'.($n+1).';++i)';
	echo ' s +=String.fromCharCode(v[i]);';
	unset($h);
}
function asciiencode(){
	global $h;
	echo 'var v=new Array(),i,s;';
	$n = strlen($h);
	for($i = 0; $i < $n;++$i)
		echo 'v['.$i.']='.ord($h{$i}).';';
	echo 'for(s="",i=0;i<'.$n.';++i)';
	echo ' s += String.fromCharCode(v[i]);';
	unset($h);
}
function checksubmit(){
	$t = $_COOKIE['scode'];
	@header('Set-Cookie: scode=0; expires='.date('r',100).'; path=/',TRUE);//clear cookie
	if($_SERVER['REQUEST_METHOD'] == 'POST')
		return $_POST['scode'] != ''&& (md5($_POST['scode'])== $t);
	elseif($_SERVER['REQUEST_METHOD'] == 'GET')
		return $_GET['scode'] != '' && (md5($_GET['scode'])== $t);
	return FALSE;
}
function spamKill($msg='Spam detected',$filter=NULL,$section=''){
	$t = $_COOKIE['scode'];
	@header('Set-Cookie: scode=0; expires='.date('r',100).'; path=/',TRUE);//clear cookie
	if(!is_array($filter)){
		if(is_file($filter)){
			$all_filter=parse_ini_file($filter,TRUE);
			if($section) $filter = &$all_filter[$section];//consider only that section
			else $filter = &$all_filter;
		}else $filter=array();
	}
	if($_SERVER['REQUEST_METHOD'] == 'GET') $VAR = &$_GET;
	else $VAR = &$_POST;
	if($VAR['scode'] != '' && (md5($VAR['scode']) == $t)){
		foreach($filter as $key => $re){
			if(is_array(@$all_filter[$re])){
				foreach($all_filter[$re] as $rex) if(preg_match($rex,$VAR[$key])) exit($msg.'<!--'.$key.':'.$rex.'-->');
			}elseif(preg_match($re,$VAR[$key])) exit($msg.'<!--'.$key.':'.$re.'-->');
		}
		return TRUE;
	}
	exit($msg.'<!--scode-->');
}
function initcheck(){
	if($_SERVER['HTTP_USER_AGENT'] == '') return;//no user agent, this considered as spam
	global $h;
	$h = (string)mt_rand();
	if(!setcookie('scode',md5($h),NULL,URL_ROOT)) die('error');
	echo 'function esnc_aform(f){var input = document.createElement("input");input.name="scode";input.type="hidden";';
	if(rand(0,1) == 0) reverseorder();else asciiencode();
	echo 'input.value = s;return f.appendChild(input);}';
}
?>