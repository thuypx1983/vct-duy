<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>User tracing</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link href="images/style.css" rel="stylesheet" type="text/css" />
<?php if($this->cfg['STYLE']){?>
<style type="text/css">
@import url("<?php echo $this->cfg['STYLE'] ?>");
</style>
<?php }?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body><?php $this->startForm(NULL,NULL,NULL,'','GET');?>
<p align="left"><a href="<?php echo $this->makeUrl(NULL,array('pagesize'=>$this->pagesize)) ?>"  class="item">T&#7845;t c&#7843;</a> 
| <a href="<?php echo $this->makeUrl(NULL,array('ua'=>'google','pagesize'=>$this->pagesize)) ?>" class="item" <?php if($this->ua == 'google') echo ' style="font-weight:bold"';?>>Google</a> 
| <a href="<?php echo $this->makeUrl(NULL,array('ua'=>'yahoo','pagesize'=>$this->pagesize))?>" class="item" <?php if($this->ua == 'yahoo') echo ' style="font-weight:bold"';?>>Yahoo</a>
| <a href="<?php echo $this->makeUrl(NULL,array('ua'=>'msn','pagesize'=>$this->pagesize)) ?>" class="item" <?php if($this->ua == 'msn') echo 'style="font-weight:bold"';?>>MSN</a>
| <a href="<?php echo $this->makeUrl(NULL,array('ua'=>'bot','pagesize'=>$this->pagesize)) ?>" class="item" <?php if($this->ua == 'bot') echo 'style="font-weight:bold"';?>>Bot</a>
| IP <input name="ip" value="<?php echo $this->ip ?>" class="input" size="10" /> URL <input name="url" value="<?php echo $this->url ?>" class="input" size="25"/>
Agent <input type="text" class="input" name="ua" value="<?php echo $this->ua ?>" size="15" />
</p>
<p align="left">K&iacute;ch th&#432;&#7899;c trang <input type="text" size="2" class="input" name="pagesize" value="<?php echo $this->pagesize ?>"/> 
trang <select name="page" class="input" onchange="this.form.submit();"><?php
for($p=1;$p <= $this->pagecount;++$p){
	echo '<option value="'.$p.'"'; if($p==$this->page) echo ' selected ';
	echo ' >'.$p.'</option>';
}
?></select>
<input type="submit" class="button" value="Search" />
<span style="margin:0px 0px 0px 50px; ">hi&#7875;n th&#7883; t&#7915;&nbsp;</span><strong><?php echo $this->rowstart ?></strong> &#273;&#7871;n <strong><?php echo $this->rowend ?></strong> trong t&#7893;ng s&#7889; <strong><?php echo $this->rowcount ?></strong> b&#7843;n ghi
t&#7915; <strong><?php echo basename(DB_LOG); ?></strong>(<?php echo filesize(str_replace('sqlite:','',DB_LOG)) >> 10 ?> KB)
</p>
</form>
<table border="1" bordercolor="#111111" style="border-collapse:collapse; ">
<thead>
	<tr><th>IP</th><th>time<strong>(UTC)</strong></th><th>url</th><th>refer</th><th>Agent</th><th>q</th></tr>
</thead>
<tbody>
<?php for($i=0;$row=$this->rs->fetch(PDO::FETCH_ASSOC);$i=(++$i) & 1){?>
<tr class="tr<?php echo $i ?>">
<td nowrap><a href="<?php echo $this->adjustUrl(NULL,array('ip'=>$row['ip'],'page'=>NULL)); ?>" class="item"><?php echo $row['ip'] ?></a></td>
<td nowrap><?php echo strftime(FORMAT_DATETIME,strtotime($row['tm'])); ?></td>
<td><a href="<?php echo $this->adjustUrl(NULL,array('url'=>$row['url'],'page'=>NULL)) ?>" class="item"><?php echo $row['url'] ?></a></td>
<td><a href="<?php echo $row['refer'] ?>" class="item" target="_w2"><?php echo str_replace(URL_BASE,URL_ROOT,$row['refer']) ?></a></td>
<td><?php echo $row['ua'] ?></td>
<td><?php echo $row['q'] ?></td>
</tr>
<?php }?>
</tbody>
</table>
</body>
<script type="text/javascript">
var url_up="<?php echo URL_UP ?>";
var url_back="<?php echo URL_BACK ?>";
</script>
<script src="js/item-script.js" type="text/javascript"></script>
</html>
