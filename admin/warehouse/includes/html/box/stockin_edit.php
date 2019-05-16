
<script language="JavaScript1.2" type="text/javascript">



    function SendEventExistRequest(Url) {

        var SendUrl = Url + "&r=" + Math.random();
        httpObj.open("GET", SendUrl, true);
        httpObj.onreadystatechange = function RecieveEventRequest() {


            if (httpObj.readyState == 4) {

                if (httpObj.responseText == 1) {
                    alert("Warehouse code already exists in database. Please enter another.");
                    document.getElementById("warehouse_code").select();
                    return false;
                } else if (httpObj.responseText == 2) {
                    alert("Warehouse name already exists in database. Please enter another.");
                    document.getElementById("warehouse_name").select();
                    return false;
                } else if (httpObj.responseText == 0) {
                    document.forms[0].submit();
                } else if (httpObj.responseText == 3) {
                    alert("Bin Location already exists in database. Please enter another.");
                    document.getElementById("binlocation").select();
                    return false;
                } else if (httpObj.responseText == 4) {
                    document.forms[0].submit();
                }
                else {
                    alert("Error occur : " + httpObj.responseText);
                    return false;
                }
            }
        };
        httpObj.send(null);
    }

    function validateWarehouse(frm) {

        if (ValidateForSimpleBlank(frm.receiving_number, "Receiving Number") && ValidateForSimpleBlank(frm.package_id, "Package Id") && ValidateForSimpleBlank(frm.receiving_date, "Receiving Date") && ValidateForSimpleBlank(frm.wareHouse, "WareHouse") && ValidateForSimpleBlank(frm.mode_of_trasport, "Mode Of Trasport"))
        {
            var Url = "isRecordExists.php?warehouse_id=" + escape(document.getElementById("warehouse_name").value) + "&binlocation_name=" + escape(document.getElementById("binlocation").value) + "&Type=Warehouse";
            //alert(Url);		 
            SendEventExistRequest(Url);
            return false;
        }
        else {
            return false;
        }


    }


    function ltype() {


        var opt = document.getElementById('type').value;

        if (opt == "Company") {
            document.getElementById('com').style.display = 'block';
        } else {
            document.getElementById('com').style.display = 'none';
            document.getElementById('company').value = '';

        }


    }

