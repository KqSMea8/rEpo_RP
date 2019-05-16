<a href="<?= $RedirectURL ?>" class="back">Back</a>
<div class="had">
	<?= $MainModuleName ?>  <span>&raquo;
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
			
			
			var SendUrl = 'ajax.php?action=bin&warehouse_id='+document.getElementById("warehouse_id").value+'&current_bin='+document.getElementById("main_bin_id").value+SelectOption+OtherOption+'&r='+Math.random()+'&select=1';
			

			httpObj.open("GET", SendUrl, true);

			httpObj.onreadystatechange = function BinListRecieve(){

				if (httpObj.readyState == 4) {
					//alert(httpObj.responseText);
					document.getElementById("bin_td").innerHTML  = httpObj.responseText;
										
				}
			};
			httpObj.send(null);
			
		}

	}




        function validateForm(frm)	{
	
	var NumLine = parseInt($("#NumLine").val());
		if(document.getElementById("bin_id") != null){
		document.getElementById("main_bin_id").value = document.getElementById("bin_id").value;
	}
	
				if (ValidateForSimpleBlank(frm.bin_qty,"Bin Qty")
				&&ValidateForSelect(frm.bin_id,"Bin Location")
				&&ValidateForSelect(frm.Status,"Status"))	{
			
					var avilQty = 0;
					var inQty = 0;
					var totalSum = 0;
				   
					binQty = document.getElementById("bin_qty").value;
					warehouseQty = document.getElementById("warehouse_qty").value;
					//totalSum += parseInt(inQty);
						if (parseInt(binQty) > parseInt(warehouseQty))	{
							
							alert("Bin qty must  be less than or equal to Warehouse qty for this item.");
							document.getElementById("warehouse_qty").focus();
							return false;
						}
					// totalSum = parseInt(totalSum, 10);
			  
					else	{
					
							ShowHideLoader('1','S');
							return true;	
						}

				}
				else	{
					return false;
				}
		}



      


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
                                      <td  align="right"   class="blackbold" width="20%"> SKU Code :  </td>
									   <td height="30" align="left">
									   <input type="text" name="sku_code" id="sku_code" value="<?=$arryAssemble[0]['Sku']?>" class="disabled" size="15" readonly="" />
									   </td>
									   <td align="right"   class="blackbold">Description :</td>
													<td height="30" align="left">
													<input type="text" id="description" name="description" class="disabled" readonly="" size="15" value="<?= $arryAssemble[0]['description'] ?>"  /></td>
										
													
													
										</tr>
 
 	  <tr>
	  <td  align="right"   class="blackbold" > Warehouse Location :  </td>
										       <td height="30" align="left">
     <?php 
	$objWarehouse=new warehouse();
	$WarehouseName=$objWarehouse->AllWarehouses($arryAssemble[0]['warehouse_code']);
	$BinName=$objWarehouse->getBindata($arryAssemble[0]['bin_id']);
									?>
                                         <? if(!empty($_GET['edit'])||!empty($_GET['popup'])) { ?>
                                                    <select name="warehouse_id" id="warehouse_id" class="inputbox" onChange="Javascript: BinListSend();">
                                               
                                                <? for ($i = 0; $i < sizeof($arryWarehouse); $i++) { ?>
                                                    <option value="<?= $arryWarehouse[$i]['WID'] ?>" <?
                                                    if ($arryWarehouse[$i]['WID'] == $arryAssemble[0]['warehouse_id']) {
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
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Bin Location :<span class="red">*</span></td>
	  <td  align="left" id="bin_td" class="blacknormal">&nbsp;</td>
	  
	  
	</tr>
 
 
              
<tr>                         
                                        <td  align="right"   class="blackbold" > Warehouse Quantity :</td>
                                        <td height="30" align="left">
                                        <input type="text" name="warehouse_qty" value="<?= $arryAssemble[0]['warehouse_qty'] ?>" readonly="" size="10" class="disabled" id="warehouse_qty"/>  
<input type="hidden" name="warehouse_qty" value="<?= $arryAssemble[0]['warehouse_qty'] ?>" id="warehouse_qty" />
    <? if ($arrayItem[0]['evaluationType'] == 'Serialized') { ?>
                                                <a  class="fancybox fancybox.iframe" href="editSerial.php?id=<?= $_GET['bc'] ?>" id="addItem"><img src="../images/tab-new.png"  title="Serial number">  Add Serial Number</a>

                                                <input  name="serial_qty" id="serial_qty"  value="" type="hidden"   class="textbox" size="10"  maxlength="30" />
    <? } ?>

                                            <input  name="serialized" id="serialized"  value="<?= $arrayItem[0]['evaluationType'] ?>" type="hidden"   class="textbox" size="10"  maxlength="30" />
                                        </td>
                                   
                                   
                                   <td  align="right"   class="blackbold" >Bin Quantity :<span class="red">*</span></td>
                                        <td   align="left" >
                                           <input type="text" name="bin_qty" id="bin_qty" value="<?=$arryAssemble[0]['bin_qty']?>" class="textbox" size="10" maxlength="30" onkeypress="return isNumberKey(event);"/>
                                       
                                        </td>
                                     
                                      
							
                                    </tr>
									<tr>
                                        
														   <td  align="right"   class="blackbold" >Status : <span class="red">*</span> </td>
                                        <td   align="left" >
										<?
										if(!empty($_GET['edit'])||!empty($_GET['popup'])) {
										if(!empty($_GET['edit'])) {
										?>
                                            <select name="Status" id="Status" class="inputbox">
                                                <option value="">Select Status</option>

                                                <option value="2" <? if ($arryAssemble[0]['bin_Status'] == 2) {
        echo "selected";
    } ?>>Completed</option>
                                                <option value="0" <? if ($arryAssemble[0]['bin_Status'] == 0) {
        echo "selected";
    } ?>> Parked</option>
												<option value="1" <? if ($arryAssemble[0]['bin_Status'] == 1) {
        echo "selected";
    } ?>> Cancelled</option>

                                            </select>
											<? 
											}
											else{?>
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
											<?}
											}
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
											   <td  align="right"   class="blackbold" >  </td>
                                        <td   align="left" >
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
										   <strong><?= $arryAssemble[0]['RecieveNo'] ?></strong>
										  <?}?>
                                            <input  name="item_id" id="item_id" value="<?= $arryAssemble[0]['ItemID'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />
                                            <input  name="on_hand_qty" id="on_hand_qty" value="<?= $arrayItem[0]['qty_on_hand'] ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />	
                                            <input  name="ref_code" id="ref_code" value="<?= $ref_code ?>" type="hidden"  class="disabled" class="inputbox"  maxlength="30" />
			<td align="right" class="blackbold">Currency :</td>
		  		<td  align="left" >
		    			<input  name="currency" type="text" class="disabled" id="currency" value="<?=$Config['Currency']?>" readonly="" size="10" maxlength="5" />	          
				</td>
   
                                      
                                   </tr>
									<tr>
									
									<td  align="right"   class="blackbold" >Recieve Date :</td>
                                        <td   align="left" >
                                           <input type="text" class="disabled" readonly="" name="Recieve_date" id="Recieve_date" class="datebox hasDatepicker" value="<?=$arryAssemble[0]['UpdatedDate']?>" class="textbox" size="10" maxlength="30" onkeypress="return isNumberKey(event);"/>
                                       
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
		    			<input name="packageCount" type="text" class="disabled" readonly="" size="10" id="packageCount" value="<?=$arryAssemble[0]['packageCount']?>"  maxlength="50" />	<!--a class="fancybox add fancybox.iframe"  href="Package.php"> Add</a-->
	          
				</td>
				</tr> 
				<tr>
		  		<td align="right"   class="blackbold" valign="top">Package Type :</td>
		  		<td  align="left" height="30">
					
				<input name="packageType" type="text" class="disabled"  readonly="" size="15" id="packageType" value="<?= $arryAssemble[0]['PackageType'] ?>"  maxlength="50" />
                    	          
				</td>
				<tr>
		  		<td align="right"   class="blackbold" valign="top">Weight :</td>
		  		<td  align="left" >
		    			<input name="Weight" type="text" class="disabled" id="Weight" size="10" readonly="" value="<?=$arryAssemble[0]['Weight']?>"  maxlength="50" />	          
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
					<?php //echo $arryAssemble[0]['bin_id']; ?>
					<input type="hidden" name="main_bin_id" id="main_bin_id"  value="<?=$arryAssemble[0]['bin_id'] ?>" />
				</td>
            </tr>

        </table>
		
	</form>


<? } ?>
<script>
BinListSend();
</script>
