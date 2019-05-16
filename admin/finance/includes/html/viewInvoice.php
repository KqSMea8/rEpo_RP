<script language="JavaScript1.2" type="text/javascript">
function ProcessCreditCard(OrderID,Line){
   
	var SendUrl = "&action=PCard&OrderID="+escape(OrderID)+"&r="+Math.random();

	$("#dialog-modal").html("<?=AUTH_CARD?>");
    $("#dialog-modal").dialog(
    {
        title: "Authorize Credit Card",
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() {
				 $(this).dialog("close");
				 ShowHideLoader(1,'P');

				 $.ajax({
					type: "GET",
					url: "../processCardInv.php",
					data: SendUrl,
					dataType : "JSON",
					success: function (responseText)
					 {	
						
						var Msg = '';
						if(responseText["Status"]=="1"){
							Msg = '<div class=greenmsg>'+responseText["MSG"]+'</div>';
							document.getElementById("ccLink"+Line).style.display = 'none';
							document.getElementById("Balance"+Line).style.display = 'none';
						}else if(responseText["ErrorMSG"]!=""){
							Msg = responseText["ErrorMSG"];
						}else {
							Msg = "Error in card processing.";
						}
						document.getElementById("processcard_div").innerHTML = Msg;
						$("#processcard_link").fancybox().trigger('click');
						 ShowHideLoader(0,'');
		
						   
					}

				   });
									 

			},
			"Cancel": function() {
				 $(this).dialog("close");
			}
		}

     });



}



