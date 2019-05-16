<a href="<?= $RedirectURL ?>" class="back">Back</a>
<? 
if (empty($ErrorMSG)) {
	
		//echo '<div class="message" align="center">' . $ErrorMSG . '</div>';
		if($arryAssemble[0]['bin_Status']==0)
	{	

	?>
        <!--<a class="pdf" style="float:right;margin-left:5px;" target="_blank" href="pdfBOM.php?bom=<?=$_GET['view']?>">Download</a>-->
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$EditUrl?>" class="edit">Edit</a>
	<? }
	} ?>
<div class="had">
	<?= $MainModuleName ?>    <span>&raquo;
	<? echo (!empty($_GET['view'])) ? ("View " . $ModuleName) : ("Add " . $ModuleName); ?>
    </span>
</div>
<? if (!empty($errMsg)) { ?>
    <div align="center"  class="red" ><?php echo $errMsg; ?></div>
<?
	}
?>  
<?
	if (!empty($ErrorMSG)) {
	
		echo '<div class="message" align="center">' . $ErrorMSG . '</div>';
		
	}else {
    
?>

    <script language="JavaScript1.2" type="text/javascript">
        function validateForm(frm)	{
		
		if(document.getElementById("bin_id") != null){
		document.getElementById("main_bin_id").value = document.getElementById("bin_id").value;
	}
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
                                      <td  align="right"   class="blackbold" width="20%" valign="top"> SKU Code :  </td>
									   <td height="30" align="left" valign="top">
									  <strong><?=$arryAssemble[0]['Sku']?></strong>
									   </td>
										
													
													<td align="right"   class="blackbold" valign="top">Description :</td>
													<td height="30" align="left" valign="top">
													<strong><?= $arryAssemble[0]['description'] ?></strong></td>
										</tr>
 
 	  <tr>
	  <td  align="right"   class="blackbold" > Warehouse Location :  </td>
										       <td height="30" align="left">
     <?php 
	$objWarehouse=new warehouse();
	$WarehouseName=$objWarehouse->AllWarehouses($arryAssemble[0]['warehouse_code']);
	$BinName=$objWarehouse->getBindata($arryAssemble[0]['bin_id']);
    //print_r($arryAssemble); exit;
									?>
                                         <? if(!empty($_GET['edit'])||!empty($_GET['popup'])) { ?>
                                                    <select name="warehouse_id" id="warehouse_id" class="inputbox" onChange="Javascript: BinListSend();">
                                               
                                                <? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                                    <option value="<?= $arryWarehouse[$i]['WID'] ?>" <?
                                                    if ($arryWarehouse[$i]['WID'] == $WarehouseName[0]['WID']) {
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
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Bin Location :</td>
	  
	  <td  align="left" class="blacknormal"><?=$BinName[0]['binlocation_name']?>&nbsp;</td>
	  
	  				
	</tr>
 
 
              
<tr>                         
                                        <td  align="right"   class="blackbold" > Warehouse Quantity :</td>
                                        <td height="30" align="left">
                                       <?= $arryAssemble[0]['warehouse_qty'] ?>
<input type="hidden" name="warehouse_qty" value="<?= $arryAssemble[0]['warehouse_qty'] ?>" id="warehouse_qty" />
    <? if ($arrayItem[0]['evaluationType'] == 'Serialized') { ?>
                                                <a  class="fancybox fancybox.iframe" href="editSerial.php?id=<?= $_GET['bc'] ?>" id="addItem"><img src="../images/tab-new.png"  title="Serial number">  Add Serial Number</a>

                                                <input  name="serial_qty" id="serial_qty"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" />
    <? } ?>

                                            <input  name="serialized" id="serialized"  value="<?= $arrayItem[0]['evaluationType'] ?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
                                        </td>
                                   
                                   
                                   
                                         <td  align="right"   class="blackbold" >Bin Quantity :</td>
                                        <td   align="left" >
                                          <?=$arryAssemble[0]['bin_qty']?>
                                       
                                        </td>
										
                                      
							
                                    </tr>
									<tr>
									 <td  align="right"   class="blackbold" > </td>
                                        <td   align="left" >
										</td>
                                       <td  align="right"   class="blackbold" >Status : </td>
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
											 <? if ($arryAssemble[0]['bin_Status'] == 2) {
        $status = 'Completed';
        $Class = 'green';
    } ?>
                                               <? if ($arryAssemble[0]['bin_Status'] == 0) {
       $status = 'Parked';
        $Class = 'green';
    } ?> 
											 <? if ($arryAssemble[0]['bin_Status'] == 1) {
        $status = 'Cancelled';
        $Class = 'red';
    } ?>
											<?echo '<span class="'.$Class.'" >' . $status . '</span>'; } ?>
                                      
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
                                        <td  align="right"   class="blackbold" > Recieve No# :  </td>
                                        <td height="30" align="left">
										 <? if(!empty($_GET['popup'])) {?>
                                  <input name="RecieveNo" type="text" readonly=""  class="disabled" id="RecieveNo" value="<?=$arryAssemble[0]['RecieveNo']; ?>"  maxlength="20"  />

										  <? } 
										  else
										  {?>
										  <strong> <?= $arryAssemble[0]['RecieveNo'] ?></strong>
										  <?}?>
                                            <input  name="item_id" id="item_id" value="<?= $arryAssemble[0]['ItemID'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />
                                            <input  name="on_hand_qty" id="on_hand_qty" value="<?= $arrayItem[0]['qty_on_hand'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />	
                                            <input  name="ref_code" id="ref_code" value="<?= $ref_code ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />
			<td align="right" class="blackbold">Currency :</td>
		  		<td  align="left" >
		    		<strong><?=$Config['Currency']?> </strong>       
				</td>
   
                                      
                                   </tr>
									<tr>
									
									<td  align="right"   class="blackbold" >Recieve Date :</td>
                                        <td   align="left" >
                                           <strong><?=$arryAssemble[0]['UpdatedDate']?></strong>
                                       
                                        </td>	
				
		       </tr>  
			   			    

                                </table>
<tr>

                            <td colspan="2" align="left" class="head">
                                Package Information</td>
                        </tr>

                <tr>
		  		<td align="right"   class="blackbold" valign="top" width="20%" >Package Count :</td>
		  		<td  align="left" >
		    			<?=$arryAssemble[0]['packageCount']?>
	          
				</td>
			</tr> <tr>
		  		<td align="right"   class="blackbold" valign="top">Package Type :</td>
		  		<td  align="left" >
					
										<?= $arryAssemble[0]['PackageType'] ?>
										          
				</td>
				<tr>
		  		<td align="right"   class="blackbold" valign="top">Weight :</td>
		  		<td  align="left" >
		    			<?=$arryAssemble[0]['Weight']?>	          
				</td>
			</tr>
                            </td>
                        </tr>


              <tr>

			
	<tr>
		  		
			</tr>

                        <tr>
                            <td colspan="2" align="right"></td>
                        </tr>
                               
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
					<input type="hidden" name="main_bin_id" id="main_bin_id"  value="<?php echo $WarehouseName[0]['WID']; ?>" />
				</td>
            </tr>

        </table>
		
	</form>


<? } ?>
<script>
BinListSend();
</script>