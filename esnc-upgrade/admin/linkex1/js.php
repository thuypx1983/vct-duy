<?php require('../config.php');
require './config.php';
header('Cache-Control:public',TRUE);?>
var URL_ADMIN = '<?php echo addslashes(URL_ADMIN); ?>';
var URL_TEMP = '<?php echo addslashes(URL_TEMP); ?>';
var URL_ROOT='<?php echo addslashes(URL_ROOT); ?>';
var URL_BASE='<?php echo addslashes(URL_BASE);?>';
var ACT_OPEN='<?php echo ACT_OPEN;?>';
var ACT_LIST='<?php echo ACT_LIST;?>';
var ACT_SEARCH='<?php echo ACT_SEARCH;?>';
var ACT_ADD='<?php echo ACT_ADD;?>';
var ACT_RENAME='<?php echo ACT_RENAME;?>';
var ACT_SET='<?php echo ACT_SET;?>';
var ACT_SETCTRL='<?php echo ACT_SETCTRL;?>';
var ACT_UNSETCTRL='<?php echo ACT_UNSETCTRL;?>';
var ACT_MOVE='<?php echo ACT_MOVE;?>';
var ACT_COPY='<?php echo ACT_COPY;?>';
var ACT_REORDER='<?php echo ACT_REORDER;?>';
var ACT_PRICE='<?php echo ACT_PRICE;?>';
var ACT_CLONE='<?php echo ACT_CLONE;?>';
var ACT_REMOVE='<?php echo ACT_REMOVE;?>';
var ACT_DEL='<?php echo ACT_DEL;?>';
var ACT_SAVE='<?php echo ACT_SAVE;?>';
var ACT_PASSWD='<?php echo ACT_PASSWD;?>';
var ACT_DOWNLOAD='<?php echo ACT_DOWNLOAD;?>';