<script language="JavaScript1.2" type="text/javascript">
$(document).ready(function() {
		
 	$('#total_items').closest('tr').hide();
 	$('#CategoryID').closest('tr').hide();
 	$('#All_Items').closest('tr').hide();
   	$('#Writedown_id').change(function() {
   		showHideInputs($(this).val());
		
	   });
  
   
});

function showHideInputs(str){
	if(str =='Group'){
		$('#total_items').closest('tr').show();
		$('#CategoryID').closest('tr').show();
		$('#All_Items').closest('tr').hide();
	}else if(str =='Inventory' ){
		$('#total_items').closest('tr').show();
		$('#CategoryID').closest('tr').hide();
		$('#All_Items').closest('tr').hide();
	}else if(str =='Items' ){
		$('#total_items').closest('tr').hide();
		$('#All_Items').closest('tr').show();
		$('#CategoryID').closest('tr').hide();
		$("#CategoryID").val(''); 	 
	}else{
		$('#total_items').closest('tr').hide();
		$('#CategoryID').closest('tr').hide(); 
		$('#All_Items').closest('tr').hide();
		$("#CategoryID").val('');
	} 
}


function changeformdata(type){
	$("#piGal").find('input').each(function(){
		$(this).val('');
		});
 $("#Condition").val('');
	var type = $("#Writedown_id").val();
		if(type == 'Inventory'){
			 callAjax(type,'');
			 $("#CategoryID").val('');
			 
		}else if(type == 'Group'){
			
			var catID = $("#CategoryID").val(); 
			if(catID!=''){
			callAjax(type,catID);
			}
		}
	}
function changeCondition(){

//$("#total_items").val('');
				$("#total_qty").val('');
				$("#total_cost").val('');
				$("#avg_cost").val('');



var type = $("#Writedown_id").val();
		if(type == 'Inventory'){
			 callAjax(type,'');
			 $("#CategoryID").val('');
			 
		}else if(type == 'Group'){
			
			var catID = $("#CategoryID").val(); 
			if(catID!=''){
			callAjax(type,catID);
			}
		}else{
callAjax(type,'');
}




}
function callAjax(type,catID){

var Condition = $("#Condition").val();
var All_Items = $("#All_Items").val();

//alert(All_Items);
	    $.ajax({
			type: "GET",
			url: "ajax.php?action=Getwritedata&type="+type+"&CategoryID="+catID+"&Sku="+All_Items+"&Condition="+Condition, 
			//data: Gen,			
			success: function(data) {
			//alert(data);
			var myArray = jQuery.parseJSON(data);
				$("#total_items").val(myArray.totalItems);
				$("#total_qty").val(myArray.TotQty);
				$("#total_cost").val(myArray.TotQty*myArray.price);
				$("#avg_cost").val(myArray.price);
				
			}
		   });
	    
	}


function selectCat(val)
{
	$('#CategoryID').find('option[value="'+val+'"]').prop('selected', true);
}

</script>





<div class="had">Manage <?=$MainModuleName?></div>
 <div ><a href="<?=$RedirectUrl?>" class="back">Back</a></div>


<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
 <td  valign="top">
 
