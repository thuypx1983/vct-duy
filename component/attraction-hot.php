<Div class="box_hottour_all">
    <h4 class="h2_title"><a href="<?php echo urlBuild('attraction.php')?>"><?php echo @T_ATTRACTION_HOT ?></a></h4>
				<div class="padding_useful">
                    <div class="row">
					<?php
					$rs = catnewslist(CATNEWS_CTRL_SHOW|CATNEWS_CTRL_ATTRACTION,null,1);
					$cat = mysql_fetch_object($rs);
					$rs_sub = catnewslist(CATNEWS_CTRL_SHOW,(int)$cat->id,100);
					$hot = array();
					while ($row = mysql_fetch_object($rs_sub)){
						$rs_subsub = catnewslist(CATNEWS_CTRL_SHOW|CATNEWS_CTRL_HOME,(int)$row->id,100);
						while($item=mysql_fetch_object($rs_subsub)){
							$hot[] = $item;
						}
					}
					foreach($hot as $row){
					?>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <h4 class="h4_item">
                                <a href="<?php echo urlBuild('attraction-list.php',array('url'=>$row->urlrewrite)) ?>">
                                    <?php echo $row->name?>
                                </a>
                            </h4>
                        </div>
					<?php 
					}?>
					</div>
				</div>
</Div>