<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        ShowHideLoader('1');
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }

    $(function() {
        $("#Post_to_GL").click(function(e) {

            var number_of_checked_checkbox = $(".posttogl:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one payment.");
                return false;
            } else {
		 ShowHideLoader('1','P');
                return true;
            }

        });
    })

    function filterLead(id)
    {
        location.href = "viewVendorPayment.php?customview=" + id;
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
	$("#SuppCode555").click(function(){
		if(LoadedFlag==0){
			LoadedFlag = 1;	
			//$("#SuppCode").empty();				
			$("#SuppCode").append('<option value="">Loading....</option>');
			var SuppCode = '<?=$_GET['SuppCode']?>';			
			var sendParam='&action=GetVendorList&SuppCode='+escape(SuppCode)+'&r='+Math.random();  
			$.ajax({
				type: "GET",
				async:false,
				url: 'ajax_pay.php',
				data: sendParam,
				success: function (responseText) {				 
					$("#SuppCode").empty();	
					$("#SuppCode").append(responseText); 					
				}
			});



			 

		}
	});

});
</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center">
    <?php if (!empty($_SESSION['mess_payment'])) {
        echo $_SESSION['mess_payment'];
        unset($_SESSION['mess_payment']);
    } ?></div>
    
    
<form action="" method="get" enctype="multipart/form-data" name="form3" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >
		<tr>
		<td>
		<select name="SuppCode" id="SuppCode" class="inputbox" >
                            <option value="">---All Vendors---</option>
                            <?php foreach($arryVendorList as $values){?>
                            <option value="<?=$values['SuppCode']?>" <?=($_GET['SuppCode']==$values['SuppCode'])?('selected'):('')?>><?=stripslashes($values['VendorName'])?></option>
                            <?php }?>                      
        </select>
                        
      <script>
$("#SuppCode").select2();
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
    
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
        <tr>
            <td align="right" valign="top">

                <? if($ModifyLabel==1){ ?>
                <div style="float:right;">
                    <input type="submit" class="button" name="Post_to_GL" id="Post_to_GL" onclick="return checkPosttoGL()" value="Post to GL" style="font-weight: normal; height: 22px;">
                </div>
		<? } ?>


                <div style="float:right; padding-right: 10px;">
                    
                    <a  href="payVendor.php" class="add">Pay Vendor</a>

<? if ($_GET['search'] != '') { ?>
                        <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
<? } ?>



<? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_vendorpayment.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
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

                                <td width="10%" class="head1" >Payment No#</td>
				                <td width="10%" class="head1" >Payment Date</td>
                                <td width="14%"  class="head1" >GL Posting Date</td>          
				                <td width="11%"   class="head1" >Posted By</td>
				 <td width="10%"   class="head1"  align="center">Amount </td>        
                                <td width="10%" align="center" class="head1"> Amount (<?= $Config['Currency'] ?>)</td>
                                <td width="12%"  align="center" class="head1">Action</td>
                               <? if($ModifyLabel==1){ ?> <td width="1%" align="center" class="head1"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheck('SelectAll', 'posttogl');" /></td><? } ?>

                            </tr>
                            

                            <?

$printcheck = '<img src="'.$Config['Url'].'admin/images/find.png" border="0"  onMouseover="ddrivetip(\'<center>Preview Check</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';
$void = '<img src="'.$Config['Url'].'admin/icons/memo.png" border="0"  onMouseover="ddrivetip(\'<center>Void</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';

                        if (is_array($arryVendorPayment) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $invAmnt = 0;$separator=0;$CountCheck=0;
                            foreach ($arryVendorPayment as $key => $values) {
                                $flag = !$flag;                              
                                $Line++;

			
				if($values['PostToGL'] == "Yes" && $separator!=1 && $CountCheck>0) {
					echo '<tr align="center"><td  colspan="8" class="selectedbg">&nbsp;</td></tr>';
					$separator=1;
				}


                                ?>


                                <tr align="left" >
                                       
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
            if ($values['PostToGLDate'] > 0)
                echo date($Config['DateFormat'], strtotime($values['PostToGLDate']));
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
  <a class="fancybox vSalesPayWidth fancybox.iframe"  href="vVendorPayment.php?view=<?=$values['TransactionID']?>" onMouseover="ddrivetip('<center>View Payment Summary</center>', 140,'')"; onMouseout="hideddrivetip()" ><strong><?=number_format($values['TotalAmount'],2)?></strong></a>
</td>
                                       

                                    <td align="center" class="head1_inner">


<? if($ModifyLabel==1){
	if($values['PostToGL'] == "Yes"){
		if($values['Voided'] != "1"){	
			echo '<a href="viewVendorPayment.php?void_id='.$values['TransactionID'].'&curP='.$_GET["curP"].'" onclick="return confirmAction(this, \'Void Vendor Payments\', \''.VOID_VP_MSG.'\')" >'.$void.'</a> ';
		}else{
			echo '<span class=red>Voided</span>';
		}
	}else{ 
		echo ' <a href="payVendor.php?edit='.$values['TransactionID'].'&curP='.$_GET["curP"].'" >'.$edit.'</a>';

		echo ' <a href="viewVendorPayment.php?del_id='.$values['TransactionID'].'&curP='.$_GET['curP'].'" onclick="return confirmDialog(this, \'Vendor Payment\')"  >'.$delete.'</a>';


	 }
}

 
if($values['Method']=='Check' && !empty($values['CheckFormat'])){
	echo ' <a class="fancybox fancybox.iframe" href="check.php?TransactionID='.$values['TransactionID'].'" >'.$printcheck.'</a>';
}

?>

 



                                    </td>


<? if($ModifyLabel==1){ ?>
                                    <td align="center">
 <?php if ($values['PostToGL'] == "No") { 
	$CountCheck++;
?>
                                            <input type="checkbox" onchange="return ChangePostToGlDate();" name="posttogl[]" id="posttogl<?=$CountCheck?>" class="posttogl" value="<?php echo $values['TransactionID']; ?>">
        <?php } ?>
                                    </td>

<? } ?>




                                </tr>



                                <?php
                               
                            } // foreach end //
                            ?>

                        <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
                                <?php } ?>

                        <tr>  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryVendorPayment) > 0) { ?>
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
    </table>
</form>    


<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {


        $(".vSalesPayWidth").fancybox({
            'width': 1000
        });



    });

</script>
