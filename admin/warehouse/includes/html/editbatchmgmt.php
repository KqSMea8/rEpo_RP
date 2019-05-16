<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>

<div class="had">
<?=$MainModuleName?>  &raquo; <span> 
	<?php 
	 if($_GET["tab"]=="Summary"){
	echo (!empty($_GET['edit']))?(" ".ucfirst($_GET["tab"])." Details") :("Add ".$ModuleName);  
} else{

	 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($ModuleName)." Details") :("Add ".$ModuleName);
	}
	?>
		
		
		</span>
</div>

	  

<!-- By rajan  25 april 2016 --> 

<script language="JavaScript1.2" type="text/javascript">

$(function(){
	
    $("#cfform").submit(function(){    
    
        var err = $(this).validateForm({Email:''});
        if((err === false) || ($('#avail_msg').children('span').hasClass('redmsg') === true)) return false; else return true;
    })
});

</script>
<form name="cfform" id="cfform"  method="post" enctype="multipart/form-data">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">



   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall"> 
    <tr>
	 <td colspan="4" align="left" class="head">Batch Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" valign="top" width="20%"> Batch Name : </td>
        <td   align="left" valign="top" width="30%">
	<input data-mand="y" name="batchname" type="text" class="textbox" id="batchname" value="<?php echo $batcharr[0]['batchname'] ?>"  maxlength="20" oninput ="Javascript:CheckAvailField('avail_msg','batchname','<?=$_GET['edit']?>');" />
        <div style="margin-left:5px;" id="batchnameerr" class="red"></div><div id="avail_msg"></div>
        </td>
     
</tr> 
<?php
            $TodayDateAarry = explode(" ", $Config['TodayDate']);
            if($_GET['edit'])
            {
                //$TodayDate = $batcharr[0]['createdon'];
                $str = 'Created On';
            }else{
                //$TodayDate = $TodayDateAarry[0];
                $str = 'Current Date';
            }
            ?>
<tr>
        <td  align="right"   class="blackbold" valign="top" width="20%"> <?=$str?> : </td>
        <td   align="left" valign="top" width="30%">
            <?php

						$arryTime = explode(" ",$Config['TodayDate']);
						$TodayDate = ($batcharr[0]['createdon']>0)?($batcharr[0]['createdon']):($Config['TodayDate']);
$arryTime = explode(" ",$batcharr[0]['createdon']);

            //$TodayDateAarry = explode(" ", $Config['TodayDate']);
            if($_GET['edit'])
            {
               $btchDate =  date($Config['DateFormat'], strtotime($arryTime[0]))." ".$arryTime[1];
            }else{
               //echo date($Config['DateFormat'], strtotime($arryTime[0]))." ".$arryTime[1];
            }
            ?>


<?php if(!empty($_GET['edit'])){
	//$arryTime = explode(" ",$Config['TodayDate']);
	//$BatchDate = ($batcharr[0]['createdon']>0)?($batcharr[0]['createdon']):($Config['TodayDate']); 
	//echo $ShippedDate;
echo $btchDate;
	?>
	
	<?php } else {?>
		<script type="text/javascript">
		$(function() {
			$('#createdon').datepicker(
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

<? 	
$arryTime = explode(" ",$Config['TodayDate']);
$ShippedDate = ($batcharr[0]['createdon']>0)?($batcharr[0]['createdon']):($Config['TodayDate']); 
?>
<input id="createdon" name="createdon" readonly="" class="inputbox" value="<?=$ShippedDate?>"  type="text" > 
<?php }?>











           
        </td>
     
</tr> 
<tr>
        <td  align="right"   class="blackbold" valign="top" width="20%">Description : </td>
        <td   align="left" valign="top" width="30%">
            <textarea name="description" rows="5" class="inputbox" id="description"><?php echo $batcharr[0]['description'] ?></textarea>
        </td>
     
</tr> 

 </table>	
        <?php if($_GET['edit']){?>
         <table style="display:none;" <?=$table_bg?>>
    <tr>
	 <td colspan="8" align="left" class="head">Entries Listing</td>
    </tr>
    
    <tr align="left"  >
      <td width="10%"  class="head1">Order Date</td>
      <td class="head1" width="10%"> Order No</td>
      <td class="head1" width="10%">Invoice No</td>
      <td class="head1" width="10%"> Order Type</td>
      <td class="head1" width="15%"> Customer Name</td>
      <td width="15%"  align="center" class="head1" > Sales Person</td>
      <td width="10%"  align="center" class="head1" >Amount</td>
      <td width="15%"  align="center" class="head1" >Currency</td>
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
        <td > <?php  if ($values['OrderDate'] > 0) echo date($Config['DateFormat'], strtotime($values['OrderDate'])); ?></td>
        <td > <a class="fancybox po fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?php echo $values['SaleID'] ?>"> <?php echo $values['SaleID'] ?></a></td>
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
    <tr><td  colspan="8" align="right">Total Amount :- <?php echo $total.' '.$Config['Currency'];?> </td></tr>
    
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	
  </table>
        <?php }?>
    </td>
</tr>

<tr>
    <td align="left" valign="top"> &nbsp;</td>
</tr>

<tr>
    <td  align="center">
            <?php if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
            <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
            <input type="hidden" name="batchId" id="batchId" value="<?= $_GET['edit'] ?>" />
            <input type="hidden" name="status" id="status" value="<?= $batcharr[0]['status'] ?>" />
            
    </td>
</tr>

   
</table></form>
