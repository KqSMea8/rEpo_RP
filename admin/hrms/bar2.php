<?php
	require_once("../includes/settings.php");
	require_once($Prefix."classes/employee.class.php");
	$objEmployee=new employee();
	

	for($i=0;$i<sizeof($arryDepartment);$i++) {
		$arryNumEmployee = $objEmployee->GetNumEmployee($arryDepartment[$i]['depID']);
		$valuesBar[$arryDepartment[$i]['Department']] = $arryNumEmployee[0]['TotalEmployee'];
	}

			/*
			$v1 = 10;
			$v2 = 20;
			$v3 = 30;
			$v4 = 1000;
			$y1 = '2001';
			$y2 = '2002';
			$y3 = '2003';
			$y4 = '2004';
		
		$valuesBar=array($y1 => $v1,$y2 => $v2,$y3 => $v3,$y4 => $v4);
		*/

		//echo '<pre>';		print_r($valuesBar);exit;
 		
		//image filed
		 $img_width=360;
		 $img_height=250;
		 
		//border margins
		 $margins=30;
		 
		 $graph_width=$img_width - $margins * 2;
		 $graph_height=$img_height - $margins * 2; 
		 
		 $img=imagecreate($img_width,$img_height);
		 
		 $bar_width=20;
		 $total_bars=count($valuesBar);
		 $gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1); 
		 
		 $bar_color=imagecolorallocate($img,102,102,102);
		 $background_color=imagecolorallocate($img,240,240,255);
		 $border_color=imagecolorallocate($img,255,255,255);
		 $line_color=imagecolorallocate($img,220,220,220); 
		 
		 imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
		 imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);
		 
		 $max_value=(max($valuesBar)>100)?(max($valuesBar)):(100); 
		 $ratio= $graph_height/$max_value; 
		 
		 $horizontal_lines=10;
		 
		 $horizontal_gap=$graph_height/$horizontal_lines;
		 for($i=1;$i<=$horizontal_lines;$i++){
			$y=$img_height - $margins - $horizontal_gap * $i ;
			imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
			$v=intval($horizontal_gap * $i /$ratio);
			imagestring($img,0,5,$y-5,$v,$bar_color);
		 }
		 
		 for($i=0;$i< $total_bars; $i++){
			list($key,$value)=each($valuesBar);
			$x1= $margins + $gap + $i * ($gap+$bar_width) ;
			$x2= $x1 + $bar_width;
			$y1=$margins +$graph_height- intval($value * $ratio) ;
			$y2=$img_height-$margins;
			imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
			imagestring($img,0,$x1+3,$y1-10,$value,$bar_color);
			imagestring($img,0,$x1+3,$img_height-20,$key,$bar_color);

		} 
		
			header("Content-type:image/png");
			imagepng($img);

?>