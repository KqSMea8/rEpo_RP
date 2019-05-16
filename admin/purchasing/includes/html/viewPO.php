<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}

 
 function filterLead(id)
    {
        location.href = "viewPO.php?customview=" + id + "&module=<?= $_GET['module'] ?>&search=Search";
        LoaderSearch();
    }
 
 
 
   function makepdffile(url){
            $.ajax({
            url: url,
        });
    }

function printExternal(url) {
   var div = document.getElementById("printerDiv");
      div.innerHTML = '<iframe src="'+url+'" onload="this.contentWindow.print();"></iframe>';

}


function genEdiFunction(inf) {
    var modal = document.getElementById('myEdiDIV'+inf);

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn"+inf);
      modal.style.display = "block";
   
} 
function EDIModelClose(inf){
 var modal = document.getElementById('myEdiDIV'+inf);
    modal.style.display = "none";
  
}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<form action="" method="post" name="form1"><!-----moved here by nisha for highlight option----->
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="top">
		<a href="<?=$AddUrl?>" class="add">Add <?=$ModuleName?></a>
		
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_po.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
	
	 
		

		 <? if($_GET['search']!='') {?>
	  	<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
 <? if ($num > 0 ) { ?>
            <tr>
                <td align="right" height="40" valign="bottom">


<?
	//added by nisha for highlight option
$ToSelect = 'OrderID';
include_once("../includes/FieldArrayRow.php");
echo $RowColorDropDown;
?>
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
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arryPurchase)?>');" /></td>-->
	<td width="10%" class="head1" >Order Date</td>
	<td width="12%"  class="head1" ><?=$ModuleIDTitle?>#</td>
	<td width="7%" class="head1" >Order Type</td>
	<td width="10%" class="head1" >Sales Order #</td>
	<td class="head1" width="10%" >Vendor</td>
	<td width="10%"   class="head1" >Posted By</td>
	<td width="6%" align="center" class="head1" >Amount</td>
	<td width="5%" align="center" class="head1" >Currency</td>
	<td width="5%"  align="center" class="head1" >Approved</td>
	<!--td width="5%"  align="center" class="head1" >Status</td-->       
      <td width="15%"  align="center" class="head1 head1_action">Action</td>
	<!-- addedby nisha for highlight options ------->
		 <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'OrderID', '<?= sizeof($arryPurchase) ?>');" /></td>
    </tr>
   <? } else { ?>
          <tr align="left"  >
                <? foreach ($arryColVal as $key => $values) { ?>
                    <td width=""  class="head1" ><?= $values['colname'] ?></td>
                <? } ?>
                <td width="12%"  align="center" class="head1 head1_action" >Action</td>
<td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll', 'OrderID', '<?= sizeof($arryPurchase) ?>');" /></td>

          </tr>
        <? } ?>
    <?php 
