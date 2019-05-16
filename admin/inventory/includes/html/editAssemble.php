
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
            var NumLine = parseInt($("#NumLine").val());




            var asmID = Trim(document.getElementById("asmID")).value;

            //document.getElementById("sku"+i) 

            if (ValidateForSelect(frm.Sku, "Bill Number")
		    && ValidateForSelect(frm.bomCondition, "Condition")
                    && ValidateForSelect(frm.warehouse, "Warehouse Location")
                    && ValidateForSimpleBlank(frm.assembly_qty, "Assembly quantity")
                    // && ValidateForSimpleBlank(frm.serial_qty, "Serial Number")

                    ) {

             //alert(document.getElementById("serialized").value);

              if (document.getElementById("Serialized").value == "Serialized" || document.getElementById("Serialized").value == "Serialized Average")
                {
                    
                    
                    if (document.getElementById("serial_value").value == "")
                    {
                        //alert("Return Qty SerialQtyShould be Less Than Or Equal To Invoice Qty.");
                        alert(" Please add  serial number.");
                        document.getElementById("assembly_qty").focus();
                        return false;
                    }

                }


 
                var avilQty = 0;
                var inQty = 0;
                var totalSum = 0;
                for (var i = 1; i <= NumLine; i++) {
         
                    avilQty = document.getElementById("on_hand" + i).value;

                    //var SerialQty = document.getElementById("serial_number" + i).value;
                    inQty = document.getElementById("qty" + i).value;

                    totalSum += parseInt(inQty);
                    if (parseInt(inQty) > parseInt(avilQty))
                    {
                        //alert("Return Qty SerialQtyShould be Less Than Or Equal To Invoice Qty.");
                        alert(" Qauntity must  be less than qty on hand for this item.");
                        document.getElementById("qty" + i).focus();
                        return false;
                    }
                    
                    
                    
              if (document.getElementById("valuationType"+i).value == "Serialized" || document.getElementById("valuationType"+i).value == "Serialized Average")
                {
                    
                    
                    if (document.getElementById("serial_value" + i).value == "")
                    {
                        //alert("Return Qty SerialQtyShould be Less Than Or Equal To Invoice Qty.");
                         alert(" Please select component serial number.");
                        document.getElementById("serial_value" + i).focus();
                        return false;
                    }

                }
                    
                    if (document.getElementById("Condition"+i).value  == '')
                    {
                        
                        alert(" Please select component Condition.");
                        document.getElementById("Condition" + i).focus();
                        return false;
                    }

                }
                //alert(totalSum);return false;
                totalSum = parseInt(totalSum, 10);
                if (totalSum == 0)
                {
                    alert("Component qty should not be blank.");
                    document.getElementById("qty1").focus();
                    return false;
                } else {
                    ShowHideLoader('1', 'S');
                    false
                    return true;
                }

                var Url = "isRecordExists.php?checkItem=" + escape(document.getElementById("Sku").value) + "&editID=" + document.getElementById("asmID").value;

                //SendExistRequest(Url,frm.Sku, "Assembly Item");
                return true;


            } else {
                return false;
            }

        }


        function UpdateAssembleqty() {
            NumLine = document.getElementById("NumLine").value;
            //alert(NumLine);
            var totval = parseInt(0);
            for (var i = 1; i <= NumLine; i++) {
                if (document.getElementById("assembly_qty").value != '') {
                    document.getElementById("qty" + i).value = document.getElementById("bomqty" + i).value * document.getElementById("assembly_qty").value;
                    document.getElementById("amount" + i).value = document.getElementById("qty" + i).value * document.getElementById("price" + i).value;

                    var TotValue = document.getElementById("amount" + i).value;

                    totval = parseInt(totval) + parseInt(TotValue);
                } else {
                    document.getElementById("qty" + i).value = document.getElementById("bomqty" + i).value;

                }

            }

            document.getElementById("TotalValue").value = parseInt(totval);
        }

        $(document).ready(function() {
            $('#addItem').on('click', function() {
                var qty = $('#assembly_qty').val();
                 var Availqty = $('#on_hand_qty').val();
                var serial_Num = $('#serial_Num').val();
                var serial_sku = $('#Sku').val();
                var warehouse = $('#warehouse').val();

                 if (qty != '' && warehouse != '' && serial_sku != '' ) {

                    var linkhref = $('#addItem').attr("href") + '&total=' + qty + '&sku=' + serial_sku + '&warehouse=' + warehouse+'&serial_value_sel='+serial_Num;
                    $('#addItem').attr("href", linkhref);
                } else {
                    if (warehouse == '') {
                        alert("Please Select Warehouse Location.")
                        $('#warehouse').focus();
                        return false;
                    }
                    if (qty == '') {
                        alert("Please Enter Assembly Qty.")
                        $('#assembly_qty').focus();
                        return false;
                    }

                   
                }

            });
        });

