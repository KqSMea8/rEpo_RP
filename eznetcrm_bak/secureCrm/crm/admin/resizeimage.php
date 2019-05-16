<?php
	session_start();

	function html2rgb($color){ 
		if ($color[0] == '#')        $color = substr($color, 1);    if (strlen($color) == 6)        list($r, $g, $b) = array($color[0].$color[1],                                 $color[2].$color[3],                                 $color[4].$color[5]);    elseif (strlen($color) == 3)        list($r, $g, $b) = array($color[0], $color[1], $color[2]);    else        return false;    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);    return array($r, $g, $b);
	}

	//function genThumb($filename, $width, $height, $detect=false){
		// Get orignal dim+ensions	


		$filename=$_GET['img']; 
		$width=$_GET['w']; 
		$height=$_GET['h']; 
		$backColor = $_GET['bg'];
		$detect=false;
		
		list($width_orig, $height_orig) = getimagesize($filename);		
		$transparency = 100;
		
		
		$intNewWidth  = (($width_orig>$width) && (!empty($width)))?($width):($width_orig);
		$intNewHeight = (($height_orig>$height) && (!empty($height)))?($height):($height_orig);		
		/*
		if ($intNewWidth!=$width_orig && $intNewWidth<$width_orig && $detect) {
			$width_difference 	= $width_orig-$intNewWidth;// $width_orig-$width
			$width_percent		= ($width_difference * 100)/$width_orig;
			$intNewHeight		= ($height_orig) -(($height_orig*$width_percent)/100);
		}	*/	
		


		if($width_orig >= $width){
			if ($width && ($width_orig < $height_orig)) 
			{
				$intNewWidth = ($height / $height_orig) * $width_orig;
			} 
			else 
			{
				$intNewHeight = ($width / $width_orig) * $height_orig;
			}
		}else if($height_orig >= $height){
			
			if ($height && ($width_orig > $height_orig)) 
			{
				$intNewHeight = ($width / $width_orig) * $height_orig;
			} 
			else 
			{
				$intNewWidth = ($height / $height_orig) * $width_orig;
			}
		}
		
		else{
				$intNewWidth = $width_orig;
				$intNewHeight = $height_orig; 
		}		


		$imageInfo = getimagesize($filename);
		$type = $imageInfo['mime'];		
		
		if (($type == 'image/jpg') || ($type == 'image/jpeg')) {
			 $imSource = @imagecreatefromjpeg($filename);
		} elseif ($type == 'image/png') {			
			$imSource = @imagecreatefrompng($filename);
        } elseif ($type == 'image/gif') {
			$imSource = @imagecreatefromgif($filename);	
		} elseif ($type == 'image/bmp' || $type == 'image/x-windows-bmp') {
			$imSource = @imagecreatefromwbmp($filename);
		} else {
			$imSource = @imagecreatefromgif($filename);
		}
		
		if(function_exists('imagecreatetruecolor')){
   			$imDestination = imagecreatetruecolor($intNewWidth, $intNewHeight);
		}else{
   			$imDestination = imagecreate($intNewWidth, $intNewHeight);
		}

		 

		/////////////////////////////

		if(empty($backColor)) $backColor = 'ffffff';
		
		

		if($backColor != '' && ($type == 'image/png' || $type == 'image/gif')){
			$RGBArray = html2rgb($backColor);
			$R = $RGBArray[0];
			$G = $RGBArray[1];
			$B = $RGBArray[2];
			$th_bg_color = imagecolorallocate($imDestination, $R , $G, $B);
			imagefill($imDestination, 0, 0, $th_bg_color);
			imagecolortransparent($imDestination, $th_bg_color);
		}else{
			 $transCol = imagecolorallocate($imSource, 0, 0, 0);
			 $transCol = imagecolortransparent($imSource, $transCol);	
		}

		/////////////////////////////






		//imagecopymerge($imSource, $watermark, 0, 0, 0, 0, $watermark_width, $watermark_height, $transparency);
		imagecopyresampled($imDestination, $imSource, 0, 0, 0, 0, $intNewWidth, $intNewHeight, $width_orig, $height_orig);
		header("Content-type: ".$type);
		
		if (($type == 'image/jpg') || ($type == 'image/jpeg')) {
			imagejpeg($imDestination);
		} elseif ($type == 'image/png') {			
			imagepng($imDestination);
        } elseif ($type == 'image/gif') {
			imagegif($imDestination);
		} elseif ($type == 'image/bmp' || $type == 'image/x-windows-bmp') {
			imagewbmp($imDestination);
		} else {
			imagegif($imDestination);
		}
  // 	}

/*if (isset($_GET['img']) && !empty($_GET['img']) && isset($_GET['h']) && !empty($_GET['h']) && isset($_GET['w']) && !empty($_GET['w'])) {
	if (empty($_GET['d'])) {
		genThumb($_GET['img'], $_GET['w'], $_GET['h']);
	} else {
		genThumb($_GET['img'], $_GET['w'], $_GET['h'], true);
	}
}*/
//genThumb('administrator/components/com_phpshop/shop_image/product/bfa73a4fba77505fa71c960dc84c38dc.jpg', 100, 100);

?>
