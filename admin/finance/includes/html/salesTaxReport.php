<script language="JavaScript1.2" type="text/javascript">


function ShowReportBy(){	
	 if(document.getElementById("rby").value=='L'){
		document.getElementById("taxDiv").style.display = 'block';
		document.getElementById("customerDiv").style.display = 'none';		
	 }else{
		document.getElementById("taxDiv").style.display = 'none';
		document.getElementById("customerDiv").style.display = 'block';		 	
	 }
}

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

	  /*if(document.getElementById("c").value == "")
	  {
		alert("Please Select Customer.");
		document.getElementById("c").focus();
		return false;
	  }*/

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
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>

<td valign="bottom" style="display:none1">
		  Report By :<br> 
		  <select name="rby" class="textbox" id="rby" style="width:100px;" onChange="Javascript:ShowReportBy();">
			 <option value="C" <?  if($_GET['rby']=='C'){echo "selected";}?>>Customer</option>
			 <option value="L" <?  if($_GET['rby']=='L'){echo "selected";}?>>Tax Rate</option>
			 
		</select> 
		</td>
	   <td>&nbsp;</td>

<td valign="bottom">

<div id="customerDiv" <?  if($_GET['rby']!='C'){echo 'style="display:none"';}?>>
Customer :<br> 
		<select id="CustCode" class="inputbox" name="CustCode">
			   <option value="">---All Customers---</option>
			     <?php foreach($arryCustomer as $customer){?>
				 <option value="<?=$customer['CustCode'];?>" <?php if($_GET['CustCode'] == $customer['CustCode']){echo "selected";}?>><?php echo $customer['CustomerName']; ?></option>
				<?php }?>
			</select>
</div>

<div id="taxDiv"  <?  if($_GET['rby']!='L'){echo 'style="display:none"';}?>>
Tax Rate :<br> 
		<select id="Tax" class="inputbox" name="Tax">
			   <option value="">---All Taxes---</option>
			     <?php foreach($arryTax as $tax){
 
?>
				 <option value="<?=$tax?>" <?php if($_GET['Tax'] == $tax){echo "selected";}?>><?php echo $tax; ?></option>
				<?php }?>
			</select>
</div>


</td>


		

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
From Date :<br> <input id="f" name="f" readonly="" class="datebox" value="<?=$_GET['f']?>"  type="text" placeholder="From Date" > 
</div>

	</td> 

	 

		 <td valign="bottom">

                			
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
To Date :<br> <input id="t" name="t" readonly="" class="datebox" value="<?=$_GET['t']?>"  type="text" placeholder="To Date">
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
	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
              <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='sales_tax_report.php?<?=$QueryString?>&module=Invoice';" />

	    <? } ?>


		</td>
      </tr>

<tr>

	 	  <tr>
	 <td align="right">
