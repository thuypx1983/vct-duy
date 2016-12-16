<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET ?>" />
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link href="images/style.css" rel="stylesheet" type="text/css" />
<title>User tracing</title>
<style type="text/css">
TEXTAREA,PRE,CODE{font-family:Courier New;font-size:12px;letter-spacing:1px}
</style>
</head>
<body>
This tool is to trace user visit (time, ip, referer, user agent...).<br/>
The tool makes use of <strong>PDOSQLite</strong>. So your system must have <strong>PDOSQLite</strong> installed in order to run this tool.<br/> 
Please <a href="<?php echo $this->makeUrl(0,NULL,'setup')?>" class="item">click here</a> to run setup
</body>
<script type="text/javascript">
var url_up="<?php echo URL_UP ?>";
var url_back="<?php echo URL_BACK ?>";
</script>
<script src="js/item-script.js" type="text/javascript"></script>
</html>