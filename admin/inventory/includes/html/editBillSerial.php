<?php //**************************************Ganesh 4 jan ************************** ?>
<SCRIPT LANGUAGE=JAVASCRIPT>

    function ValidateForm(frm)
    {
        if (ValidateMandExcel(frm.excel_file, "Please upload sheet in excel format."))
        {

            ShowHideLoader('1', 'P');
            return true;
        } else {
            return false;
        }

    }
    </SCRIPT>
   <script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }


    $(document).ready(function() {

//$("#allSerialNo").onchnage(function() {
$("#allSerialNo").on('input',function(e){
 var allSerialNo = $.trim($("#allSerialNo").val());
 var resSerialNo = allSerialNo.split("\n");
 var lineNumber = $("#lineNumber").val();
            var totalQtySerial = $("#totalQtySerial").val();
            
          var totCont =0;

            var seriallength = resSerialNo.length;
 totCont = totalQtySerial-seriallength;
document.getElementById("cont").innerHTML = totCont;

 if (seriallength > totalQtySerial || seriallength < totalQtySerial)
            {
                document.getElementById("msg").innerHTML = "You can generate only " + totalQtySerial + " serial number.";
                //alert("You can generate only " + totalQtySerial + " serial number.");
                return false;
            }
/*if(totCont < 0){
document.getElementById("cont").innerHTML = 0;
$('#allSerialNo').prop('readonly', true);
}*/
 

});

         $("#AddSerialNumber").click(function() {
            var SerialSku = $("#SerialSku").val();
            var lineNumber = $("#lineNumber").val();
            var totalQtySerial = $("#totalQtySerial").val();

            //var allSerialNo = $("input[name^='serialNo']").map(function() {  return $.trim(this.value); }).get().filter(function(arr){if(arr) return arr;}).join(',');

var allSerialNo = $("#serialNo").val();
var Conditi = $("#Conditi").val();
var inputs = document.getElementsByClassName( 'SRNUM' ),
    names  = [].map.call(inputs, function( input ) {
        return input.value;
    }).join( '|' );
//alert(names);


	    var allserdesc = $("input[name^='description']").map(function() {  return $.trim(this.value); }).get().filter(function(arr){if(arr) return arr;
}).join('|');

 var allserPrice = $("input[name^='price']").map(function() {  return $.trim(this.value); }).get().filter(function(arr){if(arr) return arr;
}).join('|');

//var SerialUnitPrice = document.getElementById("UnitPrice").value;
//alert(allserPrice);
            var resSerialNo = names.split('|');
	
            resSerialNo = resSerialNo.filter(function(e) { return e; });
         
            var seriallength = resSerialNo.length;
         

            if (totalQtySerial == "") {
                alert("Please Enter Qty.");
                return false;
            }
            if (names == "")
            {
                alert("Please Enter Serial Number.");
                return false;
            }
//alert(totalQtySerial);
//alert(seriallength);
            if (seriallength > totalQtySerial || seriallength < totalQtySerial)
            {
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

            var SendParam = 'allSerialNo=' + escape(names) + '&allserdesc='+allserdesc+'&allserPrice='+allserPrice+'&Conditi='+Conditi+'&Sku='+SerialSku+'&action=checkSerialNumber';
//alert(SendParam);
            $.ajax({
                type: "POST",
                async: false,
                url: 'ajax.php',
                data: SendParam,
                success: function(responseText) {
//alert(responseText);
                    /*if (responseText != "")
                    {
                        alert("Serial Number " + responseText + " Already Exists.");
                        //$("#serialNo").highlight(responseText , { wordsOnly: true });
                        return false;
                    } else {*/

													window.parent.document.getElementById("serial_value" ).value = names;
													window.parent.document.getElementById("serial_Price" ).value = allserPrice;
													//if(SerialUnitPrice>0){
													//window.parent.document.getElementById("price" ).value = SerialUnitPrice;
													//}
													window.parent.document.getElementById("serial_desc" ).value = allserdesc;
													//window.parent.document.getElementById("price" ).focus();
													parent.$.fancybox.close();
													return false;
                    }

                //}

            });


        });




/*$(document).on('click', '.addmore', function(){
$( $('#serials').clone().attr( "id" ,"serials"+$(".serials").length ).append('<a style="float:right; margin:25px -20px" class="delDiv" href="javascript:;"><img src="<?php echo _SiteUrl?>/admin/images/delete.png"></a>') ).insertBefore($(this));

})*/
<? //if($_GET['edit']>0){?>
var SNB = $('#serial_value', window.parent.document).val().split('|');
//alert(SNB);
if(SNB!=''){
$('input[id^="serialNo"]').each(function(i){
	$(this).val(SNB[i]);
});

}

var SND = $('#serial_desc', window.parent.document).val().split('|');
if(SND!=''){
$('input[id^="description"]').each(function(i){
	$(this).val(SND[i]);
});
}


var SNP = $('#serial_Price', window.parent.document).val().split('|');
if(SNP!=''){
$('input[id^="price"]').each(function(i){
	$(this).val(SNP[i]);
});
}
<? //}?>

    });

</script>

<script type="text/javascript">

function check()

{

$("#checking").show();

}

</script>


<div id="import">
<div class="had" ><?= $MainModuleName ?> &raquo; <span>
        Import Serial No
    </span>
</div>

<a class="download" style="float:right" href="dwn.php?file=../upload/Excel/Serial_No.xls">Download Template</a>
<div align="center" id="ErrorMsg" class="redmsg"><br><?= $ErrorMsg ?></div>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	



    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
        <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">

            <tr>
                <td align="center"  >

                    <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">


                        <tr>
                            <td  class="blackbold" valign="top" width="45%"  align="right"> Import Serial No :<span class="red">*</span></td>
                            <td  align="left"   class="blacknormal" valign="top" height="80"><input name="excel_file" type="file" class="inputbox"  id="excel_file"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
                                <br>
                                <?= IMPORT_SHEET_FORMAT_MSG ?>
                            </td>
                        </tr>
                         <input type="hidden" name="lineNumber" id="lineNumber" value="<?= $_GET['id'] ?>">
                        <input type="hidden" name="totalQtySerial" id="totalQtySerial" value="<?= $_GET['total'] ?>">
                        <input type="hidden" name="allSelectedSerialNumber" id="allSelectedSerialNumber" value="<?=trim($_GET['serial_value_sel']);?>">
												<input type="hidden" name="SerlSku" id="SerlSku" value="<?= $_GET['sku'] ?>">
												<input type="hidden" name="Condition" id="Condition" value="">
											<input type="hidden" name="warehouse" id="warehouse" value="">
											<input type="hidden" name="AdjustID" id="AdjustID" value="">
                    </table></td>
            </tr>
            <tr><td align="center">
                    <input name="Submit" type="submit" class="button" onClick="check();" value="Upload" />

                </td></tr> 
            
        </form>
    </table>

</div>
</div>

<div id="checking" style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
<div class="text" style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
<center><img src="../images/load_process.gif" alt="Loading"></center>
Checking Please Wait! <Br>Meanwhile Please <b style="color: red;">BE ONLINE</b>
</div>
</div>
 
<?php //**************************************************************** ?>




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


<?php if (!empty($_SESSION['mess_Serial'])) { ?>
    <div class="redmsg" align="center"> <?
        echo $_SESSION['mess_Serial'];
        $dis = 1;
        ?></div>
    <?
    unset($_SESSION['mess_Serial']);
}
?>

<?php if(empty($_GET['sku'])){?>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
 <tr>
                   
<td align="left" class="red" align="center" style=" font-size: 14px;font-weight: bold;padding: 30px;">
Enter  Qty.
</td>
</tr>
 <tr>
                   

</table>

<?php } else {?>
<div class="had">
    Serial Number For SKU - <?= $_GET['sku'] ?><br>

Serial Qty :  <span id="cont"><?= $_GET['total'] ?></span>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
 <tr>
                   
<td align="right" >
<input type="button" class="export_button"  id ="importButton" name="imp" value="Import Serial No"/>
</td>
</tr>
 <tr>
                   

</table>

</div>
<?php if (!empty($_SESSION['mess_Serial'])) { ?>
    <div class="redmsg" align="center"> <?
        echo $_SESSION['mess_Serial'];
        $dis = 1;
        ?></div>
    <?
    unset($_SESSION['mess_Serial']);
}


if(!empty($arrayHeader)){
$arrySaleItem=array();
//foreach ($arrayHeader as $Key => $values){
for($i=0;sizeof($arrayHeader)>$i;$i++){

//$j = $i-1;
$arrySaleItem[$i]['serialNo'] = $arrayHeader[$i][0];
$arrySaleItem[$i]['price']=$arrayHeader[$i][1];
$arrySaleItem[$i]['description']=$arrayHeader[$i][2];
}

$NumLine =sizeof($arrySaleItem);


}else{

if($_GET['total']>0) $NumLine =$_GET['total']; else $NumLine =2;

}




/*echo "<pre>";
print_r($arrySaleItem);
exit;*/
?>


<form id="serialform" name="serialform" method ="post">
 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
				<td  class="heading">&nbsp;&nbsp;&nbsp;Serial Number</td>
				<td  class="heading">Price</td>
				<td  class="heading">Description</td>
    </tr>
</thead>
<tbody>
	<? 
 $SerialUnitPrice=0;
	$subtotal=0;
$importQty=0;
if($NumLine>0){
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		

	 
	$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');

	if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';

	if(empty($arrySaleItem[$Count]['price'])) $arrySaleItem[$Count]['price']='0';
 
	if(empty($arrySaleItem[$Count]['id'])) $arrySaleItem[$Count]['id']='';
	if(empty($arrySaleItem[$Count]['serialNo'])) $arrySaleItem[$Count]['serialNo']='';
	if(empty($arrySaleItem[$Count]['description'])) $arrySaleItem[$Count]['description']='';
	?>
     <tr class='itembg'>
		<td>

<?/*=($Line>1)?('<img src="../images/delete.png" id="ibtnDel" title="Delete">'):("&nbsp;&nbsp;&nbsp;")*/?>

<? //echo '<img src="../images/delete.png" id="ibtnDel" title="Delete">'; ?>
		<input type="text" name="serialNo[]" required id="serialNo" class="textbox SRNUM"  size="30"   value="<?=stripslashes($arrySaleItem[$Count]['serialNo'])?>"     />
		<input type="hidden" name="id[]" id="id" value="<?=$arrySaleItem[$Count]['id']?>" readonly maxlength="20"  />
		</td>
 <td><input type="text" name="price[]" id="price" class="textbox" style="width:366px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/>
       </td>
        <td><input type="text" name="description[]" id="description" class="textbox" style="width:366px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["description"])?>"/>
       </td>
       
       
    </tr>
	<? $SerialUnitPrice += $arrySaleItem[$Count]["price"]; }

}


if($importQty>0){
	$SerialUnitPrice = $SerialUnitPrice/$importQty;
}


?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="3" align="right">
						<!--a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add New</a--> 
						<input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
						<input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
						<input type="hidden" name="lineNumber" id="lineNumber" value="<?= $_GET['id'] ?>">
						<input type="hidden" name="totalQtySerial" id="totalQtySerial" value="<?= $_GET['total'] ?>">
						<input type="hidden" name="SerialSku" id="SerialSku" value="<?= $_GET['sku'] ?>">
						<input type="hidden" name="Conditi" id="Conditi" value="<?= $_GET['cond'] ?>">
						<input type="hidden" name="UnitPrice" id="UnitPrice" value="<?= number_format($SerialUnitPrice,2) ?>">

        </td>
    </tr>
</tfoot>



  

</table>
<table>

 <tr>
        <td colspan="2" align="center">

		
		 
       		 <input type="submit" name="AddSerialNumber" id="AddSerialNumber" value="Save" class="button"  />
        	 



		
        </td>
    </tr>

</table>
</form>
<? }?>
<script>
<?php  // ...............................Ganesh 4 jan.......................// ?>
 $("#import").hide();
$(document).ready(function(){
    
    $("#importButton").click(function(){
        $("#import").show();

  document.getElementById("Condition" ).value = window.parent.document.getElementById("Condition<?php echo $_GET['id'] ?>" ).value;
document.getElementById("warehouse" ).value = window.parent.document.getElementById("warehouse" ).value;
document.getElementById("AdjustID" ).value = window.parent.document.getElementById("AdjustID" ).value;
       
    });

    
    $("#button").click(function(){
        $("#import").hide();
    });
 $("#cancel").click(function(){
       parent.$.fancybox.close();
 var str = $("#serial_value<?php echo $_GET['id'] ?>", window.parent.document).val('');
        str =  str.split(',').join('&#13;&#10;')
        $("#serialNo").html(str);
      
    });

 if( $("#serialNo").html()==''){
        var str = $("#serial_value<?php echo $_GET['id'] ?>", window.parent.document).val();
       str =  str.split(',').join('&#13;&#10;')
        $("#serialNo").html(str);
    }

  




});

</script>

