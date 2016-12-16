<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="forms/style.css" />
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
</head>
<body style="margin: 0px 0px 0px 0px;" class="text">
<?php
	$url .= URL_SELF.'?';
	if(count($this->a_link)==0) $url.=urlmodify('act',ACT_SAVE);
	elseif($this->tag!='') $url.=urlmodify('act',ACT_ADD);
	else $url.=urlmodify('act',ACT_EDIT);
?>
<form action="<?php echo $url; ?>" method="post" id="idfrmPDlink">

<table width="100%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">	
	<thead>
	<tr>
		<th width="14%">&nbsp;</th>				
		<th width="63%" >Các sản phẩm liên quan đến  <?php echo '<strong>'.$this->name.'</strong>'; ?></th>		
		<th width="23%">Tìm với từ khóa</th>
	</tr>
	</thead>
	<?php 
		$i=1;
		foreach($this->a_cat as $cat){ ?>
	<tr>		
		<td colspan="2">		
		<?php
		$rs = $this->getproduct($cat['id'],$this->tag);
		$a = array();
		while($a[] = mysql_fetch_assoc($rs)); //cho danh sach bai vao mang de dem so tin bai trong nhom
		array_pop($a);
		mysql_free_result($rs);
		?>
		<div><DIV class="join_plus" onclick="showChildNodes(this);">&nbsp;</DIV><strong class="a"><?php echo $cat['name'].'</strong> (Có '.count($a).' sản phẩm)'; ?></strong></div><div class="block">
			<table width="98%" cellpadding="0" cellspacing="0" class="tab_item">
				<thead>
				<tr>
					<th width="5%">&nbsp;</th>
					<th width="11%" >ID</th>
					<th width="65%" >Tên bài</th>
					<th width="19%" >Trạng thái</th>	
				</tr>
				</thead>
				<?php 
				foreach($a as $row){	
					$rss = $this->getctrl($row['id']);		
					$str='';$checked='';					
					while($rw = mysql_fetch_assoc($rss)){
						if($rw['count']!=0){
							$str='Đang liên kết';
							$checked='checked="checked"';
						}else{
							$str='Chưa liên kết';
							$checked="";	
						}
					}
					mysql_free_result($rss);

				?>
				<tr>
					<td><?php echo '<input type="checkbox" name="linkid['.$row['id'].']" value="'.$row['id'].'" '.$checked.' />'?></td>
					<td><?php printf(FORMAT_ID_STRING,$row['id']);?></td>
					<td><?php echo $row['name'];?></td>
					<td align="center"><?php echo $str; ?></td>
				</tr>	
				<?php }?>
			</table>
		</div>		
		</td>
		<?php if($i==1){?>	
		<td  rowspan="<?php echo count($this->a_cat);?>" valign="top">
		<?php		
			foreach($a_tag as $tag){
				echo '<a href="'.URL_SELF.'?act='.ACT_SEARCH.'&NWid='.$this->newsid.'&NWlink='.$this->type.'&tag='.$tag.'">'.$tag.'</a>, ';
			}				
		?>		
		</td>
		<?php }$i++;?>
	</tr>
	<?php }?>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
window.top.document.title = self.document.title;
var self_type='<?php echo $this->type ?>';
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo URL_CWD.'item-list.php?CPid='.$this->catproductid.'&PDpagesize='.$PDpagesize.'&PDpage='.$PDpage; ?>';
var url_filter = '<?php echo URL_SELF.'?'.urlmodify('act',ACT_SEARCH,ALIAS.'ctrl',''); ?>';
var frmSearch = document.getElementById('idfrmSearch');
</script>
<script language="javascript" type="text/javascript">
function doSave(){
	document.getElementById('idfrmPDlink').submit();
}
function doUp(){
	self.location.href=url_up;
}
function doSearch(){
		frmSearch.style.top='2px';
		frmSearch.style.left='180px';
		frmSearch.q.select();
		frmSearch.q.focus();
}
function noSearch(){
	frmSearch.style.top='-600px';
	frmSearch.style.left='-600px';
}
function showChildNodes(o){
	if(o.className=='join_plus'){
		o.className='join_minus';
		o.parentNode.nextSibling.style.display='block';
	}else{
		o.className='join_plus';
		o.parentNode.nextSibling.style.display='none';
	}
}
</script>