function BinListSend(){


		var OtherOption = '';
		if(document.getElementById("OtherBin") != null){
			OtherOption = '&other=1';
		}
		var SelectOption = '';
		if(document.getElementById("SelectOption") != null){
			SelectOption = '&select=1';
		}
		
		//document.getElementById("MainBinTitleDiv").style.display = 'inline';

		document.getElementById("bin_td").innerHTML = '<select name="bin_id" class="inputbox" id="bin_id" ><option value="">Loading...</option></select>';
		
		if(document.getElementById("bin_id") != null){
			
			
			var SendUrl = 'ajax.php?action=bin&warehouse_id='+document.getElementById("warehouse").value+'&Sku='+document.getElementById("Sku").value+'&current_bin='+document.getElementById("main_bin_id").value+SelectOption+OtherOption+'&r='+Math.random()+'&select=1';
			

			httpObj.open("GET", SendUrl, true);

			httpObj.onreadystatechange = function BinListRecieve(){
 //alert(httpObj.responseText);
				if (httpObj.readyState == 4) {
					//alert(httpObj.responseText);
					document.getElementById("bin_td").innerHTML  = httpObj.responseText;
										
				}
			};
			httpObj.send(null);
			
		}

	}

function SearchBill(Key){
  
var DataExist =0;
 var DsmID = document.getElementById("asmID").value;
//alert(bomID);
if(document.getElementById("Sku").value==''){
return false;
}
DataExist = CheckAvailField('MsgSpan_Display','Sku',DsmID);
//alert(DataExist);
//DataExist = CheckExistingData("isRecordExists.php","&bom_Sku="+escape(Key)+"&editID="+bomID, "Sku","Bill Number");
  


  var SendUrl = "&action=BillNumberCode&key="+escape(Key)+"&r="+Math.random();
        /******************/
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: SendUrl,
            dataType : "JSON",
            success: function (responseText) {

             if(responseText == null){
                 //alert('Item Sku [ '+document.getElementById("bom_Sku").value+' ] is not exists.');
                document.getElementById('MsgSpan_Display').innerHTML="<span class=redmsg>Bom! is not exists.</span>";
                   document.getElementById("Sku").value='';
                   document.getElementById("bomCondition").value='';
                   document.getElementById("item_id").value='';
                   document.getElementById("description").value='';
                   document.getElementById("on_hand_qty").value='';
                   document.getElementById("price").value='';
                   
                  }else{

if(responseText["bill_option"] == 'No'){

		location.href="editAssemble.php?bc="+responseText["bomID"];
	}else{
	
		$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'OptionList.php?edit='+responseText["bomID"]+'&link=editAssemble.php',
                                type: 'iframe',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });
		//location.href ="OptionList.php?edit="+bomCode;

	}
		          /* document.getElementById("Sku").value=responseText["Sku"];
		           document.getElementById("bomCondition").value=responseText["Condition"];
		           document.getElementById("item_id").value=responseText["ItemID"];
		           document.getElementById("description").value=responseText["description"];
		            document.getElementById("on_hand_qty").value=responseText["on_hand_qty"];
		            document.getElementById("price").value=responseText["sell_price"];
                                  document.getElementById("disassembly_qty").focus();*/

		           
               }
           


            }
        });
        /******************/
  

}


