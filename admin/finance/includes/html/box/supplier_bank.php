<? 
if($SuppID>0){
	$arryBank = $objSupplier->GetBank('',$SuppID,''); 
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<? if($_GET['edit']>0){ ?>	
<tr>
<td colspan="2" align="right" height="30">
<a class="fancybox add fancybox.iframe" href="editSuppBank.php?SuppID=<?=$SuppID?>">Add Bank Detail</a>
</td>
</tr>
<? } ?>

	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="10" width="100%" align="center">
   
    <?php 
	
  if(sizeof($arryBank)>0){ ?>

    <tr align="left"  >
       <td class="head1" >Bank Name</td>
        <td width="20%" class="head1" >Account Name</td>
	 <td width="20%" class="head1" >Account Number</td>

       <td width="15%"  class="head1" >Routing Number </td>
       <td width="15%"  class="head1">Swift Code </td>

     <? if($_GET['edit']>0){ ?> <td width="8%"  align="center"  class="head1 head1_action" >Action</td><?}?>
    </tr>

<?
  	$flag=true;
	$Line=0;
  	foreach($arryBank as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;
	
  ?>
    <tr align="left" class="<?=$class?>" >
     <td><?=stripslashes($values["BankName"])?></td>

	<td><?=stripslashes($values["AccountName"])?></td>
       <td><?=stripslashes($values["AccountNumber"])?></td>

	<td><?=stripslashes($values["RoutingNumber"])?></td>
	<td><?=stripslashes($values["SwiftCode"])?></td>

     <? if($_GET['edit']>0){ ?> 
<td  align="center" class="head1_inner">
  
<a href="editSuppBank.php?edit=<?=$values['BankID']?>&SuppID=<?=$SuppID?>"  class="fancybox fancybox.iframe"><?=$edit?></a>
 
<a href="editSupplier.php?del_bank=<?=$values['BankID']?>&edit=<?=$SuppID?>&tab=bank" onclick="return confirmDialog(this, 'Bank Detail')"  ><?=$delete?></a>   </td>
<? } ?>

  
     </tr>
    <?php 
	

} // foreach end //

	



?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
		 
	 
		 </td>
	</tr>	
	

</table>
<? } ?>
