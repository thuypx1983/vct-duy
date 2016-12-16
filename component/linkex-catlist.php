<?php 
$rs = catlinkexchangelist();
$BNpage=1;
if(!empty($_GET['BNpage']))$BNpage=(int)$_GET['BNpage'];
echo '
	<Div class="b_about_all">
		<Div class="title_about_">
			<Div class="left_title_about">
				<Div class="right_title_about">
					<Div class="middle_title_tourist">
						<h2>'.@T_GROUP_LINK_EX.'</h2>
					</Div>
				</Div>
			</Div>
		</Div>
		<div class="ct_about_">
			<div class="arrow_back_2"></div>
			<div class="padding_tour_group_">
			<div class="content_menu_left">
	        <ul class="box_pa_cambodia">';
if($row=mysql_fetch_assoc($rs)){
	do{
		echo '<li';
		if($CBid == $row['id']){
			echo ' class="list_link_exchange_active"';
		}
		echo '><a class="box_tour_list" href="';
		echo 'link_exchanges_'.preg_replace('/\W+/','_',$row['name']).'_'.$row['id'].'.html';
		echo '">';
		echo $row['name'];
		echo '</a>';
		echo '</li>';
		$page=1;$pagecount=0;
		$rs1=linkexchangepagelist((int)$row['id'],null,null,null,$page,$pagecount,LINKEX_PAGESIZE);
		for($i = 2;$i <= $pagecount;$i++){
			echo '&nbsp;&nbsp;<a  href="link_exchanges_'.preg_replace('/\W+/','_',$row['name']).'_'.$row['id'].'_'.$i.'.html';
			if($i == $BNpage)
				echo '" class="paging" id="page_active">[';
			else
				echo '" class="paging">[';
			echo $i;
			echo ']</a>';
		}
	}while($row=mysql_fetch_assoc($rs));
}
 echo '
		</ul>
		</div></div>
		<div class="clr_right"><span></span></div>
	</div>
	<div class="end_about_">
		<Div class="left_end_about">
			<Div class="right_end_about">
				<Div class="middle_end_about"><span></span>
				</Div>
			</Div>
		</Div>
	</div>
</div>';
?>