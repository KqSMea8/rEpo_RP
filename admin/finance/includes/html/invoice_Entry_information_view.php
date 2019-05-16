<?
if(empty($ModuleID)){
	$ModuleIDTitle = "PO Number"; $ModuleID = "SaleID"; $module ='Order';
}

if($objConfigure->getSettingVariable('SO_SOURCE')==1){
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
		$EcommFlag = 1;
	}
}
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	

  <tr>
	 <td colspan="4" align="left" class="head"><?=$module?> Information
	 <a class="fancybox fancybox.iframe" style="float:right;" href="../sales/order_log.php?OrderID=<?=$_GET['view']?>&module=Sales<?=$module?>" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()" ></a>
	 </td>
</tr>
    <?php   
        $arryRecurr = $arrySale;

        //include("../includes/html/box/recurring_2column_sales_view.php");
        ?>  

<? if($arrySale[0]['OrderPaid']>0) { ?>
	<tr>
		 <td  align="right"   class="blackbold" >Payment Status  : </td>
		<td   align="left" >
			<?=($arrySale[0]['OrderPaid']==1)?('<span class=greenmsg>Paid</span>'):('<span class=redmsg>Refunded</span>')?>
		</td>
	</tr>
	<? } ?>

 <tr>
        <td  align="right"   class="blackbold" width="20%"> <?=$ModuleIDTitle?> # : </td>
        <td   align="left" width="20%"><B><?=stripslashes($arrySale[0][$ModuleID])?></B></td>
   
        <td  align="right" width="30%"  class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
         <?=($arrySale[0]['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['InvoiceDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
	  
	  <tr>
        <td  align="right"   class="blackbold" >Ship Date  : </td>
        <td   align="left" >
         <?=($arrySale[0]['ShippedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['ShippedDate']))):(NOT_SPECIFIED)?>
		</td>
      
        <td  align="right"   class="blackbold" width="20%"> Ship From(Warehouse) : </td>
        <td   align="left" ><B><?=stripslashes($arrySale[0]['wName'])?></B></td>
       </tr>
	  <tr>
			<td  align="right"   class="blackbold" width="20%"> Customer : </td>
			<td   align="left" >

<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arrySale[0]['CustCode']?>" ><?=stripslashes($arrySale[0]["CustomerName"])?></a>
</td>
	  
			<td  align="right"   class="blackbold" width="20%"> SO/Reference Number # : </td>
			<td   align="left">
                            <b><?=(!empty($arrySale[0]['SaleID']))?(stripslashes($arrySale[0]['SaleID'])):(NOT_SPECIFIED)?></b>
                        </td>
	  </tr>
          
          
           <tr>
        <td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
		 <?=(!empty($arrySale[0]['PaymentTerm']))?(stripslashes($arrySale[0]['PaymentTerm'])):(NOT_SPECIFIED)?>
		</td>
 
 <? if($arrySale[0]['CardCharge']==1 && $arrySale[0]['CardChargeDate']>0 && $arrySale[0]['OrderPaid']<=0){  ?>
	 <td align="right" class="blackbold">Auto Card Charge on :</td>
        <td align="left">  
		<strong><?=($arrySale[0]['CardChargeDate']>0)?(date("jS", strtotime(date("Y-m-".$arrySale[0]['CardChargeDate'])))):('')?> day of month</strong>
	</td>
	<? } ?>
</tr>
          

<? if(!empty($BankAccount)){ ?>
	<tr>
			<td  align="right"   class="blackbold" > Bank Account : </td>
			<td   align="left" >
	        	 <?=$BankAccount?>
			</td>

			 
	</tr>
	<? } ?>

	  <tr>
			
	  
       <td  align="right" class="blackbold" >Created By  : </td>
       <td   align="left">
               <?
                       if($arrySale[0]['AdminType'] == 'admin'){
                               $CreatedBy = 'Administrator';
                       }else{
                               $CreatedBy = '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arrySale[0]['AdminID'].'" >'.stripslashes($arrySale[0]['CreatedBy']).'</a>';
                       }
                       echo $CreatedBy;
               ?>
         </td>
     </tr>

 <? if($arrySale[0]['CreatedDate']>0){ ?>
		<tr>
		<td  align="right"   class="blackbold" > Created Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['CreatedDate'])); ?>
		</td>
		<td  align="right"   class="blackbold" >  Updated Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['UpdatedDate'])); ?>
		</td>
		</tr>
	<? } ?>

	  <tr>
            <td  align="right"   class="blackbold" width="20%"> Sales Person : </td>
			<td   align="left" >
                            <?php if(!empty($arrySale[0]['SalesPerson'])){?>
                            <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arrySale[0]['SalesPersonID']?>" ><?=stripslashes($arrySale[0]['SalesPerson'])?></a>
                            <?php } else {?>
                            <?=NOT_SPECIFIED?>
                            <?php }?>
                        </td>
			<td  align="right"   class="blackbold" width="20%"> Invoice Status : </td>
			<td   align="left" ><?=stripslashes($arrySale[0]['InvoicePaid'])?></td>
	  </tr>

