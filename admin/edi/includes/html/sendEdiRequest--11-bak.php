
<?php 
$hide = 0;
if($_GET['mod']=='Accept'){

$hide =  1;
}

$hideVendor =  0;
$hideCust =  0;
if($_GET['EdiType']=='Customer'){

$hideVendor =  1;
$hideCust =  0;
}else if($_GET['EdiType']=='Vendor'){

$hideVendor =  0;
$hideCust =  1;

}
?>







<div>
 <form name="form1" id="form1" target="_parent" action="requestEDI.php" method="post"  enctype="multipart/form-data">
    <div id="dialogContent" style="background-color:#ffffff;">
  
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td class="head"> Edi <?=$_GET['mod']?></td>
    </tr>
   <tr bgcolor="#ffffff"> 
   
    <td> 
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
   <? if(empty($hide)){?>
     <tr <?=$hide?>>
    <td class="blackbold" align="right"> Edi Type : </td>
    <td><select name="EDITypeSelected" class="textbox" style="width:180px;" id ="EDITypeSelected">
    
    <option value="">-Select-</option>
    <option value="Customer">Customer</option>
    <option value="Vendor">Vendor</option>
    <option value="Both">Both</option>
    
    </select></td></tr>
    <? }?>
    
   <?php if(empty($hideCust)){?>
     <tr id="showCust">
   <td class="blackbold" align="right"> Customer : </td>
    <td><select name="ToCust" class="textbox" style="width:180px;" id ="ToCust">
    
    <option value="">-Select-</option>
    <? foreach($arryCustRequest as $ToCust){?>
    	<option value="<?= $ToCust['CustCode'] ?>" ><?= $ToCust['Company'] ?>(<?= $ToCust['CustCode'] ?>)</option>

    <? }?>
    
    </select></td></tr>
    <? }?>
    <!-- <tr>
   <td class="blackbold" align="right"> From Customer : </td>
    <td><select name="FromCust" class="textbox" style="width:180px;" id ="FromCust">
    
    <option value="">-Select-</option>
    <option value="Customer">Customer</option>
    <option value="Vendor">Vendor</option>
    <option value="Both">Both</option>
    
    </select></td></tr>-->
    <?php if(empty($hideVendor)){?>
     <tr id="showVend">
   <td class="blackbold" align="right"> Vendor : </td>
    <td><select name="ToVendor" class="textbox" style="width:180px;" id ="ToVendor">
    
    <option value="">-Select-</option>
    <? foreach($arryVenRequest as $ToVend){?>
    	<option value="<?= $ToVend['SuppCode'] ?>" ><?= $ToVend['VendorName'] ?>(<?= $ToVend['SuppCode'] ?>)</option>

    <? }?>
    
    </select></td></tr>
    <? }?>
   <!--  <tr>
   <td class="blackbold" align="right"> From Vendor:</td>
    <td><select name="FromVendor" class="textbox" style="width:180px;" id ="FromVendor">
    
    <option value="">-Select-</option>
    <option value="Customer">Customer</option>
    <option value="Vendor">Vendor</option>
    <option value="Both">Both</option>
    
    </select></td></tr>-->
   
    	
    	</table>
    	</td></tr>
    	<tr>
    <td align="center">
	<input type="submit" class="button" id="reqSubmit" name="reqSubmit" onclick ="window.parent.document.getElementById('formid').submit();" value="<?=$_GET['mod']?>"/>
	<input type="hidden" name="request_CmpID" id="request_CmpID" value="<?=$_GET['request_CmpID']?>"  >
<input type="hidden" name="name" id="name" value="<?=$_GET['name']?>"  >
<input type="hidden" name="mod" id="mod" value="<?=$_GET['mod']?>"  >
<input type="hidden" name="type" id="type" value="<?=$_GET['type']?>"  >


	      
    	</td></tr>
    	
    	</table>
    	
    </div>
    </form>
</div>


<script type="text/javascript">

$(function() {



$("#EDITypeSelected").change(function(e) {
 
var EDITypeSelected = $("#EDITypeSelected").val();

 var ToCust = $("#ToCust").val(); 
var ToVendor = $("#showVend").val();
if(EDITypeSelected=='Customer'){

$("#showVend").hide();
$("#showCust").show();

}else if(EDITypeSelected=='Vendor'){
$("#showVend").show();
$("#showCust").hide();

}else{

$("#showVend").show();
$("#showCust").show();

}
});

 
    $("#reqSubmit666").click(function(e) {
    
   
        var EDITypeSelected = $("#EDITypeSelected").val();
        var ToCust = $("#ToCust").val(); 
        var FromCust =$("#FromCust").val();
        var ToVendor = $("#ToVendor").val();
        var FromVendor = $("#FromVendor").val();
        var request_CmpID = $("#request_CmpID").val();
        var requestname = $("#name").val();
        
        
        if (EDITypeSelected == '') {
            alert("Please select Edi Type.");
            return false;
        } 
        else {
        
        
      
    window.parent.form.submit();
    return true;

        
        /*var dataString="empIds="+escape(empIds)+"&Type="+escape(selectedSalesPersonType)+"&action=GetCommisionPercentage";
      	 $.ajax({
              type: "POST",
              url: "ajax.php",
              dataType: 'json',
              //data:{action:'GetCommisionPercentage',empIds:empIds,Type:selectedSalesPersonType}, 
              data: dataString,
              //async:false,
	               success: function(data){
	               	
			           if(data <=100){
                     $("#previousSelectedSalesPerson").val(selectedSalesPersonType);
                     window.parent.document.getElementById("SalesPerson").value=selectedSalesPersonName;
                     window.parent.document.getElementById("SalesPersonType").value=selectedSalesPersonType;
                     window.parent.document.getElementById("SalesPersonID").value=selectedSalesPersonIds;
                     parent.jQuery.fancybox.close();
                     ShowHideLoader('1','P');
			           }
			           else
			           {
				           alert("Sum of Commission Percentage Should Be Less Or Equal To 100");
				           return false;
			           }
		           }
		}); 
*/
   
       /* var dataString="empIds="+escape(empIds)+"&Type="+escape(selectedSalesPersonType)+"&action=GetCommisionPercentage";
      	$.ajax({
		type: "POST",
		url: "ajax.php",
		dataType: 'json',
		//data:{action:'GetCommisionPercentage',empIds:empIds,Type:selectedSalesPersonType}, 
		data: dataString,
		//async:false,
	    success: function(data){
	    	
			if(data <=100){
                $("#previousSelectedSalesPerson").val(selectedSalesPersonType);
	            window.parent.document.getElementById("SalesPerson").value=selectedSalesPersonName;
	            window.parent.document.getElementById("SalesPersonType").value=selectedSalesPersonType;
	            window.parent.document.getElementById("SalesPersonID").value=selectedSalesPersonIds;
                parent.jQuery.fancybox.close();
                ShowHideLoader('1','P');
			}
			else
			{
				alert("Sum of Commission Percentage Should Be Less Or Equal To 100");
				return false;
			}
		}
		});*/


    	
    

      }
    });
});

</script>
