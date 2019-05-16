<div class="custom-overlay"></div>
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var reqcounter = 1;
	var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
	

		counter = parseInt($("#NumLine").val()) + 1;
	

		var newRow = $("<tr class='itembg'>");
		var cols = "";

		
        cols += '<td><img src="../images/delete.png" id="ibtnDel" title="Delete">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="textbox"  size="30"  onblur="SearchQUOTEComponent(this.value,' + counter + ')"  onclick="Javascript:SetAutoComplete(this);" /></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="textbox" style="width:366px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td>';



		newRow.append(cols);
	
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;


	});



	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		

	});


	 

	});


  

function ResetSearch() {
    $("#prv_msg_div").show();
    $("#frmSrch").hide();
    $("#preview_div").hide();
    $("#msg_div").html("");
}


 $(document).ready(function() {

        $("#AddSerialNumber").click(function() {
            var totCont =0;
            var lineNumber = $("#lineNumber").val();
            var totalQtySerial = $("#totalQtySerial").val();
var Sku =$("#Sku").val();;

 

            var allSerialNo = $("input[name^='serialNo']").map(function() {  return $.trim(this.value); }).get().filter(function(arr){if(arr) return arr;}).join(',');
	    var allserdesc = $("input[name^='description']").map(function() {  return $.trim(this.value); }).get().filter(function(arr){if(arr) return arr;
}).join('%~%');
            var resSerialNo = allSerialNo.split(',');
	//alert(resSerialNo);
            resSerialNo = resSerialNo.filter(function(e) { return e; });
            
            var seriallength = resSerialNo.length;
           

            if (totalQtySerial == "") {
                alert("Please Enter Invoice Qty.");
                return false;
            }
            if (allSerialNo == "")
            {
                alert("Please Enter Serial Number.");
                return false;
            }

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

            var SendParam = 'allSerialNo=' + escape(allSerialNo) + '&desc='+allserdesc+'&action=checkSerialNumber&Sku='+Sku+'&r=' + Math.random();

            $.ajax({
                type: "GET",
                async: false,
                url: 'ajax.php',
                data: SendParam,
                success: function(responseText) {
                    if (responseText != "")
                    {
                        alert("Serial Number " + responseText + " Already Exists.");
                        $("#allSerialNo").highlight(responseText , { wordsOnly: true });
                        return false;
                    } else {

			window.parent.document.getElementById("serial_value" + lineNumber).value = allSerialNo;
			window.parent.document.getElementById("serialdesc" + lineNumber).value = allserdesc;
			parent.$.fancybox.close();
                    }

                }

            });


        });




/*$(document).on('click', '.addmore', function(){
$( $('#serials').clone().attr( "id" ,"serials"+$(".serials").length ).append('<a style="float:right; margin:25px -20px" class="delDiv" href="javascript:;"><img src="<?php echo _SiteUrl?>/admin/images/delete.png"></a>') ).insertBefore($(this));

})*/
/*var SN = $('#serial_value'+$('#lineNumber').val(), window.parent.document).val().split(',');
$('input[name^="serialNo"]').each(function(i){
	$(this).val(SN[i]);

})

var SND = $('#serialdesc'+$('#lineNumber').val(), window.parent.document).val().split('%~%');
$('input[name^="description"]').each(function(i){
	$(this).val(SND[i]);

})*/
  
var SNB = $('#serial_value'+$('#lineNumber').val(), window.parent.document).val().split(',');
//alert(SNB);
if(SNB!=''){
$('input[id^="serialNo"]').each(function(i){
	$(this).val(SNB[i]);
});

}

var SND = $('#serialdesc'+$('#lineNumber').val(), window.parent.document).val().split('|');
if(SND!=''){
$('input[id^="description"]').each(function(i){
	$(this).val(SND[i]);
});
}


  
});
   
 function setcount(vl){
var title='';
var totCont =0;
 var allSerialNo = $("input[name^='serialNo']").map(function() {  return $.trim(this.value); }).get().filter(function(arr){if(arr) return arr;}).join(',');
            //var lineNumber = $("#lineNumber").val();
            var totalQtySerial = $("#totalQtySerial").val();
 var resSerialNo = allSerialNo.split(',');
	//alert(resSerialNo);
            resSerialNo = resSerialNo.filter(function(e) { return e; });
            
            var seriallength = resSerialNo.length;

//alert(seriallength);

if( seriallength>0){

 

 totCont = totalQtySerial-seriallength;
document.getElementById("cont").innerHTML = totCont;
$('#cont').html().replace(title);

}else if(seriallength==0){ seriallength =0;
totCont = totalQtySerial;
document.getElementById("cont").innerHTML = totCont;
$('#cont').html().replace(title);

}


}
 $(document).keydown(function(e) {

  // Set self as the current item in focus
  var self = $(':focus'),
      // Set the form by the current item in focus
      form = self.parents('form:eq(0)'),
      focusable;

  // Array of Indexable/Tab-able items
  focusable = form.find('input,a,select,button,textarea,div[contenteditable=true]').filter(':visible');

  function enterKey(){
    if (e.which === 13 && !self.is('textarea,div[contenteditable=true]')) { // [Enter] key

      // If not a regular hyperlink/button/textarea
      if ($.inArray(self, focusable) && (!self.is('a,button'))){
        // Then prevent the default [Enter] key behaviour from submitting the form
        e.preventDefault();
      } // Otherwise follow the link/button as by design, or put new line in textarea

      // Focus on the next item (either previous or next depending on shift)
      focusable.eq(focusable.index(self) + (e.shiftKey ? -1 : 1)).focus();

      return false;
    }
  }
  // We need to capture the [Shift] key and check the [Enter] key either way.
  if (e.shiftKey) { enterKey() } else { enterKey() }
});

