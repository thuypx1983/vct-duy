<?php 
	$current = 0;
	if($_GET['url']){
		$catnow = catnewsopen(@$CNid);
		$item = mysql_fetch_object(newsopen(@$NWid));
		if($item){ $catnow = catnewsopen(@$CNid,$item->id); $current = $catnow->parentid;}
		if($catnow) $current = $catnow->parentid;
	}
?>
<Div class="box_hottour_all" style="padding: 0">
    <div class="title_support">
        <?php echo T_USEFUL_INFO ?>
    </div>
    <div class="padding_tour_group_">
        <div class="content_menu_left">
				<ul id="default1">
				<?php 
				$rs = catnewslist(CATNEWS_CTRL_SHOW|CATNEWS_CTRL_USEFUL_INFO,null,1);
				$cat =  mysql_fetch_object($rs);
				$rs = catnewslist(CATNEWS_CTRL_SHOW,$cat->id,100);
				while ($row = mysql_fetch_object($rs)){
				?>
					<li id="tab_<?php echo $row->id ?>" class="box_pa_title_unselected" onmouseover="this.style.cursor='pointer'" onclick="javascript:showItem1('<?php echo $row->id?>');">
						<?php echo $row->name ?>
						<ul id="item_<?php echo $row->id ?>" class="box_pa_cambodia" style="display: none;" onmouseover="this.style.cursor='default'">
							<?php 
							$rs_sub = catnewslist(CATNEWS_CTRL_SHOW,$row->id,100);
							while ($item = mysql_fetch_object($rs_sub)){
								if(@$item){
									echo '<li class="submenu_vn_one">';
									if($catnow->id==@$item->id)
										echo '<a href="'.urlBuild('useful-information-list.php',array('url'=>@$item->urlrewrite)).'"><span>'.@$item->name.'</span></a>';
									else 
										echo '<a href="'.urlBuild('useful-information-list.php',array('url'=>@$item->urlrewrite)).'">'.@$item->name.'</a>';
									echo '</li>';
									}
								}
							?>	
						</ul>
					</li>
				<?php 
				}?>
				</ul>
			</div>
    </div>
</Div>
<script>
<?php 
if($current){
?>
showItem1('<?php echo $current ?>');
<?php }?>
</script>