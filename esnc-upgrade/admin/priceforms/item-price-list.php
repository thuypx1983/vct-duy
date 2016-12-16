<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<head><title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
<link type="text/css" rel="stylesheet" href="images/rtestyle.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" src="js/rte.js" type="text/javascript"></script>
</head>
<body>
<form method="post">
<?php 
	$obj->show();
	echo '<input type="submit" class="button" value="Th&ecirc;m m&#7899;i" name="packageadd" />
		<input type="submit" class="button" value="L&#432;u l&#7841;i" name="packagesave" />
		<input type="submit" class="button" value="Nh&#7853;p gi&aacute;" name="price" />'
?>
<form>
</body>
</html>
<?php dbclose(); ?>