<Div class="box_hottour_all">
	<Div class="title_about_">
		<Div class="left_title_tour_">
			<Div class="right_title_tour_">
				<Div class="middle_title_tour_">
					<span></span>
				</Div>
			</Div>
		</Div>
	</Div>
	<div class="left_x_useful">
		<Div class="right_x_useful">
			<div class="ct_tourpage_">
				<div class="padding_hottour">
					<?php
					$item = productread(@$PDid);
					$name = $item->name.' ';
					echo '<form method="post" action="process.php?act=service-book" name="form_contact" onsubmit="return checkBookService(this);">';
					$tag = array(
					'{{T_SERVICE_NAME}}'=>$name,
					'{{T_YOUR_NAME}}'=>'<input type="text" class="contact_us"  name="ct_name_2" />',
					'{{T_YOUR_EMAIL}}'=>'<input type="text" class="contact_us" name="ct_email_2" />',
					'{{T_YOUR_COUNTRY}}'=>'<input class="contact_us" name="ct_country">',
					'{{T_YOUR_CITY}}'=>'<input type="text" class="contact_us" name="ct_city">',
					'{{T_YOUR_PHONE}}'=>'<input type="text" class="contact_us" name="ct_phone"/>',
					'{{T_SERVICE_START}}' => '<input type="text" class="hotel_book_checkin"  name="departdate">',
					'{{T_SUBJECT}}'=>'<input type="text" class="contact_us" name="ct_subject" />',
					'{{T_CONTENT}}'=>'<textarea class="contact_us" rows=" 6" name="ct_content_2"></textarea>',
					'{{T_SPAM}}' => '<input type="text" class="ct_spam" name="scode" />',
					'{{I_SPAM}}'=> '<img id="esnc_captcha" src="'.urlBuild(URL_ADMIN.'texttogif.php',array('url'=>URL_ROOT,'rnd'=>rand())).'" /><div id="refresh_captcha" onclick="document.getElementById(\'esnc_captcha\').src=\''.URL_ADMIN.'texttogif.php?url='.URL_ROOT.'&rnd=\'+Math.random();">'.@T_REFRESH_IMAGE.'</div><div class="clear"><span></span></div>',
					'{{T_SUBMIT}}'=>'<input type="submit" value="'.@T_SUBMIT.'" class="input_send"/>',
					'{{T_RESET}}'=>'<input type="reset" value="'.@T_RESET.'" class="input_send"/>'
					);
					echo strtr(@file_get_contents(PATH_APPLICATION.'form-book-service.htm'),$tag);
					echo '<input type="hidden" name="name" value="'.$name.'">';
					echo '</form>';
					?>
				</div>
			</div>
		</Div>
	</div>
	<div class="end_about_">
		<Div class="left_end_hottour">
			<Div class="right_end_hottour">
				<Div class="middle_end_hottour"><span></span>
				</Div>
			</Div>
		</Div>
	</div>
	
</Div>