<style>
	.link_exchange_list{border-bottom:1px solid #666; padding-bottom:10px;}
</style>
<?php 
$rs = catbannerlist(CATBANNER_CTRL_LINK|CATBANNER_CTRL_SHOW);
$a_cat = array();
while($a_cat[]=mysql_fetch_assoc($rs));
array_pop($a_cat);
if($a_cat){
?>
<Div class="b_about_all">
	<Div class="title_about_">
		<Div class="left_title_about">
			<Div class="right_title_about">
				<Div class="middle_title_tourist">
					<h2><?php echo @T_GROUP_LINK_EX ?></h2>
				</Div>
			</Div>
		</Div>
	</Div>
	<div class="ct_about_">
		<div class="arrow_back_2"></div>
		<div class="padding_tour_group_">
			<div class="content_menu_left">
				<ul class="box_pa_cambodia" >
				<?php 
				foreach($a_cat as $row){
					echo '<li class="service_list_menu">';
					echo '<a  class="tblue tbold s11 tour_group_list" href="';
					echo urlBuild('link-exchange.php',array('CBname'=>$row['name'],'CBid'=>$row['id']));
					echo '">';
					echo $row['name'];
					echo '</a>';
					$pgcount = catbannerpage($row['id'],BANNER_PAGESIZE_LINKEXCHANGE);
					for($i = 2;$i <= $pgcount;++$i){
						echo '&nbsp;&nbsp;<a  href="';
						echo urlBuild('link-exchange.php',array('CBname'=>$row['name'],'CBid'=>$row['id'],'BNpage'=>$i));
						if($i == $BNpage)
							echo '" class="paging" id="page_active">[';
						else
							echo '" class="paging">[';
						echo $i;
						echo ']</a>';
					}
					echo '</li>';
				}
				?>
				</ul>
			</div>
		</div>
	</div>
	<div class="end_about_">
		<Div class="left_end_about">
			<Div class="right_end_about">
				<Div class="middle_end_about"><span></span>
				</Div>
			</Div>
		</Div>
	</div>
</Div>
<?php }?>