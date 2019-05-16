<style>
	.showTr{	
	}
	.hideTr{
		display:none;
	}
	.expandrow{
		cursor:pointer;
	}
</style>
<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<script language="JavaScript1.2" type="text/javascript">


	/*$("body").on('click',".salespymenttr",function(){
		var invoiceId = this.id;
		var currenttr =  ".tr"+"_"+invoiceId;
		var checkFlow = $(this).attr('data-flow');
		if(checkFlow=="hide"){
		     $("[id="+invoiceId+"]").show();
		     $(this).attr('data-flow',"show");
		     $(this).html('-');
		}else{
			 $("[id="+invoiceId+"]").hide();
		     $(this).attr('data-flow',"hide");
			 $(this).show();
			 $('.salespymenttr').parents('tr').closest(currenttr).show();
			  $(this).html('+');
		}
	});*/








    function ValidateSearch() {
	ShowHideLoader(1,'F');
	return true;        
    }






    /*$(document).ready(function(){
     $("#SelectAll").click(function(){
     var flag,i;
     if($("#SelectAll").prop("checked") == true){
     flag = true;
     }else{
     flag = false;
     }
     var totalCheckboxes = $('input:checkbox').length;
     for(i=1; i<=totalCheckboxes; i++){
     document.getElementById('OrderID'+i).checked=flag;
     }
     });
     });*/



