<script language="JavaScript1.2" type="text/javascript">
function validate_company(frm){
	if(confirm("Are you sure you want to permanently delete this company?")){
		return true;
	}else{
		return false;
	}
	return false;
}
</script>

<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_company(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_company'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">Company Admin Details</td>
</tr>
<tr>
        <td  align="right"   class="blackbold" width="20%"> Company Name  : </td>
        <td   align="left" width="30%">
<?php echo stripslashes($arryCompany[0]['CompanyName']); ?>          </td>
      
        <td  align="right"   class="blackbold" width="20%"> Display Name  : </td>
        <td   align="left" >

<?=stripslashes($arryCompany[0]['DisplayName'])?>



</td>
      </tr>



  <tr>
	 <td  align="right"> Email : </td>
 <td  align="left">
<?php echo $arryCompany[0]['Email']; ?>
</td>

	 <td  align="right"   class="blackbold" >Status  : </td>
        <td   align="left"  >
          <? 	 if($arryCompany[0]['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
		 echo $status;
         ?>
        </td> 


</tr>


<tr>
        <td  align="right"   class="blackbold"  valign="top" > Allowed Modules  : </td>
        <td   align="left"  valign="top">
<ul style="line-height:25px;">
	<li <?=($arryCompany[0]['Department']=="")?(''):('style="display:none"')?>> <?=MOD_ERP?> <br></li>

	<li <?=substr_count($arryCompany[0]['Department'],"1")?(''):('style="display:none"')?>> <?=MOD_HRMS?> <br></li>
		
	<li <?=substr_count($arryCompany[0]['Department'],"5")?(''):('style="display:none"')?>> <?=MOD_CRM?> <br></li>

	<li <?=substr_count($arryCompany[0]['Department'],"2")?(''):('style="display:none"')?>> <?=MOD_ECOMMERCE?> <br></li>

	<li <?=substr_count($arryCompany[0]['Department'],"3,4,6,7,8")?(''):('style="display:none"')?>> <?=MOD_INVENTORY?> <br></li>
</ul>



	
	
</td>

<td></td>
<td valign="top">
<? if($arryCompany[0]['Image'] !='' && file_exists('../upload/company/'.$arryCompany[0]['Image']) ){ ?>

<a href="../upload/company/<?=$arryCompany[0]['Image']?>" class="fancybox" data-fancybox-group="gallery"  title="<?=stripslashes($arryCompany[0]["CompanyName"])?>" ><? echo '<img src="../resizeimage.php?w=150&h=150&img=upload/company/'.$arryCompany[0]['Image'].'" border=0 >';?></a>
<?	} ?>
</td>



 </tr>

</table>
<br>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<? if(!empty($ErrorMsg)){?>
	<tr>
	  <td height="50" align="center" class="redmsg">
	<?=$ErrorMsg?>
	</td>
	</tr>
<? }else{?>


<? //HRMS
if($arryCompany[0]['Department']=="" || substr_count($arryCompany[0]['Department'],"1")) { 
	$NumEmployee = $objConfigure->NumEmployee();
	$NumCandidate = $objConfigure->NumCandidate();
	$NumHRMSDocument = $objConfigure->NumHRMSDocument();
	$NumAnnouncement = $objConfigure->NumAnnouncement();
	$HrmsFlag=1;
?>
<tr>
	 <td colspan="4" align="left" class="head"><?=MOD_HRMS?> Data Count</td>
</tr>
<tr>
	<td  align="right" width="20%">  Employee : </td>
	<td  align="left" width="30%">
	<?=$NumEmployee?>
	</td>

	<td  align="right"   class="blackbold" width="20%"> Candidate   : </td>
	<td   align="left"  >
	<?=$NumCandidate?>
	</td> 
</tr> 
<tr>
	<td  align="right"> Document : </td>
	<td  align="left">
	<?=$NumHRMSDocument?>
	</td>

	<td  align="right"> Announcement : </td>
	<td  align="left">
	<?=$NumAnnouncement?>
	</td>
</tr>
<? } ?>


<? //CRM
if($arryCompany[0]['Department']=="" || substr_count($arryCompany[0]['Department'],"5")) { 
	$NumLead = $objConfigure->NumLead();
	$NumOpportunity = $objConfigure->NumOpportunity();
	$NumTicket = $objConfigure->NumTicket();
	$NumContact = $objConfigure->NumContact();
	$NumQuote = $objConfigure->NumQuote();
	$NumEvent = $objConfigure->NumEvent();
	$NumCampaign = $objConfigure->NumCampaign();
	$NumCRMDocument = $objConfigure->NumCRMDocument();
	$NumCRMUser = $objConfigure->NumEmployee(5);
	$NumCRMItem = $objConfigure->NumItem();
	$NumCustomer = $objConfigure->NumCustomer();
?>
<tr>
	 <td colspan="4" align="left" class="head"><?=MOD_CRM?> Data Count</td>
</tr>
<tr>
	<td  align="right" width="20%"> Lead : </td>
	<td  align="left" width="30%">
	<?=$NumLead?>
	</td>

	<td  align="right"   class="blackbold" width="20%">Opportunity   : </td>
	<td   align="left"  >
	<?=$NumOpportunity?>
	</td> 
</tr> 
<tr>
	<td  align="right"> Ticket : </td>
	<td  align="left">
	<?=$NumTicket?>
	</td>
	<td  align="right"> Contact : </td>
	<td  align="left">
	<?=$NumContact?>
	</td>
</tr>
<tr>
	<td  align="right"> Quote : </td>
	<td  align="left">
	<?=$NumQuote?>
	</td>
	<td  align="right"> Event : </td>
	<td  align="left">
	<?=$NumEvent?>
	</td>
</tr>
<tr>
	<td  align="right">  Document : </td>
	<td  align="left">
	<?=$NumCRMDocument?>
	</td>
	<td  align="right"> Campaign : </td>
	<td  align="left">
	<?=$NumCampaign?>
	</td>
</tr>

<tr>
	<td  align="right">  Customer : </td>
	<td  align="left">
	<?=$NumCustomer?>
	</td>
	<? if($HrmsFlag!=1){?>
	<td  align="right"> User : </td>
	<td  align="left"><?=$NumCRMUser?></td>
	<? } ?>
</tr>


<!--tr>
	<td  align="right"> Item : </td>
	<td  align="left">
	<?=$NumCRMItem?>
	</td>
</tr-->

<? } ?>

	



<? //ECOMMERCE
if($arryCompany[0]['Department']=="" || substr_count($arryCompany[0]['Department'],"2")) { 
	$NumECOMMItem = $objConfigure->NumECOMMItem();
	$NumOrder = $objConfigure->NumOrder();
	$NumECOMMCustomer = $objConfigure->NumECOMMCustomer();
?>
<tr>
	 <td colspan="4" align="left" class="head"><?=MOD_ECOMMERCE?> Data Count</td>
</tr>
<tr>
	<td  align="right" width="20%">  Item : </td>
	<td  align="left" width="30%">
	<?=$NumECOMMItem?>
	</td>

	<td  align="right"   class="blackbold" width="20%"> Order   : </td>
	<td   align="left"  >
	<?=$NumOrder?>
	</td> 
</tr> 
<tr>
	<td  align="right"> Customer : </td>
	<td  align="left">
	<?=$NumECOMMCustomer?>
	</td>

	
</tr>
<? } ?>

<? //INVENTORY
if($arryCompany[0]['Department']=="" || substr_count($arryCompany[0]['Department'],"3,4,6,7,8")) { 
	$NumInvItem = $objConfigure->NumItem();
	$NumWarehouse = $objConfigure->NumWarehouse();
	$NumBin = $objConfigure->NumBin();
	$NumInbound = $objConfigure->NumInbound();
	$NumOutbound = $objConfigure->NumOutbound();
	$NumSalesQuote = $objConfigure->NumSO('Quote');
	$NumSalesOrder = $objConfigure->NumSO('Order');
	$NumPurchaseQuote = $objConfigure->NumPO('Quote');
	$NumPurchaseOrder = $objConfigure->NumPO('Order');

	//Finance
	$NumAccount = $objConfigure->NumAccount();
	$NumCashReceipt = $objConfigure->NumCashReceipt();
	$NumCustomer = $objConfigure->NumCustomer();
	$NumInvoice = $objConfigure->NumInvoice();
	$NumPayment = $objConfigure->NumPayment();
	$NumVendor = $objConfigure->NumVendor();
?>

<tr>
	 <td colspan="4" align="left" class="head">Inventory Data Count</td>
</tr>
<tr>
	<td  align="right" width="20%">  Item : </td>
	<td  align="left" width="30%"><?=$NumInvItem?></td>
	<td width="20%"></td>
	<td></td>
</tr> 

<tr>
	 <td colspan="4" align="left" class="head">Warehouse Data Count</td>
</tr>
<tr>
	<td  align="right">  Warehouse : </td>
	<td  align="left" ><?=$NumWarehouse?></td>
	<td  align="right">  Bin : </td>
	<td  align="left" ><?=$NumBin?></td>
</tr> 
<tr>
	<td  align="right">  Inbound Order : </td>
	<td  align="left" ><?=$NumInbound?></td>
	<td  align="right">  Outbound Order : </td>
	<td  align="left" ><?=$NumOutbound?></td>
</tr> 
<tr>
	 <td colspan="4" align="left" class="head">Sales Data Count</td>
</tr>
<tr>
	<td  align="right">  Sales Quote : </td>
	<td  align="left" ><?=$NumSalesQuote?></td>
	<td  align="right">  Sales Order : </td>
	<td  align="left" ><?=$NumSalesOrder?></td>
</tr> 
<tr>
	 <td colspan="4" align="left" class="head">Purchasing Data Count</td>
</tr>
<tr>
	<td  align="right">  Purchase Quote : </td>
	<td  align="left" ><?=$NumPurchaseQuote?></td>
	<td  align="right">  Purchase Order : </td>
	<td  align="left" ><?=$NumPurchaseOrder?></td>
</tr>
<tr>
	 <td colspan="4" align="left" class="head">Finance Data Count</td>
</tr>
<tr>
	<td  align="right">  Chart of Accounts : </td>
	<td  align="left" ><?=$NumAccount?></td>
	<td  align="right">  AR Cash Receipt : </td>
	<td  align="left" ><?=$NumCashReceipt?></td>
</tr>
<tr>
	<td  align="right">  Customer : </td>
	<td  align="left"><?=$NumCustomer?></td>
	<td  align="right"> AR Invoice : </td>
	<td  align="left"><?=$NumInvoice?></td>
</tr>
<tr>
	<td  align="right">  AP Payment : </td>
	<td  align="left" ><?=$NumPayment?></td>
	<td  align="right">  Vendor : </td>
	<td  align="left"><?=$NumVendor?></td>
</tr>
<? }
} ?>
	
	
	
</table>	
  





	
	  
	
	</td>
   </tr>

   
  <? if($CmpID>100){?>
   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	

      <input name="Submit" type="submit" class="button" id="SubmitButton" value="Delete Permanently"  />


<input type="hidden" name="CmpID" id="CmpID" value="<?=$CmpID?>" />


</div>

</td>
   </tr>
<? } ?>
   </form>
</table>
</div>




