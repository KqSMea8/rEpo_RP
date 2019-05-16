<?
/************************/
if($objConfigure->getSettingVariable('SO_SOURCE')==1){
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],2)==1){
		$EcomFlag=1;
	}
}

/******CODE FOR POST TO GL******************************/
if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) { 
	CleanPost();
	foreach($_POST['posttogl'] as $TransactionID){
		
		/*****************
		$ContraTransactionID = $objBankAccount->GetContraID($TransactionID);
		if(empty($ContraTransactionID)){
			$ContraTransactionID = $objBankAccount->GetContraIDReverse($TransactionID);
		}
		if($TransactionID>0 && $ContraTransactionID>0){
			$TransactionID = $TransactionID.','.$ContraTransactionID;
		}
		/*****************/


		if($EcomFlag==1){ 
			$objTransaction->RefundOnAmazonEbay($Prefix,$TransactionID,$_POST['PostToGLDate']);		 
		}
		
		 
		$objBankAccount->TransactionPostToGL($TransactionID,$_POST['PostToGLDate']);  

		$objTransaction->PostToGainLoss($TransactionID,$_POST['PostToGLDate'],'AR');	
		
		$objReport->TransactionPostForVendorCommission($TransactionID, $_POST['PostToGLDate']);
	}
	$_SESSION['mess_payment'] = AR_POSTED_TO_GL_AACOUNT;
	header("Location:" . $RedirectURL);
	exit;
}
/********END CODE********************************/
unset($_GET['TransactionID']);
unset($_GET['ContraID']);

$_GET['PostToGL'] = 'No';
$_GET['PaymentType'] = 'Sales';
$arryCash = $objBankAccount->ListCashReceipt($_GET);
$num = $objBankAccount->numRows();

?>
<script language="JavaScript1.2" type="text/javascript">
$(function() {
        $("#Post_to_GL").click(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one cash receipt.");
                return false;
            } else {
		window.onbeforeunload = null;
		 ShowHideLoader('1','P');
                return true;
            }

        });
    })


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


<div class="borderall">
<div class="had">Unposted Cash Receipt</div>
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
   

 <tr>
            <td align="right" valign="top">
             
                <div style="float:right;">
			 <?  if($num > 0 && $ModifyLabel==1) { ?>
                    <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" onclick="return checkPosttoGL()" value="Post to GL" style="font-weight: normal; height: 22px;">
			<? } ?>
                </div>
         

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
?>
   
<input id="PostToGLDate" name="PostToGLDate" readonly="" class="datebig" value="<?=$todatdate[0]?>"  type="text" >
               
                      </td>
        </tr>
        <tr>
            <td  valign="top">



                <div id="prv_msg_div" style="display:none">
                    <img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >

                              <td width="20%"  class="head1" >Cash Receipt No#</td>
                           
                                <td   class="head1" >Cash Receipt Date</td>
                      
                                <td  width="20%" class="head1">Posted By</td>
				 <td width="10%"   class="head1"  align="center">Amount </td>                 
                                <td width="15%" align="center" class="head1">Amount (<?= $Config['Currency'] ?>)</td>
                      
                             
                               <? if($ModifyLabel==1){ ?> 
			 <td width="10%"  align="center" class="head1">Action</td>
			 <td width="5%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td>
				<? } ?>
                            </tr>


                            <?
                        
                   
                        $history = '<img src="' . $Config['Url'] . 'admin/images/history.png" border="0"  onMouseover="ddrivetip(\'<center>View Cash History</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';
						$CountCheck=0;
                        if (is_array($arryCash) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $invAmnt = 0;
                            foreach ($arryCash as $key => $values) {
                                $flag = !$flag;
                               
                                $Line++;
                                ?>

 
                                <tr align="left"  >
                                       
                                        <td height="20">
                                        <? echo $values["ReceiptID"];    ?>
                                        </td>


 <td >
 
 <?
if ($values["PaymentDate"] > 0) {
     echo date($Config['DateFormat'], strtotime($values["PaymentDate"]));
 } else {
     echo NOT_SPECIFIED;
 }
 ?>
 </td>
                                        
<td>
 <?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  </td>


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
                                    

					 <? if($ModifyLabel==1){ ?>
<td align="center" class="head1_inner">
                     
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

if($values['OrderPaid'] != "1"){
	echo ' <a href="receivePayment.php?edit='.$values['TransactionID'].'&curP='.$_GET["curP"].'" >'.$edit.'</a>';

	echo '<a href="receivePayment.php?del_id='.$values['TransactionID'].'&curP='.$_GET['curP'].'" onclick="return confirmDialog(this, \'Cash Receipt\')"  >'.$delete.'</a>';
}else if($values['OrderPaid'] == "2"){				 		 
	#echo '<a href="'.$VoidCardUrl.'" class="grey_bt"  onclick="return confirmAction(this, \'Void Credit Card\', \''.VOID_CARD.'\')" >Void Credit Card</a>';
			 
}
?>


                    </td>




                                     <td align="center">
                                        <? $CountCheck++; ?>
                                        	 
                                            <input type="checkbox" onchange="return ChangePostToGlDate();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl" value="<?=$values['TransactionID']?>">
      
                                    </td>
					<? } ?>

                                </tr>



                                <?php
                                 
                            } // foreach end //
                            ?>

                        <?php  } else { ?>
                            <tr align="center" >
                                <td  colspan="10" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
                                <?php } ?>

                        <tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>  

</td>
                        </tr>
                    </table>

                </div> 

 <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">


            </td>
        </tr>
    </table>
</form> 
</div>
<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {


        $(".vSalesPayWidth").fancybox({
            'width': 1000
        });



    });

</script> 
