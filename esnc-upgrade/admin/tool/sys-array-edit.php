<?php 
class Sys_Array_Edit extends Tool{
	function run(){
		if(isset($_GET['cmId']))		$this->cmId=$_GET['cmId'];
		else $this->cmId = -1;
		$this->cfg = unserialize($this->data);
		switch($this->act){
		case ACT_SAVE:
			$this->CM_NAME = explode(',',$this->cfg[$this->cmId]['vars']);
			$this->cmFile = $this->cfg[$this->cmId]['name'];
			foreach($this->CM_NAME as $cm_name){
				foreach($_POST[$cm_name]['v'] as $i=>$value)
					if($value && !$_POST[$cm_name]['k'][$i]) $_POST[$cm_name]['k'][$i] = $value;//set key=value if key empty
					elseif(!$value) unset($_POST[$cm_name]['v'][$i],$_POST[$cm_name]['k'][$i]);
			}
			$fh = fopen(PATH_APPLICATION.$this->cmFile,'w');
			fwrite($fh,'<?php //#'.implode(',',$this->CM_NAME)."\r\n");
			foreach($this->CM_NAME as $cm_name){
				fwrite($fh,'$'.$cm_name.'='.var_export(array_combine($_POST[$cm_name]['k'],$_POST[$cm_name]['v']),TRUE));
				fwrite($fh,";\r\n");
			}
			fwrite($fh,' ?>');
			fclose($fh);
			redirect($this->makeUrl(ACT_OPEN,array('cmId'=>$this->cmId)));
			break;
		default://show form
			$this->nFiles = count($this->cfg);
			if( $this->nFiles == 1)	$this->cmId = 0;// there is only 1 file, set to active
			if($this->cmId >=0) $this->cmFile=$this->cfg[$this->cmId]['name'];
			if($this->cmFile){
				include PATH_APPLICATION.$this->cmFile;
				$this->CM_NAME = explode(',',$this->cfg[$this->cmId]['vars']);
			}
			include PATH_ADMIN_FORM.'sys-array-edit-form.php';
		}
	}
	function setup(){
		if($this->act == ACT_SAVE){
			foreach($_POST['del'] as $i=>$filename){
				rename(PATH_APPLICATION.$filename,PATH_TEMP.time().'_'.rand().'~'.$filename);
				unset($_POST['cmfile'][$i]);
			}
			foreach($_POST['cmfile'] as $i=>&$file){
				if(preg_match('/^[a-z][a-z\-]+\.php$/',$file['name']) && preg_match('/^[A-Z][A-Z_]+(?:\,[A-Z][A-Z_]+)*$/',$file['vars'])){
					if(!is_file(PATH_APPLICATION.$file['name'])){
						$fh = fopen(PATH_APPLICATION.$file['name'],'w');
						fwrite($fh,'<?php //#'.$file['vars']);
						$t = explode(',',$file['vars']);
						foreach($t as $varname) fwrite($fh,"\r\n\${$varname}=array();");
						fwrite($fh,'?>');
						fclose($fh);
					}
				}
			}
			$this->data= serialize($_POST['cmfile']);
			$this->ctrl = array_sum($_POST['ctrl']);
			$this->name= $_POST['name'];
			if(!$this->name) $this->name = 'Gi&aacute; tr&#7883; th&#432;&#7901;ng d&ugrave;ng';
			$this->save();
			redirect($this->makeUrl(NULL));
		}
		$this->cfg=unserialize($this->data);
		if(!$this->cfg) $this->cfg=array();
		$this->startPage('C&agrave;i &#273;&#7863;t/c&#7845;u hinh tr&igrave;nh so&#7841;n th&#7843;o m&#7843;ng');
?><style type="text/css">
input.input{width:300px;}
input.cmmorevars{text-transform:uppercase;}
label{width:300px;
display:-moz-inline-box;
display:inline-block;
margin:5px 0px 0px 0px;
}
div.heading{margin:8px 0px;}
</style>
<div align="center" class="heading"><strong>C&agrave;i &#273;&#7863;t/c&#7845;u hinh tr&igrave;nh so&#7841;n th&#7843;o m&#7843;ng</strong></div>
<div style="margin:2px auto 2px auto;width:700px ">
<?php $this->startForm(ACT_SAVE,NULL,NULL,'onsubmit="return checkForm(this)"');?>
<label>T&ecirc;n c&ocirc;ng c&#7909;</label><input type="text" class="input" name="name" value="<?php echo $this->name ?>" /><br/>
<label>Hi&#7875;n th&#7883; &#7903; menu h&#7879; th&#7889;ng</label><input type="checkbox" name="ctrl[]" value="1073741824" <?php if($this->ctrl & 0x40000000) echo 'checked'?> /><br />
<fieldset><legend>C&aacute;c t&#7853;p tin</legend>
<?php $i=-1; foreach($this->cfg as $i=>&$file){?>
<label>T&ecirc;n (PATH_APPLICATION/*.php)</label><input type="hidden" class="input" name="cmfile[<?php echo $i ?>][name]" value="<?php echo $file['name'] ?>" /> <?php echo $file['name'] ?> <input type="checkbox" name="del[<?php echo $i ?>]" value="<?php echo $file['name'] ?>" /> xo&aacute;<br />
<label>Mi&ecirc;u t&#7843; </label><input type="text" class="input" name="cmfile[<?php echo $i ?>][desc]" value="<?php echo $file['desc'] ?>" /><br />
<label>C&aacute;c bi&#7871;n</label><input type="hidden" class="input" name="cmfile[<?php echo $i ?>][vars]" value="<?php echo $file['vars'] ?>" /> <?php echo $file['vars'] ?> <br />
<?php }; ++$i;//to add more file?>
<br />Th&ecirc;m t&#7853;p tin m&#7899;i<br />
<label>T&ecirc;n (PATH_APPLICATION/*.php)</label><input type="text" class="input cmmorefile" name="cmfile[<?php echo $i ?>][name]" onchange="checkFileName(this)" /> <br />
<label>Mi&ecirc;u t&#7843; </label> <input type="text" class="input cmmoredesc" name="cmfile[<?php echo $i ?>][desc]" /><br />
<label>C&aacute;c bi&#7871;n (vi&#7871;t hoa, c&aacute;ch nhau d&#7845;u ph&#7849;y)</label><input type="text" class="input cmmorevars" name="cmfile[<?php echo $i ?>][vars]" onchange="checkVars(this)" />
<input type="hidden" name="ctrl[]" value="1" />
</fieldset>
<?php $this->endForm();?>
</div>
<script type="text/javascript">
function checkVars(o){
	o.value=o.value.toUpperCase();
	if(o.value && !/^[A-Z][A-Z_]+(?:\,[A-Z][A-Z_]+)*$/.test(o.value)){
		parent.banner.setStatus('T&ecirc;n bi&#7871;n kh&ocirc;ng h&#7907;p l&#7879;');
		o.focus();
		o.select();
		return false;
	}
	return true;
}
function checkFileName(o){
	if(o.value && !/^[a-z][a-z\-]+\.php$/.test(o.value)){
		parent.banner.setStatus('T&ecirc;n file kh&ocirc;ng h&#7907;p l&#7879;');
		o.focus();
		o.select();
		return false;
	}
	return true;
}
function checkForm(f){
	var check= checkFileName(f.elements['cmfile[<?php echo $i ?>][name]']) && checkVars(f.elements['cmfile[<?php echo $i ?>][vars]']);
	var a = document.getElementsByTagName('input'),n=a.length,i;
	for(i=0;i<n;++i) if(!a.item(i).value){  a.item(i).disabled = true;}
	return check;
}
function doSave(){
	var f;
	if(checkForm(f = document.getElementsByTagName('form').item(0))) f.submit();
}
function doDel(){ doSave();}
</script><?php
		$this->endPage();
	}
	function about(){
		$this->startPage('C&ocirc;ng c&#7909; s&#7917;a &#273;&#7893;i c&aacute;c m&#7843;ng th&#432;&#7901;ng d&ugrave;ng, m&#7843;ng nh&#7887;');
		echo 'C&ocirc;ng c&#7909; n&agrave;y d&ugrave;ng &#273;&#7875; s&#7917;a c&aacute;c m&#7843;ng th&#432;&#7901;ng d&ugrave;ng.<br />
C&aacute;c m&#7843;ng n&agrave;y d&ugrave;ng &#273;&#7875; ch&#7913;a m&#7897;t s&#7889; gi&aacute; tr&#7883; nh&#7887;. V&iacute; d&#7909;: Mr, Mrs, Search Engine...';
		$this->endPage();
	}//end function about
	function remove(){
		parent::cleanup();
		showLoadScreen(URL_UP,5,'Tool uninstalled');
	}
}
?>