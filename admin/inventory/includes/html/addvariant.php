<script type="text/javascript" src="includes/time.js"></script>
<script type="text/javascript" src="../js/jquery.validation.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine-en.js"></script>
<link rel="stylesheet" href="css/validationengine.css" type="text/css" />


<script language="JavaScript1.2" type="text/javascript">
function ShowList(){
	document.getElementById("ListingRecords").style.display = 'none';
	document.topForm.submit();
}


$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="optiondiv"><input type="text" id="mdlettersnum" class="inputbox" name="mytext[]"/><input type="hidden" value="0" class="inputbox" name="mytextId[]"/><a href="#" class="remove_field optionremove">Remove</a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});


function ltype() {

        var opt = document.getElementById('lead_source').value;

        if (opt == "4") {
            document.getElementById('manageoption').style.display = 'block';
             document.getElementById('manageoptionv').style.display = 'block';
             document.getElementById('manageoptionp').style.display = 'block';
            
        } else if(opt == "5"){
        
        document.getElementById('manageoption').style.display = 'block';
        document.getElementById('manageoptionv').style.display = 'block';
         document.getElementById('manageoptionp').style.display = 'block';
        }else{
            document.getElementById('manageoption').style.display = 'none';
        document.getElementById('manageoptionv').style.display = 'none';
        document.getElementById('manageoptionp').style.display = 'none';
            //document.getElementById('company').value = '';
        }


    }

function uniquevariantname(frm){
    /*
   var letters = /^[A-Za-z]+$/;  
   if(document.getElementById('variantname').value.match(letters)){
    $.ajax({
                           type:"GET",
                       url:"ajax.php",
                     data:"action=VariantIsExit&Variantname="+escape(document.getElementById("variantname").value)+"",
                    success:function(data){
                           //$("#div_"+ID).remove();
                            alert(data);
                              var result=data;
                            //window.alert(result);
                             if(result==1){
                                 window.alert("Variant name already exist");
                                 return false;
                              }
                           else {
                             
                                ShowHideLoader('1','S');
                                 window.alert("hello");
                                return false;	

                            }
                              

                         }

                      });
                   }
                  else {
                      window.alert("Letters Only");
                                            return false;
                                        }
                                        */



}
function validateVariant(frm){

	var letters = /^[A-Za-z]+$/;
         var letterNumber = /^[0-9a-zA-Z]+$/;//id="mdlettersnum"
	if( ValidateForSimpleBlank(frm.variantname, "Variant Name")
		//&& ValidateForSelect(frm.assignedTo, "Assigned To")
		&& ValidateForSelect(frm.lead_source, "Field Type")
		&& ValidateForSelect(frm.required, "Values Required")
		){
            
            
                               
                        if(document.getElementById('variantname').value.match(letters)){        
                                 if(document.getElementById('mdlettersnum').value!=''){
                                     if(document.getElementById('mdlettersnum').value.match(letterNumber)){
                                         var Url = "isRecordExists.php?Variantname="+escape(document.getElementById("variantname").value)+"&vareditID="+document.getElementById("varianteditid").value+"";////
                  

					SendExistRequest(Url,"variantname", "Variant Name");
                                        return false;
                                     }
                                     else {
                                         window.alert("Special Characters Not Allowed");
                                         return false;
                                     }
                                 }
                                 else{
                  var Url = "isRecordExists.php?Variantname="+escape(document.getElementById("variantname").value)+"&vareditID="+document.getElementById("varianteditid").value+"";////
                  

					SendExistRequest(Url,"variantname", "Variant Name");
                                        return false;
                                        

                                
                    }
                    }
                    else{
				window.alert("Letters Only");	
                                return false;	
			}
                }
                        return false;
}

                
	




function DeleteVariantOption(ID){
	  
$.ajax({
          type:"GET",
          url:"ajax.php",
          data:"action=VariantOption&del_Variant=delete&v_id="+ID,
          success:function(data){
              $("#div_"+ID).remove();
              //console.log(data);
              //$('#info').html(data);
			 
          }

      });
}


</script>
<script>
    	//$("#form1").validationEngine({promptPosition : "topRight:-2,0" return false;});
    function allLetterrrr(inputtxt)  
      {  
       var letters = /^[A-Za-z]+$/;  
       if(document.getElementById('variantname').value.match(letters))
         {  
          return true;  
         }  
       else  
         {  
         alert("letters Only"); 
         return false;  
         }  
      }  
  </script>
<script>
function goBack() {
    window.history.back()
}
</script>
<style>
    .optionlabel{
        vertical-align: top;
    }
    .optiondiv{
        margin-bottom: 4px;
        margin-top: 2px;
    }
    .optionbutton{
        background-color: #bebebe;
    color: #000;
    cursor: pointer;
    }
    .optionremove{
        
        background-color: #d40503;
        color: #fff !important;
        margin-left: 5px;
        padding: 2px;
    }
    #manageoptionp{
        margin-left: 93px;
    }
    
