<?php 
if($row->ctrl&CATPRODUCT_CTRL_COMBODIA){
	?>
    <li class="dropdown li_dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $row->name?> <span class="caret"></span></a>
        <ul class="dropdown-menu menu_tour_ul_0" role="menu">
            <li role="presentation" class="dropdown-header">
                <a id="menu1" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="<?php echo urlBuild('tour-list.php',array('url'=>$row->urlrewrite)) ?>"><span><?php echo @T_TOUR_IN.' '.$row->name; ?><span class="caret"></span></a></li>
                <?php
                $rs_tour = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$row->id,true,null,100);
                if(mysql_num_rows($rs_tour)>0){
                    ?>
                            <?php
                            while ($subcat = mysql_fetch_object($rs_tour)){
                                $href2 = urlBuild('sub-tour-list.php',array('CPname'=>$row->urlrewrite,'url'=>$subcat->urlrewrite));
                                ?>
                        <li role="presentation" class="li_sub">
                                    <a href="<?php echo $href2 ?>"><?php echo $subcat->name ?></a>
                                </li>
                            <?php
                            }
                            ?>

                <?php } ?>
            <?php
            $rs_hotel = catproductlist(CATPRODUCT_CTRL_SHOW|CATPRODUCT_CTRL_HOTEL|CATPRODUCT_CTRL_COMBODIA,null,true,null,100);
            if($hotel = mysql_fetch_object($rs_hotel)){
                ?>
                <li role="presentation">
                    <a href="<?php echo urlBuild('hotel.php').'#'.$hotel->id?>"><span><?php echo @T_HOTEL_IN.' '.$hotel->name; ?><span class="caret"></span></a></li>
                    <?php
                    $rs_sub_hotel = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$hotel->id,true,null,100);
                    if(mysql_num_rows($rs_sub_hotel)>0){
                        ?>
                                <?php
                                while ($subcathotel = mysql_fetch_object($rs_sub_hotel)){
                                    echo '
								<li role="presentation" class="li_sub">
									<a href="'.urlBuild('hotel-list.php',array('url'=>$subcathotel->urlrewrite)).'">'.$subcathotel->name.'</a>
								</li>';
                                }
                                ?>
                    <?php } ?>
            <?php
            }
            $rs_useful = catnewslist(CATNEWS_CTRL_SHOW|CATNEWS_CTRL_USEFUL_INFO,null,1);
            $catuseful = mysql_fetch_object($rs_useful);
            $rs_useful = catnewslist(CATNEWS_CTRL_SHOW,(int)$catuseful->id,100);
            $item = '';
            while ($temp = mysql_fetch_object($rs_useful))
                if($temp->ctrl&CATNEWS_CTRL_COMBODIA){
                    $item = $temp;
                    break;
                }
            if($item){
                echo '
				<li>
					<a href="'.urlBuild('useful-information.php').'#'.$item->id.'"><span>'.@T_USEFUL_INFO_IN.' '.$item->name.'</span></a>
				</li>';
            }
            ?>
        </ul>
	</li>
	<?php 
	}
?>