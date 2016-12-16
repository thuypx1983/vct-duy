<html><head><title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../images/style.css" />
<script language="javascript" type="text/javascript" src="../js/library.js"></script>
<script language="javascript" type="text/javascript" src="../js.php"></script>
<script language="javascript" type="text/javascript">
</script>
<style type="text/css">
div#attribute{
	font-size:11px;
	visibility:hidden;
	position:absolute;
	border:1px solid #96969D;
	border-top:0px;
	background:#FFFFFF;	
}
div#attributetext{
	padding:5px 0px 0px 20px;
	font-size:11px;
	background:url(../images/selectbox.gif);
	width:156px;
	height:22px;
	background-repeat:no-repeat;
}
</style>
</head>
<body class="text">
<form action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data" id="idfrmItem">	
<table width="100%" border="0" class="text">
<tr valign="top">
	<td>
	<div class="title">M&#227;</div>
	<div><input name="code" type="text" value="<?php echo $this->code; ?>" style="width:150px;"></div>	</td>
	<td>
	<div class="title">T&#234;n</div>
	<div><?php echo $this->lastname; ?></div>
	</td>
	<td>
	<div class="title">H&#7885;</div>
	<div><?php echo $this->firstname; ?></div>
	</td>
	<td>
		<div class="title">Email</div>
		<div class="text"><?php echo $this->email; ?></div>
	</td>
</tr>
<tr valign="top">
	<td>
		<div class="title">&#272;&#7863;c t&#237;nh</div>
		<div>
			<div id="attributetext" onClick="SHOW('attribute');">&#272;&#259;c t&#237;nh</div>
			<div id="attribute">
			<?php 
			foreach($this->a_ctrl as $ctl=>$text){
				echo '<div><input type="checkbox" value="'.$ctl.'" name="ctrl[]" ';
				if($this->ctrl & $ctl) echo ' checked';
				echo ' />&nbsp;'.ctrl_format($ctl).$text.'</div>';
			}?>
				<div style="text-align:right; "><a href="#" onClick="SHOW('attribute');return false;">&#272;&#243;ng</a></div>
			</div>
		</div>	</td><td>
		<div class="title">&#272;i&#7879;n tho&#7841;i</div>
		<div><?php echo $this->phone; ?></div>
	</td><td>
		<div class="title">Mobile</div>
		<div><?php echo $this->mobile; ?></div>
	</td><td>
		<div class="title">Fax</div>
		<div><?php echo $this->fax; ?></div>
	</td>
</tr>
<tr valign="top">
	<td>
		<div class="title">T&#234;n t&#7893; ch&#7913;c</div>
		<div><?php echo $this->organ ?>&nbsp;<?php
if(CUSTOMER_CTRL_AGENT == 0x02){
	include PATH_COMPLS.'agent.php';
	$rs = agentlist(NULL,NULL,1);
	if($row=mysql_fetch_assoc($rs)){
		echo '<br/><select name="agentid" class="input"><option value="0">--Ch&#7885;n &#273;&#7841;i l&#253;--</option>';
		do{
			echo '<option value="'.$row['id'].'"'. ($this->agentid == $row['id']? ' selected':'').'>';
			if($row['code']) echo '['.$row['code'].']'.$row['name'];
			else echo '(#'.sprintf(FORMAT_ID_STRING,$row['id']).')'.$row['name'];
			echo '</option>';
		}while($row=mysql_fetch_assoc($rs));
		echo '</select>';
	}
}		
		?></div>
	</td>
	<td>
		<div class="title">Ng&#224;y sinh</div>
		<div><?php echo $this->birthdate; ?></div>
	</td>
	<td>
		<div class="title">N&#417;i sinh</div>
		<div><?php echo $this->birthplace; ?>&nbsp;</div>
	</td>
	<td>
		<div class="title">Gi&#7899;i t&#237;nh</div>
		<div><?php 
foreach($this->a_gender as $key=>$text)
	if($this->gender & $key)
		echo '<input name="gender[]" value="'.$key.'" disabled="true" type="checkbox" class="input_mini" checked />'.$text.'&nbsp;';		
		 ?>&nbsp;</div>
	</td>
</tr>
<tr valign="top"><td >
		<div class="title">M&#227; th&#224;nh ph&#7889;</div>
		<div><?php echo $this->city ?> <input class="input" style="width:80px" name="cityid" value="<?php echo $this->cityid ?>" /></div>
	</td>
	<td >
		<div class="title">M&#227; qu&#7889;c gia</div>
		<div><?php echo $this->country ?> <input class="input" style="width:30px" name="countryid" value="<?php echo $this->countryid ?>" /></div>
	</td>
	<td colspan="2">
		<div class="title">&#272;&#7883;a ch&#7881;</div>
		<div><address><?php echo $this->address ?></address></div>
	</td>
</tr>
<tr><td colspan="4">
	<div class="title">Ki&#7875;u t&agrave;i kho&#7843;n</div>
	<div><select name="type" class="input"><?php 
foreach($GLOBALS['CUSTOMER_TYPE'] as $type=>$type_name)	
	if($type == $this->type) echo '<option value="'.$type.'" selected>'.$type_name.'</option>';
	else echo '<option value="'.$type.'">'.$type_name.'</option>';
	 ?></select></div>	
</td></tr>
<tr valign="top"><td >
		<div class="title">Ng&#224;y t&#7841;o</div>
		<div><?php echo $this->created ?></div>	
	</td><td >
		<div class="title">Ng&#224;y s&#7917;a &#273;&#7893;i</div>
		<div><?php echo $this->modified ?></div>	
	</td><td >
		<div class="title">Ng&#224;y &#273;&#259;ng nh&#7853;p</div>
		<div><?php echo $this->lastlogon ?></div>	
	</td><td >
		<div class="title">L&#7847;n &#273;&#259;ng nh&#7853;p</div>
		<div><?php echo $this->visited ?></div>	
	</td>
</tr>
<tr><td height="28" class="title" colspan="4"><a href="<?php echo URL_ADMIN?>order/item-list.php?keyword=<?php echo $this->email?>" >&#272;&#417;n h&#224;ng &#273;&#227; &#273;&#7863;t (theo email)</a><br></td>
	</tr>
<tr><td colspan="4">
<div class="title">T&#243;m t&#7855;t</div>
<div><?php echo $this->summary ?></div>
</td>
</tr>
</table><!-- <?php echo $this->password ?>-->
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var sParams = "status=yes,scrollbars=no,toolbar=no,menubar=no,resizable=no,location=no,height=514,width=740,top=50,left=100";
var url_rte = URL_ADMIN + 'rte.php?filename=<?php echo $this->contentfile;?>';
var self_id = '<?php echo $this->id;?>';
var self_type = '<?php echo $this->type;?>';
var frmItem = document.getElementById("idfrmItem");
var imgImg1 = document.getElementById('idimgImg1');
var imgImg2 = document.getElementById('idimgImg2');
var imgImg = document.getElementById('idimgImg');
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo dirname(URL_SELF) ?>/item-list.php?<?php echo urlmodify($this->alias.'id',NULL,$this->catalias.'id',$this->catid); ?>';
var url_newitem=url_self + '?<?php echo urlmodify('catid',$this->catid,$this->alias.'id',0,'id',0,'type',$_GET['type']); ?>';
function checkForm(f){
	return true;
}
</script>
<script language="javascript" src="../js/item-script.js"></script>
<?php dbclose(); ?>