<?php
function resize_image($source,$imagename,$modwidth = 500)
{

// Them vao inc/common cho anh mo ta cua news va product
// photo-upload.php  cho thu vien anh cua sp
// define('IMAGE_SIZE',600);
//define('IMAGE_SIZE_UPLOAD',600); trong file config.php
//item cua san pham
              $imagepath = $imagename;
              $save = $source.$imagename;
              $file = $source.$imagename;
              list($width, $height) = getimagesize($file) ;                                                 
              //$modwidth = 100;
			  $ext = strstr($imagepath,'.');
              if (($width > $modwidth) && $ext != '.gif') {	  
			  $diff = $width / $modwidth;                                                     
              $modheight = $height / $diff; 
              $tn = imagecreatetruecolor($modwidth, $modheight) ;
			  
			  if ($ext=='.jpg' || $ext=='.jpeg'){
              $image = imagecreatefromjpeg($file) ;
			  imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;                                    
              imagejpeg($tn, $save, 100) ;
			  }
			  if ($ext=='.png'){
              $image = imagecreatefrompng($file) ;
			  imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;                                    
              imagepng($tn, $save) ;
			  }
			  //if ($ext=='.bmp'){$image = imagecreatefromwbmp($file) ; imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; imagejpeg($tn, $save, 100) ;}
			  }
return true;
}
?>