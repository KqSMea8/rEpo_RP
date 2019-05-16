<script language="JavaScript1.2" type="text/javascript">

function ShowDateField(){
	document.getElementById("monthDiv").style.display = 'none';
	document.getElementById("yearDiv").style.display = 'none';
	document.getElementById("fromDiv").style.display = 'none';
	document.getElementById("toDiv").style.display = 'none';	
	document.getElementById("keyDiv").style.display = 'none';

	 if(document.getElementById("FilterBy").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';				
	 }else if(document.getElementById("FilterBy").value=='Month'){
	    	document.getElementById("monthDiv").style.display = 'block';
		document.getElementById("yearDiv").style.display = 'block';		
	 }else if(document.getElementById("FilterBy").value=='Reference' || document.getElementById("FilterBy").value=='Source'  || document.getElementById("FilterBy").value=='Name'){	    	
		document.getElementById("keyDiv").style.display = 'block';	
	 }else{
		document.getElementById("fromDiv").style.display = 'block';
		document.getElementById("toDiv").style.display = 'block';	
	 }


}




function ValidateSearch(frm){	

	  /*if(document.getElementById("c").value == "")
	  {
		alert("Please Select Customer.");
		document.getElementById("c").focus();
		return false;
	  }*/

	if(document.getElementById("FilterBy").value=='Year'){
		if(!ValidateForSelect(frm.Year, "Year")){
			return false;	
		}
	}else if(document.getElementById("FilterBy").value=='Month'){
		if(!ValidateForSelect(frm.Month, "Month")){
			return false;	
		}
		if(!ValidateForSelect(frm.Year, "Year")){
			return false;	
		}
	}else if(document.getElementById("FilterBy").value=='Reference' || document.getElementById("FilterBy").value=='Source'  || document.getElementById("FilterBy").value=='Name'){	    		
		if(!ValidateForSimpleBlank(frm.key, "Search Keyword")){
			return false;	
		}	 
	 
	}else{
		if(!ValidateForSelect(frm.FromDate, "From Date")){
			return false;	
		}
		if(!ValidateForSelect(frm.ToDate, "To Date")){
			return false;	
		}

		if(frm.FromDate.value>frm.ToDate.value){
			alert("From Date should not be greater than To Date.");
			return false;	
		}

		var NumDay =  DateDiff(frm.FromDate.value,frm.ToDate.value);
		if(NumDay>90){
			alert("Please select 3 months duration.");
			return false;
		}	

	}

	ShowHideLoader(1,'F');
	return true;	



	
}
</script>

<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
	
	

		<td valign="bottom">
		  Filter By :<br> 
		  <select name="FilterBy" class="textbox" id="FilterBy" style="width:120px;" onChange="Javascript:ShowDateField();">
					 <option value="Date" <?  if($_GET['FilterBy']=='Date'){echo "selected";}?>>Date Range</option>
					 <!--option value="Year" <?  if($_GET['FilterBy']=='Year'){echo "selected";}?>>Year</option-->
					 <option value="Month" <?  if($_GET['FilterBy']=='Month'){echo "selected";}?>>Month</option>
			 <option value="Source" <?  if($_GET['FilterBy']=='Source'){echo "selected";}?>>Source</option>
			 <option value="Reference" <?  if($_GET['FilterBy']=='Reference'){echo "selected";}?>>Reference No</option>
			 <option value="Name" <?  if($_GET['FilterBy']=='Name'){echo "selected";}?>>Name</option>
		</select> 
		</td>
	   <td>&nbsp;</td>


		 <td valign="bottom">
                		
		<script type="text/javascript">
		$(function() {
			$('#FromDate').datepicker(
				{
				showOn: "both",dateFormat: 'yy-mm-dd', 
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+1?>', 
				 
				changeMonth: true,
				changeYear: true

				}
			);
		});
		</script>
<div id="fromDiv" style="display:none">
From Date :<br> <input id="FromDate" name="FromDate" readonly="" class="datebox" value="<?=$_GET['FromDate']?>"  type="text" placeholder="From Date" > 
</div>

	</td> 

	 

		 <td valign="bottom">

               		
