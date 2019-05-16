<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){	
	if( ValidateForSelect(frm.s, "Sales Person") 
		&& ValidateForSelect(frm.m, "Month") 
		&& ValidateForSelect(frm.y, "Year") 
	){
			
			ShowHideLoader(1,'F');
			return true;	
	}else{
		return false;	
	}
	
}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_sale'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<? if($_GET['pop']!=1){ ?>	
<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Sales Person :<br> <select name="s" class="inputbox" id="s" >
		  <option value="">--- Please Select ---</option>
		  <? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
		  <option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$_GET['s']){echo "selected";}?>>
		  <?=stripslashes($arryEmployee[$i]['UserName'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		
	   <td>&nbsp;</td>




		 <td valign="bottom">
			Month :<br>
			<?=getMonths($_GET['m'],"m","textbox")?>
		 </td> 



	   <td>&nbsp;</td>

		

		 <td valign="bottom">
			Year :<br>
			<?=getYears($_GET['y'],"y","textbox")?>
		 </td> 


	  <td align="right" valign="bottom"> <input name="sb" type="submit" class="search_button" value="Go"  /></td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	
	
	
	
	
	<? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">

<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		</td>
      </tr>
	 <? } ?>


<? } ?>


	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if(!empty($_GET['m']) && !empty($_GET['y']) && !empty($_GET['s'])){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
		<td width="12%" class="head1" >Payment Date</td>
		<td width="14%" class="head1" >Payment Method</td>
		<td width="12%" class="head1" >Payment Ref #</td>		
		<td width="8%"  class="head1" >Invoice #</td>
		<td width="10%" class="head1" >Invoice Date</td>
		<td width="8%"  class="head1" >Order #</td>
		<td width="10%" class="head1" >Order Date</td>
		<td class="head1" >Customer</td>
		<td width="8%" align="center" class="head1" >Amount</td>
		<td width="6%" align="center" class="head1" >Currency</td>
    </tr>
   
    <?php 
  if(is_array($arryPayment) && $num>0){
  	$flag=true;
	$Line=0; $TotalAmount=0;
  	foreach($arryPayment as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
       <td height="20"> 
	   <? if($values['PaymentDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
		?>
	   
	   </td> 
	    <td><?=stripslashes($values["Method"])?> </td>
	    <td><?=stripslashes($values["ReferenceNo"])?></td>

	   <td>
<? if($_GET['pop']!=1){ ?>
<a class="fancybox fancybox.iframe" href="../finance/vInvoice.php?pop=1&view=<?=$values['OrderID']?>" ><?=$values["InvoiceID"]?></a>
<? } else { echo $values["InvoiceID"]; }?>
</td>

      <td>
	   <? if($values['InvoiceDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
		?>	   
	   </td>
       <td>

<? if($_GET['pop']!=1){ ?>
<a class="fancybox fancybox.iframe" href="vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$values['SaleID']?>" ><?=$values["SaleID"]?></a>
<? } else { echo $values["SaleID"]; }?>

</td>
	   	<td>
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>	   
	   </td>
      <td> 

<? if($_GET['pop']!=1){ ?>
<a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>"><?=stripslashes($values["CustomerName"])?></a> 
<? } else { echo stripslashes($values["CustomerName"]); }?>

</td> 
       <td align="center"><?=$values['DebitAmnt']?></td>
     <td align="center"><?=$values['Currency']?></td>


   
    
    </tr>
    <?php 
		$TotalAmount += $values['DebitAmnt'];
    } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  


 <tr >  <td  colspan="10"  id="td_pager">
<?php if($_GET['pop']!=1 && count($arryPayment)>0){?>
Total Record(s) : &nbsp;<?php echo $num;?>      
&nbsp;&nbsp;&nbsp;     
<?}?>
</td>
  </tr>


  </table>

<br>
<?
if($TotalAmount>0){
/***************************/
$EmpID = $_GET['s']; $EmpDivision = $arryEmp[0]['Division'];
require_once("../includes/html/box/commission_cal.php");
include("../includes/html/box/commission_view.php");
/***************************/
?>
<!--table width="100%" cellpadding="0" cellspacing="0">
 <tr>  
	<td align="right"  >Total Sales Amount : </td>
	<td align="left"><?=round($TotalAmount,2).' '.$Config["Currency"]?></td>
  </tr>
<? if(!empty($arrySalesCommission[0]['CommType'])){ ?>
<tr>
	<td  align="right" class="blackbold" width="75%" >Sales Structure :</td>
	<td align="left" valign="top">
	<?=($arrySalesCommission[0]['CommType'])?> 
	</td>
  </tr>	


 <tr>  
	<td  align="right">Sales Person Type : </td>
	<td align="left"><?=(!empty($arrySalesCommission[0]['SalesPersonType']))?($arrySalesCommission[0]['SalesPersonType']):("None");?></td>
  </tr>
 <tr>
	<td  align="right" class="blackbold"  valign="top">Commission Tier :</td>
	<td align="left" valign="top">

<? if($arrySalesCommission[0]['Percentage']>0){ ?>
<?=$arrySalesCommission[0]['Percentage']." %  on sale of : ".$arrySalesCommission[0]['RangeFrom']." - ".$arrySalesCommission[0]['RangeTo']." ".$Config['Currency'].""?>
<? }else {echo "None"; } ?>
			

	</td>
 </tr>	

<tr>
	<td align="right" class="blackbold" valign="top">
	Spiff Amount   :

	</td>
	<td  align="left"  valign="top">

	<?
	if(!empty($arrySalesCommission[0]['SpiffAmount'])){
	$SpiffAmount = $arrySalesCommission[0]['SpiffAmount'].' '.$Config['Currency'];
	}else{
	$SpiffAmount = 'None';
	}
	echo $SpiffAmount;
	?>
	
	

	</td>
</tr>

	<tr>
	<td align="right" class="blackbold"  valign="top">
		Sales Target for Spiff Amount  :

		</td>
		<td  align="left" valign="top" >	
		<?
		if(!empty($arrySalesCommission[0]['SpiffTarget'])){
		$SpiffTarget = $arrySalesCommission[0]['SpiffTarget'].' '.$Config['Currency'];
		}else{
		$SpiffTarget = 'None';
		}
		echo $SpiffTarget;
		?>

	</td>
	</tr>


 <tr>  
	<td align="right">Sales Amount for Commission : </td>
	<td align="left"><?=round($TotalSales,2).' '.$Config["Currency"]?></td>
  </tr>
<? } else{?>
<tr>
	<td  align="right" class="blackbold" width="85%">Sales Structure :</td>
	<td align="left" valign="top">
	<?=NOT_DEFINED?> 
	</td>
  </tr>	
<? } ?>
 <tr>  
	<td align="right">Sales Commission : </td>
	<td align="left"><b><?=round($TotalCommission,2).' '.$Config["Currency"]?></b></td>
  </tr>
</table-->






<? }} ?>

  </div> 
 

  
</form>
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>
