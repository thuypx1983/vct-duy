<?php
include 'securimage/securimage.php';
$url=@(string)$_GET['url'];
$img = new securimage();

$img->image_width = 120;
$img->image_height = (int)($img->image_width * 0.4);
$img->perturbation = 0;
$img->image_bg_color = new Securimage_Color("#afd446");
$img->text_color = new Securimage_Color("#2c74d5");
//$img->use_multi_text = true;
//$img->text_angle_minimum = -5;
//$img->text_angle_maximum = 5;
//$img->use_transparent_text = true;
//$img->text_transparency_percentage = 30;
$img->num_lines = 0;
$img->line_color = new Securimage_Color("#4287e3");
$img->code_length = 8;
//$img->image_signature = 'esnc.net';
//$img->signature_color = new Securimage_Color(rand(0, 64), rand(64, 128), rand(128, 255));
//$img->use_wordlist = true; 
$img->charset = 'abcdefghklmnprstuvwyz23456789';
$img->esnc_url = $url;
$img->show('images/secbg.png');
?>

