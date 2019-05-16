<link rel="stylesheet" href="css/crm.css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />

<script type="text/javascript">

//By chetan 7July//
$(function(){
    
    $('#ctyp').closest('td').prev().css('width','10%');
    $("#OppTitleDiv").hide();
    $("#OppValDiv").hide();
    $("#CustTitleDiv").hide();
    $("#CustValDiv").hide();
        
    $('#CustType').change(function(){
	custtype($(this).val());
    });
    
    custtype($('#CustType').val()); 
    
    function custtype(sel)
    {
        if(sel == 'o'){
		$("#OppTitleDiv").show();
		$("#OppValDiv").show();
		$("#CustTitleDiv").hide();
		$("#CustValDiv").hide();			
	}else if(sel == 'c'){
		$("#OppTitleDiv").hide();
		$("#OppValDiv").hide();
		$("#CustTitleDiv").show();
		$("#CustValDiv").show();
	}else{
		$("#OppTitleDiv").hide();
		$("#OppValDiv").hide();
		$("#CustTitleDiv").hide();
		$("#CustValDiv").hide();
	}
        
    }
    
    
    $( "input[name$='assign']" ).click(function() { 
            if(this.value=='Users') //By Chetan//
            {
                $('#group').hide();
                $('#user').show();
            }else{
                $('#user').hide();
                $('#group').show();
            }   

        });
    
    $('#ship_state').blur(function(){SetTaxable(1);});
    $('#ship_country').blur(function(){SetTaxable(1);});
    $('#tax_auths').change(function(){SetTaxable(1);})
    $('input[name$="Reseller"]').click(function(){SetReseller(1);});
    
    //17july//
    $("#form1").submit(function(){
        var err;
        $('div.red').html('');
        //6Oct//
        //if($("#TaxRate").val() != null){
	//	$("#MainTaxRate").val() = $("#TaxRate").val();
	//}

	if(document.getElementById("TaxRate") != null){
		document.getElementById("MainTaxRate").value = document.getElementById("TaxRate").value;
	}

       
        $("#form1  :input[data-mand^=\'y\']").each(function(){
            
            $fldname = $(this).attr('name');
            $fldname = $fldname.replace('[]',''); //by niraj for multicheckbox
            $input = ($(this).closest('td').prev().clone().children().remove().end().text()).replace(':','');  
              if($(this).attr('type') == '' || typeof($(this).attr('type')) == 'undefined' || $(this).attr('type') == 'text')
              {
                if( $.trim($(this).val()) == "")
                {
                        $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
                        err = 1;
                }    
              
              }else{//by niraj for checkbox 11feb16
                if($('input[name^="'+$fldname+'"]').length == 1)
		{ 
			if($('#'+$fldname+':checked').length < 1)
			{
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}
		}else{
			if($('input[name^="'+$fldname+'"]:checked').length < 1)
			{  
			     $("#"+$fldname+"err").html(""+$input+" is mandatory field.");
			     err = 1;
			}

		}
            }
          
              if($fldname == 'assign')
              { 
                    if($("#assign:checked").val()=='Users' && $("#AssignToUser").val()=='')
                    {
                        $("#"+$fldname+"err").html("Please Enter Assign User Name.");
                        err = 1;	
                    }else if($("#assign:checked").val()=='Group' && $("#AssignToGroup").val()==''){

                        $("#"+$fldname+"err").html("Please Select Assign Group.");
                        err = 1;
                    }
              }
          
        });
        
        
          //6Oct//
        if($("#CustType").val()!="" && typeof($("#CustType").val()) != 'undefined')
        {
            if($("#CustType").val() == 'c'){ fld = 'Customer';cfld='CustomerName'; }else if($("#CustType").val() == 'o'){ fld = 'Opportunity';cfld='opportunityName';}
             
            if($('#'+cfld+'').val()=="")
            {
                err = 1;     
                $("#typeerr").html(""+fld+" is mandatory field.");
            }
        }    
        
        if($("#EntryType").val() == "recurring")
        {
            if($("#EntryFrom").val()=='')
            {
                err = 1;     
                $("#EntryFromerr").html("Entry From is mandatory field.");
            }
            if($("#EntryTo").val()=='')
            {
                err = 1;
                $("#EntryToerr").html("Entry To is mandatory field.");
            }

            if($("#EntryFrom").val()!='' && $("#EntryTo").val()!='' && ($("#EntryTo").val() <= $("#EntryFrom").val())){
                err = 1;
                $("#EntryToerr").html("End Date Should be Greater Than Start Date.");
            }
            	
        }
             
        if(err == 1){ return false;}else{
            
            var NumLine = parseInt($("#NumLine").val());     
            for(var i=1;i<=NumLine;i++){

                if(document.getElementById("sku"+i).value == ""){

                        if(!ValidateForSelect(document.getElementById("sku"+i), "SKU")){
                                return false;
                        }
                        if(!ValidateForSimpleBlank(document.getElementById("description"+i), "Item Description")){
                                return false;
                        }
                        if(!ValidateMandNumField2(document.getElementById("qty"+i), "Quantity",1,999999)){
                                return false;
                        }
                        if(!ValidateMandDecimalField(document.getElementById("price"+i), "Unit Price")){
                                return false;
                        }	
                }
                if(parseFloat(document.getElementById("discount"+i).value) > parseFloat(document.getElementById("price"+i).value))
                {
                   alert("Discount Should be Less Than Unit Price!");
                   return false;
                }
            }
            
            
            if( OrderID==''){		
	
                var Url = "isRecordExists.php?QuoteSubject="+escape(document.getElementById("subject").value)+"&editID="+document.getElementById("quoteid").value+"&Type=Quote";
                SendExistRequest(Url,"subject", "Quote Subject");
                return false;
            }
            
            
        } 
 
       
    });
    
    
    //By Chetan 16July//
      if($('#form1 input:checkbox').length>0){
         
        $('#form1 input:checkbox').click(function(){
            
          fldname = $(this).attr('name');
          if(!$(this).is(':checked'))
          { 
                  $('<input>').attr({
                        type: 'hidden',
                        id: fldname,
                        name: fldname,
                        value:''
                    }).prependTo('#form1');
          }else{
                $('input[name="'+fldname+'"][type="hidden"]').remove();
          }
            
        });
          
      }
      
      //End//
      
     
    
    
});