</script>

<?php if(empty($_GET['sku'])){?>
<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
 <tr>
                   
<td align="left" class="red" align="center" style=" font-size: 14px;font-weight: bold;padding: 30px;">
Enter  Qty.
</td>
</tr>
</table>

<?php } else {?>
<div class="had">
    Serial Number For SKU - <?= $_GET['sku'] ?><br>
Serial Qty :  <span id="cont"><?= $_GET['total'] ?></span>

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
<style>
.submenu {
    margin: 10px;
}
.custom-overlay.open {
    background: #000 none repeat scroll 0 0;
    height: 100%;
    opacity: 0.6;
    position: fixed;
    width: 100%;
    z-index: 100;
}
</style>
<script type="text/javascript">

jQuery('body').on('click','.range-link',function(){

    var html='';
    html +='<ul><li><label>Start Serial Range</label><input type="" class="startSrialRange inputbox"></li>';
    html +='<li><input type="button" class="range-button button" value="Select"></li></ul>';
    jQuery('.range-popup').html(html);
    jQuery('.range-popup').dialog({
    	  open: function() {
    	jQuery('.custom-overlay').addClass('open');
    },
    close: function() {
    	jQuery('.custom-overlay').removeClass('open');
    } 
        });

  
    })


jQuery('body').on('click','.range-button',function(){

var startrange=jQuery('.startSrialRange').val();

console.log(startrange);
var total=jQuery('#totalQtySerial').val();
for (var i=0; i<parseInt(total);i++){
console.log(parseInt(startrange)+i);
			jQuery('#serialform table.order-list tbody tr:eq('+(i)+') td input.serialNo-class').val(parseInt(startrange)+i);
	
}
jQuery('.range-popup').dialog('close');   
});


</script>


<form id="serialform" name="serialform" method ="post">
<div class="submenu"><a href="javascript:void(0)" class="range-link">Select Range</a></div>

 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td  class="heading">&nbsp;&nbsp;&nbsp;Serial Number</td>
<!--td  class="heading">Price</td>
		<td  class="heading">Description</td>-->
		
    </tr>
</thead>
<tbody>
	<? 
	$subtotal=0;
if($_GET['total']>0) $NumLine =$_GET['total']; else $NumLine =2;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		

	
	if($arrySale[0]['tax_auths']=='Yes' && $arrySaleItem[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	$ReqDisplay = !empty($arrySaleItem[$Count]['req_item'])?(''):('style="display:none"');

	if(empty($arrySaleItem[$Count]['Taxable'])) $arrySaleItem[$Count]['Taxable']='No';


	?>
     <tr class='itembg'>
		<td>

<?/*=($Line>1)?('<img src="../images/delete.png" id="ibtnDel" title="Delete">'):("&nbsp;&nbsp;&nbsp;")*/?>

<? //echo '<img src="../images/delete.png" id="ibtnDel" title="Delete">'; ?>
		<input type="text" name="serialNo[]" required id="serialNo" class="textbox serialNo-class" onblur="setcount(this.value);"  size="50"   value="<?=stripslashes($arrySaleItem[$Count]['sku'])?>"     />
		<input type="hidden" name="id[]" id="id" value="<?=$arrySaleItem[$Count]['id']?>" readonly maxlength="20"  />
		
		<input type="hidden" name="price[]" id="price" class="textbox"   maxlength="50"   value="<?=stripslashes($arrySaleItem[$Count]["price"])?>"/>
<input type="hidden" name="description[]" id="description" class="textbox" style="width:366px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arrySaleItem[$Count]["description"])?>"/>
		</td>

       
       
    </tr>
	<? }?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="3" align="right">
		 <!--a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add New</a--> 
			<input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
			<input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />
			<input type="hidden" name="lineNumber" id="lineNumber" value="<?= $_GET['id'] ?>">
			<input type="hidden" name="totalQtySerial" id="totalQtySerial" value="<?= $_GET['total'] ?>">
	<input type="hidden" name="Sku" id="Sku" value="<?= $_GET['sku'] ?>">
		
        </td>
    </tr>
</tfoot>



  

</table>
<table>

 <tr>
        <td colspan="3" align="center">

		
		 
       		 <input type="submit" name="AddSerialNumber" id="AddSerialNumber" value="Save" class="button"  />
        	 



		
        </td>
    </tr>

</table>
</form>
<? }?>

<? #echo '<script>SetInnerWidth();</script>'; ?>

<div class="range-popup" style="display:none;"></div>
