<?php
$rs = catnewslist(CATNEWS_CTRL_SHOW|CATNEWS_CTRL_TESTIMONIAL,null,1);
$cat = mysql_fetch_object($rs);
$page = isset($_GET['page'])?(int)$_GET['page']:1;
$rs = newspagelist($page,N_TESTIMONIAL_PER_PAGE,$pagecount,null,(int)$cat->id,NEWS_CTRL_SHOW);
$count = 0;
?>
<div class="box-whyus">
    <div class="breadcrumbs clearfix">
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo URL_BASE ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_HOME ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <span itemprop="title"><?php echo $cat->name?></span>
        </div>
    </div>
    <div class="box-title">
        <div class="box-outer-2 box-right">
            <h2 class="h2_category"><?php echo $cat->name ?></h2>
					<Div class="content_about_index">
						<?php
						 if($pagecount>1){?>
							<Div class="page_next_tour_" align="right">
								<form method="get" action="testimonial.php">
								<?php
									if($page<=$pagecount&&$page>1)
										echo '<A href="'.urlBuild('testimonial.php',array('page'=>$page-1)).'"><<</A>';
									else if($page==1)	echo '<A href="'.urlBuild('testimonial.php',array('page'=>$pagecount)).'"><<</A>';
									echo @T_SELECT_PAGE;
								?>	
									<select name="page" class="page_next_tour_" onchange="this.form.submit();return true;">
										<?php 
											for($i=1;$i<=$pagecount;$i++){
												echo '<option '.($page==$i?'selected="selected"':'').'value="'.$i.'">'.$i.'</option>';
											}
										?>
									</select>
								<?php 
									if($page<$pagecount)
										echo '<A href="'.urlBuild('testimonial.php',array('page'=>$page+1)).'">>></A>';
									else if($page==$pagecount)
										echo '<A href="'.urlBuild('testimonial.php',array('page'=>1)).'">>></A>';
								?>
								</form>
							</Div>
						<?php } ?>
						<table border="0" cellspacing="0" cellpadding="5">
						<?php
						$count=0;
						while ($row = mysql_fetch_object($rs)){
							$count++;
						?>
						  <tr>
							<td colspan="2" <?php echo ($count==1?'':'class="tetimonial_title"')?>><span id="<?php echo $row->id ?>" class="title_test"><?php echo $row->name ?></span></td>
						</tr>
						  <tr>
							<?php if($row->tag){ ?><td width="33%"><span class="email_cus"><?php echo @T_EMAIL ?>:</span> <span class="email_cus2"><?php echo $row->tag?></span></td> <?php }?>
						    <?php if($row->creator){?><td width="67%"><span class="email_cus"><?php echo @T_NATIONAL ?>:</span> <span class="email_cus2"><?php echo $row->creator?></span></td><?php } ?>
						  </tr>
						  <tr>
							<td colspan="2"><?php echo $row->summary ?></td>
						  </tr>
						<?php } ?>
						</table>
						<?php
						 if($pagecount>1){?>
							<Div class="page_next_tour_" align="right">
								<form method="get" action="testimonial.php">
								<?php
									if($page<=$pagecount&&$page>1)
										echo '<A href="'.urlBuild('testimonial.php',array('page'=>$page-1)).'"><<</A>';
									else if($page==1)	echo '<A href="'.urlBuild('testimonial.php',array('page'=>$pagecount)).'"><<</A>';
									echo @T_SELECT_PAGE;
								?>	
									<select name="page" class="page_next_tour_" onchange="this.form.submit();return true;">
										<?php 
											for($i=1;$i<=$pagecount;$i++){
												echo '<option '.($page==$i?'selected="selected"':'').'value="'.$i.'">'.$i.'</option>';
											}
										?>
									</select>
								<?php 
									if($page<$pagecount)
										echo '<A href="'.urlBuild('testimonial.php',array('page'=>$page+1)).'">>></A>';
									else if($page==$pagecount)
										echo '<A href="'.urlBuild('testimonial.php',array('page'=>1)).'">>></A>';
								?>
								</form>
							</Div>
						<?php } ?>
						<Div class="content_about_index">
							<form method="post" action="process.php?act=testimonial" name="form_contact" onsubmit="return checkTestimonial(this);">
							<?php 
							$tag = array(
								'{{T_YOUR_NAME}}'=>'<input type="text" class="contact_us"  name="ct_name_2" />',
								'{{T_YOUR_EMAIL}}'=>'<input type="text" class="contact_us" name="ct_email_2" />',
								'{{T_YOUR_COUNTRY}}'=>'<input type="text" class="contact_us" name="ct_country">',
								'{{T_YOUR_PHONE}}'=>'<input type="text" class="contact_us" name="ct_phone"/>',
								'{{T_SUBJECT}}'=>'<input type="text" class="contact_us" name="ct_subject" />',
								'{{T_CONTENT}}'=>'<textarea class="text_contact_us" name="ct_content_2"></textarea>',
								'{{T_SPAM}}' => '<input type="text" class="ct_spam" name="scode" />',
								'{{I_SPAM}}'=> '<img id="esnc_captcha" src="'.urlBuild(URL_ADMIN.'texttogif.php',array('url'=>URL_ROOT,'rnd'=>rand())).'" /><div id="refresh_captcha" onclick="document.getElementById(\'esnc_captcha\').src=\''.URL_ADMIN.'texttogif.php?url='.URL_ROOT.'&rnd=\'+Math.random();">'.@T_REFRESH_IMAGE.'</div><div class="clear"><span></span></div>',
								'{{T_SUBMIT}}'=>'<input type="submit" value="'.@T_SUBMIT.'" class="input_send"/>',
								'{{T_RESET}}'=>'<input type="reset" value="'.@T_RESET.'" class="input_send"/>'
								);
							echo strtr(@file_get_contents(PATH_APPLICATION.'form-testimonial.htm'),$tag);
							?>
							</form>							
						</Div>
					</Div>
</Div>
</Div>
</Div>