function frameBillDisplay(){

 var sku = document.getElementById("Sku").value;
 var cond = document.getElementById("bomCondition").value;
var total = document.getElementById("assembly_qty").value;
//var link ='../warehouse/addSerial.php?id='+ln+'&cond='+cond+'&sku='+sku+'';
//alert(link);
//openIframe(link)
$.fancybox.open({
                                padding : 0,
                                closeClick  : false, // prevents closing when clicking INSIDE fancybox
                                href:'editBillSerial.php?total='+total+'&cond='+cond+'&sku='+sku,
                                type: 'iframe',
  width:'70%', height:'70%',
                                helpers   : { 
                                                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
                                            }
                            });

}
    </script>


<div class="message"><? if (!empty($_SESSION['mess_asm'])) {
                echo $_SESSION['mess_asm'];
                unset($_SESSION['mess_asm']);
            } ?>
            </div>
    <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

        <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                        <tr>
                            <td colspan="2" align="left" class="head">
                                Assembly Information</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	 




                                    <tr>
                                        <td  align="right"   class="blackbold" > Bill Number:  <span class="red">*</span> </td>
                                        <td height="30" align="left">
                                            <input  name="Sku" id="Sku" value="<?= $arryAssemble[0]['Sku'] ?>"   type="text" class="textbox" size="30" onclick="Javascript:SetBomComplete(this);"   maxlength="50" onBlur="Javascript:return SearchBill(this.value);  " />
                                            <input  name="item_id" id="item_id" value="<?= $arryAssemble[0]['item_id'] ?>" type="hidden"  class="inputbox"  maxlength="30" />
                                            <input  name="on_hand_qty" id="on_hand_qty" value="<? if(isset($arrayItem[0]['qty_on_hand'])) echo $arrayItem[0]['qty_on_hand']; ?>" type="hidden"  class="inputbox"  maxlength="30" />	
                                            <input  name="ref_code" id="ref_code" value="<?= $ref_code ?>" type="hidden"  class="inputbox"  maxlength="30" />

                                        <? if (empty($_GET['edit'])) {
                                         echo '<a  class="js-open-modal" href="#" id="click_to_load_modal_popup" >' . $search . '</a>	';
                                            //echo '<a  class="js-open-modal" href="#" data-modal-id="popup1" >' . $search . '</a>';
                                        } ?>
</br><span id="MsgSpan_Display"></span>
  <td  align="right"   class="blackbold" > Item Condition:  <span class="red">*</span> </td>
                                        <td height="30" align="left">


                                           <select name="bomCondition" id="bomCondition" class="inputbox">
<option value="">Select Condition</option>
<?=$ConditionDrop?>
</select>

                                        </td>
                                   </tr>

<tr>
                                        <td  align="right"   class="blackbold" > Description:   </td>
                                        <td height="30" align="left">


                                            <input  name="description" id="description" value="<?= $arryAssemble[0]['description'] ?>" type="text"  size="30"  class="inputbox" style="width:350px;"  maxlength="150" />

                                        </td>
                             
			<td  align="right"   class="blackbold" > Available Quantity:   </td>
			<td height="30" align="left">
			    <input  name="on_hand_qty" id="on_hand_qty"  value="<? if(isset($arrayItem[0]['qty_on_hand'])) echo $arrayItem[0]['qty_on_hand']; ?>" type="text" readonly  class="disabled" size="10"  maxlength="30" />

			</td>
		</tr>

	<tr>
		<td  align="right"   class="blackbold" > Warehouse Location:  <span class="red">*</span> </td>
		<td height="30" align="left">
			<select name="warehouse" id="warehouse" class="inputbox" onChange="Javascript: BinListSend();">
			<option value="">Select Location</option>
			<? 

if(!isset($arryAssemble[0]['warehouse_code'])) $arryAssemble[0]['warehouse_code']='';

