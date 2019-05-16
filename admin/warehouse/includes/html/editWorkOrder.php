
<a href="<?= $RedirectURL ?>" class="back">Back</a>



<div class="had">
    <?= $MainModuleName ?>    <span>&raquo;
        <? echo (!empty($_GET['edit'])) ? ("Edit " . $ModuleName) : ("Add " . $ModuleName); ?>

    </span>
</div>
<? if (!empty($errMsg)) { ?>
    <div align="center"  class="red" ><?php echo $errMsg; ?></div>
    <?
}



if (!empty($ErrorMSG)) {
    echo '<div class="message" align="center">' . $ErrorMSG . '</div>';
} else {
    #include("includes/html/box/po_form.php");
    ?>


    <script language="JavaScript1.2" type="text/javascript">
        function validateForm(frm) {
            NumLine = parseInt($("#NumLine").val());


            //var DsmID = Trim(document.getElementById("DsmID")).value;

            //document.getElementById("sku"+i)

            if (ValidateForSimpleBlank(frm.WON, "Work Order Number")
                    && ValidateForSelect(frm.BOM, "BOM Number")
                    && ValidateForSelect(frm.WoCondition, "Condition ")
                    && ValidateForSimpleBlank(frm.WoQty, "Work Order quantity")
                    && ValidateForSelect(frm.warehouse, "Warehouse Location ")

                    ) {



                for (var i = 1; i <= NumLine; i++) {
                    if (document.getElementById("sku" + i) != null) {
                        if (!ValidateForSelect(document.getElementById("sku" + i), "Sku")) {
                            return false;
                        }
											
                        if (!ValidateMandNumField2(document.getElementById("BomQty" + i), "Quantity", 1, 999999)) {
                            return false;
                        }


                    }
                }

                var Url = "isRecordExists.php?checkWorkOrder=" + escape(document.getElementById("WON").value) + "&editID=" + document.getElementById("edit").value;
//alert(Url);return false;
                SendExistRequest(Url,frm.WON, "Work Order Number");
                //return true;
return false;

            } else {
                return false;
            }

        }

$(function() {
    //$('#OrderType').hide(); 
    $('#OrderType').change(function(){
        if($('#OrderType').val() == 'Order') {
            $('#sale').show(); 
        } else {
            $('#sale').hide(); 
        } 
    });


if($('#OrderType').val() == 'Order') {
            $('#sale').show(); 
        }


});

function SearchBomSelect(key){


 var Bom = document.getElementById("BOM").value = '';
if(key==''){

return false;
}
ShowHideLoader('1', 'P');

       var SelID = 1;
      
        var SendUrl = "&action=SearchBomCode&key="+escape(key)+"&r="+Math.random();
 $.ajax({
            type: "GET",
            url: "../sales/ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {
           
                   if(responseText["Sku"] == undefined){
													//alert('Item Sku [ '+key+' ] is not exists.');
													DisplayConMsg(document.getElementById("BOM"),'Alert','BOM does not exists.');
													document.getElementById("BOM").value='';
													document.getElementById("item_id").value='';
													document.getElementById("description").value='';
													document.getElementById("WoQty").value='';
													ShowHideLoader('2', 'P');
                   }else{ 

												$reqitem = (responseText["RequiredItem"]) ? responseText["RequiredItem"]+'#' : '';  
												document.getElementById("req_item").value =  responseText["KitItems"];
												//if(document.getElementById("req_item").value) $("#sku"+SelID).closest('tr').addClass('parent').css("background-color", "#106db2"); 

													document.getElementById("BOM").value=responseText["Sku"];
													document.getElementById("item_id").value=responseText["ItemID"];
													document.getElementById("description").value=responseText["description"];
													document.getElementById("WoQty").value='1';
													//document.getElementById("sku" + SelID).focus();         
													ShowHideLoader('2', 'P');  
addComponentItem(1);               
                      }

            }
        });


}
function SetAutoCompleteBom(elm){		
	$(elm).autocomplete({
		source: "../jsonNonKitSku.php",
		minLength: 1
	});

}
   function addComponentItem(row) { 
			
			//inputstr = row.find('input[name^="sku"]').val().toLowerCase();           //By chetan 3Sep//
			var req_item = $('#req_item').val();
			if(req_item != ''){
				var req_itm_sp = req_item.split("#");	
				var req_item_length = req_itm_sp.length;
//alert(req_item_length);

			}	
	
			

		<!--FOR ITEM ADD CODE -->
 var NumLine =  parseInt($("#NumLine").val());		 
if(req_item_length > 0 && NumLine < req_item_length){
for(var r = 2; r<=req_item_length; r++){
$("#addrow").click();
}

 NumLine =  parseInt($("#NumLine").val());


for(var s = 0; s < req_item_length; s++){
var reqItem = req_itm_sp[s];
var req_itm_sp_pipe = reqItem.split("|");


for(var m = 1; m<=NumLine; m++){
if(document.getElementById("sku"+m) != null){
if(document.getElementById("sku"+m).value == "")
	{
		//$("#sku"+m).closest('tr').css("background-color", "#d33f3e").addClass('child'); 
		document.getElementById("item_id"+m).value = req_itm_sp_pipe[0];
		document.getElementById("sku"+m).value = req_itm_sp_pipe[1];
		document.getElementById("description"+m).value = req_itm_sp_pipe[2];
		document.getElementById("qty"+m).value = (req_itm_sp_pipe[3]) ? req_itm_sp_pipe[3] : 1;   
		
		/****************************************************************/
	document.getElementById("sku"+m).setAttribute("class", "disabled");
	document.getElementById("sku"+m).setAttribute("readonly", "readonly");
		document.getElementById("qty"+m).setAttribute("class", "disabled");
		document.getElementById("qty"+m).setAttribute("readonly", "readonly");
		document.getElementById("parent_ItemID"+m).value = $("item_id").val(); 
		document.getElementById("Org_Qty"+m).value = (req_itm_sp_pipe[3]) ? req_itm_sp_pipe[3] : 1;  
                       $("#sku"+m).next('a').attr('onclick','return false;');              
			
		break;	
}		

}	
}		
}
//By Chetan 12Jan//		
		//showTotalPrice();
}	
			
		<!--END ITEM ADD CODE-->
		        
		//row.find('input[name^="add_req_flag"]').val('1');		

			
		}


 function UpdateWOqty() {
            NumLine = document.getElementById("NumLine").value;
            //alert(NumLine);
            var totval = parseInt(0);
            for (var i = 1; i <= NumLine; i++) {
                if (document.getElementById("WoQty").value != '') {
                    document.getElementById("qty" + i).value = document.getElementById("Org_Qty" + i).value * document.getElementById("WoQty").value;
                    //document.getElementById("amount" + i).value = document.getElementById("qty" + i).value * document.getElementById("price" + i).value;

                   // var TotValue = document.getElementById("amount" + i).value;

                    //totval = parseInt(totval) + parseInt(TotValue);
                } else {
                    document.getElementById("qty" + i).value = document.getElementById("Org_Qty" + i).value;

                }

            }

            //document.getElementById("TotalValue").value = parseInt(totval);
        }
    </script>








    <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                        <tr>
                            <td colspan="2" align="left" class="head">
                                Work Order Information</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	 


