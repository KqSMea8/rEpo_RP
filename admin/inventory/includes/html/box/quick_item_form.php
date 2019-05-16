<script language="JavaScript1.2" type="text/javascript">
//function validateItem(frm){

	

	//if( ValidateForSimpleBlank(frm.Sku,"Item Sku")
		//&&ValidateForSimpleBlank(frm.description, "Item Description")
		//&& ValidateForTextareaMand(frm.description,"description",10,300)
		//&& ValidateForSelect(frm.CategoryID,"Category")
		//&& ValidateForSelect(frm.itemType,"Item Type")
		//&& ValidateForSelect(frm.procurement_method,"Procurement Method")
		//&& ValidateForSelect(frm.evaluationType,"valuation Type")		
		
		//){
			
					
					
				
                  //var Url = "isRecordExists.php?Sku="+escape(document.getElementById("Sku").value)+"&editID="+document.getElementById("ItemID").value+"&Type=Inventory";
				  //alert(Url);
                                  
                                  //SendExistRequest(Url,"Sku", "Item Sku "+document.getElementById("Sku").value);
					//SendExistRequest(Url,'Item Sku '+document.getElementById("Sku").value);
		  	
		                  // return false;
				
					
			//}else{
					//return false;	
			//}	

		
//}



 $(document).ready(function() {    
     $("#SubmitButton").click(function(e) {
		 e.preventDefault();
//alert("aaaaaaaa");
var Sku=$( "#Sku" ).val();
var description=$( "#description" ).val();
var CategoryID=$( "#CategoryID" ).val();
var Taxable=$( "#Taxable" ).val();
var Status=$("#Status").val();
var SelID =1;
$.ajax({
        type: 'post',
        url: '../ajax_post.php',
				data: {
						action:'itemAdd',
						Sku:Sku,
						description:description,
						CategoryID:CategoryID,
						Taxable:Taxable,
						Status:Status,	
				},
				dataType: "JSON",
     success: function (responseText) {

 window.parent.location.reload();
 window.close();

        }
    });

return false;

}); });





</script>



<div class="e_right_box">

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
                                            
                                                <input name="Sku" type="text" class="inputbox"  id="Sku" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>"   maxlength="30"/>

<span id="MsgSpan_Display"></span>
                                                    <!--<input  name="Sku" id="Sku" onkeypress="return isAlphaKey(event);" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>" type="text" class="inputbox"  maxlength="30" />	--> </td>
                                            </tr>
                                            
                                            <tr>
                                                <td  align="right"   class="blackbold" >Item Description :<span class="red">*</span> </td>
                                                <td  height="30" align="left">
                                                    <input  type="text" name="description" class="inputbox" id="description" value="<? echo stripslashes($arryProduct[0]['description']); ?>"/>	 </td>
                                            </tr>
                                            
                                              <tr>
                                                <td  align="right"   class="blackbold" >Category /SubCategory : </td>
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
                                              <tr style="display:none;">
                                                <td  align="right"   class="blackbold" >Item Type :  <span class="red">*</span> </td>
                                                <td  height="30" align="left">
                                                   <select name="itemType" id="itemType" class="inputbox">
                                                        <option value="">Select Item Type</option>
															<? for($i=0;$i<sizeof($arryItemType);$i++) {?>
															<option value="<?=$arryItemType[$i]['attribute_value']?>" <?  if($arryItemType[$i]['attribute_value']==$arryProduct[0]['itemType']){echo "selected";}?>>
															<?=$arryItemType[$i]['attribute_value']?>
															</option>
														<? } ?>   
                                                        </select>
                                                        </td>
                                            </tr>
                                            
                                             
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
                                             <tr style="display:none;">
                                                <td align="right"   class="blackbold" >Valuation Type :  <span class="red">*</span> </td>
                                                <td  height="30" align="left">
                                                   <select name="evaluationType" id="evaluationType" class="inputbox">
                                                        <option value="">Select Valuation</option>
														   <? for($i=0;$i<sizeof($arryEvaluationType);$i++) {?>
															<option value="<?=$arryEvaluationType[$i]['attribute_value']?>" <?  if($arryEvaluationType[$i]['attribute_value']==$arryProduct[0]['evaluationType']){echo "selected";}?>>
															<?=$arryEvaluationType[$i]['attribute_value']?>
															</option>
														<? } ?> 
                                                        </select>
                                                        </td>
                                            </tr>
                                        
                                        
                                           <tr style="display:none;">
                                                <td align="right"   class="blackbold" >Unit Measure: </td>
                                                <td height="30" align="left">
                                                    <!--<input  name="UnitMeasure" id="UnitMeasure" value="<? echo stripslashes($arryProduct[0]['UnitMeasure']); ?>" type="text" class="inputbox"  size="30" maxlength="100" />-->	
													
													
													 <select name="UnitMeasure" id="UnitMeasure" class="inputbox">
                                                        <option value="">Select Unit Measure</option>
															<? for($i=0;$i<sizeof($arryUnit);$i++) {?>
															<option value="<?=$arryUnit[$i]['attribute_value']?>" <?  if($arryUnit[$i]['attribute_value']==$arryProduct[0]['UnitMeasure']){echo "selected";}?>>
															<?=$arryUnit[$i]['attribute_value']?>
															</option>
														<? } ?>   
                                                        </select>
													</td>
                                            </tr>
                                            

                                         <tr>
               <td  align="right" class="blackbold">Taxable  :</td>
               <td   align="left">

<input type="checkbox" name="Taxable" id="Taxable" value="Yes" <?  echo "checked";?>>
       
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

               $PostedByID = (!empty($arryProduct[0]['PostedByID'])?($arryProduct[0]['PostedByID']):("1"));

                                        if (sizeof($arryCategory) <= 0)
                                            $DisabledButton = 'disabled';
                                        ?>
                                        <input name="Submit" type="submit"  class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "   />
                                        <input type="hidden" name="ItemID" id="ItemID" value="<? echo $_GET['edit']; ?>" />
                                        <input type="hidden" name="MaxProductImage" id="MaxProductImage" value="<? echo $MaxProductImage; ?>" />
                                        <input type="hidden" name="OldStatus" id="OldStatus" value="<?= $arryProduct[0]['Status'] ?>" >
                                        <input type="hidden" name="non_inventory" id="non_inventory" value="No" />
                                       </td>
                                </tr>

                            </form>
                        </table>
                   
</div>