//End//



	var ew_DHTMLEditors = [];

function copyAddressRight(form) {

	if(typeof(form.bill_street) != 'undefined' && typeof(form.ship_street) != 'undefined')
		form.ship_street.value = form.bill_street.value;

	if(typeof(form.bill_city) != 'undefined' && typeof(form.ship_city) != 'undefined')
		form.ship_city.value = form.bill_city.value;

	if(typeof(form.bill_state) != 'undefined' && typeof(form.ship_state) != 'undefined')
		form.ship_state.value = form.bill_state.value;

	if(typeof(form.bill_code) != 'undefined' && typeof(form.ship_code) != 'undefined')
		form.ship_code.value = form.bill_code.value;

	if(typeof(form.bill_country) != 'undefined' && typeof(form.ship_country) != 'undefined')
		form.ship_country.value = form.bill_country.value;

	if(typeof(form.bill_pobox) != 'undefined' && typeof(form.ship_pobox) != 'undefined')
		form.ship_pobox.value = form.bill_pobox.value;
	
	return true;

}

function copyAddressLeft(form) {

	if(typeof(form.bill_street) != 'undefined' && typeof(form.ship_street) != 'undefined')
		form.bill_street.value = form.ship_street.value;
	
	if(typeof(form.bill_city) != 'undefined' && typeof(form.ship_city) != 'undefined')
		form.bill_city.value = form.ship_city.value;

	if(typeof(form.bill_state) != 'undefined' && typeof(form.ship_state) != 'undefined')
		form.bill_state.value = form.ship_state.value;

	if(typeof(form.bill_code) != 'undefined' && typeof(form.ship_code) != 'undefined')
		form.bill_code.value =	form.ship_code.value;

	if(typeof(form.bill_country) != 'undefined' && typeof(form.ship_country) != 'undefined')
		form.bill_country.value = form.ship_country.value;

	if(typeof(form.bill_pobox) != 'undefined' && typeof(form.ship_pobox) != 'undefined')
		form.bill_pobox.value = form.ship_pobox.value;

	return true;

}



</script>





<div class="back"><a class="back" href="<?=$RedirectURL?>">Back</a></div>

<?php

	if( (!empty($arryQuote) && $arryQuote[0]['quotestage']=='Accepted') && $_GET['edit']>0){ 
		if(empty($arryCompany[0]["Department"]) || substr_count($arryCompany[0]['Department'],6)>0){
			echo '<a class="fancybox edit" href="#convert_form" >'.CONVERT_TO_SALE_ORDER.'</a>';
			include("includes/html/box/quote_convert_form.php");
		}
	}
 