<tr>
			<td  align="right" class="blackbold">Shipping Carrier  : </td>
			<td  align="left"><?=(!empty($arrySale[0]['ShippingMethod']))?(stripslashes($arrySale[0]['ShippingMethod'])):(NOT_SPECIFIED)?>
		  </td>

		<td align="right" valign="top" class="blackbold">Shipping Method :</td>
		<td align="left" valign="top">
<?
if(!empty($arrySale[0]['ShippingMethodVal'])){	
	$arryShipMethodName = $objConfigure->GetShipMethodName($arrySale[0]['ShippingMethod'],$arrySale[0]['ShippingMethodVal']);
}
?>


<?=(!empty($arryShipMethodName[0]['service_type']))?(stripslashes($arryShipMethodName[0]['service_type'])):(NOT_SPECIFIED)?>
		</td>

	</tr>


          <tr>
		
	<? if($EcommFlag==1 || $objConfig->isHostbillActive() ){ ?>
	<td  align="right"   class="blackbold" > Order Source  : </td>
	<td   align="left" >
<?=(!empty($arrySale[0]['OrderSource']))?(stripslashes($arrySale[0]['OrderSource'])):(NOT_SPECIFIED)?>
	         
	</td>

	<td  align="right"   class="blackbold" width="20%">Fees :  </td>
        <td   align="left" >

<?php echo $arrySale[0]['Fee']; ?>


</td>

		
	<? } ?>
 
              <tr>   
			<!--td align="right" class="blackbold">GL Account :</td>
	<td align="left">

		<?=$GLAccount?>

	</td-->
			<td  align="right" class="blackbold"  > Invoice Comment : </td>
			<td  align="left">
                            <?=(!empty($arrySale[0]['InvoiceComment']))?(stripslashes($arrySale[0]['InvoiceComment'])):(NOT_SPECIFIED)?>
                             
                        </td>
	  </tr>

<tr>
<td  align="right" class="blackbold"  > Currency : </td>
			<td  align="left"> <? echo $Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']);  ?>
</td>

</tr>


<tr>


	<td  align="right" valign="top"  class="blackbold" > Customer PO#  : </td>
	<td   align="left" >
<?=(!empty($arrySale[0]['CustomerPO']))?(stripslashes($arrySale[0]['CustomerPO'])):(NOT_SPECIFIED)?>
	      
</td>
</tr>

<?php
$MainDir = $Config['FileUploadDir'].$Config['S_DocomentDir'];
 
  if(!empty($getDocumentArry)){?>


<tr>
<td  align="right" valign="top"  class="blackbold">Document :</td>

	<td   align="left" >
<?
foreach($getDocumentArry as $val){
     if(!empty($val['FileName']) && IsFileExist($Config['S_DocomentDir'], $val['FileName'])){
    	 
    	$Showfile='';
    	$checkval="1";
    	echo ''.stripslashes($val['FileName']).'&nbsp;<a href="../download.php?file='.$val['FileName'].'&folder='.$Config['S_DocomentDir'].'"  style="display: inline-block;margin-bottom:5px;" class="download">Download File</a>';
    	//echo '<input type="hidden" name="FileName" value="'.stripslashes($val['FileName']).'">';
    }
    }?>
</td>
</tr>
   <? } ?>




<?php 
 
if($arryCurrentLocation[0]['country_id']==106){ ?>
<tr>
    <td height="30" align="right" valign="top"   class="blackbold" >  Document  :</td>
    <td  align="left" valign="top" >
	
	<? 
      if(IsFileExist($Config['S_DocomentDir'], $arrySale[0]['UploadDocuments']) ){
         ?>
	<div id="IdProofDiv">
	<?=$arrySale[0]['UploadDocuments']?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arrySale[0]['UploadDocuments']?>&folder=<?=$Config['S_DocomentDir']?>" class="download">Download</a> 

	</div>
<?	}else{ echo NOT_UPLOADED;} ?>		
	
	</td>
  </tr>
 <?php } ?>
 
</table>
