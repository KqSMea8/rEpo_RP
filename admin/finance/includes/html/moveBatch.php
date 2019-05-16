<script language="JavaScript1.2" type="text/javascript">
$(function() {
        $("#MoveToBatch").click(function(e) {

            var number_of_checked_checkbox = $(".TransactionID:checked").length;
            if (number_of_checked_checkbox == 0) {
                alert("Please select atleast one record to move.");
                return false;
            } else {		 
		LoadSearch();
                return true;
            }

        });
    })




function LoadSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
</script>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>
<div class="borderall">
<div class="had">Move Checks to Batch :   <br>
<?php
	echo stripslashes($arryBatch[0]['BatchName']); 
	if(!empty($arryBatch[0]['Description'])){
		echo ' ['.stripslashes($arryBatch[0]['Description']).']';
	}

?> 


 </div>
 

<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">
<form action="" method="post" name="form1">
    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
   

 <tr>
            <td align="left" valign="top">
             
              
                    <input type="submit" class="button" name="MoveToBatch" id="MoveToBatch"  value="Move" >
              	
         

            </td>
        </tr>  

        <tr>
            <td  valign="top">

 
 <? 
$CheckBox=1;
include("includes/html/box/vendor_payment_list.php"); 
?>
 

            </td>
        </tr>
    </table>
</form>  
</div>
 </div>


<? } ?>

