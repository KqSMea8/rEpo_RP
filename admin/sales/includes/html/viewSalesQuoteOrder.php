<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        ShowHideLoader('1');
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }

    function filterLead(id)
    {
        location.href = "viewSalesQuoteOrder.php?customview=" + id + "&module=<?= $_GET['module'] ?>&search=Search";
        LoaderSearch();
    }

   function makepdffile(url){
            $.ajax({
            url: url,
        });
    }
    

$(document).ready(function(){

		$(".to-block").hover(
		function() { 
			$(this).find("a").show(300);
		  },
		  function() {
			 // if($(this).attr('class')!='add-edit-email')
				$(this).find("a").hide();
		
		});
                
                
                $(".flag_white").hide();
                $(".flag_red").show();
                $('.evenbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				$(this).find(".flag_white").hide();
                                //$(this).find(".flag_e").css('display','none');
                });
                $('.oddbg').hover(function() { 
			$(this).find(".flag_white").show();
                        //$(this).find(".flag_e").css('display','block');
		  },
		  function() {
			 
				 $(this).find(".flag_white").hide();
                                 //$(this).find(".flag_e").css('display','none');
                });
                
                
                
                 //By chetan 24 DEC//
                $('#highlight select#RowColor').attr('onchange','javascript:showColorRowsbyFilter(this)');
                $('#highlight select#RowColor option').each(function() {
                    $val = $(this).val();
                    $text = $(this).text();
                    $val = $val.replace('#', '');
                    $(this).val($val);
                });
                //End//
             
                
                //End jquery show/hide for Delete, Mark as Read, Mark as Unread buttons
  

		$(".authcard").fancybox({
		    'width': 500
		});
		$(".voidcard").fancybox({
		    'width': 1000
		});


     });

//By chetan 24 DEC//
    
    var showColorRowsbyFilter = function(obj)
    {
        if(obj.value !='')
        {
            $url = window.location.href.split("&rows")[0];
            window.location.href = $url+'&rows='+obj.value;
        }
    }


function paypalrefresh(id){

     $.ajax({
                    type: "POST",
                    url: "../paypalrefresh.php",
                    data: {OrderId:id,module:'<?php echo $_GET['module'];?>'},
                    dataType : "JSON",
                     beforeSend: function() {
                        $('.oid-'+id+' td.action-td').append('<img class="td-loader" src="<?php echo $Config['Url'].'admin/images/';?>loader.gif">');
                     },
                    success: function (responseText)
                     {  
                        console.log(responseText);
                        if(responseText.Status==1 || responseText.Status==2){
                            if(responseText.rowstatus){
                              $('.oid-'+id+' td.col-status').html(responseText.rowstatus);
                            }
                        }
                        if(responseText.paidstatus=='1' || responseText.paidstatus=='2'){

                            $('.oid-'+id+' td.action-td').find('.paypal-refreshaction').remove()
                        }
                      $('.oid-'+id+' td.action-td').find('.td-loader').remove();
                      
        
                           
                    }

                   });

}

     //End//

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
					url: "../processCard.php",
					data: SendUrl,
					dataType : "JSON",
					success: function (responseText)
					 {	
						
						var Msg = '';
						if(responseText["Status"]=="1"){
							Msg = '<div class=greenmsg>'+responseText["MSG"]+'</div>';
							document.getElementById("ccLink"+Line).style.display = 'none';
							
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
					url: "../processCard.php",
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
</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><?
    if (!empty($_SESSION['mess_Sale'])) {
        echo $_SESSION['mess_Sale'];
        unset($_SESSION['mess_Sale']);
    }
    ?></div>
  <form action="" method="post" name="form1">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
        <td align="center" valign="top">

<a class="fancybox" id="processcard_link" href="#processcard_div"  style="display:none">sent</a>
<div id="processcard_div" class="redmsg" style="display:none;padding:15px;width:300px;" align="center" ></div>


</td>
      </tr>

    <tr>
        <td align="right" valign="top">


            <? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_so.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

            <? } ?>



            <a href="<?= $AddUrl ?>" class="add">Add <?= $ModuleName ?></a>

            <? if ($_GET['search'] != '') { ?>
                <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
            <? } ?>


        </td>
    </tr>
<? if ($num > 0 && $ModifyLabel==1) { ?>
            <tr>
                <td align="right" height="40" valign="bottom">


<?
$ToSelect = 'OrderID';
include_once("../includes/FieldArrayRow.php");
echo $RowColorDropDown;
?>
  </td>
    </tr>
<? }?>
    <tr>
        <td  valign="top">


          
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                        <? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?= sizeof($arrySale) ?>');" /></td>-->
                                <td width="10%" class="head1" >Order Date</td>
                                <td width="10%"   class="head1" ><?= $module ?> Number</td>
                                 <td width="8%" class="head1">Order Type</td>
                                <td class="head1">Customer</td>
                                <td width="10%" class="head1">Sales Person</td>
				 <td width="10%"   class="head1" >Posted By</td>
                                <td width="8%" align="center" class="head1" >Amount</td>
                                <td width="5%" align="center" class="head1" >Currency</td>
                                <td width="8%"  align="center" class="head1" >Status</td>
                                <!--td width="8%"  align="center" class="head1" >Approved</td-->
                                <td width="12%"  align="center" class="head1 head1_action" >Action</td>
 <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'OrderID', '<?= sizeof($arrySale) ?>');" /></td>
                            </tr>
                        <? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                                <? } ?>
                                <td width="12%"  align="center" class="head1 head1_action" >Action</td>
