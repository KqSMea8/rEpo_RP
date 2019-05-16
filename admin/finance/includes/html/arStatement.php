<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>
<script language="JavaScript1.2" type="text/javascript">
$(function() {
    $("#Send_Mail").click(function(e) {

        var number_of_checked_checkbox = $(".Cid:checked").length;
        var actionToPerform = document.getElementById("Send_Mail").value;
        if (number_of_checked_checkbox == 0) {
            alert("Please select atleast one Checkbox to send email.");
            return false;
        } 
      else {
 
    	  if(actionToPerform=="Send Mail"){
			if(document.getElementById("CC").value!=''){
				if(!isEmail(document.getElementById("CC"))){
					return false;
				}
			}

		

			if(document.getElementById("AttachPdf").checked){
				ShowHideLoader('1','ATT');				
			}else{
				ShowHideLoader('1','P');	
			}

			return true;

			/*if(confirm("Are you sure you want to send email for selected records.")){
				
           			document.getElementById("form1").submit();
				return true;
			}else{
				return false;
			}*/
            }
      }
    });
});



function StatementSendMail() {	
	
	var CountCheck = document.getElementById("CountCheck").value;

	var orderno=""; var j=0;	
	for(var i=1; i<=CountCheck; i++){ 
		if(window.parent.document.getElementById("Cid"+i).checked){
		j++;
			var Cid =window.parent.document.getElementById("Cid"+i).value;
			orderno+=Cid+',';
		}
	}


	if(j>0){
		if((document.getElementById("attachrow").style.display == 'none')){ 
			document.getElementById("attachrow").style.display = 'inline' ; //inline	
		}
        }else{
		document.getElementById("attachrow").style.display = 'none';  	
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
	StatementSendMail();
}
</script>

<div class="had"><?=$MainModuleName?> Report</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" >
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Customer : <select id="c" class="inputbox" name="c">
			   <option value="">---All---</option>
			     <?php foreach($arryCustomer as $customer){?>
				 <option value="<?=$customer['CustCode'];?>" <?php if($_GET['c'] == $customer['CustCode']){echo "selected";}?>><?php echo $customer['CustomerName']; ?></option>
				<?php }?>
			</select>
		</td>
		
	   <td>&nbsp;</td>
		
	  <td align="right" valign="bottom">   <input name="search" type="submit" class="search_button" value="Go"  />	  
	<script>
$("#c").select2();
</script> 
	  
	  </td> 
 </tr>


</table>
 	</form>

	</td>
      </tr>


<tr>
        <td align="center" valign="top">
<a class="fancybox" id="mailsent_link" href="#mailsent_div"  style="display:none">sent</a>
<div id="mailsent_div" style="display:none;padding:5px;" >
 <? 
if (!empty($_SESSION['mess_Statement'])) {
    echo $_SESSION['mess_Statement'];
    unset($_SESSION['mess_Statement']);
?>	
<script type="text/javascript">
    $(document).ready(function() {
	$("#mailsent_link").fancybox().trigger('click');
    });
</script>
<? } ?>
</div>


</td>
      </tr>


	
	<tr>
        <td align="right" valign="top">
		
	 <? if($num>0){?>

		<? if($ModifyLabel==1){?>
		<a href="emailStatementSetting.php" class="fancybox edit fancybox.iframe" style="display:none11" >Email Statement Setting</a>
		<? } ?>

	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>

		
	    <? } ?>


		</td>
      </tr>
<form action="" method="post" name="form1" id="form1" >	 
<tr>
<td valign="top">

<? if(!empty($ErrorMSG)) {echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';}else{ ?>

<span id="attachrow"  style="display:none">
&nbsp;&nbsp;&nbsp;<input id="AttachPdf" name="AttachPdf" type="checkbox" value="1"  >&nbsp;<b>Attach Pdf </b>  &nbsp;&nbsp;&nbsp;&nbsp;<input id="CC" name="CC" type="textbox" class="inputbox" value="" maxlength="60" placeholder="CC">
</span>



 <input type="submit" class="button" name="Send_Mail" id="Send_Mail" value="Send Mail" >


<? } ?>


	</td>
	 
  
	 

</tr>

 
<tr >
<td  >


</td>

</tr>	

	  
	<tr>
	  <td  valign="top">
	

		
		<? if (!empty($_SESSION['mess_Statement'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_Statement'])) {echo $_SESSION['mess_Statement']; unset($_SESSION['mess_Statement']); }?>	
</td>
</tr>
<? } ?>
		<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
		<div id="preview_div">

		<table <?=$table_bg?>>
		<tr align="left"  >


<td width="2%" align="center" class="head1 head1_action">
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'Cid');" />
</td>


		<td class="head1" >Customer</td>  
		<td class="head1" width="18%">Invoice Date</td>    
		<td class="head1" width="18%">Invoice/Credit Memo #</td>  
		<td class="head1" width="20%">Balance in Customer Currency</td>  
		<td class="head1" width="20%">Balance [<?=$Config['Currency']?>]</td>  
		</tr>


		<?php 
  $CountCheck=0;
		if(is_array($arryStatement) && $num>0){
		$flag=true;
		$Line=0;
               $TotalUnpaidInvoice = 0;
	       $NewCustCode ='';
		       $CustomerUnpaidInvoice = 0;
		       
		      
		foreach($arryStatement as $key=>$values){
		        $flag=!$flag;
		        $bgclass = (!$flag)?("oddbg"):("evenbg");
		        $Line++;
                

			$ConversionRate=1;
			if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
				$ConversionRate = $values['ConversionRate'];			   
			}



		/***********************/
		$ModuleDate=''; $ModuleLink='';$orginalAmount=0;
		if($values['Module']=='Invoice'){
			$orginalAmount = $values['TotalInvoiceAmount'];
			$ModuleDate=$values['InvoiceDate'];

			if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoiceGl.php?view='.$values['OrderID'].'&pop=1">'.$values["InvoiceID"].'</a>';
			}else{
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?view='.$values['OrderID'].'&IE='.$values['InvoiceEntry'].'&pop=1">'.$values["InvoiceID"].'</a>';
			}
		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];
			$ModuleDate=$values['PostedDate'];

			if($values['OverPaid']=='1'){
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?inv='.$values['InvoiceID'].'&pop=1">'.$values["InvoiceID"].'</a>';
			}else{
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
			}
		} 
		$OrderAmount = $orginalAmount;
		$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount); 

                $PaidAmnt = $values['ReceiveAmnt']; 
                if($PaidAmnt !=''){
                    $UnpaidInvoice = $orginalAmount-$PaidAmnt;                    
                }else{
                    $UnpaidInvoice = $orginalAmount;  
                }
		                
                $TotalUnpaidInvoice +=$UnpaidInvoice;
                

		/********CC: Customer Currency************/		
		$PaidAmntCC = $values['ReceiveOrigAmnt']; 
		if($PaidAmntCC !='' ){
                    $BalanceCC = $OrderAmount-$PaidAmntCC;                    
                }else{
                    $BalanceCC = $OrderAmount;  
                }
		/********************/
		?>

		<? if(($NewCustCode != '' && $NewCustCode != $values['CustCode'])){ 

			$CustomerTotal = '<tr class="oddbg">
			<td colspan="5" align="right" height="30" ><b> Total : </b></td>
			<td><b>'.number_format($CustomerUnpaidInvoice,2).' '.$Config['Currency'].'</b></td>
			</tr>'; 
		 	echo $CustomerTotal;
			
			$CustomerUnpaidInvoice = 0;
			
		} ?>

		<? if($NewCustCode != $values['CustCode']){  ?>
		<tr>
<td></td>
		<td height="30" class="head1">
		<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID=<?=$values['CustID']?>" ><b><?=stripslashes($values["Customer"])?></b></a>
		</td>
		<td class="head1"><b>Phone:</b> <?=$values['Landline']?>	</td>
		<td class="head1" colspan="2"><b>Contact :</b>   <?
			echo $values['ContactPerson'];
		   ?></td>
		<td class="head1">  <b>Credit Limit:</b> <?=(!empty($values['CreditLimitCurrency']) && !empty($values['CustCurrency']) && $values['CustCurrency']!=$Config['Currency'])?($values['CreditLimitCurrency'].' '.$values['CustCurrency']):($values['CreditLimit']); ?>   </td>
		</tr>
		<? } 

	if(abs($UnpaidInvoice)>0){  //start row
?>
		 <tr align="left" class="<?=$bgclass?>">
	   <td align="center"  class="head1_inner">
<?php 
	$CountCheck++; ?>
 <input type="checkbox" name="Cid[]" id="Cid<?=$CountCheck?>" onchange="return StatementSendMail();" class="Cid" value="<?php echo $values['OrderID'].'#'.$values['CustID']; ?>">
 </td>
	  
<td></td>
		<td><?=date($Config['DateFormat'], strtotime($ModuleDate))?> </td>
		<td><?=$ModuleLink?>  </td>
		<td><? if($values['CustomerCurrency']!=$Config['Currency']){
				echo number_format($BalanceCC,2).' '.$values['CustomerCurrency']; 
			}
		?></td>
		<td><? echo number_format($UnpaidInvoice,2).' '.$Config['Currency']; ?></td>
		</tr>
		<?php
	} //end row

		$NewCustCode = $values['CustCode'];
		$Customer =  $values["Customer"];
		$CustomerUnpaidInvoice +=$UnpaidInvoice;

 } // foreach end //


		if(empty($_GET['c'])){
			$CustomerTotal = '<tr class="evenbg">
			<td colspan="5" align="right" height="30"><b>Total : </b></td>
			<td><b>'.number_format($CustomerUnpaidInvoice,2).' '.$Config['Currency'].'</b></td>
			</tr>';
			echo $CustomerTotal;
		}


?>
              <tr class="oddbg">
		<td colspan="5" align="right" ><b>Total : </b></td>
		<td><b><?=number_format($TotalUnpaidInvoice,2);?> <?=$Config['Currency']?></b></td>
		</tr>
		<?php }else{?>
		<tr align="center" >
		<td  colspan="12" class="no_record"><?=NO_RECORD?> </td>
		</tr>
		<?php } ?>

		
		</table>
		</div> 
		
		       <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
		       <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
               <input type="hidden" name="NumLine" id="NumLine" value="<?=$Line?>">              
               <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">
		
</td>
</tr>
</form>
</table>

<script language="JavaScript1.2" type="text/javascript">

   /* $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });*/

</script>


