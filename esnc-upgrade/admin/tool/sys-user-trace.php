<?php
class Sys_User_Trace extends Tool{
	var $rs;
	function remove(){
		unlink(PATH_GLOBAL.'db_log.sqlite');
		parent::cleanup();
		include_once PATH_ADMINCOMPLS.'app_config.php';
		include_once PATH_ADMIN.'inc/function.php';
		app_config_remove('DB_LOG');
		showloadscreen(URL_UP,5,'Tool uninstalled');
	}
	function about(){
		include PATH_ADMIN_FORM.'user-trace-about.php';
	}
	function setup(){
		switch($this->act){
		case ACT_SAVE:
			if($_POST['accept']){
				try{
					$db = new PDO('sqlite:'.PATH_GLOBAL.'db_log.sqlite',0666);
					include_once PATH_ADMINCOMPLS.'app_config.php';
					include_once PATH_ADMIN.'inc/function.php';
					app_config_add('DB_LOG',array('name'=>'B&#7853;t t&iacute;nh n&#259;ng user-trace','type'=>'checkbox','default'=>'sqlite:'.PATH_GLOBAL.'db_log.sqlite'));
					$db->exec('CREATE TABLE log(
id bigint unsigned auto_increment primary key,
ip varchar(20),
url varchar(1024),
ua varchar(255),
refer varchar(1024),
tm datetime,
q varchar(1024)
)'
					);	
				}catch(Exception $EE){
					echo 'Failed create logging database';
					return;
				}
				$this->name='User - tracing';
				$this->ctrl |= 1;
				$this->access=ACCESS_DEVELOPPER;
				$this->data=serialize($_POST['cfg']);
				$this->save();
				redirect($this->makeUrl(NULL));
			}else{
				redirect(URL_UP);
			}
		case ACT_DOWNLOAD:
			$compressed_file=strftime('%Y%m%d%H%M%S').'db_log.zip';
			$org_file=str_replace('sqlite:','',DB_LOG);
			$zipcmd='zip -j -X  '.PATH_TEMP.$compressed_file.' '.$org_file;
			exec($zipcmd);
//			echo $zipcmd;exit();
			if(!is_file(PATH_TEMP.$compressed_file)){ $compressed_file=strftime('%Y%m%d%H%M%S').basename($org_file); copy($org_file,PATH_TEMP.$compressed_file); }
			header('Content-Type:application/octet-stream',TRUE);
			header('Content-Disposition:attachment;filename="'.$compressed_file.'"');
			header('Content-Length:'.filesize(PATH_TEMP.$compressed_file));
			readfile(PATH_TEMP.$compressed_file);
			exit();
		case ACT_REMOVE://purging database
			$sql = 'DELETE FROM log WHERE tm > CURRENT_TIME -7 *3600*24';
			try{$db = new PDO(DB_LOG,0777);
			$db->exec($sql);
			}catch(Exception $EE){}
			redirect($this->makeUrl(0));
			exit();
		default:
			$this->cfg=unserialize($this->data);
			include PATH_ADMIN_FORM.'user-trace-setup.php';
		}
	}
	function init(){
		$this->cfg=unserialize($this->data);
	}
	function run(){
		global $sql;
		$this->init();
		$db = new PDO(DB_LOG,0666);
		$sql = 'SELECT ip,url,ua,refer,tm,q FROM log';
		$wh =' WHERE';
		if($this->ua=(string)$_GET['ua']){
			if($this->ua=='bot'){
				$t = str_replace('|','%\' OR ua LIKE \'%',$this->cfg['BOT']);
				$wh .= ' AND (ua LIKE \'%'.$t.'%\')';
			}else
				$wh .=' AND (ua LIKE '.$db->quote('%'.$this->ua.'%').')';
		}
		if($this->ip=(string)$_GET['ip'] and preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/',$this->ip)){
			$wh .= ' AND (ip=\''.$this->ip.'\')';
		}
		if($this->url=(string)$_GET['url']){
			$wh .= ' AND (url=\''.$this->url.'\')';
		}
		if($this->refer=(string)$_GET['refer']){
			$wh .= ' AND (refer=\''.$this->refer.'\')';
		}
		$this->date1=(string)$_GET['date1'];
		$d1=preg_replace('/(\d{1,2})\D+(\d{1,2})\D+(\d{4}|\d{2})/','$3-$2-$1 00:00:00',$this->date1,$c1);
		$this->date2=(string)$_GET['date2'];
		$d2=preg_replace('/(\d{1,2})\D+(\d{1,2})\D+(\d{4}|\d{2})/','$3-$2-$1 23:59:59',$this->date2,$c2);
		if($c1 && $c2) $wh .= ' AND (tm BETWEEN \''.$d1.'\' AND \''.$d2.'\')';
		elseif($c1) $wh .= ' AND (tm >= \''.$d1.'\')';
		elseif($c2) $wh .= ' AND (tm <= \''.$d2.'\')';
		if($wh == ' WHERE')$wh='';else $wh=str_replace('WHERE AND',' WHERE',$wh);
		$this->page = (int)$_GET['page'];
		if($this->page < 1) $this->page = 1;
		$this->pagesize = (int)$_GET['pagesize'];
		if($this->pagesize > 100 || $this->pagesize < 5) $this->pagesize=$this->cfg['PZ'];
		$this->rowstart=($this->page-1) * $this->pagesize;
		$lm = ' LIMIT '.$this->rowstart.','.$this->pagesize;
		$this->rowend = $this->rowstart++ + $this->pagesize;
		$sql = 'SELECT COUNT(*) FROM log '.$wh;//find how many rows
		$rs = $db->query($sql);
		$row=$rs->fetch(PDO::FETCH_NUM);
		$this->rowcount = (int)$row[0];
		if($this->rowend > $this->rowcount) $this->rowend=$this->rowcount;
		$this->pagecount = ceil($this->rowcount / $this->pagesize);
		$sql = 'SELECT ip,url,refer,ua,tm,q FROM log '.$wh. ' ORDER BY id DESC '. $lm;
		$this->rs = $db->query($sql);
		include PATH_ADMIN_FORM.'user-trace-list.php';
	}//run tool
}
?>