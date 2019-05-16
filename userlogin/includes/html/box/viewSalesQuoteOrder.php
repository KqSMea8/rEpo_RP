<?php 

$_GET['module'] = 'Order';
$_GET["customview"]='All';
$ModuleID = "SaleID";
$module=$_GET['module'];

if(!empty($arryCustomer[0]['Cid'])){
	$CustomerID=$arryCustomer[0]['Cid'];
}	

$AddUrl = "editSalesQuoteOrder.php?module=".$_GET['module'];
$ViewSalesUrl = "vSalesQuoteOrder.php?module=".$_GET['module']."&curP=".$_GET['curP'];

$RedirectURL = 'dashboard.php?curP=1&tab=salesorder';
 $num=0;
if(!empty($CustomerID)){
	$arrySale=$objSale->ListSale($_GET,$CustomerID);
	$num=$objSale->numRows();

	$pagerLink=$objPager->getPager($arrySale,$RecordsPerPage,$_GET['curP']);
	(count($arrySale)>0)?($arrySale=$objPager->getPageRecords()):("");
}
?>
<script language="JavaScript1.2" type="text/javascript">
function ShowDateField(){	
	 if(document.getElementById("fby").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else if(document.getElementById("fby").value=='Month'){
	    document.getElementById("monthDiv").style.display = 'block';
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else{
	   document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("yearDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'block';
		document.getElementById("toDiv").style.display = 'block';	
	 }
}
function ValidateSearch(frm){	
	
	if(document.getElementById("fby").value=='Year'){
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else if(document.getElementById("fby").value=='Month'){
		if(!ValidateForSelect(frm.m, "Month")){
			return false;	
		}
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else{
		if(!ValidateForSelect(frm.f, "From Date")){
			return false;	
		}
		if(!ValidateForSelect(frm.t, "To Date")){
			return false;	
		}

		if(frm.f.value>frm.t.value){
			alert("From Date should not be greater than To Date.");
			return false;	
		}

	}

	ShowHideLoader(1,'F');
	return true;	



	
}

    function filterLead(id)
    {
        location.href = "viewSalesQuoteOrder.php?customview=" + id + "&module=<?= $_GET['module'] ?>&search=Search";
        LoaderSearch();
    }
</script>

 
<div class="message" align="center"><?
    if (!empty($_SESSION['mess_Sale'])) {
        echo $_SESSION['mess_Sale'];
        unset($_SESSION['mess_Sale']);
    }
    ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td align="right" valign="top">
            <? if ($num > 0) { ?>
                <!--<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_so.php?<?= $QueryString ?>';" />
                --><input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

            <? } ?>



            <a href="<?= $AddUrl ?>" class="add">Add Order</a>

            <? if ($_GET['search'] != '') { ?>
                <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
            <? } ?>


        </td>
    </tr>
	<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>

		<td valign="bottom">
		  Filter By :<br> 
		  <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateField();">
					 <option value="Date" <?  if($_GET['fby']=='Date'){echo "selected";}?>>Date Range</option>
					 <option value="Year" <?  if($_GET['fby']=='Year'){echo "selected";}?>>Year</option>
					 <option value="Month" <?  if($_GET['fby']=='Month'){echo "selected";}?>>Month</option>
		</select> 
		</td>
	   <td>&nbsp;</td>


		 <td valign="bottom">
		 <? if($_GET['f']>0) $FromDate = $_GET['f'];  ?>				
		<script type="text/javascript">
		$(function() {
			$('#f').datepicker(
				{
				showOn: "both",dateFormat: 'yy-mm-dd', 
				yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
				maxDate: "+0D", 
				changeMonth: true,
				changeYear: true

				}
			);
		});
		</script>
<div id="fromDiv" style="display:none">
From Date :<br> <input id="f" name="f" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" placeholder="From Date" > 
</div>

	</td> 

	 

		 <td valign="bottom">

		 <? if($_GET['t']>0) $ToDate = $_GET['t'];  ?>				
<script type="text/javascript">
$(function() {
	$('#t').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
		maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<div id="toDiv" style="display:none">
To Date :<br> <input id="t" name="t" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" placeholder="To Date">
</div>

<div id="monthDiv" style="display:none">
Month :<br>
<?=getMonths($_GET['m'],"m","textbox")?>
</div>





</td> 
  <td><div id="yearDiv" style="display:none">
Year :<br>
<?=getYears($_GET['y'],"y","textbox")?>
</div></td>

	  <td align="right" valign="bottom">  

 <input name="view" type="hidden" value="<?=$_GET['view']?>"  />
 <input name="tab" type="hidden" value="<?=$_GET['tab']?>"  />
 <input name="search" type="submit" class="search_button" value="Go"  />	  
	  <script>
	  ShowDateField();
	  </script>
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>
    <tr>
        <td  valign="top">


            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                        <? if ($_GET["customview"] == 'All') { ?>
                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','');" /></td>-->
                                <td width="13%" class="head1" >Order Date</td>
                                <td width="12%"  align="center" class="head1" ><?= $module ?> Number</td>
                                 <td class="head1">Order Type</td>
                                <td class="head1">Customer Name</td>
                                <td class="head1">Sales Person</td>
                                <td width="8%" align="center" class="head1" >Amount</td>
                                <td width="8%" align="center" class="head1" >Currency</td>
                                <td width="12%"  align="center" class="head1" >Status</td>
                                <!--td width="8%"  align="center" class="head1" >Approved</td-->
                                <td width="12%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>
                        <? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                                <? } ?>
                                <td width="12%"  align="center" class="head1 head1_action" >Action</td>

                            </tr>
                        <? } ?>
                        <?php
$pdf = '<img src="'.$Config['Url'].'admin/images/pdf.gif" border="0"  onMouseover="ddrivetip(\'<center>Download PDF</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';
                        if (!empty($arrySale) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $OrderType = '';
                            foreach ($arrySale as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                
                                
                                if($values["OrderType"] != '') $OrderType = $values["OrderType"]; else $OrderType = 'Standard'; 
                                
                                
                                
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">

                                    <? if ($_GET["customview"] == 'All') { ?>   
                                                <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?= $Line ?>" value="<?= $values['OrderID'] ?>" /></td>-->
                                        <td height="20">
                                            <?
                                            if ($values['OrderDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['OrderDate']));
                                            ?>

                                        </td>
                                        <td align="center"><?= $values[$ModuleID] ?></td>
                                        <td><?=$OrderType?></td>
                                        <td><?= stripslashes($values["CustomerName"]) ?></td> 
                                        <td><?= $values['SalesPerson'] ?></td>
                                        <td align="center"><?= $values['TotalAmount'] ?></td>
                                        <td align="center"><?= $values['CustomerCurrency'] ?></td>
                                        <td align="center">
                                            <?
                                             $OrderStatus = $objSale->GetOrderStatusMsg($values['Status'],$values['Approved'],$values['PaymentTerm'],$values['OrderPaid']);
echo $OrderStatus;
                                            ?>
                                               
                                        </td>


                                        <!--td align="center"><?
                                        if ($values['Approved'] == 1) {
                                            $Approved = 'Yes';
                                            $ApprovedCls = 'green';
                                        } else {
                                            $Approved = 'No';
                                            $ApprovedCls = 'red';
                                        }

                                        echo '<span class="' . $ApprovedCls . '">' . $Approved . '</span>';
                                        ?></td-->


                                    <?
                                    } 

                                    ?>
                                   <td  align="center" class="head1_inner">

       

<?
 $PdfResArray = GetPdfLinks(array('Module' => 'Order',  'ModuleID' => $values['SaleID'], 'ModuleDepName' => 'Sales', 'OrderID' => $values['OrderID'], 'PdfFolder' => $Config['S_Order'], 'PdfFile' => $values['PdfFile']));
 
 
 $DownloadUrl = str_replace("../pdfCommonhtml.php","../admin/pdfCommonhtml.php", $PdfResArray['PrintUrl']);
?>                               

<a href="../admin/sales/vSalesQuoteOrder.php?module=Order&pop=1&view=<?=$values['OrderID']?>" class="fancybox fancybig fancybox.iframe"><?= $view ?></a>

                                         
<a href="<?=$DownloadUrl?>" target="_blank"><?=$pdf?></a>


                                        <!-- <a href="<?= $EditUrl . '&edit=' . $values['OrderID'] ?>" ><?= $edit ?></a>
                                        <?php
                                       /* $TotalGenerateInvoice = $objSale->GetQtyInvoiced($values['OrderID']);
                                        if ($module == "Order") {
                                            $TotalInvoice = $objSale->CountInvoices($values['SaleID']);
                                        }*/
                                        ?>
                                        <?php if (empty($TotalInvoice)) { ?>
                                            <a href="<?= $EditUrl . '&del_id=' . $values['OrderID'] ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"><?= $delete ?></a> 
        <?php } ?>

                                       

                                        <br><a class="fancybox fancybox.iframe" href="<?= $SendUrl . '&view=' . $values['OrderID'] ?>" >Send <?= $module ?></a>

                                        <?
					/*
                                        if ($module == "Order") {


                                            if ($TotalInvoice > 0)
                                                echo '<br><a href="../finance/viewInvoice.php?so=' . $values['SaleID'] . '" target="_blank">' . $TotalInvoice . ' Invoices</a>';
                                            if ($values['Status'] == 'Open' && $values['Approved'] == 1 && $TotalGenerateInvoice[0]['QtyInvoiced'] != $TotalGenerateInvoice[0]['Qty'] && $OrderType == 'Standard')
                                                echo '<br><a href="../finance/generateInvoice.php?so=' . $values['SaleID'] . '&invoice=' . $values['OrderID'] . '" target="_blank">' . GENERATE_INVOICE . '</a>';
                                        }*/
                                        ?>
										 -->
                                    </td></tr>
                            <?php } // foreach end // ?>

<?php }else { ?>
                            <tr align="center" >
                                <td  colspan="10" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
<?php } ?>

                        <tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySale) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 


                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>

