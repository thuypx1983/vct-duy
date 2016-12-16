<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_USER_NOTICE);
define('ESNC_VERSION','ESNC.Net 1.2/PHP 5.1/Apache 1.3/Linux i686/MySQL4.1');
define('REGEX_CHECK_ID_SERIES','/^(\d+,)*\d+$/');
define('REGEX_CHECK_STRING_SERIES','/^([\w\s\.]+,)*[\w\s\.]+$/');
define('ID_VALUE_SEPERATOR','aa');
define('REGEX_CHECK_FILENAME','/^[^\\/\\\\*\\?\\|\\:\\"\\<\\>]+$/');
define('REGEX_NORMAL_FILENAME','/[^a-zA-Z\\d\\.\\-\\_]+|_{2,}|(?:\\.+(?=[^\\.]*\\.))|(?:\\.+(?=\\.))/');
define('REGEX_HREF','/href\\=([\\\'\\"])([^\\\'\\"]+)\\1/i');
define('REGEX_EMAIL','/^[\\w\\.\\+\\-\\=]+@(?:[a-zA-Z\\-]+\\.)+(?:[a-zA-Z]{2,6})$/');
define('FORMAT_ID_STRING','%06u');
define('FORMAT_PRODUCT_CODE','%s');
define('FILE_ALLOW_UPLOAD_TYPE','|txt|htm|html|jpg|gif|doc|css|rtf|xls|pdf|ppt|jpeg|bmp|png|mpg|avi|swf|jar|zip|js|xml|');//allowed upload file type
$FILE_ALLOW_EDIT_TYPE = explode('|',trim(FILE_ALLOW_UPLOAD_TYPE,'|'));
$FILE_ALLOW_EDIT_PATH = array(0=>PATH_TEMP,PATH_APPLICATION,PATH_META,PATH_GALLERY,PATH_PRODUCTPHOTO_IMG);
$FILE_ALLOW_EDIT_FOLDER_NAME = array('Th&#432; m&#7909;c t&#7841;m th&#7901;i','Th&ocirc;ng tin h&#7879; th&#7889;ng','Th&#244;ng tin &#273;&#7863;c bi&#7879;t','Th&#432; vi&#7879;n d&ugrave;ng chung','Th&#432; vi&#7879;n &#7843;nh s&#7843;n ph&#7849;m');
$FILE_ALLOW_EDIT_URL = array(0=>URL_TEMP,URL_APPLICATION,URL_META,URL_GALLERY,URL_PRODUCTPHOTO_IMG);

define('PATH_ADMIN',dirname(__FILE__).'/');
define('PATH_ADMINCOMPLS',PATH_ADMIN.'admincompls/');
define('PATH_ADMIN_FORM',PATH_ADMIN.'forms/');
define('PATH_ADMIN_PRICEFORM',PATH_ADMIN.'priceforms/');
define('URL_BASE_ADMIN',str_replace(URL_ROOT.'$/',URL_ADMIN,URL_BASE.'$/'));
define('URL_CWD',dirname(URL_SELF).'/');
define('UPDATE_CTRL',0);

define('URL_GO',$_REQUEST['go']);
$act = $_REQUEST['act'];
unset($_GET['act']);
if($t=	http_build_query($_GET)) define('URL_PAGE',URL_SELF.'?'.$t); else define('URL_PAGE',URL_SELF);

define('SORTBY_VIEW_DESC',1);
define('SORTBY_VIEW_ASC',0);
define('SORTBY_NAME_DESC',2);
define('SORTBY_NAME_ASC',3);
define('SORTBY_CREATED_DESC',5);
define('SORTBY_CREATED_ASC',4);

