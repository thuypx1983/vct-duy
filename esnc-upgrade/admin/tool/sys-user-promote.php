<?php class Sys_User_Promote extends Tool{//class name must be same as file name and extends the tools class
	function remove(){//called when user click uninstall
		switch($this->act){
		case ACT_SAVE:
			parent::cleanup();
			redirect($this->makeUrl(ACT_DONE,NULL,'remove'));
		case ACT_DONE:
			showloadscreen(URL_UP,5,'Tool uninstalled...');
			break;
		default:
			$this->startPage('Uninstall user promoting tool');
			$this->startForm(ACT_SAVE,NULL,'remove');
			echo '<fieldset style="text-align:center"><legend>please click UNINSTALL to remove tool, CANCEL to continue to use tool</legend>'
			,'<input type="submit" value="UNINSTALL" class="button"/>&nbsp;'
			,'<input type="button" value="CANCEL" onclick="doUp();" class="button" />'
			,'</fieldset>';
			$this->endForm();
			$this->endPage();
		}
	}
	function setup(){//called when user setup the tool
		global $session;
		switch($this->act){
		case ACT_SAVE://when act is save, write configuration to database
			$this->name='User promote tool';
			$this->ctrl |= array_sum($_POST['ctrl']);
			$this->access=USER_CTRL_ROOT|ACCESS_DEVELOPPER;//require access developper to run
			$this->save();
			redirect($this->makeUrl(ACT_DONE,NULL,'setup'));
		case ACT_DONE:
			$this->startPage('User promote tool');
			echo '<p align="center"><strong>Done</strong></p>'
			,'<script type="text/javascript" >window.setTimeout("doUp();",2000);</script>';
			$this->endPage();
			break;
		default:
			$this->startPage('User promote tool setup');
			$this->startForm(ACT_SAVE);
			echo 
			'<fieldset style="width:800px;margin:60px auto 20px auto; "><legend>Click SETUP to setup the tool</legend>'
			,'<input type="hidden" name="ctrl[]" value="1" />'
			,'<input type="checkbox" name="ctrl[]" value="1073741824"',($this->ctrl & 1073741824 ? ' checked': ''),' /> Show on system menu <br/>'
			,'<input type="submit" value="SETUP" class="button" />&nbsp;'
			,'<input type="button" value="CANCEL" class="button" onclick="doUp()" />'
			,'</fieldset><script type="text/javascript">function doSave(){document.forms[0].submit();}</script>';
			$this->endForm();
			$this->endPage();
		}
	}
	function init(){
	}
	function run(){//tool run
		global $session;
		if($session->getAccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){
			switch($this->act){
			case ACT_SAVE:
				$email=$_POST['USemail'];
				$id = (int)$_POST['USid'];
				$flag = (int)$_POST['flag'];
				if($flag)
					$sql = 'UPDATE `'.DB_TABLE_PREFIX.'user` SET `ctrl` = `ctrl` | '.ACCESS_DEVELOPPER.' WHERE `id`='.$id.' AND `email`=\''.mysql_real_escape_string($email).'\'';
				else
					$sql = 'UPDATE `'.DB_TABLE_PREFIX.'user` SET `ctrl` = `ctrl` & ~'.ACCESS_DEVELOPPER.' WHERE `id`='.$id.' AND `email`=\''.mysql_real_escape_string($email).'\'';
				mysql_query($sql);
				redirect($this->makeUrl(ACT_DONE,array('ret'=>mysql_affected_rows(),'user'=>$email),'run'));
			case ACT_DONE:
				$this->startPage('User promote tool');
				echo '<fieldset style="text-align:center"><legend>Result</legend>';
					if($_GET['ret'] > 0) echo '<font color="green"><strong>Successfully</strong></font> process user: '.$_GET['user'];
					else echo '<font color="red"><strong>Failed</strong></font> process user: '.$_GET['user'];
				echo '</fieldset>';
				$this->endPage();			
			break;
			default://this code can be included from other file
				$this->startPage('User promote tool');
				$this->startForm(ACT_SAVE);
					echo '<fieldset><legend>Promote/Demote user as ACCESS_DEVELOPPER</legend>';
					echo '<table><tr><td>Email</td><td>:<input type="text" name="USemail" class="input" /></td></tr>';
					echo '<tr><td>User id</td><td>:<input type="text" name="USid" class="input" /></td></tr>';
					echo '<tr><td>ACCESS_DEVELOPPER</td><td>:<input type="checkbox" name="flag" class="input_mini" value="1" /></td></tr>';
					echo '<tr><td colspan="2" align="center"><input type="submit" class="button" value="Submit" /><input type="button" class="button" value="Cancel" onclick="doUp()" /></td></tr></table>';
					echo '</fieldset>';
				$this->endForm();
				$this->endPage('<script type="text/javascript">function doSave(){document.forms[0].submit()}</script>');
			}
		}else{
			$this->startPage('User promote tool');
			echo '<p align="center">Only DEVELOPPER can run this tool.<br/>You do not have neccessary priviledges to run this tool</p>'
			,'<script type="text/javascript">window.setTimeout("doUp()",2000);</script>';
			$this->endPage();
		}
	}
	function about(){
		$this->startPage('About user promote tool');
		echo '<p align="center" class="text"><strong>User promote tool</strong> is to make an user a ACCESS_DEVELOPPER</p>';
		$this->endPage();
	}
}?>
