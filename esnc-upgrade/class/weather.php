<?php
//tienpd@esnadvanced.com
class weather{
	var $path_weather_file;
	function show(){
		readfile($this->path_weather_file);	
	}	
}
?>