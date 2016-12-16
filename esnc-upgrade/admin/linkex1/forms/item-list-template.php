<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>S&#7917;a m&atilde; giao di&#7879;n</title>
<base href="<?php echo URL_BASE_ADMIN ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css"/>
<link type="text/css" rel="stylesheet" href="forms/style.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
</head>
<body style="margin: 0px 0px 0px 0px" class="text">
<table width="100%" cellpadding="0" cellspacing="0">
<thead>
	<tr>
		<th>&nbsp;</th>
		<th align="center">&nbsp;</th>
		<th width="<?php echo COL2_WIDTH ?>" ><span class="text" style="font-weight:bold;color:#FF0000 "><?php echo COL2_NAME ?>/*.htm</span></th>
		<th >H&agrave;nh &#273;&#7897;ng</th>
	</tr>
</thead>
<tbody>
	<?php 
	for($i = $this->startrow,$j=0;($j < $this->pagesize) && ($i < $this->rowcount); ++$i,++$j){
	?>
	<tr>
		<td align="center">&nbsp;</td>
		<td align="center" onClick="notepad('<?php echo $this->rs[$i] ?>');" class="item_icon">&nbsp; </td>
		<td align="left"><?php echo $this->rs[$i]; ?></td>
		<td align="center"><a  class="item" href="javascript:notepad('<?php echo $this->rs[$i] ?>');" >So&#7841;n th&#7843;o</a></td>
	</tr>	
	<?php }//end row scan?>	
</tbody>
<tfoot>
	<tr>
		<td >&nbsp;</td>
        <td align="center">&nbsp;</td>
		<td nowrap>&nbsp;
<?php if($this->pagecount > 1){echo '<span class="text" >::</span>';
$q=urlformat($this->q,$this->alias.'page','');
	for($p = 1; $p <= $this->pagecount; ++$p){ if($p != $this->page) {?>
		<a href="<?php echo URL_SELF."?{$q}{$p}" ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>	</td>
		<td nowrap>&nbsp;</td>
	</tr>
</tfoot>
</table>
</body>
<script language="javascript" type="text/javascript" src="js/item-list.js"></script>
<script language="javascript" type="text/javascript" src="js/lang.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo URL_APPLICATION ?>lang-admin.js"></script>
<script language="javascript" type="text/javascript" src="js/pte.js" ></script>
<script language="javascript" type="text/javascript" >
function notepad(file){
	if(window.confirm(W_TEMPLATE_EDIT)){
		window.open(URL_ADMIN + 'tpe.php?filename=' + file,'subWindow',sPlainWin);
	}
}
window.top.document.title=self.document.title;
</script>
</html>