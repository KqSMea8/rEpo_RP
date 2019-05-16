<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>


<div class="had"> <?=$MainModuleName?> </div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

   
<? if (!empty($_SESSION['mess_product'])) {?>	
    <tr>
        <td  >
            <div class="message"><? echo $_SESSION['mess_product']; unset($_SESSION['mess_product']); ?>
            </div>
        </td>
    </tr>		
<? } ?>
    <tr>
        <td  align="right" >
 
            <? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_item.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
<? if($_GET['module'] != 'exclusive'){?>
	  <a class="fancybox add_quick fancybox.iframe" href="addItem.php">Quick Entry</a>
<? }?>
           
            <? if($_GET['key']!='') {?>
		  <a href="<?=$ViewUrl?>" class="grey_bt">View All</a>
		<? }?>
<? if($_GET['module'] != 'exclusive'){?>
<input type="button" class="export_button"  name="imp" value="Import Item" onclick="Javascript:window.location='importItem.php';" />
<?php if( $_SESSION['sync_items']=='I2E' ||$_SESSION['sync_items']=='both' ){?>
<input type="button" class="sync_button"  name="sync_items" value="Sync Item" onclick="Javascript:selectitems();" />
  <?php }?>


<a href="editItem.php?curP=<?= $_GET['curP'] ?>&tab=basic" class="add">Add New Item</a>
<? }?>
        </td>
  </tr>
    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1" id="form1">
                
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>


                    <tr align="left">
                        <td width="4%" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ItemID','<?= sizeof($arryProduct) ?>');" /></td>
                        <!--<td width="4%" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ItemID','<?= sizeof($arryProduct) ?>');" /></td>-->
                      <td width="9%" class="head1" >Sku</td>
                      <td  class="head1" >Item Description</td>
                      <!--td  width="14%" class="head1" >Track Inventory</td-->
                      <!--td width="15%" class="head1">Valuation Method</td-->
                       
                      <!--td width="12%"  class="head1" >Item Type</td-->
                      <!--td width="10%" class="head1" >Qty on Hand</td-->
                         
                           <td width="9%"  class="head1"align="center">Status</td>
                      <td width="8%"  align="center" class="head1 head1_action" >Action</td>
                  </tr>

                    <?php
                    if (is_array($arryProduct) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryProduct as $key => $values) {
                            $flag = !$flag;
                             $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <td class="head1_inner"><input type="checkbox" name="ItemID[]" id="ItemID<?= $Line ?>" value="<?= $values['ItemID']; ?>"></td>
                                <!--<td class="head1_inner"><input type="checkbox" name="ItemID[]" id="ItemID<?= $Line ?>" value="<?= $values['ItemID']; ?>"></td>-->
                                <td>  
                                  <a href="vItem.php?view=<?=$values['ItemID']?>&curP=<?=$_GET['curP']?>&CatID=<?=  $values["CategoryID"] ?>&tab=basic"  <? if($values['itemType'] == 'Kit'){?> onmouseout="hideddrivetip()" onmouseover="ddrivetip('<center>Avg Cost - <? echo $values['average_cost'];?></center>', 90,'')"  <? } ?>><?= stripslashes($values['Sku']); ?></a>
                                </td>
                                <td><?= stripslashes($values['description']);?></td>
				<!--td><?=ucfirst($values['non_inventory']);?></td-->
                                <!--td><?=stripslashes($values['evaluationType']); ?></td-->
                               
                                <!--td >
                                  <?= stripslashes($values['itemType'])?></td-->
                                 <!--td><?=$values['qty_on_hand'];?></td-->
                               
                               
                                  <td align="center"><?
                                    if ($values['Status'] == 1) {
                                        $status = 'Active';
                                    } else {
                                        $status = 'InActive';
                                    }

                               

                                    echo '<a href="editItem.php?active_id=' . $values["ItemID"] . '&curP=' . $_GET["curP"] . '&CatID=' .  $values["CategoryID"] . '" class="'.$status.' alt="Click to Change Status" title="Click to Change Status">' . $status . '</a>';






                                    ?></td>
                                   
                                <td  align="center" class="head1_inner"  >





                                      <a  href="vItem.php?view=<?=$values['ItemID']?>&curP=<?=$_GET['curP']?>&CatID=<?=  $values["CategoryID"] ?>&tab=basic" ><?=$view?></a>



                                    <a  href="editItem.php?edit=<? echo $values['ItemID']; ?>&curP=<?php echo $_GET['curP']; ?>&CatID=<?= $values["CategoryID"] ?>&tab=basic"><?= $edit ?></a>  

<? if(!$objItem->isSkuTransactionExist($values['Sku'])){ ?>
<a href="editItem.php?del_id=<? echo $values['ItemID']; ?>&CategoryID=<?php echo $values['CategoryID']; ?>&curP=<?php echo $_GET['curP']; ?>&MemberID=<?= $_GET['MemberID'] ?>&CatID=<?=  $values["CategoryID"] ?>" onClick="return confDel('Item')"  ><?= $delete ?></a>
<? } ?>

	</td>
                            </tr>

<?php 

/*if($Config['TrackInventory']==1){
$arryCondQty=$objItem->getItemCondion($values['Sku'],'');

$numQty =count($arryCondQty);

if (is_array($arryCondQty) && $numQty > 0) {*/?>
												<!--tr >
													<td  colspan="8" class="no_record"> 
															<table <?= $table_bg ?>>
																	<tr align="left" valign="middle">
																		<td width="20%"class="head1">Condition</td>
																		<td  width="20%"class="head1">Qty</td>
																		<td  width="20%"class="head1">Average Cost</td>
																	</tr-->
<?php
/*foreach ($arryCondQty as $key => $CondQty) {



                            $flag = !$flag;
                             $bgcolor2=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;
$InvQty = $objItem->CountInvQty($CondQty['ItemID'],$CondQty['condition']);
if($values['evaluationType'] =='LIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'ASC';
$_GET['Sku']  = $values['Sku'];
$_GET['Condition']  = $CondQty['condition'];
$arryVendorPrice=$objItem->GetAvgTransPrice($values['ItemID'],$_GET);
}else if($values['evaluationType'] =='FIFO'){

$_GET['LMT'] = 1;
$_GET['Ordr'] = 'DESC';
$_GET['Sku']  = $values['Sku'];
$_GET['Condition']  = $CondQty['condition'];
$arryVendorPrice=$objItem->GetAvgTransPrice($values['ItemID'],$_GET);

}else{
$_GET['Sku']  = $values['Sku'];
$_GET['Condition']  = $CondQty['condition'];
$arryVendorPrice=$objItem->GetAvgSerialPrice($values['ItemID'],$_GET);
 //$arryVendorPrice[0]['price'] = $arryVendorPrice[0]['price']/$arryVendorPrice[0]['total'];
}



$avCost = number_format($arryVendorPrice[0]['price'],2);
 $SoQty = $csearch->getSaleQTY('sale',$values['ItemID'],$CondQty['condition']);
$avgPriceCond =$CondQty['AvgCost'];
$toQty =$CondQty['condition_qty']+$SoQty;

$InvOnQty = $CondQty['condition_qty']+$InvQty[0]['InvQty'];*/
?>                                  
																		<!--tr align="left" valign="middle" bgcolor="<?= $bgcolor2 ?>">
<? if(!empty($CondQty['condition'])){?>
																		<td><?=Stripslashes($CondQty['condition'])?></td>
																		<td><?=($InvOnQty>0)?$InvOnQty:0 ?></td>
																		<td><?=$avCost." ".$Config['Currency']?></td>
<? }?>
																		</tr-->
<? //}?>

                       
														<!--</table>
													</td>
												</tr>-->
<?php //}  
//}?>
                        <?php  } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="8" class="no_record">No Inventory Items found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryProduct) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>
