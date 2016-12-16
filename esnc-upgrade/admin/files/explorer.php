<?php 
require '../../config.php';
require '../config.php';
require PATH_ADMIN.'inc/common.php';
require PATH_ADMIN.'inc/session.php';
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	exit("<script language='javascript'>window.top.location='../../';</script>");
}
unset($FILE_ALLOW_EDIT_PATH[0],$FILE_ALLOW_EDIT_PATH[1],$FILE_ALLOW_EDIT_PATH[2]);
class Explorer{
	var $FLid;//current ROOT folder id
	var $FLpath;
	var $FLurl;
	var $url;
	var $path;
	var $FLsubFolder;//sub folder id
	var $extid;//==-1: list all supported file type
	var $viewtype;//0: detail view, 1:thumbnail view,2:list view
	var $page,$pagesize,$pagecount;
	var $rs;
	function __construct($id,$sub){
		global $FILE_ALLOW_EDIT_PATH,$FILE_ALLOW_EDIT_TYPE,$FILE_ALLOW_EDIT_URL;

		$this->FLid = (int)$id;
		if($this->FLid==3 || $this->FLid==4 || $this->FLid == -1) $this->newSubFolder=TRUE;else $this->newSubFolder=FALSE;//only enable FLsubFolder for PATH_GALLERY
		$this->FLsubFolder = trim($sub,'/');
		if(!preg_match('/^[\w\-\/]*$/',$this->FLsubFolder)) $this->FLsubFolder='';
		if(!$this->FLpath=$FILE_ALLOW_EDIT_PATH[$this->FLid]) return FALSE;
		$this->FLurl=$FILE_ALLOW_EDIT_URL[$this->FLid];
		$this->path=rtrim($this->FLpath.$this->FLsubFolder,'/').'/';
		$this->url=rtrim($this->FLurl.$this->FLsubFolder,'/').'/';
	}
	function show($search=''){//scanning directory
		global $FILE_ALLOW_EDIT_PATH,$FILE_ALLOW_EDIT_TYPE,$FILE_ALLOW_EDIT_URL,$ESNC_ROWCOUNT,$ESNC_ROWSTART,$ESNC_ROWEND;

		if(!$search) $search='*';
		else{
			$search=preg_replace('/[^\w\-\*\?]/','',$search);
			$_GET['q']=$search;
			if(strpos('?',$search) === FALSE && strpos('*',$search) === FALSE) $search = '*'.$search.'*';
		}
		if($this->extid==-1)
			$pattern = $search.'.{'.trim(strtr(FILE_ALLOW_UPLOAD_TYPE,'|',','),',').'}';
		else
			$pattern = $search.'.'.$FILE_ALLOW_EDIT_TYPE[$this->extid];
		if($this->page < 1) $this->page =1;
		if($this->pagesize < 15) $this->pagesize=20;
		$cwd = getcwd();
		if(!@chdir($this->path)){
			chdir($this->path=$this->FLpath);
			$this->FLsubFolder='';
			$_GET['FLsubFolder']='';
		}
		$this->FLparent = dirname($this->FLsubFolder);
		if($this->FLparent{0} == '.') $this->FLparent='/';
		$this->rsFolder = glob('*',GLOB_ONLYDIR);//load only directory first
		$this->rs = glob($pattern,GLOB_BRACE);
		chdir($cwd);
		$ESNC_ROWCOUNT=count($this->rs);
		$this->pagecount = (int)ceil(@($ESNC_ROWCOUNT/$this->pagesize));
		$ESNC_ROWSTART=($this->page-1) * $this->pagesize + 1;
		$ESNC_ROWEND=min($ESNC_ROWCOUNT,$ESNC_ROWSTART+$this->pagesize);
		include PATH_ADMIN_FORM.'explorer.php';
		exit();
	}
	function ren($name){

		if(!preg_match(REGEX_CHECK_FILENAME,$this->id)){
			_trace('filename not valid'.$this->id);
			return FALSE;
		}
		$t = fileperms($v=$this->path.$this->id);
		$ext = pathinfo($this->id,PATHINFO_EXTENSION);
		$name = preg_replace(array(REGEX_NORMAL_FILENAME,'/\.[^\.]+$/'),array('_',''),$name);
		@chmod($v,0755);
		$ret = @rename($v,$newname=$this->path.$name.'.'.$ext);
		@chmod($newname,$t);//reset last mod
		return $ret;
	}
	function moveto(){
	}
	function copyto(){
	}
	function remove(){

		$t=explode(',',$this->id);
		foreach($t as $id){
			if(preg_match(REGEX_CHECK_FILENAME,$id)){
				$r = $this->path.$id;
				chmod($r,0777);//make writeable before
				if(is_dir($r)){
					_trace('rmdir:'.$r);
					rmdir($r);
				}else{
					_trace('unlink:'.$r);
					unlink($r);
				}
			}
		}
		return TRUE;
	}
	function add($name){//create folder
		if($this->newSubFolder){
			if(chdir($this->path) && preg_match('/^[\w\-]+$/',$name)) 
				return @mkdir($name) && @chmod($name,0755);
		}
	}
}
if($o = new Explorer($_GET['FLid'],$_GET['FLsubFolder'])){
	if(isset($_GET['FFextid']))
		$o->extid = (int)$_GET['FFextid'];
	else
		$o->extid=-1;
	switch($act){
	case ACT_ADD:
		$o->add($_POST['newSubFolder']);
		redirect(URL_SELF.'?'.urlmodify('act',NULL));
		break;
	case ACT_RENAME:
		$o->id=$_GET['id'];
		$o->ren($_GET['newname']);
		redirect(URL_SELF.'?'.urlmodify('act',NULL,'newname',NULL,'id',NULL));
		break;
	case ACT_REMOVE:
		$o->id=$_GET['id'];
		$o->remove();
		redirect(URL_SELF.'?'.urlmodify('act',NULL,'id',NULL));
		break;
	default:
		$o->pagesize=(int)$_GET['pagesize'];
		$o->page = (int)$_GET['page'];
		$o->show($_GET['q']);
	}
}else{
	echo 'Wrong path';
}
?>