<td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'OrderID', '<?= sizeof($arrySale) ?>');" /></td>
                            </tr>
                        <? } ?>
                        <?php

$CardProcess = '<img src="'.$Config['Url'].'admin/images/card.png" border="0"  onMouseover="ddrivetip(\'<center>Authorize Credit Card</center>\', 150,\'\')"; onMouseout="hideddrivetip()"  >';

$VoidCard = '<img src="'.$Config['Url'].'admin/images/cc.png" border="0"  onMouseover="ddrivetip(\'<center>Void Credit Card</center>\', 150,\'\')"; onMouseout="hideddrivetip()"  >';


if($module=="Order"){
	$PdfFolder = $Config['S_Order'];
	$SaleIDCol = 'SaleID';
}else{
	$PdfFolder = $Config['S_Quote'];
	$SaleIDCol = 'QuoteID';
}
 
 



                        if (is_array($arrySale) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $OrderType = '';
                            foreach ($arrySale as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                
                              
                                if($values["OrderType"] != '') $OrderType = $values["OrderType"]; else $OrderType = 'Standard'; 
                                
				$NotifyIcon='';unset($arrStatusMsg);

				$EmailIcon = ($values['MailSend']!=1)?('emailgreen.png'):('emailred.png');
			 	$sendemail = '<img src="' . $Config['Url'] . 'admin/images/'.$EmailIcon.'" border="0"  onMouseover="ddrivetip(\'<center>Send '.$module.'</center>\', 120,\'\')"; onMouseout="hideddrivetip()" >';

/********************/
$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $values[$SaleIDCol], 'ModuleDepName' => 'Sales', 'OrderID' => $values['OrderID'], 'PdfFolder' => $PdfFolder, 'PdfFile' => $values['PdfFile']));
/********************/


$arrVal = explode(',',	$queryCommentKey[0]['commentedIds']);
$available = in_array($values['OrderID'],$arrVal);
if($available > 0){
$comment = '<img src="'.$Config['Url'].'admin/images/comment_red.png" border="0"  class="commenticon" onMouseover="ddrivetip(\'<center>Comments</center>\', 65,\'\')"; onMouseout="hideddrivetip()" >';
}else{
$comment = '<img src="'.$Config['Url'].'admin/images/comment.png" border="0"  class="commenticon" onMouseover="ddrivetip(\'<center>Comments</center>\', 65,\'\')"; onMouseout="hideddrivetip()" >';

}


				
$TransactionExist=0;
$PaymentSO=0;

$TotalInvoice = $QtyInvoiced = $QtyOrdered = $QtyShip =0;	
																			
