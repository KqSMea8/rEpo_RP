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
            $(wrapper).append('<div class="optiondiv"><input type="text" class="inputbox" name="mytext[]"/><a href="#" class="remove_field optionremove">Remove</a></div>'); //add input box
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


function validateVariant(frm){

	

	if( ValidateForSimpleBlank(frm.variantname, "Variant Name")
		//&& ValidateForSelect(frm.assignedTo, "Assigned To")
		&& ValidateForSelect(frm.lead_source, "Input Type")
		&& ValidateForSelect(frm.required, "Values Required")
		
		
		
		
		
		){
		
				ShowHideLoader('1','S');
					return true;	
					
			}else{
					return false;	
			}	

		
}

function Delete_VariantOption(ID){
	  //var parentID='<?=$_GET['view']?>';
	  //var parent_type='<?=$_GET['module']?>';
	  //var commented_by='<?=$_SESSION['AdminType']?>';
	  //var commented_id='<?=$_SESSION['AdminID']?>';
	  
var SendUrl = "ajax.php?action=VariantOption&del_Variant=delete&v_id="+ID+"&r="+Math.random();
		//var SendUrl = "ajax.php?action=Commented&del_comment=delete&commentID="+ID+"&r="+Math.random(); 
		//alert(SendUrl);
                console.log(SendUrl);
		httpObj2.open("GET", SendUrl, true);
		httpObj2.onreadystatechange = function ListLocalTime(){
			if (httpObj2.readyState == 4) {
				//alert('pppp');
				document.getElementById("info").innerHTML = httpObj2.responseText;
				
			}

		};

		httpObj2.send(null);
//alert(ID);
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
            <a href="managevariant.php" class="add">View Variant</a>
            <a href="addvariant.php?editVId=<?php echo $_GET['editVId'];?>&amp;curP=<?php echo $_GET['curP'];?>" class="edit">Edit</a>
            <a href="javascript:void(0)" class="back" onclick="goBack()">Back</a>
        
        </td>
 </tr>
</table>
 
<form action="" method="post" name="form1" onSubmit="return validateVariant(this);" enctype="multipart/form-data">
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
                            <input name="variant_name" type="text" class="inputbox" id="variantname" value="<?php echo stripslashes($GetVariantEditList[0]['variant_name'])?>" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> <div  id="com_title">Input Type :<span class="red">*</span> </div></td>
                        <td   align="left" >
                            <input type="text" class="inputbox" id="variantname" value="<?php echo $GetVariantEditList[0]['field_name']?>" disabled/>
                            <!--<select name="variant_type_id" class="inputbox" id="lead_source" onchange="ltype();">
                                <option value="<?php echo $GetVariantEditList[0]['variant_type_id']?>"><?php echo $GetVariantEditList[0]['field_name']?></option>
                                
                                </select>-->

                        </td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> <div  id="com_title">Values Required :<span class="red">*</span> </div></td>
                        <td   align="left" >
                            <?php if($GetVariantEditList[0]['required']==0){
                                    
                                    $req='No';
                                }
                                else{
                                    $req='Yes';
                                }
                                ?>
                            <input type="text" class="inputbox" id="variantname" value="<?php echo $req;?>" disabled/>
                            <!--<select name="required" class="inputbox" id="required">
                                
                                <option value=""><?php echo $req;?></option>
                                
                            </select>-->
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
                                <div class="optiondiv">
                        
                                <input type="text" name="mytext[]" class="inputbox" value="<?php echo stripslashes($Optvalues['option_value']);?>" disabled>
                                
                            
                           
                            
                            </div>
                                 <?php  } } ?>
                                
                            </div>
                        </td>
                        </tr>
                        
                            
                    
      
	
</table>	
  




	
	  
	
	</td>
        </tr>
        
   

 

   <tr>
    <td  align="center">
	
	<!--<div id="SubmitDiv" style="display:none1">
	
        <? if ($_GET['editVId'] > 0)
            $ButtonTitle = 'Update ';
        else
            $ButtonTitle = 'Submit';
        ?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
</div>-->

</td>
   </tr>
   </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

<? //} ?>

</div>	
</td>
</tr>
</table>
<? echo '<script>SetInnerWidth();</script>'; ?>
