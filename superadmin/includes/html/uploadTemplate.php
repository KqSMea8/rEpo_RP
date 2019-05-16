<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateForm(frm)
{
    if($('#TemplateId').val()==''){
		if($('#TemplateDisplayName').val()==''){
			alert('Please enter template display name');
			return false;
			
		}
		else if($('#template').val()==''){
			alert('Please select your template');
			return false;
			
		}
	}else if($('#TemplateId').val()!=''){
		if($('#TemplateDisplayName').val()==''){
			alert('Please enter template display name');
			return false;
			
		}else if($('#TemplateDis').val()=='Private'){
		if($('#CmpID').val()==''){
			alert('Please select template company');
			return false;
			
		}
            }      	
}

</SCRIPT>

<script type="text/javascript">

$(function() { 
   $('#mySelect').on('change', function(){
    var selValue = $(this).val();  
   if(selValue =='e') {$("#myecom").show();}
   else  {$("#myecom").hide(); }  
});
});

$(document).ready(function() {
    if ($("select[name=TemplateType] option:selected").val() == 'w') {
        $("#myecom").hide();
    }
$("#displayTemp").hide();
 $('#TemplateDis').on('change', function(){
    var selValue = $(this).val();  
   if(selValue =='Private') {$("#displayTemp").show();}
   else  {$("#displayTemp").hide(); }  
});
});


</script>

<a href="<?=$RedirectUrl?>"  class="back">Back</a>
<div class="had">
Template    <span> &raquo;
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
			 </span>
</div>
<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle">
		  <br><br />
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" enctype="multipart/form-data" onSubmit="return ValidateForm(this);">
               
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				 
					
                    <tr>
                    <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Template Display Name : <span class="red">*</span></td>
                    <td width="56%" align="left"><input value="<?=stripslashes($arryTemplate[0]['TemplateDisplayName'])?>" name="TemplateDisplayName" type="text" class="inputbox" id="TemplateDisplayName" size="31" maxlength="30" <? if($_GET['edit']==1) echo 'Readonly'; ?>/> </td>
                    </tr>
                    <tr>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Template Type : <span class="red">*</span></td>
                      <td width="56%" align="left">
                      <?php $TemplateType=array('e'=>'E-Commerce','w'=>'Website');?>
                      <select name="TemplateType" class="inputbox" id="mySelect">
                      <?php foreach($TemplateType as $key=>$val){
                      	echo '<option value="'.$key.'" ';
                      	if(stripslashes($arryTemplate[0]['TemplateType'])==$key) echo 'selected="selected"';
                      	echo '>'.$val.'</option>';
                      }?>                      	
                      </select>
                    </tr>
 <tr>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Display Template : <span class="red">*</span></td>
                      <td width="56%" align="left">
                      <?php $TemplateDis=array('Public'=>'Public','Private'=>'Private');?>
                      <select name="TemplateDis" class="inputbox" id="TemplateDis">
                      <?php foreach($TemplateDis as $key=>$val){
                      	echo '<option value="'.$key.'" ';
                      	if(stripslashes($arryTemplate[0]['TemplateDis'])==$key) echo 'selected="selected"';
                      	echo '>'.$val.'</option>';
                      }?>                      	
                      </select>
                    </tr>
 <tr id="displayTemp">
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Company : <span class="red">*</span></td>
                      <td width="56%" align="left">
                      
                      <select name="CmpID" class="inputbox" id="CmpID">
												<option value="" >Select Company</option>
                      <?php foreach($arrySelCompany as $value){
                      	echo '<option value="'.$value['CmpID'].'" ';
                      	if(stripslashes($arryTemplate[0]['CmpID'])==$value['CmpID']) echo 'selected="selected"';
                      	echo '>'.$value['CompanyName'].'</option>';
                      }?>                      	
                      </select>
                    </tr>
                    
                    <tr id="myecom">
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Ecom Type : <span class="red">*</span></td>
                      <td width="56%" align="left">
                      <?php $EcomType=array('leisure'=>'Leisure','health'=>'Health','generalmerchandise'=>'General Merchandise',
                          'footwear'=>'Footwear','clothingapparel'=>'Clothing/ Apparel','specialty'=>'Specialty',
                          'electronics'=>'Electronics','software'=>'Software','sportinggoods'=>'Sporting Goods','homeGoods'=>'Home Goods','transportation'=>'Transportation','telecommunication'=>'Telecommunication','books'=>'Books','other'=>'Other');?>
                          <select name="EcomType" class="inputbox" >
                      <?php foreach($EcomType as $key=>$val){
                      	echo '<option value="'.$key.'" ';
                      	if(stripslashes($arryTemplate[0]['EcomType'])==$key) echo 'selected="selected"';
                      	echo '>'.$val.'</option>';
                      }?>                      	
                      </select>                     
                    </tr>
                    
                   <?php //added by rakesh  price field 14-Apr-2016  ?> 
                    
                     <tr>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Template Price : <span class="red">*</span></td>
                      <td width="56%" align="left"><input value="<?=stripslashes($arryTemplate[0]['TemplatePrice'])?>" name="TemplatePrice" type="text" class="inputbox" id="TemplatePrice" size="5" maxlength="10" /> <span class="">Fill 0 (Zero) for free.</span> </td>
                    
                     </tr>
                      <tr>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Template Name : <span class="red">*</span></td>
                      <td width="56%" align="left"><input value="<?=stripslashes($arryTemplate[0]['TemplateName'])?>" name="TemplateName" type="text" class="inputbox" id="TemplateDisplayName" size="31" maxlength="30" <? if($_GET['edit']==1) echo 'Readonly'; ?>/> </td>
                    </tr>
                    
                    <tr>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold">Set as Default : <span class="red">*</span></td>
                      <td width="56%" align="left"><input type="checkbox" <?php if(stripslashes($arryTemplate[0]['is_default']) == 1 ){ echo 'checked';} ?>  value="1" name="is_default" type="text" class="inputbox" id="is_default" size="31" maxlength="30" <? if($_GET['edit']==1) echo 'Readonly'; ?>/></td>
                    </tr>
                    
                    
                    
					<?php
				if(!isset($_GET['edit']) || empty($_GET['edit'])  ){ ?>
				<tr>
                      <td width="44%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Upload : <span class="red">*</span> </td>
                      <td width="56%" align="left"><input type="file" name="template" id="template"/> </td>
                    </tr>
				<?php	}	?>
					
					
                  </table></td>
                </tr>
				
				<tr>
                  <td align="center" valign="top" >
				  <br>
				
				  <input type="hidden" name="TemplateId" id="TemplateId"  value="<?=$_GET['edit']?>" />
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
				  <br>  
				  <br>				  </td>
                </tr>	
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
