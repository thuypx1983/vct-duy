<?php 
require('../nonsign.php');
class news{
	var $id,$name,$tag,$content,$summary,$view,$ctrl,$creator,$created,$keyword,$img1,$alt1,$img2,$alt2;

	function fetch(){
		$this->id=(int)$_GET['id'];
		$this->name=(string)$_POST['name'];
		$this->tag=(string)$_POST['tag'];
		$this->content=(string)$_POST['content'];
		$this->summary=(string)$_POST['summary'];
		$this->view=(int)$_POST['view'];
		$this->ctrl=(int)@array_sum($_POST['ctrl']);
		$this->creator=(string)$_POST['creator'];
		$this->created=(string)$_POST['created'];
		$this->keyword=(string)$_POST['keyword'];
		$this->img1=(string)$_POST['img1'];
		$this->alt1=(string)$_POST['alt1'];
		$this->img2=(string)$_POST['img2'];
		$this->alt2=(string)$_POST['alt2'];
		$this->catnewsid = $_POST['catnewsid'];
		$this->urlrewrite=(string)$_POST['urlrewrite'];
		if($_POST['rte_tag_summary']) RTE::normalizeHTML($this->summary);
		if($_POST['rte_tag_content']) RTE::normalizeHTML($this->content) ;
		if($this->created == $_POST['lastcreated']) $this->created==NULL;//keep last updated
	}
	function addrow(){
		if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
		global $sql;
		$this->created = mysql_format_datetime($this->created);
		$sql='INSERT INTO `'.DB_TABLE_PREFIX.'news`(`name`,`tag`,`content`,`summary`,`view`,`ctrl`,`creator`,`created`,`keyword`,`img1`,`alt1`,`img2`,`alt2`,`urlrewrite`,`catnewsid`) VALUES ('
		." '".mysql_real_escape_string(stripslashes($this->name))."'"
		.",'".mysql_real_escape_string(stripslashes($this->tag))."'"
		.",'".mysql_real_escape_string(stripslashes($this->content))."'"
		.",'".mysql_real_escape_string(stripslashes($this->summary))."'"
		.",'".(int)$this->view."'"
		.",'".(int)$this->ctrl."'"
		.",'".mysql_real_escape_string(stripslashes($this->creator))."'"
		.(strpos($this->created,'0000') === FALSE ? ",'".$this->created."'":','.SQL_NOW)
		.",'".mysql_real_escape_string(stripslashes($this->keyword))."'"
		.",'".mysql_real_escape_string(stripslashes($this->img1))."'"
		.",'".mysql_real_escape_string(stripslashes($this->alt1))."'"
		.",'".mysql_real_escape_string(stripslashes($this->img2))."'"
		.",'".mysql_real_escape_string(stripslashes($this->alt2))."'"
		.",'".mysql_real_escape_string(stripslashes($this->urlrewrite))."'"
		.','.($this->catnewsid ? (int)$this->catnewsid:'NULL')		
		.')';
		_trace($sql);
		if(mysql_query($sql)){
			$this->id = mysql_insert_id();
			if(is_writable(PATH_NEWS_CONTENT) && $this->content != ''){
				define('NEWS_CONTENT',PATH_NEWS_CONTENT.'news-'.$this->id.'.htm');
				@chmod(NEWS_CONTENT,0777);//make writable
				@unlink(NEWS_CONTENT);
				@file_put_contents(NEWS_CONTENT,$this->content);
				@chmod(NEWS_CONTENT,0500);//make read-only
			}
			return TRUE;
		}
	}
	function updaterow(){
	if(trim($this->urlrewrite)=='' || trim($this->urlrewrite)==NULL ) $this->urlrewrite=$this->name;
		$this->urlrewrite= trim($this->urlrewrite);
		$this->urlrewrite=nonsign($this->urlrewrite);
		global $sql;
		settype($this->id,'int');
		if($this->created == '') $created=',`Created`='.SQL_NOW;//empty datetime, set to now()
		else{
			$this->created = mysql_format_datetime($this->created);
			if(strpos($this->created,'0000') === FALSE) $created = ",`Created`='".$this->created."'";//valid datetime set
			else $created = '';//not update
		}
		$sql = "UPDATE `".DB_TABLE_PREFIX."news` SET"
		." `Name`='".mysql_real_escape_string(stripslashes($this->name))."'"
		.",`Tag`='".mysql_real_escape_string(stripslashes($this->tag))."'"
		.",`Content`='".mysql_real_escape_string(stripslashes($this->content))."'"
		.",`Summary`='".mysql_real_escape_string(stripslashes($this->summary))."'"
		.",`View`='".(int)$this->view."'"
		.",`Ctrl`='".(int)$this->ctrl."'"
		.",`Creator`='".mysql_real_escape_string(stripslashes($this->creator))."'"
		.$created
		.",`KeyWord`='".mysql_real_escape_string(stripslashes($this->keyword))."'"
		.",`Img1`='".mysql_real_escape_string(stripslashes($this->img1))."'"
		.",`Alt1`='".mysql_real_escape_string(stripslashes($this->alt1))."'"
		.",`Img2`='".mysql_real_escape_string(stripslashes($this->img2))."'"
		.",`Alt2`='".mysql_real_escape_string(stripslashes($this->alt2))."'"
		.",`Urlrewrite`='".mysql_real_escape_string(stripslashes($this->urlrewrite))."'"
		.",`CatNewsID`=".($this->catnewsid ? (int)$this->catnewsid:'NULL')
		." WHERE `id` = {$this->id}";
		if(mysql_query($sql)) return TRUE;
		_trace(mysql_error());
		_trace($sql);
		
	}
	function loadonerow(){
	
		global $sql;
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `tag`, `content`, `summary`, `view`, `ctrl`, `creator`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`, `keyword`, `img1`, `alt1`, `img2`, `alt2`, `urlrewrite` FROM `".DB_TABLE_PREFIX."news` WHERE `id` = {$this->id}";
		$row=mysql_fetch_assoc($rs=mysql_query($sql));
		$this->name = (string)$row['name'];
		$this->tag = (string)$row['tag'];
		$this->content = (string)$row['content'];
		$this->summary = (string)$row['summary'];
		$this->view = (int)$row['view'];
		$this->ctrl = (int)$row['ctrl'];
		$this->creator = (string)$row['creator'];
		$this->created = (string)$row['created'];
		$this->keyword = (string)$row['keyword'];
		$this->img1 = (string)$row['img1'];
		$this->alt1 = (string)$row['alt1'];
		$this->img2 = (string)$row['img2'];
		$this->alt2 = (string)$row['alt2'];
		$this->urlrewrite = (string)$row['urlrewrite'];
		
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		settype($this->id,'int');
		$sql = "SELECT `id`, `name`, `tag`, `content`, `summary`, `view`, `ctrl`, `creator`,DATE_FORMAT(`created`,'".FORMAT_DB_DATETIME."') as `created`, `keyword`, `img1`, `alt1`, `img2`, `alt2`, `urlrewrite` FROM `".DB_TABLE_PREFIX."news` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
}
?>
