<?
$arryLeaveType = $objCommon->GetAttributeByValue('','LeaveType');
if(sizeof($arryLeaveType)>0){


/************************************/
$arryEmp=$objEmployee->GetEmployeeBrief($_SESSION['AdminID']);

if($arryEmp[0]['LeaveAccrual']==1){       
	$Y = date("Y");
        $FromDate = $Y."-01-01"; $ToDate = $Y."-12-31";
	if($arryEmp[0]['JoiningDate'] > $FromDate){
		$FromDate = $arryEmp[0]['JoiningDate'];
	}

	//$FromDate = "2014-06-01"; $ToDate = "2014-06-30"; //temporary

	$arryWorkDt = $objTime->getHrsWorked($_SESSION['AdminID'],$FromDate,$ToDate);
	$HrsWorked = $arryWorkDt['HrsWorked'];
	$DaysWorked = $arryWorkDt['DaysWorked'];
	$CalendarDays = (strtotime($ToDate) - strtotime($FromDate))/(24*3600) + 1;
	$ProbationPeriod = $arryEmp[0]['ProbationPeriod'];
	$EligibilityPeriod = $arryEmp[0]['EligibilityPeriod'];	
	$JobType = $arryEmp[0]['JobType'];




	if(!empty($JobType)){
		$arryCustomRule=$objLeave->getRuleByType($JobType);
		if(sizeof($arryCustomRule)>0){
			foreach($arryCustomRule as $key=>$values){
				#echo $values['RuleOn'].' '.$values['RuleOpp'].' '.$values['RuleValue'].' : '.$values['LeaveAllowed'].'<br>';
				/////////////
				switch($values['RuleOn']){
				    case 'P': //Probation Period
					if($values['RuleOpp']=='E'){	
						if($ProbationPeriod==$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
						}
					}else if($values['RuleOpp']=='G'){	
						if($ProbationPeriod>$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];

						}
					}else if($values['RuleOpp']=='GE'){	
						if($ProbationPeriod>=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='L'){	
						if($ProbationPeriod<$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='LE'){	
						if($ProbationPeriod<=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='NE'){	
						if($ProbationPeriod!=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}
					break;

				case 'E': //Eligibility Period
					if($values['RuleOpp']=='E'){	
						if($EligibilityPeriod==$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='G'){	
						if($EligibilityPeriod>$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='GE'){	
						if($EligibilityPeriod>=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='L'){	
						if($EligibilityPeriod<$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='LE'){	
						if($EligibilityPeriod<=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='NE'){	
						if($EligibilityPeriod!=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}
					break;

				 case 'H': //HrsWorked
					if($values['RuleOpp']=='E'){	
						if($HrsWorked==$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='G'){	
						if($HrsWorked>$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='GE'){	
						if($HrsWorked>=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='L'){	
						if($HrsWorked<$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='LE'){	
						if($HrsWorked<=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='NE'){	
						if($HrsWorked!=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}
					break;

				 case 'D': //DaysWorked
					if($values['RuleOpp']=='E'){	
						if($DaysWorked==$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='G'){	
						if($DaysWorked>$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='GE'){	
						if($DaysWorked>=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='L'){	
						if($DaysWorked<$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='LE'){	
						if($DaysWorked<=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='NE'){	
						if($DaysWorked!=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}
					break;

				  case 'C': //CalendarDays
					if($values['RuleOpp']=='E'){	
						if($CalendarDays==$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='G'){	
						if($CalendarDays>$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='GE'){	
						if($CalendarDays>=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='L'){	
						if($CalendarDays<$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='LE'){	
						if($CalendarDays<=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}else if($values['RuleOpp']=='NE'){	
						if($CalendarDays!=$values['RuleValue']){
							$LeaveAllowed = $values['LeaveAllowed'];
							
						}
					}
					break;



				 
				}//end switch
				///////////////////	
				if(!empty($LeaveAllowed)){	
					break;
				}


			}
		}
	}
}
/************************************/

?>

<div class="right-search">
<h4>Entitled / Balance</h4>
<div class="right_box">

<?  

echo '<ul class="righttxt">';

if(!empty($LeaveAllowed)){	
	$LeaveAllowedArry = explode("#", $LeaveAllowed);
	foreach($LeaveAllowedArry as $val){
		$innerArry = explode(":", $val);
		$arryFinalLeave[$innerArry[0]] = $innerArry[1];
	}

	foreach($arryFinalLeave as $key=>$values){		
	  	$ApprovedLeave = $objLeave->getLeaveByStatus($_SESSION['AdminID'],"'Approved','Taken'",$key);
		$Balance = 0;
		$Balance = $EntitleDays - $ApprovedLeave;
		echo '<li><b>'.$key.'</b>';
	
		echo '<br>Entitled: '.$values.'<br>Balance: '.$Balance;
	
	
		echo '</li>';
	}


}else{ // Fixed Leave

	foreach($arryLeaveType as $key=>$values){
		$EntitleDays = $objLeave->getLeaveEntitle($_SESSION['AdminID'],$values["attribute_value"]);
	  	$ApprovedLeave = $objLeave->getLeaveByStatus($_SESSION['AdminID'],"'Approved','Taken'",$values["attribute_value"]);
		$Balance = 0;
		$Balance = $EntitleDays - $ApprovedLeave;
		echo '<li><b>'.$values["attribute_value"].'</b>';
	
		echo '<br>Entitled: '.$EntitleDays.'<br>Balance: '.$Balance;
	
	
		echo '</li>';
	}

}
echo '</ul>';
?>
  
	
	
	
  </div>
</div>
<? } ?>
