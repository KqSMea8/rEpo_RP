<?php

	function html2rgb($color){ 
		if ($color[0] == '#')        $color = substr($color, 1);    if (strlen($color) == 6)        list($r, $g, $b) = array($color[0].$color[1],                                 $color[2].$color[3],                                 $color[4].$color[5]);    elseif (strlen($color) == 3)        list($r, $g, $b) = array($color[0], $color[1], $color[2]);    else        return false;    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);    return array($r, $g, $b);
	}
	#$arry = html2rgb('#c8b935');	echo '<pre>';print_r($arry);exit;


	$v1 = 30;
	$v2 = 10;
	$v3 = 25;
	$v4 = 15;
	$v5 = 20;	

	$image = imagecreate(400, 400);
	
	// Color settings
	$mainbg = imagecolorallocate($image, 239, 239, 239);
	
	$orange = imagecolorallocate($image, 249, 126, 17);
	$orange2 = imagecolorallocate($image, 167, 81, 5);
	
	$blue = imagecolorallocate($image, 43, 128, 255);
	$blue2 = imagecolorallocate($image, 0, 69, 172);
	
	$green = imagecolorallocate($image, 99, 235, 157);
	$green2 = imagecolorallocate($image, 19, 143, 72);
	
	$yellow = imagecolorallocate($image, 200, 185, 53);
	$yellow2 = imagecolorallocate($image, 215, 215, 0);

	$new = imagecolorallocate($image, 195, 204, 56);
	$new2 = imagecolorallocate($image, 215, 215, 0);

	$black = imagecolorallocate($image, 102, 102, 102);
	
	// Segments settings
	//$value = "This is a information for top";
	$value_a = $v1;
	$value_b = $v2;
	$value_c = $v3;
	$value_d = $v4;
	$value_e = $v5;
	// Curve settings
	$curve1 = round(360*($value_a/100));
	$curve2 = round(360*($value_b/100));
	$curve3 = round(360*($value_c/100));
	$curve4 = round(360*($value_d/100));
	$curve5 = round(360*($value_e/100));

	// Data message for top
	/*imagefilledrectangle($image, 0, 0, 0+$value, 0, $orange);
	imagestring($image, 50, 100, 20, $value, $black);*/
	
	// Data display in rectangles
	imagefilledrectangle($image, 10, 10, 10+$value_a, 30, $orange);
	imagestring($image, 3, 15+$value_a, 13, 'Google: '.$value_a.'%', $black);
	
	imagefilledrectangle($image, 10, 40, 10+$value_b, 60, $blue);
	imagestring($image, 3, 15+$value_b, 43, 'Yahoo: '.$value_b.'%', $black);
	
	imagefilledrectangle($image, 10, 70, 10+$value_c, 90, $green);
	imagestring($image, 3, 15+$value_c, 73, 'Gmail: '.$value_c.'%', $black);
	
	imagefilledrectangle($image, 10, 100, 10+$value_d, 120, $yellow);
	imagestring($image, 3, 15+$value_d, 103, 'Hotmail: '.$value_d.'%', $black);

	imagefilledrectangle($image, 10, 130, 10+$value_e, 150, $new);
	imagestring($image, 3, 15+$value_e, 133, 'Indiatimes: '.$value_e.'%', $black);	

	// 3D effect of the chart
	for ($i = 280; $i > 250; $i--) {
		imagefilledarc($image, 200, $i, 380, 200, 0, $curve1, $orange2, IMG_ARC_PIE);
		imagefilledarc($image, 200, $i, 380, 200, $curve1, $curve1+$curve2 , $blue2, IMG_ARC_PIE);
		imagefilledarc($image, 200, $i, 380, 200, $curve1+$curve2, $curve1+$curve2+$curve3 , $green2, IMG_ARC_PIE);
		imagefilledarc($image, 200, $i, 380, 200, $curve1+$curve2+$curve3, $curve1+$curve2+$curve3+$curve4 , $yellow2, IMG_ARC_PIE);
		imagefilledarc($image, 200, $i, 380, 200, $curve1+$curve2+$curve3+$curve4, $curve1+$curve2+$curve3+$curve4+$curve5 , $new2, IMG_ARC_PIE);
	}

	// Create upper layer
	imagefilledarc($image, 200, 250, 380, 200, 0, $curve1, $orange, IMG_ARC_PIE);
	imagefilledarc($image, 200, 250, 380, 200, $curve1, $curve1+$curve2 , $blue, IMG_ARC_PIE);
	imagefilledarc($image, 200, 250, 380, 200, $curve1+$curve2, $curve1+$curve2+$curve3 , $green, IMG_ARC_PIE);
	imagefilledarc($image, 200, 250, 380, 200, $curve1+$curve2+$curve3, $curve1+$curve2+$curve3+$curve4 , $yellow, IMG_ARC_PIE);
	imagefilledarc($image, 200, 250, 380, 200, $curve1+$curve2+$curve3+$curve4, $curve1+$curve2+$curve3+$curve4+$curve5 , $new, IMG_ARC_PIE);
	// Display in browser
	header('Content-type: image/png');
	imagepng($image);
	
	imagedestroy($image);

?>