<script type="text/javascript">
$(function() {
	$('#ToDate').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+1?>', 
		 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<div id="toDiv" style="display:none">
To Date :<br> <input id="ToDate" name="ToDate" readonly="" class="datebox" value="<?=$_GET['ToDate']?>"  type="text" placeholder="To Date">
</div>

<div id="monthDiv" style="display:none">
Month :<br>
<?=getMonths($_GET['Month'],"Month","textbox")?>
</div>

<div id="keyDiv" style="display:none">
<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">
</div>

</td> 
  <td><div id="yearDiv" style="display:none">
Year :<br>
<?=getYears($_GET['Year'],"Year","textbox")?>
</div></td>


<? if(sizeof($CurrencyArray)>1){ ?>
	<td>
		Currency :<br>

		<select name="Currency" class="inputbox" id="Currency" style="width:70px">		
		<?	
		foreach($CurrencyArray as $Currency){ 
		$sel = ($_GET['Currency']==$Currency)?("selected"):("");
		echo '<option value="'.$Currency.'" '.$sel.'>'.$Currency.'</option>';				
		}
		?>
		</select> 

		<script>
		$("#Currency").select2();
		</script> 
	</td>
<? } ?>




	  <td align="right" valign="bottom">   <input name="search" type="submit" class="search_button" value="Go"  />	  
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
        <td align="right" valign="top">
		
	    <? if($num>0){?>

<ul class="export_menu">
	<li><a class="hide" href="#">Export Accounts</a>
	<ul>
		<li class="excel" ><a href="export_gl_report.php?<?=$QueryString?>" ><?=EXPORT_EXCEL?></a></li>
		 
	</ul>
	</li>
</ul>


	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/> 
	    <? } ?>


		</td>
      </tr>
	 	  
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>
	<tr align="left"  >
		<td width="11%"  class="head1">Date</td>
		<td width="11%" class="head1">Source</td>
		<td width="11%" class="head1">Reference No#</td>
		 
		<td class="head1">Name</td>
		<td width="15%" class="head1">Category</td>
		<td width="18%" class="head1">GL Account</td>
		<td width="10%" class="head1" align="right">Debit [<?=$DefaultCurrency?>]</td>
		<td width="10%"  class="head1" align="right">Credit [<?=$DefaultCurrency?>]</td>
		<!--td width="5%"  class="head1 head1_action"  align="center">Action</td-->		 	 
	</tr>

	<?php 
	if(is_array($arryReport) && $num>0){
	$flag=true;
	$Line=0;
	$totalTaxAmnt=0;
	$TotalDebit = 0;
	$TotalCredit = 0;
	foreach($arryReport as $key=>$values){


		$ReceivedAmount = '';
		$PaidAmount = '';
	
	 	/*******PK*********/
	 	if(!empty($Config['ModuleCurrencySel'])){		
			if($values["TransactionType"]=='D')$ReceivedAmount = $values["OriginalAmount"];
			if($values["TransactionType"]=='C')$PaidAmount = $values["OriginalAmount"];	
		}else{
			$ReceivedAmount = $values["DebitAmnt"];
			$PaidAmount = 	$values["CreditAmnt"];	
		}
		/**********************/


		$TotalDebit += $ReceivedAmount;
		$TotalCredit += $PaidAmount;

		$flag=!$flag;		
		$Line++;

		$Name = '';
		if(!empty($values["CustomerName"])){ 
			$Name = stripslashes(ucfirst($values["CustomerName"])); 
		}else if(!empty($values["VendorName"])){ 
			$Name = stripslashes(ucfirst($values["VendorName"]));
		}


		$NewCode = $values["PaymentType"].'#'.$values['ReferenceNo'].'#'.$values["PaymentType"].'#'.$Name;


		$Source='';
		if(!empty($values["SaleID"])){
			$Source = 'SO: '.$values["SaleID"];
		}elseif(!empty($values["PurchaseID"])){
			$Source = 'PO: '.$values["PurchaseID"];
		}elseif(!empty($values["RecPurchaseID"])){
			$Source = 'PO: '.$values["RecPurchaseID"];
		}

	?>
	

	<? if($OldCode != $NewCode){ ?>

	<tr >
	<td  height="30" class="heading" >
	 <?=date($Config['DateFormat'], strtotime($values['PaymentDate']))?>
 
	</td>
	<td  class="heading" > <?=stripslashes($Source)?> </td> 
	<td  class="heading" > <?=stripslashes($values["ReferenceNo"])?> </td> 

	<td  class="heading"> 
		<?=$Name?>
		</td> 
    
	    	<td class="heading" colspan="6">

		<? 	
			
			if($values["PaymentType"]=='Sales'  && $values["EntryType"]=='Invoice'  && $values["PaymentType"]==$arryAccount[0]['AccountName']){
				echo 'Customer Invoice';
			}else{
				echo stripslashes($values["PaymentType"]);
				if(!empty($values['Method'])){
					 echo " - ".$values['Method'];
				}
				if(!empty($AccountName)){ 
					echo " - ".$AccountName;
				}

				 
			}

		?>


		</td> 

	</tr>
	<? } ?>

		<tr>
		<td colspan="5" align="center">  <? if($_GET['pk']){echo $values["PaymentID"].'#'.$values["OriginalAmount"].'#'.$values["ModuleCurrency"]; } ?></td>
		
		 
		<td><?=$values["AccountNameNumber"]?>

</td> 

		

		 <td align="right"><? if($ReceivedAmount>0 || $ReceivedAmount<0){echo number_format($ReceivedAmount,2);}?></td> 
    <td align="right"><? 
if($PaidAmount>0 || $PaidAmount<0){
	echo number_format($PaidAmount,2);
}


?></td>
<!--td  align="center" class="head1_inner">

<?php if(!empty($values['JournalID'])){?>
<a href="vGeneralJournal.php?pop=1&amp;view=<?=$values['JournalID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>
<?php if(!empty($values['InvoiceID']) && $values['PaymentType'] == 'Sales'){?>
<a href="receiveInvoiceHistory.php?pop=1&amp;InvoiceID=<?=$values['InvoiceID']?>&edit=<?=$values['OrderID']?>&InvoiceID=<?=$values['InvoiceID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>
<?php if(!empty($values['InvoiceID']) && $values['PaymentType'] == 'Purchase'){?>
<a href="payInvoiceHistory.php?pop=1&amp;po=<?=$values['PurchaseID']?>&view=<?=$values['OrderID']?>&inv=<?=$values['InvoiceID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>


<?php if(!empty($values['ExpenseID'])){ /*if($_GET['accountID'] == 32)$Flag=1;else$Flag=0;*/$Flag=1;?>
<a href="vOtherExpense.php?pop=1&amp;Flag=<?=$Flag;?>&amp;view=<?=$values['ExpenseID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>


<?php if(!empty($values['TransferID'])){?>
<a href="vTransfer.php?pop=1&amp;view=<?=$values['TransferID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>
<?php if(!empty($values['DepositID'])){?>
<a href="vDeposit.php?pop=1&amp;view=<?=$values['DepositID']?>" class="fancybox po fancybox.iframe"><?=$view?></a>
<?php }?>

</td-->
 
		</tr>
		<?php 

	$OldCode = $values["PaymentType"].'#'.$values['ReferenceNo'].'#'.$values["PaymentType"].'#'.$Name;

} // foreach end //?>

		<tr >
		<td  colspan="6" align="right"> <b>Total : </b> </td>
		<td align="right"><b><? echo number_format($TotalDebit,2);?></b></td> 
		<td align="right"><b><? echo number_format($TotalCredit,2);?></b></td>
		</tr>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
	</tr>
	<?php } ?>

	<!--<tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReport)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	</tr>-->
</table>
		</div> 
		 
	<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
	<input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
	</form>
</td>
</tr>

</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".po").fancybox({
			'width'         : 900
		 });

});

</script>
