<?php class document{//save document to url and return
	var $FLid,$FLsubFolder,$name,$extension,$path;
	function save(){
		global $FILE_ALLOW_EDIT_PATH;
		if($this->path=$FILE_ALLOW_EDIT_PATH[$this->FLid]){
			$this->FLsubFolder = trim($this->FLsubFolder,'/');
			if($this->FLsubFolder) $this->path .= $this->FLsubFolder.'/';	
			_trace($this->path);			
			_trace($_FILES);
			if(is_uploaded_file($_FILES['userfile']['tmp_name'])){	
				$pathparts = pathinfo($_FILES['userfile']['name']);
				$this->name = preg_replace(REGEX_NORMAL_FILENAME,'_',$pathparts['basename']);//normalize orininal filename
				$this->extension = strtolower($pathparts['extension']);
				$this->name = str_replace('.'.$pathparts['extension'],'.'.$this->extension,$this->name);//force to lowercase extension
				if(strpos((string)FILE_ALLOW_UPLOAD_TYPE,"|{$this->extension}|") !== FALSE){//check weather allow to upload					
					if(is_file($this->path.$this->name)) $this->name = getuniquename() .'_'.$this->name;//auto prepend unique name
					if(move_uploaded_file($_FILES['userfile']['tmp_name'],$this->path.$this->name)){
						chmod($this->path.$this->name,0744);
						return TRUE;
					}
				}
			}
		}
		$this->name = NULL;
		return FALSE;
	}
}
?>