$(function() {
	$(".expandrow").click(function(){
		var TrID = this.id;
		var OrderID = $(this).attr('data-flow');
		var imgSrc = $(this).attr('src');
 
		if(imgSrc=='../images/plus.png'){
			$(this).attr('src','../images/minus.png');  
		}else{
			$(this).attr('src','../images/plus.png');  
		}
		 $(".cls"+OrderID).toggle();   
     });
        
});










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
        location.href = "viewSalesPayments.php?customview=" + id;
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


    function toggle_it(itemID)
    { 
      
        if ((document.getElementById(itemID).style.display == 'none')) 
            { 
              document.getElementById(itemID).style.display = '' 
              event.preventDefault()
            }
         else 
             { 
              document.getElementById(itemID).style.display = 'none'; 
              event.preventDefault()
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

<div class="had"><?= $MainModuleName ?></div>
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
                    <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" onclick="return checkPosttoGL()" value="Post to GL" style="font-weight: normal; height: 22px;">
                </div>
                <div style="float:right; padding-right: 10px;">
                   
                    <a  href="receivePayment.php" class="add">Receive Payment</a>
                </div>
		<? } ?>

<? if ($_GET['search'] != '') { ?>
                <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
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
                                     <td width="17%"  class="head1" >Invoice/GL/Credit Memo #</td>
                                <td width="10%" class="head1" >Payment Date</td>
                                 <td width="10%" class="head1" >Post to GL Date</td>
                               
                                <td width="10%"   class="head1" >SO/Reference #</td>
                                <td   class="head1">Customer</td>
                                <td width="10%" align="center" class="head1">Amount (<?= $Config['Currency'] ?>)</td>
                                <td width="11%"  align="center" class="head1">Payment Status</td>
                                <td width="13%"  align="center" class="head1">Action</td>
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


                        if (is_array($arrySale) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $invAmnt = 0;
				$classCount=0;
                            foreach ($arrySale as $key => $values) {
                                $flag = !$flag;
                               
                                $Line++;


                                #$CustomerName = $objBankAccount->getCustomerName($values['CustCode']);

				if($values['PostToGL'] == "Yes" && $separator!=1 && $CountCheck>0) {
					echo '<tr align="center"><td  colspan="9" class="selectedbg">&nbsp;</td></tr>';
					$separator=1;
				}


				/***********************/
				/***********************/ 
				$RowPlus='';$rowClass='';$invHide = '';
				if($_GET['sortby'] == '' && $values['PostToGL'] == "Yes" && $values["InvoiceID"]!=''){
					$arryOrder[$values["OrderID"]][] = $values["OrderID"];

					 if(sizeof($arryOrder[$NewOrderID])==1){ ?>
					<script>$("#row"+<?=$NewOrderID?>).hide();</script>	 
					<? }					
					
					if($NewOrderID!=$values["OrderID"]){						
						$RowPlus = '<img class="expandrow" id="row'.$values["OrderID"].'" data-flow="'.$values["OrderID"].'" src="../images/plus.png">';						$classCount='0';
					}else{
						$RowPlus = '&nbsp;';
						$rowClass = 'class="cls'.$values["OrderID"].' hideTr"';
						$invHide = 'hideTr';
						$classCount++;
					}
				}
				/***********************/
				/***********************/

                                ?>

      

                                <tr align="left"  <?=$rowClass?> >
                                        <? if ($_GET["customview"] == 'All') { ?>


		 <td >

					<? 
					//echo $values["OrderID"];
					if(!empty($values["InvoiceID"])){
						echo $RowPlus;
					?>
                                            <a href="vInvoice.php?pop=1&amp;view=<?= $values['OrderID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" class="fancybox <?=$invHide?> vSalesPayWidth fancybox.iframe"><?=$values["InvoiceID"]?></a> 
					<? }else if(!empty($values["GLID"])){ 
						echo $values["AccountNameNumber"];
					}else if(!empty($values["CreditID"])){ 
						echo $values["CreditID"];
					} ?>
                                        </td>
  
                                        <td height="20">
                                            <?
                                            if ($values['PaymentDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['PaymentDate']));
                                            ?>

                                        </td>
                                          <td height="20">
                                            <?
                                            if ($values['PostToGLDate'] > 0)
                                                echo date($Config['DateFormat'], strtotime($values['PostToGLDate']));
                                            ?>

                                        </td>
                                       
                                        <td >
                                            <?php if ($values['InvoiceEntry'] == '1') { ?>
                                                <a href="vInvoice.php?pop=1&amp;view=<?= $values['OrderID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" class="fancybox vSalesPayWidth fancybox.iframe"><?= $values['SaleID'] ?></a> 
            <?php } else { ?>
                                                <a href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?= $values['SaleID'] ?>" class="fancybox vSalesPayWidth fancybox.iframe"><?= $values['SaleID'] ?></a>
            <?php } ?>

                                        </td>
                                        <td><a class="fancybox fancybox.iframe" href="../custInfo.php?CustID=<?= $values['CustID'] ?>" ><?=stripslashes($values['CustomerName']) ?></a></td>

                                        <td align="center">

<strong><?=($values["GLID"]>0 && $values['NegativeFlag']==1)?("-"):("")?><?=number_format($values['DebitAmnt'],2)?></strong></td>
                                        <td align="center">
                                            <? 
				if(!empty($values["InvoiceID"])){
                                            if ($values['InvoicePaid'] == 'Paid') {
                                                $StatusCls = 'green';
                                                $InvoicePaid = "Paid";
                                            } else {
                                                $StatusCls = 'red';
                                                $InvoicePaid = "Partially Paid";
                                            }

                                            echo '<span class="' . $StatusCls . '">' . $InvoicePaid . '</span>';
				}
                                            ?>


                                        </td>
                                        <?
                                    } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'PaymentDate') {

                                                if ($values[$cusValue['colvalue']] > 0) {
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                                } else {
                                                    echo NOT_SPECIFIED;
                                                }
                                            } elseif ($cusValue['colvalue'] == 'InvoicePaid') {
                                                if ($values[$cusValue['colvalue']] == 'Paid') {
                                                    $StatusCls = 'green';
                                                    $InvoicePaid = "Paid";
                                                } else {
                                                    $StatusCls = 'red';
                                                    $InvoicePaid = "Partially Paid";
                                                }

                                                echo '<span class="' . $StatusCls . '">' . $InvoicePaid . '</span>';
                                            } else {
                                                ?>

                                                <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                                            <?
                                            }
                                            echo '</td>';
                                        }
                                    }
                                    ?>
                                    <td align="center" class="head1_inner">

<? if(!empty($values["InvoiceID"])){ ?>

	<a href="receiveInvoiceHistory.php?edit=<?= $values['OrderID'] ?>&InvoiceID=<?= $values['InvoiceID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" target="_blank"><?=$history?></a>

	<a href="pdf_case_reciept.php?o=<?= $values['OrderID'] ?>&InvoiceID=<?= $values['InvoiceID'] ?>&IE=<?= $values['InvoiceEntry'] ?>"><?=$download?></a>
	<a class="fancybox fancybox.iframe" href="<?=$SendUrl.'&view='.$values['OrderID']?>&ID=<?= $values['PaymentID']?>&InvoiceID=<?= $values['InvoiceID'] ?>&IE=<?= $values['InvoiceEntry'] ?>" ><?=$sendemail?></a>

<? }


if($ModifyLabel==1 && $values['PostToGL'] == "No"){?>

	<? 	
	if($values['TransactionID']>0){
		if($objTransaction->isTransactionDataExist($values['TransactionID'])){
			echo ' <a href="receivePayment.php?edit='.$values['TransactionID'].'&curP='.$_GET["curP"].'" >'.$edit.'</a>';
		}
	}?>

 <a href="viewSalesPayments.php?del_payment=<?php echo $values['PaymentID']; ?>&amp;curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, 'Payment')"  ><?=$delete?></a>
<?}?>


                                    </td>



				 <? if($ModifyLabel==1){ ?> 
                                    <td align="center">
                                        <?php if ($values['PostToGL'] == "No") {
												$CountCheck++;
                                        	?>
                                        	<input type="hidden"   name="orno" id="orno<?=$CountCheck?>" value="<?=$values['SaleID']?>">
                                            <input type="checkbox" onchange="return ChangePostToGlDate();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl" value="<?php echo $values['PaymentID']; ?>#<?= $values['SaleID'] ?>#<?= $values['InvoiceEntry'] ?>">
        <?php } ?>
                                    </td>
					<? } ?>




                                </tr>



                                <?php

			
		                        if($values["InvoiceID"]!=''){
						$NewOrderID = $values['OrderID'];
					}
				
				 
                            } // foreach end //


	if(sizeof($arryOrder[$NewOrderID])==1){
?>
<script>$("#row"+<?=$NewOrderID?>).hide();</script>

<? 
	}



} else { ?>
                            <tr align="center" >
                                <td  colspan="10" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
<?php } ?>

                        <tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arrySale) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
                            }
?></td>
                        </tr>
                    </table>

                </div> 


                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
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
