<? 
if($arryCustomer[0]['CustCode']!=''){	 
	$ViewDetailUrl = "../finance/vCreditNote.php?pop=1";

	$_GET['CustCode'] = $arryCustomer[0]['CustCode'];		
	$arrySaleCredit = $objSale->ListCreditNote($_GET);
	if(sizeof($arrySaleCredit)>0){ 
?>
<script language="JavaScript1.2" type="text/javascript">
function ShowDateFieldCredit(){	
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


function ValidateSearchCr(frm){	
	
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
	  <td  valign="top" class="had2">
Credit Memo 
	</td>
</tr>
<!--tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form4" onSubmit="return ValidateSearchCr(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>

		<td valign="bottom">
		  Filter By :<br> 
		  <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateFieldCredit();">
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
	  ShowDateFieldCredit();
	  </script>
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr-->
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">

<tr align="left"  >
	<td width="13%" class="head1" >Posted Date</td>
	<td width="12%"  class="head1" >Credit Memo ID#</td>
	<td width="13%" class="head1" >Expiry Date</td>

	<td width="8%" align="center" class="head1" >Amount</td>
	<td width="8%" align="center" class="head1" >Currency</td>
	<td width="8%"  align="center" class="head1" >Status</td>
	<td width="8%"  align="center" class="head1" >Approved</td>
</tr>
<?
  	$flag=true;
	$Line=0;
  	foreach($arrySaleCredit as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;	
  ?>
<tr align="left"  class="<?=$class?>">
 
<td height="20">
		 <?
                if($values['PostedDate'] > 0)
                    echo date($Config['DateFormat'], strtotime($values['PostedDate']));
                ?>
	</td>
		<td >
<a class="fancybox fancybig fancybox.iframe" href="<?=$ViewDetailUrl.'&view='.$values['OrderID']?>" ><?=$values["CreditID"]?></a>

</td>
  <td>
                                                <?
                                                if ($values['ClosedDate'] > 0)
                                                    echo date($Config['DateFormat'], strtotime($values['ClosedDate']));
                                                ?>

                                            </td>

		  <td align="center"><?= $values['TotalAmount'] ?></td>
                                            <td align="center"><?= $values['CustomerCurrency'] ?></td>
		
		 <td align="center">
                                                <?
                                                if ($values['Status'] == 'Open') {
                                                    $StatusCls = 'green';
                                                } else {
                                                    $StatusCls = 'red';
                                                }

                                                echo '<span class="' . $StatusCls . '">' . $values['Status'] . '</span>';
                                                ?>

                                            </td>


                                            <td align="center"><?
                                                if ($values['Approved'] == 1) {
                                                    $Approved = 'Yes';
                                                    $ApprovedCls = 'green';
                                                } else {
                                                    $Approved = 'No';
                                                    $ApprovedCls = 'red';
                                                }

                                                echo '<span class="' . $ApprovedCls . '">' . $Approved . '</span>';
                                                ?></td>


 
</tr>

 <?
} // foreach end //

?>
  
     
   
  </table>
</div>
	 
		 </td>
	</tr>	
	

</table>
<? }} ?>
