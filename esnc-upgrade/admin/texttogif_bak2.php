<?php /* * vu.tran edit captcha * */


function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
}

$url=@(string)$_GET['url'];	

//$string = rand(1000,1000000);

$string = generateCode('6');

header('Content-Type: image/png',TRUE);

header('Cache-Control: no-cache',TRUE);

setcookie('scode',md5($string),0,$url);
$width='120';
$height='40';
$font = 'monofont.ttf';
$font_size = $height * 0.9;
      $image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');

      /* set the colours */
      $background_color = imagecolorallocate($image, 255, 255, 255);
      $text_color = imagecolorallocate($image, 20, 40, 100);
      $noise_color = imagecolorallocate($image, 100, 120, 180);

      /* create textbox and add text */
      $textbox = imagettfbbox($font_size, 0, $font, $string) or die('Error in imagettfbbox function');
      $x = ($width - $textbox[4])/2;
      $y = ($height - $textbox[5])/2;
      $d = -1;
      imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $string) or die('Error in imagettftext function');
      imagettftext(
	    $image, $font_size, 0, $x + $d, $y + $d, $noise_color, $font , $string
      ) or die('Error in imagettftext function');
      imagettftext(
	    $image, $font_size, 0, $x + 2 * $d + 1, $y + 2 * $d + 1, $noise_color, $font , $string
      ) or die('Error in imagettftext function');
     

      /* mix in background dots */
      /*for( $i=0; $i<($width*$height)/10; $i++ ) { 
            imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $background_color);		 
      }*/

      /* mix in text and noise dots */
      for( $i=0; $i<($width*$height)/25; $i++ ) { 
        // imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);		 
	 	imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $text_color);		 
      }

      /* rotate a bit to add fuzziness */
      $image = imagerotate($image, 1, $background_color);
imagejpeg($image);
imagedestroy($image);
?>