</div>
                <? if (sizeof($arryProduct)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0">
                        <tr align="center" > 
                            <td height="30" align="left" >
                               <!-- <input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');">-->
                                <!--<input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');" />-->
                                <!--<input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?= $Line ?>','ItemID','editItem.php?curP=<?= $_GET['curP'] ?>&dCatID=<?=$_GET['CatID']?>');" />--></td>
                        </tr>
                    </table>
                <? } ?>

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
<div style="display:none;">
    <div id="dialogContent">
    	<input type="radio" name="synctype" value="one" checked="checked" onclick="chosevalue(this.value); ">sycn this page items
    	<input type="radio" name="synctype" value="all" onclick="chosevalue(this.value);" >sync all item
    	
    </div>
</div>
<input type="hidden" name="synctypeselected" id="synctypeselected" value=""  >


            </form>
        </td>
    </tr>

</table>
<script type="text/javascript">
function chosevalue(selectedval){
	
	$('#synctypeselected').val(selectedval);
	 sendtosync();
	 $.fancybox.close();
	 
}


function sendtosync(){
	var selectedItemID=new Array();
	$('[name="ItemID[]"]:checked').each(function(i,e) {
		
		selectedItemID.push(e.value);
	});
	if(selectedItemID.length==0){
		alert('Please select item first');
	}
	else{
		var selecttype='';
		selecttype=$('#synctypeselected').val();
			
		document.form1.action ="syncItem.php";
		$("#form1").submit();
		//Items=$("input[name='ItemID[]']:checked").serialize();
		//window.location='syncItem.php?'+Items+'&selecttype='+selecttype;
	}
	
}
function selectitems(){
	var selectedItemID=new Array();
	$('[name="ItemID[]"]:checked').each(function(i,e) {
		
		selectedItemID.push(e.value);
	});
	if(selectedItemID.length==0){
		alert('Please select item first');
	}
	else{
		var selecttype='';
		if($('#SelectAll').is(":checked")){
			 
			selecttype='all';
			
			$.fancybox({
		        'type': 'inline',
		        'href': '#dialogContent',
		       'afterClose':function () {
				sendtosync();
	        		}
		    }); 
			 
		 } 
		else{
			document.form1.action ="syncItem.php";
			$("#form1").submit();
			//Items=$("input[name='ItemID[]']:checked").serialize();
			//window.location='syncItem.php?'+Items+'&selecttype='+selecttype;
		}
		
	}
	
}
</script>
