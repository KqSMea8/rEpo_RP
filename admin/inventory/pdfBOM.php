<?	require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/bom.class.php");
	

	$objBom=new bom();
	(!$_GET['module'])?($_GET['module']='Quote'):("BOM"); 
	$module = $_GET['module'];

      
	$ModuleName = "BOM ";
        $ModuleIDTitle = "Bom Code"; $ModuleID = "BomID"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE;

	if(!empty($_GET['bom'])){
		$arryBom = $objBom->ListBOM($_GET['bom'],'','','',1);

		$BOMID   = $arryBom[0]['bomID'];	
		if($BOMID>0){
			$arryBomItem = $objBom->GetBomStock($BOMID);

			$NumLine = sizeof($arryBomItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		$ErrorMSG = NOT_EXIST_DATA;
	}

	if(!empty($ErrorMSG)) {
		echo $ErrorMSG; exit;
	}

	/*******************************************/
	/*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

	 $Title = "Bill Number #  ".$arryBom[0]['Sku'];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/********* BOM  Detail **************/
	/*************************************/
	
	$OrderDate = ($arryBom[0]['bomDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryBom[0]['bomDate']))):(NOT_MENTIONED);
	//$Approved = ($arryBom[0]['Status'] == 1)?('Completed'):('Parked');
	
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => $ModuleIDTitle."# :", $Head2 => $arryBom[0]['bom_code']),
                array($Head1 => "SKU :", $Head2 => $arryBom[0]['Sku']),
		//array($Head1 => "Item Condition :", $Head2 => $arryBom[0]['bomCondition']),
                array($Head1 => "Item Description :", $Head2 => $arryBom[0]['description']),
                array($Head1 => "Total Cost :", $Head2 => $arryBom[0]['total_cost']),
		array($Head1 => "Bom Date :", $Head2 => $OrderDate)
		
		
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

	
	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>Component Item</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,93,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>'; $Head2 = '<b>Condition</b>';$Head3 = '<b>Description</b>'; $Head4 = '<b>Qty</b>';  $Head5 = '<b>Unit Price</b>'; $Head6= '<b>Total Cost</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			
			$ordered_qty = $arryBomItem[$Count]["bom_qty"];
                        $wastage_qty = $arryBomItem[$Count]["WastageQty"];

			

            $arryDef[$i][$Head1] = stripslashes($arryBomItem[$Count]["sku"]);
            $arryDef[$i][$Head2] = stripslashes($arryBomItem[$Count]["Condition"]);
            $arryDef[$i][$Head3] = stripslashes($arryBomItem[$Count]["description"]);
            $arryDef[$i][$Head4] = $arryBomItem[$Count]["bom_qty"];
            $arryDef[$i][$Head5] = number_format($arryBomItem[$Count]["unit_cost"],2);
            $arryDef[$i][$Head6] = number_format($arryBomItem[$Count]["total_bom_cost"],2);
            $data[] = $arryDef[$i];
            $i++;

			$subtotal += $arryBomItem[$Count]["total_bom_cost"];
			

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'70'),$Head2=>array('justification'=>'left'),$Head3=>array('justification'=>'left','width'=>'60'),$Head4=>array('justification'=>'left','width'=>'90'),$Head5=>array('justification'=>'left','width'=>'60'),$Head6=>array('justification'=>'left','width'=>'70'),$Head7=>array('justification'=>'right','width'=>'80')), 'shaded'=>1,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$subtotal = number_format($subtotal,2);
		
		$TotalAmount = number_format($arryBom[0]['total_cost'],2);

		$TotalTxt =  " Total Cost : ".$subtotal;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		


    }


// $pdf->ezStream();
	/***********************************/
       $file_path = 'upload/pdf/'.$_GET['bom'].".pdf";
       $pdfcode = $pdf->output();
       $fp=fopen($file_path,'wb');
       fwrite($fp,$pdfcode);
       fclose($fp);

      	header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
       exit;
	
?>
