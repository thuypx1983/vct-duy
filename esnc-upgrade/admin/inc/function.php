<?php
function file_post_contents(&$file,$local,$age,$timeout,&$form,$allowtag=NULL){
/* get remote file content, support multiple destination
$file: array of array(url,$ip)
local: local file for replace
$age: maximum age of local file
$timeout: timeout socket
$allowtag: similar to strip_tags function, if $allowtag==NULL, all tag are allowed
*/

	if($age > 0 && time() - @filemtime($local) <= $age) return file_get_contents($local);
	$data = http_build_query($form);
	$stdHeader="Accept: */*\r\nReferer: ";
	$c = array('http'=>array('method'=>'POST','max_redirects'=>2,'content'=>$data));
	ini_set('default_socket_timeout',$timeout);
	foreach($file as $ip=>$host_url_refer){
		$c['http']['header']=$stdHeader.$host_url_refer[2];
		$context = stream_context_create($c);
		if($t = @file_get_contents($host_url_refer[0],FALSE,$context)){
			ini_restore('default_socket_timeout');
			if($allowtag==NULL || $allowtag=='*'){
				@file_put_contents($local,$t);//cache for next use
				return $t;
			}
			else{ 
				$d = new DOMDocument;
				@$d->loadHTML(strip_tags($t,$allowtag));
				$d->normalize();
				@$d->save($local);
				return $d->saveXML();
			}
		}
		unset($context);
	}
	ini_restore('default_socket_timeout');
	return FALSE;
}
function file_load_contents(&$file,$local,$age,$timeout,$allowtag=NULL){
/* get remote file content, support multiple destination
$file: array of array(url,$ip)
local: local file for replace
$age: maximum age of local file
$timeout: timeout socket
$allowtag: similar to strip_tags function, if $allowtag==NULL, all tag are allowed
*/
	if($age > 0 && time() - @filemtime($local) <= $age) return @file_get_contents($local);
	$timeout = ini_set('default_socket_timeout',$timeout);
	foreach($file as $ip=>$url){
		if($t = @file_get_contents($url[0])){
			ini_restore('default_socket_timeout');
			if($allowtag==NULL || $allowtag=='*'){
				@file_put_contents($local,$t);//cache for next use
				return $t;
			}
			else{ 
				$d = new DOMDocument;
				@$d->loadHTML(strip_tags($t,$allowtag));
				$d->normalize();
				@$d->save($local);
				return $d->saveXML();
			}
		}
	}
	ini_restore('default_socket_timeout');	
	return FALSE;
}
function foldersize($d){
/* foldersize: get foldersize:
set global variables to store returned value
$n_file: number of file
$n_folder: number of sub folders
$max_filesize: maximum file size
$name_maxfilesize: name of the file with maximum size
maximum 100000 subfolders+ files can be processed

return: size (in B) of folder
*/
	global $n_file,$n_folder,$max_filesize,$name_maxfilesize;
	$size=0;
	$rs = glob($d.'/*.*',GLOB_NOSORT);
	foreach($rs as $f){
		$size += ($t = filesize($f));//get all filesize;
		++$n_file;
		if($max_filesize < $t){
			$max_filesize = $t;
			$name_maxfilesize = $f;
		}
	}
	$rs = glob($d.'/*',GLOB_ONLYDIR|GLOB_NOSORT);//get all directory;
	foreach($rs as $f)
		if($f != $d.'/..' && $f != $d.'/.' && $n_folder < 10000 && $n_file < 100000){//maximum 100000 folder can be processed
			++$n_folder;
			$size += foldersize($f);
		}
	return $size;
}
function zipFile($file,$zipFile,$cmd='zip -X -r'){
/* this zip a file
$file: file to zip
$zipFile: target file
$param: additional argument pass to zip program, like standard zip progam
*/
	ob_start();
	exec($cmd.'  '.$zipFile.' '.$file);
	ob_end_clean();
	return is_file($zipFile);
}
function save_ini_file($filename,&$a){
	rename($filename,PATH_TEMP.time().'~'.basename($filename));
	$fp=fopen($filename,'w');
	fwrite($fp,';created by save_ini_file ESNC.Net ini engine '.strftime(FORMAT_DATETIME).'===');
	foreach($a as $sec=>$section){
		if($sec !== ''){
			if(is_array($section)){
				fwrite($fp,"\r\n[{$sec}]");
				foreach($section as $key=>$value) if($key !== '') fwrite($fp,"\r\n{$key}=\"{$value}\"");
			}else
				fwrite($fp,"\r\n{$sec}=\"{$section}\"");
		}
	}
	fclose($fp);
}

?>