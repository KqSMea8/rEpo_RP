<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}


function multiSearch(val){
if(val==1){
document.getElementById("serach_form").style.display = 'block';
	document.getElementById("List-serial").style.display = 'none';
}else{
document.getElementById("serach_form").style.display = 'none';
	document.getElementById("List-serial").style.display = 'block';

}

}

</script>

<style>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: auto;
    background-color: white;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}
</style>
<div class="had"> <?=$MainModuleName?> </div>

<div id="List-serial">

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

 
   
    <tr>
        <td  >
            <div class="message"><? if (!empty($_SESSION['mess_product'])) { echo $_SESSION['mess_product']; unset($_SESSION['mess_product']);} ?>
            </div>
        </td>
    </tr>		
	<tr>
		<td  align="right" >
				<? if(!empty($_GET['key']) || !empty($_POST['SearchValue']) || !empty($_GET['Duplicate']) ) {?>
				<a href="<?=$ViewUrl?>" class="grey_bt">View All</a>
				<? }?>
		</td>
	</tr>
    <tr>
        <td id="ProductsListing">

            <form action="" method="post" name="form1">
                
                <div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
                <table <?= $table_bg ?>>


						<tr align="left">
								<!--<td width="4%" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ItemID','<?= sizeof($arrySerial) ?>');" /></td>-->
								<td width="15%"  class="head1">Serial Number</td>
<td  class="head1" width="5%">Sku</td>
<td  class="head1" width="9%"> InvoiceID</td>
								<td  class="head1" width="12%"> Customer</td>
						<td  class="head1" width="5%">PO</td>
									<td  class="head1" width="12%">Vendor</td>
								<td  class="head1" width="8%"> Condition</td>
								<td  class="head1" width="7%"> Unit Price</td>
								<td width="5%" class="head1" >Warehouse</td>
								<td width="6%" class="head1" >Receipt Date</td>
								<td width="8%" class="head1" >Status</td>
						</tr>

                    <?php
                    
                    $UR='';
                    
                    if (is_array($arrySerial) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arrySerial as $key => $values) {
                            $flag = !$flag;
                             $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
                            $Line++;

                            //if($values['Status']<=0){ $bgcolor="#000000"; }



#$objItem->InsertTempSerial($ReceivDate, $UnitPr,$Condition,$values['serialID']);


                            ?>
                            <tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
                                <!--<td class="head1_inner"><input type="checkbox" name="ItemID[]" id="ItemID<?= $Line ?>" value="<?= $values['serialID']; ?>"></td>-->

											<td><?= stripslashes($values['serialNumber']);?> &nbsp;&nbsp;&nbsp;&nbsp; 
<?php if($values['OrderID']!=0 && $values['SelectType']=='Dassemble') {?> 
<div class="tooltip"><a href="" class="InActive">MA</a>
  <span class="tooltiptext"><table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
<tr align="left">
<td class="head1">Sku</td><td class="head1">Serial</td>
</tr>
<?php  $arryRelSerial = $objItem->RelatedSerial($values['OrderID'],''); 

 foreach ($arryRelSerial as $key => $valuesSer) {?>
<tr align="left" valign="middle" >
<td><?=$valuesSer['Sku']?></td><td><?=$valuesSer['serialNumber']?></td>
</tr>
<? }?>
</table>
  </span>
</div>

  <? }?>



</td>
<td><?= stripslashes($values['Sku']); ?></td>
<td>
<? if(!empty($values['InvoiceID'])){?>
<a href="../finance/vInvoice.php?pop=1&amp;inv=<?= stripslashes($values['InvoiceID']); ?>" class="fancybox po fancybox.iframe"><?= stripslashes($values['InvoiceID']); ?></a>
<? }else{?>

<?=NOT_SPECIFIED?>

<? }?>
</td>
											<td>
<? if(!empty($values['OrderCustomerName'])){?>
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>"><?= stripslashes($values['OrderCustomerName']); ?></a>
<? }else{?>

<?=NOT_SPECIFIED?>

<? }?>
</td>
<td>

<? if(!empty($values['pInvoiceID'])){?>
<a class="fancybox po fancybox.iframe" href="../finance/vPoInvoice.php?pop=1&inv=<?=stripslashes($values['pInvoiceID'])?>"><?= stripslashes($values['pInvoiceID']); ?></a>
<? }else{?>

<?=NOT_SPECIFIED?>

<? }?>
</td>
											<td>
<? if(!empty($values['SuppCompany'])){?>
<a href="../finance/suppInfo.php?view=<?=$values['SuppCode']?>" class="fancybox supp fancybox.iframe"><?= stripslashes($values['SuppCompany']); ?></a>
<? }else{?>

<?=NOT_SPECIFIED?>

<? }?>
</td>
											
											<td><?= stripslashes($values['Condition']); ?></td>
											<td>
											<?/*= stripslashes($UnitPr)." ".$Config['Currency'];*/ ?>
											<?= stripslashes($values['UnitCost'])." ".$Config['Currency']; ?>
											</td>
											<td>  
											<a class="fancybox po fancybox.iframe" href="../warehouse/vWarehouse.php?view=<?=$values['warehouse']?>&curP=1&pop=1"><?= stripslashes($values['warehouse_code']); ?></a>
											</td>

 <td >
                                            <?
                                           if ($values['ReceiptDate'] > 0)
													echo date($Config['DateFormat'], strtotime($values['ReceiptDate']));
                                            ?>

                                        </td>

                                <td><? if($values['UsedSerial'] == 0){  $Status = 'Available'; $stus = 'Active';  $class = 'green'; }else{  $Status ='Not Available'; $stus = 'InActive'; $class = 'red';} 

#print_r($_SESSION['AdminType']);
if($_SESSION['AdminType'] =='admin'){

if($_GET['sortby']!='' || $_GET['UsedSerial']!=''||$_GET['Condition']!=''||$_GET['key']!=''||$_GET['FromDate']!=''||$_GET['ToDate']!=''||$_GET['asc']!=''){
 $UR = '&sortby='.$_GET['sortby'].'&UsedSerial='.$_GET['UsedSerial'].'&key='.$_GET['key'].'&FromDate='.$_GET['FromDate'].'&ToDate='.$_GET['ToDate'].'&asc='.$_GET['asc'];
}

 echo '<a href="viewSerial.php?active_id=' . $values["serialID"] . '&curP=' . $_GET["curP"] . ''.$UR.'" class="'.$stus.' alt="Click to Change Status" title="Click to Change Status">' . $Status . '</a>';
}else{
?>
               


                 <span class="<?=$class?>"><?=$Status?></span>
<?}?>
                                    
                                
                                </td>
				
                               
                                 
                            </tr>
                        <?php } // foreach end // ?>



                    <?php } else { ?>
                        <tr >
                            <td  colspan="11" class="no_record">No serial number found.</td>
                        </tr>

                    <?php } ?>



                    <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySerial) > 0) { ?>
                                &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                    }
                    ?></td>
                    </tr>
                </table>
