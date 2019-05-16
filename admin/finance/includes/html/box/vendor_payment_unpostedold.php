<script language="JavaScript1.2" type="text/javascript">
$(function() {
        $("#Post_to_GL").click(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one payment.");
                return false;
            } else {
		window.onbeforeunload = null;
		 ShowHideLoader('1','P');
                return true;
            }

        });
    })


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

<?
if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) {

	   CleanPost();
    foreach ($_POST['posttogl'] as $PaymentID) {

        $objBankAccount->commonPostToGL($PaymentID,'','',$_POST['PostToGLDate']);
    }

    $_SESSION['mess_payment'] = AP_POSTED_TO_GL_AACOUNT;
    header("Location:payVendor.php");
    exit;
}


$_GET['PostToGL'] = 'No';
$arryPaymentInvoice = $objBankAccount->ListPaidPaymentInvoice($_GET);
$num = $objBankAccount->numRows();

/*$pagerLink = $objPager->getPager($arryPaymentInvoice, $RecordsPerPage, $_GET['curP']);
(count($arryPaymentInvoice) > 0) ? ($arryPaymentInvoice = $objPager->getPageRecords()) : ("");*/

?>
<div class="had"><?=$MainModuleName?></div>
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
   

 <tr>
            <td align="right" valign="top">
             
                <div style="float:right;">
                    <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" onclick="return checkPosttoGL()" value="Post to GL" style="font-weight: normal; height: 22px;">
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
   
<input id="PostToGLDate" name="PostToGLDate" readonly="" class="datebox" value="<?=$todatdate[0]?>"  type="text" >
               
                  
        
          
              
                      </td>
        </tr>
        <tr>
            <td  valign="top">



                <div id="prv_msg_div" style="display:none">
                    <img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >

                                <td width="14%" class="head1" >Payment Date</td>
				
                                <td width="14%" align="center" class="head1" >Invoice/Credit Memo#</td>
                                <td width="14%"  align="center" class="head1" >Reference No.</td>
                                <td  class="head1">Vendor</td>
                                <td width="11%" align="right" class="head1">Amount (<?= $Config['Currency'] ?>)</td>
                                <td width="14%"  align="center" class="head1">Payment Status</td>
                                <td width="10%"  align="center" class="head1">Action</td>
                                <td width="1%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td>

                            </tr>


                            <?
                        
                        $pay = '<img src="' . $Config['Url'] . 'admin/images/pay.png" border="0"  onMouseover="ddrivetip(\'<center>Pay Vendor</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';
                        $history = '<img src="' . $Config['Url'] . 'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>View History</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';
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
                                ?>


                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                       
                                        <td height="20">
                                            <?
                                            if ($values['PaymentDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
                                            ?>

                                        </td>



                                        <td align="center"> 
<?php 
if(!empty($values["CreditID"])){
	echo $values["CreditID"];
}else{

	if ($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') { ?>
		<a href="vOtherExpense.php?pop=1&amp;Flag=<?= $Flag; ?>&amp;view=<?=$values['ExpenseID']?>" class="fancybox po fancybox.iframe"><?= $values["InvoiceID"]; ?></a>
	<?php } else { ?>
		<a href="vPoInvoice.php?module=Invoice&amp;pop=1&amp;view=<?= $values['OrderID'] ?>" class="fancybox po fancybox.iframe"><?= $values["InvoiceID"]; ?></a>
	<?php }

}

 ?>


                                        </td>  
                                        <td align="center">
 <?=$values['ReferenceNo']?>



                                        </td>
                                        <td><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?= $values['SuppCode'] ?>" ><?= stripslashes(ucfirst($SupplierName)) ?></a></td> 

                                        <td align="right"><strong><?= number_format($values['CreditAmnt'],2,'.',''); ?></strong></td>
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
                                            }else  if ($values['PaymentType'] == 'Other Expense') {
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
                                        

                                    <td align="center">
                                        <?php if ($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') { ?>
                                            <a href="vOtherExpense.php?view=<?= $values['ExpenseID'] ?>&pop=1&pay=1" class="fancybox po fancybox.iframe"><?= $history; ?></a>
                                        <?php } else { ?>
                                            <a href="payInvoiceHistory.php?view=<?= $values['OrderID'] ?>&po=<?= $values['PurchaseID'] ?>&inv=<?= $values[$ModuleID] ?>" target="_blank"><?= $history; ?></a>
                                        <?php } ?>
                                    </td>
                                    <td align="center">
 <?php if ($values['PostToGL'] == "No") { 
	$CountCheck++;
?>
                                            <input type="checkbox" onchange="return ChangePostToGlDate();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl" value="<?php echo $values['PaymentID']; ?>">
        <?php } ?>
                                    </td>

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

                        <tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>  
<!--
    <?php if (count($arryPaymentInvoice) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                                }
                                ?>
-->
</td>
                        </tr>
                    </table>

                </div> 

 <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">


            </td>
        </tr>
    </table>
</form>  
