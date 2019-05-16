
<a href="<?= $RedirectURL ?>" class="back">Back</a>
	<? if(empty($ErrorMSG)){
	if($arryAssemble[0]['Status']==0)
	{?>
        <!--<a class="pdf" style="float:right;margin-left:5px;" target="_blank" href="pdfBOM.php?bom=<?=$_GET['view']?>">Download</a>-->
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$EditUrl?>" class="edit">Edit</a>
	<? } } ?>



<div class="had">
    <?= $MainModuleName ?>    <span>&raquo;
        <?=$ModuleName.' Detail'?>

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
                    && ValidateForSelect(frm.warehouse, "Warehouse Location ")
                    && ValidateForSimpleBlank(frm.assembly_qty, "Assembly quantity")
                    // && ValidateForSimpleBlank(frm.serial_qty, "Serial Number")

                    ) {

//alert(document.getElementById("serialized").value);

              if (document.getElementById("serialized").value == "Serialized")
                {
                    
                    
                    if (document.getElementById("serial_qty").value == "")
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
                    
                    
                    
              if (document.getElementById("Comp_Serialized"+i).value == "Serialized")
                {
                    
                    
                    if (document.getElementById("serial_number" + i).value == "")
                    {
                        //alert("Return Qty SerialQtyShould be Less Than Or Equal To Invoice Qty.");
                         alert(" Please select component serial number.");
                        document.getElementById("serial_number" + i).focus();
                        return false;
                    }

                }
                    
                   /* if (SerialQty == '')
                    {
                        //alert("Return Qty SerialQtyShould be Less Than Or Equal To Invoice Qty.");
                        alert(" Please select component serial number.");
                        document.getElementById("serial_number" + i).focus();
                        return false;
                    }*/

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
                //var item_id = $('#item_id').val();
                var serial_sku = $('#Sku').val();
                var warehouse = $('#warehouse').val();

                if (qty != '' && warehouse != '' && serial_sku != '') {

                    var linkhref = $('#addItem').attr("href") + '&total=' + qty + '&sku=' + serial_sku + '&warehouse=' + warehouse;
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

                    if (serial_sku != '') {
                        alert("Please Enter Bill Number.")
                        return false;
                    }
                }

            });
        });


    </script>



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
                                        <td  align="right"   class="blackbold" > Bill Number :  </td>
                                        <td height="30" align="left">
                                          <?= $arryAssemble[0]['Sku'] ?>
                                            <input  name="item_id" id="item_id" value="<?= $arryAssemble[0]['ItemID'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />
                                            <input  name="on_hand_qty" id="on_hand_qty" value="<?= $arrayItem[0]['qty_on_hand'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />	
                                            <input  name="ref_code" id="ref_code" value="<?= $ref_code ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />

    <? if (empty($_GET['view'])) {
        echo '<a class="fancybox fancybox.iframe" href="bomList.php?link=editAssemble.php">' . $search . '</a>';
    } ?>

   
                                        <td  align="right"   class="blackbold" > Description :   </td>
                                        <td height="30" align="left">


                                            <?= $arryAssemble[0]['description'] ?>
                                        </td>
                                   </tr>
<tr>
                                        <td  align="right"   class="blackbold" > Available Quantity :   </td>
                                        <td height="30" align="left">
                                           <?= $arryAssemble[0]['on_hand_qty'] ?>
                                        </td>
										<td  align="right"   class="blackbold" > Warehouse Location :   </td>
										       <td height="30" align="left">
                                        <!--<input  name="warehouse" id="warehouse" value="" readonly="readonly" type="text" class="disabled"  maxlength="30" />-->	
                                        <!--<input  name="WID" id="WID" value="" type="hidden"  class="inputbox"  maxlength="30" />	-->
										
									<?php 
									$objWarehouse=new warehouse();
	$WarehouseName=$objWarehouse->AllWarehouses($arryAssemble[0]['warehouse_code']);
									?>

											 <?=$WarehouseName[0]['warehouse_name'];?>
											
													</td>
                                    </tr>

              
<tr>                         
                                        <td  align="right"   class="blackbold" > Assembly Quantity :</td>
                                        <td height="30" align="left">
                                          <?= $arryAssemble[0]['assembly_qty'] ?>

    <? if ($arrayItem[0]['evaluationType'] == 'Serialized') { ?>
                                                <a  class="fancybox fancybox.iframe" href="editSerial.php?id=<?= $_GET['bc'] ?>" id="addItem"><img src="../images/tab-new.png"  title="Serial number">  Add Serial Number</a>

                                                <input  name="serial_qty" id="serial_qty"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" />
    <? } ?>

                                            <input  name="serialized" id="serialized"  value="<?= $arrayItem[0]['evaluationType'] ?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
                                        </td>
                                   
                                   
                                   
                                     
                                      
											   <td  align="right"   class="blackbold" >Status : </td>
                                        <td   align="left" >
										<?

		$status = 'Parked';
        $Class = 'green';
											?>
											 <? if ($arryAssemble[0]['Status'] == 2) {
        $status = 'Completed';
        $Class = 'green';
    } ?>
                                               <? if ($arryAssemble[0]['Status'] == 0) {
       
    } ?> 
											 <? if ($arryAssemble[0]['Status'] == 1) {
        $status = 'Cancelled';
        $Class = 'red';
    } ?>
											<?echo '<span class="'.$Class.'" >' . $status . '</span>';  ?>
                                      
											</td>
                                    </tr>
									<tr>
                                        <td  align="right"   class="blackbold" >Warehouse Qty :</td>
                                        <td   align="left" >
                                           <?=$arryAssemble[0]['warehouse_qty']?>
                                       
                                        </td>
										<td  align="right"   class="blackbold" >Assemble Date :</td>
                                        <td   align="left" >
                                           <?=$arryAssemble[0]['asmDate']?>
                                       
                                        </td>
                                    </tr>
