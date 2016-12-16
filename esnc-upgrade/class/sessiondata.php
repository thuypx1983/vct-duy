<?php
class sessiondata{
	function put(&$o,$name){
		if(is_scalar($o))
			trigger_error('N&#7871;u mu&#7889;n ghi m&#7897;t bi&#7871;n &#273;&#417;n gi&#7843;n (s&#7889;, x&acirc;u k&yacute; t&#7921;) v&agrave;o Session, ch&#7881; c&#7847;n d&ugrave;ng $_SESSION[\''.$name.'\']=, kh&ocirc;ng c&#7847;n d&ugrave;ng sessiondata::put.<br />Ch&#7881; n&ecirc;n d&ugrave;ng khi c&#7847;n l&#432;u m&#7897;t m&#7843;ng ho&#7863;c m&#7897;t &#273;&#7889;i t&#432;&#7907;ng v&agrave;o session',E_USER_NOTICE);
		$_SESSION[$name]=serialize($o);
	}
	function get(&$o,$name){
		return (bool)($o =  unserialize(@$_SESSION[$name]));
	}
}
?>