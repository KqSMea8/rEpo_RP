<?
//By Chetan 30Aug2017//
$DbColumnArray = array(
    "Sku" => "Sku",
    "description" => "Item Description",
    "non_inventory" => "Track Inventory",
    "sell_price" => "Price",
    "itemType" => "Item Type",
    "Condition" => "Condition",	
    "Manufacture" => "Manufacture",		
    "Status" => "Status"
    
);
$DbColumn = sizeof($DbColumnArray);

/********Connecting to main database*********/
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
/*******************************************/

$MainDir = $Prefix."admin/inventory/upload/Excel/".$parameters['CmpID']."/";
//echo file_exists($MainDir.$parameters['ExcelFile']);
if(!empty($parameters['ExcelFile']) && file_exists($MainDir.$parameters['ExcelFile'])){
		

	$Filepath = $MainDir.$parameters['ExcelFile'];
	//echo '<pre>';print_r($Filepath);exit;
	$Spreadsheet = new SpreadsheetReader($Filepath);		
	$Sheets = $Spreadsheet -> Sheets();
	$Count = 0;
	$ItemAddedCount = 0;
	$ItemCount = 0;
	$arrayItem=array();
	foreach ($Sheets as $Index => $Name){
		$Time = microtime(true);
		$Spreadsheet -> ChangeSheet($Index);

		foreach ($Spreadsheet as $Key => $Row){
			//echo "<pre>";	print_r($Row);echo "</pre>";exit;
			unset($arrayItem[$Count]);
			foreach($DbColumnArray as $Key => $Heading){
				$i = $parameters[$Key];
				$arrayItem[$Count][$Key] = trim($Row[$i]);
			}
			$Count++;
		}
			
	}

	$arrayItem = array_values(array_filter(array_map('array_filter', $arrayItem)));	
	$NumItem=sizeof($arrayItem);
	//echo $NumItem."<pre>";print_r($arrayItem);echo "</pre>";exit;
	if($NumItem>0){
		/******Connecting to company database*******/
		$Config['DbName'] = $Config['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/

		$objItem->CreateTempTableForImport();
		for($i=1;$i<$NumItem;$i++){

			$Res = $objItem->checkItemSku($arrayItem[$i]['Sku']);
			if(empty($Res))
			{	
				unset($arrayItem[$i]['Status']);
				$arrayItem[$i] = array_merge($arrayItem[$i],array('Status'=>'1'));	
				$objItem->importToTemp($arrayItem[$i]);	
				$ItemAddedCount++;
			} 
		}
			
	}
	/**********************************/
	$parameters['TotalImport'] = $ItemAddedCount;
	//unlink($MainDir.$parameters['ExcelFile']);
}

unset($parameters['ExcelFile']);

/*******************************/
/*******************************/

?>
