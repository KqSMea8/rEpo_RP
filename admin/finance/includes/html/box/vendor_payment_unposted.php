<?
 
(empty($_GET['tran']))?($_GET['tran']=""):("");

/******CODE FOR POST TO GL*************/
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
		   
		 
		$objBankAccount->TransactionPostToGL($TransactionID,$_POST['PostToGLDate']); 
	
		$objTransaction->PostToGainLoss($TransactionID,$_POST['PostToGLDate'],'AP');
		$objConfig->CreateAPInvoiceForStandAloneFreight($TransactionID, 'VendorPayment', $_POST['PostToGLDate']);
		 	  
	}
	$_SESSION['mess_payment'] = AP_POSTED_TO_GL_AACOUNT;
	header("Location:payVendor.php");
	exit;
}
/********END CODE****************/
/******CODE FOR MoveBatch*************/
if(!empty($_POST['MoveBatch']) && !empty($_POST['posttogl'])) { 
	CleanPost();	
	$objCommon->MoveCheckToBatch($_POST['MoveBatch'],$_POST['posttogl']); 		
	$_SESSION['mess_payment'] = BATCH_MOVED;
	header("Location:payVendor.php?tran=C");
	exit;
}
/********END CODE****************/

unset($_GET['TransactionID']);
unset($_GET['ContraID']);
$_GET['PostToGL'] = 'No';
$_GET['PaymentType'] = 'Purchase';
$arryPaymentInvoice = $objBankAccount->ListVendorPayment($_GET);
$num = $objBankAccount->numRows();

/*$pagerLink = $objPager->getPager($arryPaymentInvoice, $RecordsPerPage, $_GET['curP']);
(count($arryPaymentInvoice) > 0) ? ($arryPaymentInvoice = $objPager->getPageRecords()) : ("");*/

$arryBatch = $objCommon->GetBatch('', '0');
$NumBatch = sizeof($arryBatch);	
?>
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

	$("#MoveBatch").change(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) {
		$('#MoveBatch').val('');  
                alert("Please select atleast one record to move.");
                return false;
            } else {
		window.onbeforeunload = null;
		document.formBottom.submit();  
		 ShowHideLoader('1','P');
                return true;
            }

        });


    })


