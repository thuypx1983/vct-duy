<div class="b_customer_2_all">
	<div class="b_car_list_all">
		<div class="b_contact_us">
			<form method="post" class="form_contact" onsubmit="return checkReviewForm(this);" action="process.php?act=post-comment">
			<?php 
				if(isset($_GET['act'])){
					$act = @$_GET['act']; 
					if($act=='spam') @readfile(PATH_APPLICATION.'msg-spam.htm');
				}
				else {
				$PDid = (int)$_GET['PDid'];
				$item = productread($PDid);
				$tag = array(
					'{{T_PRODUCT_NAME}}' => $item->name,
					'{{T_NAME}}' => '<input type="text" size="45" name="name" />',
					'{{T_CONTENT}}' => '<textarea cols="51" rows="6" name="content"></textarea>',
					'{{T_SPAM}}' => '<input type="text" name="scode" class="input_contact_2">',
					'{{I_SPAM}}'=> '<img id="esnc_captcha" src="'.urlBuild(URL_ADMIN.'texttogif.php',array('url'=>URL_ROOT,'rnd'=>rand())).'" /><div id="refresh_captcha" onclick="document.getElementById(\'esnc_captcha\').src=\''.URL_ADMIN.'texttogif.php?url='.URL_ROOT.'&rnd=\'+Math.random();">'.@T_REFRESH_IMAGE.'</div><div class="clear"><span></span></div>',
					'{{T_SUBMIT}}' =>'<input type="submit" value="'.@T_SUBMIT.'" class="input_b_contact" />',
					'{{T_RESET}}' =>'<input type="reset"  value="'.@T_RESET.'" class="input_b_contact" />',
				); 	
				echo strtr(@file_get_contents(PATH_APPLICATION.'form-tour-feedback.htm'),$tag);
				}
			?>	
			<input type="hidden" name="PDid" value="<?php echo $PDid?>">
			</form>
		</div>
		<Div class="clear_right"></Div>
	</div>
</div>
