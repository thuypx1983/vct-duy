<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	exit('<script type="text/javascript">window.top.location.href="../../"</script>');
}
require '../config.php';
require("../inc/dbcon.php");
require(PATH_ADMINCOMPLS.'itemlist.php');
require PATH_CLASS.'tool.php';
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');
define('COL1_NAME','ID');

define('COL2_WIDTH','45%');
define('COL2_NAME','T&ecirc;n');

define('COL3_WIDTH','22%');
define('COL3_NAME','L&#7847;n ch&#7841;y g&#7847;n &#273;&acirc;y');

define('COL4_WIDTH','35%');
define('COL4_NAME','H&agrave;nh &#273;&#7897;ng');

define('COL5_WIDTH','40');
define('COL5_NAME','Th&#7913; t&#7921;');

define('COL6_NAME','&#272;&#7863;c t&iacute;nh');

define('CATALIAS','');
define('ALIAS','TL');

class mylist extends itemflatlist{
	function show(){
		global $session;
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->sortby = (int)$_GET[ALIAS.'sortby'];
		if($this->sortby == '') $this->sortby = SORTBY_ID_DESC;
		$this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];
		$this->open('`tb`.`id`,`tb`.`file`,`tb`.`name`,DATE_FORMAT(`tb`.`lastrun`,\''.FORMAT_DB_DATETIME.'\') as `lastrun`,`tb`.`run`,`tb`.`ctrl`,`tb`.`view`,`tb`.`access`');
		$this->a_tools=array();
		while($row=mysql_fetch_assoc($this->rs)){
			$this->a_tools[$row['file']]=$row;
		}
		mysql_free_result($this->rs);
		$this->rs=&$this->a_tools;
		$this->getAvailableTool();
		include PATH_ADMIN_FORM.'item-list-tool.php';
	}
	function getAvailableTool(){
		$cd = getcwd();
		if(is_dir(PATH_COMPONENT.'tool') && chdir(PATH_COMPONENT.'tool')) 	$this->tools=glob('*.php'); else $this->tools=array();
		chdir(dirname(__FILE__));
		$this->sysTools=glob('sys*.php');
		$this->tools = array_merge($this->tools,$this->sysTools);
		unset($this->sysTools);
		chdir($cd);
	}
}

$o = new mylist;
$o->doctitle='C&ocirc;ng c&#7909;, d&agrave;nh cho l&#7853;p tr&igrave;nh vi&ecirc;n';
$o->table='tool';
$o->type = TABLE_TOOL;
$o->alias = 'TL';
$o->a_ctrl = &$TOOL_CTRL;

switch($act){
	case ACT_REMOVE:				
		$o->id = (string)$_GET['id'];
		$o->del();				
		redirect(URL_SELF);
		break;
	case ACT_REORDER:
		$o->idvalue=(string)$_GET['idvalue'];
		echo $o->reorder() ? "parent.banner.setStatus('Thay &#273;&#7893;i th&agrave;nh c&ocirc;ng');":"parent.banner.setStatus('L&#7895;i khi thay &#273;&#7893;i');self.document.reload();";
		break;
	default: $o->show();	
}
dbclose();
?>