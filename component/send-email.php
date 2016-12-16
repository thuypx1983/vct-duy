<form action="process.php?act=send-email" method="post" name="form_contact" onSubmit="return checkSendEmail(this);">
<div class="b_customer_2_all">
	<div class="b_car_list_all">
		<div class="b_contact_us">
			<?php 
				if(isset($_GET['act'])){
					$act = @$_GET['act']; 
					if($act=='spam') @readfile(PATH_APPLICATION.'msg-spam.htm');
					else if($act=='send-email-ok') @readfile(PATH_APPLICATION.'msg-send-email-ok.htm');
				}
				else {
				$name = @$_GET['name'];
				$tag = array(
					'{{T_ITEM_NAME}}' => $name,
					'{{T_YOUR_NAME}}' => '<input type="text" class="input_contact_2" name="your-name">',
					'{{T_YOUR_EMAIL}}' => '<input type="text" name="send_email_2" class="input_contact_2">',
					'{{T_TO_EMAIL}}' => '<input type="text" name="send_email_1" class="input_contact_2">',
					'{{T_CC_EMAIL}}' => '<input type="text" class="input_contact_2" name="send_email_cc">',
					'{{T_CONTENT}}' => '<textarea name="ct_content_2" class="text_content_contact"></textarea>',
					'{{T_SPAM}}' => '<input type="text" name="scode" class="input_contact_2">',
					'{{I_SPAM}}'=> '<img id="esnc_captcha" src="'.urlBuild(URL_ADMIN.'texttogif.php',array('url'=>URL_ROOT,'rnd'=>rand())).'" /><div id="refresh_captcha" onclick="document.getElementById(\'esnc_captcha\').src=\''.URL_ADMIN.'texttogif.php?url='.URL_ROOT.'&rnd=\'+Math.random();">'.@T_REFRESH_IMAGE.'</div><div class="clear"><span></span></div>',
					'{{T_SUBMIT}}' =>'<input type="submit" value="'.@T_SUBMIT.'" class="input_b_contact" />',
					'{{T_RESET}}' =>'<input type="reset"  value="'.@T_RESET.'" class="input_b_contact" />',
					
				);
				echo strtr(@file_get_contents(PATH_APPLICATION.'form-send-email.htm'),$tag);
				echo '<input type="hidden" name="link" value="'.$_GET['link'].'">';
				}
		?>		
		</div>
		<Div class="clear_right"></Div>
	</div>
</div>
</form>
</body>
