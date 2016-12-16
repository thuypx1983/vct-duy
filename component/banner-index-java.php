<?php 
$rs = productlist(0,4,PRODUCT_CTRL_SHOW|PRODUCT_CTRL_SLIDE,null,PRODUCT_TYPE_TOUR);
$arr = array();
while ($temp = mysql_fetch_object($rs)) {
	$read = productread($temp->id);
	$arr[] = $read;
}
?>
<script type="text/javascript" src="js/mootools.js"></script>
<script type="text/javascript" src="js/rokstories.js"></script>
<link href="images/rokstories.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
var RokStoriesImage = {};
	RokStoriesImage['rokstories-2'] = [];
	<?php 
	foreach ($arr as $row){
	?>
	RokStoriesImage['rokstories-2'].push('<?php echo URL_PRODUCT_IMG2.$row->img2 ?>');
	<?php }?>

window.addEvent('domready', function() {
	new RokStories('rokstories-2', {
		'id': 2,
		'startElement': 1,
		'thumbsOpacity': 0.6,
		'mousetype': 'click)."',
		'autorun': 1,
		'delay': 5000,
		'startWidth': 410,
		'layout': '$layout',
		'linkedImgs': 0,
		'showThumbs': 0,
		'fixedThumb': 1
		});
});
</script>
<Div class="banner_java_all java_b_ie6">
	<div class="padding_banner_java">
		<div class="feature-block" id="rokstories-2">
			<Div class="left_banner_java">
				<div class="image-container feature-pad">
					<div class="image-full img_show_active" style="height: 200px; width: 410px;"></div>
					<div class="image-small" style="width: 410px;">
						<?php 
							foreach ($arr as $row)
								echo '<img title="'.($row->alt2?$row->alt2:$row->name).'" class="feature-sub img_noactive" src="'.URL_PRODUCT_IMG2.$row->img2.'" style="visibility: visible; opacity: 0.3;">'
						?>
					</div>
				</div>
			</div>
			<div class="right_banner_java">
				<div class="desc-container">
				<?php 
				foreach ($arr as $row){
				?>
					<div class="description" style="visibility: hidden; opacity: 0;">
						<Div class="title_tour_java">
							<h4>
							<?php 
								echo $row->name; 
								if(@$row->quantity) echo ' - '.$row->quantity.' '.@T_NIGHTS;
								//201208 if(@$row->price) echo ' <span>From $'.$row->price.'</span>';
								/*201208 if($row->warranty){ ?><Span><?php echo ' to $'.$row->warranty ?></Span><?php }  201208*/?>
							</h4>
						</Div>
						<div class="text_tour_java">
							<?php
								if(strlen(strip_tags($row->summary)))
								 	echo strleft($row->summary,250,'...');
								 else if(strlen(strip_tags($row->detail)))
								 	echo strleft($row->detail,250,'...')
							?>
						</div>
						<div class="input_book_java">
							<a href="<?php echo urlBuild('tour-detail.php',array('CPname'=>$row->caturlrewrite,'url'=>$row->urlrewrite))?>" ><?php echo @T_VIEW_MORE ?></a>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
		<Div class="clear_both"></Div>
	</div>
</div>
