<? 
if(!empty($SuppCode)){
	require_once($Prefix . "classes/finance.account.class.php");
	$objBankAccount = new BankAccount();
	
	$_GET['SuppCode'] = $SuppCode;
	$arryVendorPayment=$objBankAccount->ListVendorPayment($_GET);
	 
	$arryBankAccount=$objBankAccount->getBankAccountForPaidPayment();
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


function ValidatePaySearch(frm){	
	
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

</script>
<table width="100%" border="0" cellpadding="5" cellspacing="5">


<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidatePaySearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>


<td valign="bottom">
		Bank Account :<br> 
 <select name="AccountID" class="inputbox" id="AccountID" >
    <option value="">--- All ---</option>
<? 
(empty($_GET['AccountID']))?($_GET['AccountID']=""):(""); 

for($i=0;$i<sizeof($arryBankAccount);$i++) {
	$selected='';
	if($_GET['AccountID']==$arryBankAccount[$i]['BankAccountID']){ 
		$selected='selected';
	} 
?>
     <option  value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?=$selected?>>
     <?=$arryBankAccount[$i]['AccountName']?>  [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
            <? } ?>
</select> 
		</td>
	   <td>&nbsp;</td>

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
 <input name="edit" type="hidden" value="<?=$_GET['edit']?>"  />
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
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
<? if(sizeof($arryVendorPayment)>0){ ?>
<tr align="left"  >
	<td width="13%"  class="head1" >Payment No#</td>
	<td width="13%" class="head1" >Payment Date</td>
	<td width="13%"   class="head1" >GL Posting Date</td>
	<td width="20%"   class="head1" >Payment Account</td>
	<td  class="head1" >Posted By</td>
	<td width="12%"   class="head1"  align="center">Amount </td>                            
	<td width="12%"   class="head1"  align="center"> Amount (<?= $Config['Currency'] ?>)</td>      
</tr>
<?
  	$flag=true;
	$Line=0;
  	foreach($arryVendorPayment as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;

	$arryDtAmount=$objBankAccount->GetTransactionDataAmount($values["TransactionID"],'',$SuppCode);	
	$AmountTotal = $arryDtAmount[0]['AmountTotal'];
	$OriginalAmountTotal = $arryDtAmount[0]['OriginalAmountTotal'];	
  ?>
<tr align="left"  class="<?=$class?>">
 
<td height="20">
   <? echo $values["ReceiptID"];    ?>
</td>
<td >
<?
if($values["PaymentDate"] > 0) {
     echo date($Config['DateFormat'], strtotime($values["PaymentDate"]));
}else {
	echo NOT_SPECIFIED;
}
 ?>
</td>
<td >
<?
if($values["PostToGLDate"] > 0) {
     echo date($Config['DateFormat'], strtotime($values["PostToGLDate"]));
} 
 ?>
   
</td>
<td height="20">
   <? echo $values["PaymentAccount"];    ?>
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

<td align="center">
<?
if(!empty($OriginalAmountTotal)){
	echo number_format($OriginalAmountTotal,2).' '.$values['ModuleCurrency'];
}

?>  

</td>

<td align="center">
  <a class="fancybox vSalesPayWidth fancybox.iframe"  href="vVendorPayment.php?view=<?=$values['TransactionID']?>&SuppCode=<?=$SuppCode?>" onMouseover="ddrivetip('<center>View Payment Summary</center>', 140,'')"; onMouseout="hideddrivetip()" ><strong><?=number_format($AmountTotal,2)?></strong></a>
<? if($values['Voided'] == "1"){ echo '<br><span class=red>Voided</span>'; } ?>

</td>


 
</tr>

 <?
} // foreach end //

?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
	 
		 </td>
	</tr>	
	

</table>


<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {


        $(".vSalesPayWidth").fancybox({
            'width': 1000
        });



    });

</script>
<? } ?>
