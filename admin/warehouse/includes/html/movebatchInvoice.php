<script type="text/javascript">
$(function(){
$("#moveto").submit(function(){
     err =  $(this).validateForm({
              Email: ""
          });
    
    if(err === false ){ return false; }else{ return true;}
    });        
});  
</script>    
<div class="had"></div>
<div class="message" align="center"><?php if(!empty($_SESSION['mess_batch'])) {echo $_SESSION['mess_batch']; unset($_SESSION['mess_batch']); }?></div>
<form name="moveto" id="moveto" method="post">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 
	<tr>
	  <td  valign="top">
<?php if(!$_POST){ ?>
<table <?=$table_bg?>>
    <tr>
	 <td colspan="9" align="left" class="head"><strong>Entries Listing (To Move Select Checkbox)</strong></td>
    </tr>
    
    <tr align="left"  >
	<td width="10%"  align="center" class="head1" >Move Invoice</td>      
	<td width="10%"  class="head1">Order Date</td>
      <td class="head1" width="10%"> Order No</td>
      <td class="head1" width="10%">Invoice No</td>
      <td class="head1" width="10%"> Order Type</td>
      <td class="head1" width="15%"> Customer Name</td>
      <td width="15%"  align="center" class="head1" > Sales Person</td>
      <td width="10%"  align="center" class="head1" >Amount</td>
      <td width="10%"  align="center" class="head1" >Currency</td>
    </tr>
   
    <?php 
    $total = '';
    if(is_array($EntriesArr) && count($EntriesArr)>0){
          $flag=true;
          $Line=0;
          foreach($EntriesArr as $key=>$values){
          $flag=!$flag;
          $bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
          $Line++;
    ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	<td align="center"><input type="checkbox" name="moveto[]" id="moveto" value="<?php echo $values['OrderID'] ?>"></td>
        <td > <?php  if ($values['OrderDate'] > 0) echo date($Config['DateFormat'], strtotime($values['OrderDate'])); ?></td>
        <td > <?php echo $values['SaleID'] ?></td>
        <td > <?php echo  stripslashes($values["InvoiceID"]); ?></td>
        <td > <?php if($values["OrderType"] != '') echo $values["OrderType"]; else echo 'Standard';?></td>
        <td ><?= stripslashes($values["CustomerName"]) ?></td>
        <td> <?= $values['SalesPerson'] ?></td>
        <td>
        
            <?php if($values['CustomerCurrency']!=$Config['Currency']){ ?>
            <?php $ConversionPrice = round($values['TotalAmount']*$values['ConversionRate'],2); 
                    $total += $ConversionPrice;
            ?>
            <span class="red"> (<?php echo $ConversionPrice." ".$Config['Currency'];?>)</span>
            <?php }else{ 
                $total += $values['TotalAmount'];
                echo $values['TotalAmount'] ;  }  ?>

        
        
        </td>
        <td ><?= $values['CustomerCurrency'] ?></td>
    </tr>
    <?php } // foreach end //?>
    <tr><td  colspan="9" align="right">Total Amount :- <?php echo $total.' '.$Config['Currency'];?> </td></tr>
	<tr align="center">
	    <td colspan="9" >
		    <input name="Move" type="submit" class="button" id="Move" value="Move"  />
		    <input type="hidden" name="batchId" id="batchId" value="<?= $_GET['batchId'] ?>" />
	    </td>
	</tr>



  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	
  </table>
<?php }else{ ?>
<table <?=$table_bg;?>>
	<tr>
	 	<td colspan="9" align="left" class="head"><strong>Batch Listing (Select Batch To Move Invoice)</strong></td>
	</tr>
	<tr>
		<td  align="right"   class="blackbold" valign="top" width="20%"> Batch List : </td>
		<td   align="left" valign="top" width="30%">
		<select data-mand="y" name="batchId" id="batchId" class="inputbox" >
		<option value="">Select Batch</option>
		<?php  if(!empty($arryBatch)){
			foreach($arryBatch as $values){
		?>
			<option value="<?=$values['batchId']?>"><?=$values['batchname']?></option>

		<?php } } ?>
		</select>
                <div id="batchIderr" class="red" style="margin-left:5px;"></div>    
		</td>
	</tr>
	<tr align="center">
		<td colspan="9">
		    <input name="Save" type="submit" class="button" id="Save" value="Save"  />
		    <input type="hidden" name="frbatchId" id="frbatchId" value="<?= $_GET['batchId'] ?>" />
		    <input type="hidden" name="invoiceIds" id="invoiceIds" value="<?=$MoveIds?>" />
		</td>
	</tr>
</table>
<?php }?>
</td>
	</tr>
</table>
</form>
