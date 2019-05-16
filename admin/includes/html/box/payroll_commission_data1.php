<?	if($Payroll=="1" && !empty($EmpIDArray) && !empty($_GET['pk567'])){
		require_once($Prefix."classes/sales.quote.order.class.php");
		$objSale = new sale();
		$EmpIDArray =  array_unique($EmpIDArray);

		//$EmpIDMulti = implode(",",$EmpIDArray); //temp
		$arryPayment=$objSale->SalesCommissionReport($FromDate,$ToDate,0,'',$EmpIDMulti);
		$numPayment=$objSale->numRows();
		if(is_array($arryPayment) && $numPayment>0){
			//echo $FromDate.','.$ToDate; pr($arryPayment);
			$EmpDivision = 5;
			foreach($arryPayment as $key=>$values){
				$EmpID = $values['SalesPersonID'];
 
				if($values['CommOn']==1){
					include("../includes/html/box/commission_cal_per.php");
				}else if($values['CommOn']==2){
					include("../includes/html/box/commission_cal_margin.php");
				}else{
					include("../includes/html/box/commission_cal.php");
				}
				
				if($TotalCommission>0){
					echo '<br>'.$EmpID.'#'.$TotalCommission;
					/******************/
					if(!in_array($EmpID,$EmpIDArray)){
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
				
					$arrayList[$EmpID]["TotalCommission"] = $TotalCommission;
					/******************/


				}
			}
		}

	}

 
	/************************/

?>