if($module == "Order") {
	$TotalGenerateInvoice = $objSale->GetQtyInvoicedCheck($values['OrderID']);
	#$ShipOrderInv = $objSale->GetShipOrderStatus($values['SaleID'],'Shipment');
	$TotalInvoice = $objSale->CountInvoices($values['SaleID']);

	$QtyInvoiced = (!empty($TotalGenerateInvoice[0]['QtyInvoiced']))?($TotalGenerateInvoice[0]['QtyInvoiced']):('');
	$QtyOrdered = (!empty($TotalGenerateInvoice[0]['Qty']))?($TotalGenerateInvoice[0]['Qty']):('');
	$QtyShip = (!empty($TotalGenerateInvoice[0]['QtyShip']))?($TotalGenerateInvoice[0]['QtyShip']):('');
	 

	if($values['PaymentTerm'] == 'Credit Card'){
		$TransactionExist = $objSale->isSalesTransactionExist($values['OrderID'],'Credit Card');
		if($TransactionExist==1){
			$TotalCharge = $objCard->GetTransactionTotal($values['OrderID'],'Charge',$values['PaymentTerm']);
			$TotalRefund = $objCard->GetTransactionTotal($values['OrderID'],'Void',$values['PaymentTerm']);
			$PaymentSO = $TotalCharge - $TotalRefund;
		}
		if(!empty($values['StatusMsg'])){
			$arrStatusMsg = explode("#",$values['StatusMsg']);
			$NotifyIcon = ($arrStatusMsg[0]==1)?('notify.png'):('fail.png');
		 	$NotifyIcon = '<img src="' . $Config['Url'] . 'admin/images/'.$NotifyIcon.'" border="0"  onMouseover="ddrivetip(\'<center>'.stripslashes($arrStatusMsg[1]).'</center>\', 300,\'\')"; onMouseout="hideddrivetip()" >';
		}
	}


if($values['PickID']=='' && empty($values['DropShipCheck']) && $QtyInvoiced <= 0 && $values['batchId']==0){
$TotalOnHanQty= $objSale->StockItemOnHand($values['OrderID']);
$TotalOrderQty= $objSale->SalesOrderQty($values['OrderID']);
//echo $TotalOrderQty." =".$TotalOnHanQty;
if($TotalOrderQty>$TotalOnHanQty){

$stockStatus =  '<br><a class="InActive" style="text-decoration:none;" >Partial Stock</a>&nbsp&nbsp';

}else{

$stockStatus = '<br><a class="Active" style="text-decoration:none;" >In Stock</a>&nbsp&nbsp';
}
/*if(!empty($values['PickStatus']) && $values['PickStatus']!=''){
			if($values['PickStatus'] == "Completed"){
			$stockStatus =  "Completed";
			}else {

			
$PickStatus = "<br><br><a class='Active' style='background-color:#0071ad !important;text-decoration:none;'> In Picking</a>&nbsp&nbsp";
}
}else{

$PickStatus =  "<br><br><a class='Active' style='text-decoration:none;'>Picking</a>&nbsp&nbsp";

}*/

$PickStatus = '';
} else{

$stockStatus = '';
}
}


$Cancelecon ='';