function validateForm(frm){

alert("aaaaaaaaaa");
	var qty_left=0; var qty=0; var total_qty=0; var total_qty_left=0; 
	var total_received=0; var total_qty_received=0;
	var to_return=0; var total_to_return=0;
	var total_returned=0; 

	var EditReturnID = Trim(document.getElementById("OrderID")).value;
	var EditReturnOrderID = Trim(document.getElementById("ReturnOrderID")).value;
	//alert(EditReturnID);

	if(EditReturnID>0){
		ShowHideLoader('1','S');
		return true;	
	}
     
	if(!ValidateForSelect(frm.RecieveID, "Receive Number")){
			return false;
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

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

    <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">


        <tr>

            <td><input name="adj_number" type="hidden" class="inputbox" id="adj_number" value="<? echo $arryAdjustment['0']['adjustNo'] ?>"  maxlength="50" /></td>
        </tr>

        <tr>

            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

                    <tr>
                        <td width="45%" colspan="2" align="left" class="head">Adjustment Information</td>
                    </tr>                                


                    <tr>

                        <td  align="right" class="blackbold"> Adjustment Number #  : </td>
                        <td   align="left" >
                            <a class="fancybox fancybox.iframe" href="../inventory/vAdjustment.php?pop=1&view=<?= $arryAdjustment['0']['adjID'] ?>" ><?php echo $arryAdjustment['0']['adjustNo']; ?></a>
                        </td>
                    </tr>
                    <tr>

                        <td  align="right" class="blackbold"> Warehouse #  : </td>
                        <td   align="left" >
                            <a class="fancybox fancybox.iframe" href="vWarehouse.php?pop=1&view=<?= $arryAdjustment['0']['WID'] ?>" > <?= $arryAdjustment['0']['warehouse_code'] ?></a>

                        </td>
                    </tr>
                    <tr>

                        <td  align="right" class="blackbold"> Created By : </td>
                        <td   align="left" >

                            <?
                            if ($arryAdjustment[0]['created_by'] == 'admin') {
                                $CreatedBy = 'Administrator';
                            } else {
                                $CreatedBy = '<a class="fancybox fancybox.iframe" href="../hrms/empInfo.php?view=' . $arryAdjustment[0]['created_id'] . '" >' . stripslashes($arryTransfer[0]['created_by']) . '</a>';
                            }
                            echo $CreatedBy;
                            ?>


                        </td>
                    </tr>
                    <tr>

                        <td  align="right" class="blackbold"> Adjustment Date  : </td>
                        <td   align="left" >
                            <? echo date($Config['DateFormat'], strtotime($arryAdjustment[0]['adjDate'])); ?>

                        </td>
                    </tr>




                    <tr>
                        <td  align="right" class="blackbold">  Status  : </td>
                        <td   align="left" >
                            <?php if ($arryAdjustment['0']['Status'] == 2) {
                                echo "Completed";
                            } ?>
                        </td>
                    </tr>







                        <!--<tr>
                                <td  align="right" class="blackbold"> Warehouse Name  :<span class="red">*</span> </td>
                                <td   align="left" >
                                        <input name="warehouse_name" type="text" class="inputbox" id="receiving_number" value=""  maxlength="50" />
                                </td>
                        </tr>-->
                    <tr>
                        <td colspan="2" align="left" class="head">Receive Information</td>
                    </tr>


                    <tr>
                        <td  align="right"   class="blackbold" width="20%"> Receive No# :<? if (empty($_GET['edit'])) { ?><span class="red">*</span><? } ?> </td>
                        <td   align="left" >
                            <? if (!empty($_GET['edit']) || !empty($arryAdjustment[0]["ReceiveID"])) { ?>
                                <B><?= stripslashes($arryAdjustment[0]["ReceiveID"]) ?></B>

                            <? } else { ?>
                                <input name="ReceiveID" type="text" class="datebox" id="ReceiveID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');
                    return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID', 'ReceiveID', '<?= $_GET['edit'] ?>');" onMouseover="ddrivetip('<?= BLANK_ASSIGN_AUTO ?>', 220, '')"; onMouseout="hideddrivetip()"/>
                                <span id="MsgSpan_ModuleID"></span>
<? } ?>
                        </td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold"> Transaction Ref  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <input name="transaction_ref" type="text" class="disabled" id="transaction_ref" value="<?=$arryAdjustment['0']['adjustNo'] ?>" size="14"  maxlength="50" />            </td>
                    </tr>  
                    <tr>
                        <td  align="right"   class="blackbold"> Receiving Date  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <script type="text/javascript">
        $(function() {
            $('#ReceiveDate').datepicker(
                    {
                        showOn: "both",
                        yearRange: '<?= date("Y") - 10 ?>:<?= date("Y") + 10 ?>',
                        dateFormat: 'yy-mm-dd',
                        changeMonth: true,
                        changeYear: true

                    }
            );
        });
                            </script>
<? $ReceiveDate = ($arryAdjustment[0]['ReceivedDate'] > 0) ? ($arryAdjustment[0]['ReceivedDate']) : (date("Y-m-d"));?>
               <input id="ReceiveDate" name="ReceiveDate" readonly="" class="datebox" value="<?=$ReceiveDate?>"  type="text" >         </td>
                    </tr>  

                    <tr>
                        <td  align="right"   class="blackbold"> Mode of Transport  : </td>
                        <td   align="left" ><select name="transport" id="transport" class="inputbox">
                                <option value="">Select Transport</option>
                                <? for ($i = 0; $i < sizeof($arryTrasport); $i++) { ?>
                                    <option value="<?= $arryTrasport[$i]['attribute_value'] ?>" <?
                                                if ($arryTrasport[$i]['attribute_value'] == $arryAdjustment[0]['transport']) {
                                                    echo "selected";
                                                }
                                                ?>>
                                    <?= $arryTrasport[$i]['attribute_value'] ?>
                                    </option>
<? }
?>                                                     
                            </select>   </td>
                    </tr>			   

                    <tr>
                        <td colspan="2" align="left"   class="head">Package Information</td>
                    </tr>

                    <tr>
                        <td align="right"   class="blackbold" valign="top">Package Count :</td>
                        <td  align="left" >
                            <input name="packageCount" type="text" class="inputbox" id="packageCount" value="<?= $arryAdjustment[0]['packageCount'] ?>"  maxlength="50" /><!--span>	<a class="fancybox  fancybox.iframe"  href="Package.php"> Add</a></span-->		          
                        </td>
                    </tr> <tr>
                        <td align="right"   class="blackbold" valign="top">Package Type :</td>
                        <td  align="left" >
                            <select name="PackageType" id="PackageType" class="inputbox">
                                <option value="">Select Package Type</option>
                                <? for ($i = 0; $i < sizeof($arryPackageType); $i++) { ?>
                                    <option value="<?= $arryPackageType[$i]['attribute_value'] ?>" <?
                                                if ($arryPackageType[$i]['attribute_value'] == $arryAdjustment[0]['PackageType']) {
                                                    echo "selected";
                                                }
                                                ?>>
                                    <?= $arryPackageType[$i]['attribute_value'] ?>
                                    </option>
<? }
?>                                                     
                            </select>		          
                        </td>
                    <tr>
                        <td align="right"   class="blackbold" valign="top">Weight :</td>
                        <td  align="left" >
                            <input name="Weight" type="text" class="inputbox" id="Weight" value="<?= $arryAdjustment[0]['Weight'] ?>"  maxlength="50" />	          
                        </td>
                    </tr>


                    <tr>
                        <td colspan="2" align="left"   class="head">Charges</td>
                    </tr>

                    <tr>
                        <td align="right"   class="blackbold" valign="top">Charge :</td>
                        <td  align="left" >
                            <select name="charge" id="charge" class="inputbox">
                                <option value="">Select Charge</option>
                                <? for ($i = 0; $i < sizeof($arryCharge); $i++) { ?>
                                    <option value="<?= $arryCharge[$i]['attribute_value'] ?>" <?
                                                if ($arryCharge[$i]['attribute_value'] == $arryAdjustment[0]['charge']) {
                                                    echo "selected";
                                                }
                                                ?>>
                                    <?= $arryCharge[$i]['attribute_value'] ?>
                                    </option>
<? }
?>                                                     
                            </select>			          
                        </td>
                    </tr> 
                    <tr>
                        <td align="right"   class="blackbold" valign="top">Description :</td>
                        <td  align="left" >
                            <textarea name="Description" type="text" class="inputbox" id="Description" maxlength="50" /><?= stripslashes($arryAdjustment[0]['Description']) ?>	</textarea>		          
                        </td>
                    </tr>
                   
                    <tr>
                        <td align="right"   class="blackbold" valign="top">Price :</td>
                        <td  align="left" >
                            <input name="Price" type="text" class="inputbox" id="Price" value="<?= $arryAdjustment[0]['Price'] ?>"  maxlength="50" />			          
                        </td>
                    <tr>
                    <tr>
                        <td align="right"   class="blackbold" valign="top">Paid As :</td>
                        <td  align="left" >
                            <select name="PaidAs" id="PaidAs" class="inputbox">
                                <option value="">Select Paid</option>
                                <? for ($i = 0; $i < sizeof($arryPaid); $i++) { ?>
                                    <option value="<?= $arryPaid[$i]['attribute_value'] ?>" <?
                                                if ($arryPaid[$i]['attribute_value'] == $arryAdjustment[0]['PaidAs']) {
                                                    echo "selected";
                                                }
                                                ?>>
                                    <?= $arryPaid[$i]['attribute_value'] ?>
                                    </option>
<? }
?>                                                     
                            </select>			          
                        </td>
                    <tr>
                    <tr>
                        <td align="right"   class="blackbold" valign="top">Amount :</td>
                        <td  align="left" >
                            <input name="ammount" type="text" class="inputbox" id="ammount" value="<?= $arryAdjustment[0]['amount'] ?>"  maxlength="50" />			          
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td align="right">
                <?
                echo $CurrencyInfo = str_replace("[Currency]", $arryPurchase[0]['Currency'], CURRENCY_INFO);
                ?>	 
            </td>
        </tr>


        <tr>
            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



                    <tr>
                        <td  align="left" class="head" ><?= RETURN_ITEM ?>
                            <div style="float:right"><a class="fancybox fancybox.iframe" href="../inventory/vAdjustment.php?module=Order&pop=1&view=<?=$arryAdjustment['0']['adjID']?>" ><?= VIEW_ORDER_DETAIL ?></a></div>

                            <script language="JavaScript1.2" type="text/javascript">

                                $(document).ready(function() {
                                    $(".fancybox").fancybox({
                                        'width': 900
                                    });

                                });

                            </script>



                        </td>
                    </tr>

                    <tr>
                        <td align="left" >
                            <?
                            if (!empty($_GET['edit'])) {
                                include("w_item_adjustment_view.php");
                            } else {
                                include("w_item_adjustment.php");
                            }
                            ?>
                        </td>
                    </tr>

                </table>	


            </td>
        </tr>			


        <tr>
            <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td  align="center">
<input type="hidden" name="InboundID" id="InboundID" value="<?=$arryAdjustment[0]['InboundID']?>" readonly />
<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['adj']?>" readonly />
<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
                <? if ($HideSubmit != 1) { ?>	
                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Process "  />
<? } ?>

            </td>
        </tr>
    </form>
</table>
