<?
$arryLeaveType = $objCommon->GetAttributeByValue('','LeaveType');
if(sizeof($arryLeaveType)>0){

?>

<div class="right-search">
<h4>Entitled / Balance</h4>
<div class="right_box">

<?  

echo '<ul class="righttxt">';



if($arryEmp[0]['LeaveAccrual']==1){ 	
	foreach($arryFinalLeave as $key=>$values){	
		$EntitleDays = 	$values;
	  	$ApprovedLeave = $objLeave->getLeaveByStatus($_SESSION['AdminID'],"'Approved','Taken'",$key);
		$Balance = 0;
		$Balance = $EntitleDays - $ApprovedLeave;
		echo '<li><b>'.$key.'</b>';

		echo '<br>Entitled: '.$EntitleDays.'<br>Balance: '.$Balance;


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
