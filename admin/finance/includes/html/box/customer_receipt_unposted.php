<script language="JavaScript1.2" type="text/javascript">
$(function() {
        $("#Post_to_GL").click(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one cash receipt.");
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
/* * *******CODE FOR POST TO GL************************************* */

if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) 
{
	   CleanPost();

    foreach ($_POST['posttogl'] as $posttoglData)
     {

        $posttoglDataExplode = explode("#", $posttoglData);

        $PaymentID = $posttoglDataExplode[0];
        $SaleID = $posttoglDataExplode[1];
        $InvoiceEntry = $posttoglDataExplode[2];
        
        $arrySpiff = $objBankAccount->getSpiffData($SaleID);

        if ($arrySpiff[0]['Spiff'] == "Yes" && $arrySpiff[0]['SpiffAmount'] > 0)
         {

            $orderAmount = $objBankAccount->GetOrderTotalPaymentAmntForSale($SaleID);
          }

        $postGLOrderAmnt = $objBankAccount->commonPostToGL($PaymentID, $SaleID, $InvoiceEntry,$_POST['gldate']);

        //echo "=>".$orderAmount."==>".$postGLOrderAmnt;exit;


        if (intval($postGLOrderAmnt) >= intval($orderAmount) && intval($orderAmount) > 0 && $arrySpiff[0]['Spiff'] == "Yes") 
        {


            /*             * ********************GET VENDOR DATA****************************************************** */

            $spiffContact = $arrySpiff[0]['SpiffContact'];
            //echo "=>".$spiffContact;
            $ContactInfoStrip = str_replace("<br>", "", $spiffContact);
            $ContactInfoStrip = str_replace(",", "", $ContactInfoStrip);
            $ContactInfoStrip = str_replace("-", "", $ContactInfoStrip);
            $ExplodespiffContact = explode("|", $ContactInfoStrip);
            //echo '<pre>';print_r($ExplodespiffContact);

            $fullName = $ExplodespiffContact[0];
            $explodeFullName = explode(" ", $fullName);
            $FirstName = $explodeFullName[0];
            $LastName = $explodeFullName[1];

            $arrySupplier = array();
            $arryRgn = array();
            $arrySupplier['FirstName'] = trim($FirstName);
            $arrySupplier['LastName'] = trim($LastName);
            $arrySupplier['Address'] = trim($ExplodespiffContact[1]);
            $arrySupplier['City'] = trim($ExplodespiffContact[2]);
            $arrySupplier['State'] = trim($ExplodespiffContact[3]);
            $arrySupplier['OtherCity'] = trim($ExplodespiffContact[2]);
            $arrySupplier['OtherState'] = trim($ExplodespiffContact[3]);
            $arrySupplier['Country'] = trim($ExplodespiffContact[4]);
            $arrySupplier['ZipCode'] = trim($ExplodespiffContact[5]);
            $arrySupplier['Mobile'] = trim($ExplodespiffContact[7]);
            $arrySupplier['Landline'] = trim($ExplodespiffContact[9]);
            $arrySupplier['Fax'] = trim($ExplodespiffContact[11]);
            $arrySupplier['Email'] = trim($ExplodespiffContact[13]);
            $arrySupplier['Status'] = '1';
            $arrySupplier['Currency'] = $Config['Currency'];
            $arrySupplier['CustomerVendor'] = '1';

            $arryRgn['City'] = trim($ExplodespiffContact[2]);
            $arryRgn['State'] = trim($ExplodespiffContact[3]);
            $arryRgn['Country'] = trim($ExplodespiffContact[4]);

            /*             * ****************************************connect main database******************************** */
            $Config['DbName'] = $Config['DbMain'];
            $objConfig->dbName = $Config['DbName'];
            $objConfig->connect();

            if (!empty($arrySupplier['Country']))
             {
                $arryCountry = $objRegion->GetCountryID($arrySupplier['Country']);
                $arrySupplier["country_id"] = $arryCountry[0]['country_id']; //set	
                if ($arrySupplier["country_id"] > 0 && !empty($arrySupplier["OtherState"])) {
                    $arryState = $objRegion->GetStateID($arrySupplier["OtherState"], $arrySupplier['country_id']);
                    $arrySupplier["main_state_id"] = $arryState[0]['state_id']; //set
                }
                if ($arrySupplier["country_id"] > 0 && !empty($arrySupplier["OtherCity"])) {
                    $arryCity = $objRegion->GetCityID($arrySupplier["OtherCity"], $arrySupplier["country_id"]);
                    $arrySupplier["main_city_id"] = $arryCity[0]['city_id']; //set
                }
            }


            /*             * *********************************connect company database****************************************** */

            //echo '<pre>';print_r($arrySupplier);exit;

            $Config['DbName'] = $_SESSION['CmpDatabase'];
            $objConfig->dbName = $Config['DbName'];
            $objConfig->connect();
            //Check vendor
            $SuppID = $objSupplier->isEmailExistsForCustomerVendor($arrySupplier['Email'], $fullName);

            if ($SuppID > 0) {
                //Update supplier contact address here
                $arrySupplier['SuppID'] = $SuppID;
                $objSupplier->updateSupplierContactAddress($arrySupplier);
                $arrySuppBrief = $objSupplier->GetSupplierBrief($SuppID);
            } else {
                $supplierID = $objSupplier->AddSupplier($arrySupplier);
                //$objSupplier->UpdateCountyStateCity($arryRgn,$supplierID);

                $arrySupplier['PrimaryContact'] = 1;
                $AddID = $objSupplier->addSupplierAddress($arrySupplier, $supplierID, 'contact');
                $objSupplier->UpdateAddCountryStateCity($arryRgn, $AddID);
                $arrySuppBrief = $objSupplier->GetSupplierBrief($supplierID);
            }

            /*             * ***********************************Add Invoice and payment information************************************ */

            $invoicePaymentData = array();

            $invoicePaymentData['TotalAmount'] = $arrySpiff[0]['SpiffAmount'];
            $invoicePaymentData['Amount'] = $arrySpiff[0]['SpiffAmount'];
            $invoicePaymentData['EntryType'] = 'one_time';
            $invoicePaymentData['PaidTo'] = $arrySuppBrief[0]['SuppCode'];
            $invoicePaymentData['GlEntryType'] = 'Single';
            $invoicePaymentData['ExpenseTypeID'] = $arrySpiffSettings[0]['GLAccountTo'];
            $invoicePaymentData['PaymentDate'] = $Config['TodayDate'];
            $invoicePaymentData['PaymentMethod'] = $arrySpiffSettings[0]['PaymentMethod'];
            $invoicePaymentData['BankAccount'] = $arrySpiffSettings[0]['GLAccountFrom'];
            $invoicePaymentData['InvoiceEntry'] = '3';

            $objBankAccount->addOtherExpense($invoicePaymentData);
        }
    }

    $_SESSION['mess_payment'] = AR_POSTED_TO_GL_AACOUNT;
    header("Location:receivePayment.php");
    exit;
}

/* * *******END CODE*********************************** */


$ModuleIDTitle = "Invoice Number";
$ModuleID = "InvoiceID";

$_GET['PostToGL'] = 'No';
$arrySale = $objBankAccount->ListReceivePaymentInvoice($_GET);
$num = $objBankAccount->numRows();
/*
$pagerLink = $objPager->getPager($arrySale, $RecordsPerPage, $_GET['curP']);
(count($arrySale) > 0) ? ($arrySale = $objPager->getPageRecords()) : ("");*/

?>
<div class="borderall">
<div class="had">Unposted <?=$MainModuleName?></div>
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

                               <td width="10%" class="head1" >Payment Date</td>
                           
                                <td width="15%"  class="head1" >Invoice/GL/Credit Memo #</td>
                                <td width="15%"  class="head1" >SO/Reference Number</td>
                                <td   class="head1">Customer</td>
                                <td width="8%" align="right" class="head1">Amount (<?= $Config['Currency'] ?>)</td>
                                <td width="12%"  align="center" class="head1">Payment Status</td>
                                <td width="10%"  align="center" class="head1">Action</td>
                                <td width="1%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td>

                            </tr>


                            <?
                        
                     $receive = '<img src="' . $Config['Url'] . 'admin/images/receive.jpeg" width="25" height="25" border="0"  onMouseover="ddrivetip(\'<center>Receive Payment</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';
                        $history = '<img src="' . $Config['Url'] . 'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>View History</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';
						$CountCheck=0;
                        if (is_array($arrySale) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $invAmnt = 0;
                            foreach ($arrySale as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                ?>


                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                       
                                        <td height="20">
                                           <?
                                            if ($values['PaymentDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
                                            ?>

                                        </td>


 <td >
					<? if(!empty($values["InvoiceID"])){?>
                                            <a href="vInvoice.php?pop=1&amp;view=<?= $values['OrderID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" class="fancybox vSalesPayWidth fancybox.iframe"><?=$values["InvoiceID"]?></a> 
					<? }else if(!empty($values["GLID"])){ 
						echo $values["AccountNameNumber"];
					}else if(!empty($values["CreditID"])){ 
						echo $values["CreditID"];
					} ?>
                                        </td>
                                        <td >
                                            <?php if ($values['InvoiceEntry'] == '1') { ?>
                                                <a href="vInvoice.php?pop=1&amp;view=<?= $values['OrderID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" class="fancybox vSalesPayWidth fancybox.iframe"><?= $values['SaleID'] ?></a> 
            <?php } else { ?>
                                                <a href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?= $values['SaleID'] ?>" class="fancybox vSalesPayWidth fancybox.iframe"><?= $values['SaleID'] ?></a>
            <?php } ?>

                                        </td>
                                        <td><a class="fancybox fancybox.iframe" href="../custInfo.php?CustID=<?= $values['CustID'] ?>" ><?= stripslashes($values['CustomerName']) ?></a></td>

                                        <td align="right"><strong><?= number_format($values['DebitAmnt'],2,'.',''); ?></strong></td>
                                         <td align="center">
                                            <?
					if(!empty($values["InvoiceID"])){
                                            if ($values['InvoicePaid'] == 'Paid') {
                                                $StatusCls = 'green';
                                                $InvoicePaid = "Paid";
                                            } else {
                                                $StatusCls = 'red';
                                                $InvoicePaid = "Partially Paid";
                                            }

                                            echo '<span class="' . $StatusCls . '">' . $InvoicePaid . '</span>';
					}
                                            ?>


                                        </td>
                                        

                                    <td align="center">
					<? if(!empty($values["InvoiceID"])){ ?>
                                        <a href="receiveInvoiceHistory.php?edit=<?= $values['OrderID'] ?>&InvoiceID=<?= $values['InvoiceID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" target="_blank"><?= $history; ?></a>
					<? } ?>
                                    </td>
                                     <td align="center">
                                        <?php if ($values['PostToGL'] == "No") {
												$CountCheck++;
                                        	?>
                                        	<input type="hidden"   name="orno" id="orno<?=$CountCheck?>" value="<?=$values['SaleID']?>">
                                            <input type="checkbox" onchange="return ChangePostToGlDate();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl" value="<?php echo $values['PaymentID']; ?>#<?= $values['SaleID'] ?>#<?= $values['InvoiceEntry'] ?>">
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
</div>
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {


        $(".vSalesPayWidth").fancybox({
            'width': 1000
        });



    });

</script> 
