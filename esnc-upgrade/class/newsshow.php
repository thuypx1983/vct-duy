<?php
//tienpd@esnadvanced.com
require_once(PATH_COMPLS.'news.php');
//ham lay ve nhom goc dau tien 
function get_firstGroup_ofRoot($cat_ctrl=CATNEWS_CTRL_SHOW){
	$field = '`a`.`id`,`a`.`parentid`,`a`.`name`,`a`.`desc`,`a`.`view`,`a`.`img1`,`a`.`alt1`,`a`.`extra`';
	$from = '`#catnews` as `a`';
	$where = '`a`.`ctrl`&'.((int)$cat_ctrl).' = '.((int)$cat_ctrl);
	$more = 'ORDER BY `a`.`parentid` ASC';
	$rs = mysql_select($field,$from,$where,$more,0,1); 
	if($row=mysql_fetch_object($rs))
		return $row;
	else return null;
}
//lay toan bo nhom con
function getnodes($id,&$result,&$deep){
	settype($id,'int');
	global $sql;
	$sql = "SELECT `id` FROM `catnews` WHERE `parentid`=".$id;
	$rs = mysql_query($sql);
	if($row = mysql_fetch_assoc($rs)){
		$deep = $deep + 1;
		do{
			$result[count($result)] = array('deep'=>$deep,'id'=>$row['id']);
			catdomain::getnodes($row['id'],$result,$deep);
		}while($row = mysql_fetch_assoc($rs));
	}
}
//lay nhom cha
function getparentnodes($id,&$result){
	if($id){
		settype($id,'int');
		global $sql;
		$sql = "SELECT `parentid` FROM `catnews` WHERE `parentid` IS NOT NULL AND `id`=".$id;
		$rs = mysql_query($sql);
		if($row = mysql_fetch_assoc($rs)){
			do{
				$result[count($result)] = $row['parentid'];
				catdomain::getparentnodes($row['parentid'],$result);
			}while($row = mysql_fetch_assoc($rs));
		}
	}
}
//ham kiem tra co nhom con
function is_grParentGroup($CNid=null){
	if($CNid){
		$field = '`a`.`id`,`a`.`parentid`,`a`.`name`,`a`.`desc`,`a`.`view`,`a`.`img1`,`a`.`alt1`,`a`.`extra`';
		$from = '`#catnews` as `a`';
		$where = '`a`.`parentid` = '.((int)$CNid);
		$more = '';
		$rs = mysql_select($field,$from,$where,$more,0,1000); 
	}else{
		$field = '`a`.`id`,`a`.`parentid`,`a`.`name`,`a`.`desc`,`a`.`view`,`a`.`img1`,`a`.`alt1`,`a`.`extra`';
		$from = '`#catnews` as `a`';
		$where = '`a`.`parentid` IS NULL';
		$more = '';
		$rs = mysql_select($field,$from,$where,$more,0,1000); 
	}
	if(mysql_affected_rows()>0) return true;
	else return false;
}
//ham kiem tra co item
function is_parentGroup($CNid=null){
	if($CNid){
		$field = '`a`.`NewsID`';
		$from = '`#catnewsnews` as `a`';
		$where = '`a`.`catnewsid` = '.((int)$CNid);
		$more = '';
		$rs = mysql_select($field,$from,$where,$more,0,1000); 
	}else{
		return false;
	}
	if(mysql_affected_rows()>0) return true;
	else return false;
}
//class ListNews
class ListNews{
	//cac thuoc tinh $showGroupImage,$showGroupDesc,$showItemImage,$showItemSummary chi co tac dung tren trang list
	var $message;
	var $root_id;
	var $group_ctrl,$showGroupName,$showGroupImage,$showGroupDesc;
	var $item_ctrl,$showItemImage,$showItemSummary,$showItemDate,$showItemViewDetail;
	var $list_page_name,$detail_page_name;
	var $n_group_size,$n_group_item_size;
	var $n_item_size;
	var $T_ViewDetail,$T_MoreList;
	var $showMoreList,$n_more_item_size;
	var $cssClass;
	var $IsQuichViewDetail;
	
