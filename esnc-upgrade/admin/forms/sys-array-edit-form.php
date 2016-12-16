<?php $this->startPage('Gi&aacute; tr&#7883; th&#432;&#7901;ng d&ugrave;ng'); //write standard page header?>
<div style="margin:10px auto 10px auto;">
<?php if($this->nFiles > 1){ 
	echo '<select onchange="self.location.href=this.value"><option>--Ch&#7885;n--</option>';
	foreach($this->cfg as $id=>$file)
	if($id==$this->cmId) echo '<option value="'.$this->makeUrl(ACT_OPEN,array('cmId'=>$id)).'" selected>'.$file['desc'].'</option>';
	else echo '<option value="'.$this->makeUrl(ACT_OPEN,array('cmId'=>$id)).'" >'.$file['desc'].'</option>';
	echo '</select>';
}else
	echo '<p align="center"><strong>'.$this->cfg[0]['desc'].'</strong></p>'; 
if($this->cmId >=0){
	$this->startForm(ACT_SAVE,array('cmId'=>$this->cmId),NULL,'onsubmit="return checkForm(this);"');
	foreach($this->CM_NAME as $cm_name){
		echo '<fieldset style="float:left;width:30%;margin:2px;"><legend>'.$cm_name.'</legend><table width="100%"><tr><th>T&ecirc;n (text)</th><th>Gi&aacute; tr&#7883; (key)</th></tr>';
		$i=0;
		foreach($$cm_name as $cm_key=>$cm_value){
			echo '<tr><td><input type="text" name="'.$cm_name.'[v]['.$i.']" value="'.$cm_value.'" /></td><td><input type="text" name="'.$cm_name.'[k]['.$i.']" value="'.$cm_key.'" /></td></tr>';
			++$i;
		}
		for($j=0;$j<4;++$j,++$i)
			echo '<tr><td><input type="text" name="'.$cm_name.'[v]['.$i.']" value="" /></td><td><input type="text" name="'.$cm_name.'[k]['.$i.']" /></td></tr>';
		echo '</tbody>';
		echo '</table></fieldset>';
	}
	$this->endForm();
}?>
<div align="center" style="clear:both; ">&#272;&#7875; xo&aacute; m&#7897;t tu&#7923; ch&#7885;n, h&atilde;y xo&aacute; c&#7843; t&ecirc;n v&agrave; gi&aacute; tr&#7883; c&#7911;a d&ograve;ng &#273;&oacute;.</div>
</div>
<script language="javascript" type="text/javascript">
window.top.document.title=self.document.title;
function checkForm(f){
	var a=document.getElementsByTagName('input'),n=a.length,i;
	for(i=0;i<n;++i) if(!a.item(i).value) a.item(i).disabled = true;// dont submit if empty
	return true;
}
function doSave(){
	if(checkForm(f = document.getElementsByTagName('form').item(0))) f.submit();
}
</script>
<?php $this->endPage();?>