<tr>

 <td  align="right"   class="blackbold" > Work Order From:   </td>
                                        <td  align="left"><select name="OrderType" id="OrderType" class="textbox">
                                                <option value="Standard"  <? if ($arryWorkOrder[0]['OrderType']=='Standard') { echo "selected"; } ?> >Standard</option>
<option value="Order" <? if ($arryWorkOrder[0]['OrderType']=='Order' || $_GET['so']>0) { echo "selected"; } ?>>Sales Order</option>
</select></td>
</tr>

                                 <tr id="sale" style="display:none;">
                                        <td  align="right"   class="blackbold" > Sales Order:   </td>
                                        <td  align="left">
                                        <input  name="SaleID" id="SaleID" value="<?= $arryWorkOrder[0]['SaleID'] ?>" readonly="readonly" type="text" class="disabled" size="7"  maxlength="30" />
<a class="fancybox fancybox.iframe" href="WoSoList.php"><img border="0" src="../images/view.gif"></a>
                                         <input  name="OrderID" id="OrderID" value="<?= $arryWorkOrder[0]['OrderID'] ?>" readonly="readonly" type="hidden" class="disabled"  maxlength="30" />	
                                        

                   </td>
                                   
                                        <td  align="right"   class="blackbold" > Customer:   </td>
                                        <td  align="left">
                                            <input  name="CustomerName" id="CustomerName" value="<?= $arryWorkOrder[0]['CustomerName'] ?>" readonly="readonly" type="text" class="disabled"  maxlength="30" />	<input  name="CustCode" id="CustCode" value="<?= $arryWorkOrder[0]['CustCode'] ?>" readonly="readonly" type="hidden" class="disabled"  maxlength="30" />	
                                         <input  name="CustID" id="CustID" value="<?= $arryWorkOrder[0]['CustID'] ?>" readonly="readonly" type="hidden" class="disabled"  maxlength="30" />	
                                        
                                          
                                           

                                        </td>
                                    </tr> 


                                    <tr>
                                        <td  align="right"   class="blackbold" > Work Order Number:  <span class="red">*</span> </td>
                                        <td  align="left">
                                           

