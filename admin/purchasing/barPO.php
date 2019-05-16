<?php
	require_once("../includes/settings.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();
	
	$OrderTotal = 0;


	if((!empty($_GET['f']) && !empty($_GET['t'])) || $_GET['y']){
		
		$module = $_GET['module'];
		$ModuleName = "Purchase ".$_GET['module'];

		if($_GET['fby']=="Year"){
			$BotTextHeight = 15;
			for($i=1;$i<=12;$i++) {
				$mon = $i; if($mon<10) $mon = '0'.$i;
				$from = $_GET['y'].'-'.$mon.'-01';
				$to = $_GET['y'].'-'.$mon.'-31';
				$MonthName = date("F",strtotime($from));
				$arryNumOrder = $objPurchase->GetNumPOByYear($_GET['y'],$from,$to,$_GET['s'],$_GET['st']);
				$valuesBar[$MonthName] = $arryNumOrder[0]['TotalOrder'];
				$OrderTotal +=  $arryNumOrder[0]['TotalOrder']; 
			}
		}else{
			$BotTextHeight = 40;
			$FromYear = date("Y",strtotime($_GET['f']));
			$ToYear = date("Y",strtotime($_GET['t']));
			for($i=$FromYear;$i<=$ToYear;$i++) {
				$arryNumOrder = $objPurchase->GetNumPOByYear($i,$_GET['f'],$_GET['t'],$_GET['s'],$_GET['st']);
				#$rand = rand(10,100);
				$valuesBar[$i] = $arryNumOrder[0]['TotalOrder']+$rand;
				$OrderTotal +=  $arryNumOrder[0]['TotalOrder']; 
			}		
		}

		



	}else{
		exit;
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
		 $img_width=750; 
		 $img_height=480;
		 $yname='Number of '.$ModuleName;//y-axis name
		 $xname = 'Total '.$ModuleName.':'.$OrderTotal;
		//border margins
		 $margins=50;
		 $ymargin=30;

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
			$x1= $margins + $gap + $i * ($gap+$bar_width) ;
			$x2= $x1 + $bar_width;
			$y1=($margins +$graph_height- intval($value * $ratio))-$ymargin ;
			$y2=($img_height-$margins)-$ymargin;
			
			$rem = ceil($value/20);
			$rand_no = rand(0,5);
			imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color_arry[$rand_no]);
			imagestring($img,0,$x1+3,$y1-10,$value,$values_color);
			imagestringup($img,3,$x1,$img_height-$BotTextHeight,$key,$txt_color);

		} 

		imagestringup($img,5,0,280, $yname, $txt_color);
		imagestring	($img,2,$img_width-220,2, $xname, $txt_color);

			header("Content-type:image/png");
			imagepng($img);

?>
