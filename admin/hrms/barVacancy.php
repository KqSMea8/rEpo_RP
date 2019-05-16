<?php
	require_once("../includes/settings.php");
	require_once($Prefix."classes/candidate.class.php");
	$objCandidate = new candidate();
	

	$arryVacancy=$objCandidate->GetVacancy('','');
	$num=$objCandidate->numRows();
	$numPos=0; $numHired=0;
	$BotTextHeight = 8;
	for($i=0;$i<sizeof($arryVacancy);$i++) {
		$VacancyName = trim(substr(stripslashes($arryVacancy[$i]["Name"]),0,20));
		#$rand = rand(10,30);
		$valuesBar[$VacancyName] = $arryVacancy[$i]["NumPosition"].','.$arryVacancy[$i]["Hired"];
		$numPos +=  $arryVacancy[$i]["NumPosition"];
		$numHired +=  $arryVacancy[$i]["Hired"];
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

		#echo '<pre>';		print_r($valuesBar);exit;
 		
		//image filed
		 $img_width=780; 
		 $img_height=480;
		 $yname='Number of Employee';//y-axis name
		  $xname = 'Total Position:'.$numPos;
		  $xname2 = 'Total Hired:'.$numHired;
		//border margins
		 $margins=55;
		 $ymargin=65;

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
		 

$bag_color=imagecolorallocate($img,255,255,255);//Baground color 
$xyline_color=imagecolorallocate($img,157,176,134);//XY-axis color

$bar_color=imagecolorallocate($img,123,172,172);//Yellow color


$green_color=imagecolorallocate($img,0,123,0);//Green color 
$red_color=imagecolorallocate($img,172,0,0);//Red color


$txt_color=imagecolorallocate($img,73,86,58);//text color
$line_color=imagecolorallocate($img,157,176,134); 
$values_color=imagecolorallocate($img,73,86,58);//values color


		 imagefilledrectangle($img,0,0,$img_width,$img_height,$bag_color);
		 #imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);
		 
        $LineHeight = $img_height-$margins-$ymargin;
		imageline($img,$margins,$LineHeight,$img_width-$ymargin,$LineHeight,$xyline_color);
		imageline($img,$margins,2,$margins,$LineHeight,$xyline_color);
		imageline($img,$img_width-$ymargin,2,$img_width-$ymargin,$LineHeight,$xyline_color);


		 $max_value=(max($valuesBar)>100)?(max($valuesBar)):(100); 
		 $ratio= $graph_height/$max_value; 
		 
		 $horizontal_lines=10;
		 $LineHeight=$LineHeight+5;
		 $horizontal_gap=$graph_height/$horizontal_lines;
		 for($i=1;$i<=$horizontal_lines;$i++){
			$y=$LineHeight - 4 - $horizontal_gap * $i ;
			imageline($img,$margins,$y,$img_width-$ymargin,$y,$line_color);
			$v=intval($horizontal_gap * $i /$ratio);
			imagestring($img,0,25,$y-2,$v,$values_color);
		 }
		 $ymargin = $ymargin;
		 for($i=0;$i< $total_bars; $i++){
			list($key,$value)=each($valuesBar);
			$arryVal = explode(",",$value); 
			
			$x1= $margins + $gap + $i * ($gap+$bar_width);
			$x2= $x1 + $bar_width ;
			$y1=($margins +$graph_height- intval($arryVal[0] * $ratio))-$ymargin ;
			$y2=($img_height-$margins)-$ymargin;
			/******************/
			$x3= $x2 + 1 ;
			$x4= $x3 + $bar_width ;
			$y3=($margins +$graph_height- intval($arryVal[1] * $ratio))-$ymargin ;
			$y4=($img_height-$margins)-$ymargin;

			imagefilledrectangle($img,$x1,$y1,$x2,$y2,$green_color);
			imagefilledrectangle($img,$x3,$y3,$x4,$y4,$red_color);
			imagestring($img,0,$x1+5,$y1-10,$arryVal[0],$values_color);
			imagestring($img,0,$x3+5,$y3-10,$arryVal[1],$values_color);
			imagestringup($img,2,$x1+10,$img_height-$BotTextHeight,$key,$txt_color);

		} 

		#imagestringup($img,5,0,280, $yname, $txt_color);
		imagestring	($img,3,400,6, $xname, $green_color);
		imagestring	($img,3,580,6, $xname2, $red_color);

			header("Content-type:image/png");
			imagepng($img);

?>
