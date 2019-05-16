<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
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
		 ShowHideLoader('1','P');
                return true;
            }

        });
    })

function filterLead(id)
    {
        location.href = "viewVendorInvoiceEntry.php?customview=" + id;
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

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><?php
        if (!empty($_SESSION['mess_Sale'])) {
            echo $_SESSION['mess_Sale'];
            unset($_SESSION['mess_Sale']);
        }
        ?><? if(!empty($_SESSION['mess_invoice'])) {echo $_SESSION['mess_invoice']; unset($_SESSION['mess_invoice']); }?></div>



<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<form action="" method="post" name="form1">
	<tr>
        <td align="right" valign="bottom">
 <a  class="add" href="editVendorInvoiceEntry.php">Invoice Entry</a>  

	
		   <? if($num>0){?>

 

<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_po_invoice_entry.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
	

		 <? if($_GET['search']!='') {?>
	  	<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
 <? if($num > 0 && $ModifyLabel==1){ ?>  
<tr>
	  <td  valign="top" align="right">
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

<? }?>

	<tr>
	  <td  valign="top">
	


<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   <? if ($_GET["customview"] == 'All') { ?>
    <tr align="left"  >
    
		<td width="10%" class="head1" >Invoice Date</td>
		<td width="12%" class="head1" >GL Posting Date</td>
		<td width="10%"  class="head1" >Invoice #</td>
		<!--<td width="10%"  class="head1" >PO/Reference #</td>
		<td width="10%" class="head1" >Order Date</td>-->
		<td class="head1" >Vendor</td>
		 <td width="12%"   class="head1" >Posted By</td>
		<td width="8%" align="center" class="head1" >Amount</td>
		<td width="8%" align="center" class="head1" >Currency</td>
		<td width="6%"  align="center" class="head1" >Status</td>
               <td width="12%"  align="center" class="head1 head1_action" >Action</td>
		<? if($ModifyLabel==1){ ?> <td width="1%" align="center" class="head1">
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td>
		<? } ?>
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
 $adjustment = '<img src="' . $Config['Url'] . 'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>Adjustment History</center>\', 110,\'\')"; onMouseout="hideddrivetip()" >';
 $history = '<img src="' . $Config['Url'] . 'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>Payment History</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';

$NotPosted = '<img src="' . $Config['Url'] . 'admin/images/error-icon.png"  border="0"  onMouseover="ddrivetip(\'<center>'.NOT_POSTED_TOGL.'</center>\', 125,\'\')"; onMouseout="hideddrivetip()" >';

#$NotPostedAmount = '<img src="' . $Config['Url'] . 'admin/images/error-icon.png"  border="0"  onMouseover="ddrivetip(\'<center>'.NOT_POSTED_TOGL_AMOUNT.'</center>\', 230,\'\')"; onMouseout="hideddrivetip()" >';


$arryTime = explode(" ",$Config['TodayDate']);
$TodayDate = $arryTime[0];

  if(is_array($arryInvoice) && $num>0){
  	$flag=true;
	$Line=0;
	$CountCheck=0;
  	foreach($arryInvoice as $key=>$values){
	$flag=!$flag;
	$Line++;
        
	/*$TotalGlLineAmount='0';
	if($values['ExpenseID']>0 && $values['PostToGL'] != "1" && $values['GlEntryType']=="Multiple"){
		$TotalGlLineAmount = $objBankAccount->getInvoiceMultiTotal($values['ExpenseID']);
		
	}*/


        if(empty($values["SuppCompany"])){ 
            $SupplierName = $objBankAccount->getSupplierName($values['SuppCode']);
        }else{
            $SupplierName = $values["SuppCompany"];
        }
	
	if($values['PostToGL'] == "1" && $separator!=1 && $CountCheck>0) {
		echo '<tr align="center"><td colspan="11" class="selectedbg">&nbsp;</td></tr>';
		$separator=1;
	}
  ?>

    <tr align="left">
         <? if ($_GET["customview"] == 'All') { ?>   
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">

	   <? 



if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
<td>
            <?
            if ($values['PostToGLDate'] > 0)
                echo date($Config['DateFormat'], strtotime($values['PostToGLDate']));
            ?>

        </td>
       <td><?=$values["InvoiceID"]?></td>
      
      <td> <a class="fancybox supp fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($SupplierName)?></a> </td> 

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
	if($values['TotalAmount']>0){
		 if($values['InvoicePaid'] ==1){
			  $Paid = 'Paid';  $PaidCls = 'green';
		 }elseif($values['InvoicePaid'] == 2){
			  $Paid = 'Partially Paid';  $PaidCls = 'red';
		 }else{
			  $Paid = 'Unpaid';  $PaidCls = 'red';
		 }

		echo '<span class="'.$PaidCls.'">'.$Paid.'</span>';
	}
		
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
                                                    <a href="vPoInvoice.php?pop=1&amp;view=<?=$values['OrderID']?>&IE=<?=$values['InvoiceEntry'];?>" class="fancybox po fancybox.iframe"><?=$values['PurchaseID']?></a>
                                                    <?php } else if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){?>
                                                    <a href="vOtherExpense.php?pop=1&amp;Flag=<?=$Flag;?>&amp;view=<?=$values['ExpenseID']?>" class="fancybox po fancybox.iframe">
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

 
<?php if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){?>
<a href="vOtherExpense.php?view=<?=$values['ExpenseID']?>&IE=2"><?=$view?></a>
<a href="vOtherExpense.php?view=<?=$values['ExpenseID']?>&pop=1&pay=1" class="fancybox po fancybox.iframe"><?=$history?></a>
<?php }else{?>
	<a href="vPoInvoice.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>&IE=1"><?=$view?></a>
<a href="payInvoiceHistory.php?view=<?=$values['OrderID']?>&inv=<?=$values['InvoiceID']?>&pop=1" class="fancybox po fancybox.iframe"><?=$history?></a>
<?php }?>
         
 

<? if($values['InvoicePaid'] != 1 && $values['InvoicePaid'] != 2 && $values['PostToGL'] != "1") { ?> 

	<?php if($values['InvoiceEntry']>0){?>
	<a href="editVendorInvoiceEntry.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>
	<?php } else {?>
	<a href="editPoInvoice.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&po=<?=$_GET['po']?>"><?=$edit?></a>
	<?php }?>
    
    <a href="editVendorInvoiceEntry.php?del_id=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&exp=<?=$values['ExpenseID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 


<?php }?>




    <?php 

if($values['InvoiceEntry'] != 2 && $values['InvoiceEntry'] != 3){?>
<!--    <a href="pdfPoInvoice.php?o=<?=$values['OrderID']?>&module=<?=$module?>" ><?=$download?></a>-->
    <a href="../pdfCommonhtml.php?o=<?= $values['OrderID'] ?>&module=<?= $module ?>&ModuleDepName=PurchaseInvoice" ><?= $download ?></a>
    <?php }?>




	</td>

<? if($ModifyLabel==1){ ?>
 <td align="center">
<?
if($values['PostToGL'] != "1") { 
	
	/*if($TotalGlLineAmount>0 && $TotalGlLineAmount!=$values['TotalAmount']){
		echo $NotPostedAmount;		
	}else */
	//if($values['PostedDate']<=$TodayDate){
	$CountCheck++; ?>
    <input type="checkbox" name="posttogl[]" id="posttogl<?=$CountCheck?>" onchange="return ChangePostToGlDate();" class="posttogl" value="<?php echo $values['OrderID']; ?>"  	>
<?
	/*}else{
		echo $NotPosted;
      	}*/

 } ?>
 </td>
<? } ?>


    </tr>







<? 
//adjustment list
$numAdjustment=0;
$arryAdjustment = $objBankAccount->GetAdjustment($values['InvoiceID']);
$numAdjustment = $objBankAccount->numRows(); 
if($numAdjustment>0){
	foreach($arryAdjustment as $keyadj=>$valuesadj){
		$SuppCompany=(!empty($valuesadj['CompanyName']))?($valuesadj['CompanyName']):($valuesadj['SuppCompany']); 
?>
 <tr>
	<td></td>
	<td>
            <?
            if ($valuesadj['PostToGLDate'] > 0)
                echo date($Config['DateFormat'], strtotime($valuesadj['PostToGLDate']));
            ?>

        </td>
	<td>Adjustment #<?=$values['InvoiceID']?></td>
	<td><? 
       echo '<a class="fancybox supp fancybox.iframe" href="suppInfo.php?view='.$valuesadj['PaidTo'].'">'.stripslashes($SuppCompany).'</a>';  
	?></td>
	<td align="center"> <?=number_format($valuesadj['AdjustmentAmount'],2)?> </td>
	<td align="center"><?=$valuesadj['Currency']?></td>
	<td></td>
	  <td  align="center" class="head1_inner">
	
	 <a href="adjustmentHistory.php?inv=<?=$values['InvoiceID']?>" target="_blank"><?=$adjustment?></a>	
	<? //if($valuesadj['PostToGL'] == "No") { ?>
	<a href="editVendorInvoiceEntry.php?del_adj=<?=$valuesadj['AdjID']?>&curP=<?=$_GET['curP']?>" onclick="return confirmDialog(this, 'Adjustment')"><?=$delete?></a> 
	<? //} ?>
	 </td>
	 <td align="center">
	<? //if($valuesadj['PostToGL'] == "No") { 
		$CountCheck++; ?>
	    <input  type="checkbox" name="posttogl[]" id="posttogl<?=$CountCheck?>" onchange="return ChangePostToGlDate();" class="posttogl" value="<?='AdjID#'.$valuesadj['AdjID']?>">
	<? //} ?>
	 </td>
 </tr>
<? }} ?>





    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="11" class="no_record"><?=NO_INVOICE?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="11"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryInvoice)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
  <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">

</td>
	</tr>
</form>

</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
	$(".po").fancybox({
		'width'  : 900
	 });


});

</script>


<? } ?>

