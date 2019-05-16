<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        ShowHideLoader('1');
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }

    function filterLead(id)
    {
        location.href = "viewPicking.php?customview=" + id + "&search=Search";
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
     //End//
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
        <td align="right" valign="top">


            <? if (!empty($num55 )) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_Pick.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

            <? } ?>



           <!-- <a href="<?= $AddUrl ?>" class="add">Add <?= $ModuleName ?></a>-->

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
                                <td width="8%"   class="head1" >Pick Number</td>                              
                                <td class="head1" width="18%" >Customer</td>                              
                                <td width="8%" align="center" class="head1" >Amount</td>                              
                                <td width="8%"  align="center" class="head1" >Order Status</td>
                                <td width="8%"  align="center" class="head1" >Picking Status</td>
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

$arrVal = explode(',',	$queryCommentKey[0]['commentedIds']);
$available = in_array($values['OrderID'],$arrVal);
if($available > 0){
$comment = '<img src="'.$Config['Url'].'admin/images/comment_red.png" border="0"  class="commenticon" onMouseover="ddrivetip(\'<center>Comments</center>\', 65,\'\')"; onMouseout="hideddrivetip()" >';
}else{
$comment = '<img src="'.$Config['Url'].'admin/images/comment.png" border="0"  class="commenticon" onMouseover="ddrivetip(\'<center>Comments</center>\', 65,\'\')"; onMouseout="hideddrivetip()" >';

}
																				
if($module == "Order") {
	$TotalGenerateInvoice = $objSale->GetQtyInvoicedCheck($values['OrderID']);
	$ShipOrderInv = $objSale->GetShipOrderStatus($values['SaleID'],'Shipment');
	$TotalInvoice = $objSale->CountInvoices($values['SaleID']);

	
}


/********************/
$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $values['SaleID'], 'ModuleDepName' => 'Sales', 'OrderID' => $values['OrderID'], 'PdfFolder' => $Config['S_Order'], 'PdfFile' => $values['PdfFile']));
/********************/

?>
                                
                              
                                <tr align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>>


                                    <? if ($_GET["customview"] == 'All') { ?>   
                                                <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?= $Line ?>" value="<?= $values['OrderID'] ?>" /></td>-->
                                        <td height="20">
                                            <?
                                            if ($values['OrderDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['OrderDate']));
                                            ?>

                                        </td>
                                        <td><?= $values[$ModuleID] ?></td>
<td><?= $values['PickID'] ?></td>
                                       
                                        <td><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?= $values['CustCode'] ?>" ><?= stripslashes($values["CustomerName"]) ?></a></td> 
                                       


                                        <td align="center"><?= $values['TotalAmount'] ?></td>
                                       
                                        <td align="center">
<? 
//echo $values['Status'] ."=>".$values['Approved']."=>".$values['PaymentTerm']."=>".$values['OrderPaid'];
$OrderStatus = $objSale->GetOrderStatusMsg($values['Status'],$values['Approved'],$values['PaymentTerm'],$values['OrderPaid']);
echo $OrderStatus;
$OrderSt = strip_tags($OrderStatus);
?>
                                               
                                        </td>
 <td align="center">
<? 
//$OrderStatus = $objSale->GetOrderStatusMsg($values['Status'],$values['Approved'],$values['PaymentTerm'],$values['OrderPaid']);
//if ($TotalGenerateInvoice[0]['QtyInvoiced'] == $TotalGenerateInvoice[0]['Qty']  && $TotalGenerateInvoice[0]['QtyShip'] == $TotalGenerateInvoice[0]['Qty']  ){

if(!empty($values['PickStatus']) && $values['PickStatus']!=''){
			if($values['PickStatus'] == "Completed"){
			echo "Completed";
			}else {

			
echo "<a class='Active' style='background-color:#0071ad !important;text-decoration:none;'> In Picking</a>";
}
}else{

echo "<a class='Active' style='text-decoration:none;'>Picking</a>";

}
//echo $values['Status'];
//$OrderSt = strip_tags($OrderStatus);
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
                                    <td  align="center" class="head1_inner">


 <?=$NotifyIcon?>

                                        <a href="<?= $ViewUrl . '&view=' . $values['OrderID'] ?>" ><?= $view ?></a>
                                        
                                      




<?php

/*

if ($TotalGenerateInvoice[0]['QtyInvoiced'] <= 0 ) { ?>

	 <? if($values['batchId']==0){?>
	<a href="<?= $EditUrl . '&edit=' . $values['OrderID'] ?>" ><?=$edit?></a>
	 


    	<? if($PaymentSO<=0){?>
    <!--	<a href="<?= $EditUrl . '&del_id=' . $values['OrderID'] ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"><?= $delete ?></a> -->
	<?} } ?>

<?php } */?>


<? if($values['PickStatus'] != "Completed" && $values['PickStatus'] == "In Picking"){?>
<a href="<?= $EditUrl . '&edit=' . $values['OrderID'] ?>" ><?=$edit?></a>
<? }?>

<? if($values['PickID'] != ""){?>
    <a href="<?= $EditUrl . '&del_id=' . $values['OrderID'] ?>" onclick="return confirmDialog(this, 'Picking')"><?= $delete ?></a>
	<?} ?>


                                   <a href="<?=$PdfResArray['DownloadUrl']?>" ><?=$download?></a>

                                     
<?php if($values['SaleID']==''){ $so ='&sq='.$values['QuoteID']; }else{ $so ='&so='.$values['SaleID'];} ?>

<a class="fancybox com fancybox.iframe"  href="../erpComment.php?view=<?php echo $values['OrderID']; ?>&module=<?php echo $_GET['module']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=Comments&popLead=1<?=$so?>" ><?=$comment?></a>

                                        <?
                                       


                                          

if ($values['Status'] == 'Open' && $values['Approved'] == 1 &&  $TotalGenerateInvoice[0]['QtyInvoiced'] != $TotalGenerateInvoice[0]['Qty']  && ($OrderType == 'Standard' || $OrderType == 'PO') && $TotalGenerateInvoice[0]['QtyShip'] != $TotalGenerateInvoice[0]['Qty'] && $OrderSt != 'Credit Hold' && (empty($values['PickStatus']) && $values['PickStatus']=='') ){


 echo '<br><a target="_blank" href="editPicking.php?so=' . $values['SaleID'] . '&edit=' . $values['OrderID'] . '" > Pick</a>';


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
