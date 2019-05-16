<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateAccount(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>	

	 <tr>
		<td  align="right" width="45%" class="blackbold"> Account Type  : </td>
		<td   align="left" >
		<?php $accountType = $objBankAccount->getAccountTypeName($arryBankAccount[0]['AccountType']);?>
		  <?=stripslashes(ucwords(strtolower($accountType)));?>
		</td>
	</tr>	
    <?php if($arryBankAccount[0]['ParentAccountID'] > 0){?>
       <tr>
		<td  align="right"  class="blackbold">Parent Account : </td>
		<td   align="left" >
    <?php $parentAccount = $objBankAccount->getParentAccountName($arryBankAccount[0]['ParentAccountID']);?>
		  <?=stripslashes($parentAccount);?>
		</td>
	</tr>	
	<?php }?>
	<tr>
	<td  align="right"   class="blackbold"> Account Name  : </td>
	<td  align="left" >
	 
	<?=stripslashes($arryBankAccount[0]['AccountName']);?>
	</td>
	</tr>	  
	<tr>
		<td  align="right"   class="blackbold"> Account Number  : </td>
		<td  align="left" >
		 
		<?=$arryBankAccount[0]['AccountNumber'];?>
		</td>
	</tr>	
	
	<!--<tr>
		<td  align="right" class="blackbold"> Account Code : </td>
		<td   align="left">
		 
		<//?=$arryBankAccount[0]['AccountCode'];?>
		</td>
	</tr>-->	
	 
	<tr>
		<td  align="right" valign="top"  class="blackbold">Bank Address  : </td>
		<td   align="left" >
		 
                     <?=(!empty($arryBankAccount[0]['Address']))?(stripslashes($arryBankAccount[0]['Address'])):(NOT_SPECIFIED)?>
		</td>
	</tr>
	<tr>
		<td  align="right"   class="blackbold">Status  : </td>
		<td   align="left"  >
			<?php 

			if($arryBankAccount[0]['Status'] == "Yes") {$ActiveChecked = ' Active'; $InActiveChecked ='';}
			if($arryBankAccount[0]['Status'] == "No") {$ActiveChecked = ''; $InActiveChecked = 'InActive';}

			?>
			<?=$ActiveChecked?><?=$InActiveChecked?>
		</td>
	</tr>

	

</table>	
  </td>
 </tr>


 </form>
</table>
