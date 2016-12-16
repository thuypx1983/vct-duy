<Div class="box_hottour_all" style="padding: 0">
	<div class="title_support">
		<?php echo @T_GROUP_SERVICE ?>
	</Div>
<div class="padding_tour_group_">
            <div class="content_menu_left">
				<ul class="box_pa_cambodia" >
				<?php 
				$catnow = catproductread(@$CPid);
				$rs = catproductlist(CATPRODUCT_CTRL_SHOW|CATPRODUCT_CTRL_SERVICE,null,false,null,1);
				$cat = mysql_fetch_object($rs);
				$rs = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$cat->id,false,null,100);
				while ($row = mysql_fetch_object($rs)){
					if($catnow->id==$row->id)
						echo '<li class="service_list_menu"><Span>'.$row->name.'</Span></li>';
					else 
						echo '<li class="service_list_menu"><a href="'.urlBuild('service-list.php',array('url'=>$row->urlrewrite)).'">'.$row->name.'</a></li>';
				}
				?>
				</ul>
			</div>
		</div>
	</div>
</Div>

 