<? if($arryOptionCat[0]['optionID']>0){?>
                                 <tr>
                                        <td  align="right"   class="blackbold" >Option Code : </td>
                                        <td   align="left" >
                                            <a class="fancybox fancybox.iframe" href="vOptionBill.php?optionID=<?=$arryOptionCat[0]['optionID']?>&curP=1&bom_id=<?=$_GET['bc']?>&bom_code="> <?=$arryOptionCat[0]['option_code']?></a>
                                       
                                        </td>
                                    </tr>
<? }?>      

                                </table>

                            </td>
                        </tr>


 <tr>
                            <td colspan="2" align="left" class="head">
                                Recieve Information</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	 




                                    <tr>
                                        <td  align="right"   class="blackbold" width="28%"> Recieve No# :  </td>
                                        <td height="30" align="left">
                                          <strong><?= $arryAssemble[0]['RecieveNo'] ?></strong>
                                            <input  name="item_id" id="item_id" value="<?= $arryAssemble[0]['ItemID'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />
                                            <input  name="on_hand_qty" id="on_hand_qty" value="<?= $arrayItem[0]['qty_on_hand'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />	
                                            <input  name="ref_code" id="ref_code" value="<?= $ref_code ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />

   
                                      
                                   </tr>
<tr>
                                        <td  align="right" width="20%"  class="blackbold" >  Transaction Ref :   </td>
                                        <td align="left">
                                           <strong><?= $arryAssemble[0]['asm_code'] ?><strong>
                                        </td>
								
                                    </tr>
									<tr>
				<td  align="right"   class="blackbold"> Receiving Date :</td>
				<td   align="left" >
				<script type="text/javascript">
					$(function() {
						$('#RecieveDate').datepicker(
							{
							showOn: "both",
							yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
							dateFormat: 'yy-mm-dd',
							changeMonth: true,
							changeYear: true

							}
						);
					});
					</script>

<? 	
$PaymentDate = ($arryPurchase[0]['RecieveDate']>0)?($arryPurchase[0]['RecieveDate']):(""); 
?>
<?= $arryAssemble[0]['UpdatedDate'] ?>  </td>
		       </tr>  

              

<? if($arryOptionCat[0]['optionID']>0){?>

                                 <tr>
                                        <td  align="right"   class="blackbold" >Option Code : </td>
                                        <td   align="left" >
                                            <a class="fancybox fancybox.iframe" href="vOptionBill.php?optionID=<?=$arryOptionCat[0]['optionID']?>&curP=1&bom_id=<?=$_GET['bc']?>&bom_code="> <?=$arryOptionCat[0]['option_code']?></a>
                                       
                                        </td>
                                    </tr>
<? }?>      

                                </table>

                            </td>
                        </tr>
    <tr>
                            <td colspan="2" align="left" class="head">
                                Package Information</td>
                        </tr>

                <tr>
		  		<td align="right"   class="blackbold" valign="top" width="28%">Package Count :</td>
		  		<td  align="left" >
		    			<?=$arryAssemble[0]['packageCount']?>	<!--a class="fancybox add fancybox.iframe"  href="Package.php"> Add</a-->
	          
				</td>
			</tr> <tr>
		  		<td align="right"   class="blackbold" valign="top">Package Type :</td>
		  		<td  align="left" >
				
                     
                                    <?= $arryAssemble[0]['PackageType'] ?>
          	</td>
				<tr>
		  		<td align="right"   class="blackbold" valign="top">Weight :</td>
		  		<td  align="left" >
		    			<?=$arryAssemble[0]['Weight'];?>         
				</td>
			</tr>
	  		<td align="right"   class="blackbold" valign="top">Currency :</td>
		  		<td  align="left" >
		    			<strong><?=$Config['Currency']?></strong>       
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
                                <? if (!empty($arryAssemble[0]['bomID']) || !empty($_GET['view'])) { ?>
                            <tr>
                                <td colspan="2" align="left" class="head" >Kit Item</td>
                            </tr>

                            <tr>
                                <td align="left" colspan="2">


                            <?
                            require_once("includes/html/box/assemble_item_form.php");



//include("includes/html/box/assemble_item_edit.php");
                            ?>
                <? //include("includes/html/box/assemble_item_edit.php"); ?>
                                </td>
                            </tr>
    <? } ?>

                    </table>	


                </td>
            </tr>
    <? if ($_GET['view'] > 0) {
        if ($arryAssemble[0]['Status'] == 2 || $arryAssemble[0]['Status'] == 1) {
            //$disNone = "style='display:none;'";
        } $ButtonTitle = 'Update ';
    } else {
        $ButtonTitle = ' Process ';
    } ?>
            <tr>
                <td  align="center">

                    <input type="hidden" name="asmID" id="asmID" value="<?= $_GET['view'] ?>" />
                    <input type="hidden" name="bomID" id="bomID" value="<?= $BomID ?>" />




                    <input type="hidden" name="PrefixPO" id="PrefixPO" value="<?= $PrefixPO ?>" />



                </td>
            </tr>

        </table>

    </form>


<? } ?>
