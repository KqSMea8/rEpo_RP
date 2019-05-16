<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }


    $(document).ready(function() {

        $("#AddSerialNumber").click(function() {
            
             //var allSelectedSerialNumber = document.getElementById("allSelectedSerialNumber").value;
              //allSelectedSerialNumber = allSelectedSerialNumber.replace(/,$/,"");
            //alert(allSelectedSerialNumber);
            var allSerialNo = $.trim($("#allSerialNo").val());
            var lineNumber = $("#lineNumber").val();
            var totalQtySerial = $("#totalQtySerial").val();
            var resSerialNo = allSerialNo.split("\n");
            
            //alert(allSerialNo);
            
            resSerialNo = resSerialNo.filter(function(e) { return e; });
            
            var seriallength = resSerialNo.length;
           

            if (totalQtySerial == "") {
                alert("Please Enter Invoice Qty.");
                return false;

            }

            if (allSerialNo == "")
            {
                alert("Please Enter Serial Number.");
                //document.getElementById("msg").innerHTML = "Please Enter Serial Number.";
                $("#allSerialNo").focus();
                return false;
            }

            if (seriallength > totalQtySerial || seriallength < totalQtySerial)
            {
                //document.getElementById("msg").innerHTML = "You can generate only " + totalQtySerial + " serial number.";
                alert("You can generate only " + totalQtySerial + " serial number.");
                return false;
            }

            if (seriallength > 0)
            {
                var flagDup = 0;
                for (var i = 0; i < seriallength; i++) {
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

            if (flagDup > 0)
            {
                alert("Serial number Contained Duplicate value .Please enter Unique Serial number.");
                return false;
            }

            var SendParam = 'allSerialNo=' + escape(allSerialNo) + '&action=checkSerialNumber&r=' + Math.random();

            $.ajax({
                type: "GET",
                async: false,
                url: 'ajax.php',
                data: SendParam,
                success: function(responseText) {
                    if (responseText != "")
                    {
                        
                        
                        //document.getElementById("msg").innerHTML = "Serial Number " + responseText + " Already Exists.";
                        alert("Serial Number " + responseText + " Already Exists.");
                        $("#allSerialNo").highlight(responseText , { wordsOnly: true });
                        return false;
                    } else {

                        window.parent.document.getElementById("serial_value" + lineNumber).value = resSerialNo;
                        parent.$.fancybox.close();
                    }

                }

            });


        });
    });

</script>
<style>
    .multiSelectBox{
         /*background-color: whitesmoke;margin-bottom: 1px;*/ 
         border-bottom: 1px solid #CCCCCC; 
         height: 18px;  
         padding: 5px 0 2px 3px;
         cursor: pointer;
         
    }
    .multiSelectBox:hover {
            background-color: whitesmoke;
           } 
</style>
<?php if(empty($_GET['sku'])){?>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
 <tr>
                   
<td align="left" class="red" align="center" style=" font-size: 14px;font-weight: bold;padding: 30px;">
<?=ENTER_QTY_RECEIVE?>
</td>
</tr>
</table>

<?php } else {?>
<div class="had">
    Serial Number For SKU - <?= $_GET['sku'] ?>


</div>
<?php if (!empty($_SESSION['mess_Serial'])) { ?>
    <div class="redmsg" align="center"> <?
        echo $_SESSION['mess_Serial'];
        $dis = 1;
        ?></div>
    <?
    unset($_SESSION['mess_Serial']);
}
?>

<form name="addItemSerailNumber" id="addItemSerailNumber"  action=""  method="post" onSubmit="return validateI(this);"  enctype="multipart/form-data">
    <table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">

        <tr>

            <td align="left" valign="top" width="250px">


                Serial Qty : <?= $_GET['total'] ?><br>
                <span id="msg" class="redmsg"></span>
                <?php  $serial_value_sel = explode(",",$_GET['serial_value_sel']);
                                //$serial_value_sel=array_map('trim',$serial_value_sel);
                          ?>
                
                
                <textarea name="allSerialNo" type="text" class="textarea" style="height: 250px; width: 275px;" id="allSerialNo"><? foreach($serial_value_sel as $serial){?><? echo $serial."\n";?><? }?></textarea>
                <input type="hidden" name="lineNumber" id="lineNumber" value="<?= $_GET['id'] ?>">
                <input type="hidden" name="totalQtySerial" id="totalQtySerial" value="<?= $_GET['total'] ?>">
                <input type="hidden" name="allSelectedSerialNumber" id="allSelectedSerialNumber" value="<?=trim($_GET['serial_value_sel']);?>">
            </td>
            <td align="left" valign="top"></td>
        </tr>
        <? if($_GET['view'] != 1){?>
        <tr>
            <td align="center" colspan="2">
                <input type="button" name="submit" id="AddSerialNumber" value="Add Serial Number"  class="button"/>
            </td>
        </tr>
        <? }?>

    </table>
</form>
<?php }?>