	function _constructor(){}
	function validProperties(){
		if(($this->root_id==null)||(!is_int($this->root_id)))return false;
		else {
			$CN = catnewsopen($this->root_id,null);	
			if($CN==null)return false;
		}
		if(($this->group_ctrl==null)||(!is_int($this->group_ctrl)))$this->group_ctrl=CATNEWS_CTRL_SHOW;
		if(($this->item_ctrl==null)||(!is_int($this->item_ctrl)))$this->item_ctrl=NEWS_CTRL_SHOW;
		
		if($this->showGroupImage==null)$this->showGroupImage=false;
		if($this->showGroupDesc==null)$this->showGroupDesc=false;
		if($this->showGroupName==null)$this->showGroupName=false;
		
		if($this->showItemImage==null)$this->showItemImage=false;
		if($this->showItemSummary==null)$this->showItemSummary=false;
		if($this->showItemViewDetail==null)$this->showItemViewDetail=false;
		if($this->showMoreList==null)$this->showMoreList=false;
		if($this->IsQuichViewDetail==null)$this->IsQuichViewDetail=false;
		
		if(($this->n_group_size==null)||(!is_int($this->n_group_size)))$this->n_group_size=1;
		if(($this->n_group_item_size==null)||(!is_int($this->n_group_item_size)))$this->n_group_item_size=2;
		if(($this->n_item_size==null)||(!is_int($this->n_item_size)))$this->n_item_size=15;
		if(($this->n_more_item_size==null)||(!is_int($this->n_more_item_size)))$this->n_more_item_size=5;
		
		if($this->list_page_name==null)$this->list_page_name='list-news.php';
		if($this->detail_page_name==null)$this->detail_page_name='detail-news.php';
		if($this->T_ViewDetail==null)$this->T_ViewDetail='View detail';
		if($this->T_MoreList==null)$this->T_MoreList='Other news';
		if($this->cssClass==null)$this->cssClass='module_news';
		return true;
	}
	private	function showListItem($group_id,$inum=5,$mnum=5,$gettype=0){
		$text='';
		if(!is_grParentGroup($group_id)){
			$group = catnewsopen($group_id,null);
			$href = urlBuild($this->list_page_name,array('CNid'=>$group->id,'CNname'=>$group->name));
			$img = htmlview(URL_NEWS_IMG1,$group->img1,' class="img_1", alt="'.$group->alt1.'"',T_NO_IMG,TRUE);
			$text='<div class="group">';
			$text.='<div class="group_info">';
			if($this->showGroupName==true)
				$text.='<div class="group_name"><a href="'.$href.'" class="group_name">'.$group->name.'</a></div>';
			if($this->showGroupImage==true)
				$text.='<div class="group_image"><a href="'.$href.'" class="group_image">'.$img.'</a></div>';
			if($this->showGroupDesc==true)
				$text.='<div class="group_desc">'.$group->desc.'</div>';
			$text.='</div>';
			$last_id = null;
			$rs = newslist($group->id,$this->item_ctrl,$inum,0);			
			if($row=mysql_fetch_assoc($rs)){
				$text.='<div class="group_items">';			
				do{
					$href = urlBuild($this->detail_page_name,array('CNid'=>$group->id,'NWid'=>$row['id'],'CNname'=>$group->name,'NWname'=>$row['name']));
					$img = htmlview(URL_NEWS_IMG1,$row['img1'],'class="news_nw_image" alt="'.$row['alt1'].'"',T_NO_IMG,TRUE);
					$text.='<div class="group_item">';
					if($this->showItemImage==true)
						$text.='<div class="group_item_image"><a href="'.$href.'" class="group_item_image">'.$img.'</a></div>';
					$text.='<div class="group_item_name"><a href="'.$href.'" class="group_item_name" name="question_'.$row['id'].'">'.$row['name'].'</a></div>';
					if($this->showItemSummary==true)
						$text.='<div class="group_item_summary"><a name="answer_'.$row['id'].'"></a>'.$row['summary'].'</div>';
					if($this->showItemViewDetail==true)
						$text.='<div class="group_item_view_detail"><a href="'.$href.'" class="group_item_view_detail" name="go_question_'.$row['id'].'">'.$this->T_ViewDetail.'</a></div>';
					$text.='</div>';
					$last_id = (int)$row['id'];
				}while($row=mysql_fetch_assoc($rs));
				$text.='</div>';
				if($this->showMoreList==true){
					if($last_id){
						$nw = newsopen($last_id,true);
						$rs = newslistmore((int)$nw->id,$nw->created,$mnum,$group->id,(int)$this->item_ctrl);
						if($row=mysql_fetch_assoc($rs)){
							$text.='<div class="group_items_more"><div class="group_items_more_title">'.$this->T_MoreList.'</div>';
							do{
								$href = urlBuild($this->detail_page_name,array('CNid'=>$group->id,'NWid'=>$row['id'],'CNname'=>$group->name,'NWname'=>$row['name']));
								$img = htmlview(URL_NEWS_IMG1,$row['img1'],'alt="'.$row['alt1'].'"',T_NO_IMG,TRUE);
								$text.='<div class="group_item_name_more"><a href="'.$href.'" class="group_item_name_more">'.$row['name'].'</a></div>';
							}while($row=mysql_fetch_assoc($rs));
							$text.='</div>';
						}
					}
				}
			}
			$text.='</div>';
		}
		switch($gettype){
			case 1:
				return $text; 			
				break;
			default:echo $text;		
		}
	}
	private	function showListGroup($group_id,$gnum=5,$gettype=0){
		$text='';
		if(is_grParentGroup($group_id)){
			$group = catnewsopen($group_id,null);
			$href = urlBuild($this->list_page_name,array('CNid'=>$group->id,'CNname'=>$group->name));
			$img = htmlview(URL_NEWS_IMG1,$group->img1,' class="img_1", alt="'.$group->alt1.'"',T_NO_IMG,TRUE);
			$rs = catnewslist($this->group_ctrl,$group->id,$gnum);
			$text='<div class="group_group">';
			$text.='<div class="group_info">';			
			if($this->showGroupName==true)
				$text.='<div class="group_name"><a href="'.$href.'" class="group_name">'.$group->name.'</a></div>';
			if($this->showGroupImage==true)
				$text.='<div class="group_image"><a href="'.$href.'" class="group_image">'.$img.'</a></div>';
			if($this->showGroupDesc==true)
				$text.='<div class="group_desc">'.$group->desc.'</div>';
			$text.='</div>';				
			if($row=mysql_fetch_assoc($rs)){
				$text.='<div class="group_childs">';	
				do{
					$href = urlBuild($this->list_page_name,array('CNid'=>$row['id'],'CNname'=>$row['name']));
					$img = htmlview(URL_NEWS_IMG1,$row['img1'],'alt="'.$row['alt1'].'"',T_NO_IMG,TRUE);
					$text.='<div class="group_child">';
					if($this->showGroupName==true)
						$text.='<div class="group_child_name"><a href="'.$href.'" class="group_child_name">'.$row['name'].'</a></div>';
					if($this->showGroupImage==true)
						$text.='<div class="group_child_image"><a href="'.$href.'" class="group_child_image">'.$img.'</a></div>';
					if($this->showGroupDesc==true)
						$text.='<div class="group_child_desc">'.$row['desc'].'</div>';
					$text.='</div>';
				}while($row=mysql_fetch_assoc($rs));
				$text.='</div>';				
			}
			$text.='</div>';
		}
		switch($gettype){
			case 1:
				return $text; 			
				break;
			default:echo $text;		
		}
	}
	private	function showList($group_id,$num=10000,$gnum=5,$inum=5,$mnum=5,$gettype=0){
		$text='';
		if(is_grParentGroup($group_id)){
			$group = catnewsopen($group_id,null);
			$href = urlBuild($this->list_page_name,array('CNid'=>$group->id,'CNname'=>$group->name));
			$img = htmlview(URL_NEWS_IMG1,$group->img1,' class="img_1", alt="'.$group->alt1.'"',T_NO_IMG,TRUE);
			$rs = catnewslist($this->group_ctrl,$group_id,$num);
			if($row=mysql_fetch_assoc($rs)){
				$text.='<div class="module_news '.$this->cssClass.'">';			
				do{
					if(is_grParentGroup($row['id'])){
						$text.=$this->showListGroup($row['id'],$gnum,1);
					}else{
						$text.=$this->showListItem($row['id'],$inum,$mnum,1);
					}
				}while($row=mysql_fetch_assoc($rs));
				$text.='</div>';
			}
		}else{
			$text.='<div class="module_news '.$this->cssClass.'">';
			$text.=$this->showListItem($row['id'],$inum,$mnum,1);
			$text.='</div>';
		}
		switch($gettype){
			case 1:
				return $text; 			
				break;
			default:echo $text;		
		}
	}
	function show($gettype=0){
		$text='';
		$this->validProperties();
		$root = catnewsopen($this->root_id,null);
		if(is_grParentGroup($root->id)){
			$text.=$this->showList($root->id,$this->n_group_size,$this->n_group_item_size,$this->n_more_item_size,1);
		}else{
			$text.='<div class="module_news '.$this->cssClass.'">';
			$text.=$this->showListItem($root->id,$this->n_item_size,$this->n_more_item_size,1);
			$text.='</div>';
		}
		switch($gettype){
			case 1:
				return $text; 			
				break;
			default:echo $text;		
		}
	}
}
//end class ListNews
//class DetailNews
class DetailNews{
	var $CN_id,$id;
	var $ShowName,$ShowImage,$ShowSummary,$ShowContent;
	var $showMoreList,$ShowLessList;
	var $cssClass;
	function DetailNews(){}
	private	function validProperties(){
		if(($this->id==null)||(!is_int($this->id))){return false;}
		else {
			$NW = newsopen($this->id,true);
			if($NW==null)return false;
		}
		if($this->ShowName==null)$this->ShowName=true;
		if($this->ShowImage==null)$this->ShowImage=true;
		if($this->ShowSummary==null)$this->ShowSummary=true;
		if($this->ShowContent==null)$this->ShowContent=true;
		if($this->showMoreList==null)$this->showMoreList=true;
		if($this->ShowLessList==null)$this->ShowLessList=true;
		if($this->cssClass==null)$this->cssClass='module_news_detail';
		return true;
	}
	function show(){
		if(!$this->validProperties())return;
		$NW = newsopen($this->id,true);
		echo '<div class="'.$this->cssClass.'">';
		echo '<div class="news_item_detail">';
		if($this->ShowName)echo '<div class="news_detail_name">'.$NW->name.'</div>';
		if($this->ShowImage)echo '<div class="news_detail_name">'.$NW->img1.'</div>';
		if($this->ShowSummary)echo '<div class="news_detail_name">'.$NW->summary.'</div>';
		if($this->ShowContent)echo '<div class="news_detail_name">'.newsshow($NW->id).'</div>';
		echo '</div>';
		if($this->showMoreList==true){
			echo '<div class="news_item_morelist">';
			echo '</div>';
		}
		if($this->ShowLessList==true){
			echo '<div class="news_item_lesslist">';
			echo '</div>';
		}
		echo '</div>';
	}
}
//end class DetailNews
//end class ListFAQ
class ListFAQ{
	var $root_id;var $root_name;
	var $item_ctrl;var $num;var $page_name;var $cssClass;var $showRootName;var $o_cat;
	var $recordset;var $showBackToQuestion;var $textBackToQuestion;
	function ListFAQ(){}
	private function destroy(){}
	private function validProperties(){
		if(($this->item_ctrl==null)||(!is_int($this->item_ctrl)))$this->item_ctrl = 1;
		if(($this->num==null)||(!is_int($this->num)))$this->num = 10;
		if(($this->root_id==null)||(!is_int($this->root_id)))return false;
		else {
			$this->o_cat = catnewsopen($this->root_id,NULL);	
			if($this->o_cat==null)return false;
			else{
				if(is_grParentGroup($this->root_id))return false;
				else{
					$this->recordset = newslist($this->root_id,$this->item_ctrl,$this->num);
					if(mysql_affected_rows()<=0)return false;
				}
			}
		}
		if($this->showRootName==null)$this->showRootName=false;
		else{
			if(($this->root_name==null)||($this->root_name=='')){
				$this->root_name = $this->o_cat->name;
			}
		}
		if($this->showBackToQuestion==null){
			$this->showBackToQuestion=true;
			if(($this->textBackToQuestion==null)||($this->textBackToQuestion=='')){
				$this->textBackToQuestion = "Back to question";
			}
		}
		if($this->cssClass==null)$this->cssClass='module_faq';		
		if((!$this->page_name)||($this->page_name=='')){
			if($_SERVER['SERVER_PORT']!=80){
				$this->page_name = "http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
			}else{
				$this->page_name = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			}
		}else{
			if($_SERVER['SERVER_PORT']!=80){
				$this->page_name = "http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT']."/".str_replace("http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'],"",$this->page_name);				
			}else{
				$this->page_name = "http://".$_SERVER['HTTP_HOST']."/".str_replace("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],"",$this->page_name);
			}
		}
		return true;
	}
	function show(){
		if($this->validProperties()==false)return;
		echo '<div class="'.$this->cssClass.'">';
		if($this->showRootName==true)echo '<div class="faq_root_name">'.$this->root_name.'</div>';
		echo '<div class="faq_listquestions">';
		$i=0;
		while($row = mysql_fetch_assoc($this->recordset)){
			$href = $this->page_name."#answer_".$i;
			echo '<div class="faq_item">';
			echo '<a href="'.$href.'" name="question_'.$i.'" class="faq_item">'.$row['name'].'</a>';
			echo '</div>';
			$i++;
		}
		echo '</div>';
		$this->recordset = newslist($this->root_id,$this->item_ctrl,$this->num);
		echo '<div class="faq_listanswers">';
		$i=0;
		while($row = mysql_fetch_assoc($this->recordset)){
			$href = $this->page_name."#question_".$i;
			echo '<div class="faq_item">';
			echo '<div class="faq_asked"><a name="answer_'.$i.'">'.$row['name'].'</a></div>';
			echo '<div class="faq_summary">';
			echo $row['summary'];
			echo '</div>';
			echo '<div class="faq_backtoquestion">';
			echo '<a href="'.$href.'" class="faq_backtoquestion">'.$this->textBackToQuestion.'</a>';
			echo '</div>';
			echo '</div>';
			$i++;
		}
		echo '</div>';
		echo '</div>';
		$this->destroy();
	}
}
//end class ListFAQ
//end tienpd@esnadvanced.com
?>