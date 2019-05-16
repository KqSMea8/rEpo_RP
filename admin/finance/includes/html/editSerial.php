<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }
    
    
 $(document).ready(function(){
     
        $("#AddSerialNumber").click(function(){

            var allSerialNo = $.trim($("#allSerialNo").val());
            var lineNumber = $("#lineNumber").val();
            var totalQtyInvoced = $("#totalQtyInvoced").val();
             var resSerialNo = allSerialNo.split("\n");
             var seriallength = resSerialNo.length;      
             
              if(totalQtyInvoced == ""){
                     alert("Please Enter Invoice Qty.");
                        return false;
                     
                 }
                 
             if(allSerialNo == "")
                    {
                        alert("Please Enter Serial Number.");
                        $("#allSerialNo").focus();
                        return false;
                    }
                
                 /*if(seriallength > totalQtyInvoced || seriallength < totalQtyInvoced)   
                     {
                         alert("You can generate only "+totalQtyInvoced+" serial number.");
                         return false;
                     }*/
                     
                 if(seriallength > 0)   
                     { var flagDup = 0;
                        for(var i=0;i<seriallength;i++){
                              for (j = i + 1; j < seriallength; j++) {             
                                if (resSerialNo[i] != "") {
                                    if (resSerialNo[i] == resSerialNo[j]) {
                                        flagDup = 1;
                                        break;
                                    } 

                                    
                                }
                            }

                    }
                     //return false;
             }
             
             if(flagDup > 0)
                 {
                      alert("Serial number Contained Duplicate value .Please enter Unique Serial number.");
                       return false;
                 }
           
            var SendParam = 'allSerialNo=' + escape(allSerialNo) +'&action=checkSerialNumber&r='+Math.random(); 
             
                        $.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) {
				if(responseText != "")
                                    {
                                        alert("Serial Number "+responseText+" Already Exists.");
                                        return false;
                                    }else{
                                       
                                        window.parent.document.getElementById("serial_value"+lineNumber).value = resSerialNo;
                                        parent.$.fancybox.close();
                                    }
				
			}
                        
                      });	


                });
            });     

</script>


<div class="had">
    Serial Number For SKU - <?=$_GET['sku']?>


</div>
<?php if (!empty($_SESSION['mess_Serial'])) { ?>
    <div class="redmsg" align="center"> <? echo $_SESSION['mess_Serial'];
    $dis = 1;
    ?></div>
    <? unset($_SESSION['mess_Serial']);
}
?>

<form name="addItemSerailNumber" id="addItemSerailNumber"  action=""  method="post" onSubmit="return validateI(this);"  enctype="multipart/form-data">
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
     
          <tr>
                   
                     <td align="left" valign="top" width="250px">
                         Total Serial Number: <?=$_GET['TotalSerial']?><br>
                         Total Qty invoiced: <?php if($_GET['QtyInvoiced'] > 0){echo $_GET['QtyInvoiced'];}else{echo "0";}?><br>
                         Available Serial Number: <?=$_GET['NumSerial']?><br>
                         Qty to Invoice: <?=$_GET['total']?><br>
                         <textarea name="allSerialNo" type="text" class="textarea" style="height: 250px; width: 275px;" id="allSerialNo"></textarea>
                         <input type="hidden" name="lineNumber" id="lineNumber" value="<?=$_GET['id']?>">
                         <input type="hidden" name="totalQtyInvoced" id="totalQtyInvoced" value="<?=$_GET['total']?>">
                    </td>
                    <td align="left" valign="top"></td>
                </tr>
        <tr>
        <td align="center" colspan="2">
                <input type="button" name="submit" id="AddSerialNumber" value="Add Serial Number"  class="button"/>
        </td>
        </tr>
   
</table>
 </form>