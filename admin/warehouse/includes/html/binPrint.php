<?php 
	//$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewManageBin.php'; 
	/**************************************************/	
	$ModuleName = "Manage Bin";
	$RedirectURL = "viewManageBin.php?curP=".$_GET['curP'];
	require('classes/BCGFont.php');
	require('classes/BCGColor.php');
	require('classes/BCGDrawing.php');
	require('classes/BCGcode39.barcode.php'); 
	if(empty($_GET['tab'])) $_GET['tab']="personal";

	

?>
<div style="width: 500px; margin: auto; text-align: center;">
<?php

if(is_array($arryWarehouse) && $num>0)
{
  	$flag=true;
	$Line=0;
	$font = new BCGFont('./classes/font/Arial.ttf', 18);

	// The arguments are R, G, B for color.
	
	
  	foreach($arryWarehouse as $key=>$values):	
		 $barcode = $values["barcode"];
                if($barcode == ''):
			$barcode = strtoupper(substr(md5($values["binlocation_name"]),0,10));		
                endif;
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255); 


		$code = new BCGcode39();
		$code->setScale(2); // Resolution
		$code->setThickness(30); // Thickness
		$code->setForegroundColor($color_black); // Color of bars
		$code->setBackgroundColor($color_white); // Color of spaces
		$code->setFont($font); // Font (or 0) 
		$code->parse($barcode); // Text
		$path = "upload/bin/'".$barcode."'.png";
		$drawing = new BCGDrawing($path, $color_white);
		$drawing->setBarcode($code);
		$drawing->draw();					
		$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);     
		$widval = $values["warehouse_id"];
		$dataval = $objWarehouse->getWarehousedata($widval);
		//echo $warehouse_code = $dataval['0']['warehouse_code'];echo "<br>";
$bin_location = stripslashes($values["binlocation_name"]);
		$warehouse_name = $dataval['0']['warehouse_name'];echo "<strong>WareHouse : ".$warehouse_name ."</strong><br>";
		echo "<strong>BinLocation : ".$bin_location ."</strong><br>";		 
		
                $path = "upload/bin/'".$barcode."'.png";?>
                <img style='margin:10px;' src="<?php echo $path; ?>"/>
<?php
                echo "------------------------------------------------------------------------------------------------<br>";
        endforeach; 
}

?>
</div>
<script>window.onload= function () { window.print();window.close();   }  </script>
