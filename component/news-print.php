<?php 
	$item = mysql_fetch_object(newsopen(@$NWid));
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
			<Div class="title_tour_dt">
				<h2><?php echo $item->name ?></h2>
			</Div>
			<Div class="ct_tour_list_page_">
				<Div class="top_tour_dt">
					<div class="left_ser_dt">
						<?php htmlview(URL_NEWS_IMG1,$item->img1);?>
					</div>
					<Div class="right_ser_dt_print">
						<Div class="summart_ser">
							<?php echo @$item->summary?>
						</Div>
						<table class="opition_tour" width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td width="42%"><a class="print_tour" href="javascript:Toprint();"><?php echo @T_PRIN?></a></td>
						  </tr>
						</table>
					</Div>
					<Div class="clear_left"></Div>
				</Div>
				<Div class="data_service">
				<?php echo @$item->content ?>
				</Div>
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