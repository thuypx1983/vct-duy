<div id="main_menu">
    <?php
    ob_start();
    ?>
    <ul class="sf-menu superfish">
        <li class="li_main_menu"><a class="a_main_menu" href="<?php echo urlBuild('index.php')?>"><?php echo T_HOME ?></a></li>
		        <li class="li_main_menu">
            <a class="a_main_menu" href="/tours/"><?php echo T_VIETNAM_TOUR?></a>
            <div class="sub_menu clearfix sub_menu_bottom">
                <?php
                $rs = catproductlist(CATPRODUCT_CTRL_SHOW|CATPRODUCT_CTRL_TOUR,null,true,null,100);
                while($row = mysql_fetch_object($rs)){
                    $rs2 = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$row->id,true,null,100,PRODUCT_CTRL_SHOW);
                    ?>
                    <div class="sub_menu_col">
                        <h4 class="h4_sub_menu">
                            <a href="<?php echo urlBuild('tour-list.php',array('url'=>$row->urlrewrite)) ?>"><?php echo $row->name ?></a>
                        </h4>
                        <?php while($item = mysql_fetch_object($rs2)){?>
                            <div class="sub_menu_cat">
                                <a href="<?php echo urlBuild('sub-tour-list.php',array('CPname'=>$row->urlrewrite,'url'=>$item->urlrewrite))?>" class="tback"><?php echo $item->name?></a>
                            </div>
                        <?php
                        }?>
                    </div>
                <?php
                }
                ?>
            </div>
        </li>
        <li class="li_main_menu"><a class="a_main_menu" href="<?php echo urlBuild('service.php')?>"><?php echo T_SERVICE?></a></li>
        <li class="li_main_menu"><a class="a_main_menu" href="<?php echo urlBuild('useful-information.php')?>"><?php echo T_USEFUL_INFO?></a></li>
        <li class="li_main_menu">
            <a class="a_main_menu" href="<?php echo urlBuild('term-condition.php') ?>"><?php echo @T_TERM_CONDITION ?></a>
        </li>
        
        <?php
        $rs = catnewslist(CATNEWS_CTRL_SHOW|CATNEWS_CTRL_INFO,NULL,1);
        if($catinfo = mysql_fetch_object($rs)){
        ?>
        <li class="li_main_menu">
            <a  href="#" class="a_main_menu"><?php echo $catinfo->name ?></a>
            <div class="sub_menu clearfix sub_menu_bottom">
                <div class="sub_menu_col">
                <?php
                $rs = newslist((int)$catinfo->id,NEWS_CTRL_SHOW,100,0);
                while($row = mysql_fetch_object($rs)){
                    echo '
                    <div class="sub_menu_cat">
                        <a href="'.urlBuild('info.php',array('CNname'=>$row->caturlrewrite,'url'=>$row->urlrewrite)).'"><span>'.$row->name.'</span></a>
                    </div>';
                }
                ?>
                </div>
            </div>
        </li>
		<li class="li_main_menu"><a class="a_main_menu" href="<?php echo urlBuild('contact-us.php')?>"><?php echo T_CONTACT?></a></li>
        <?php }?>
    </ul>
    <?php $menu = ob_get_contents();
    ob_end_clean();
    echo $menu;
    ?>
</div>
<nav id="menu" class="mm-menu mm-vertical mm-offcanvas mm-front mm-hasfooter">
    <?php echo $menu ?>
</nav>
<script type="text/javascript">
    jQuery(function(){
        jQuery('.li_main_menu').hover(function() {
            jQuery(this).addClass('lihover');
        }, function() {
            jQuery(this).removeClass('lihover');
        });
    });
</script>