<?
echo $CurrencyInfo = str_replace("[Currency]",$Config['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>	  
<tr>
	<td>

<table id="myTable" class="order-list" cellspacing="1" cellpadding="0" width="100%">
<tr >
	<td class="heading">Gross Sales [<?=$Config['Currency']?>]</td>
	<td class="heading">Exempt Sales [<?=$Config['Currency']?>]</td>
	<td class="heading">Taxabale Amount [<?=$Config['Currency']?>]</td>
	<td class="heading">Tax Collected [<?=$Config['Currency']?>]</td>
</tr>
<tr class="itembg">
	<td><?=number_format($GrossSale,2)?></td>
	<td><?=number_format($ExemptSale,2)?></td>
	<td><?=number_format($TaxabaleAmount,2)?></td>
	<td><?=number_format($TaxCol,2)?></td>
</tr>
</table>


	</td>
</tr>

	  
	
	<tr>
	  <td  valign="top">
	

		<form action="" method="post" name="form1">
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>
		<tr align="left"  >
		<td class="head1" <?=$TaxDisplay?> width="8%" >Tax Rate</td>  
        	<td class="head1"  >Customer</td>    
		<td width="10%" class="head1">Invoice Date</td>
		<td width="9%"  class="head1">Invoice#</td>
 		<td width="10%"   class="head1">Invoice Amount</td>
		
		<td class="head1"  width="12%">Payment Term</td>
        <td class="head1"  width="10%">Due Date</td>
        
        <td class="head1"  width="9%">SO #</td>
		<td class="head1"  align="right" width="12%">Tax Amount (<?=$Config['Currency']?>)</td>
		</tr>

		<?php 
		
		if(is_array($arrySale) && $num>0){
		$flag=true;
		$Line=0;
		
		$CustomerAmount=0;
		
          $TotalAmount = 0;

		foreach($arrySale as $key=>$values){
		
			$ConversionRate=1;
			if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
				$ConversionRate = $values['ConversionRate'];			   
			}
		        $Amount = GetConvertedAmount($ConversionRate, $values['taxAmnt']);
			$TotalAmount +=$Amount;

			$InvoiceTotal +=  GetConvertedAmount($ConversionRate, $values['TotalInvoiceAmount']); 
	       
			$flag=!$flag;
			$bgclass = (!$flag)?("oddbg"):("evenbg");
			$Line++;
		 
			if(!empty($values["PaymentTerm"])){ 
				$arryTerm = explode("-",$values["PaymentTerm"]);
				$arryDate = explode("-",$values['InvoiceDate']);
				list($year, $month, $day) = $arryDate;

				$TempDate  = mktime(0, 0, 0, $month , $day+$arryTerm[1], $year);	
				$DueDate = date("Y-m-d",$TempDate);
				$DueDate = date($Config['DateFormat'], strtotime($DueDate));
			}else{
				$DueDate = '';
			}


			$TaxRateValue = trim(stripslashes($values['TaxRate']));
			$arrTxs = explode(":",$TaxRateValue);
			$TaxVale = $arrTxs[1].' : '.$arrTxs[2].'%';


		
			$TaxByCode = ($_GET['rby']=='L')?($TaxVale):($values['CustCode']);



		 if($NewCustCode!='' && $NewCustCode != $TaxByCode){
			$CustomerTotal = '<tr class="oddbg">
			<td '.$TaxDisplay.'> </td>
			<td colspan="7" align="right" height="30" ><b> Total : </b></td>
			<td  align="right" ><b>'.number_format($CustomerAmount,2).'</b></td>

			</tr>';
			echo $CustomerTotal;
			$CustomerAmount=0;
		 } 

		 if($NewCustCode != $TaxByCode){ 
			if($_GET['rby']=='L'){
				
				echo '<tr>
				<td colspan="9" height="30" class="head1">
				<b>'.$TaxVale.'</b>
				</td>
				 
				</tr>';
			}else{
				echo '<tr>
				<td colspan="5" height="30" class="head1">
				<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID='.$values['CustID'].'" ><b>'.stripslashes($values["CustomerName"]).'</b></a>
				</td>
				<td colspan="4" class="head1"><b>Phone:</b> '.$values['Mobile'].' </td> 
				</tr>';
			}
		 } 

		    
		?>



		
			
     
          <tr align="left" class="<?=$bgclass?>">
                <td>  </td>      
		<td <?=$TaxDisplay?>><? echo '<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID='.$values['CustID'].'" ><b>'.stripslashes($values["CustomerName"]).'</b></a>'; ?></td>
  
		<td>
		<?=date($Config['DateFormat'], strtotime($values['InvoiceDate']));?></td>
		
		<td>
		<a href="vInvoice.php?pop=1&amp;view=<?=$values['OrderID']?>" class="fancybox po fancybox.iframe"><?=$values['InvoiceID']?></a></td> 

		<td><?=$values["TotalInvoiceAmount"]. " ".$values["CustomerCurrency"]?>

	 
</td>

		<td><?=stripslashes($values['PaymentTerm'])?></td>

		   
		
		<td> <?=$DueDate?></td>

	
	  <td>
		<?=stripslashes($values['SaleID'])?></td>	
		
	<td  align="right" ><b><?=(number_format($Amount,2))?></b></td>
	
		
		</tr>
		
		
	  <?php		
		 $NewCustCode = $TaxByCode;
		 $CustomerAmount +=$Amount;
	  
	   } 
		
	
		$CustomerTotal = '<tr class="oddbg">
			<td '.$TaxDisplay.'> </td>
			<td colspan="7" align="right" height="30" ><b> Total : </b></td>
			<td  align="right" ><b>'.number_format($CustomerAmount,2).'</b></td>
			
			</tr>';

		
		if($_GET['rby']=='L'){
			 if(empty($_GET['Tax'])){			
			 	echo $CustomerTotal;
			 } 
		}else{
			 if(empty($_GET['CustCode'])){			
			 	echo $CustomerTotal;
			 } 
		}


	?>
		

		
		 <tr class="oddbg">
		<td <?=$TaxDisplay?>> </td>
		<td  colspan="3" align="right" height="30"><b>Total Invoice Amount: </b></td>
	<td   ><b><?=number_format($InvoiceTotal,2);?> <?=$Config['Currency']?></b></td>
		<td  colspan="3" align="right" height="30"><b>Total Tax Amount:  </b></td>
	<td  align="right" ><b><?=number_format( $TotalAmount,2);?> <?=$Config['Currency']?></b></td>
		</tr>

		<?php }else{?>
		<tr align="center" >
		<td  colspan="9" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		<!--<tr>  <td  colspan="5"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySale)>0){?>
		&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
		}?></td>
		</tr>-->
		</table>
		</div> 

		 
		</form>
</td>
</tr>

</table>

