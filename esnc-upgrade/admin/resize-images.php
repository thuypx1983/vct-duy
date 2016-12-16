<?php
function resize_image($source,$imagename,$limit)
{
// Them vao inc/common cho anh mo ta cua news va product
// photo-upload.php  cho thu vien anh cua sp
// define('IMAGE_SIZE',600);
//define('IMAGE_SIZE_UPLOAD',600); trong file config.php
//item cua san pham
			if(!($limit<=0)) {
              $imagepath = $imagename;
              $save = $source.$imagename;
              $file = $source.$imagename;
              list($width, $height) = getimagesize($file) ;                                                 
              //$limit = 100;
			  $ext = strstr($imagepath,'.');
			  $width1 = $width;
			  if($width<$height) {  $width1 = $height;}
              if (($width1 > $limit) && $ext != '.gif') {	  
			  $diff = $width1 / $limit;                                                     
              $modheight = $height / $diff; 
              $tn = imagecreatetruecolor($limit, $modheight) ;
			  
			  if ($ext=='.jpg' || $ext=='.jpeg'){
              $image = imagecreatefromjpeg($file) ;
			  imagecopyresampled($tn, $image, 0, 0, 0, 0, $limit, $modheight, $width, $height) ;                                    
              imagejpeg($tn, $save);
			  }
			  if ($ext=='.png'){
              $image = imagecreatefrompng($file) ;
			  imagecopyresampled($tn, $image, 0, 0, 0, 0, $limit, $modheight, $width, $height) ;                                    
              imagepng($tn, $save) ;
			  }	  
			  //if ($ext=='.bmp'){$image = imagecreatefromwbmp($file) ; imagecopyresampled($tn, $image, 0, 0, 0, 0, $limit, $modheight, $width, $height) ; imagejpeg($tn, $save, 100) ;}
			  }
			}
return true;
}
?>