?>









<div class="had">
   <span>&raquo;
	<?php 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<?php if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php } 
  


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}


?>
  
<form name="form1" id="form1" action="<?php //echo $ActionUrl?>"  method="post" onSubmit="return validateQuote(this);  validateInventory('Products');" enctype="multipart/form-data">
<table  border="0" class="borderall" cellpadding="0" cellspacing="0" width="100%">
									  <?php      

$head=1;
$NewArr = array();
if(!empty($arryQuote[0])  && !empty($arryQuoteAdd[0]))
{
    $NewArr = array_merge($arryQuote[0],$arryQuoteAdd[0]);
}elseif(!empty($arryQuote[0]) && empty($arryQuoteAdd[0]))    
{
    $NewArr = $arryQuote[0];
}elseif(empty($arryQuote[0]) && !empty($arryQuoteAdd[0]))   
{
    $NewArr = $arryQuoteAdd[0];
}
$arrayvalues = $NewArr;
for($h=0;$h<sizeof($arryHead);$h++){ 
   
    if($arryHead[$h]['head_value'] == 'Ship Address Information'){
?>
    
    <tr> 
        <td colspan="8" class="head" align="left"><?=$arryHead[$h]['head_value']?>&nbsp;&nbsp;&nbsp;
        <input name="cpy" onclick="return copyAddressRight(form1)" type="radio"><b>Copy Billing address</b></span>
        </td>    										
    </tr>

    <?php }else{?>
    <tr>
        <td colspan="8" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>
    
    <?php }

    if($arryHead[$h]['head_value'] == 'Quote Information')
    {
        //Recurring Start//
        $arryRecurr = (!empty($arryQuote)) ? $arryQuote : '';
		$arryRecurr[0]['CrmQuote'] = 1;
        include("../includes/html/box/recurring_2column_sales.php"); 
        //Recurring End//
    }


$arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 
include("includes/html/box/CustomFieldsNew.php"); 

if($arryHead[$h]['head_value'] == 'Ship Address Information'){
    
?>

<script language="JavaScript1.2" type="text/javascript">
SetReseller();
SetTaxable();
function SetReseller(ProcessCal){
	if($('#Reseller:checked').val() == 'No'){
                $("#ResellerNo").val('');
		$("#ResellerNo").closest('td').hide().prev().hide();
	}else{
		$("#ResellerNo").closest('td').show().prev().show();
	}
	
}

function SetTaxable(ProcessCal){
	if(document.getElementById("tax_auths").value=='Yes' && document.getElementById("ship_country").value!=''){
		$("#TaxRateVal").html('<img src="../images/loading.gif">');
		var SendUrl = "&action=TaxRateAddress&State="+escape(document.getElementById("ship_state").value)+"&Country="+escape(document.getElementById("ship_country").value)+"&OldTaxRate="+escape(document.getElementById("TaxRate").value)+"&r="+Math.random();
 
	   	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		success: function (responseText) {			
			if(responseText!=''){		
				$("#TaxRateVal").html(responseText);
			}else{
				$("#TaxRateVal").html("No tax class.");
			}
		   
		}

	   	});
	}else{
		$("#TaxRateVal").html("None");
	}


	if(ProcessCal==1){
		ProcessTotal();
	}
}


</script>



<?php }

}

?>
<tr>
	<td colspan="8"  align="left" >
	
		<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			 <td  align="left" class="head" >Line Item</td>
		</tr>
		<tr>
			<td align="left" >
				<? 	include("includes/html/box/sale_quote_item_form.php");?>
			</td>
		</tr>
		
		</table>
		
	</td>
</tr>

 <tr>
    <td  colspan="8"  align="center">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
		<input name="quoteid" value="<?=(isset($quoteid)) ? $quoteid : '';?>" id="quoteid" type="hidden">

		<input type="hidden" name="Module" id="Module" value="<?=$_GET['module']?>" />

		<input type="hidden" name="ModuleID" id="ModuleID" value="<?=(isset($ModuleID)) ? $ModuleID :'';?>" />
		<input type="hidden" name="PrefixSale" id="PrefixSale" value="<?=(isset($PrefixSale)) ? $PrefixSale : '';?>" />

	</td>
   </tr>
									  
</table>
</form>

	

	
 
