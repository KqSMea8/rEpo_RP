<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch() {
	ShowHideLoader('1','F');
      
    }
function SetRecType(EntryInterval){	
	var url = 'viewPoRecurringInvoice.php?intv='+EntryInterval;
	ShowHideLoader('1','F');
	window.location = url;

}
/*
$(function() {
	$( "#EntryInterval" ).selectmenu({
	  change: function( event, ui ) {
             console.log(ui);
               var vals = ui.item.value;		
           	SetRecType(vals);
         }

     });
      
});*/
</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><?
    if (!empty($_SESSION['mess_recpo_inv'])) {
        echo $_SESSION['mess_recpo_inv'];
        unset($_SESSION['mess_recpo_inv']);
    }
    ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
  <tr>
        <td  valign="top">

<table id="search_table" cellspacing="0" cellpadding="0" border="0" style="margin:0">
<form name="frmSrch" id="frmSrch" action="" method="get" onsubmit="return ValidateSearch();">
<tr>
<td align="left">
<select name="intv" class="textbox" id="intv" >
	<option value="" <?php if($_GET['intv'] == ""){echo "selected";}?>>ALL</option>
	<? foreach($arryInterval as $interval){ 
		$sel = ($_GET['intv'] == $interval)?("selected"):("");
		$intervalLabel = str_replace("_"," ",$interval);
		echo '<option value="'.$interval.'" '.$sel.'>'.ucfirst($intervalLabel).'</option>';
	}?>

	</select>
</td>

<td align="left">
<select name="status" class="textbox" id="status"> 
	<option value="Active" <?php if($_GET['status'] == "Active"){echo "selected";}?>>Active</option>
	<option value="InActive" <?php if($_GET['status'] == "InActive"){echo "selected";}?>>InActive</option>
</select>
</td>
<td align="left">
  <input type="submit" value="Go" class="search_button" name="s">
</td>

</tr>


</form>
</table>






 </td>
    </tr>

    <tr>
        <td align="right" valign="top">
            <? if ($num > 0) { ?>
                <!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_po.php?<?= $QueryString ?>&EntryType=<?=$_GET['EntryType']?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();" -->

            <? } ?>



            <!--a href="<?= $AddUrl ?>" class="add">Add Recurring <?= $ModuleName ?></a-->

            <? if ($_GET['search'] != '') { ?>
                <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
            <? } ?>


        </td>
    </tr>

    <tr>
        <td  valign="top">


            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                       
                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?= sizeof($arryPurchase) ?>');" /></td>-->
				<!--td width="12%"  class="head1" >Invoice Number</td>
                                <td  class="head1" >Invoice Date</td-->
                                <td class="head1">Vendor Name</td>
				 <td width="8%" class="head1">Invoice #</td>                              
                                 <td width="8%" class="head1">Amount</td>                              
                                <td width="8%"  class="head1">Currency</td>

                                <td width="8%" class="head1">Interval</td>
				
				<td width="8%"  class="head1" >Entry Date</td>
				
				<td width="10%" class="head1">Every</td>

                                <td width="12%" class="head1">Entry From</td>

                                <td width="12%" width="8%"  class="head1" >Entry To</td>
                               
                    
                                <td width="7%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>
                       
                        <?php

$cancel = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Cancel</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';


if (is_array($arryPurchase) && $num > 0) {
    $flag = true;
    $Line = 0;
    $OrderType = '';
    $TotalAmount = 0;
$SuppCode='';
 
    foreach ($arryPurchase as $key => $values) {
        $flag = !$flag;
      
        $Line++;
        
	
	$ConversionRate=1;
	if($values['Currency']!=$Config['Currency'] && $values['ConversionRate']>0){
		$ConversionRate = $values['ConversionRate'];			   
	}
	
     
            
	          
  ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">

                                  

                   
<td>
<? if($SuppCode != $values['SuppCode']){ ?>

<? if(!empty($values["VendorName"])){?>
<a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?= $values['SuppCode'] ?>" ><?= stripslashes($values["VendorName"]) ?></a>
<? }else{ echo $values["SuppCompany"]; } ?>

<? } ?>
 
</td> 
<td><?= $values['InvoiceID'] ?></td>

 <td> 

<? 
 
if($values['PostToGL']=="1" && $values['RecurringAmount']>0 && ($values['InvoiceEntry']=="2" || $values['InvoiceEntry']=="3") ){
	$AmountVal = $values['RecurringAmount'];
}else{
	$AmountVal = $values['TotalAmount'];
}
 echo number_format($AmountVal,2);

$Amount = GetConvertedAmount($ConversionRate, $AmountVal);  

$TotalAmount += $Amount;

   ?>
</td>

<td><?= $values['Currency'] ?> </td>
                    
 <td>

	<?php
	if(!empty($values['EntryInterval'])){
		$_GET['intv'] = $values['EntryInterval'];
	}else{
		$_GET['intv'] = "Monthly";
	}
	if($_GET['intv'] == "semi_monthly"){ $_GET['intv'] = "Semi Monthly";  }

	echo ucfirst($_GET['intv']);
	?>




</td>

<td>

 <? if($values['EntryInterval'] != 'biweekly' && $values['EntryInterval'] != 'semi_monthly'){
	echo $values['EntryDate'];

 }?> 

</td>

<td>



<? if($values['EntryInterval'] == "yearly"){ 
                        $monthNum  = $values['EntryMonth'];
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $dateObj->format('F'); 
	echo $monthName;
  } else if($values['EntryInterval'] == "biweekly"){ 
	echo $values['EntryWeekly'];
  }
?>



</td>
 
<td>
<?php  if($values['EntryFrom']>0)echo date($Config['DateFormat'], strtotime($values['EntryFrom']));?>
</td>

<td>
<?php  if($values['EntryTo']>0)echo date($Config['DateFormat'], strtotime($values['EntryTo']));?>

</td>




                                       

                                    
                                    <td  align="center" class="head1_inner">

 <? if($ModifyLabel == 1){ ?>                                 
 <a class="fancybox fancybox.iframe" href="<?= $EditUrl . '&pop=1&edit=' . $values['OrderID'] ?>" ><?= $edit ?></a>
                                                                           
 <!--a href="viewPoRecurringInvoice.php?cancel_id=<?=$values['OrderID']?>" onclick="return confirmAction(this, '<?= $ModuleName ?>','Are you sure you want to cancel this <?= $ModuleName ?>?')"><?= $cancel ?></a-->                                      

 <a href="Javascript:void(0);" onclick="Javascript:RemoveRecord(this,'<?=$values['OrderID']?>','AP Recurring Invoice','cancel')" ><?= $cancel ?></a>


<? } ?>


                                    </td>
                                </tr>
                            <?php 
$SuppCode = $values['SuppCode'];
} // foreach end // ?>

<?php }else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
<?php } ?>

                        <tr>  <td  colspan="2" id="td_pager">Total Record(s) : &nbsp;
<span id="recordCount"><?=$num?></span> 
   <?php if ($num>count($arryPurchase)) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
				<td  colspan="9"  id="td_pager">
				<?
					 
					if(!empty($TotalAmount)){
						echo '<strong>'.number_format($TotalAmount,2).' '.$Config['Currency'].'</strong>';
					}
				?>
					
				</td>
                        </tr>
                    </table>

                </div> 


                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>

