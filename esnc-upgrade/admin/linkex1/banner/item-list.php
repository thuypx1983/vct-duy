<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_BANNER)){
        echo "<script language='javascript'>window.top.location='".URL_ROOT."'</script>";
        exit();
}
?>
<?php 
require '../config.php';
require("../inc/dbcon.php");
require('../admincompls/itemlist.php');
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','50%');
define('COL2_NAME','T&ecirc;n');

define('COL3_WIDTH','15%');
define('COL3_NAME','Ng&agrave;y t&#7841;o');

define('COL4_WIDTH','40%');
define('COL4_NAME','url');

define('COL5_WIDTH','7%');
define('COL5_NAME','Th&#7913; t&#7921;');

define('COL6_NAME','&#272;&#7863;c t&iacute;nh');

define('CATALIAS','CB');
define('ALIAS','BN');

class bannerlist extends itemlist{
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
			if(isset($_GET['status'])) $this->status = (int)$_GET['status'];
			else $this->status=NULL;			
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->nctrl = (int)$_GET['nctrl'];			
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
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->sortby = (int)$_GET[ALIAS.'sortby'];
		if(is_array($_GET[ALIAS.'ctrl'])) $this->ctrl = $_GET[ALIAS.'ctrl']=(int)@array_sum($_GET[ALIAS.'ctrl']);
		else $this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];
		$search='';
		if($q = mysql_real_escape_string($_GET['q'])){
			$search .= " AND (`name` LIKE '%{$q}%' OR `url` LIKE '%{$q}%' OR `desc` LIKE '%{$q}%')";
		}elseif(($id = (int)$_GET[ALIAS.'id']) > 0){
			$search = ' AND `tb`.`id`='.$id;
		}
		$date1 = mysql_format_date($_GET[ALIAS.'created1']);
		$date2 = mysql_format_date($_GET[ALIAS.'created2']);
		if(strpos($date1,'0000') === FALSE && strpos($date2,'0000') === FALSE){
			$search .=' AND (`tb`.`created` BETWEEN \''.$date1.' 00:00:00\' AND \''.$date2.' 23:59:59\')';
		}elseif(strpos($date1,'0000') === FALSE){
			$search .= ' AND (`tb`.`created` >= \''.$date1.' 00:00:00\')';
		}elseif(strpos($date2,'0000') === FALSE){
			$search .= ' AND (`tb`.`created` <= \''.$date2.' 23:59:59\')';
		}
		if(is_array($_GET[ALIAS.'status'])) $this->status = $_GET[ALIAS.'status'] = implode(',',$_GET[ALIAS.'status']);
		$this->open("`tb`.`id`,`tb`.`name`,DATE_FORMAT(`tb`.`created`,'".FORMAT_DATE."') as `created`,IF(`tb`.`url` IS NOT NULL AND `tb`.`url` <> '',`tb`.`url`,`tb`.`desc`),`tb`.`view`,`tb`.`ctrl`,`tb`.`status`",substr($search,4));
		include PATH_ADMIN_FORM.'item-list-banner.php';
		exit();
	}
}
$o = new bannerlist;
$o->doctitle='Danh s&aacute;ch li&ecirc;n k&#7871;t';
$o->table='banner';
$o->type = TABLE_BANNER;
$o->alias = 'BN';
$o->catalias = 'CB';
$o->a_ctrl = &$BANNER_CTRL;
$o->a_status = &$BANNER_STATUS;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
?>
