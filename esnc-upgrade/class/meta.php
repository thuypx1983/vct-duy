<?php
class meta{
	var $path,$title,$base,$m;
	function read(){
		if($ss = fileread($this->path)){
			$this->m=array();
			$s=strip_tags($ss,'<title><base><meta>');
			$t=strip_tags($s,'<title>');
			if(preg_match('/\>([^\<]+)\</m',$t,$a)) $this->title=$a[1];
			$t=strip_tags($s,'<meta>');
			if(preg_match_all('/<meta\s+([a-zA-Z\-]+)\=\"([^\"]+)\"\s+([a-zA-Z\-]+)\=\"([^\"]+)\"/m',$t,$a,PREG_SET_ORDER)){
				foreach($a as $v){
					if($v[1] == 'content'){
						$this->m[strtolower($v[4])]=$v[2];
					}else{
						$this->m[strtolower($v[2])]=$v[4];
					}
				}
			}
			$t=strip_tags($s,'<base>');
			if(preg_match('/<base href=\"([^\"]+)\"/i',$t,$a)) $this->base=$a[1];
		}
	}
	function save(){
		$s = '';
		if($this->base) $s .= '<base HREF="'.$this->base.'" />';
		if($this->title) $s .= '<title>'.$this->title.'</title>';		
		if(is_array($this->m)){
			foreach($this->m as $name=>$content){
				switch($name){
				case 'content-type':
				case 'expires':
				case 'refresh':
					$s .= '<meta http-equiv="'.$name.'" content="'.$content.'" />';
					break;
				default:
					$s .= '<meta name="'.$name.'" content="'.$content.'" />';
				}
			}
		}
		filesave($this->path,$s);
	}
}
?>