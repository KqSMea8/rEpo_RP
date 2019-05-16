<script language="JavaScript1.2" type="text/javascript">
function multipleShip(){	
   var vals = []
   $('input:checkbox[name="ship_check[]"]').each(function() {
       if (this.checked) {
           vals.push(this.value);
       }
   });
	
	
	var CustCode = window.parent.document.getElementById("CustCode").value;		
	var SendUrl = "&action=SetMultiShipment&CustCode="+escape(CustCode)+"&OrderIDs="+vals+"&r="+Math.random();
	 
	if(vals!=''){		
	   	$.ajax({
		type: "GET",
		url: "../warehouse/ajax.php",
		data: SendUrl,		
		success: function (responseText)
		 {
			
			parent.$("#MultipleShipDetail").html(responseText);
			parent.$("#multipleShip").val(vals);
	 		parent.jQuery.fancybox.close();	
		
		}

	   });

	}

  
	
}

</script>

<?php if(sizeof($arryDetail)>0){?>
<div class="had">Shipment Information</div>
<form name="form1" action=""  method="post"  enctype="multipart/form-data">
<div id="button"></div>


 


<table <?=$table_bg?>>
   <tr class="even">
	 <td colspan="7"   align="left" > <input name="Submit" type="button" onClick="Javascript:multipleShip();" class="button"
			id="SubmitButton" value="Select"> </td>
</tr>
 

    <tr align="left"  >
	  <td width="8%"  align="center" class="head1 head1_action" >Select</td>
      <td  class="head1" >Shipment Date</td>
      <td  width="15%"   class="head1"  >Shipment #</td>
      <td width="15%"  class="head1"  >SO #</td>
      <td width="15%" align="center" class="head1" >Amount</td>
      <td width="10%" align="center" class="head1" >Currency</td>
<td width="10%" align="center" class="head1" >Status</td>
      
    
    </tr>
   
    <?php 
  if(is_array($arryDetail)){


  	$flag=true;
	$Line=0;
  	foreach($arryDetail as $key=>$values){
	$flag=!$flag;
	 
	$Line++;
	
	//$TotalGenerateShipment = $objSale->GetQtyShipmented($values['OrderID']);
  ?>
    <tr align="left"   >
	 <td  align="center" class="head1_inner">
      <input id="ship" name="ship_check[]" value="<?=$values['OrderID']?>" type="checkbox">

</td> 
	  </td>
	   <td height="20">
	   <? if($values['ShippedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ShippedDate']));
	   ?>
	   
	   </td>
       <td><?=$values["ShippingID"]?></td>
	  
        <td> <a class="fancybox po fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?php echo $values['SaleID'] ?>"> <?php echo $values['SaleID'] ?></a></td>


       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['CustomerCurrency']?></td>
<td align="center">
<?
if($values['ShipmentStatus'] == 'Shipped'){
	$cls ='green';
}else{
	$cls ='red';
}
?>
<span class="<?=$cls?>"><?=$values['ShipmentStatus']?></span>


</td>

     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
   
    <?php } ?>

  </table>
  
  
 
  
  </form>
  <?php }else{?>
 	<table>

	<tr>
		<td align="center"><span class="red">No Record Found</span></td>
	
	</tr>


</table>
  <?php }?>
  
