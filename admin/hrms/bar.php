<?php

			$v1 = 30;
			$v2 = 10;
			$v3 = 25;
			$v4 = 35;
		

	$image = imagecreate(300, 300);
	
	// Color settings
	$mainbg = ImageColorAllocateAlpha($image, 40, 130, 25, 10);
	
	$orange = imagecolorallocate($image, 249, 126, 17);
	$orange2 = imagecolorallocate($image, 167, 81, 5);
	
	$blue = imagecolorallocate($image, 43, 128, 255);
	$blue2 = imagecolorallocate($image, 0, 69, 172);
	
	$green = imagecolorallocate($image, 99, 235, 157);
	$green2 = imagecolorallocate($image, 19, 143, 72);
	
	$yellow = imagecolorallocate($image, 247, 241, 26);
	$yellow2 = imagecolorallocate($image, 215, 215, 0);
	$black = imagecolorallocate($image, 255, 255, 255);
	
	// Segments settings
	//$value = "This is a information for top";
	$value_a = $v1;
	$value_b = $v2;
	$value_c = $v3;
	$value_d = $v4;
	
	// Curve settings
	$curve1 = round(360*($value_a/100));
	$curve2 = round(360*($value_b/100));
	$curve3 = round(360*($value_c/100));
	$curve4 = round(360*($value_d/100));
	
	// Data message for top
	/*imagefilledrectangle($image, 0, 0, 0+$value, 0, $orange);
	imagestring($image, 50, 100, 20, $value, $black);*/
	
	// Data display in rectangles
	imagefilledrectangle($image, 10, 10, 10+$value_a, 30, $orange);
	imagestring($image, 5, 15+$value_a, 13, $value_a, $black);
	
	imagefilledrectangle($image, 10, 40, 10+$value_b, 60, $blue);
	imagestring($image, 5, 15+$value_b, 43, $value_b, $black);
	
	imagefilledrectangle($image, 10, 70, 10+$value_c, 90, $green);
	imagestring($image, 5, 15+$value_c, 73, $value_c, $black);
	
	imagefilledrectangle($image, 10, 100, 10+$value_d, 120, $yellow);
	imagestring($image, 5, 15+$value_d, 103, $value_d, $black);
	
	// 3D effect of the chart
	for ($i = 280; $i > 250; $i--) {
		imagefilledarc($image, 200, $i, 380, 200, 0, $curve1, $orange2, IMG_ARC_PIE);
		imagefilledarc($image, 200, $i, 380, 200, $curve1, $curve1+$curve2 , $blue2, IMG_ARC_PIE);
		imagefilledarc($image, 200, $i, 380, 200, $curve1+$curve2, $curve1+$curve2+$curve3 , $green2, IMG_ARC_PIE);
		imagefilledarc($image, 200, $i, 380, 200, $curve1+$curve2+$curve3, $curve1+$curve2+$curve3+$curve4 , $yellow2, IMG_ARC_PIE);
	}

	// Create upper layer
	imagefilledarc($image, 200, 250, 380, 200, 0, $curve1, $orange, IMG_ARC_PIE);
	imagefilledarc($image, 200, 250, 380, 200, $curve1, $curve1+$curve2 , $blue, IMG_ARC_PIE);
	imagefilledarc($image, 200, 250, 380, 200, $curve1+$curve2, $curve1+$curve2+$curve3 , $green, IMG_ARC_PIE);
	imagefilledarc($image, 200, 250, 380, 200, $curve1+$curve2+$curve3, $curve1+$curve2+$curve3+$curve4 , $yellow, IMG_ARC_PIE);
	
	// Display in browser
	header('Content-type: image/png');
	imagepng($image);
	
	imagedestroy($image);

?>