<form action="" id="form1"  method="post" name="form1"  enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
            <td  align="center" valign="top" >
		  <div id="piGal">
                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
               		 <tr> 
	     				<td colspan="4" class="head" align="left">Inventory Writedown</td>
					</tr>
                    <tr>
                        <td  align="right" class="blackbold">Inventory Writedown :<span class="red">*</span></td>
                        <td  align="left">
                            <select name="Writedown_id" class="inputbox" id="Writedown_id" onchange="changeformdata(this.value)">
                                <option value="">--- Select ---</option>
                                <option value="Items" <? if($arraydetails[0]['Inv_Writedown']=='Items'){ echo "selected"; }?> >Items</option>
                                <option value="Group" <? if($arraydetails[0]['Inv_Writedown']=='Group'){ echo "selected"; }?> >Group</option>
                                <option value="Inventory" <? if($arraydetails[0]['Inv_Writedown']=='Inventory'){ echo "selected"; }?> >Inventory</option>
                            </select>
                        </td>
                    </tr>
                    
                     <tr>
                        <td  align="right" class="blackbold">All Items:<span class="red">*</span></td>
                        <td  align="left"> <input type="text" name="All_Items" id="All_Items" class="inputbox disabled" readonly value="<? echo stripslashes($arraydetails[0]['Sku']); ?>" />
                        <a class="fancybox fancybox.iframe" href="Inv_ActiveItemsList.php"><img src="../images/view.gif" border="0"></a>
                        </td>
                    </tr>
                   
                   <tr>
                        <td  align="right" class="blackbold">Category :<span class="red">*</span></td>
                        <td  align="left">
                            <select name="CategoryID" class="inputbox" id="CategoryID" onchange="changeformdata(this.value)">
                                <option value="">--- Select ---</option>
                              <?php  $objCategory->getCategories(0, 0, $_GET['CatID']); ?>
                              </select>
                        </td>
                    </tr>
		
		 <?php  $ConditionSelectedDrop = $objCondition->GetConditionDropValue();  ?>
					 <tr>
                        <td  align="right" class="blackbold">Condition :<span class="red"></span></td>
                        <td  align="left">
                            <select name="Condition" class="inputbox" id="Condition" onchange="changeCondition(this.value)" >
                                <option value="">--- Select ---</option>
                             		<?=$ConditionSelectedDrop; ?>
                              </select>
                        </td>
                    </tr>
				 	<tr>
					 <td  align="right"   class="blackbold" >Total Items:</td>
					 <td> <input type="text" name="total_items" id="total_items" class="inputbox disabled" readonly value="<? echo stripslashes($arraydetails[0]['Total_Items']); ?>" /></td>
					</tr>
					<tr>
					 <td  align="right"   class="blackbold" >Total Qty:</td>
					 <td> <input type="text" name="total_qty" id="total_qty" class="inputbox disabled" readonly value="<? echo stripslashes($arraydetails[0]['Total_Qty']); ?>" /></td>
					</tr>
					<tr>
					 <td  align="right"   class="blackbold" >Total Cost: </td>
					 <td> <input type="text" name="total_cost" id="total_cost" class="inputbox disabled" readonly value="<? echo stripslashes($arraydetails[0]['Total_Cost']); ?>" /></td>
					</tr>
					<tr>
					 <td  align="right"   class="blackbold" >Avg. Cost: </td>
					 <td> <input type="text" name="avg_cost" id="avg_cost" class="inputbox disabled" readonly value="<? echo stripslashes($arraydetails[0]['avg_Cost']); ?>" /></td>
					</tr>
					<tr>
					 <td  align="right"   class="blackbold" >Market Cost: </td>
					 <td> <input type="text" name="Market_cost" id="Market_cost" class="inputbox"  value="<? echo stripslashes($arraydetails[0]['Market_cost']); ?>" onkeypress="return isDecimalKey(event);"/></td>
					</tr>
                    <tr>
                        <td  align="right"   class="blackbold"> Status: </td>
                        <td  align="left" >
                            <select name="Status" class="inputbox" id="Status" onchange="">
                                <option value="">--- Select ---</option>
                                <option value="0" <? if($arraydetails[0]['Status']=='0'){ echo "selected"; }?> >Parked</option>
                                <option value="1" <? if($arraydetails[0]['Status']=='1'){ echo "selected"; }?>>Completed</option>
                            </select>
                        </td>
                    </tr>
                   <tr>
					 <td> <input type="hidden" name="ItemID" id="ItemID" class="inputbox"  value="<? echo stripslashes($arraydetails[0]['ItemID']); ?>" /></td>
					</tr>
				  <tr>
					 <td> <input type="hidden" name="ID" id="ID" class="inputbox"  value="<? echo stripslashes($arraydetails[0]['ID']); ?>" /></td>
					</tr>	
				</table>  
				</div>
 			</td>
  </tr>
  
  <?php
		if ($_GET['edit'] > 0) {
				$ButtonTitle = 'Update';
		}else{
				$ButtonTitle = 'Submit';
		}
  ?>      
        <tr>
         <td align="center"> <input name="Submit" type="submit" class="button" id="SubmitButton" value="<?= $ButtonTitle ?>"  /></td>
        </tr> 
        
   </table>
       

  
</form> 
        
        
</td>
</tr>
</TABLE>
<?php if ($_GET['edit'] > 0) { ?>

<script type="text/javascript">
$(document).ready(function() {
	showHideInputs('<?php echo $arraydetails[0]['Inv_Writedown']; ?>');
	selectCat('<?php echo $arraydetails[0]['CategoryID']; ?>');
	$("#Condition").find('option[value="<?php echo $arraydetails[0]['Condition']; ?>"]').prop('selected', true);
});	
</script>
<?php } ?>







