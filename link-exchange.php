<?php
require './config.php';
require PATH_INC.'commonguest.php';
require PATH_CLASS.'cache.php';
require_once(PATH_COMPLS.'rewrite.php');
require_once(PATH_COMPLS.'esnc_aform.php');
cache::start();
require PATH_CLASS.'esnc.php' ;
require PATH_INC.'dbconguest.php';
require 'linkexchange.php';
require_once(PATH_COMPLS.'news.php');
require_once(PATH_COMPLS.'product.php');
require_once(PATH_COMPLS.'bannerlist.php');
require_once('function-add.php');
$act= @$_GET['act'];
$BNpage= @(int)$_POST['BNpage'];
switch($act){
case 'add': 
	if(@$_POST['CBid']){
		$o_cat=catlinkexchangeopen($_POST['CBid']); 
		$CBname=$o_cat->name;
		if(!checkSubmit()) {redirect('message.php?act=spam'); }
		else{
		include(PATH_CLASS.'banner.php');
		include(PATH_INC.'function.php');
		class linker extends bannerlink{
			function add(){
				$this->a_cat= $_POST['CBid'];
				$this->ctrl= BANNER_CTRL_LINK;
				$this->type= 2;
				return $this->addoverwrite();
			}
		}
		$bn= new linker();
		$bn->url= $_POST['BNurl'];
		$bn->name= $_POST['BNname'];
		$bn->desc= $_POST['BNdesc'];
		$bn->mybanner= $_POST['BNmybanner'];
		$bn->email= $_POST['BNemail'];
		$bn->detail= $_POST['BNemail'];
		if ($bn->checker()=== false){
			redirect('message.php?act=nolinkback');
			return;
		}
		if(!$bn->isduplicated()){
			$page= $bn->lookup();
			$location= URL_BASE.'link-exchange.php?CBid='.$_POST['CBid'].($page>1 ?"&BNpage=".$page:'');
			$location= '<a href="'.$location.'">'.$location.'</a>';
			$tag= array(
            '{{BANNER_NAME}}','{{BANNER_URL}}','{{BANNER_DESC}}','{{BANNER_CATEGORY}}','{{BANNER_BACKLINK}}','{{BANNER_LOCATION}}','{{BANNER_REMOVE}}'
			); 
			$tagvalue= array(
            $bn->name,'<a href="'.$bn->url.'">'.$bn->url.'</a>',$bn->desc,$CBname,'<a href="'.$bn->mybanner.'">'.$bn->mybanner.'</a>',$location,'<a _base_href="'.URL_BASE.'" href="'.URL_ADMIN.'sys/flash-action.php?act=rmlinkex&BNid='.$bn->id.'">Remove Link</a>'
			);
			include(PATH_CLASS.'mailer.php');
			include(PATH_COMPLS.'user.php');
			$mr= new mailer(PATH_APPLICATION.'email_addlinknotify.htm', $tag, $tagvalue);
			$mr->sender= EMAIL_WEBMASTER;
			$rs= userlist(USER_ALERT_LINK);		
			$mr->recipient= $_POST['BNemail'];
			while($row= mysql_fetch_assoc($rs)){
				$mr->recipient.= ','.$row['email']; 
			}
			mysql_free_result($rs); 
			$mr->send();
			unset($mr);
			redirect('message.php?act=thanklinkex');
		}
		else if($bn->isduplicated()){
			redirect('message.php?act=duplicatelinkex');
		}
		}
	}else {
		redirect('message.php?act=errorlinkex');
	}
	break;
}
esnc::process(PATH_TEMPLATES.'link-exchange.htm',PATH_ESNC.'link-exchange.php');
require PATH_ESNC.'link-exchange.php';
dbclose();
cache::finish(TRUE);
?>