#pr($arryPurchase);
 
  if(is_array($arryPurchase) && $num>0){
  	$flag=true;
	$Line=0;
	

	if($module=="Order"){
		$PdfFolder = $Config['P_Order'];
		$PurchaseIDCol = 'PurchaseID';
	}else{
		$PdfFolder = $Config['P_Quote'];
		$PurchaseIDCol = 'QuoteID';
	}
	
	
	
  	foreach($arryPurchase as $key=>$values){
	$POReceipt = 0;

	$flag=!$flag;
	$Line++;
	$RceiptStatus=$objPurchase->GetRceiptStatus($values['PurchaseID']);
	$RecStatus = (!empty($RceiptStatus[0]['RecStatus']))?($RceiptStatus[0]['RecStatus']):('');

	$EmailIcon = ($values['MailSend']!=1)?('emailgreen.png'):('emailred.png');
	$sendemail = '<img src="' . $Config['Url'] . 'admin/images/'.$EmailIcon.'" border="0"  onMouseover="ddrivetip(\'<center>Send '.$module.'</center>\', 120,\'\')"; onMouseout="hideddrivetip()" >';

/********************/
$PdfResArray = GetPdfLinks(array('Module' => $module,  'ModuleID' => $values[$PurchaseIDCol], 'ModuleDepName' => 'Purchase', 'OrderID' => $values['OrderID'], 'PdfFolder' => $PdfFolder, 'PdfFile' => $values['PdfFile']));
/********************/
 
$arrVal = explode(',',	$queryCommentKey[0]['commentedIds']);
$available = in_array($values['OrderID'],$arrVal);
if($available > 0){
$comment = '<img src="'.$Config['Url'].'admin/images/comment_red.png" border="0"  class="commenticon" onMouseover="ddrivetip(\'<center>Comments</center>\', 65,\'\')"; onMouseout="hideddrivetip()" >';
}else{
$comment = '<img src="'.$Config['Url'].'admin/images/comment.png" border="0"  class="commenticon" onMouseover="ddrivetip(\'<center>Comments</center>\', 65,\'\')"; onMouseout="hideddrivetip()" >';

}
$EdiLink ='';
if(!empty($values["EDIRefNo"])){

try {
$EdiRefArry = '';
$DisplayName = '';
$PostToGl = 0;
	$EdiRefArry = explode("/",$values['EDIRefNo']);
	$DisplayName=$ediObj->GetCompanyForEDI($EdiRefArry[1],$Config['DbMain']);
	if(!empty($EdiRefArry[4])){
	$arrySalesinv = $objSale->GetSale('',$EdiRefArry[4],'Invoice',$DisplayName);
	
	if($arrySalesinv[0]['InvoiceID']!=''){
	$PostToGl =  $arrySalesinv[0]['PostToGL'];
	
	
	$EdiLink .='<a class="Active" id="myBtn'.$values['OrderID'].'" onclick=" genEdiFunction('.$values['OrderID'].');"  >Allow Edi Data</a><br>';
	
	$EdiLink .='<div  class="modalEdi"  id="myEdiDIV'.$values['OrderID'].'" style="display:none;"><div class="modalEdi-content"><span class="closeEDi" onclick ="return EDIModelClose('.$values['OrderID'].');">&times;</span><p><a class="btn Active"  href="viewPO.php?PostEdi='.$values['OrderID'].'&refd='.$DisplayName.'&receipt=2&invid='.$arrySalesinv[0]['OrderID'].'" >Recieve and generate Invoice</a> <br><br>   <a class="btn InActive"  href="viewPO.php?PostEdi='.$values['OrderID'].'&receipt=1&refd='.$DisplayName.'&invid='.$arrySalesinv[0]['OrderID'].'" >Recieve and not generate Invoice</a></p></div> </div>';
	}
	}
}

//catch exception
catch(Exception $e) {
echo 'Message: ';
}
$CountPO =0;
	$CountPO = $objPurchase->getCountReceiptPO($values['PurchaseID']);
				if($CountPO>0){
						$POReceipt=1;
				}else{
          $POReceipt = 0;

       }

}


	if($values["OrderType"]=='Dropship'){
		$OrderTypeButton = '<a class="Active" style="text-decoration:none;background-color:#1569C7!important;" >'.$values['OrderType'].'</a>';
	}else{
		$OrderTypeButton = '<a class="Active" style="text-decoration:none;" >'.$values['OrderType'].'</a>';
	}

if(!empty($values["VendorName"])){
		$VendorName = $values["VendorName"];
	}else{
		$VendorName = $values["SuppCompany"];
	}


if(!empty($values["EDICompId"])){
$ediiconmain =$ediicon;
}else{
$ediiconmain='';
}

	
  ?>
   <tr  align="left"  bgcolor="<?= $bgcolor ?>" <? if(!empty($values['RowColor'])){ echo 'style="background-color:'.$values['RowColor'].'"'; }?>> <!-----modified by nisha for color highlight options-->
         <? if ($_GET["customview"] == 'All') { ?>
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>
	   
	   </td>
	 <td><?=$values[$ModuleID]?></td>
      <td><?=$OrderTypeButton?></td>
     <td><?php if(empty($values["EDICompId"]) || $values["OrderType"]=='Dropship' ) echo $values['SaleID']; ?></td>
      <td><a class="fancybox fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>" ><?=stripslashes($VendorName)?></a><?=$ediiconmain?></td> 
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
		 if($values['Approved'] ==1){
			  $Approved = 'Yes';  $ApprovedCls = 'green';
		 }else{
			  $Approved = 'No';  $ApprovedCls = 'red';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$Approved.'</span>';
		
	 ?></td>

     <!--td align="center">
	 <?  $OrderIsOpen = 0;
		 if($values['Status'] == 'Cancelled' || $values['Status'] == 'Rejected'){
			 $StatusCls = 'red';
		 }else if($values['Status'] == 'Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = '';
			 $OrderIsOpen = 1;
		 }

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';
		
	 ?>
	 
	</td-->


    
    
     <?  } else {

             foreach ($arryColVal as $key => $cusValue) {
                echo '<td>';

                if ($cusValue['colvalue'] == 'SuppCompany') {
                    echo '<a class="fancybox fancybox.iframe" href="suppInfo.php?view=' . $values['SuppCode'] . '" >' . stripslashes($values["SuppCompany"]) . '</a>';
                } elseif ($cusValue['colvalue'] == 'AssignedEmp') {
                    echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['AssignedEmpID'] . '" >' . stripslashes($values["AssignedEmp"]) . '</a>';
                } elseif ($cusValue['colvalue'] == 'Status') {
                    #echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view=' . $values['SalesPersonID'] . '" >' . stripslashes($values["SalesPerson"]) . '</a>';

                    $OrderIsOpen = 0;
                    if ($values[$cusValue['colvalue']] == 'Cancelled' || $values[$cusValue['colvalue']] == 'Rejected') {
                        $StatusCls = 'red';
                    } else if ($values[$cusValue['colvalue']] == 'Completed') {
                        $StatusCls = 'green';
                    } else {
                        $StatusCls = '';
                        $OrderIsOpen = 1;
                    }

                    echo '<span class="' . $StatusCls . '">' . $values['Status'] . '</span>';
                } elseif ($cusValue['colvalue'] == 'OrderDate' || $cusValue['colvalue'] == 'DeliveryDate') {
                    if ($values[$cusValue['colvalue']] > 0)
                        echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                } elseif ($cusValue['colvalue'] == 'Approved') {
                    
                 if ($values[$cusValue['colvalue']] == 1) {
                    $Approved = 'Yes';
                    $ApprovedCls = 'green';
                } else {
                    $Approved = 'No';
                    $ApprovedCls = 'red';
                }

                echo '<span class="'.$ApprovedCls.'">'.$Approved.'</span>';
            } else { ?>

            <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
            <? }
        echo '</td>';
    }
} ?>
    
    
    
    
      <td  align="center" class="head1_inner">
<?
if($module=="Order"){ 
	$TotalInvoice=$objPurchase->CountInvoices($values['PurchaseID']);
	$TotalQtyLeft = $objPurchase->GetTotalRcieveQtyLeft($values['OrderID']);




}

?>
<a href="<?=$ViewUrl.'&view='.$values['OrderID']?>" ><?=$view?></a>

<? 
 


//if($TotalInvoice<=0 && $values['Status'] != 'Completed'){ 
//if($values['Status'] != 'Completed'){  
if($POReceipt !=1 && $values['close_status'] != 1){ ?>
<a href="<?=$EditUrl.'&edit='.$values['OrderID']?>" ><?=$edit?></a>
<? } 
if($TotalInvoice<=0 && $values['Status'] != 'Completed' && $values['close_status'] != 1){ ?>
<a href="<?=$EditUrl.'&del_id='.$values['OrderID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 
<? } ?>
<a href="<?=$PdfResArray['DownloadUrl']?>" ><?=$download?></a>
<a <?=$PdfResArray['MakePdfLink']?> class="fancybox fancybox.iframe" href="<?=$SendUrl.'&view='.$values['OrderID']?>" ><?=$sendemail?></a>
<?php if($values['PurchaseID']==''){ $so ='&qo='.$values['QuoteID']; }else{ $so ='&po='.$values['PurchaseID'];} ?>
<a class="fancybox com fancybox.iframe"  href="../erpComment.php?view=<?php echo $values['OrderID']; ?>&module=<?php echo $_GET['module']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=Comments&popLead=1<?=$so?>" ><?=$comment?></a>
<?
if($module=="Order"){ 	
	if($TotalInvoice>0){
		echo '<br><a href="../finance/viewPoInvoice.php?po='.$values['PurchaseID'].'" target="_blank" >'.$TotalInvoice.' Invoices</a>';
	}
	if($values['Approved'] ==1){
		//if($TotalQtyLeft>0 && $OrderIsOpen == 1){

//if($TotalQtyLeft > 0 && $OrderIsOpen == 1){				
	if($values['close_status'] == 1 ){
echo '<br><span class=black>Received<span>';
echo '<br><span class=black>Closed<span>'; 
}else{	
if( $TotalQtyLeft > 0){		

if(!empty($PostToGl)){
		echo '<br />'.$EdiLink;
		}else{

if($values['OrderType']=="Dropship"){		
	
echo '<br><a class="Active" href="../warehouse/receiptOrder.php?po='.$values['OrderID'].'"  style="text-decoration:none;background-color:#1569C7!important;" >Receive</a>';	

}else{	
		
		
		echo '<br><a class="action_bt" style="text-decoration:none;" href="../warehouse/receiptOrder.php?po='.$values['OrderID'].'" >Receive</a>';
	
}
}
}
		if($TotalInvoice > 0 && $TotalQtyLeft > 0){	
			echo '<br><a class="action_bt" href="../purchasing/viewPO.php?cOrder='.$values['OrderID'].'" >Close</a>';
		}
	    }
		
#echo $EdiLink;

			//echo '<br><a class="action_bt" href="../warehouse/receiptOrder.php?po='.$values['OrderID'].'" target="_blank" >Receive</a>';
		//
/*}else {

if($RecStatus == 'Completed'){
			echo '<br><span class=black>Received<span>';
}else if($RecStatus == 'Parked'){

echo '<br><a class="action_bt" href="../warehouse/editPoReceipt.php?edit='.$RceiptStatus[0]['RID'].'&po='.$values['PurchaseID'].'" target="_blank" >Create Invoice</a>';
}
		}*/
	}

}
?>
<? if($values['OrderType']=="Dropship"){?>
<ul class="print_menu" style="width:60px;">
<li><a  href="#">Print</a>
<ul>
 <!--../pdfCommonhtml.php?o=&module=Order&ModuleDepName=Sales 
 <li class="print" ><a href="../pdfCommonhtml.php?o=&module=Order&ModuleDepName=Sales&curP=1&print=print&sop=<?=$values['SaleID']?>" onclick="javascript:printExternal('../pdfCommonhtml.php?o=&module=Order&ModuleDepName=Sales&curP=1&print=print&sop=<?=$values['SaleID']?>');" target="_blank" >Print SO</a></li>
 ../pdfCommonhtml.php?o=&module=Order&attachfile=1&ModuleDepName=Purchase
 -->
<!--<li class="print" ><a href="../pdfCommonhtml.php?o=&module=Order&ModuleDepName=Sales&curP=1&print=print&sop=<?=$values['SaleID']?>"  target="_blank" >Print SO</a></li>-->
<li class="print" ><a href="../pdfBothPDFhtml.php?sop=<?=$values['SaleID']?>&po=<?=$values['OrderID']?>&curP=1&ModuleDepName=printboth"  target="_blank" >Print PO & SO</a></li>
<li class="print" ><a href="<?=$PdfResArray['PrintUrl']?>" target="_blank">Print PO</a></li>

</ul>
</li>
</ul>
<? }else{?>

<?php 
	echo '<br><ul class="print_menu" style="width:60px;"><li class="print" ><a target="_blank" class="edit"  href="'.$PdfResArray['PrintUrl'].'">&nbsp;</a></li></ul>';
	//'pdfCommonhtml.php?o=9977&module=Order&editpdftemp=1&tempid=&ModuleDepName=Sales'
	?>
<? }?>
	</td>
<td ><input type="checkbox" name="OrderID[]" id="OrderID<?= $Line ?>" value="<?= $values['OrderID'] ?>" /></td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td colspan="11" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td colspan="11"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryPurchase)){ ?>
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
<!--added by nisha for row highlight options---->
	<input type="hidden" name="NumField" id="NumField" value="<?= sizeof($arryPurchase) ?>">

</td>
	</tr>
</table>
</form>
<div id="printerDiv" style="display:none"></div>
