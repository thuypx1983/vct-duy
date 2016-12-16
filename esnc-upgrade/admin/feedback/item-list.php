<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_FEEDBACK)){
        echo "<script language='javascript'>window.top.location='".URL_ROOT."'</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require('../admincompls/itemlist.php');
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','30%');
define('COL2_NAME','Ng&#432;&#7901;i g&#7917;i');

define('COL3_WIDTH','55%');
define('COL3_NAME','Ch&#7911; &#273;&#7873;');

define('COL4_WIDTH','12%');
define('COL4_NAME','Ng&agrave;y th&aacute;ng');

define('COL5_WIDTH','7%');
define('COL5_NAME','Th&#7913; t&#7921;');

define('COL6_NAME','&#272;&#7863;c t&iacute;nh');

define('CATALIAS','CF');
define('ALIAS','FB');

class feedbacklist extends itemlist{
	function process(){
		switch($this->act){
		case ACT_LIST:
		case ACT_OPEN:
		case ACT_SEARCH:
			$this->catid=(int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_DEL:
		case ACT_REMOVE:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
			$this->del();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_MOVE:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
			$this->moveto();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_COPY:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
			$this->copyto();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_SETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->setctrl();
			$this->q = urlchop($this->q,'id');
			$this->catid = (int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_UNSETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->unsetctrl();
			$this->q = urlchop($this->q,'id');
			$this->catid = (int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_RENAME:
			$this->name = (string)$_GET['name'];
			$this->id = (int)$_GET['id'];
			echo ($this->ren() ? "parent.banner.setStatus('&#272;&#7893;i t&ecirc;n th&agrave;nh c&ocirc;ng');" : "parent.banner.setStatus('L&#7895;i khi &#273;&#7893;i t&ecirc;n');input.value=exvalue;");
			exit();
		case ACT_REORDER:
			$this->idvalue = (string)$_GET['idvalue'];
			echo $this->reorder() ? "parent.banner.setStatus('Thay &#273;&#7893;i th&agrave;nh c&ocirc;ng');":"parent.banner.setStatus('L&#7895;i khi thay &#273;&#7893;i');self.document.reload();";
			exit();//not open
		}
	}
	function show(){
		$this->keyword = $_GET[ALIAS.'keyword'];
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->sortby = (int)$_GET[ALIAS.'sortby'];
		$this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];
		$this->open('`tb`.`id`,`tb`.`name`,`tb`.`subject`,DATE_FORMAT(`tb`.`created`,\''.FORMAT_DATE.'\'),`tb`.`view`,`tb`.`ctrl`');
		include('../forms/item-list-feedback.php');
		exit();
	}
}
$o = new feedbacklist;
$o->table='feedback';
$o->type = TABLE_FEEDBACK;
$o->alias = 'FB';
$o->catalias = 'CF';
$o->a_ctrl = &$FEEDBACK_CTRL;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
?>