</style>
<div class="had">Manage <?=$ModuleName?></div>
<div id="info"> </div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_var'])) {echo $_SESSION['mess_var']; unset($_SESSION['mess_var']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
 <td  valign="top">

<div id="ListingRecords">



<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" >
            <a href="managevariant.php"  class="add">View Variant</a>
            <?php if ($_GET['editVId'] > 0) { ?>
            <a href="javascript:void(0)" class="back" onclick="goBack()">Back</a>
            <?php } ?>
        </td>
 </tr>
</table>
 
<form action="" id="form1" onSubmit="return validateVariant(this);"  method="post" name="form1"  enctype="multipart/form-data">
<div id="piGal">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                        <td colspan="4" align="left" class="head">Add Variant</td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold" > Variant Name  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <input name="variant_name" type="text" class="inputbox" id="variantname" value="<?php echo stripslashes($GetVariantEditList[0]['variant_name'])?>" />
                            <input name="editid" type="hidden" class="inputbox" id="varianteditid" value="<?php echo stripslashes($GetVariantEditList[0]['id'])?>" />
                        </td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> <div  id="com_title">Field Type :<span class="red">*</span> </div></td>
                        <td   align="left" >
                            <select name="variant_type_id" class="inputbox" id="lead_source" onchange="ltype();">
                                <option value="">--- Select ---</option>
                                <?php foreach($variantType as $values){ ?>
                                    <option value="<?php echo $values['id']?>" <?php if($values['id']==$GetVariantEditList[0]['variant_type_id']){ echo 'selected'; }?> ><?php echo $values['field_name']?></option>
                                <?php }?>
                                </select>

                        </td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> <div  id="com_title">Values Required :<span class="red">*</span> </div></td>
                        <td   align="left" >
                            <select name="required" class="inputbox" id="required">
                                <option value="">--- Select ---</option>
                                <option value="0" <?php if($GetVariantEditList[0]['required']==0){ echo 'selected';}?>>No</option>
                                <option value="1" <?php if($GetVariantEditList[0]['required']==1){ echo 'selected';}?>>Yes</option>
                            </select>
                        </td>
                    </tr>
                    
                    <?php //$display="display:none;";
                    if(!empty($GetVariantEditList) && ($GetVariantEditList[0]['variant_type_id']=='4' || $GetVariantEditList[0]['variant_type_id']=='5')) { 
                       //if(is_array($GetMultipleEditVariantOption)) {  
                        $display="display:block;";
                        
                    } else { 
                        //echo 'tt';
                        $display="display:none;";
                    }?>
                   
                    <tr>
                        <td colspan="4" align="left" class="head"><div id="manageoption" style="<?php echo $display ?>">Manage Label/Option</div></td>
                        
                    </tr>
                      <tr>
                          <td  align="right"   class="blackbold optionlabel"><div id="manageoptionp" style="<?php echo $display ?>"> Option  :<span class="red">*</span> </div></td>
                        <td align="left">
                            <div class="input_fields_wrap" id="manageoptionv" style="<?php echo $display ?>">
                                     <?php if(is_array($GetMultipleEditVariantOption)) { 
                        
                        foreach($GetMultipleEditVariantOption as $Optvalues){
                        
                        ?>
                                <div class="optiondiv" id="div_<?php echo $Optvalues['id'];?>">
                        
                                <input type="text" id="mdlettersnum" name="mytext[]" class="inputbox" value="<?php echo stripslashes($Optvalues['option_value']);?>">
                                <input type="hidden" name="mytextId[]" class="inputbox" value="<?php echo $Optvalues['id'];?>">
                                
                                <img src="../images/delete.png" id="" onclick="DeleteVariantOption(<?php echo $Optvalues['id']; ?>);"  title="Delete" style="margin-left:4px; cursor: pointer;" >
                           
                            
                            </div>
                                 <?php  } } ?>
                                <?php if ($_GET['editVId'] > 0) { ?>
                                <div class="optiondiv">
                        
                                
                                <a class="add_field_button blackbold optionbutton">Add More Option</a>
                                </div>
                                <?php } else { ?>
                                <input type="text" name="mytext[]" id="mdlettersnum" class="inputbox" value="">
                                <a class="add_field_button blackbold optionbutton">Add More Option</a>
                                <?php } ?>
                            </div>
                        </td>
                        </tr>
                        
                            
                    
      
	
</table>	
 </td>
        </tr>
        
   

 

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
        <?php if ($_GET['editVId'] > 0)
            $ButtonTitle = 'Update ';
        else
            $ButtonTitle = 'Submit';
        ?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?>"  />
</div>

</td>
   </tr>
   </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

<?php //} ?>

</div>	
</td>
</tr>
</table>
<?php echo '<script>SetInnerWidth();</script>'; ?>

