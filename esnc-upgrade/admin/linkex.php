<?php //tienpd@esnadvanced.com
require('../config.php');
require('inc/common.php');
require('config.php');
require('inc/dbcon.php');
require('linkex/modulelinkexchange.php');
require('inc/session-linkex.php');

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml">';
echo '<head>';
echo '<base href="'.URL_BASE_ADMIN.'" />';
echo '<title>ESNC.Net - h&#7879; th&#7889;ng xu&#7845;t b&#7843;n th&ocirc;ng tin &#273;i&#7879;n t&#7917; - modlue link exchange</title>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
echo '<link type="text/css" rel="stylesheet" href="images/style.css">';
echo '<comment>';
echo '<link type="text/css" rel="stylesheet" href="images/style-nonie.css">';
echo '</comment>';
echo '<style>';
echo 'body{overflow:auto;}';
echo 'tr#toolbar,tr#menubar{background-color:#F2F1EB;height:25px;}';
echo 'tr#toolbar td{border-bottom:1px ridge #ACA899}';
echo 'tr#menubar td{border-bottom:1px solid #CCCCCC;}';
echo 'tr#menubar td a{padding-right:15px;}';
echo '#idstatusLine{color:red; text-align:right; display:inline;width:300px;float:right;padding-right:40px;}';
echo '.textbutton,.textbutton-hover,.imgbutton,.imgbutton-hover,.flatbutton,.flatbutton-hover{';
echo 'behavior:url(\'js/IEhover.htc\');';
echo '}';
echo 'DIV.top A{margin-right:10px;}';
echo '</style>';
echo '<script type="text/javascript">';
echo 'function showmodule(url){';
echo '	content.location.href = \''.URL_ADMIN.'\' + url;';
echo '}';
echo '</script>';
echo '</head>';
echo '<body style="margin:0px auto 0px auto" class="text">';
echo '<div class="top">';
echo '<a href="javascript:parent.showmodule(\'linkex/cat-list.php\');">category</a>';
echo '<a href="javascript:parent.showmodule(\'linkex/item-list.php\');">item list</a>';
echo '<a href="javascript:parent.showmodule(\'linkex/myaccount.php?id='.$linkex_user->id.'\');">'.$linkex_user->email.'</a>';
echo '</div>';
echo '<table width="100%">';
echo '<tr>';
echo '<td>';
echo '<iframe name="content" src="about:blank" width="100%" height="600px"></iframe>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<script type="text/javascript">';
echo '	if((content.location.href == null)||(content.location.href == \'\')||(content.location.href == \'about:blank\')){';
echo '		content.location.href = \''.URL_ADMIN.'\' + \'linkex/cat-list.php\';';
echo '	}';
echo '</script>';
echo '</body>';
echo '</html>';
dbclose();
?>