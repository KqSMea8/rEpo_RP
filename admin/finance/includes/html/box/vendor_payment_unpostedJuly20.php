<script language="JavaScript1.2" type="text/javascript">
$(function() {
        $("#Post_to_GL").click(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one payment.");
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

<?
/******CODE FOR POST TO GL******************************/
if (!empty($_POST['Post_to_GL']) && !empty($_POST['posttogl'])) { 
	CleanPost();
	foreach($_POST['posttogl'] as $TransactionID){
		$ContraID = 0;
		$ContraID = $objBankAccount->GetContraID($TransactionID);  
		if($ContraID>0){
			$TransactionID = $TransactionID.','.$ContraID;
		}		 
		$objBankAccount->TransactionPostToGL($TransactionID,$_POST['PostToGLDate']); 
	
		  
	}
	$_SESSION['mess_payment'] = AP_POSTED_TO_GL_AACOUNT;
	header("Location:payVendor.php");
	exit;
}
/********END CODE********************************/


$_GET['PostToGL'] = 'No';
$arryPaymentInvoice = $objBankAccount->ListVendorPayment($_GET);
$num = $objBankAccount->numRows();

/*$pagerLink = $objPager->getPager($arryPaymentInvoice, $RecordsPerPage, $_GET['curP']);
(count($arryPaymentInvoice) > 0) ? ($arryPaymentInvoice = $objPager->getPageRecords()) : ("");*/

?>
<div class="borderall">
<div class="had">Unposted <?=$MainModuleName?> </div>
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
   

 <tr>
            <td align="right" valign="top">
             
                <div style="float:right;">
                    <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" onclick="return checkPosttoGL()" value="Post to GL" style="font-weight: normal; height: 22px;">
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
//echo $todatdate[0];exit;

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

                                <td width="20%" class="head1" >Payment No#</td>
				                <td   class="head1" >Payment Date</td>
                                <td  width="20%" class="head1">Posted By</td>
                                <td width="15%" align="center" class="head1">Amount (<?= $Config['Currency'] ?>)</td>
                                <!--  <td width="14%"  align="center" class="head1">Payment Status</td>-->
                               
                               <? if($ModifyLabel==1){ ?>  
				 <td width="10%"  align="center" class="head1">Action</td>
<td width="1%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td>
                              	<? } ?>
                            </tr>


                            <?
                        
    $printcheck = '<img src="'.$Config['Url'].'admin/images/print.png" border="0"  onMouseover="ddrivetip(\'<center>Print Check</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';                    
                        if (is_array($arryPaymentInvoice) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $invAmnt = 0;
                            foreach ($arryPaymentInvoice as $key => $values) {
                                $flag = !$flag;
                                
                                $Line++;
 
                                ?>


                                <tr align="left"   >
                                       
                                       
                                        <td height="20">
                                        <? echo $values["ReceiptID"];    ?>
                                        </td>
                                       
                                        <td height="20">
                                            <?
                                            if ($values['PaymentDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
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
  <a class="fancybox vSalesPayWidth fancybox.iframe"  href="vVendorPayment.php?view=<?=$values['TransactionID']?>" onMouseover="ddrivetip('<center>View Payment Summary</center>', 140,'')"; onMouseout="hideddrivetip()" ><strong><?=number_format($values['TotalAmount'],2)?></strong></a>
</td>

      
  <td align="center" class="head1_inner">



<? if($ModifyLabel==1 && $values['PostToGL'] == "No"){
	echo ' <a href="payVendor.php?edit='.$values['TransactionID'].'" >'.$edit.'</a>';
	
	echo ' <a href="payVendor.php?del_id='.$values['TransactionID'].'" onclick="return confirmDialog(this, \'Vendor Payment\')"  >'.$delete.'</a>';
  }

if($values['Method']=='Check' && !empty($values['CheckFormat'])){
	echo ' <a class="fancybox fancybox.iframe" href="check.php?TransactionID='.$values['TransactionID'].'" >'.$printcheck.'</a>';
}
?>





                                    </td>



                                
                                    <td align="center">
 <?php if ($values['PostToGL'] == "No") { 
	$CountCheck++;
?>
                                            <input type="checkbox" onchange="return ChangePostToGlDate();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl" value="<?php echo $values['TransactionID']; ?>">
        <?php } ?>
                                    </td>

                                </tr>



                                <?php
                                 
                            } // foreach end //
                            ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="7" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
                                <?php } ?>

                        <tr>  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>  
<!--
    <?php if (count($arryPaymentInvoice) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                                }
                                ?>
-->
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

