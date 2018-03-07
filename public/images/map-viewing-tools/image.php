<?php
$font = 16;
$string = 'z:' . $_GET['z'] . 'x:' . $_GET['x'] . 'y:' . $_GET['y'];
$im = imagecreatefrompng(getcwd() . '/grid.png');
imagesavealpha($im, true);
imagealphablending($im, false);
$blue = imagecolorallocate($im, 0, 0, 255);
$fontType = getcwd() . '/Roboto-Regular.ttf';
imagettftext($im, $font, 0, 3, 128, $blue, $fontType, $string);
header("Content-type: image/png");
imagepng($im);
imagedestroy($im);