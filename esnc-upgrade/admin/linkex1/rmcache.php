<?php
require '../config.php';
passthru('rm -f '.PATH_DEBUG.'*.htm');
$ff = glob(PATH_DEBUG.'*.*');
foreach($ff as $f) unlink($f);
passthru('rm -f '.PATH_CACHE.'*.htm');
passthru('rm -f '.PATH_CACHE.'*.bin');
passthru('rm -f '.PATH_CACHE.'*.js');
$ff = glob(PATH_CACHE.'*.*');
foreach($ff as $f) unlink($f);
$ff = glob(PATH_ESNC.'*.*');
foreach($ff as $f) touch($f,1000);
?>