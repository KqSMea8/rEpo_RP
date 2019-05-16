<style>
 .validation
    {
      color: red;
      margin-bottom: 20px;
    }
</style>

<script language="JavaScript1.2" type="text/javascript">

			
					
					
				
                  //var Url = "isRecordExists.php?Sku="+escape(document.getElementById("Sku").value)+"&editID="+document.getElementById("ItemID").value+"&Type=Inventory";
				  //alert(Url);
                                  
                                  //SendExistRequest(Url,"Sku", "Item Sku "+document.getElementById("Sku").value);
					//SendExistRequest(Url,'Item Sku '+document.getElementById("Sku").value);
		  	
		                   //return false;
				
					
	



 $(document).ready(function() {    
     $("#SubmitButton").click(function(e) {
		 e.preventDefault();
//alert("aaaaaaaa");
var Sku=$( "#Sku" ).val();
var description=$( "#description" ).val();
var CategoryID=$( "#CategoryID" ).val();
var sale_tax=$( "#sale_tax_rate" ).val();
var itemType=$( "#itemType" ).val();
var Status=$("#Status").val();
var SelID =$("#selectid").val();
var focusSet = false;

if (!$('#Sku').val()) {
        if ($("#Sku").parent().next(".validation").length == 0) // only add if not added
        {
            $("#Sku").parent().after("<span class='validation' style='color:red;'>Please enter item sku</span>");
        }
        e.preventDefault(); // prevent form from POST to server
        $('#Sku').focus();
        focusSet = true;
    } else {
        $("#Sku").parent().next(".validation").remove(); // remove it
    }

if (!$('#description').val()) {
        if ($("#description").parent().next(".validation").length == 0) // only add if not added
        {
            $("#description").parent().after("<span class='validation' style='color:red;'>Please enter item description</span>");
        }
        e.preventDefault(); // prevent form from POST to server
        $('#description').focus();
        //focusSet = true;
		if (!focusSet) {
				  $("#description").focus();
return false;
			}
    } else {
        $("#description").parent().next(".validation").remove(); // remove it
    }

if (!$('#CategoryID').val() ) {
        if ($("#CategoryID").parent().next(".validation").length == 0) // only add if not added
        {
            $("#CategoryID").parent().after("<span class='validation' style='color:red;'>Please select  category</span>");
        }
        e.preventDefault(); // prevent form from POST to server
        $('#CategoryID').focus();
        //focusSet = true;
		if (!focusSet) {
				  $("#CategoryID").focus();
return false;
			}
    } else {
        $("#CategoryID").parent().next(".validation").remove(); // remove it
    }

 
$.ajax({
        type: 'post',
        url: '../ajax_post.php',
	data: {
		action:'itemAdd',
		Sku:Sku,
		description:description,
		CategoryID:CategoryID,
		sale_tax_rate:sale_tax,
		Status:Status,
		itemType:itemType,
		
	},
	dataType: "JSON",
        success: function (responseText) {

//alert(responseText);
//return false;


 										window.parent.document.getElementById("sku" + SelID).value = responseText["Sku"];
                    window.parent.document.getElementById("item_id" + SelID).value = responseText["ItemID"];
                    window.parent.document.getElementById("description" + SelID).value = responseText["description"];
                    window.parent.document.getElementById("qty" + SelID).value = '1';
                    window.parent.document.getElementById("on_hand_qty" + SelID).value = '0';
                    window.parent.document.getElementById("price" + SelID).value = '0.00';
                    window.parent.document.getElementById("item_taxable" + SelID).value = responseText["sale_tax_rate"];

 										parent.ProcessTotal();
                    /**********************************/


                    parent.jQuery.fancybox.close();
                    ShowHideLoader('1', 'P');
        //$('#success__para').html("You data will be saved");
        }
    });

return false;

}); });


 //window.parent.document.getElementById("sku1").value = document.getElementById("Sku").value;
 //window.parent.document.getElementById("description1").value = document.getElementById("description").value;
 //window.parent.document.getElementById("qty1").value = 1;
 //window.parent.document.getElementById("price1").value = 0.00;



</script>



<div class="e_right_box">
<div id="Erromsg" style="color:red;"></div>
 <table width="100%"   border="0" cellpadding="0" cellspacing="0">
  <tr>
   <td  align="center" valign="middle" >     
   <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
    <form  method="post" onsubmit="return submitdata();"  enctype="multipart/form-data">
                                <tr>
                                    <td align="center" valign="top" >
                                        <table width="100%" border="0" cellpadding="3" cellspacing="1"  class="borderall">
       
                                      
                                        
                                         <tr>
                                                <td width="45%" align="right"   class="blackbold" >Item Sku:  <span class="red">*</span> </td>
                                                <td  height="30" align="left">
                                            
                                                <input name="Sku" type="text" class="inputbox"  id="Sku" value="<? echo stripslashes($_GET['Sku']); ?>"   maxlength="30"/>

