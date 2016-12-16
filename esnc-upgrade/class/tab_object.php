<?php
class tab_object{
	var $ID;
	var $cssClass;
	var $arr_tab_name;
	var $arr_tab_content;
	function tab_objcet(){}
	private	function validData(){
		if($this->ID == null) return false;
		if((!is_array($this->arr_tab_name))||(count($this->arr_tab_name) == 0)) return false;
		if((!is_array($this->arr_tab_content))||(count($this->arr_tab_content) == 0)) return false;
		if(count($this->arr_tab_name) != count($this->arr_tab_content)) return false;
		if(($this->cssClass == null)||($this->cssClass==''))$this->cssClass = 'tab_object';
		return true;
	}
	function show(){
		if(!$this->validData()) return;
		echo '<div class="'.$this->cssClass.'">';
		echo '<div class="tab_name">';
		for($i=0;$i<count($this->arr_tab_name);$i++){
			echo '<div class="tab_name_item" id="'.$this->ID.'_tab_name_item_'.$i.'">'.$this->arr_tab_name[$i].'</div>';
		}
		echo '<div class="tab_name_item_notuse" id="'.$this->ID.'_tab_name_item_notuse">';
		echo '</div>';
		echo '</div>';
		echo '<div class="tab_content">';
		for($i=0;$i<count($this->arr_tab_content);$i++){
			echo '<div class="tab_content_item" id="'.$this->ID.'_tab_content_item_'.$i.'">'.$this->arr_tab_content[$i].'</div>';
		}
		echo '</div>';
		echo '</div>';
	}
}
?>