for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
			<option value="<?= $arryWarehouse[$i]['WID'] ?>" <?
			if ($arryWarehouse[$i]['warehouse_code'] == $arryAssemble[0]['warehouse_code']) {
			echo "selected";
			}
			?>>
			<?= $arryWarehouse[$i]['warehouse_name'] ?>
			</option>
			<? }
			?>                                                     
			</select>
		</td>
	</tr>

	<tr style="display:none;"> 
		<td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Bin Location :<span class="red">*</span></td>
		<td  align="left" id="bin_td" class="blacknormal">&nbsp;</td>
	</tr>
<tr>                         
<td  align="right"   class="blackbold" > Assembly Quantity:  <span class="red">*</span> </td>
<td height="30" align="left">
<? if(!isset($arryAssemble[0]['valuationType'])) $arryAssemble[0]['valuationType']=''; 

if(!isset($arryAssemble[0]['serial_name'])) $arryAssemble[0]['serial_name']='';
if(!isset($arryAssemble[0]['assembly_qty'])) $arryAssemble[0]['assembly_qty']='';
if(!isset($arryAssemble[0]['Comment'])) $arryAssemble[0]['Comment']='';
?>

<input  name="assembly_qty" id="assembly_qty"  onblur="return UpdateAssembleqty();" value="<?= $arryAssemble[0]['assembly_qty'] ?>" type="text"   class="textbox" size="10"  maxlength="30" />

 <input  name="Serialized" id="Serialized"  value="<?= $arryAssemble[0]['valuationType'] ?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
<? if ((($arryAssemble[0]['valuationType'] == 'Serialized' || $arryAssemble[0]['valuationType'] == 'Serialized Average' ) ) || $arryAssemble[0]['serial_name'] !='') { ?>
      <!--a  class="fancybox slnoclass2 fancybox.iframe" href="BillSerial.php?id=<?= $_GET['bc'] ?>" id="addItem"><img src="../images/tab-new.png"  title="Serial number">  Add S.N</a>--
      <!--input  name="serial_Num" id="serial_Num"  value="<?=$arryAssemble[0]['serial_name']?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
     <input  name="serial_qty" id="serial_qty"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" /-->
 <span id="serialqty1"></span><span   id="serial"><a href="#" onclick="frameBillDisplay();"  ><img src="../images/tab-new.png"  title="Serial number">&nbsp;Add S.N.</a>
                       
                    </span>

<?php 
if(empty($arryAssemble[0]["serial_value"])) $arryAssemble[0]["serial_value"]='';
if(empty($arryAssemble[0]["serial_Price"])) $arryAssemble[0]["serial_Price"]='';
if(empty($arryAssemble[0]["serial_desc"])) $arryAssemble[0]["serial_desc"]='';

 if($arryAssemble[0]["serial_name"]!='' && $_GET['edit']!=''){  $arryAssemble[0]["serial_value"] = $arryAssemble[0]["serial_name"]; }  //print_r($arryAssemble); ?>
<input type="hidden" name="valuationType" id="valuationType" value="<?= stripslashes($arryAssemble[0]['valuationType']) ?>" readonly maxlength="20"  />
        <input type="hidden" name="serial_value" id="serial_value" value="<?= stripslashes($arryAssemble[0]["serial_value"]) ?>" readonly   />           
 <input type="hidden" name="serial_Price" id="serial_Price" value="<?= stripslashes($arryAssemble[0]["serial_Price"]) ?>" readonly   />
 <input type="hidden" name="serial_desc" id="serial_desc" value="<?= stripslashes($arryAssemble[0]["serial_desc"]) ?>" readonly   />
<? } ?>




                                        </td>
                                   
                                   
                                   
                                        <td  align="right"   class="blackbold" >Status  : </td>
                                        <td   align="left" >
                                            <select name="Status" id="Status" class="inputbox">
                                                <option value="">Select Status</option>

                                                <option value="2" <? if ($arryAssemble[0]['Status'] == 2) {
        echo "selected";
    } ?>>Completed</option>
                                                <option value="0" <? if ($arryAssemble[0]['Status'] == 0) {
        echo "selected";
    } ?>> Parked</option>

                                            </select>


                                        </td>
                                    </tr>

