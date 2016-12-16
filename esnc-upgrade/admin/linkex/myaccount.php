<?php 
require('../../config.php');
require('../inc/common.php');
require('../config.php');
require('../inc/dbcon.php');
require('modulelinkexchange.php');
require('../inc/session-linkex.php');
require('../../class/misc.php');?>
<?php
$message='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Esnc console, module link exchange, category list</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?php echo URL_BASE_ADMIN."linkex/" ?>" />
	<style>
		INPUT.textbox{border:solid 1px #CCCCCC;}
		INPUT.button{border:solid 1px #CCCCCC;}
	</style>
	<script type="text/javascript">
		<?php if($message!='')echo 'alert(\''.$message.'\');';?>
	</script>
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><form method="post" name="form1" id="form1">
	<table>
		<tr>
			<td style="vertical-align:top;">
				<table>
				<tr>
				<td>Email</td>
				<td><a><?php echo $linkex_user->email;?></a></td>
				</tr>
				<tr>
				<tr>
				<td>Created</td>
				<td><a><?php echo $linkex_user->created;?></a></td>
				</tr>
				<tr>
				<td>Last login</td>
				<td><a><?php echo $linkex_user->lastlogin;?></a></td>
				</tr>
				<tr>
				<td>Last update</td>
				<td><a><?php echo $linkex_user->lastupdate;?></a></td>
				</tr>
				<tr>
				<td>visited</td>
				<td><a><?php echo $linkex_user->visited;?></a></td>
				</tr>
				<tr>
				<td>expired</td>
				<td><a><?php echo $linkex_user->expired;?></a></td>
				</tr>
				</table>
			</td>
			<td style="vertical-align:top;">
				<table>
				<tr>
				<td>User</td>
				<td><input type="text" name="name" class="textbox" value="<?php echo $linkex_user->user;?>" /></td>
				</tr>
				<tr>
				<td>Full Name</td>
				<td><input type="text" name="url" class="textbox" value="<?php echo $linkex_user->name;?>" /></td>
				</tr>
				<tr>
				<td>Birthday</td>
				<td><input type="text" name="src" class="textbox" value="<?php echo $linkex_user->birthday;?>" /></td>
				</tr>
				<tr>
				<td>Address</td>
				<td><input type="text" name="desc" class="textbox" value="<?php echo $linkex_user->address;?>" /></td>
				</tr>
				<tr>
				<td>Phone</td>
				<td><input type="text" name="desc" class="textbox" value="<?php echo $linkex_user->phone;?>" /></td>
				</tr>
				<tr>
				<td>Mobie</td>
				<td><input type="text" name="desc" class="textbox" value="<?php echo $linkex_user->mobie;?>" /></td>
				</tr>
				</table>
			</td>
			<td style="vertical-align:top;">
				<table>
				<tr>
				<td>Ctrl</td>
				<td>
<?php 
$ctrl = new ctrl_object();
$ctrl->ID=listctrl;
$ctrl->arr_ctrl_name =  $CATLINKEXCHANGE_CTRL;
$ctrl->showHeader = false;
$ctrl->showFooter = false;
$ctrl->show();
?>
				</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td>
				<input type="submit" class="button" name="ACT_UPDATE" value="Cập nhật " />
				<input type="submit" class="button" name="ACT_UP" value="Tr&#7903; lại " />
				</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
</form></body>
</html>
<?php dbclose();?>