if($values['CanReqest']==1){
$Cancelecon= $Cancellation;

}
if(!empty($values["EDICompId"])){
$ediiconmain =$ediicon;
$values["CustomerName"]=$values["CustomerCompany"];
}else{
$ediiconmain='';
}
?>
                                
                              
                                <tr align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?> class="oid-<?php echo $values['OrderID'];?>">


                                    <? if ($_GET["customview"] == 'All') { ?>   
                                                <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?= $Line ?>" value="<?= $values['OrderID'] ?>" /></td>-->
                                        <td height="20">
                                            <?


 

                                            if ($values['OrderDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['OrderDate']));
                                            ?>

                                        </td>
                                        <td><?= $values[$ModuleID] ?> <?=$stockStatus?><?=$PickStatus?></td>
                                        <td><?=$OrderType?></td>
                                        <td><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?= $values['CustCode'] ?>" ><?= stripslashes($values["CustomerName"]) ?></a><?=$ediiconmain?>
<?=$Cancelecon?>




                                        </td> 
                                        
                                        
                                        <!--modified by nisha on 24 sept 2018--> 
                                        <td> <? $salesPersoToDisplay ="";
                                        if((!empty($values['SalesPersonID'])) || (!empty($values['VendorSalesPerson']))) {
                                            $salesPersoToDisplay  = $objConfig->createSalesPersonLink($values['SalesPersonID'],$values['VendorSalesPerson']);
                                             }
                                         echo $salesPersoToDisplay;
                                                ?>
</td>
                                       <!-- <td> 

<? if($values['SalesPersonType']=='1') { ?><a class="fancybox fancybox.iframe" href="../vendorInfo.php?SuppID=<?= $values['SalesPersonID'] ?>" ><?= $values['SalesPerson'] ?></a> <? } else { ?><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['SalesPersonID'] ?>" ><?= $values['SalesPerson'] ?></a><? } ?>
</td>-->


<td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>


                                        <td align="center"><?= $values['TotalAmount'] ?></td>
                                        <td align="center"><?= $values['CustomerCurrency'] ?></td>
                                        <td align="center" class="col-status">
<? 
$OrderStatus = $objSale->GetOrderStatusMsg($values['Status'],$values['Approved'],$values['PaymentTerm'],$values['OrderPaid']);
echo $OrderStatus;
$OrderSt = strip_tags($OrderStatus);
?>
                                               
                                        </td>

                                    <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';

                                            if ($cusValue['colvalue'] == 'CustomerName') {
                                                echo '<a class="fancybox fancybox.iframe" href="../custInfo.php?view=' . $values['CustCode'] . '" >' . stripslashes($values["CustomerName"]) . '</a>';
                                            } elseif ($cusValue['colvalue'] == 'SalesPerson') {
                                                echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';
                                            } elseif ($cusValue['colvalue'] == 'Status') {
                                                #echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';

						

					$OrderStatus = $objSale->GetOrderStatusMsg($values[$cusValue['colvalue']],$values['Approved'],$values['PaymentTerm'],$values['OrderPaid']);
					echo $OrderStatus;
                                        $OrderSt = strip_tags($OrderStatus);     		   


                                            } elseif ($cusValue['colvalue'] == 'OrderDate' || $cusValue['colvalue'] == 'DeliveryDate') {
                                                if ($values[$cusValue['colvalue']] > 0)

																							
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                            } elseif ($cusValue['colvalue'] == 'EntryType') {
                                                if ($values[$cusValue['colvalue']] == 'one_time') {

                                                    $Entry = explode('_', $values[$cusValue['colvalue']]);

                                                    $EntryType = ucfirst($Entry[0] ). " " . ucfirst($Entry[1]);
                                                    ?>
                                                    <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($EntryType)) : (NOT_SPECIFIED) ?>

                                                <? } else { ?>

                                                    <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes(ucfirst($values[$cusValue['colvalue']]))) : (NOT_SPECIFIED) ?>

                                                <? }
                                            } else { ?>

                                                <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                            <?
                                            }

                                            echo '</td>';
                                        }
                                    }
                                    ?>
                                    <td  align="center" class="head1_inner action-td">


 <?=$NotifyIcon?>

                                        <a href="<?= $ViewUrl . '&view=' . $values['OrderID'] ?>" ><?= $view ?></a>
                                        
                                      




<?php

 

if ($QtyInvoiced <= 0 ) { ?>

	 <? //if($values['batchId']==0 || $values['PickID']==''){
if($values['PickID']==''){?>
	<a href="<?= $EditUrl . '&edit=' . $values['OrderID'] ?>" ><?=$edit?></a>
	 


    	<? if($PaymentSO<=0){?>
    	<a href="<?= $EditUrl . '&del_id=' . $values['OrderID'] ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"><?= $delete ?></a> 
	<?} } ?>

<?php } ?>








                                      <a href="<?=$PdfResArray['DownloadUrl']?>" ><?=$download?></a>

                                        <a <?=$PdfResArray['MakePdfLink']?> class="fancybox fancybox.iframe" href="<?=$SendUrl.'&view='.$values['OrderID']?>" ><?=$sendemail?></a>
