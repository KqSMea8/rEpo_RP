<?
$Config['ExportContent'] = '';

$content = '<table '.$table_bg.'>
	<tr align="left"  >';


$content .= '<td width="9%" class="head1">Account Name</td>
	<td width="10%" class="head1">Account Number</td>

	<td width="12%" class="head1" align="right">Balance ('.$Config['Currency'].')</td>	
	<td width="12%" class="head1" align="center">Status</td>		
	</tr>';




	if(is_array($arryBankAccountType) && $num>0){

		foreach($arryBankAccountType as $key=>$values){ 

			$content .= '<tr>
			<td  colspan="6" height="30" style="background-color:#FFFFFF;" valign="bottom">'.'<b>'.$values['AccountType'].'<b></td>
			</tr>';

	if(!empty($_GET['AccountTypeID']))
	{ 

		$arryAccountTypeID=$objBankAccount->getAccountTypeByID($_GET['AccountTypeID']);
		$AccountTypeID = $arryAccountTypeID[0]["AccountTypeID"];
		$RangeFromm=$arryAccountTypeID[0]["RangeFrom"];

	}else
	{

		 $AccountTypeID = $values['AccountTypeID'];
		  $arryAccountTypeID=$objBankAccount->getAccountTypeByID($values['AccountTypeID']);
		  $RangeFromm=$arryAccountTypeID[0]["RangeFrom"];
	}
	$Config['RootAccount'] = 1;
	$arryBankAccount=$objBankAccount->getBankAccount($RangeFromm,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);	
	$numBankAcc = sizeof($arryBankAccount);

		unset($Config['RootAccount']);


	foreach ($arryBankAccount as $key => $values) {   
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");

		$ReceivedAmnt = round($values['ReceivedAmnt'],2);
		$PaidAmnt = round($values['PaidAmnt'],2);
		if($AccountTypeID==2 || $AccountTypeID==3 || $AccountTypeID==4 || $AccountTypeID==7){
		$Balance = $PaidAmnt-$ReceivedAmnt;
		}else{
		$Balance = $ReceivedAmnt-$PaidAmnt;
		}

		if($values['DefaultAccount']==1){
			 #echo $DefaultIcon;
		}

	 	if($Config['pop']==1){ 
			$AccountName = str_replace("'","",$values["AccountName"]);
		}else{  
			$AccountName = ucwords($values['AccountName']);
		}
		if($values['BankAccountNumber'] != '' ){
			$AccountName .= '<br>[ Bank Acc No : '.$values['BankAccountNumber'].' ]';
		}

		if ($values['Status'] == 'Yes') {
		$status = 'Active';
		} else {
		$status = 'InActive';
		}
              

		$content .='<tr align="left" >
		<td >'.$AccountName.'</td>
		<td  width="15%" align="left">'.$values['AccountNumber'].'</td>
		<td align="right">'.number_format($Balance,2).'</td>
                <td align="center">'.$status.'</td>';
	} 
	
$groupAccountName=$objBankAccount->getGroupByAccountType($AccountTypeID);
$numGrp = sizeof( $groupAccountName);
	foreach($groupAccountName as $key=>$values){ 
		  $AccountNamee1=$objBankAccount->getBankAccountWithGroupID($values['GroupID'],$RangeFromm);
		$content .='<tr align="left"> 
		<td   height="20" >'.ucwords($values['GroupName']).' [Group]</td>
		<td  width="15%"> </td>
		       
		</tr>'; 
		$Balance=0;

	foreach($AccountNamee1 as $key=>$values4){   //echo "www";die;

		$ReceivedAmnt = round($values4['ReceivedAmnt'],2);
		$PaidAmnt = round($values4['PaidAmnt'],2);
		if($AccountTypeID==2 || $AccountTypeID==3 || $AccountTypeID==4 || $AccountTypeID==7){
		$Balance = $PaidAmnt-$ReceivedAmnt;
		}else{
		$Balance = $ReceivedAmnt-$PaidAmnt;
		}

		if($values4['DefaultAccount']==1){
			 # echo $DefaultIcon;
		}

                 if ($values4['Status'] == 'Yes') {
			$status = 'Active';
			} else {
			$status = 'InActive';
			}
                        
			$AccountName = ucwords($values4['AccountName']);


			if($values4['BankAccountNumber'] != '' ){
				$AccountName .= '<br>[ Bank Acc No: '.$values4['BankAccountNumber'].' ]';
			}

			$content .='<tr> 
			<td style="padding-left:20px;" >'.$AccountName.'</td>
			<td width="15%" align="left">'.$values4['AccountNumber'].' </td>
			<td align="right"> '.number_format($Balance,2).'</td>
                        <td align="center">'.$status.'</td> </tr>';

	 }


	 $objBankAccount->getChartSubGroupAccountExport($values['GroupID'],0,$FromDate,$ToDate,$RangeFromm);
	 $content .= $Config['ExportContent'];

             }
 }
   }







$content .= '</table>';

 
		 
if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}



?>
