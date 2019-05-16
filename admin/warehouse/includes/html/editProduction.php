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
	}else {
    
?>

    <script language="JavaScript1.2" type="text/javascript">
        function validateForm(frm)	{
		
				var NumLine = parseInt($("#NumLine").val());
				var ModuleField = 'RecieveNo';
				var ModuleVal = Trim(document.getElementById(ModuleField)).value;
				var OrderID = Trim(document.getElementById("asmID")).value;
				var asmID = Trim(document.getElementById("asmID")).value;

				if (ValidateForSelect(frm.warehouse, "Warehouse Location ")
				&&ValidateForSelect(frm.Status,"Status")
				&&ValidateForSimpleBlank(frm.warehouse_qty,"Warehouse Qty"))	{
					
					var avilQty = 0;
					var inQty = 0;
					var totalSum = 0;
				   
					avilQty = document.getElementById("warehouse_qty").value;
					inQty = document.getElementById("Assembly_qty").value;
					totalSum += parseInt(inQty);
						if (parseInt(avilQty) > parseInt(inQty))	{
							
							alert("Warehouse qty must  be less than or equal to Assemble qty for this item.");
							document.getElementById("warehouse_qty").focus();
							return false;
						}
					 totalSum = parseInt(totalSum, 10);
			  
						if(ModuleVal!='' && OrderID=='')	{
							 
							var Url = "isRecordExists.php?"+ModuleField+"="+escape(ModuleVal)+"&editID="+OrderID;
							SendExistRequest(Url,ModuleField, "<?=$ModuleIDTitle?>");
							return false;	
						}else	{
					
							ShowHideLoader('1','S');
							return true;	
						}

				}else	{
					return false;
				}
		}


        function UpdateAssembleqty()	{
		
				NumLine = document.getElementById("NumLine").value;
				var totval = parseInt(0);
					for (var i = 1; i <= NumLine; i++)	{
						if (document.getElementById("assembly_qty").value != '') {
							document.getElementById("qty" + i).value = document.getElementById("bomqty" + i).value * document.getElementById("assembly_qty").value;
							document.getElementById("amount" + i).value = document.getElementById("qty" + i).value * document.getElementById("price" + i).value;
							var TotValue = document.getElementById("amount" + i).value;
							totval = parseInt(totval) + parseInt(TotValue);
						}else	{
							document.getElementById("qty" + i).value = document.getElementById("bomqty" + i).value;
						}
					}
				document.getElementById("TotalValue").value = parseInt(totval);
				
        }

        $(document).ready(function() {
		
            $('#addItem').on('click', function() {
		        var warehouse = $('#warehouse').val();
				alert(warehouse);
                if (qty != '' && warehouse != '' && serial_sku != '') {

                    var linkhref = $('#addItem').attr("href") + '&total=' + qty + '&sku=' + serial_sku + '&warehouse=' + warehouse;
                    $('#addItem').attr("href", linkhref);
                }else {
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
                                        <td  align="right"   class="blackbold" > Bill Number:  </td>
                                        <td height="30" align="left">
                                          <?= $arryAssemble[0]['Sku'] ?>
                                            <input  name="item_id" id="item_id" value="<?= $arryAssemble[0]['ItemID'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />
                                            <input  name="on_hand_qty" id="on_hand_qty" value="<?= $arrayItem[0]['qty_on_hand'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />	
                                            <input  name="ref_code" id="ref_code" value="<?= $ref_code ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />



   
                                        <td  align="right"   class="blackbold" > Description:   </td>
                                        <td height="30" align="left">


                                            <?= $arryAssemble[0]['description'] ?>
                                        </td>
                                   </tr>
									<tr>
                                        <td  align="right"   class="blackbold" > Available Quantity:   </td>
                                        <td height="30" align="left">
                                           <?= $arryAssemble[0]['on_hand_qty'] ?>
                                        </td>
										<td  align="right"   class="blackbold" > Warehouse Location: <span class="red">*</span>  </td>
										       <td height="30" align="left">
     <?php 
	$objWarehouse=new warehouse();
	$WarehouseName=$objWarehouse->AllWarehouses($arryAssemble[0]['warehouse_code']);

									?>
                                         <? if(!empty($_GET['edit'])||!empty($_GET['popup'])) { ?>
                                                    <select name="warehouse" id="warehouse" class="inputbox">
                                                <option value="">Select Location</option>
                                                <? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                                    <option value="<?= $arryWarehouse[$i]['warehouse_code'] ?>" <?
                                                    if ($arryWarehouse[$i]['warehouse_code'] == $arryAssemble[0]['warehouse_code']) {
                                                        echo "selected";
														
                                                    }
                                                    ?>>
        <?= $arryWarehouse[$i]['warehouse_name'] ?>
                                                    </option>
    <? }	?>                                                     
                                            </select>
											<? } else {?>
											 <?=$WarehouseName[0]['warehouse_name'];?>
											<?}?>
													</td>
										</tr>

              
<tr>                         
                                        <td  align="right"   class="blackbold" > Assembly Quantity:</td>
                                        <td height="30" align="left">
                                          <?= $arryAssemble[0]['assembly_qty'] ?>
<input type="hidden" name="Assembly_qty" value="<?= $arryAssemble[0]['assembly_qty'] ?>" id="Assembly_qty" />
    <? if ($arrayItem[0]['evaluationType'] == 'Serialized') { ?>
                                                <a  class="fancybox fancybox.iframe" href="editSerial.php?id=<?= $_GET['bc'] ?>" id="addItem"><img src="../images/tab-new.png"  title="Serial number">  Add Serial Number</a>

                                                <input  name="serial_qty" id="serial_qty"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" />
    <? } ?>

                                            <input  name="serialized" id="serialized"  value="<?= $arrayItem[0]['evaluationType'] ?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
                                        </td>
                                   
                                   
                                   
                                     
                                      
											   <td  align="right"   class="blackbold" >Status  : <span class="red">*</span> </td>
                                        <td   align="left" >
										<?
										if(!empty($_GET['edit'])||!empty($_GET['popup'])) {
									
										?>
                                            <select name="Status" id="Status" class="inputbox">
                                                <option value="">Select Status</option>

                                                <option value="2" <? if ($arryAssemble[0]['Status'] == 2) {
        echo "selected";
    } ?>>Completed</option>
                                                <option value="0" <? if ($arryAssemble[0]['Status'] == 0) {
        echo "selected";
    } ?>> Parked</option>
												<option value="1" <? if ($arryAssemble[0]['Status'] == 1) {
        echo "selected";
    } ?>> Cancelled</option>

                                            </select>
											<? }
										else {
		
											?>
											 <? if ($arryAssemble[0]['Status'] == 2) {
        $status = 'Completed';
        $Class = 'green';
    } ?>
                                               <? if ($arryAssemble[0]['Status'] == 0) {
       $status = 'Parked';
        $Class = 'green';
    } ?> 
											 <? if ($arryAssemble[0]['Status'] == 1) {
        $status = 'Cancelled';
        $Class = 'red';
    } ?>
											<?echo '<span class="'.$Class.'" >' . $status . '</span>'; } ?>
                                      
											</td>
                                    </tr>
									<tr>
                                        <td  align="right"   class="blackbold" >Warehouse Qty :<span class="red">*</span></td>
                                        <td   align="left" >
                                           <input type="text" name="warehouse_qty" id="warehouse_qty" value="<?=$arryAssemble[0]['warehouse_qty']?>" class="textbox" size="10" maxlength="30" onkeypress="return isNumberKey(event);"/>
                                       
                                        </td>
										<td  align="right"   class="blackbold" >Assemble Date :</td>
                                        <td   align="left" >
                                           <input type="text" class="disabled" readonly="" name="assemble_date" id="assemble_date" class="datebox hasDatepicker" value="<?=$arryAssemble[0]['asmDate']?>" class="textbox" size="10" maxlength="30" onkeypress="return isNumberKey(event);"/>
                                       
                                        </td>
                                    </tr>
<? if($arryOptionCat[0]['optionID']>0){?>

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
                            <td colspan="2" align="left" class="head">
                                Recieve Information</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="left">

                                <table width="100%" border="0" cellpadding="5" cellspacing="0">	 




                                    <tr>
                                        <td  align="right"   class="blackbold" > Recieve No#:  </td>
                                        <td height="30" align="left">
										 <? if(!empty($_GET['popup'])) {?>
                                  <input name="RecieveNo" type="text" class="datebox" id="RecieveNo" value="<?php echo stripslashes($arryAssemble[0][$RecieveNo]); ?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_ModuleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_ModuleID','RecieveNo','<?=$_GET['popup']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()" />
	<span id="MsgSpan_ModuleID"></span>
										  <? } 
										  else
										  {?>
										   <?= $arryAssemble[0]['RecieveNo'] ?>
										  <?}?>
                                            <input  name="item_id" id="item_id" value="<?= $arryAssemble[0]['ItemID'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />
                                            <input  name="on_hand_qty" id="on_hand_qty" value="<?= $arrayItem[0]['qty_on_hand'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />	
                                            <input  name="ref_code" id="ref_code" value="<?= $ref_code ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />

   
                                      
                                   </tr>
<tr>
                                        <td  align="right" width="20%"  class="blackbold" >  Transaction Ref :   </td>
                                        <td align="left">
                                           <?= $arryAssemble[0]['asm_code'] ?>
                                        </td>
								
                                    </tr>
									<tr>
				<td  align="right"   class="blackbold"> Receiving Date  : </td>
				<td   align="left" >
				<script type="text/javascript">
					$(function() {
						$('#RecieveDate').datepicker(
							{
							showOn: "both",
							yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
							dateFormat: 'yy-mm-dd',
							changeMonth: true,
							maxDate: "D",
							changeYear: true

							}
						);
					});
					</script>

	
<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$RecieveDate = ($arryAssemble[0]['UpdatedDate']>0)?($arryAssemble[0]['UpdatedDate']):($arryTime[0]); 
?>



<input id="RecieveDate" name="RecieveDate" readonly="" class="datebox" value="<?=$RecieveDate?>"  type="text" >         </td>
		       </tr>  

                                </table>

                            </td>
                        </tr>
    <tr>
                            <td colspan="2" align="left" class="head">
                                Package Information</td>
                        </tr>

                <tr>
		  		<td align="right"   class="blackbold" valign="top" width="20%" >Package Count :</td>
		  		<td  align="left" >
		    			<input name="packageCount" type="text" class="inputbox" id="packageCount" value="<?=$arryAssemble[0]['packageCount']?>"  maxlength="50" />	<!--a class="fancybox add fancybox.iframe"  href="Package.php"> Add</a-->
	          
				</td>
			</tr> <tr>
		  		<td align="right"   class="blackbold" valign="top">Package Type :</td>
		  		<td  align="left" >
					<select name="PackageType" id="PackageType" class="inputbox">
									<option value="">Select Package Type</option>
							 <? for ($i = 0; $i < sizeof($arryPackageType); $i++) { ?>
										<option value="<?= $arryPackageType[$i]['attribute_value'] ?>" <? if ($arryPackageType[$i]['attribute_value'] == $arryAssemble[0]['PackageType']) {
										echo "selected";
									} ?>>
										<?= $arryPackageType[$i]['attribute_value'] ?>
										</option>
<? } ?>                                                     
					</select>		          
				</td>
				<tr>
		  		<td align="right"   class="blackbold" valign="top">Weight :</td>
		  		<td  align="left" >
		    			<input name="Weight" type="text" class="inputbox" id="Weight" value="<?=$arryAssemble[0]['Weight']?>"  maxlength="50" />	          
				</td>
			</tr>
	<tr>
		  		<td align="right"   class="blackbold" valign="top">Currency :</td>
		  		<td  align="left" >
		    			<input name="currency" type="text" class="disabled" id="currency" value="<?=$Config['Currency']?>" readonly="" size="10" maxlength="5" />	          
				</td>
			</tr>

                        <tr>
                            <td colspan="2" align="right"></td>
                        </tr>
                                <? if(!empty($arryAssemble[0]['asmID'])&&(!empty($_GET['edit'])||!empty($_GET['popup'])))	{ 
								?>
                            <tr>
                                <td colspan="2" align="left" class="head" >Kit Item</td>
                            </tr>

                            <tr>
                                <td align="left" colspan="2">

								<?
								require_once("includes/html/box/assemble_item_form.php");
								?>
                
                                </td>
                            </tr>
    <? } ?>
					</table>	

                </td>
            </tr>
    <? if ($_GET['edit'] > 0) {
        if ($arryAssemble[0]['Status'] == 2 || $arryAssemble[0]['Status'] == 1) {
            //$disNone = "style='display:none;'";
        } $ButtonTitle = 'Update ';
		} else {
        $ButtonTitle = ' Process ';
		} 
	?>
            <tr>
                <td  align="center">
<? if(!empty($_GET['edit'])||!empty($_GET['popup']))	{ ?>

                    <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
<? } ?>
					<input type="hidden" name="asmID" id="asmID" value="<?= $_GET['edit'] ?>" />
                    <input type="hidden" name="bomID" id="bomID" value="<?= $BomID ?>" />
					<input type="hidden" name="PrefixPO" id="PrefixPO" value="<?= $PrefixPO ?>" />
				</td>
            </tr>

        </table>
		
	</form>


<? } ?>
