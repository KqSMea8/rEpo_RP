<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        ShowHideLoader('1');
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }

    $(function() {
        $("#Post_to_GL").click(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one payment.");
                return false;
            } else {
		 ShowHideLoader('1','P');
                return true;
            }

        });
    })

    function filterLead(id)
    {
        location.href = "viewPurchasePayments.php?customview=" + id;
        LoaderSearch();
    }


function ChangePostToGlDate() {	
    	
	var CountCheck = document.getElementById("CountCheck").value;

	var orderno="";	var j=0;	
	for(var i=1; i<=CountCheck; i++){
		if(window.parent.document.getElementById("posttogl"+i).checked){
			j++;
			var posttogl =window.parent.document.getElementById("posttogl"+i).value;
			orderno+=posttogl+',';
		}
	}

	if(j>0){
		if((document.getElementById("gldaterow").style.display == 'none')){ 
			document.getElementById("gldaterow").style.display = '' ;	
		}
        }else{
		document.getElementById("gldaterow").style.display = 'none';  	
	}
    	
    }


function SelectCheck(MainID,ToSelect)
{	
	var flag,i;
	var Num = document.getElementById("CountCheck").value;
	if(document.getElementById(MainID).checked){
		flag = true;
	}else{
		flag = false;
	}
	
	for(i=1; i<=Num; i++){
		document.getElementById(ToSelect+i).checked=flag;
	}
	ChangePostToGlDate();
}
</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center">
    <?php if (!empty($_SESSION['mess_Invoice'])) {
        echo $_SESSION['mess_Invoice'];
        unset($_SESSION['mess_Invoice']);
    } ?></div>
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
        <tr>
            <td align="right" valign="top">

                <? if($ModifyLabel==1){ ?>
                <div style="float:right;">
                    <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" onclick="return checkPosttoGL()" value="Post to GL" style="font-weight: normal; height: 22px;">
                </div>
		<? } ?>


                <div style="float:right; padding-right: 10px;">
                    
                    <a  href="payVendor.php" class="add">Pay Vendor</a>

<? if ($_GET['search'] != '') { ?>
                        <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
<? } ?>
                </div>


            </td>
        </tr>
     
<tr id="gldaterow"  style="display:none">
        
                  
 <td align="right" valign="top"><span class="posttogl">Post to GL Date: </span><script>
$(function() {
$( "#PostToGLDate" ).datepicker({ 
		
	
		showOn: "both",
	yearRange: '<?=date("Y")-10?>:<?=date("Y")?>', 


	dateFormat: 'yy-mm-dd',

	changeMonth: true,
	changeYear: true
	
	});
});
</script>
<? 
$todatdate=$Config['TodayDate'];
$todatdate = explode(" ", $todatdate);
//echo $todatdate[0];exit;

?>
   
<input id="PostToGLDate" name="PostToGLDate" readonly="" class="datebig" value="<?=$todatdate[0]?>"  type="text" >
               
                  
        
          
              
                      </td>
        </tr>
        <tr>
            <td  valign="top">



                <div id="prv_msg_div" style="display:none">
                    <img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
<? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >

                                <td width="10%" class="head1" >Payment Date</td>
				<td width="10%" class="head1" >GL Posting Date</td>
                                <td width="14%"  class="head1" ><?= $ModuleIDTitle ?></td>
                                <td width="10%"  n="center" class="head1" >Reference No.</td>
                                <td  class="head1">Vendor</td>
				 <td width="11%"   class="head1" >Posted By</td>
                                <td width="7%" align="center" class="head1">Amount (<?= $Config['Currency'] ?>)</td>
                                <td width="10%"  align="center" class="head1">Payment Status</td>
                                <td width="12%"  align="center" class="head1">Action</td>
                               <? if($ModifyLabel==1){ ?> <td width="1%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td><? } ?>

                            </tr>
<? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

    <? } ?>
                                <td width="8%"  align="center" class="head1">Action</td>
                                <td width="5%" align="center" class="head1">Select</td>
                            </tr>

                            <?
                        }
                        $pay = '<img src="' . $Config['Url'] . 'admin/images/pay.png" border="0"  onMouseover="ddrivetip(\'<center>Pay Vendor</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';
                        $history = '<img src="' . $Config['Url'] . 'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>View History</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';
 			$sendemail = '<img src="' . $Config['Url'] . 'admin/images/emailsend.png" border="0"  onMouseover="ddrivetip(\'<center>Send Payment Info</center>\', 120,\'\')"; onMouseout="hideddrivetip()" >';


                        if (is_array($arryPaymentInvoice) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $invAmnt = 0;
                            foreach ($arryPaymentInvoice as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                if (empty($values["SuppCompany"])) {
                                    $SupplierName = $objBankAccount->getSupplierName($values['SuppCode']);
                                } else {
                                    $SupplierName = $values["SuppCompany"];
                                }
			
				if($values['PostToGL'] == "Yes" && $separator!=1 && $CountCheck>0) {
					echo '<tr align="center"><td  colspan="10" class="selectedbg">&nbsp;</td></tr>';
					$separator=1;
				}


                                ?>


                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                        <? if ($_GET["customview"] == 'All') { ?>  
                                        <td height="20">
                                            <? 
                                            if ($values['PaymentDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
                                            ?>

                                        </td>

<td>
            <?
            if ($values['PostToGLDate'] > 0)
                echo date($Config['DateFormat'], strtotime($values['PostToGLDate']));
            ?>

        </td>

                                        <td > 
<? 
if(!empty($values["CreditID"])){
	echo $values["CreditID"];
}else{
if($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') { ?>
	<a href="vOtherExpense.php?pop=1&amp;Flag=<?= $Flag; ?>&amp;view=<?=$values['ExpenseID']?>" class="fancybox po fancybox.iframe"><?=$values["InvoiceID"]?></a>
<? } else { ?>
	<a href="vPoInvoice.php?module=Invoice&amp;pop=1&amp;view=<?= $values['OrderID'] ?>" class="fancybox po fancybox.iframe"><?=$values["InvoiceID"]?></a>
<?php } 
}
?>


                                        </td>  
                                        <td >
 <?=$values['ReferenceNo']?>
<!--
<?php if ($values['InvoiceEntry'] == '1') { ?>
	<a href="vPoInvoice.php?module=Invoice&amp;pop=1&amp;view=<?= $values['OrderID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" class="fancybox po fancybox.iframe"><?= $values['PurchaseID'] ?></a> 
<?php } else if ($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == "3") { ?>
	<a href="vOtherExpense.php?pop=1&amp;Flag=<?= $Flag; ?>&amp;view=<?= $values['ExpenseID'] ?>" class="fancybox po fancybox.iframe">
	<?php if ($values['InvoiceEntry'] == "3") { ?>Spiff<?php } else { ?><?= $values['PurchaseID'] ?><?php } ?>
	<? //=$values['PurchaseID'] ?>
	</a>
<?php } else { ?>
	<a href="../purchasing/vPO.php?module=Order&amp;pop=1&amp;po=<?= $values['PurchaseID'] ?>" class="fancybox po fancybox.iframe"><?= $values['PurchaseID'] ?></a>
<?php } ?>
-->



                                        </td>
                                        <td><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?= $values['SuppCode'] ?>" ><?= stripslashes(ucfirst($SupplierName)) ?></a></td> 

<td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>

                                        <td align="center"><strong><?= number_format($values['CreditAmnt'],2,'.',''); ?></strong></td>
                                        <td align="center">
                                            <?  
					    if(!empty($values["CreditID"])){
						 if($values['CreditStatus'] =='Completed'){
							 $StatusCls = 'green';
							 $InvoicePaid = "Applied";
						 }else{
							 $StatusCls = 'red';
							 $InvoicePaid = "Partially Applied";
						 }
                                            }else if ($values['PaymentType'] == 'Other Expense') {
                                                $StatusCls = 'green';
                                                $InvoicePaid = "Paid";
                                            } else { 
                                                if ($values['InvoicePaid'] == 1) {
                                                    $StatusCls = 'green';
                                                    $InvoicePaid = "Paid";
                                                } else {
                                                    $StatusCls = 'red';
                                                    $InvoicePaid = "Partially Paid";
                                                }
                                            }
                                            echo '<span class="' . $StatusCls . '">' . $InvoicePaid . '</span>';
                                            ?>
                                            <br>


                                        </td>
                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'PaymentDate') {

                                                if ($values[$cusValue['colvalue']] > 0) {
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                                } else {
                                                    echo NOT_SPECIFIED;
                                                }
                                            } elseif ($cusValue['colvalue'] == 'InvoicePaid') {
                                                if ($values['InvoicePaid'] == 1) {
                                                    $StatusCls = 'green';
                                                    $InvoicePaid = "Paid";
                                                } else {
                                                    $StatusCls = 'red';
                                                    $InvoicePaid = "Partially Paid";
                                                }

                                                echo '<span class="' . $StatusCls . '">' . $InvoicePaid . '</span>';
                                            } elseif($cusValue['colvalue'] == "SuppCompany"){
                                                
                                                echo '<a class="fancybox fancybox.iframe" href="suppInfo.php?view='.$values['SuppCode'].'" >'.stripslashes(ucfirst($values[$cusValue['colvalue']])).'</a>';
                                                
                                            }elseif($cusValue['colvalue'] == "InvoiceID"){
                                                if ($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') {
                                                    echo '<a href="vOtherExpense.php?pop=1&amp;Flag='.$Flag.'&amp;view='.$values['ExpenseID'].'" class="fancybox po fancybox.iframe">'.$values[$ModuleID].'</a>';
                                                }else{
                                                    echo ' <a href="vPoInvoice.php?module=Invoice&amp;pop=1&amp;view='.$values['OrderID'].'" class="fancybox po fancybox.iframe">'.$values[$ModuleID].'</a>';
                                                    
                                                }
                                                #echo '<a class="fancybox fancybox.iframe" href="suppInfo.php?view='.$values['SuppCode'].'" >'.stripslashes(ucfirst($values[$cusValue['colvalue']])).'</a>';
                                                
                                            }else {?>

                                                <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                                <?
                                            }
                                            echo '</td>';
                                        }
                                    }
                                    ?>

                                    <td align="center" class="head1_inner">








                                        <?php if ($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') { ?>
                                            <a href="vOtherExpense.php?view=<?= $values['ExpenseID'] ?>&pop=1&pay=1" class="fancybox po fancybox.iframe"><?= $history; ?></a>


		<a href="pdf_vendor_payment_history.php?o=<?= $values['ExpenseID'] ?>&pop=1&pay=1&vendorinfo=<?= $values['SuppCode'] ?>" ><?= $download ?></a>
                                            <a class="fancybox fancybox.iframe" href="<?=$SendUrl.'&view='.$values['ExpenseID']?>&ID=<?= $values['PaymentID']?>&pop=1&pay=1&vendorinfo=<?= $values['SuppCode'] ?>" ><?=$sendemail?></a>



                                        <?php } else { ?>
                                            <a href="payInvoiceHistory.php?view=<?= $values['OrderID'] ?>&po=<?= $values['PurchaseID'] ?>&inv=<?= $values[$ModuleID] ?>" target="_blank"><?= $history; ?></a>

<a href="pdf_payInvoice_vendor_payment_history.php?o=<?= $values['OrderID'] ?>&po=<?= $values['PurchaseID'] ?>&inv=<?= $values[$ModuleID] ?>&vendorinfo=<?= $values['SuppCode'] ?>" ><?= $download ?></a>
                                            <a class="fancybox fancybox.iframe" href="<?=$SendUrlPay.'&view='.$values['OrderID']?>&ID=<?= $values['PaymentID']?>&po=<?= $values['PurchaseID'] ?>&inv=<?= $values[$ModuleID] ?>" ><?=$sendemail?></a>


                                        <?php } ?>



<? if($ModifyLabel==1 && $values['PostToGL'] == "No"){?>
	<? if($values['TransactionID']>0){
		if($objTransaction->isTransactionDataExist($values['TransactionID'])){
			echo ' <a href="payVendor.php?edit='.$values['TransactionID'].'&curP='.$_GET["curP"].'" >'.$edit.'</a>';
		}
	}
	echo '<a href="viewPurchasePayments.php?del_payment='.$values['PaymentID'].'&curP='.$_GET['curP'].'" onclick="return confirmDialog(this, \'Payment\')"  >'.$delete.'</a>';
  } 

?>





                                    </td>


<? if($ModifyLabel==1){ ?>
                                    <td align="center">
 <?php if ($values['PostToGL'] == "No") { 
	$CountCheck++;
?>
                                            <input type="checkbox" onchange="return ChangePostToGlDate();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl" value="<?php echo $values['PaymentID']; ?>">
        <?php } ?>
                                    </td>

<? } ?>




                                </tr>



                                <?php
                                $NewInvoiceID = $values['InvoiceID'];
                            } // foreach end //
                            ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="10" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
                                <?php } ?>

                        <tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryPaymentInvoice) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 


                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
 <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">

            </td>
        </tr>
    </table>
</form>    

