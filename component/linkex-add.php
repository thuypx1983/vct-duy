<?php 
$select = '<select name="CBid" class="link_input">';
$rs = catlinkexchangelist();
if($row=mysql_fetch_assoc($rs)){
	do{
		if($CBid == $row['id'])
			$select .= '<option value="'.$row['id'].'" selected="selected">'.$row['name'].'</option>';
		else
			$select .= '<option value="'.$row['id'].'" >'.$row['name'].'</option>';
	}while($row=mysql_fetch_assoc($rs));
}
$select .= '</select>';
$tag      = array('{{CATEGORY}}','{{IMG_CODE}}','{{IMG}}');
$tagvalue = array($select,'<input class="input input_book" name="scode"/>','<img src="'.urlBuild(URL_ADMIN.'texttogif.php',array('url'=>URL_ROOT,'rnd'=>rand())).'" />');
//if($message=="true")	echo "Link da duoc gui, xin cho admin duyet";
//if($message=="false")	echo "Link chua gui duoc, ban vui long gui lai hoac lien he voi admin de duoc giai dap";
echo '<form method="post" onsubmit="return checkLinkForm(this);" class="book link_exchange" action="link-exchange.php?act=add">';
echo str_replace($tag,$tagvalue,file_get_contents(PATH_APPLICATION.'form_link_submit.htm'));
echo '</form>';
?>
<script language="javascript" type="text/javascript" src="js/esnc_aform.php"></script>