</div>
                <? if (sizeof($arrySerial)) { ?>
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


            </form>
        </td>
    </tr>

</table>
</div>
<div id="serach_form" style="display:none;">

  <form action="viewSerial.php" method="post" name="form1">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
		
		<tr>

			<td colspan="2">
			<div id="move_div">
			<table width="100%" border="0" cellpadding="5" cellspacing="0"
				class="borderall">
				<tr>
					<td align="center" class="head" width="40%">Serach Serial Numbers <div align="right"> <a class="back" href="#" onclick="return multiSearch(0);">Back</a>

</div></td>
					
				</tr>
				<tr>
				
					
					
					<td align="center"><? 
					echo '<textarea  class="inputbox" name="SearchValue" id="SearchValue"  style="width:200px;height:300px; background: rgb(255, 255, 255) none repeat scroll 0 0;" >';
					
					echo '</textarea>';


					?></td>
				</tr>
				<tr>

<td align="center" >	<select name="UsedSerialCheck" id="UsedSerialCheck" class="textbox" ><option <?php if($_GET['UsedSerialCheck']==''){ echo "selected";} ?> value="">Select Status</option><option <?php if($_GET['UsedSerialCheck']=='UnUsed' && $_GET['UsedSerialCheck']!=''){ echo "selected";} ?> value="UnUsed">Available</option><option <?php if($_GET['UsedSerialCheck']=='Used'){ echo "selected";} ?> value="Used">Not Available</option></select></td>


</tr>
			</table>
			</div>
			</td>
		</tr>
		
		<tr>
            <td align="center" height="135" valign="top"><br>
            <input name="Submit" name="Submit" type="Submit" class="button"  value="Search" />
              &nbsp; </td>
          </tr>
	</table>
</form>
</div>
