

<script language="JavaScript1.2" type="text/javascript">
function validateOptionBillForm(frm){
	var NumLine = parseInt($("#NumLine").val());
		
	var DataExist =0;


if( ValidateForSimpleBlank(frm.option_code, "Option code")
		
	){
	
	for(var i=1;i<=NumLine;i++){
		if(document.getElementById("sku"+i) != null){
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
	}

	for(var i=1;i<=NumLine;i++){
		if(document.getElementById("sku"+i) != null){
			if(document.getElementById("evaluationType"+i) == "Serialized"){
				if(!ValidateForSimpleBlank(document.getElementById("serial_qty"+i), "Serial Number for "+document.getElementById("sku"+i).value)){
				  return false;
				} 

			}     

		}
	}
	
		



		return true;	
		

	}else{
		return false;	
	}	

	var optionID = Trim(document.getElementById("option_code").value);

	

	
	
if(!ValidateForSimpleBlank(frm.option_code, "Option Code")){
		return false;
	}
	/**********************/
	
	DataExist = CheckExistingData("isRecordExists.php","&OPTIONCODE="+escape(document.getElementById("option_code").value)+"&editID="+document.getElementById("optionID").value, "option_code","Option Code");
	if(DataExist==1)return false;
	/**********************/	
		

	
		
}


//By Chetan 8Sept//
$(function(){
    
    $('#close').click(function(){
        
        if(/\bedit\b/.test(parent.location.href))
        {
            parent.jQuery.fancybox.close();
        }else{
            parent.window.location.href ="myeditBOM.php?edit=<?=$_GET['bomID']?>&curP=1&tab=bill_Information" ;
        }
    })
    
})
//End//
//function OptionItemCode(Key,ID){
//  
//var DataExist =0;
//
//
//
//
//  var SendUrl = "&action=SearchBillNumber&key="+escape(Key)+"&r="+Math.random();
//        /******************/
//        $.ajax({
//            type: "GET",
//            url: "ajax.php",
//            data: SendUrl,
//            dataType : "JSON",
//            success: function (responseText) {
//
//
//             if(responseText["Sku"] != undefined){
//                         document.getElementById("option_code"+ID+"").value=responseText["Sku"];
//		           
//		           document.getElementById("description_one"+ID+"").value=responseText["description"];
//		          
//                                  document.getElementById("sku1").focus();
//
//		           
//               }
//           
//
//
//            }
//        });
//        /******************/
//  
//
//}
</script>







 
<table id="optionsTable<?php echo $j;?>" class="optionsTable" width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" class="delOption">
<tr>
    <td colspan="2" align="left" class="head">Option Bill <img src="../images/delete-161.png" class="ibtnDeloption" id="ibtnDeloption<?php echo $j;?>" style="float: right; display: <?php if($_GET['edit']){ echo "block";}else{echo "none"; }?>"></td>

</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="addoption">	 
 
      
      <tr>
                        <td width="20%"  align="right"   class="blackbold" > Option Code: <span class="red">*</span> </td>
                        <td   align="left">
<!--                           <input type="hidden" name="optionname"  value=<?=$newNumLine?> >-->
                            <input type="hidden" name="optionId<?php echo $j;?>" id="optionId<?php echo $j;?>"  value="<?php if(isset($values['optionID'])) echo $values['optionID'] ; ?>">
                           <input  name="option_code<?php echo $j;?>"  <?=(!empty($values['option_code']))?>  id="option_code<?php echo $j;?>" class="<?=(!empty($values['option_code']))?('disabled'):('textbox')?>" style="text-transform:uppercase" onBlur="Javascript:return OptionItemCode(this.value,'<?php echo $j;?>');" value="<? if(isset($values['option_code'])) echo $values['option_code']; ?>" type="text"   size="10"/>
 

</td>


                        <td align="right"   class="blackbold" > Description :   </td>
                        <td   align="left">
                            
                      
                           <input  name="description_one<?php echo $j;?>" id="description_one<?php echo $j;?>" value="<? if(isset($values['description1'])) echo $values['description1']; ?>" type="text"  size="30"  class="inputbox"  maxlength="100" />
                          

</td>
                 
                    </tr> 
                   




</table>

	 </td>
</tr>






<tr>
	 <td colspan="2" align="right">
	 
	 </td>
</tr>
<tr>
	 <td colspan="2" align="left" class="head" >Component Item</td>
</tr>

<tr>
	<td align="left" colspan="2">
            
		<?php 	include("includes/html/box/option_item_form.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>


        
          
   <tr <?=$disNone?>>
    <td  align="center">
	
	


</td>
   
      
  
    
</table>









