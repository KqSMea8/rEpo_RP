
<style>
.border{
    border:1px solid #ddd;
}

</style>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
        <td  align="right"   class="blackbold"  valign="top" width="45%"> Employee  : </td>
        <td   align="left" >
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryReimbursement[0]['EmpID']?>"><?=stripslashes($arryReimbursement[0]['UserName'])?></a>   

	</td>
</tr>

 <tr>
	  <td  class="blackbold" valign="top"   align="right" >Expense Reason :</td>
	  <td  align="left"   class="blacknormal" valign="top">
	<?=stripslashes($arryReimbursement[0]['ExReason'])?>
	  </td>
	</tr>

<tr>
          <td align="right"   class="blackbold" valign="top">Created Date  :</td>
          <td  align="left" >
	<?=($arryReimbursement[0]['CreatedDate']>0)?(date($Config['DateFormat'], strtotime($arryReimbursement[0]['CreatedDate']))):(NOT_SPECIFIED)?>
	      </td>
</tr>

<tr>
          <td align="right"   class="blackbold" valign="top">Apply Date  :</td>
          <td  align="left" >
	<?=($arryReimbursement[0]['ApplyDate']>0)?(date($Config['DateFormat'], strtotime($arryReimbursement[0]['ApplyDate']))):(NOT_SPECIFIED)?>
	      </td>
</tr>

 
  <tr>
		  <td  class="blackbold" valign="top"   align="right" >Comment :</td>
		  <td  align="left"   class="blacknormal" valign="top">
   <?=(!empty($arryReimbursement[0]['Comment']))?(nl2br(stripslashes($arryReimbursement[0]['Comment']))):(NOT_SPECIFIED)?>		  
		  </td>
 </tr>
 
 
  <tr>
		  <td  class="blackbold" valign="top"   align="right" >Payment Status :</td>
		  <td  align="left"   class="blacknormal" valign="top">
<? 
		 if($arryReimbursement[0]['Returned'] == '1'){
			 $StatusCls = 'green'; 
		 }else if($arryReimbursement[0]['Approved'] == '2'){
			 $StatusCls = 'red';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$arryReimbursement[0]['Status'].'</span>';	
?>		  
		  </td>
 </tr>
 
 <tr>
                    <td  class="blackbold" valign="top"   align="right"> Attached Reimbursement :</td>
                    <td  align="left"   class="blacknormal" valign="top">			
					
 <? 
	$document = stripslashes($arryReimbursement[0]['document']);
	if($document !='' &&  IsFileExist($Config['ReimDir'],$document)){ 
?>			
			
<div  id="DocDiv" >	
	<?=$document?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$document?>&folder=<?=$Config['ReimDir']?>" class="download">Download</a> 
</div>			
		 <? }else{ echo NOT_UPLOADED;}?>	
					
					 
                  				</td>
                  </tr>
                  
                  
 <? if($arryReimbursement[0]['IssueDate']>0){ ?>
  <tr>
		  <td  class="blackbold" valign="top"   align="right" >Approved Amount :</td>
		  <td  align="left"   class="blacknormal" valign="top">
<?=(!empty($arryReimbursement[0]['SancAmount']))?(round($arryReimbursement[0]['SancAmount'],2)):("0")?>
 <?=$Config['Currency']?> 	
		  
		  </td>
		</tr>      
		
		<tr>
          <td align="right"   class="blackbold" valign="top">Approved Date  :</td>
          <td  align="left" >
		<?  echo date($Config['DateFormat'], strtotime($arryReimbursement[0]['IssueDate']));
		?>
		   </td>
        </tr>
	<? } ?>
 
 
 <tr>
		  <td  class="blackbold" valign="top"   align="right" >Approved :</td>
		  <td  align="left"   class="blacknormal" valign="top">
		  <? 
		 if($arryReimbursement[0]['Approved'] == '1'){
			 $ApprovedCls = 'green'; $ApprovedStatus = 'Yes';
		 }else{
			 $ApprovedCls = 'red'; $ApprovedStatus = 'No';
		 }

		 echo '<span class="'.$ApprovedCls.'">'.$ApprovedStatus.'</span>';
		  ?>	
		  
		  </td>
 </tr>
 
 

</table>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<?php echo "<br>";?>
<div style="float:right;padding:4px;"><b>All amounts stated in <?=$Config['Currency']?></b></div>
<?php //echo "<pre>";print_r(sizeof($arryReimbursementItem));?>
 <tr><td><div align="left" class="had">Line Item</div></td></tr>
 
 <tr>
        <td  align="left"   class="border head"  valign="top"> Type</td>
        <td  align="left"   class="border head"  valign="top"> FromZip </td>
        <td  align="left"   class="border head"  valign="top"> ToZip</td>
        <td  align="left"   class="border head"  valign="top"> Mileage Rate</td>
        <td  align="left"   class="border head"  valign="top"> Total Miles</td>
        <td  align="left"   class="border head"  valign="top"> Reference </td>
        <td  align="left"   class="border head"  valign="top"> Comment</td>
        <td  align="right"   class="border head"  valign="top"> TotalRate</td>
 </tr> 
 
<?php for($Line=1;$Line<=sizeof($arryReimbursementItem);$Line++) { 
		$Count=$Line-1;?>     
        
 <tr>
         <td   class="border" align="left" >
         <?=(!empty($arryReimbursementItem[$Count]['Type']))?(stripslashes($arryReimbursementItem[$Count]['Type'])):(NOT_SPECIFIED)?>
	     </td>
	     
         <td  class="border"  align="left" >
         <?=(!empty($arryReimbursementItem[$Count]['FromZip']))?(stripslashes($arryReimbursementItem[$Count]['FromZip'])):('')?>
	     </td>
	     
	     
         <td  class="border"  align="left" >
         <?=(!empty($arryReimbursementItem[$Count]['ToZip']))?(stripslashes($arryReimbursementItem[$Count]['ToZip'])):('')?>
	     </td>
	     
	    
         <td  class="border"  align="left" >
         <?=(!empty($arryReimbursementItem[$Count]['MileageRate']))?(stripslashes($arryReimbursementItem[$Count]['MileageRate'])):('')?>
	     </td>
	     
	    
         <td  class="border"  align="left" >
         <?=(!empty($arryReimbursementItem[$Count]['TotalMiles']))?(stripslashes($arryReimbursementItem[$Count]['TotalMiles'])):('')?>
	     </td>
	     
	     
         <td  class="border"  align="left" >
         <?=(!empty($arryReimbursementItem[$Count]['Reference']))?(stripslashes($arryReimbursementItem[$Count]['Reference'])):('')?>
	     </td>
	     
	 
         <td  class="border"  align="left" >
         <?=(!empty($arryReimbursementItem[$Count]['ReimComment']))?(stripslashes($arryReimbursementItem[$Count]['ReimComment'])):('')?>
	     </td>
	     
	     <td  class="border"  align="right" >
         <?=(!empty($arryReimbursementItem[$Count]['TotalRate']))?(stripslashes($arryReimbursementItem[$Count]['TotalRate'])):(NOT_SPECIFIED)?>
	     </td>
</tr>

<? } $TotalAmount = $arryReimbursement['0']['TotalAmount']; echo "<br>";?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr style="float:right"><td><div align="right">Grand Total : <?=$TotalAmount?></div></td></tr>
</table>


</table>



  



