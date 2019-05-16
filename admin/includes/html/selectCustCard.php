<script language="JavaScript1.2" type="text/javascript">
 
function ResetSearch(){	
	$("#prv_msg_div").show();	 
	$("#preview_div").hide();
}
function SetCard(CardID,CustID){
	ResetSearch();
		
	var CrdType =  $("#CrdType").val();       
			
	var SendUrl = "&action=CustomerCardInfo&CardID="+escape(CardID)+"&CustID="+escape(CustID)+"&r="+Math.random();

   	$.ajax({
	type: "GET",
	url: "ajax.php",
	data: SendUrl,
	dataType : "JSON",
	success: function (responseText)
	 {	
		 
		parent.$("#CreditCardInfo"+CrdType).show();	 

		parent.$("#CreditCardID"+CrdType).val(responseText["CardID"]);	 
		parent.$("#CreditCardType"+CrdType).val(responseText["CardType"]);	 
 		parent.$("#CreditCardNumber"+CrdType).val(responseText["CardNumber"]);
		parent.$("#CreditCardNumberTemp"+CrdType).val(responseText["CardNumberTemp"]);
		parent.$("#CreditExpiryMonth"+CrdType).val(responseText["ExpiryMonth"]);	 
		parent.$("#CreditExpiryYear"+CrdType).val(responseText["ExpiryYear"]);	 
 		parent.$("#CreditSecurityCode"+CrdType).val(responseText["SecurityCode"]);
		parent.$("#CreditCardHolderName"+CrdType).val(responseText["CardHolderName"]);

		parent.$("#CreditAddress"+CrdType).val(responseText["Address"]);
		parent.$("#CreditCountry"+CrdType).val(responseText["CountryCode"]);
		parent.$("#CreditState"+CrdType).val(responseText["State"]);
		parent.$("#CreditCity"+CrdType).val(responseText["City"]);
		parent.$("#CreditZipCode"+CrdType).val(responseText["ZipCode"]);


		if(window.parent.document.getElementById("ConfirmPayment") != null){
			parent.$(".CreditCardAdd").hide();	 			
			parent.$(".ConfirmButton").show();	 			
		}
		


		parent.jQuery.fancybox.close();
		ShowHideLoader('1','P');
		

	
		   
	}

   });
				


}




</script>

<div class="had">Select Credit Card</div>
<? if(!empty($ErrorMsg)){ 
		echo $ErrorMsg; 
 }else{ ?>	 
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left"  >
	<td class="head1" >Card Number</td>
	<td width="15%" class="head1" >Card Type</td>
	<td width="15%" class="head1" >Card Holder Name</td>
	<td width="20%"  class="head1" >Expiry Date</td>
	<td width="15%"  class="head1">Address</td>
	<td width="15%"  class="head1">Comment</td>     
    </tr>
   
    <?php 
 if($num>0){ 
  	$flag=true;
	$Line=0;
  	foreach($arryCard as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;
	/*
	 unset($arryCardNumber); 
	$arryCardNumber = explode("-",$values["CardNumber"]);
	if($values["CardType"]=='Amex'){
		$CardNumber = 'xxxx-xxxxxx-'.$arryCardNumber[2];
	}else{
		$CardNumber = 'xxxx-xxxx-xxxx-'.$arryCardNumber[3];
	}*/

	$CardNumber = CreditCardNoX($values["CardNumber"],$values["CardType"]);


	$ExpiryStatus = CheckCardExpiry($values["ExpiryMonth"], $values["ExpiryYear"]);

	$ExpiryStatusVal = strtolower(strip_tags($ExpiryStatus));
  ?>
   <tr align="left" class="<?=$class?>" >
     <td>
<? if($ExpiryStatusVal=='expired'){?>
<?=$CardNumber?>
<? }else{?>
<a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetCard('<?=$values["CardID"]?>','<?=$values["CustID"]?>');"><?=$CardNumber?></a>
<? } ?>
	


</td>

	<td><?=stripslashes($values["CardType"])?></td>
       <td><?=stripslashes($values["CardHolderName"])?></td>

	<td><?=$values["ExpiryMonth"].'-'.$values["ExpiryYear"]?>

<?=$ExpiryStatus?>
</td>
	<td><?=stripslashes($values["Address"])?></td>
<td><?=stripslashes($values["Comment"])?></td>
      

  
     </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="6"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>    </td>
  </tr>
  </table>

  </div> 

  
</form>
</td>
	</tr>
</table>

<input type="hidden" name="CrdType" id="CrdType" value="<?=$_GET['type']?>" class="textbox">


<? } ?>
