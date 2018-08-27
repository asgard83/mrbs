<?php
session_start();
$string = '';
for ($i = 0; $i < 5; $i++)
{
	$string .= chr(rand(97, 122));
}
$_SESSION['codex_reg'] = $string;
$dir = 'fonts/';
$image = imagecreatetruecolor(180, 50);
$font = "Molot.otf";
$num2 = rand(1,2);
if($num2==1)
{
	$color = imagecolorallocate($image, 113, 193, 217);// color
}
else
{
	$color = imagecolorallocate($image, 163, 197, 82);// color
}
// background transparant
imagesavealpha($image, true);
$trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
imagefill($image, 0, 0, $trans_colour);
$red = imagecolorallocate($image, 255, 0, 0);
imagefilledellipse($image, 400, 300, 400, 300, $red);

// background color white
/*$white = imagecolorallocate($image, 231, 235, 238); 
imagefilledrectangle($image,0,0,399,99,$white);*/

imagettftext ($image, 30, 0, 10, 40, $color, $dir.$font, $_SESSION['codex_reg']);
header("Content-type: image/png");
imagepng($image);
?>