<span id="MsgSpan_Display"></span>
                                                    <!--<input  name="Sku" id="Sku" onkeypress="return isAlphaKey(event);" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>" type="text" class="inputbox"  maxlength="30" />	--> </td>
                                            </tr>
                                            
                                            <tr>
                                                <td  align="right"   class="blackbold" >Item Description :<span class="red">*</span> </td>
                                                <td  height="30" align="left">
                                                    <input  type="text" name="description" class="inputbox" id="description" value="<? echo stripslashes($arryProduct[0]['description']); ?>"/>	 </td>
                                            </tr>
                                            
                                              <tr>
                                                <td  align="right"   class="blackbold" >Category /SubCategory : <span class="red">*</span></td>
                                                <td  height="30" align="left">
                                                    <select name="CategoryID" id="CategoryID" class="inputbox">
			                            <option value="">Select Category</option>
                                                    <?php 
                                                    
                                                       foreach($listAllCategory as $key=>$value){
                                                        
                                                        $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);
                                                        
                                                    
                                                             ?>
                                                     <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;<?php echo $value['Name'];?></option>
                                                    <?php 
                                                    
                                                     foreach ($arrySubCategory as $key => $value) {
                                                      $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);
                                                    ?>
                                                     <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                     
                                                     <?php
                                                     foreach ($arrySubCategory as $key => $value) { 
                                                         $arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']); 
                                                         ?>
                                                      <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                      <?php
                                                     foreach ($arrySubCategory as $key => $value) { ?>
                                                      <option value="<?php echo $value['CategoryID'];?>" <?php if($_GET['ParentID']==$value['CategoryID']){echo "selected";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo $value['Name'];?></option>
                                                     <?php 
                                                         }
                                                        }
                                                     
                                                      }
                                                    } 
                                                     ?>
                                                    </select>	
                                                
                                                </td>
                                            </tr>
<?php if($arryMainmenuSection['Manage BOM']==1)
    	{ ?>
                                              <tr >
                                                <td  align="right"   class="blackbold" >Item Type :   </td>
                                                <td  height="30" align="left">
                                                   <select name="itemType" id="itemType" class="inputbox">
                                                       
															<? for($i=0;$i<sizeof($arryItemType);$i++) {?>
															<option value="<?=$arryItemType[$i]['attribute_value']?>" <?  if($arryItemType[$i]['attribute_value']==$arryProduct[0]['itemType']){echo "selected";}?>>
															<?=$arryItemType[$i]['attribute_value']?>
															</option>
														<? } ?>   
                                                        </select>
                                                        </td>
                                            </tr>
                                            
                                           <? }?> 
                                             <tr style="display:none;">
                                                <td align="right"   class="blackbold" >Procurement Method :  <span class="red">*</span> </td>
                                                <td  height="30" align="left">
                                                    
                                                    <?=$dropList?>
                                                   <!--<select name="procurement_method" id="procurement_method" class="inputbox">
												   <option value="">Select Procurement Method</option>
													<? for($i=0;$i<sizeof($arryProcurement);$i++) {?>
														<option value="<?=$arryProcurement[$i]['attribute_value']?>" <?  if($arryProcurement[$i]['attribute_value']==$arryProduct[0]['procurement_method']){echo "selected";}?>>
														<?=$arryProcurement[$i]['attribute_value']?>
														</option>
													<? } ?>
                                                        
                                                        </select>-->
                                                        </td>
                                            </tr>
                                           
                                        
                                        
                                            

																<tr>
																	<td  align="right"   class="blackbold" >Sale Tax Rate :  </td>
																			<td   align="left">
																				<select name="sale_tax_rate" id="sale_tax_rate" class="inputbox">
																					<option value="Yes" <? if($ItemSaleTax == 'yes'){ echo 'selected';}?>>Yes </option>
																					<option value="No" <? if($ItemSaleTax == 'no'){ echo 'selected';}?>>No</option>
																				</select>
																			</td>
																</tr>
                                          
                                            
                                            
                                            <tr>
                                                <td align="right"   class="blackbold">Status  </td>
                                                <td height="30" align="left"><span class="blacknormal">
                                                        <?
                                                        $ActiveChecked = ' checked';
                                                        if ($_GET['edit'] > 0) {
                                                            if ($arryProduct[0]['Status'] == 1) {
                                                                $ActiveChecked = ' checked';
                                                                $InActiveChecked = '';
                                                            }
                                                            if ($arryProduct[0]['Status'] == 0) {
                                                                $ActiveChecked = '';
                                                                $InActiveChecked = ' checked';
                                                            }
                                                        }
                                                        ?>
                                                    <input type="radio" name="Status" id="Status" value="1" <?= $ActiveChecked ?>>Active&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="Status" id="Status" value="0" <?= $InActiveChecked ?>>InActive    </span></td>
                                            </tr> 
                                            
                                            
                                            
                                            
                                             
                                                    </table>	</td>
                                            </tr>
                                  
                                        
                                       
          
                                        </table>
                                    </td>
                                </tr>
                                <tr><td align="center">
                                       
                                        <?php
                                        if ($_GET['edit'] > 0)
                                            $ButtonTitle = 'Update'; else
                                            $ButtonTitle = 'Submit';

                                      
                                        if (sizeof($arryCategory) <= 0)
                                            $DisabledButton = 'disabled';
                                        ?>
                                        <input name="Submit" type="submit"  class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
													<input type="hidden" name="ItemID" id="ItemID" value="<? echo $_GET['edit']; ?>" />
													<input type="hidden" name="MaxProductImage" id="MaxProductImage" value="<? echo $MaxProductImage; ?>" />
													<input type="hidden" name="OldStatus" id="OldStatus" value="<?= $arryProduct[0]['Status'] ?>" >
													<input type="hidden" name="selectid" id="selectid" value="<?= $_GET['selectid'] ?>" >
<? if($Config['TrackInventory']=='1') { $TrckInv = 'Yes';}else{ $TrckInv = 'No';}?>
													<input type="hidden" name="non_inventory" id="non_inventory" value="<?=$TrckInv?>" />
                                       </td>
                                </tr>

                            </form>
                        </table>
                   
</div>
