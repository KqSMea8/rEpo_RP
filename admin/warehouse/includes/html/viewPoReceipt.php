<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}

function filterLead(id)
    {
        location.href = "viewPoReceipt.php?customview=" + id;
        LoaderSearch();
    }
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Receipt'])) {echo $_SESSION['mess_Receipt']; unset($_SESSION['mess_Receipt']); }?></div>



<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" height="40" valign="bottom">
		<? if(empty($_GET['po'])){ ?>
		<a class="fancybox add fancybox.iframe" href="PoList.php?link=receiptOrder.php" ><?=RECIEVE_ORDER?></a>
		<? } ?>
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_po_receipt.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
	

		 <? if($_GET['search']!='') {?>
	  	<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   <? if ($_GET["customview"] == 'All') { ?>
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arryReceipt)?>');" /></td>-->
		<td width="10%" class="head1" >Receipt Date</td>
		<td width="10%"  class="head1" >Receipt #</td>
		<td width="10%"  class="head1" >PO/Reference #</td>
		<!--<td width="10%" class="head1" >Order Date</td>-->
		<td class="head1" >Vendor</td>
		<td width="14%"   class="head1" >Posted By</td>
		<td width="8%" align="center" class="head1" >Amount</td>
		<td width="6%" align="center" class="head1" >Currency</td>
		<td width="10%"  align="center" class="head1" >Receipt Status</td>
               <td width="12%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   <? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

    <? } ?>
                               
                                <td width="15%"  align="center" class="head1 head1_action" >Action</td>

                            </tr>
                        <? } ?>
    <?php 
  if(is_array($arryReceipt) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryReceipt as $key=>$values){
	$flag=!$flag;
	$Line++;
        
        if(!empty($values["VendorName"])){
		$VendorName = $values["VendorName"];
	}else{
		$VendorName = $values["SuppCompany"];
	}
	
  ?>
    <tr align="left">
         <? if ($_GET["customview"] == 'All') { ?>   
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">
	   <? if($values['ReceivedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ReceivedDate']));
		?>
	   
	   </td>
       <td><?=$values["ReceiptID"]?></td>
       <td>
      
          <a class="fancybox po fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a>
     
           
           </td>
	  <!--<td>
	   <? //if($values['OrderDate']>0) 
		   //echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>	   
	   </td>-->
      <td> <a class="fancybox supp fancybox.iframe" href="../finance/suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($VendorName)?></a> </td> 
<td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>

       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>


    <td align="center"><? 
		 if($values['ReceiptStatus'] =='Completed'){
			 $PaidCls = 'green';		
		 }else{
			 $PaidCls = 'red';
		 }

		echo '<span class="'.$PaidCls.'">'.$values['ReceiptStatus'].'</span>';
		
	 ?></td>
    
       <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';

                                            if ($cusValue['colvalue'] == 'CustomerName') {
                                                echo '<a class="fancybox fancybox.iframe" href="../custInfo.php?view=' . $values['CustCode'] . '" >' . stripslashes($values["CustomerName"]) . '</a>';
                                            } elseif ($cusValue['colvalue'] == 'SalesPerson') {
                                                echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';
                                            } elseif ($cusValue['colvalue'] == 'InvoicePaid') {
                                                #echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';

                                                if($values['InvoicePaid'] ==1){
                                                 $Paid = 'Paid';  $PaidCls = 'green';
                                                }elseif($values['InvoicePaid'] == 2){
                                                 $Paid = 'Partially Paid';  $PaidCls = 'red';
                                                }else{
                                                 $Paid = 'Unpaid';  $PaidCls = 'red';
                                                }

                                                  echo '<span class="'.$PaidCls.'">'.$Paid.'</span>';

                                                echo '<span class="' . $StatusCls . '">' . $Status . '</span>';
                                            } elseif ($cusValue['colvalue'] == 'OrderDate' || $cusValue['colvalue'] == 'DeliveryDate' || $cusValue['colvalue'] == 'PostedDate') {
                                                if ($values[$cusValue['colvalue']] > 0)
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                            } elseif ($cusValue['colvalue'] == 'EntryType') {
                                                if ($values[$cusValue['colvalue']] == 'one_time') {

                                                    $Entry = explode('_', $values[$cusValue['colvalue']]);

                                                    $EntryType = ucfirst($Entry[0]) . " " . ucfirst($Entry[1]);
                                                    ?>
                                                    <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($EntryType)) : (NOT_SPECIFIED) ?>

                                                <? } else { ?>

                                                    <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes(ucfirst($values[$cusValue['colvalue']]))) : (NOT_SPECIFIED) ?>

                                                <? }
                                            }elseif($cusValue['colvalue'] == 'PurchaseID'){ ?>
                                                
                                               <?php if ($values['InvoiceEntry'] == "1"){?>
                                                    <a href="vPoReceipt.php?pop=1&amp;view=<?=$values['OrderID']?>&IE=<?=$values['InvoiceEntry'];?>" class="fancybox po fancybox.iframe"><?=$values['PurchaseID']?></a>
                                                    <?php } else if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){?>
                                                    <a href="../finance/vOtherExpense.php?pop=1&amp;Flag=<?=$Flag;?>&amp;view=<?=$values['ExpenseID']?>" class="fancybox po fancybox.iframe">
                                                           <?php if($values['InvoiceEntry'] == "3"){?>Spiff<?php }else{ ?><?=$values['PurchaseID']?><?php }?>

                                                    </a>
                                                   <?php } else {?>
                                                       <a class="fancybox po fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a>
                                                   <?php }?>   
                                                
                                                
                                           <? }elseif ($cusValue['colvalue'] == 'SuppCompany') {
                                              echo '<a class="fancybox supp fancybox.iframe" href="suppInfo.php?view='.$values['SuppCode'].'">'.stripslashes($values['SuppCompany']).'</a>';                                 
                                              }else {
                                                ?>

                                                <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                                <?
                                            }

                                            echo '</td>';
                                        }
                                    }
                                    ?>
      <td  align="center" class="head1_inner">

 
           
     <? 

if($_GET['DO'] == 1){

echo $values['GenrateInvoice'];
}

 if($values['ReceiptStatus'] !='Completed'){ ?>   
 <a href="editPoReceipt.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>"><?=$edit?></a>
           
    <a href="editPoReceipt.php?del_id=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 
     <?php }?>
<a href="vPoReceipt.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>"><?=$view?></a>
    <?php if($values['InvoiceEntry'] != 2 && $values['InvoiceEntry'] != 3){?>
    <!--<a href="pdfPoReceipt.php?o=<?=$values['OrderID']?>&module=<?=$module?>" ><?=$download?></a>-->
  <a href="../pdfCommonhtml.php?o=<?=$values['OrderID']?>&module=<?=$module?>&ModuleDepName=WhousePOReceipt" ><?=$download?></a>
    <?php }

 if($values['ReceiptStatus'] =='Completed' && $values['GenrateInvoice'] !=1){ ?>   
<br>
 <a href="editPoReceipt.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>">Generate Invoice</a>
           
   
     <?php }?>



	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReceipt)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryReceipt)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td  align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
	$(".po").fancybox({
		'width'  : 900
	 });


});

</script>


<? } ?>
