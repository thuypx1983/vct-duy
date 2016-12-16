<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title>Th&ocirc;ng tin &#273;&#7863;c bi&#7879;t (title, meta...)</title>
<link type="text/css" rel="stylesheet" href="images/style.css">
<link type="text/css" rel="stylesheet" href="forms/style.css">
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
<script language="javascript" src="js.php"></script>
</head>
<body >
<table id="item-list" width="100%" cellpadding="0" cellspacing="0"  onclick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
	<thead>
	<tr>
		<th class="item_icon">&nbsp;</th>
		<th ><?php echo COL2_NAME?></th>
		<th ><?php echo COL3_NAME ?></th>
		<th ><?php echo COL4_NAME ?></th>
	</tr>
	</thead>
	<tbody>
<?php for($j=0,$i=$this->startrow;$j < $this->pagesize && $i < $this->rowcount;++$i,++$j) {
	$filename=$this->rs[$i];
	$name = $this->description[$filename]['name'];
	$urlitem='javascript:window.open(&quot;'.URL_ADMIN.'pte.php?FLid=2&filename='.urlencode($filename).'&title='.urlencode($name).'&quot;,&quot;_wplain&quot;,sPlainWin);return false;"';
?>
	<tr>
		<td class="item_icon">&nbsp;</td>
		<td nowrap>&nbsp;<a href="javascript:void(0)" onclick="<?php echo $urlitem ?>" class="item"><?php echo $filename ?></a></td>
		<td>&nbsp;<a href="javascript:void(0)" onclick="<?php echo $urlitem ?>" class="item"><?php echo $name ?></a></td>
		<td>&nbsp;
		<a href="javascript:void(0)" onclick="<?php echo $urlitem ?>" class="item">So&#7841;n th&#7843;o</a>
		<a href="<?php echo URL_SELF ?>?act=<?php echo ACT_SAVE ?>&filename=<?php echo urlencode($filename) ?>&name=" onclick="return changeDescription(this,&quot;<?php echo htmlspecialchars($filename) ?>&quot;,&quot;<?php echo htmlspecialchars($name) ?>&quot;);" class="item" style="border-left:1px solid gray;padding:0px 0px 0px 2px ">Ghi ch&uacute;</a>
		</td>
	</tr>	
<?php } //end row scan ?>
	</tbody>
	<tfoot>
	<tr>		
        <td colspan="4">&nbsp;
<?php if($this->pagecount > 1){
	$q = $_GET;
	$q[ALIAS.'pagesize']=$this->pagesize;
	unset($q[ALIAS.'page']);
	$q[ALIAS.'page']='';
	$pUrl = URL_SELF.'?'.http_build_query($q);//this make url: URL_SELF?&pagezie=xxx&page=
	echo 'Trang: ';
	for($p=1;$p <= $this->pagecount;++$p)
		if($p == $this->page) echo ' <span class="paging" >'.$p.'</span> ';
		else echo ' [ <a href="'.$pUrl.$p.'" class="paging" > '.$p.'</a> ] ';
}
?>		
		</td>
	</tr>
	</tfoot>
</table>
</body>
<script type="text/javascript">
frmSearch = document.getElementById('idfrmSearch');
function changeDescription(o,filename,name){
	var newName = window.prompt('Enter description for file ' + filename,name);
	if(newName && newName != name){
		o.href += encodeURIComponent(newName) + '&go=' + encodeURIComponent(self.location.href);
		return true;
	}
	return false;
}
window.top.document.title=self.document.title;
</script>
<script src="js/pte.js" type="text/javascript"></script>
</html>