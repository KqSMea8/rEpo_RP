<?	session_start();
	$Prefix = "../../"; 

    require_once($Prefix."includes/config.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once("language/english.php");

	include($Prefix.'classes/class.pdf.php');
	include($Prefix.'classes/class.ezpdf.php');
	include($Prefix.'includes/pdf_function.php');
	/********************************/
	$objConfig=new admin();
	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	$objCompany=new company(); 
	$arryCompany = $objCompany->GetCompanyDetail($_SESSION['CmpID']);


	/********Connecting to main database*********/
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	$Config['Prefix'] = $Prefix;

	$objPurchase=new purchase();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];


	if($module=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixPO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $PrefixPO = "PO";  $NotExist = NOT_EXIST_ORDER;
	}
	$ModuleName = "Purchase ".$module;

	if(!empty($_GET['o'])){
		$arryPurchase = $objPurchase->GetPurchase($_GET['o'],'',$module);
		$OrderID   = $arryPurchase[0]['OrderID'];	
		if($OrderID>0){
			$arryPurchaseItem = $objPurchase->GetPurchaseItem($OrderID);
			$NumLine = sizeof($arryPurchaseItem);
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

	 $Title = $ModuleName." # ".$arryPurchase[0][$ModuleID];
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/********* Order Detail **************/
	/*************************************/
	
	$OrderDate = ($arryPurchase[0]['OrderDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_MENTIONED);
	$Approved = ($arryPurchase[0]['Approved'] == 1)?('Yes'):('No');

	$DeliveryDate = ($arryPurchase[0]['DeliveryDate']>0)?(date($_SESSION['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))):(NOT_MENTIONED);

	$PaymentMethod = (!empty($arryPurchase[0]['PaymentMethod']))? (stripslashes($arryPurchase[0]['PaymentMethod'])): (NOT_MENTIONED);
	$ShippingMethod = (!empty($arryPurchase[0]['ShippingMethod']))? (stripslashes($arryPurchase[0]['ShippingMethod'])): (NOT_MENTIONED);
	$Comment = (!empty($arryPurchase[0]['Comment']))? (stripslashes($arryPurchase[0]['Comment'])): (NOT_MENTIONED);
	$Head1 = 'Left'; $Head2 = 'Right';
	$data = array(
		array($Head1 => $ModuleIDTitle."# :", $Head2 => $arryPurchase[0][$ModuleID]),
		array($Head1 => "Order Date :", $Head2 => $OrderDate),
		array($Head1 => "Approved :", $Head2 => $Approved),
		array($Head1 => "Order Status :", $Head2 => $arryPurchase[0]['Status']),
		array($Head1 => "Order Type :", $Head2 => $arryPurchase[0]['OrderType']), 
		array($Head1 => "Delivery Date :", $Head2 => $DeliveryDate),
		array($Head1 => "Payment Method :", $Head2 => $PaymentMethod),
		array($Head1 => "Shipping Method :", $Head2 => $ShippingMethod),
		array($Head1 => "Comments :", $Head2 => $Comment)
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'right','width'=>'100')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);

	/********* Vendor/Warehouse ********/
	/*************************************/

	$Head1 = '<b>Vendor Information</b>'; $Head2 = '<b>Warehouse Information</b>';

	$YCordLine = $pdf->y-25; 
	$pdf->line(50,$YCordLine,138,$YCordLine);
	$pdf->line(330,$YCordLine,430,$YCordLine);

	$Address = str_replace("\n"," ",stripslashes($arryPurchase[0]['Address']));

	$wAddress = str_replace("\n"," ",stripslashes($arryPurchase[0]['wAddress']));
	
	$data = array(
		array($Head1 => stripslashes($arryPurchase[0]['SuppCompany']), $Head2 => stripslashes($arryPurchase[0]['wName'])),
		array($Head1 => $Address.",", $Head2 => $wAddress.","),
		array($Head1 => stripslashes($arryPurchase[0]['City']).", ".stripslashes($arryPurchase[0]['State']).", ".stripslashes($arryPurchase[0]['Country'])."-".stripslashes($arryPurchase[0]['ZipCode']), $Head2 => stripslashes($arryPurchase[0]['wCity']).", ".stripslashes($arryPurchase[0]['wState']).", ".stripslashes($arryPurchase[0]['wCountry'])."-".stripslashes($arryPurchase[0]['wZipCode'])),
		array($Head1 => "Contact Name: ".stripslashes($arryPurchase[0]['SuppContact']), $Head2 =>"Contact Name: ".stripslashes($arryPurchase[0]['wContact'])),
		array($Head1 => "Mobile: ".stripslashes($arryPurchase[0]['Mobile']), $Head2 => "Mobile: ".stripslashes($arryPurchase[0]['wMobile'])),
		array($Head1 => "Landline: ".stripslashes($arryPurchase[0]['Landline']), $Head2 =>  "Landline: ".stripslashes($arryPurchase[0]['wLandline'])),
		array($Head1 => "Fax: ".stripslashes($arryPurchase[0]['Fax']), $Head2 => ""),
		array($Head1 => "Email: ".stripslashes($arryPurchase[0]['Email']), $Head2 => ""),
		array($Head1 => "Currency: ".$arryPurchase[0]['SuppCurrency'], $Head2 => "")
	);
	$pdf->ezSetDy(-10);
	$pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'280')), 'shaded'=>0, 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>9,'showHeadings'=>1, 'colGap'=>2, 'rowGap'=>2) );
	$pdf->setStrokeColor(0,0,0,1);
	/***********************************/
	$pdf->ezSetDy(-10);
	$CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_DETAIL);
	$pdf->ezText("<b>".$CurrencyInfo."</b>",9,array('justification'=>'right', 'spacing'=>'1'));
	$pdf->ezSetDy(-20);

	/********* Item Detail ***************/
	/*************************************/
	$pdf->ezText("<b>Line Item</b>",9,array('justification'=>'left', 'spacing'=>'1'));
	$YCordLine = $pdf->y-5; 
	$pdf->line(50,$YCordLine,93,$YCordLine);

	$pdf->ezSetDy(-5);
    if($NumLine>0){
        $Head1 = '<b>SKU</b>'; $Head2 = '<b>Description</b>'; $Head3 = '<b>Qty Ordered</b>'; $Head4 = '<b>Total Qty Received</b>'; $Head5 = '<b>Unit Price</b>'; $Head6 = '<b>Tax Rate</b>'; $Head7 = '<b>Amount</b>'; 
        $i=0;unset($data); unset($arryDef);

        $arryDef[$i][$Head1] = $Head1;$arryDef[$i][$Head2] = $Head2;$arryDef[$i][$Head3] = $Head3; $arryDef[$i][$Head4] = $Head4;$arryDef[$i][$Head5] = $Head5;$arryDef[$i][$Head6] = $Head6;$arryDef[$i][$Head7] = $Head7;
        $data[] = $arryDef[$i];
        $i++;
		$subtotal=0;
		for($Line=1;$Line<=$NumLine;$Line++) { 
			$Count=$Line-1;	
			$total_received = $objPurchase->GetQtyReceived($arryPurchaseItem[$Count]["id"]);
			$ordered_qty = $arryPurchaseItem[$Count]["qty"];

			if(!empty($arryPurchaseItem[$Count]["RateDescription"]))
				$Rate = $arryPurchaseItem[$Count]["RateDescription"].' : ';
			else $Rate = '';
			$TaxRate = $Rate.number_format($arryPurchaseItem[$Count]["tax"],2);

            $arryDef[$i][$Head1] = stripslashes($arryPurchaseItem[$Count]["sku"]);
            $arryDef[$i][$Head2] = stripslashes($arryPurchaseItem[$Count]["description"]);
            $arryDef[$i][$Head3] = $arryPurchaseItem[$Count]["qty"];
            $arryDef[$i][$Head4] = number_format($total_received);
            $arryDef[$i][$Head5] = number_format($arryPurchaseItem[$Count]["price"],2);
            $arryDef[$i][$Head6] = $TaxRate;
            $arryDef[$i][$Head7] = number_format($arryPurchaseItem[$Count]["amount"],2);
            $data[] = $arryDef[$i];
            $i++;

			$subtotal += $arryPurchaseItem[$Count]["amount"];
			$TotalQtyReceived += $total_received;
			$TotalQtyLeft += ($ordered_qty - $total_received);

        }
		$pdf->ezSetDy(-5);
		$pdf->setLineStyle(0.5);
        $pdf->ezTable($data,'','',array('cols'=>array($Head1=>array('justification'=>'left','width'=>'70'),$Head2=>array('justification'=>'left'),$Head3=>array('justification'=>'left','width'=>'60'),$Head4=>array('justification'=>'left','width'=>'90'),$Head5=>array('justification'=>'left','width'=>'60'),$Head6=>array('justification'=>'left','width'=>'70'),$Head7=>array('justification'=>'right','width'=>'80')), 'shaded'=>1,'shadeCol'=>array(0.9,0.9,0.9), 'showLines'=>0 , 'xPos' =>300 ,'width'=>500,'fontSize'=>8,'showHeadings'=>0, 'colGap'=>2, 'rowGap'=>2) );
        $pdf->setStrokeColor(0,0,0,1);


		$subtotal = number_format($subtotal,2);
		$Freight = number_format($arryPurchase[0]['Freight'],2);
		$TotalAmount = number_format($arryPurchase[0]['TotalAmount'],2);

		$TotalTxt =  "Sub Total : ".$subtotal."\nFreight : ".$Freight."\nGrand Total : ".$TotalAmount;
		$pdf->ezText($TotalTxt,8,array('justification'=>'right', 'spacing'=>'1.5'));

		//if($TotalQtyLeft<=0){
			$pdf->setColor(255,0,0,1);
			$pdf->ezSetDy(-20);
			$pdf->ezText(PO_ITEM_RECEIVED,8,array('justification'=>'left', 'spacing'=>'1'));
			$pdf->setColor(0,0,0,1);
		//}



    }











	/***********************************/
	$pdf->ezStream();
	/*
	// or write to a file
	$file_path = 'test.pdf';
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);
	echo '<a href="'.$file_path.'">Click here to download Pdf</a>';
	*/
?>