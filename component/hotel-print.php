<?php 
	$item = productread(@$PDid);
	$cat = catproductread(@$CPid,$item->id);
	$cf = productcf($item->id,'`a`.`cf0`,`a`.`cf1`');
?>
<Div class="logo_waytovietnam_print_">
	<?php 
	$rs = bannerlist(BANNER_CTRL_SHOW|BANNER_CTRL_LOGO,null,1);
	$banner = mysql_fetch_object($rs);
	if($banner)
		bannershow($banner);
	?>
</Div>
<Div class="box_hottour_all">
	<div class="ct_tourpage_print">
	<div class="padding_hottour">
		<div class="title_tour_dt">
			<h2><?php echo $item->name ?></h2>
		</div>
		<Div class="ct_tour_list_page_">
			<Div class="top_tour_dt">
				<div class="left_tour_dt">
					<?php 
						if($item->img2) htmlview(URL_PRODUCT_IMG2,$item->img2);
						else if($item->img1) htmlview(URL_PRODUCT_IMG1,$item->img1);
					?>
				</div>
				<Div class="right_tour_dt">
					<table class="opition_tour" width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="14%"><a class="print_tour" href="javascript:Toprint();"><?php echo @T_PRIN ?></a></td>
					  </tr>
					</table>
					<table class="infor_tour" width="100%" border="0" cellspacing="0" cellpadding="2">
					  <?php /*//201208 <tr>
						<td width="66"><?php echo @T_FROM_PRICE ?></td>
						<td width="487" class="price_tour__">: From&nbsp;$<?php echo $item->price; if(@$item->warranty) echo ' to $'.$item->warranty ?></td>
					  </tr> 201208*/?>
					  <?php 
						if(@$item->unit)
							 echo '
							  <tr>
								<td>'.@T_ADDRESS.'</td>
								<td>: '.$item->unit.'</td>
							  </tr>';
						if(@$item->model)
							 echo '
							  <tr>
								<td>'.@T_CITY.'</td>
								<td>: '.$item->model.'</td>
							  </tr>';
						if(@$item->country)
							 echo '
							  <tr>
								<td>'.@T_COUNTRY.'</td>
								<td>: '.$item->country.'</td>
							  </tr>';
					  ?>
					</table>
				</Div>
				<Div class="clear_left"></Div>
				<Div class="summart_tour">
					<?php echo $item->summary ?>
				</Div>
			</Div>
			<Div class="data_tour">
				<h4>
				<?php echo @T_HOTEL_DETAIL ?>
				</h4><br />
				<?php echo $item->detail ?>
			</Div>
			<div class="clear_left"></div>
		</Div>
	</div>
</div>
</Div>
<div id="footer">
<?php @readfile(PATH_APPLICATION.'footer.htm')?>
</div>
<script language = "javascript">
function Toprint() {
window.print();
}
</script>