function ShowPostToGlMove() {	
    	var Type = $('#TransType').val();  
	if(Type=='C' && document.getElementById("MoveBatch") != null){	
		document.getElementById("movebatchrow").style.display = '';  	 
	}else{
		document.getElementById("movebatchrow").style.display = 'none';  	

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
    	
  }
function SelectCheck(MainID,ToSelect)
{	
	var flag,i;	
	if(document.getElementById(MainID).checked){
		flag = true;
	}else{
		flag = false;
	}	

	var Type = $('#TransType').val();  
	if(Type=='C'){	
		$('.check').prop('checked', flag);   	
		$('.uncheck').prop('checked', false);   	
	}else{   
		$('.posttogl').prop('checked', flag);   			
	}
	ShowPostToGlMove();
}



function getTransactionList(Type){
	$('.posttogl').prop('checked', false);   
	$('#SelectAll').prop('checked', false); 
	$('#gldaterow').hide(); 
	$('#TransType').val(Type);  
	 
	if(Type=='C'){
		$('#tab_c').attr('class', 'grey_bt');		
		$('#tab_all').attr('class', 'white_bt');		 
		$(".tr_check").show();	
		$(".tr_uncheck").hide();
		$(".movedbatch").show();			
	}else{
		$('#tab_all').attr('class', 'grey_bt');
		$('#tab_c').attr('class', 'white_bt');			 
		$(".tr_check").show();	
		$(".tr_uncheck").show();
		$(".movedbatch").hide();		
	}

	ShowPostToGlMove();	
	 
}

function SetMoveBatch(){             
		var checkedFlag = 0;
		var ids = '';
		var TotalRecords = document.getElementById("NumField").value;
		var MoveBatch = document.getElementById("MoveBatch").value;
          
		if(TotalRecords > 0 && MoveBatch!=''){
				for(var i=1;i<=TotalRecords;i++){
					if(document.getElementById(ToSelect+i).checked==true){
						if(checkedFlag == 0){
							checkedFlag = 1;
						}						
					}
				}
                                                

				if(checkedFlag == 0){
					alert("You must select atleast one record.");  
					document.getElementById("RowColor").value=''; 
	                                   
				}else{				
					ShowHideLoader(1,'P');
					document.form1.submit();  
					return true;			

				}
		}
			
}

</script>


<div class="borderall">

<form action="" method="post" name="formBottom">
  

    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
   

 <tr>
            <td align="left" valign="top">                           
                  <div class="had">Unposted <?=$MainModuleName?> </div> 

            </td>
        </tr>  
<tr id="gldaterow"  style="display:none">
                         
 <td align="right" valign="top">

 


<span class="posttogl">Post to GL Date: </span><script>
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
               
                  
 &nbsp;&nbsp;&nbsp;&nbsp;  <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" onclick="return checkPosttoGL()" value="Post to GL"  >
          
              
                      </td>
        </tr>

<tr id="movebatchrow"  style="display:none" align="right" >
<td>
 <?
if($NumBatch>0){
	$BatchDropDown = '<select name="MoveBatch" id="MoveBatch" class="textbox" ><option value="">--- Move to Batch ---</option>';
	foreach($arryBatch as $key=>$values){ 
	    $BatchDropDown .=  '<option value="' .$values["BatchID"] . '" >' .stripslashes($values["BatchName"]).'</option>';
	}
	$BatchDropDown .=  '</select>'; 
	echo $BatchDropDown; 
}
?>   
	

   </td>

  </tr>

        <tr>
            <td  valign="top">


 
                   
            


<?
if($num>0){
	if($_GET['tran']=='C'){
		$cls_all = 'white_bt';
		$cls_c = 'grey_bt';
	}else{
		$cls_all = 'grey_bt';
		$cls_c = 'white_bt';
	
	}
?>     
  
   
 <a href="Javascript:void(0);" id="tab_all" class="<?=$cls_all?>" style="float:left;border-bottom:none;width:60px;" onclick="Javascript:getTransactionList('');"><strong>All</strong></a> <a href="Javascript:void(0);" id="tab_c"  class="<?=$cls_c?>" style="float:left;border-bottom:none;60px;" onclick="Javascript:getTransactionList('C');"><strong>Checks</strong></a>  
<input type="hidden" name="TransType" id="TransType" value="<?=$_GET['tran']?>" readonly>
<div style="clear:both"></div> 
<? } ?>
                    <table <?= $table_bg ?>>

                            <tr align="left"  >

                                <td width="20%" class="head1" >Payment No#</td>
				                <td   class="head1" >Payment Date</td>
                                <td  width="20%" class="head1">Posted By</td>
				 <td width="13%"   class="head1"  align="center">Amount </td>      
                                <td width="13%" align="center" class="head1">Amount (<?= $Config['Currency'] ?>)</td>
                                <!--  <td width="14%"  align="center" class="head1">Payment Status</td>-->
                               
                               <? if($ModifyLabel==1){ ?>  
				 <td width="10%"  align="center" class="head1">Action</td>
<td width="1%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td>
                              	<? } ?>
                            </tr>


                            <?
                        
$printcheck = '<img src="'.$Config['Url'].'admin/images/find.png" border="0"  onMouseover="ddrivetip(\'<center>Preview Check</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >'; 
$CountCheck = 0;                
                        if (is_array($arryPaymentInvoice) && $num > 0) {
                            $flag = true;
                            
                            $invAmnt = 0;
                            foreach ($arryPaymentInvoice as $key => $values) {
                                $flag = !$flag;
                                                             
 				$CountCheck++;

				$MovedBatch = '';
				if($values['Method']=='Check' && !empty($values['CheckFormat'])){
					$CheckClass= 'check';
					$PrintCheckLink = ' <a class="fancybox fancybox.iframe" href="check.php?TransactionID='.$values['TransactionID'].'" >'.$printcheck.'</a>';
					if($values['BatchID']>0){
						$MovedBatch = 'Moved';
					}
				}else{
					$CheckClass= 'uncheck';
					$PrintCheckLink = '';					
				}


                                ?>


                                <tr align="left"   class="tr_<?=$CheckClass?>">
                                       
                                       
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
	<?
if(!empty($values['OriginalAmount'])){
	echo number_format($values['OriginalAmount'],2)." ".$values['ModuleCurrency'];
}
?>

</td>
                         

<td align="center">
  <a class="fancybox vSalesPayWidth fancybox.iframe"  href="vVendorPayment.php?view=<?=$values['TransactionID']?>" onMouseover="ddrivetip('<center>View Payment Summary</center>', 140,'')"; onMouseout="hideddrivetip()" ><strong><?=number_format($values['TotalAmount'],2)?></strong></a>
</td>

      
  <td align="center" class="head1_inner">



<? if($ModifyLabel==1){
	echo ' <a href="payVendor.php?edit='.$values['TransactionID'].'" >'.$edit.'</a>';
	
	echo ' <a href="payVendor.php?del_id='.$values['TransactionID'].'" onclick="return confirmDialog(this, \'Vendor Payment\')"  >'.$delete.'</a>';
  }

 echo $PrintCheckLink;
 echo '<div class="movedbatch green">'.$MovedBatch.'<div>';
?>





                                    </td>



                                
                                    <td align="center">
 
                                            <input type="checkbox" onchange="return ShowPostToGlMove();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl <?=$CheckClass?>" value="<?php echo $values['TransactionID']; ?>">
 

      
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
 
</td>
                        </tr>
                    </table>

            

 <input type="hidden" name="CountCheck" id="CountCheck" value="<?php echo $CountCheck; ?>">


            </td>
        </tr>
    </table>
</form>  
</div>
 
<script language="JavaScript1.2" type="text/javascript">
getTransactionList('<?=$_GET["tran"]?>');
</script> 
 


<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {


        $(".vSalesPayWidth").fancybox({
            'width': 1000
        });



    });

</script> 

