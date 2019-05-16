<?
if(!empty($SuppCode)){
$_GET['SuppCode'] = $SuppCode;
$arryCredit=$objPurchase->ListCreditNote($_GET);
if(sizeof($arryCredit)>0){ 
?>


<table width="100%" border="0" cellpadding="5" cellspacing="5">
<tr>
	  <td  valign="top" class="had2">
Credit Memo 
	</td>
</tr>
<tr>
		 <td  align="left" >

<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
   
    <tr align="left"  >
		<td  class="head1" >Credit Memo ID#</td>
		<td width="18%" class="head1" >Posted Date</td>
		<td width="18%"  class="head1" >Expiry Date</td>

		<td width="18%" align="center" class="head1" >Amount</td>
		<td width="10%" align="center" class="head1" >Currency</td>
		<td width="12%"  align="center" class="head1" >Status</td>
		 <td width="8%"  align="center" class="head1" >Approved</td>
    </tr>
   
    <?php 
  if(is_array($arryCredit) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCredit as $key=>$values){
	$flag=!$flag;
	$Line++;
	$class=($flag)?("oddbg"):("evenbg");
	
  ?>
  <tr align="left"  class="<?=$class?>">
       <td>

<a class="fancybox fancybig fancybox.iframe" href="vPoCreditNote.php?pop=1&view=<?=$values['OrderID']?>" ><?=$values["CreditID"]?></a>



</td>
      <td height="20">
	 <? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
       <td>   <? if($values['ClosedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ClosedDate']));
		?></td>
	
     
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>


     <td align="center">
	 <? 
		 if($values['Status'] =='Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'red';
		 }

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';
		
	 ?>
	 
	</td>
    	    <td align="center"><? 
		 if($values['Approved'] ==1){
			  $Approved = 'Yes';  $ApprovedCls = 'green';
		 }else{
			  $Approved = 'No';  $ApprovedCls = 'red';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$Approved.'</span>';
		
	 ?></td>
    </tr>
    <?php } // foreach end //?> 
   <!--tr align="center" >
      <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?> </td>
    </tr-->
 
    <?php } ?>
  
	
  </table>




	</td>    
    </tr>
  </table>

<? }
}
 ?>


