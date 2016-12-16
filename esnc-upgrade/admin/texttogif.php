<?php $url=@(string)$_GET['url'];	

$string = rand(1000,1000000);

header('Content-Type: image/png',TRUE);

header('Cache-Control: no-cache',TRUE);

setcookie('scode',md5($string),0,$url);

$im     = imagecreatefrompng("images/secbg.png");

$orange = imagecolorallocate($im, 20, 100, 150);

$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;

imagestring($im, 10, $px, 20, $string, $orange);

imagepng($im);

imagedestroy($im);

?>