<input name="WON" type="text" class="datebox" id="WON"  value="<?=(!empty($arryWorkOrder[0]['WON']))?($arryWorkOrder[0]['WON']):($NextModuleID) ?>"   maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isUniqueKey(event);" oncontextmenu="return false" onBlur="Javascript:ClearSpecialChars(this);CheckAvailField('MsgSpan_ModuleID','WON','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
	<span id="MsgSpan_ModuleID"></span>
                                           
</td>
                   
  <td  align="right"   class="blackbold" > Date:   </td>
                                        <td  align="left">
																					<script type="text/javascript">
																							$(function() {
																								$('#SchDate').datepicker(
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
																																										  <input  name="SchDate" id="SchDate" value="<?=(!empty($arryWorkOrder[0]['SchDate']))?($arryWorkOrder[0]['SchDate']):(date('Y-m-d'));?>"   type="text" class="datebox" size="10"  maxlength="50" /></td>
                                
                                      
                                    </tr>

 <tr>

 <td  align="right"   class="blackbold" > BOM:  <span class="red">*</span> </td>
                                        <td  align="left">
                                            <input  name="BOM" id="BOM" value="<?=(!empty($arryWorkOrder[0]['BOM']))?($arryWorkOrder[0]['BOM']):('');?>"  onclick="Javascript:SetAutoCompleteBom(this);"  type="text" class="textbox" size="10" onblur="SearchBomSelect(this.value)"  maxlength="50" /><a class="fancybox fancybox.iframe" href="WoBOMList.php"><img border="0" src="../images/view.gif"></a>
                                            <input  name="item_id" id="item_id" value="<?=(!empty($arryWorkOrder[0]['ItemID']))?($arryWorkOrder[0]['ItemID']):('');?>" type="hidden"  class="inputbox"  maxlength="30" />
 <input  name="bomID" id="bomID" value="<?=(!empty($arryWorkOrder[0]['bomID']))?($arryWorkOrder[0]['bomID']):('');?>" type="hidden"  class="inputbox"  maxlength="30" />
 <input  name="req_item" id="req_item" value="<?=(!empty($arryWorkOrder[0]['req_item']))?($arryWorkOrder[0]['req_item']):('');?>" type="hidden"  class="inputbox"  maxlength="30" />
</td>
  <td  align="right"   class="blackbold" > Description:   </td>
                                        <td align="left">


                                            <input  name="description" id="description" value="<?=(!empty($arryWorkOrder[0]['description']))?($arryWorkOrder[0]['description']):('');?>" type="text"  size="50"  class="inputbox" style="width:350px;"  maxlength="200" />

                                        </td>
</tr>

 <tr>
                                       
																																								
                       <td  align="right"   class="blackbold" > Condition:  <span class="red">*</span> </td>
                                        <td  align="left">
                                            <select name="woCondition"  id="woCondition" class="textbox"   style="width:80px;"><option value="">Select </option><?=$ConditionSelectedDrop?></select>
                                          
                                           

                                        </td>          
                                   



                                        <td  align="right"   class="blackbold" > WO Quantity:  <span class="red">*</span> </td>
                                        <td  align="left">
                                            <input  name="WoQty" id="WoQty" onchange="return UpdateWOqty();"  value="<?=(!empty($arryWorkOrder[0]['WoQty']))?($arryWorkOrder[0]['WoQty']):('');?>" type="text"   class="textbox" size="10"  maxlength="30" />
                                          
                                           

                                        </td>


 
                                    </tr>

 
                                    <tr>
                                     <td  align="right"   class="blackbold" > Warehouse Location:  <span class="red">*</span> </td>
                                        <td  align="left">
                                        <!--<input  name="warehouse" id="warehouse" value="" readonly="readonly" type="text" class="disabled"  maxlength="30" />-->	
                                        <!--<input  name="WID" id="WID" value="" type="hidden"  class="inputbox"  maxlength="30" />	-->
                                            <select name="warehouse" id="warehouse" class="textbox">
                                                <option value="">Select Location</option>
                                                <? 
if(empty($arryWorkOrder[0]['warehouse'])) $arryWorkOrder[0]['warehouse']='';

for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                                    <option value="<?= $arryWarehouse[$i]['WID'] ?>" <?
                                                    if ($arryWarehouse[$i]['WID'] == $arryWorkOrder[0]['warehouse']) {
                                                        echo "selected";
                                                    }
                                                    ?>>
                                                                <?= $arryWarehouse[$i]['warehouse_name'] ?>
                                                    </option>
                                                <? }
                                                ?>                                                     
                                            </select>

                   </td>  
                               <td  align="right"   class="blackbold" > Priority:   </td>
                                        <td align="left">
<? if(empty($arryWorkOrder[0]['Priroty'])) $arryWorkOrder[0]['Priroty']=''; ?>
<select name="Priroty" id="Priroty" class="textbox">
<option value="">Select</option>
<option value="High"  <? if ($arryWorkOrder[0]['Priroty']=='High') { echo "selected"; } ?> >High</option>
<option value="Low" <? if ($arryWorkOrder[0]['Priroty']=='Low') { echo "selected"; } ?>>Low</option>
<option value="Meadium" <? if ($arryWorkOrder[0]['Priroty']=='Meadium') { echo "selected"; } ?>>Meadium</option>
</select>
                                            
                                        </td>         

</tr>
                                   
 



                                    <tr>

  
<td  align="right"   class="blackbold" >Status  : </td>
                                        <td   align="left" >
                                            <select name="Status" id="Status" class="textbox">
                                               
                                                <option value="2" <?
                                                if ($arryWorkOrder[0]['Status'] == 2) {
                                                    echo "selected";
                                                }
                                                ?>>Completed</option>
                                                <option value="0" <?
                                                if ($arryWorkOrder[0]['Status'] == 0) {
                                                    echo "selected";
                                                }
                                                ?>> Parked</option>
                                            </select>
                                        </td>

                                    </tr>



                                </table>

                            </td>
                        </tr>






                      
                       
                            <tr>
                                <td colspan="2" align="left" class="head" >Component</td>
                            </tr>
                       
                        
                            <tr>
                                <td align="left" colspan="2">

                                    <?
                                    //require_once("includes/html/box/wo_bom_form.php");
 require_once("includes/html/box/work_order_item_form.php");

                                    ?>
                                   
                                </td>
                            </tr>
                    

                    </table>	


                </td>
            </tr>
            <?
	$disNone ='';
            if ($_GET['edit'] > 0) {
                if ($arryWorkOrder[0]['Status'] == 2 || $arryWorkOrder[0]['Status'] == 1) {
                    $disNone = "style='display:none;'";
                } 
		$ButtonTitle = 'Update ';
            } else {
                $ButtonTitle = ' Submit ';
		
            }
            ?>
            <tr <?= $disNone ?>>
                <td  align="center">






                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    <input type="hidden" name="edit" id="edit" value="<?= $_GET['edit'] ?>" />
                    



                </td>
            </tr>

        </table>

    </form>


<? } ?>


<? echo '<script>SetInnerWidth();</script>'; ?>
    <script>
 $(document).ready(function() {


        $(".slnoclass2").fancybox({
            'width': 300
        });



    });
function SetBomComplete(elm){		
	$(elm).autocomplete({
		source: "../jsonBomSku.php",
		minLength: 1
	});

}

</script><? //include("includes/html/box/bomPopUpForDis.php");?>