<tr>
	<td  align="right"   class="blackbold" velign="top" > Comment:   </td>
			<td height="30" align="left">
			   <textarea name="Comment" id="Comment" class="inputbox" maxlength="30"><?=stripslashes($arryAssemble[0]['Comment'])?></textarea>
			</td>
		</tr>


<? if(!empty($arryOptionCat[0]['optionID'])){?>
                                 <tr>
                                        <td  align="right"   class="blackbold" >Option Code  : </td>
                                        <td   align="left" >
                                            <a class="fancybox fancybox.iframe" href="vOptionBill.php?optionID=<?=$arryOptionCat[0]['optionID']?>&curP=1&bom_id=<?=$_GET['bc']?>&bom_code="> <?=$arryOptionCat[0]['option_code']?></a>
                                       
                                        </td>
                                    </tr>
<? }?>      

                                </table>

                            </td>
                        </tr>






                        <tr>
                            <td colspan="2" align="right">
    <?
//$Currency = (!empty($arryPurchase[0]['Currency']))?($arryPurchase[0]['Currency']):($Config['Currency']); 
//echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
    ?>	 
                            </td>
                        </tr>
                 <? if (!empty($arryAssemble[0]['bomID']) || !empty($_GET['edit'])) { ?>
                            <tr>
                                <td colspan="2" align="left" class="head" >Kit Item</td>
                            </tr>

                            <tr>
                                <td align="left" colspan="2">
                            <? require_once("includes/html/box/assemble_item_form.php");?>
                                </td>
                            </tr>
   		 <? } ?>

                    </table>	


                </td>
            </tr>
    <? if ($_GET['edit'] > 0) {
        if ($arryAssemble[0]['Status'] == 2 || $arryAssemble[0]['Status'] == 1) {
            $disNone = "style='display:none;'";
        } $ButtonTitle = 'Update ';
    } else {
        $ButtonTitle = ' Submit ';
    } ?>
            <tr >
                <td  align="center">
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
                    <input type="hidden" name="asmID" id="asmID" value="<?= $_GET['edit'] ?>" />
                    <input type="hidden" name="bomID" id="bomID" value="<?= $BomID ?>" />
                    <input type="hidden" name="main_bin_id" id="main_bin_id"  value="<? if(isset($arryAssemble[0]['bin_id'])) echo $arryAssemble[0]['bin_id']; ?>" />
                    <input type="hidden" name="PrefixPO" id="PrefixPO" value="<?= $PrefixPO ?>" />
                    <input type="hidden" name="ModuleIDValue" id="ModuleIDValue" value="<? if(isset($arryAssemble[0]['asm_code'])) echo  $arryAssemble[0]['asm_code'] ?>  " />


                </td>
            </tr>

        </table>

    </form>


<? } ?>

<!--<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />-->

<!--<script type="text/javascript" language="javascript" src="js/bootstrap.js"></script>-->
        

    <script type="text/javascript">

$(document).ready(function(){
var $modal = $('#load_popup_modal_show_id');
$('#click_to_load_modal_popup').on('click', function(){
//ShowHideLoader('1','P');


$modal.load('asm_bom_list.php?link=editAssemble.php',{'id1': '1', 'id2': '2'},function() { 
$modal.modal('show'); ShowHideLoader('2','P');
});
//$('#load_popup_modal_show_iddd').('show');

//ShowHideLoader('');
});

$('#bom_Sku').focus();
});

 
 $(document).ready(function() {


        $(".slnoclass2").fancybox({
            'width': 800
        });



    });

</script>
<script>
BinListSend();
function SetBomComplete(elm){		
	$(elm).autocomplete({
		source: "../jsonBomSku.php",
		minLength: 1
	});

}
</script>

<div id="load_popup_modal_show_id" class="modal fade" tabindex="-1"></div>
<? #include("includes/html/box/bomPopUpForDis.php");?>
