<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
	ShowHideLoader(1,'F');
	return true;        
    }

    $(function() {
        $("#Post_to_GL").click(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) 
                {
                alert("Please select atleast one cash receipt.");
                return false;
            } 
            else 
                {
              ShowHideLoader('1','P');
            	
                return true;
            }
            

        });
    });


    function filterLead(id)
    {
        location.href = "viewCashReceipt.php?customview=" + id;
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


var LoadedFlag = 0;

 


$(document).ready(function(){
	$("#CustID555").click(function(){
		if(LoadedFlag==0){
			LoadedFlag = 1;	
			//$("#CustID").empty();				
			$("#CustID").append('<option value="">Loading....</option>');
			var CustID = '<?=$_GET['CustID']?>';			
			var sendParam='&action=GetCustomerList&CustID='+escape(CustID)+'&r='+Math.random();  
			$.ajax({
				type: "GET",
				async:false,
				url: 'ajax_receipt.php',
				data: sendParam,
				success: function (responseText) {				 
					$("#CustID").empty();	
					$("#CustID").append(responseText); 					
				}
			});



			 

		}
	});

});
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center">
    <?php if (!empty($_SESSION['mess_Invoice'])) {
        echo $_SESSION['mess_Invoice'];
        unset($_SESSION['mess_Invoice']);
    } ?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
     
<tr>
	  <td  valign="top" >
	  
<form action="" method="get" enctype="multipart/form-data" name="form3" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >
		<tr>
		<td>
		<select name="CustID" id="CustID" class="inputbox" >
                            <option value="">---All Customers---</option>
                            <?php foreach($arryCustomerList as $values){?>
                            <option value="<?=$values['custID']?>" <?=($_GET['CustID']==$values['custID'])?('selected'):('')?>><?=$values['CustomerName']?></option>
                            <?php }?>
                            
                        </select>
		<script>
$("#CustID").select2();
</script>
                <td>&nbsp;</td>
		<td  align="right"   class="blackbold"  > Invoice/GL/Credit Memo #  :</td>
                <td   align="left" >
<input name="InvoiceGL" id="InvoiceGL" class="textbox" size="10" value="<?=$_GET['InvoiceGL']?>" maxlength="30" onkeypress="Javascript:return isAlphaKey(event);" >   
                </td>
             
 
	  <td align="right"  >   <input name="search" type="submit" class="search_button" value="Go"  />	  
	
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>
 <form action="" method="post" name="form1">
<tr>
            <td align="right" valign="top">


		  <? if($ModifyLabel==1){ ?> 
                <div style="float:right;"> 
			 <?  if($num > 0) { ?>
                    <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" onclick="return checkPosttoGL()" value="Post to GL" style="font-weight: normal; height: 22px;">
			<? } ?>
                </div>
                <div style="float:right; padding-right: 10px;">
                   
                    <a  href="receivePayment.php" class="add">Receive Payment</a>
                </div>
		<? } ?>

<? if ($_GET['search'] != '') { ?>
                <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
<? } ?>


<? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_cashreceipt.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>

            </td>
        </tr>
	
        <tr id="gldaterow"  style="display:none">
          
                      
        
          
              
                  
 <td align="right" valign="top" >
 
<span class="posttogl">Post to GL Date: </span><script>
$(function() {
$( "#gldate" ).datepicker({ 
	
	
	
		showOn: "both",
	yearRange: '<?=date("Y")-10?>:<?=date("Y")?>', 

	dateFormat: 'yy-mm-dd',

	//$("#gldate").datepicker({ dateFormat: "yy-mm-dd"}).datepicker("setDate", "0"),
	changeMonth: true,
	changeYear: true
	
	});
});
</script>
<? 
$todatdate=$Config['TodayDate'];
$todatdate = explode(" ", $todatdate);
//echo $todatdate[0];exit;
$history = '<img src="' . $Config['Url'] . 'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>View History</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';
?>
   
<input id="gldate" name="gldate" readonly="" class="datebig" value="<?=$todatdate[0]?>"  type="text" >
               
                
        
          
              
                      </td>
        </tr>

        <tr>
            <td  valign="top">



                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                        <tr align="left"  >
<? if ($_GET["customview"] == 'All') { ?>
                                <td width="10%"  class="head1" >Cash Receipt No#</td>
                                <td width="10%" class="head1" >Cash Receipt Date</td>
                             	 <td width="13%" class="head1" >GL Posting Date</td>
                                <td width="10%"   class="head1" >Posted By</td>
				 <td width="10%"   class="head1"  align="center">Amount </td>                            
                                <td width="10%"   class="head1"  align="center"> Amount (<?= $Config['Currency'] ?>)</td>                            
                                <td width="10%"  align="center" class="head1">Action</td>
                                 <? if($ModifyLabel==1){ ?> <td width="1%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td><? } ?>

                            </tr>
<? } else { ?>
                            <tr align="left"  >
                                <? foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>
                                <? } ?>
                                <td width="10%"  align="center" class="head1">Action</td>
                                <td width="5%" align="center" class="head1">Select</td>
                            </tr>

                            <?
          }

                        $receive = '<img src="' . $Config['Url'] . 'admin/images/receive.jpeg" width="25" height="25" border="0"  onMouseover="ddrivetip(\'<center>Receive Payment</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';
                        $history = '<img src="' . $Config['Url'] . 'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>View History</center>\', 80,\'\')"; onMouseout="hideddrivetip()" >';
			$sendemail = '<img src="' . $Config['Url'] . 'admin/images/emailsend.png" border="0"  onMouseover="ddrivetip(\'<center>Send Payment Info</center>\', 120,\'\')"; onMouseout="hideddrivetip()" >';			$CountCheck=0;

 
                        if($num > 0) {
                            $flag = true;
                            $Line = 0;
                            $invAmnt = 0;
				$classCount=0;
				
$void = '<img src="'.$Config['Url'].'admin/icons/memo.png" border="0"  onMouseover="ddrivetip(\'<center>Void</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';				 

				
$voidCC = '<img src="'.$Config['Url'].'admin/images/cc.png" border="0"  onMouseover="ddrivetip(\'<center>Void Credit Card</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';				 

$separator='';
                            foreach ($arryCash as $key => $values) {
                                $flag = !$flag;
                           
                                $Line++;
 
				if($values['PostToGL'] == "Yes" && $separator!=1 && $CountCheck>0) {
					echo '<tr align="center"><td  colspan="8" class="selectedbg">&nbsp;</td></tr>';
					$separator=1;
				}


                                ?>

      

                                <tr align="left"   >
                                        <? if ($_GET["customview"] == 'All') { ?>


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
if(!empty($values['OriginalAmount'])){
	echo number_format($values['OriginalAmount'],2)." ".$values['ModuleCurrency'];
}
?>

</td>

<td align="center">
  <a class="fancybox vSalesPayWidth fancybox.iframe"  href="vCashReceipt.php?view=<?=$values['TransactionID']?>" onMouseover="ddrivetip('<center>View Receipt Summary</center>', 140,'')"; onMouseout="hideddrivetip()" ><strong><?=number_format($values['TotalAmount'],2)?></strong></a>
</td>



		
  <?    }  ?>
                                    <td align="center" class="head1_inner">



	<?/*?><a href="receiveInvoiceHistory.php?edit=<?= $values['OrderID'] ?>&InvoiceID=<?= $values['InvoiceID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" target="_blank"><?=$history?></a>

	<a href="pdf_case_reciept.php?o=<?= $values['OrderID'] ?>&InvoiceID=<?= $values['InvoiceID'] ?>&IE=<?= $values['InvoiceEntry'] ?>"><?=$download?></a>
	<a class="fancybox fancybox.iframe" href="<?=$SendUrl.'&view='.$values['OrderID']?>&ID=<?= $values['PaymentID']?>&InvoiceID=<?= $values['InvoiceID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" ><?=$sendemail?></a><?*/?>



<?
/*************/ 
$NotifyIcon='';unset($arrStatusMsg);
if($values['Method']=='Credit Card'){	 
	if(!empty($values['StatusMsg'])){
		$arrStatusMsg = explode("#",$values['StatusMsg']);
		$NotifyIcon = ($arrStatusMsg[0]==1)?('notify.png'):('fail.png');
	 	echo $NotifyIcon = '<img src="' . $Config['Url'] . 'admin/images/'.$NotifyIcon.'" border="0"  onMouseover="ddrivetip(\'<center>'.stripslashes($arrStatusMsg[1]).'</center>\', 300,\'\')"; onMouseout="hideddrivetip()" >';
	}
	
}
/*************/


 if($ModifyLabel==1){
	if($values['PostToGL'] == "Yes"){
		if($values['Voided'] != "1"){	
			echo '<a href="viewCashReceipt.php?void_id='.$values['TransactionID'].'&curP='.$_GET["curP"].'" onclick="return confirmAction(this, \'Void Cash Receipt\', \''.VOID_CS_MSG.'\')" >'.$void.'</a> ';
		}else{
			echo '<span class=red>Voided</span>';
		}
	}else{ 
		if($values['OrderPaid'] != "1"){
		 	echo ' <a href="receivePayment.php?edit='.$values['TransactionID'].'&curP='.$_GET["curP"].'" >'.$edit.'</a>';
			echo '<a href="viewCashReceipt.php?del_id='. $values['TransactionID'].'&curP='.$_GET['curP'].'" onclick="return confirmDialog(this, \'Cash Receipt\')"  >'.$delete.'</a>';	 
		}else if($values['OrderPaid'] == "1"){	
			$VoidCardUrl = "receivePayment.php?void_cc_id=".$values['TransactionID']."&Action=VCard&curP=".$_GET["curP"]; 			 		 
			echo '<a href="'.$VoidCardUrl.'" onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" >'.$voidCC.'</a>';
		}
	}
}
?>


                                    </td>



				 <? if($ModifyLabel==1){ ?> 
                                    <td align="center">
                                        <?php if ($values['PostToGL'] == "No") {
								$CountCheck++;
                                        	?>
                                        	<input type="hidden"   name="orno" id="orno<?=$CountCheck?>" value="<?=(!empty($values['SaleID']))?($values['SaleID']):("")?>">
                                            <input type="checkbox" onchange="return ChangePostToGlDate();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl" value="<?php echo $values['TransactionID']; ?>">
        <?php } ?>
                                    </td>
					<? } ?>




                                </tr>



                                <?php

			
		                   
				
				 
                            } // foreach end //



} else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
<?php } ?>

                        <tr>  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryCash) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                            }
?></td>
                        </tr>
                    </table>

                </div> 


                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                
  <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">
            </td>
        </tr>
	</form>
    </table>


<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {


        $(".vSalesPayWidth").fancybox({
            'width': 1000
        });



    });

</script>