function VoidCreditCard(OrderID,Line){
   
	var SendUrl = "&action=VCard&OrderID="+escape(OrderID)+"&r="+Math.random();

	$("#dialog-modal").html("<?=VOID_CARD?>");
    $("#dialog-modal").dialog(
    {
        title: "Void Credit Card",
		modal: true,
		width: 400,
		buttons: {
			"Ok": function() {
				 $(this).dialog("close");
				 ShowHideLoader(1,'P');

				 $.ajax({
					type: "GET",
					url: "../processCardInv.php",
					data: SendUrl,
					dataType : "JSON",
					success: function (responseText)
					 {	
						
						var Msg = '';
						if(responseText["Status"]=="1"){
							Msg = '<div class=greenmsg>'+responseText["MSG"]+'</div>';
							document.getElementById("vvLink"+Line).style.display = 'none';
							
						}else if(responseText["ErrorMSG"]!=""){
							Msg = responseText["ErrorMSG"];
						}else {
							Msg = "Error in processing of card refund.";
						}
						document.getElementById("processcard_div").innerHTML = Msg;
						$("#processcard_link").fancybox().trigger('click');
						 ShowHideLoader(0,'');
		
						   
					}

				   });
									 

			},
			"Cancel": function() {
				 $(this).dialog("close");
			}
		}

     });



}


    function ValidateSearch() {
        ShowHideLoader('1');
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }

 $(function() {
        $("#Post_to_GL").click(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one invoice.");
                return false;
            } else {

		var InvoiceAmount=0;
		var CountCheck = document.getElementById("CountCheck").value;
		for(var i=1; i<=CountCheck; i++){
			if(window.document.getElementById("posttogl"+i).checked){
				InvoiceAmount = Math.abs(window.document.getElementById("InvoiceAmount"+i).value);	

				if(InvoiceAmount<=0){
					if(confirm("Are you sure you want to post invoice having 0 amount?")){
						ShowHideLoader('1','P');
						return true;
					}else{
						return false;
					}
					 
				}
			}
		}
	 


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


    function filterLead(id)
    {
        location.href = "viewInvoice.php?customview=" + id;
        LoaderSearch();
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


 /*function by sachin**/
    function makepdffile(url) {
        $.ajax({
            url: url,
        });
    }
    /*function by sachin**/

</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><?php
        if (!empty($_SESSION['mess_Sale'])) {
            echo $_SESSION['mess_Sale'];
            unset($_SESSION['mess_Sale']);
        }
        ?><? if (!empty($_SESSION['mess_Invoice'])) {
    echo $_SESSION['mess_Invoice'];
    unset($_SESSION['mess_Invoice']);
} ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
        <td align="center" valign="top">

<a class="fancybox" id="processcard_link" href="#processcard_div"  style="display:none">sent</a>
<div id="processcard_div" class="redmsg" style="display:none;padding:15px;width:300px;" align="center" ></div>


</td>
      </tr>

  <form action="" method="post" name="form1">
    <tr>
        <td align="right" valign="top">
 <a  class="add" href="editInvoiceEntry.php">Invoice Entry</a>

            <a class="fancybox add fancybox.iframe" href="SalesOrderList.php?link=generateInvoice.php" ><?= GENERATE_INVOICE ?></a>
            <? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_invoice.php?<?= $QueryString ?>';" />
                <!--<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>-->
            <? } ?>

<? if ($_GET['search'] != '') { ?>
                <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
<? } ?>


        </td>
    </tr>

 <? if($num > 0 && $ModifyLabel==1){ ?> 	 
<tr>
	  <td  valign="top" align="right">
	<?php //added by nisha
$ToSelect = 'posttogl';
include_once("../includes/FieldArrayRow.php");
echo $RowColorDropDown;
?>
 <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" value="Post to GL" style="font-weight: normal; height: 22px;">


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

<? }





?>



    <tr>
        <td  valign="top">


          
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                        <tr align="left"  >
				<? if ($_GET["customview"] == 'All') { ?>

									<td width="10%" class="head1" >Invoice Date</td>
									<td width="12%" class="head1" >GL Posting Date</td>
									<td width="8%"  class="head1" >Invoice #</td>
									<td width="9%"  class="head1" >SO/Reference #</td>
									<td width="8%"  class="head1" >PO#</td>
									<td class="head1">Customer</td>
									<td width="10%"   class="head1" >Posted By</td>
									<!--td class="head1">Sales Person</td-->
									<td width="8%" align="center" class="head1">Amount</td>
									<td width="6%" align="center" class="head1">Currency</td>
									<td width="7%"  align="center" class="head1">Status</td>  
                           
			<? } else {                 
                                foreach ($arryColVal as $key => $values) { ?>
                                    <td class="head1" ><?= $values['colname'] ?></td>
    			<?	} 
                           
                        } ?>

				<td width="15%"  align="center" class="head1 head1_action" >Action</td>
			 	<? if($ModifyLabel==1){ ?> <td width="1%" align="center" class="head1">
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td>
				<? } ?>

			 </tr>

                        <?php

	$CardPay = '<img src="'.$Config['Url'].'admin/images/card.png" border="0"  onMouseover="ddrivetip(\'<center>Pay through credit card</center>\', 150,\'\')"; onMouseout="hideddrivetip()" >';

 $CardProcess = '<img src="'.$Config['Url'].'admin/images/card.png" border="0"  onMouseover="ddrivetip(\'<center>Authorize Credit Card</center>\', 150,\'\')"; onMouseout="hideddrivetip()" style="display:inline;">';

$VoidCard = '<img src="'.$Config['Url'].'admin/images/cc.png" border="0"  onMouseover="ddrivetip(\'<center>Void Credit Card</center>\', 150,\'\')"; onMouseout="hideddrivetip()"  >';

$NotPosted = '<img src="' . $Config['Url'] . 'admin/images/error-icon.png"  border="0"  onMouseover="ddrivetip(\'<center>'.NOT_POSTED_TOGL.'</center>\', 125,\'\')"; onMouseout="hideddrivetip()" >';

$arryTime = explode(" ",$Config['TodayDate']);
$TodayDate = $arryTime[0];

 
 
                        if (is_array($arrySale) && $num > 0) {
                            $flag = true;
                            $Line = 0;
				$CountCheck=$separator=$SumAmount=0;
                            foreach ($arrySale as $key => $values) {
                                $flag = !$flag;                           
                                $Line++;
				$HidePostToGL='';
				if($values['PostToGL'] == "1" && $separator!=1 && $CountCheck>0) {
					echo '<tr align="center"><td  colspan="12" class="selectedbg">&nbsp;</td></tr>';
					$separator=1;
				}


				$EmailIcon = ($values['MailSend']!=1)?('emailgreen.png'):('emailred.png');
			 	$sendemail = '<img src="' . $Config['Url'] . 'admin/images/'.$EmailIcon.'" border="0"  onMouseover="ddrivetip(\'<center>Send Invoice</center>\', 120,\'\')"; onMouseout="hideddrivetip()" >';




 /********************/
if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){
	$ModuleDepName = "SalesInvoiceGl";
}else{
	$ModuleDepName = "SalesInvoice";
}
$PdfResArray = GetPdfLinks(array('Module' => 'Invoice',  'ModuleID' => $values['InvoiceID'], 'ModuleDepName' => $ModuleDepName, 'OrderID' => $values['OrderID'], 'PdfFolder' => $Config['S_Invoice'], 'PdfFile' => $values['PdfFile']));
/********************/

 

                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?> >
                                
                                        <? if ($_GET["customview"] == 'All') { ?>   
                                     
                                        <td height="20">
                                            <?
                                            if ($values['InvoiceDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
                                            ?>

                                        </td>

<td>
            <?
            if ($values['PostToGLDate'] > 0)
                echo date($Config['DateFormat'], strtotime($values['PostToGLDate']));
            ?>

        </td>

                                        <td><?=$values["InvoiceID"]?></td>
                                        <td>
                                            <?php if ($values['InvoiceEntry'] == "1") { ?>
                                                <a href="vInvoice.php?pop=1&amp;view=<?= $values['OrderID'] ?>&IE=<?= $values['InvoiceEntry']; ?>" class="fancybox po fancybox.iframe"><?= $values['SaleID'] ?></a>
            <?php } else { ?>
                                                <a href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?= $values['SaleID'] ?>" class="fancybox po fancybox.iframe"><?= $values['SaleID'] ?></a>
            <?php } ?>
                                        </td>

<td><?=$values["CustomerPO"]?></td>

                                        <td>
<? if(!empty($values["CustomerName"])){?>
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?= $values['CustCode'] ?>" ><?= stripslashes($values["CustomerName"]) ?></a> <?php if(!empty($values["EDICompId"])){echo $ediicon;}?>
<? }else{ echo $values["OrderCustomerName"]; } ?>


</td> 

<td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>

                                        <!--td><?= stripslashes($values['SalesPerson']) ?></td-->
                                        <td align="center" nowrap>

 
<?
echo $values['TotalInvoiceAmount'];

$SumAmount += $values['TotalInvoiceAmount'];
 
if($values['PostToGL'] == "1" && $values['InvoicePaid']=='Part Paid'){  
	$paidOrderAmnt = $objBankAccount->GetTotalPaymentInvoice($values['InvoiceID'],"Sales");  
	if(!empty($paidOrderAmnt)){ 	
		$Balance =  $values['TotalInvoiceAmount'] - $paidOrderAmnt; 
		if($Balance>0)echo '<div class=redmsg>Balance: '.number_format($Balance,'2').'</div>'; 
	} 
}else if($values['PostToGL'] != "1" && $values['BalanceAmount']>0 && $values['PaymentTerm']=='Credit Card'){
	echo '<div class=redmsg id="Balance'.$Line.'">Balance: '.$values['BalanceAmount'].'</div>';
	$HidePostToGL = 1;
}


?>


</td>
                                        
                                        <td align="center"><?= $values['CustomerCurrency'] ?></td>
                                        <td align="center">
<?	
echo $InvoiceStatus = $objSale->GetInvoiceStatusMsg($values['InvoicePaid'],$values['PaymentTerm'],$values['OrderPaid']);
	
	/*$InvoicePaid = $values['InvoicePaid'];
	if ($InvoicePaid == 'Paid') {
		$StatusCls = 'green';
	} else {
		$StatusCls = 'red';
	}
	if($InvoicePaid=='Unpaid' && ($values['PaymentTerm']=='Credit Card' || $values['PaymentTerm']=='PayPal')  && ($values['OrderPaid']==1 || $values['OrderPaid']==3 || $values['OrderPaid']==4)){
		 $StatusCls = 'green';
		 $InvoicePaid = $values['PaymentTerm'];
	}
	echo '<span class="' . $StatusCls . '">' . $InvoicePaid . '</span>';*/
?>

                                        </td>
                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';

                                            if ($cusValue['colvalue'] == 'CustomerName') {
                                                echo '<a class="fancybox fancybox.iframe" href="../custInfo.php?view=' . $values['CustCode'] . '" >' . stripslashes($values["CustomerName"]) . '</a>';
                                                if(!empty($values["EDIRefNo"])){echo $ediicon;}
                                            } elseif ($cusValue['colvalue'] == 'SalesPerson') {
                                                echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';
                                            } elseif ($cusValue['colvalue'] == 'InvoicePaid') {
                                                #echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';

                                                if ($values['InvoicePaid'] == 'Paid') {
                                                    $StatusCls = 'green';
                                                } else {
                                                    $StatusCls = 'red';
                                                }

                                                echo '<span class="' . $StatusCls . '">' . $values['InvoicePaid'] . '</span>';

                                                echo '<span class="' . $StatusCls . '">' . $Status . '</span>';
                                            } elseif ($cusValue['colvalue'] == 'OrderDate' || $cusValue['colvalue'] == 'DeliveryDate' || $cusValue['colvalue'] == 'InvoiceDate') {
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
                                            } else {
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
$TransactionExist=0;
$NotifyIcon='';unset($arrStatusMsg);
if($values['PaymentTerm']=='Credit Card'){
	$TransactionExist = $objSale->isSalesTransactionExist($values['OrderID'], $values['PaymentTerm']);
	if(!empty($values['StatusMsg'])){
		$arrStatusMsg = explode("#",$values['StatusMsg']);
		$NotifyIcon = ($arrStatusMsg[0]==1)?('notify.png'):('fail.png');
	 	$StatusMsg = str_replace ("'"," ",stripslashes($arrStatusMsg[1]));
	 	echo $NotifyIcon = '<img src="' . $Config['Url'] . 'admin/images/'.$NotifyIcon.'" border="0"  onMouseover="ddrivetip(\'<center>'.$StatusMsg.'</center>\', 300,\'\')"; onMouseout="hideddrivetip()" >';
	}
	
}
?>





<?php if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){
	$ModuleDepName = "SalesInvoiceGl";
?>
<a href="vInvoiceGl.php?curP=<?=$_GET['curP']?>&view=<?=$values['OrderID']?>" ><?=$view?></a>
<? }else{ $ModuleDepName = "SalesInvoice"; ?>
<a href="vInvoice.php?curP=<?=$_GET['curP']?>&view=<?=$values['OrderID']?>&IE=<?=$values['InvoiceEntry']?>" ><?=$view?></a>
<? } ?>

<? 
 
if($values['InvoicePaid'] == 'Unpaid' && $values['PostToGL'] != "1") { ?>

	
	<?php if($values['InvoiceEntry']>0){?>
	<a href="editInvoiceEntry.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>
	<?php } else {?>
	<a href="editInvoice.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>
	<?php }?>
	
	<? if($TransactionExist!=1){ ?>
        <a href="<?=$EditUrl.'&del_id='.$values['OrderID']?>" onclick="return confirmDialog(this, 'Invoice')"><?=$delete?></a> 
		<? } ?>
<? } 
 
 

echo '<a  href="'.$PdfResArray['DownloadUrl'].'" >'.$download.'</a>';

echo'<a  '.$PdfResArray['MakePdfLink'].' class="fancybox fancybox.iframe" href="'.$SendUrl . '&view=' . $values['OrderID'].'" >'.$sendemail.'</a>';
 

if(in_array($values['OrderID'],$arrCommentOrderID)){
	$commentIcon =  $comment_red;
}else{
	$commentIcon =  $comment;
}
?>



<a class="fancybox com fancybox.iframe"  href="../erpComment.php?view=<?php echo $values['OrderID']; ?>&module=<?php echo $_GET['module']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=Comments&popLead=1&AR=<?php echo $values[$ModuleID]; ?>" ><?=$commentIcon?></a>


<?   
/**************/
if($ModifyLabel==1  && $values['InvoicePaid'] != 'Paid' ) {  
	if($values['PostToGL'] == "1" && $values['OrderPaid'] != "1"){
		echo '<a class="fancybox fancybig fancybox.iframe" href="payInvoice.php?view='.$values['OrderID'].'" >'.$CardPay.'</a>';
	}else if($values['PostToGL'] != "1" && $values['PaymentTerm']=='Credit Card'){
 
		/*if($values['OrderPaid'] == "1" || $values['OrderPaid'] == "3"){
			echo '<a href="Javascript:void(0)" id="vvLink'.$Line.'" onclick="return VoidCreditCard(\''.$values['OrderID'].'\',\''.$Line.'\')" >'.$VoidCard.'</a>';
		}else{
			echo '<a href="Javascript:void(0)" id="ccLink'.$Line.'" onclick="return ProcessCreditCard(\''.$values['OrderID'].'\',\''.$Line.'\')" >'.$CardProcess.'</a>';
		}*/
		
		
		 //Partial
		if($values['OrderPaid'] == "1"){
			echo '<a href="payINV.php?OrderID='.$values['OrderID'].'&Action=VCard"  class="fancybox voidcard fancybox.iframe" >'.$VoidCard.'</a>';
		}else{
			echo '<a href="payINV.php?OrderID='.$values['OrderID'].'&Action=PCard"  class="fancybox authcard fancybox.iframe" >'.$CardProcess.'</a>';
		}

	}
}
/*************/

 


	echo '<ul class="print_menu" style="width:60px;"><li class="print" ><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'">&nbsp;</a></li></ul>';
 
	?>
                                    </td>
                               


<? if($ModifyLabel==1){ ?> 
 <td align="center">
<?php if($values['PostToGL'] != "1" && empty($HidePostToGL)) { 
	//if($values['InvoiceDate']<=$TodayDate){
	$CountCheck++; ?>
    <input type="checkbox" name="posttogl[]" id="posttogl<?=$CountCheck?>" onchange="return ChangePostToGlDate();" class="posttogl" value="<?php echo $values['OrderID']; ?>">
 <input type="hidden" name="InvoiceAmount[]" id="InvoiceAmount<?=$CountCheck?>"  value="<?php echo $values['TotalInvoiceAmount']; ?>" class="textbox" readonly >
<?php /*}else{
		echo $NotPosted;
      }*/

} ?>
 </td>
<? } ?>


 </tr>

    <?php } // foreach end // ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="12" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
                                <?php } ?>

                        <tr>  <td  colspan="12"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySale) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                                }

 

                                ?></td>
                        </tr>
                    </table>

                </div> 


			<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
			<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
			<input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">
			<!--added by nisha forrow color---->
			<input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arrySale) ?>">
            
        </td>
    </tr>
</form>
</table>
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".po").fancybox({
            'width': 900
        });

	$(".fancybig").fancybox({
            'width': 1000
        });

	$(".authcard").fancybox({
		    'width': 500
	});
	$(".voidcard").fancybox({
	    'width': 1000
	});

    });


	

</script>
