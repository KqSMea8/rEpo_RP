<?  
if($CustID>0){
	$arryCard = $objCustomer->GetCard('',$CustID,''); 

	
?>

<? if($_GET['edit']>0){ ?>	
<br><br>
<a class="fancybox add fancybox.iframe" href="../editCustCard.php?CustID=<?=$CustID?>">Add Credit Card</a>
<br><br>
<? } ?>


<table id="myTable" cellspacing="1" cellpadding="10" width="100%" align="center">
   


    <tr align="left"  >
       <td class="head1" >Card Number</td>
        <td width="10%" class="head1" >Card Type</td>
	 <td width="15%" class="head1" >Card Holder Name</td>

       <td width="13%"  class="head1" >Expiry Date</td>
	<td width="13%"  class="head1" >Security Code </td>
       <td width="13%"  class="head1">Address </td>
	 <td width="10%"  class="head1">Comment </td>
     <? if($_GET['edit']>0){ ?> <td width="8%"  align="center"  class="head1 head1_action" >Action</td><?}?>
    </tr>

<?
 if(sizeof($arryCard)>0){ 
  	$flag=true;
	$Line=0;
  	foreach($arryCard as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;
	
	
	$ExpiryStatus = CheckCardExpiry($values["ExpiryMonth"], $values["ExpiryYear"]);

  ?>
    <tr align="left" class="<?=$class?>" >
     <td>

	<? /*unset($arryCardNumber); 
	$arryCardNumber = explode("-",$values["CardNumber"]);
	if($values["CardType"]=='Amex'){
		echo 'xxxx-xxxxxx-'.$arryCardNumber[2];
	}else{
		echo 'xxxx-xxxx-xxxx-'.$arryCardNumber[3];
	}*/
	echo CreditCardNoX($values["CardNumber"],$values["CardType"]);
	?> 


<?=($values["DefaultCard"]==1)?('<span class=red>[Default]</span>'):('')?></td>

	<td><?=stripslashes($values["CardType"])?></td>
       <td><?=stripslashes($values["CardHolderName"])?></td>

	<td><?=$values["ExpiryMonth"].'-'.$values["ExpiryYear"]?>  
	<?=$ExpiryStatus?>
	</td>
		<td><?
	if($values["CardType"]=='Amex'){
		echo 'xxxx';
	}else{
		echo 'xxx';
	}
?></td>
	<td><?=stripslashes($values["Address"])?></td>
<td><?=stripslashes($values["Comment"])?></td>
     <? if($_GET['edit']>0){ ?> 
<td  align="center" class="head1_inner">
  
<a href="../editCustCard.php?edit=<?=$values['CardID']?>&CustID=<?=$CustID?>"  class="fancybox fancybox.iframe"><?=$edit?></a>
 
 
<a href="editCustomer.php?del_card=<?=$values['CardID']?>&CustID=<?=$CustID?>&tab=card" onclick="return confirmDialog(this, 'Credit Card')"  ><?=$delete?></a>  
 

 </td>
<? } ?>

  
     </tr>
    <?php 
	

} // foreach end //

	



?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record" colspan="9"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
		 
<input type="hidden" name="CurrentDivision" id="CurrentDivision" value="<?=strtolower($CurrentDepartment)?>">	 	 
		
<? } ?>
