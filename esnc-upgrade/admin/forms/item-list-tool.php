<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link type="text/css" rel="stylesheet" href="images/style.css">
<link type="text/css" rel="stylesheet" href="forms/style.css">
<script language="javascript" type="text/javascript">
function showSelected(child,parent){
	var v =  document.getElementById(child.value);
	if (child.checked){
		parent.style.backgroundColor = "#A9D2EB";		
		v.style.backgroundColor = "#A9D2EB";
		v.style.border = "2px solid #A9D2EB";
	}else{
		parent.style.backgroundColor = "#FFFFFF";
		v.style.backgroundColor = "#FFFFFF";
		v.style.border = "2px solid #FFFFFF";
	}
}
function hover(o){
	var c = document.getElementsByName('id');
	var l = c.length;
	for (var i = 0; i<l;i++){
		if ((c[i].checked) &&(o.id == c[i].value)){
			o.style.border='2px solid #FFFFFF';
			return;
		}
	}
	o.style.border='2px solid #000000';
}
function out(o){
	var c = document.getElementsByName('id');
	var l = c.length;
	for (var i = 0; i<l;i++){
		if ((c[i].checked) &&(o.id == c[i].value)){
			o.style.border='2px solid #A9D2EB';
			return;
		}
	}	
	o.style.border='2px solid #FFFFFF';
}

</script>
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><table id="item-list" width="90%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
	<thead>
	<tr>
		<th class="item_icon">&nbsp;</th>		
		<th width="<?php echo COL1_WIDTH ?>"><?php echo COL1_NAME ?></th>		
		<th nowrap><?php echo COL2_NAME ?></th>
		<th nowrap><?php echo COL3_NAME ?></th>
		<th nowrap><?php echo COL4_NAME ?></th>
		<th ><?php echo COL6_NAME ?></th>
	</tr>
	</thead>
	<tbody><?php 
	unset($this->a_ctrl[1]);//exclude first ctrl
	foreach($this->tools as $name){//begin row scan
		$file=basename($name,'.php');
		if($row=&$this->rs[$file]){//installed tool
			$ctrl_text = '';
			if($row['ctrl'] & 2) $target='_wtool';else $target='_self';
			foreach($this->a_ctrl as $ctl => $text) if($row['ctrl'] & $ctl) $ctrl_text .= $text.'|';
			$itemurl= Tool::absToolUrl(URL_CWD.'item.php',NULL,NULL,NULL,$file,$row['id']);
?>
		<tr>
			<td class="item_icon">&nbsp;</td>
			<td align="right" nowrap><a href="<?php echo $itemurl ?>" class="item"><?php printf(FORMAT_ID_STRING,$row['id']);?></a></td>
			<td ><a href="<?php echo $itemurl ?>" class="item" <?php if (!($row['ctrl']& 1)) echo 'style="color:#CCCCCC"'; ?>  target="<?php echo $target ?>"><?php echo $row['name'] ?></a>&nbsp;</td>
			<td nowrap><?php echo $row['lastrun']; ?>&nbsp;</td>
			<td nowrap>
			<a href="<?php echo Tool::absToolUrl(URL_CWD.'item.php',NULL,NULL,'about',$file,$row['id']) ?>" class="item">Gi&#7899;i thi&#7879;u</a>
			<a href="<?php echo $itemurl?>" class="item" style="border-left:1px solid gray;padding-left:3px; " target="<?php echo $target ?>">Ch&#7841;y</a>
<?php if($session->getAccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){?>
			<a href="<?php echo Tool::absToolUrl(URL_CWD.'item.php',NULL,NULL,'setup',$file,$row['id']) ?>" class="item" style="border-left:1px solid gray;padding-left:3px; ">C&#7845;u h&igrave;nh</a>
			<a href="<?php echo Tool::absToolUrl(URL_CWD.'item.php',NULL,NULL,'remove',$file,$row['id']) ?>" class="item" style="border-left:1px solid gray;padding-left:3px; ">G&#7905; b&#7887;</a>
<?php } ?>
			</td>
			<td align="left" style="cursor:help" title="<?php echo $ctrl_text ?>"><?php echo ctrl_format($row['ctrl']); ?></td>
		</tr>	
<?php 	}elseif($session->getAccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){ //not yet installed tool, only developper allowed to install
?>
	<tr>
		<td class="item_icon">&nbsp;</td>
		<td align="right" nowrap>&nbsp;</td>
		<td align="right" nowrap><a class="item" href="<?php echo Tool::absToolUrl(URL_CWD.'item.php',NULL,NULL,'about',$file,NULL) ?>"><?php echo $name ?></a></td>
		<td align="left" nowrap>&nbsp;</td>
		<td nowrap>
		<a class="item" href="<?php echo Tool::absToolUrl(URL_CWD.'item.php',NULL,NULL,'about',$file,NULL) ?>">Gi&#7899;i thi&#7879;u</a>
		<a class="item" href="<?php echo Tool::absToolUrl(URL_CWD.'item.php',NULL,NULL,'setup',$file,NULL) ?>"  style="border-left:1px solid gray;padding-left:3px; ">C&agrave;i &#273;&#7863;t</a>
		</td>
		<td align="left" >&nbsp;</td>
	</tr>		
<?php	}
	}//end row scan?>
	</tbody>
	<tfoot>
	<tr>		
		<td colspan="6" >&nbsp;</td>
	</tr>
	</tfoot>
</table>
</body>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
<script language="javascript" type="text/javascript" defer>
window.top.document.title = self.document.title;
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo URL_SELF;?>';
var url_ctrl = '#';
var url_rename = '#';
var url_filter = '<?php echo URL_SELF.'?'.urlmodify('act',ACT_SEARCH,$this->alias.'ctrl',''); ?>';
var url_save = '#';
var url_del = '#';
var url_move = '#';
var url_copy = '#';
</script>
<script type="text/javascript" language="javascript" src="js/item-list.js"></script>
</html>
