<?	
	$CommissionFlag=0;
	if($Payroll=="1"){ //&& !empty($EmpIDArray)
		require_once($Prefix."classes/sales.quote.order.class.php");
		$objSale = new sale();
		$EmpIDArray =  array_unique($EmpIDArray);
 
		//$EmpIDMulti = implode(",",$EmpIDArray); //temp
		$arryPayment=$objSale->GetSalesPersionForCommission($FromDate,$ToDate,0,$EmpIDMulti);
		$numPayment=$objSale->numRows();
		if(is_array($arryPayment) && $numPayment>0){
			#echo $FromDate.','.$ToDate; pr($arryPayment);
			$EmpDivision = 5;
			foreach($arryPayment as $key=>$values){
				$EmpID = $values['SalesPersonID'];
				$arryComm["CommOn"] = $values['CommOn'];
				$arryComm["CommType"] = $values['CommType'];
				$arryComm["CommPaidOn"] = $values['CommPaidOn'];
 				/******************/
				$arryPayment=$objSale->CommReport($arryComm, $FromDate,$ToDate, $EmpID, 0);
				$num=$objSale->numRows(); 
				include("../finance/includes/html/box/comm_report_data.php");

				if($TotalCommissionSum>0){
					/******************/
					if(!in_array($EmpID,$EmpIDArray)){ //not punched
						$arryEmp = $objEmployee->GetEmployeeBrief($EmpID);
						$arrayList[$EmpID]["EmpID"] = $EmpID;
						$arrayList[$EmpID]['JobTitle'] =  $arryEmp[0]['JobTitle'];
						$arrayList[$EmpID]['EmpCode'] =  $arryEmp[0]['EmpCode'];
						$arrayList[$EmpID]['Department'] =  $arryEmp[0]['Department'];
						$arrayList[$EmpID]['EmpName'] =  $arryEmp[0]['UserName'];
						$arrayList[$EmpID]['Exempt'] =  $arryEmp[0]['Exempt'];
						$arrayList[$EmpID]['JoiningDate'] =  $arryEmp[0]['JoiningDate'];
						$arrayList[$EmpID]['PayCycle'] =  $arryEmp[0]['PayCycle'];
					}			
					$arrayList[$EmpID]["TotalCommission"] = $TotalCommissionSum; 
					$CommissionFlag=1;
					/**********************/ 
				}

			}

			 if(!empty($_GET['pk567']))pr($arrayList,1);
		}
		
	}
	/************************/
	//echo $CommissionFlag;

	
?>