define('TABLE_CATPRODUCT',2);
define('TABLE_PRODUCT',1);
define('TABLE_CATNEWS',4);
define('TABLE_NEWS',3);
define('TABLE_CATBANNER',6);
define('TABLE_BANNER',5);
define('TABLE_CATUTILITY',8);
define('TABLE_UTILITY',7);
define('TABLE_CATFEEDBACK',10);
define('TABLE_FEEDBACK',9);
define('TABLE_CATAGENT',12);
define('TABLE_AGENT',11);
define('TABLE_FOLDER',14);
define('TABLE_FILE',13);

define('ACT_OPEN',0);
define('ACT_LIST',1);
define('ACT_SEARCH',2);
define('ACT_ADD',3);
define('ACT_RENAME',4);
define('ACT_SET',5);
define('ACT_SETCTRL',ACT_SET);
define('ACT_UNSETCTRL',6);
define('ACT_MOVE',7);
define('ACT_COPY',8);
define('ACT_REORDER',9);
define('ACT_PRICE',10);
define('ACT_CLONE',11);
define('ACT_REMOVE',12);
define('ACT_DEL',ACT_REMOVE);
define('ACT_SAVE',13);
define('ACT_PASSWD',14);
define('ACT_DOWNLOAD',15);
define('ACT_RESTORE',16);
define('ACT_BACKUP',17);
define('ACT_REPORT',18);
define('ACT_EDIT',19);
define('ACT_SHOW',20);

define('CAT_FLAG_ITEM',1);
define('CAT_FLAG_SUBCAT',2);
define('CAT_FLAG_EMPTY',0);
define('CAT_FLAG_ROOT',-1);
define('CAT_FLAG_NOEXIST',8);
define('PRODUCT_CTRL_SHOW',		0x00000001);
define('CATPRODUCT_CTRL_SHOW',	0x00000001);
define('NEWS_CTRL_SHOW',		0x00000001);
define('CATNEWS_CTRL_SHOW',		0x00000001);

if(is_file(PATH_APPLICATION.'lang-admin.php'))
	include PATH_APPLICATION.'lang-admin.php';//per-site admin language
include PATH_ADMIN_FORM.'lang-admin.php';//global admin language
umask(0022);
define('CM_FILE',PATH_APPLICATION.'commonvalue.php');
define('LANGUAGE_FILE', PATH_APPLICATION.'lang.php');
define('CURRENCY_FILE', PATH_GLOBAL.'currency.php');
/****COMPABILITY check*/
if(!isset($AGENT_TYPE)){
define('AGENT_TYPE_AGENT',0);
define('AGENT_TYPE_OFFICE',1000);
define('AGENT_TYPE_REPT',1001);
define('AGENT_TYPE_FACTORY',1002);
define('AGENT_TYPE_CUSTOMER',134217728);//0x08000000
define('AGENT_TYPE_MEMBER',268435456);//0x10000000
define('AGENT_TYPE_MANUFACTURER',1073741824);//0x40000000
define('AGENT_TYPE_SUPPLIER',536870912);//0x20000000
$AGENT_TYPE=array(
	AGENT_TYPE_AGENT => '&#272;&#7841;i l&#253;',
	AGENT_TYPE_OFFICE => 'V&#259;n ph&#242;ng,tr&#7909; s&#7903;',
	AGENT_TYPE_REPT => '&#272;&#7841;i di&#7879;n',
	AGENT_TYPE_FACTORY => 'Nh&#224; m&#225;y',
	AGENT_TYPE_CUSTOMER=>'Customer',
	AGENT_TYPE_MEMBER =>'H&#7897;i vi&ecirc;n',
	AGENT_TYPE_MANUFACTURER=>'Nh&agrave; s&#7843;n xu&#7845;t',
	AGENT_TYPE_SUPPLIER=>'Nh&agrave; cung c&#7845;p',
);
}
$TOOL_CTRL=array(
	0x00000001=>'Cho ph&eacute;p ch&#7841;y',
	0x40000000=>'Hi&#7879;n &#7903; menu h&#7879; th&#7889;ng'
);
/**END**/
?>
