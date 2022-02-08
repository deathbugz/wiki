<?php

function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1)
{
    /* this way it works well only for orthogonal lines
    imagesetthickness($image, $thick);
    return imageline($image, $x1, $y1, $x2, $y2, $color);
    */
    if ($thick == 1) {
        return imageline($image, $x1, $y1, $x2, $y2, $color);
    }
    $t = $thick / 2 - 0.5;
    if ($x1 == $x2 || $y1 == $y2) {
        return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
    }
    $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
    $a = $t / sqrt(1 + pow($k, 2));
    $points = array(
        round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
        round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
        round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
        round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
    );
    imagefilledpolygon($image, $points, 4, $color);
    return imagepolygon($image, $points, 4, $color);
}

error_reporting(E_ALL); 
// Report all PHP errors 
error_reporting(0); 
#echo '<pre>';  print_r($_SERVER); 
$text = trim(ucfirst(next(explode('/logo/',trim($_SERVER[SCRIPT_URL])))));

list($t1, $t2, $t3, $t4) = explode(' ',$text);

$tu = ucfirst(substr($t1,0,6).' '.substr($t2,0,1).substr($t3,0,1));
$tb = substr($text,0,40);

// Create a 100*30 image
$im = imagecreate(380, 80);

// White background and blue text
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$red = imagecolorallocate($im, 248, 5, 56);
$grey = imagecolorallocate($im, 153, 153, 153);
$grey2 = imagecolorallocate($im, 220, 220, 220);

$font1 = 'lib/'.'TitilliumWeb-Black.ttf';
$font2 = 'lib/'.'Roboto-Black.ttf';
$cat = 'lib/cat_resize2.png';

$im2 = imagecreatefrompng($cat);
#list($width, $height) = getimagesize($im2);
#$percent = 0.2;
#$new_width = $width * $percent;
#$new_height = $height * $percent;
#imagecopyresampled($im, $im2, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

imagecopy($im, $im2, 2, 0, 0, 0, 69, 80);

// Add some shadow to the text
imagelinethick($im, 80,55, 370,55, $grey2, 5);
#imageline($im, 73,74, 250,74, $grey);
imagettftext($im, 45, 0, 73, 47, $red, $font1, $tu);
imagettftext($im, 11, 0, 78, 74, $grey, $font2, $tb);

// Output the image
header('Content-type: image/png');

imagepng($im);
imagedestroy($im);
?>
