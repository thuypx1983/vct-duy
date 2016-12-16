<?php class Sys_Root_Editor extends Tool{//class name must be same as file name and extends the tools class
	function remove(){//called when user click uninstall
		switch($this->act){
		case ACT_SAVE:
			parent::cleanup();
			redirect($this->makeUrl(ACT_DONE,NULL,'remove'));
		case ACT_DONE:
			showloadscreen(URL_UP,5,'Tool uninstalled...');
			break;
		default:
			$this->startPage('Uninstall system file editor tool');
			$this->startForm(ACT_SAVE,NULL,'remove');
			echo 'please click OK to remove tool, CANCEL to continue to use tool';
			echo '<input type="submit" value="OK" class="button"/>';
			echo '<input type="button" value="CANCEL" onclick="window.alert(&quot;thank you&quot;);window.history.back();" class="button" />';
			$this->endForm();
			$this->endPage();
		}
	}
	function setup(){//called when user setup the tool
		global $session;
		switch($this->act){
		case ACT_SAVE://when act is save, write configuration to database
			$this->name='System file editor';
			$this->ctrl |= array_sum($_POST['ctrl']);
			if($_POST['more']) $_POST['f'] += array($_POST['more']=>1);
			$this->data=serialize($_POST['f']);
			$this->access=0;//require access developper to run
			$this->save();
			redirect($this->makeUrl(NULL,NULL,'setup'));
		default:
			$this->cfg=unserialize($this->data);
			if(!$this->cfg) $this->cfg=array();
			$this->startPage('Root file editor setup');
			$this->startForm(ACT_SAVE);
			echo '<fieldset style="width:800px;margin:60px auto 20px auto; "><legend>Enable users to edit following files</legend>
<div>PATH_ROOT: <strong>'.PATH_ROOT.'</strong></div>
<div><input type="checkbox" name="f['.PATH_ROOT.'robots.txt]" value="1" '.($this->cfg[PATH_ROOT.'robots.txt'] ? 'checked':'').' /> robots.txt</div>';
			unset($this->cfg[PATH_ROOT.'robots.txt']);
			foreach($this->cfg as $file=>$value)
				echo '<div><input type="checkbox" class="input" name="f['.$file.']" value="1" checked />'.str_replace(PATH_ROOT,'',$file).'</div>';
			if($session->getAccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER))	echo '<div>Other file <input type="text" name="more" class="input" size="80" value="" /></div>'; 
			echo '<div><input type="hidden" value="1" name="ctrl[]" /><input type="checkbox" value="',0x40000000,'" name="ctrl[]" '; if($this->ctrl & 0x40000000) echo 'checked'; echo ' />Show on system menu</div>';
			$this->endForm();
			echo '</fieldset><script type="text/javascript">function doSave(){document.forms[0].submit();}</script>';
			$this->endPage();
		}
	}
	function init(){
		//add initialisation here
		$this->cfg=unserialize($this->data);
	}
	function run(){//tool run
		global $sql,$session;//$session is to check the permission, by using $session->getaccess
		$this->init();
		$this->active_file=$_REQUEST['active_file'];
		switch($this->act){
		case ACT_SAVE:
			if($this->active_file){
				chmod($this->active_file,700);
				rename($this->active_file,PATH_TEMP.time().'~'.basename($this->active_file));
				if(is_uploaded_file($_FILES['contentfile']['tmp_name'])){//content is uploaded
					move_uploaded_file($_FILES['contentfile']['tmp_name'],$this->active_file);
				}else{
					file_put_contents($this->active_file,$_POST['content']);
				}
				chmod($this->active_file,0555);
			}
			redirect($this->makeUrl(NULL,array('active_file'=>$this->active_file)));
		default://this code can be included from other file
			$this->startPage('System file editor');
			echo '<fieldset style="margin:5px"><legend>';
			if(count($this->cfg) == 1){
				$this->active_file=key($this->cfg);//directly open file if unique file
				echo '<strong>'.$this->active_file.'</strong>';
			}else{
				echo '<select onchange="self.location.href=this.value"><option>--Select file--</option>';
				foreach($this->cfg as $key=>$value)
					echo '<option value="'.$this->makeUrl(ACT_OPEN,array('active_file'=>$key)).'" '.($key==$this->active_file ? 'selected': '').' >'.str_replace(PATH_ROOT,URL_ROOT,$key).'</option>';
				echo '</select>';
			}
			echo '</legend>';
			if($this->active_file){
				$this->startForm(ACT_SAVE,array('active_file'=>$this->active_file),NULL,' enctype="multipart/form-data"');
				echo '&nbsp;upload content: <input type="file" class="input input_file" name="contentfile" /><br />&nbsp;Or type content directly<br/>';
				echo '<textarea name="content" class="input" style="width:798px;height:480px">';
				echo htmlspecialchars(file_get_contents($this->active_file));
				echo '</textarea>';
				$this->endForm();
			}
			echo '</fieldset><script type="text/javascript">function doSave(){document.forms[0].submit();}</script>';
			$this->endPage();
		}
	}
	function about(){
		$this->startPage('About system file editor');
		echo '<p align="center">System file editor allows you to edit some file at web root. To install this tool, you must have ACCESS_DEVELOPPER priviledge.</p>';
		$this->endPage();
	}
}?>
