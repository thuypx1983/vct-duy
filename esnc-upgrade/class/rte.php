<?php 
define('RTE_B_STYLE',		0x00000001);
define('RTE_B_FONTSIZE',	0x00000002);
define('RTE_B_LINK',		0x00000004);
define('RTE_B_IMAGE',		0x00000008);
define('RTE_B_TABLE',		0x00000010);
define('RTE_B_UPLOAD',		0x00000020);
//define('RTE_B_DROP',		0x00000040);
define('RTE_B_BOLD',		0x00000080);
define('RTE_B_ITALIC',		0x00000100);
define('RTE_B_UNDERLINE',	0x00000200);
define('RTE_B_COLOR',		0x00000400);
define('RTE_B_BGCOLOR',		0x00000800);
define('RTE_B_LEFT',		0x00001000);
define('RTE_B_RIGHT',		0x00002000);
define('RTE_B_CENTER',		0x00004000);
define('RTE_B_JUSTIFY',		0x00008000);
define('RTE_B_NUMBER',		0x00010000);
define('RTE_B_BULLET',		0x00020000);
define('RTE_B_INDENT',		0x00040000);
define('RTE_B_OUTDENT',		0x00080000);
define('RTE_B_SUPERSCRIPT',	0x00100000);
define('RTE_B_SUBSCRIPT',	0x00200000);
//define('RTE_B_HTML',		0x00400000);
//define('RTE_B_WORD',   	0x00800000);//strip word tag
define('RTE_B_PREVIEW',		0x01000000);//preview
define('RTE_B_LINEHEIGHT',	0x02000000);//line-height control
define('RTE_B_CSS',			0x04000000);//CSS style sheet
define('RTE_B_FORM',		0x08000000);//Insert form elements
define('RTE_B_DEFAULT',RTE_B_LINK|RTE_B_BOLD|RTE_B_ITALIC);
define('RTE_B_ALL',		0xFFFFFFFF);
define('URL_FSMAN',	URL_ADMIN.'files/explorer.php?FLid=3');
class RTE{
var $name,$ctrl,$img,$exbutton,$width,$height,$area,$areaStyle;//$name: objectname, $ctrl: buttons
static $quote=array('&'=>'&amp;','<textarea'=>'&lt;textarea','</textarea>'=>'&lt;/textarea&gt;');
	function __construct($n,$img='images/rteimages/',$ctrl=RTE_B_DEFAULT,$buttons=NULL){
		$this->name = $n;
		$this->frameId = $this->name.'_frame';
		$this->areaId = $this->name.'_area';
		$this->img = $img;
		$this->ctrl = $ctrl;
		$this->exbutton = &$buttons;//user-defined button
		$this->a_font=array(
			'default'=>'***ng&#7847;m &#273;&#7883;nh***',
			'Arial,Helvetica,sans-serif'=>'Arial',
			'Courier New,Courier,mono'=>'Courier New',
			'Times New Roman,Times,serif'=>'Times New Roman',
			'Verdana,Arial,Helvetica,sans-serif'=>'Verdana',
			'Tahoma,Times New Roman,Verdana'=>'Tahoma',
			);
		$this->a_size=array(
			'0px'=>'***ng&#7847;m &#273;&#7883;nh***',
			'5'=>'***t&#7841;o &#273;o&#7841;n***',
			'8px'=>'8 px',
			'9px'=>'9 px',
			'10px'=>'10 px',		
			'11px'=>'11 px',		
			'12px'=>'12 px',		
			'13px'=>'13 px',		
			'14px'=>'14 px',		
			'16px'=>'16 px',		
			'18px'=>'18 px',		
			'20px'=>'20 px',		
			'24px'=>'24 px',		
		);
	}
	function rename($n){
		$this->name = $n;
		$this->frameId = $this->name.'_frame';
		$this->areaId = $this->name.'_area';
	}
	function show($name,&$value,$height='100%',$width='100%'){
		$this->area = $name;
		$style='style="width:'.$width.';height:'.$height.'"';
		$this->showRTEtoolbar();
		echo '<div style="width:'.$width.';height:'.$height.';display:none" >';
		$this->showEditorFrame('class="editor" '.$style);
		echo '</div><div '.$style.'>';
		$this->showEditorArea($name,$value,' class="input editor" '.$style);
		echo '</div>';
	}
	function showButton($src,$title,$onclick,$id='',$style='style="float:left"'){
		echo '<div '.$style.'><div unselectable="on" class="'.$id.' rteButton" onclick="_rteObject.'.str_replace('"',"'",$onclick).'" >&nbsp;</div></div>';
	}
	function showButtonEx($src,$title,$onclick,$id='',$style='class="rteButtonEx" style="position:relative;float:left"'){
		echo '<div '.$style.'><div unselectable="on" class="'.$id.' rteButton" onclick="'.str_replace('"',"'",$onclick).'" >&nbsp;</div></div>';
	}
	function showRTEtoolbar(){
		echo '<div class="rteToolbar">';
		if($this->ctrl & RTE_B_STYLE){
			echo '<div class="rteButtonBlock" style="position:relative;float:left;white-space:nowrap;">';
			echo '<div class="rteButton" style="width:75px;text-align:center;"><strong style="cursor:default;line-height:18px;">[Ph&ocirc;ng ch&#7919;]</strong></div>';
			echo '<div class="rteMenu" style="width:120px;">';
			foreach($this->a_font as $key=>$name){
				echo '<div ><A href="#" unselectable="on" onclick="_rteObject.execCmd(\'fontname\',this.title);return false;" title="'.$key.'" style="font-family:'.$key.'" class="menu">'.$name.'</a></div>';
			}
			echo '</div></div>';
		}
		if($this->ctrl & RTE_B_FONTSIZE){
			echo '<div class="rteButtonBlock" style="position:relative;float:left;white-space:nowrap; ">';
			echo '<div class="rteButton" style="width:53px;text-align:center;"><strong style="cursor:default;line-height:18px;">&nbsp;[C&#7905; ch&#7919;]&nbsp;</strong></div>';
			echo '<div class="rteMenu" style="width:100px;">';
			foreach($this->a_size as $key=>$name){
				echo '<div ><A href="#" unselectable="on" onclick="_rteObject.execCmd(\'fontsize\',this.title);return false;" title="'.$key.'"  class="menu">&nbsp;&nbsp;'.$name.'</a></div>';
			}
			echo '</div></div>';
		}
		if($this->ctrl & RTE_B_LINK) {
			$this->showButtonEx($this->img.'hyperlink.gif','Th&ecirc;m li&ecirc;n k&#7871;t','this.parentNode.appendChild(_rteToolbar.dlgLink);_rteObject.showLinkDialog(this);','rteBnLink');
		}
		if($this->ctrl & RTE_B_IMAGE){
			$this->showButtonEx($this->img.'image.gif','Th&ecirc;m &#7843;nh (&#7843;nh ph&#7843;i &#273;&atilde; c&oacute; tr&ecirc;n m&#7841;ng ho&#7863;c &#273;&atilde; &#273;&#7849;y l&ecirc;n m&aacute;y ch&#7911;)','this.parentNode.appendChild(_rteToolbar.dlgImage);_rteObject.showImageDialog(this);','rteBnImage');
		}
		if($this->ctrl & RTE_B_UPLOAD){
			$this->showButtonEx('upload.gif','T&#7843;i l&ecirc;n','openFSMan()','rteBnUpload');
		}
		if($this->ctrl & RTE_B_TABLE){
			$this->showButtonEx($this->img.'table.gif','Th&ecirc;m b&#7843;ng','this.parentNode.appendChild(_rteToolbar.dlgTable);_rteObject.showTableDialog(this);','rteBnTable');
		}
		$this->showButton('remformat.gif','Xo&aacute; b&#7887; c&aacute;c &#273;&#7883;nh d&#7841;ng (m&agrave;u, ki&#7875;u ch&#7919;) &#273;&atilde; th&#7921;c hi&#7879;n','execCmd("removeformat")','rteBnRemoveFormat');
		$this->showButton('bold.gif','L&agrave;m &#273;&#7853;m ch&#7919;','execCmd("bold")','rteBnBold');
		$this->showButton('italic.gif','L&agrave;m nghi&ecirc;ng ch&#7919;','execCmd("italic")','rteBnItalic');
		$this->showButton('underline.gif','G&#7841;ch ch&acirc;n','execCmd("underline")','rteBnUnderline');
		if($this->ctrl & RTE_B_SUBSCRIPT)
			$this->showButton('subscript.gif','Ch&#7881; s&#7889; d&#432;&#7899;i ch&acirc;n','execCmd("subscript")','rteBnSubscript');
		if($this->ctrl & RTE_B_SUPERSCRIPT)
			$this->showButton('superscript.gif','Ch&#7881; s&#7889; m&#361;','execCmd("superscript")','rteBnSuperscript');
		if($this->ctrl & RTE_B_COLOR){
			$this->showButtonEx($this->img.'fcolor.gif','Ch&#7885;n m&agrave;u ch&#7919;','this.parentNode.appendChild(_rteToolbar.dlgColor);_rteObject.showColorPalette(this)','rteBnColor');
		}
		if($this->ctrl & RTE_B_BGCOLOR){
			$this->showButtonEx($this->img.'bgcolor.gif','Ch&#7885;n m&agrave;u n&#7873;n','this.parentNode.appendChild(_rteToolbar.dlgBgColor);_rteObject.showBgColorPalette(this)','rteBnBgColor');
		}	
		if($this->ctrl & RTE_B_LEFT)
			$this->showButton('left.gif','C&#259;n tr&aacute;i','execCmd("justifyleft")','rteBnLeft');
		if($this->ctrl & RTE_B_CENTER)
			$this->showButton('center.gif','C&#259;n gi&#7919;a','execCmd("justifycenter")','rteBnCenter');
		if($this->ctrl & RTE_B_RIGHT)
			$this->showButton('right.gif','C&#259;n ph&#7843;i','execCmd("justifyright")','rteBnRight');
		if($this->ctrl & RTE_B_JUSTIFY)
			$this->showButton('justify.gif','C&#259;n &#273;&#7873;u hai b&ecirc;n','execCmd("justifyfull")','rteBnJustify');
		if($this->ctrl & RTE_B_NUMBER)
			$this->showButton('numlist.gif','&#272;&aacute;nh s&#7889; &#273;&#7847;u d&ograve;ng','execCmd("insertorderedlist")','rteBnNumlist');
		if($this->ctrl & RTE_B_BULLET)
			$this->showButton('bullet.gif','T&#7841;o c&aacute;c m&#7909;c li&#7879;t k&ecirc; c&oacute; &#273;&aacute;nh d&#7845;u &#273;&#7847;u m&#7895;i d&ograve;ng','execCmd("insertunorderedlist")','rteBnBullet');
		if($this->ctrl & RTE_B_OUTDENT)
			$this->showButton('unindent.gif','Gi&#7843;m l&#7873; tr&aacute;i','execCmd("outdent")','rteBnUnindent');
		if($this->ctrl & RTE_B_INDENT)
			$this->showButton('indent.gif','T&#259;ng l&#7873; tr&aacute;i','execCmd("indent")','rteBnIndent');
		if(is_array($this->exbutton))
			foreach($this->exbutton as $btn)
				$this->showButtonEx($btn[1],$btn[2],$btn[3],$btn[0]);
			$this->showButton('html.gif','Xem m&atilde; HTML &#273;&atilde; t&#7841;o ra (d&ugrave;ng cho ng&#432;&#7901;i bi&#7871;t so&#7841;n th&#7843;o HTML)','toggleMode()','rteBnHTML','style="float:right;"');
			$this->showButton('preview.gif','Xem tr&#432;&#7899;c','showPreview();','rteBnPreview','style="float:right;"');
		echo '<div style="float:right;" class="rteButton"><input type="checkbox" name="rte_tag_'.$this->area.'" value="1" checked title="Chu&#7849;n ho&aacute; c&aacute;c th&#7867; HTML"  class="input input_mini" unselectable="on"/></div>';
		echo '</div>';
	}
	function showEditorFrame($style='class="editor" style="width:100%;height:100%"'){
		echo '<iframe id="'.$this->frameId.'" name="'.$this->frameId.'" '.$style.' src="about:blank" onfocus="'.$this->name.'.attachToolbar();" onblur="'.$this->name.'.detachToolbar();"></iframe>';
	}
	function showEditorArea($name,&$value,$style){
		echo '<textarea id="'.$this->areaId.'" name="'.$name.'" '.$style.' onfocus="'.$this->name.'.attachToolbar();" onblur="'.$this->name.'.detachToolbar();">';
		echo str_ireplace(array_keys(RTE::$quote),array_values(RTE::$quote),$value);
		echo '</textarea>';
	}
	function initRteObjectScript($auto=TRUE){
		static $moz_compability_timeout = 0;
		echo '<script language="javascript" type="text/javascript" defer> var '.$this->name.'=null;function '.$this->name.'_init(){';
		echo '/*@cc_on @if(1) '.$this->name.'= new RTEie(window.frames["'.$this->frameId.'"],document.getElementById("'.$this->areaId.'"),document.getElementById("'.$this->frameId.'").parentNode,document.getElementById("'.$this->areaId.'").parentNode,"'.URL_BASE.'");';
		echo ' @else @*/  '.$this->name.'= new RTE(window.frames["'.$this->frameId.'"],document.getElementById("'.$this->areaId.'"),document.getElementById("'.$this->frameId.'").parentNode,document.getElementById("'.$this->areaId.'").parentNode,"'.URL_BASE.'"); ';
		echo 'window.frames["'.$this->frameId.'"].addEventListener("focus",function (evt){'.$this->name.'.attachToolbar();},true);';
		echo 'window.frames["'.$this->frameId.'"].addEventListener("blur",function (evt){'.$this->name.'.detachToolbar();},true);';
		echo ' /*@end @*/}';		
		if($auto) echo 'window.setTimeout("'.$this->name.'_init();",'.($moz_compability_timeout += 2000).')';
		echo '</script>';
	}
	function loadRTEDialog(){?>
<div id="iddlgInsertLink" class="rteDialog" unselectable="on">
<table cellpadding="0" cellspacing="3" border="0" ><tbody >
<tr>
	<td nowrap>Li&ecirc;n k&#7871;t</td>
	<td nowrap align="right" ><select onChange="_rteToolbar.changeProto(this);"  class="input ibtn">
	<option value="" selected>------</option>
	<option value="http://" >http://</option>
	<option value="mailto:">mailto:</option>
	<option value="ftp://">ftp://</option>
	</select> <input id="frmInsertLink_x_url" type="text" class="input ibtn" size="30" onFocus="this.select();" ></td>
</tr>
<tr>
	<td nowrap>T&#234;n</td>
	<td align="right" ><input id="frmInsertLink_x_lnk" type="text" class="input ibtn" size="43"></td>
</tr>
<tr>
	<td nowrap>Tu&#7923; ch&#7885;n</td>
	<td ><select id="frmInsertLink_x_target" class="input ibtn">
		<option value="_self" selected>Gi&#7919; nguy&#234;n c&#7917;a s&#7893;</option>
		<option value="_blank">M&#7903; c&#7917;a s&#7893; m&#7899;i</option>
	</select></td>
</tr>
<tr>
	<td colspan="2" align="right" >
		<input type="button" unselectable="on" value="Ch&#7845;p nh&#7853;n" class="button ibtn" onClick="_rteObject.addLink();_rteToolbar.dlgLink.parentNode.removeChild(_rteToolbar.dlgLink);" />&nbsp;<input type="button" class="button ibtn" onClick="_rteToolbar.dlgLink.parentNode.removeChild(_rteToolbar.dlgLink);_rteObject.editorWindow.document.body.focus();" value='&#272;&oacute;ng' unselectable="on" />
	</td>
</tr>
</tbody></table>
</div>
<div id='iddlgInsertImage' class="rteDialog" unselectable="on">
<table cellpadding="0" cellspacing="3" border="0" width="300"><tbody >
<tr>
	<td >&#7842;nh</td>
	<td colspan="3" ><input type="text" id="frmInsertImage_x_url" class="input"  style="width:98%"  title="Nh&#7853;p v&agrave;o &#273;&#432;&#7901;ng d&#7851;n &#7843;nh, vd: http://www.site.com/images/myimages.gif ho&#7863;c /images/myimages.gif"/></td>
</tr>
<tr>
	<td >T&#234;n</td>
	<td colspan="3" ><input type="text" id="frmInsertImage_x_alt" class="input"  style="width:98%" title="T&ecirc;n n&agrave;y s&#7869; hi&#7875;n th&#7883; khi tr&igrave;nh duy&#7879;t ch&#432;a l&#7845;y &#273;&#432;&#7907;c &#7843;nh v&#7873;" /></td>
</tr>
<tr>
	<td width="56" >C&#259;n</td>
	<td width="70" ><select id="frmInsertImage_x_align" size="1" title="&#272;&#7883;nh v&#7883; tr&iacute; &#7843;nh" class="input" >
		<option value="" selected>Kh&#244;ng</option>
		<option value="left">Tr&#225;i</option>
		<option value="right">Ph&#7843;i</option>
		<option value="texttop">D&#432;&#7899;i ch&#7919;</option>
		<option value="absmiddle">Gi&#7919;a tuy&#7879;t &#273;&#7889;i</option>
		<option value="baseline">Theo &#273;&#432;&#7901;ng c&#417; b&#7843;n</option>
		<option value="absbottom">D&#432;&#7899;i tuy&#7879;t &#273;&#7889;i</option>
		<option value="bottom">D&#432;&#7899;i</option>
		<option value="middle">Gi&#7919;a</option>
		<option value="top">Tr&#234;n &#273;&#7881;nh</option>
	</select></td>
	<td width="99" >Vi&#7873;n</td>
	<td width="45" ><input type="text" id="frmInsertImage_x_border" size="3" value="0" title="&#272;&#7875; tr&#7889;ng s&#7869; kh&ocirc;ng c&oacute; vi&#7873;n &#7843;nh" class="input" /></td>
</tr>
<tr>
	<td >R&#7897;ng</td>
	<td ><input type="text" id="frmInsertImage_x_width" size="3" value="0" class="input" /></td>
	<td >Cao</td>
	<td ><input type="text" id="frmInsertImage_x_height" size="3" value="0" class="input" /></td>
</tr>
<tr>
	<td >L&#7873; d&#7885;c</td>
	<td ><input type="text" id="frmInsertImage_x_horiz" class="input ibtn" size="3" value="0" title="Th&ecirc;m v&agrave;o theo chi&#7873;u d&#7885;c" /></td>
	<td >L&#7873; ngang</td>
	<td ><input type="text" id="frmInsertImage_x_vert" class="input" size="3" value="0" title="Th&ecirc;m v&agrave;o m&#7897;t kho&#7843;ng c&aacute;ch theo chi&#7873;u ngang " /></td>
</tr>
<tr>
	<td colspan="4" height="20" valign="bottom" align="right" >
		<input type="button" value="Ch&#7845;p nh&#7853;n" class="button ibtn" onClick="_rteObject.addImage();_rteToolbar.dlgImage.parentNode.removeChild(_rteToolbar.dlgImage);"  unselectable="on" />&nbsp;<input type="button" onClick="_rteToolbar.dlgImage.parentNode.removeChild(_rteToolbar.dlgImage);_rteObject.editorWindow.document.body.focus();" value='&#272;&oacute;ng' class="button ibtn" unselectable="on" />
	</td>
</tr>
</tbody>
</table>
</div>
<div id='iddlgInsertTable' class="rteDialog" unselectable="on">
<table cellpadding="0" cellspacing="3" border="0" width="280"><tbody >
<tr>
	<td nowrap>H&agrave;ng:</td>
	<td ><input id="frmInsertTable_x_rows" type="text" value="2" size="8" class="input" ></td>
	<td nowrap>C&#7897;t</td>
	<td ><input id="frmInsertTable_x_cols" type="text" value="2" size="8" class="input" ></td>
</tr>
<tr>
	<td >C&#259;n</td>
	<td ><select id="frmInsertTable_x_align" class="input" >
		<option value="" selected>Kh&#244;ng</option>
		<option value="left">Tr&#225;i</option>
		<option value="right">Ph&#7843;i</option>
		<option value="center">Gi&#7919;a</option>
	</select></td>
	<td colspan="2" ><input type="checkbox" id="frmInsertTable_x_wset" checked  onclick="document.getElementById('frmInsertTable_x_wtype').disabled=document.getElementById('frmInsertTable_x_width').disabled=!this.checked" class="input input_mini" />&#272;&#7897; r&#7897;ng:</td>
</tr>
<tr>
	<td >Bi&#234;n</td>
	<td ><input id="frmInsertTable_x_border" type="text" value="1" size="8" class="input" ></td>
	<td ><input id="frmInsertTable_x_width" type="text" value="100" size="8" class="input" ></td>
	<td ><select id="frmInsertTable_x_wtype" class="input" >
		<option value="">px</option>
		<option value="%" selected>%</option>
	</select></td>
</tr>
<tr>
	<td >&#272;&#7879;m &#244;</td>
	<td ><input id="frmInsertTable_x_padding" type="text" value="4" size="8" class="input" ></td>
	<td >C&#225;ch &#244;</td>
	<td ><input id="frmInsertTable_x_spacing" type="text" value="0" size="8" class="input" ></td>
</tr>
<tr>
	<td colspan="4" height="20" valign="bottom" align="right" >
		<input type="button" value="Ch&#7845;p nh&#7853;n" class="button ibtn" onClick="_rteObject.addTable();_rteToolbar.dlgTable.parentNode.removeChild(_rteToolbar.dlgTable);"  unselectable="on"/>&nbsp;<input type="button"  value="&#272;&oacute;ng" onclick="_rteToolbar.dlgTable.parentNode.removeChild(_rteToolbar.dlgTable);_rteObject.editorWindow.document.body.focus();" class="button ibtn" unselectable="on"/>
	</td>
</tr>
</tbody></table>
</div>
<div id='iddlgColorPalette' class="rteDialog"  unselectable="on" >
<table cellpadding="1" cellspacing="1" border="0" align="center" ><tbody >
<tr>
	<td  title="#ffffff" bgcolor="#ffffff"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcccc" bgcolor="#ffcccc" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcc99" bgcolor="#ffcc99" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffff99" bgcolor="#ffff99" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffffcc" bgcolor="#ffffcc" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#99ff99" bgcolor="#99ff99" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#99ffff" bgcolor="#99ffff" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ccffff" bgcolor="#ccffff" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ccccff" bgcolor="#ccccff" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffccff" bgcolor="#ffccff" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#cccccc" bgcolor="#cccccc"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff6666" bgcolor="#ff6666" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff9966" bgcolor="#ff9966" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffff66" bgcolor="#ffff66" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffff33" bgcolor="#ffff33" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#66ff99" bgcolor="#66ff99" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#33ffff" bgcolor="#33ffff" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#66ffff" bgcolor="#66ffff" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#9999ff" bgcolor="#9999ff" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff99ff" bgcolor="#ff99ff" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#c0c0c0" bgcolor="#c0c0c0"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff0000" bgcolor="#ff0000" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff9900" bgcolor="#ff9900" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcc66" bgcolor="#ffcc66" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffff00" bgcolor="#ffff00" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#33ff33" bgcolor="#33ff33" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#66cccc" bgcolor="#66cccc" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#33ccff" bgcolor="#33ccff" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#6666cc" bgcolor="#6666cc" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc66cc" bgcolor="#cc66cc" onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#999999" bgcolor="#999999"  onClick="_rteObject.setColor(this.title);" unselectable="on"  height="12"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc0000" bgcolor="#cc0000"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff6600" bgcolor="#ff6600"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcc33" bgcolor="#ffcc33"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcc00" bgcolor="#ffcc00"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#33cc00" bgcolor="#33cc00"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#00cccc" bgcolor="#00cccc"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#3366ff" bgcolor="#3366ff"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#6633ff" bgcolor="#6633ff"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc33cc" bgcolor="#cc33cc"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#666666" bgcolor="#666666"  onClick="_rteObject.setColor(this.title);" unselectable="on"  height="12"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#990000" bgcolor="#990000"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc6600" bgcolor="#cc6600"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc9933" bgcolor="#cc9933"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#999900" bgcolor="#999900"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#009900" bgcolor="#009900"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#339999" bgcolor="#339999"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#3333ff" bgcolor="#3333ff"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#6600cc" bgcolor="#6600cc"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#993399" bgcolor="#993399"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#333333" bgcolor="#333333"  onClick="_rteObject.setColor(this.title);" unselectable="on"  height="12"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#660000" bgcolor="#660000"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#993300" bgcolor="#993300"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#996633" bgcolor="#996633"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#666600" bgcolor="#666600"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#006600" bgcolor="#006600"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#336666" bgcolor="#336666"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#000099" bgcolor="#000099"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#333399" bgcolor="#333399"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#663366" bgcolor="#663366"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#000000" bgcolor="#000000"  onClick="_rteObject.setColor(this.title);" unselectable="on"  height="12"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#330000" bgcolor="#330000"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#663300" bgcolor="#663300"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#663333" bgcolor="#663333"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#333300" bgcolor="#333300"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#003300" bgcolor="#003300"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#003333" bgcolor="#003333"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#000066" bgcolor="#000066"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#330099" bgcolor="#330099"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#330033" bgcolor="#330033"  onClick="_rteObject.setColor(this.title);" unselectable="on" ><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr><td  height="22" align="center" colspan="10" style="border:1px">
<input type="button" class="button" onClick="_rteToolbar.dlgColor.parentNode.removeChild(_rteToolbar.dlgColor);_rteObject.editorWindow.document.body.focus();" title="Nh&#7845;n v&#224;o &#273;&#226;y &#273;&#7875; &#273;&#243;ng c&#7917;a s&#7893; ch&#7885;n m&#224;u" value="&#272;&#243;ng" unselectable="on" />
</td>
</tr>
</tbody></table>
</div>
<div id='iddlgBgColorPalette' class="rteDialog" unselectable="on">
<table cellpadding="1" cellspacing="1" border="0" align="center" ><tbody >
<tr>
	<td  title="#ffffff" bgcolor="#ffffff"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcccc" bgcolor="#ffcccc" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcc99" bgcolor="#ffcc99" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffff99" bgcolor="#ffff99" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffffcc" bgcolor="#ffffcc" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#99ff99" bgcolor="#99ff99" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#99ffff" bgcolor="#99ffff" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ccffff" bgcolor="#ccffff" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ccccff" bgcolor="#ccccff" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffccff" bgcolor="#ffccff" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#cccccc" bgcolor="#cccccc"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff6666" bgcolor="#ff6666" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff9966" bgcolor="#ff9966" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffff66" bgcolor="#ffff66" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffff33" bgcolor="#ffff33" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#66ff99" bgcolor="#66ff99" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#33ffff" bgcolor="#33ffff" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#66ffff" bgcolor="#66ffff" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#9999ff" bgcolor="#9999ff" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff99ff" bgcolor="#ff99ff" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#c0c0c0" bgcolor="#c0c0c0"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff0000" bgcolor="#ff0000" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff9900" bgcolor="#ff9900" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcc66" bgcolor="#ffcc66" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffff00" bgcolor="#ffff00" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#33ff33" bgcolor="#33ff33" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#66cccc" bgcolor="#66cccc" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#33ccff" bgcolor="#33ccff" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#6666cc" bgcolor="#6666cc" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc66cc" bgcolor="#cc66cc" onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#999999" bgcolor="#999999"  onClick="_rteObject.setBgColor(this.title);" unselectable="on" height="12"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc0000" bgcolor="#cc0000"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ff6600" bgcolor="#ff6600"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcc33" bgcolor="#ffcc33"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#ffcc00" bgcolor="#ffcc00"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#33cc00" bgcolor="#33cc00"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#00cccc" bgcolor="#00cccc"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#3366ff" bgcolor="#3366ff"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#6633ff" bgcolor="#6633ff"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc33cc" bgcolor="#cc33cc"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#666666" bgcolor="#666666"  onClick="_rteObject.setBgColor(this.title);" unselectable="on" height="12"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#990000" bgcolor="#990000"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc6600" bgcolor="#cc6600"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#cc9933" bgcolor="#cc9933"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#999900" bgcolor="#999900"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#009900" bgcolor="#009900"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#339999" bgcolor="#339999"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#3333ff" bgcolor="#3333ff"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#6600cc" bgcolor="#6600cc"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#993399" bgcolor="#993399"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#333333" bgcolor="#333333"  onClick="_rteObject.setBgColor(this.title);" unselectable="on" height="12"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#660000" bgcolor="#660000"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#993300" bgcolor="#993300"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#996633" bgcolor="#996633"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#666600" bgcolor="#666600"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#006600" bgcolor="#006600"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#336666" bgcolor="#336666"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#000099" bgcolor="#000099"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#333399" bgcolor="#333399"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#663366" bgcolor="#663366"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr>
	<td  title="#000000" bgcolor="#000000"  onClick="_rteObject.setBgColor(this.title);" unselectable="on" height="12"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#330000" bgcolor="#330000"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#663300" bgcolor="#663300"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#663333" bgcolor="#663333"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#333300" bgcolor="#333300"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#003300" bgcolor="#003300"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#003333" bgcolor="#003333"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#000066" bgcolor="#000066"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#330099" bgcolor="#330099"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
	<td  title="#330033" bgcolor="#330033"  onClick="_rteObject.setBgColor(this.title);" unselectable="on"><div class="colorSelect" unselectable="on">&nbsp;</div></td>
</tr>
<tr><td  height="22" align="center" colspan="10" style="border:1px">
<input type="button" class="button" onClick="_rteToolbar.dlgBgColor.parentNode.removeChild(_rteToolbar.dlgBgColor);_rteObject.editorWindow.document.body.focus();" title="Nh&#7845;n v&#224;o &#273;&#226;y &#273;&#7875; &#273;&#243;ng c&#7917;a s&#7893; ch&#7885;n m&#224;u" value="&#272;&#243;ng" unselectable="on"/>
</td>
</tr>
</tbody></table>
</div>
<?php	echo '<script language="javascript" type="text/javascript" >var _rteToolbar=null;var _rteObject=null;function openFSMan(){window.open("'.URL_FSMAN.'","window1",window1Params);}</script>';
	}//function showRTEDialog
	function normalizeHTML(&$s){
		$s=strip_tags($s,'<a><abbr><acronym><applet><address><area><b><base><basefont><bdo><bgsound><big><blockquote><body><br><button><caption><center><cite><code><col><colgroup><dd><div><dl><dt><em><embed><fieldset><font><form><frame><frameset><h1><h2><h3><h4><h5><h6><hr><head><i><iframe><ilayer><input><img><label><legend><li><link><marquee><meta><p><ol><option><pre><s><samp><script><small><span><strike><strong><style><sub><sup><table><tbody><tr><td><textarea><inputarea><tfoot><th><thead><title><u><ul>');
		unset(self::$quote['<textarea'],self::$quote['</textarea>']);
		$s = str_ireplace(array_values(RTE::$quote),array_keys(RTE::$quote),$s);//unquote safe text
		$s = strtr($s,array('%7B'=>'{','%7D'=>'}'));//for template editor
		$s = preg_replace('/(;|\")\s*mso\-[^\:]+\:[^;\"]+(;|\")/i','$1$2',$s);		
	}
	function quoteHTML(&$s){
		$s = str_ireplace(array_keys(RTE::$quote),array_values(RTE::$quote),$s);//unquote safe text
	}
} //class RTE
?>