<?php if($values['SaleID']==''){ $so ='&sq='.$values['QuoteID']; }else{ $so ='&so='.$values['SaleID'];} ?>
<a class="fancybox com fancybox.iframe"  href="../erpComment.php?view=<?php echo $values['OrderID']; ?>&module=<?php echo $_GET['module']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=Comments&popLead=1<?=$so?>" ><?=$comment?></a>
<?php 
 

	echo '<ul class="print_menu" style="width:60px;"><li class="print" ><a target="_blank" class="edit" href="'.$PdfResArray['PrintUrl'].'" >&nbsp;</a></li></ul>';
	//'pdfCommonhtml.php?o=9977&module=Order&editpdftemp=1&tempid=&ModuleDepName=Sales'
	?>
                                        <?
                                        if($module == "Order") {


                                            if ($TotalInvoice > 0 && $Config['batchmgmt']!=1)
                                                echo '<br><a href="../finance/viewInvoice.php?so=' . $values['SaleID'] . '" target="_blank">' . $TotalInvoice . '&nbsp;Invoices</a>';
                                           // if ($values['Status'] == 'Open' && $values['Approved'] == 1 && $QtyInvoiced != $QtyOrdered && $OrderType == 'Standard' && empty($ShipOrderInv)){
 

if ($values['Status'] == 'Open' && $values['Approved'] == 1 &&  $QtyInvoiced != $QtyOrdered  && ($OrderType == 'Standard' || $OrderType == 'PO')  && $QtyShip != $QtyOrdered && $OrderSt != 'Credit Hold' ){

if($Config['batchmgmt']!=1 && $Config['TrackInventory']!=1){
                                                echo '<br><a href="../finance/generateInvoice.php?so=' . $values['SaleID'] . '&invoice=' . $values['OrderID'] . '" target="_blank">' . GENERATE_INVOICE . '</a>';
}else{

if($values['batchId']==0){

if(!empty($values['DropShipCheck']) ){
 echo '<br><a class="fancybox fancybox.iframe" href="batchinvoice.php?so=' . $values['SaleID'] . '&edit=' . $values['OrderID'] . '" >Ship</a>';
}else{
if($values['PickID']=='' && empty($values['PickID'])){
echo '<br><a  href="../warehouse/editPicking.php?SaleID=' . $values['SaleID'] . '&edit=' . $values['OrderID'] . '" target="_blank" >Pick</a>';
}
}

}


}

} 
			

if($ModifyLabel==1 && $QtyInvoiced <= 0 && $values['Status'] == 'Open' && $values['Approved'] == 1 &&   $values['PaymentTerm']=='Credit Card' && $values['RecurringOption'] != "Yes") {

	/*if($values['OrderPaid'] == "1" || $values['OrderPaid'] == "3"){
		echo '<a href="Javascript:void(0)" id="vvLink'.$Line.'" onclick="return VoidCreditCard(\''.$values['OrderID'].'\',\''.$Line.'\')" >'.$VoidCard.'</a>';
	}else{
		echo '<a href="Javascript:void(0)" id="ccLink'.$Line.'" onclick="return ProcessCreditCard(\''.$values['OrderID'].'\',\''.$Line.'\')" >'.$CardProcess.'</a>';
	}*/

	 //Partial
	if($values['OrderPaid'] == "1"){
		echo '<a href="paySO.php?OrderID='.$values['OrderID'].'&Action=VCard"  class="fancybox voidcard fancybox.iframe" >'.$VoidCard.'</a>';
	}else{
		echo '<a href="paySO.php?OrderID='.$values['OrderID'].'&Action=PCard"  class="fancybox authcard fancybox.iframe" >'.$CardProcess.'</a>';
	}	
	

}


   
        
        if($values['PaymentTerm']=='PayPal' && !in_array($values['OrderPaid'],array(1,2)) ){

           echo  '<a class="paypal-refreshaction" href="javascript:void(0)" onclick="paypalrefresh(\''.$values['OrderID'].'\')" ><img width="20" src="'.$Config['Url'].'admin/images/paypalrefresh.png" border="0"  onMouseover="ddrivetip(\'<center>Paypal Refresh</center>\', 60,\'\')"; onMouseout="hideddrivetip()" ></a>';
        }
       // pr($values['PaymentTerm']=='PayPal');
    


                                        }
                                        ?>


                                    </td>
<? if($ModifyLabel==1){ ?>
 <td ><input type="checkbox" name="OrderID[]" id="OrderID<?= $Line ?>" value="<?= $values['OrderID'] ?>" /></td>
<?}?>
                                </tr>
                            <?php } // foreach end // ?>

<?php }else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
<?php } ?>

                        <tr>  <td  colspan="11"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySale) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 



                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arrySale) ?>">
                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            
        </td>
    </tr>
</table>
</form>
