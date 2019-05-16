<?php
	require_once("../includes/settings.php");
	require_once($Prefix."classes/orders.class.php");
	$objOrder= new orders();
	
	$OrderTotal = 0;
	$maxDays=date('t');
	$currentYear = date("Y");
	$currentMonth = date("m");
	global $Config;


	for($i=1;$i<=$maxDays;$i++) {
		$datestring = $currentYear.'-'.$currentMonth.'-'.$i;			
		$totalOrderAmnt = $objOrder->getOrderAmountByDate($datestring);
		$valuesBar[$i] = $totalOrderAmnt.''.$arryNumOrder[0]['CurrencySymbol'];
		$valuesBar[$i] = $totalOrderAmnt;
		$OrderTotal +=  $totalOrderAmnt;

		$arryLegend[] = $i;
		$arryValue[] = $totalOrderAmnt;

	}


 

		//echo '<pre>';		print_r($valuesBar);exit;
 		
		//image filed
		 $img_width=750; 
		 $img_height=480;
		$yname ='Sales in '.$Config['Currency'];//y-axis name
		$xname = 'Sales for '.date('F, Y');
		//border margins
		 $margins=50;
		 $ymargin=30;
		$BotTextHeight = 50;
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


$bar_color_arry[0]=imagecolorallocate($img,0,80,123);//Blue color
$bar_color_arry[1]=imagecolorallocate($img,0,80,123);//Blue color 
$bar_color_arry[2]=imagecolorallocate($img,123,172,172);//Sky color
$bar_color_arry[3]=imagecolorallocate($img,172,0,0);//Red color
$bar_color_arry[4]=imagecolorallocate($img,123,123,172);
$bar_color_arry[5]=imagecolorallocate($img,0,123,0);//Green color 


$txt_color=imagecolorallocate($img,73,86,58);//text color
$line_color=imagecolorallocate($img,157,176,134); 
$values_color=imagecolorallocate($img,73,86,58);//values color
$label_color=imagecolorallocate($img,172,0,0);//Red color

		 imagefilledrectangle($img,0,0,$img_width,$img_height,$bag_color);
		//imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);
		 
        $LineHeight = $img_height-$margins-$ymargin;
		imageline($img,$margins,$LineHeight,$img_width-$ymargin,$LineHeight,$xyline_color);
		imageline($img,$margins,2,$margins,$LineHeight,$xyline_color);
		imageline($img,$img_width-$ymargin,2,$img_width-$ymargin,$LineHeight,$xyline_color);


		 $max_value=(max($valuesBar)>15000)?(max($valuesBar)):(15000); 
		 $ratio= $graph_height/$max_value; 
		 
		 $horizontal_lines=10;
		 $LineHeight=$LineHeight+5;
		 $horizontal_gap=$graph_height/$horizontal_lines;
		 for($i=1;$i<=$horizontal_lines;$i++){
			$y=$LineHeight - 4 - $horizontal_gap * $i ;
			imageline($img,$margins,$y,$img_width-$ymargin,$y,$line_color);
			$v=intval($horizontal_gap * $i /$ratio);
			imagestring($img,2,17,$y-5,$v,$values_color);
		 }
		 $ymargin = $ymargin;
		 for($i=0;$i< $total_bars; $i++){
			list($key,$value)=each($valuesBar);
			$x1= $margins + $gap + $i * ($gap+$bar_width) ;
			$x2= $x1 + $bar_width;
			$y1=($margins +$graph_height- intval($value * $ratio))-$ymargin ;
			$y2=($img_height-$margins)-$ymargin;
			
			$rem = ceil($value/20);

			$rand_no = rand(0,5);

			imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color_arry[$rand_no]);
			imagestringup($img,1,$x1+3,$y1-5,$value,$values_color);
			imagestringup($img,3,$x1,$img_height-$BotTextHeight,substr($key,0,10),$txt_color);

		} 

		imagestringup($img,5,0,280, $yname, $label_color);
		imagestring	($img,4,$img_width-250,2, $xname, $label_color);

			header("Content-type:image/png");
			imagepng($img);

?>
