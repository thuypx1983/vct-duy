<script language="javascript" type="text/javascript">
function getname(o){		
	var value = o.options[o.selectedIndex].text;
	var obj = document.getElementById("CBname");
	obj.value = value;
}
</script>
<?php
$rs = catbannerlist(CATBANNER_CTRL_LINK|CATBANNER_CTRL_SHOW);
$a_cat = array();
while($a_cat[]=mysql_fetch_assoc($rs));
array_pop($a_cat);
$select = '<select name="CBid" class="link_input" onChange="getname(this);">';
foreach ($a_cat as $cat){
	if($cat['id'] == $CBid)
		$select .= '<option value="'.$cat['id'].'" selected>'.$cat['name'].'</option>';
	else
		$select .= '<option value="'.$cat['id'].'" >'.$cat['name'].'</option>';
}
$select .= '</select>';
$tag      = array('{{CATEGORY}}','{{IMG_CODE}}','{{IMG}}');
$tagvalue = array($select,'<input class="input input_book" name="scode"/>','<img src="'.urlBuild(URL_ADMIN.'texttogif.php',array('url'=>URL_ROOT,'rnd'=>rand())).'" />');
echo '<form action="link-exchange.php?act=add" method="post" onsubmit="return checkLinkForm(this);" class="book link_exchange" >
<input type="hidden" id="CBname" name="CBname" value="'.@$CBname.'"/>';
echo str_replace($tag,$tagvalue,file_get_contents(PATH_APPLICATION.'form_link_submit.htm'));
echo '</form>';
?>
<script language="javascript" type="text/javascript" src="js/esnc_aform.php"></script>
