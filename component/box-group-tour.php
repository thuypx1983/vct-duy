<?php 
	$current = 0;
	$catnow = catproductread(@$CPid);
	if($catnow->ctrl&CATPRODUCT_CTRL_TOUR) $current=$catnow->id;
	else $current=$catnow->parentid;
?>
<Div class="box_hottour_all" style="padding: 0">
    <div class="title_support">
        <?php echo T_GROUP_TOUR ?>
    </div>
        <div class="padding_tour_group_">
            <div class="content_menu_left">
                <ul id="default1">
                    <?php
                    $rs = catproductlist(CATPRODUCT_CTRL_SHOW|CATPRODUCT_CTRL_TOUR,null,true,null,100);
                    while ($row = mysql_fetch_object($rs)){
                        ?>
                        <li id="tab_<?php echo $row->id ?>" class="box_pa_title_unselected" onmouseover="this.style.cursor='pointer'" onclick="javascript:showItem1('<?php echo $row->id?>');">
                            <?php echo $row->name ?>
                            <ul id="item_<?php echo $row->id ?>" class="box_pa_cambodia" style="display: none;" onmouseover="this.style.cursor='default'">
                                <?php
                                $rs_sub = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$row->id,true,null,100,PRODUCT_CTRL_SHOW);
                                while ($item = mysql_fetch_object($rs_sub)){
                                    echo '<li class="submenu_vn_one">';
                                    if($catnow->id==$item->id)
                                        echo '<span>'.$item->name.'</span>';
                                    else
                                        echo '<a href="'.urlBuild('sub-tour-list.php',array('CPname'=>$row->urlrewrite,'url'=>$item->urlrewrite)).'">'.$item->name.'</a>';
                                    echo '</li>';
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