<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
        echo "<script language='javascript'>window.top.location='".URL_ROOT."'</script>";
        exit();
}
require '../config.php';
$filename=(string)$_GET['FFid'];
if(!preg_match(REGEX_CHECK_STRING_SERIES,$filename)) return FALSE;
$path = $FILE_ALLOW_EDIT_PATH[(int)$_GET['FLid']];
header('Cache-Control:private',TRUE);
header('Content-Type:application/octet-stream',TRUE);
header("Content-Disposition:attachment; filename={$filename}");
header('Content-Length:'.filesize($path.$filename));
readfile($path.$filename);
?>