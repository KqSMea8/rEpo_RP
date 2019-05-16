<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>  <span>&raquo; <?=$ModuleName?></span>
</div>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red"><?=$errMsg?></div>
 <? } 
  

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
#include("includes/html/box/po_recieve.php");

?>

<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){



	var qty_left=0; var qty=0; var total_qty=0; var total_qty_left=0; 
	var total_received=0; var total_qty_received=0;
	var to_return=0; var total_to_return=0;
	var total_returned=0; 

	var EditReturnID = Trim(document.getElementById("OrderID")).value;
	var EditReturnOrderID = Trim(document.getElementById("RecieveOrderID")).value;
	//alert(EditReturnID);

	if(EditReturnID>0){
		ShowHideLoader('1','S');
		return true;	
	}
     
	

    if(!ValidateForSelect(frm.RecieveDate, "Receive Date")){
			return false;
		}
	

	var NumLine = parseInt($("#NumLine").val());
		
	
	for(var i=1;i<=NumLine;i++){
		if(document.getElementById("item_id"+i) != null){
			qty_left = 0; qty = document.getElementById("qty"+i).value;
			total_received = document.getElementById("total_received"+i).value;
			total_returned = document.getElementById("total_returned"+i).value;
			
			to_return = total_received - total_returned;
		
			if(to_return > 0){

				if(!ValidateOptNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
					return false;
				}			
				if(qty > to_return){
					alert("Qauntity must be be less than or equal to "+to_return+" for this item.");
					document.getElementById("qty"+i).focus();
					return false;
				}else{
					total_qty += +$("#qty"+i).val();
				}

				total_to_return += +to_return;
				
			}

			total_qty_received += +total_received;


		}
	}


	
	//if(total_qty_received<=0){
		//alert("No qauntities has been received for this order.");
		//return false;
	//}else
		
	if(total_to_return<=0){
		alert("No qauntities left to Receive for this order.");
		return false;
	}else if(total_qty<=0){
		alert("Please enter qauntity to Receive for any item.");
		return false;
	}

	


	if(ModuleVal!=''){
		var Url = "isRecordExists.php?RecieveID="+escape(ModuleVal)+"&editID=";
		SendExistRequest(Url,"RecieveID", "Receive No");
		return false;	
	}else{
		ShowHideLoader('1','S');
		return true;	
	}
	
		
}
</script>

<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

<tr>
	 <td align="left"><? include("includes/html/box/transfer_order_view.php");?></td>
</tr>




<tr>
    <td >
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >

			
			<tr>
				 <td colspan="4" align="left" class="head">Receive Information</td>
			</tr>
			

	 

 <tr>
	<td  align="right"   class="blackbold" width="20%"> Receive No# : </td>
	<td align="left">
	<?php if(!empty($_GET['view'])){?>
	 <?=$arryTransfer[0]['RecieveID'];?>
	<?php } else {?>
	<input name="ReturnID" type="text" class="datebox" id="RecieveID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','RecieveID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_ModuleID"></span>
	<?php }?>
	</td>
  
        <td  align="right"   class="blackbold" >Item Receive Date  :</td>
        <td   align="left" >
	<?php if(!empty($_GET['view'])){
	$arryTime = explode(" ",$Config['TodayDate']);
	$ReturnDate = ($arryTransfer[0]['RecieveDate']>0)?($arryTransfer[0]['RecieveDate']):($arryTime[0]); 
	echo $ReturnDate;
	?>
	
	<?php } else {?>
		<script type="text/javascript">
		$(function() {
			$('#RecieveDate').datepicker(
				{
				showOn: "both",
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+10?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true

				}
			);
		});
</script>

<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$ReturnDate = ($arryTransfer[0]['RecieveDate']>0)?($arryTransfer[0]['RecieveDate']):($arryTime[0]); 
?>
<input id="RecieveDate" name="RecieveDate" readonly="" class="datebox" value="<?=$ReturnDate?>"  type="text" > 
<?php }?>

</td>
      </tr>
 
	
 	<tr>
		<td  align="right" class="blackbold"> Comments  : </td>
		<td align="left">
		 <?php echo stripslashes($arryTransfer[0]['RecieveComment']); ?>          
		</td>
	
         <td  align="right"   class="blackbold"> Mode of Transport  : </td>
		 <td   align="left" ><?=$arryTransfer[0]['transport']?>   </td>
          </tr>			   
		      
			

			 <tr>
		  		<td align="right"   class="blackbold" valign="top">Package Count :</td>
		  		<td  align="left" >
		    			<?=$arryTransfer[0]['packageCount']?>		          
				</td>
			
		  		<td align="right"   class="blackbold" valign="top">Package Type :</td>
		  		<td  align="left" ><?=$arryTransfer[0]['PackageType']?> 
						          
				</td>
				<tr>
		  		<td align="right"   class="blackbold" valign="top">Weight :</td>
		  		<td  align="left" >
		    			<?=$arryTransfer[0]['Weight']?>	          
				</td>
			</tr>


			
		
			</table>
			</td>
			</tr>
<tr>
	 <td align="right">
<?
echo $CurrencyInfo = str_replace("[Currency]",$arryTransfer[0]['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" >Receive Item
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="../inventory/vTransfer.php?pop=1&view=<?=$refID?>" ><?=VIEW_ORDER_DETAIL?></a></div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>



	 </td>
</tr>

<tr>
	<td align="left">
	<? if(!empty($_GET['view'])){ ?>	
		<?php include("includes/html/box/transfer_item_recieve_view.php");?>
	<?php } ?>
	
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

	<tr>
	<td  align="center">

		<? if($HideSubmit!=1){ ?>	
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Process"  />
		<? } ?>
		<?php if(empty($_GET['rtn'])){?>
		<input type="hidden" name="RecieveOrderID" id="RecieveOrderID" value="<?=$_GET['tn']?>" readonly />
		
		<?php }?>
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
		

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



