<?php
	require_once("../includes/settings.php");
	require_once($Prefix."classes/orders.class.php");
	$objOrder=new orders();
        global $Config;
          
        $maxDays=date('t');
        $currentYear = date("Y");
        $currentMonth = date("m");

        
	for($i=1;$i<=$maxDays;$i++) {
               $datestring = $currentYear.'-'.$currentMonth.'-'.$i;
		$totalOrderAmnt = $objOrder->getOrderAmountByDate($datestring);
		$maxtotal[] =  $totalOrderAmnt;
		$valuesBar[$i] = $totalOrderAmnt;
	}
        
        $getMaxAmnt = max($maxtotal);
       
 		
		//image filed
		 $img_width=610;
		 $img_height=250;
		 
                 $yname ='Sales in '.$Config['Currency'];//y-axis name
		 $xname ='Sales for '.date("F").' '.$currentYear.' in '.$Config['Currency'].'';
                 
               
            
                 
		//border margins
		 $margins=30;
		 $ymargin=0;

		 $graph_width=$img_width - $margins * 2;
		 $graph_height=$img_height - $margins * 2; 
		 
		 $img=imagecreate($img_width,$img_height);
		 
		 $bar_width=15;
		 $total_bars=count($valuesBar);
		 $gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1); 
		 
		 $bar_color=imagecolorallocate($img,102,102,102);
		 $background_color=imagecolorallocate($img,240,240,255);
		 $border_color=imagecolorallocate($img,255,255,255);
		 $line_color=imagecolorallocate($img,220,220,220); 
		 

                $bag_color=imagecolorallocate($img,255,255,255);//Baground color
                $xyline_color=imagecolorallocate($img,135,135,135);//XY-axis color
                $bar_color=imagecolorallocate($img,172,212,123);//Yellow color
                $txt_color=imagecolorallocate($img,227,113,39);//text color
                $line_color=imagecolorallocate($img,220,220,220); 
                $values_color=imagecolorallocate($img,2,2,2);//values color


		 imagefilledrectangle($img,0,0,$img_width,$img_height+20,$bag_color);
		#imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);
		 
                $LineHeight = $img_height-$margins-$ymargin;
		imageline($img,$margins,$LineHeight,$img_width-27,$LineHeight,$xyline_color);
		imageline($img,$margins,2,$margins,$LineHeight,$xyline_color);


		 //$max_value=$getMaxAmnt+20; 
                 $max_value=(max($valuesBar)>100)?(max($valuesBar)):(100); 
		 $ratio= $graph_height/$max_value; 
		 
		 $horizontal_lines=10;
		 $LineHeight=$LineHeight+5;
		 $horizontal_gap=$graph_height/$horizontal_lines;
		 for($i=1;$i<=$horizontal_lines;$i++){
			$y=$LineHeight - 4 - $horizontal_gap * $i ;
			imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
			$v=intval($horizontal_gap * $i /$ratio);
			imagestring($img,0,5,$y,$v,$values_color);
		 }
		 $ymargin = $ymargin;
		 for($i=0;$i< $total_bars; $i++){
			list($key,$value)=each($valuesBar);
			$x1= $margins + $gap + $i * ($gap+$bar_width) ;
			$x2= $x1 + $bar_width;
			$y1=($margins +$graph_height- intval($value * $ratio))-$ymargin ;
			$y2=($img_height-$margins)-$ymargin;
			
		
			imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
			//imagestring($img,0,$x1+3,$y1-10,$value,$values_color);
			imagestring($img,0,$x1+3,$img_height-20,$key,$values_color);

		} 
		
                
                //imagestringup($img,15,0,235, $yname, $txt_color);
		imagestring($img,5,$img_width-270,0, $xname, $txt_color);
                
                header("Content-type:image/png");
                imagepng($img);

?>