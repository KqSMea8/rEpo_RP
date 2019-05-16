<SCRIPT LANGUAGE=JAVASCRIPT>
 function validateTax(frm){
	if( ValidateForSimpleBlank(frm.Model,"Model")
	    
		){	


	
                  var Url = "isRecordExists.php?ModelNo="+escape(document.getElementById("Model").value)+"&editID="+document.getElementById("id").value;	 
                           
                                  SendExistRequest(Url,"Model", "Model "+document.getElementById("Model").value);
					//SendExistRequest(Url,'Item Sku '+document.getElementById("Sku").value);
		  	
		                   return false;
				
					
			}else{
					return false;	
			}	

		
}

function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Generation"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Generation"+i).checked=false;
	}
}
</SCRIPT>
<a class="back" href="<?=$RedirectURL?>">Back</a>


<div class="had">
Manage  Model   <span> &raquo; 
	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($_GET["parent_type"])." Tax") :("Add  ".$ModuleName); ?></span>
		
		
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 <form name="form1" action="" method="post" onSubmit="return validateTax(this);"  enctype="multipart/form-data">
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<tr>
	 <td colspan="2" align="left"  class="head" >Model/Generation</td>
     
</tr>
	<tr>
	<td align="right" class="blackbold" > Model :<span class="red">*</span> </td>
	<td align="left" >
	<input name="Model" type="text"  class="inputbox"  id="Model" value="<?php echo stripslashes($arryModel[0]['Model']); ?>" maxlength="50" /> </td>
	</tr>
                    <tr>
                      <td  align="right" valign="top" class="blackbold"> 
					  Generation : </td>
                      <td   align="left" valign="top">

				
<div id="PermissionValue" style="width:580px; height:180px; overflow:auto">  
<table width="100%"  border="0" cellspacing=0 cellpadding=2>
				  <tr> 
				  	<?   


				  		$flag = 0;
					   if(sizeof($arryGeneration)>0) {					   
					  for($i=0;$i<sizeof($arryGeneration);$i++) { 
					  
					  	if ($flag % 3 == 0) {
							echo "</tr><tr>";
						}
						
						$Line = $flag+1;
                          $class = explode(",",$arryModel[0]['Generation']);
					   ?>
                       
                          <td align="left"  valign="top" width="220" height="20">
	 <input type="checkbox" name="Generation[]" id="Generation<?=$Line?>" <? if(in_array($arryGeneration[$i]['attribute_value'], $class)){
	echo "checked";}?> value="<?=$arryGeneration[$i]['attribute_value'];?>">&nbsp;
	 
	 <?=stripslashes($arryGeneration[$i]['attribute_value']);?> 							</td>
						 <?
						  $flag++;
						  } 
						  ?>
                        </tr>
						
                    
                     

<input type="hidden" name="Line" id="Line" value="<? echo sizeof($arryGeneration);?>">

</Div>	
	<?  if(sizeof($arryGeneration)>1) {	?>

		<div align="right">
		<a href="javascript:SelectAllRecord();">Select All</a> | <a href="javascript:SelectNoneRecords();" >Select None</a>
		</div>	

</table>
	<? } ?>					



<? }else{ 
$HideSibmit = 1;
echo "No Generation Exists";
} ?>
					  </td>
                    </tr>
<tr>
	<td align="right"   class="blackbold">Status  </td>
	<td align="left"><span class="blacknormal">
	<? $ActiveCheckedMod ="checked"; ?>
	<input type="radio" name="Status" id="Status" value="1" <?= $ActiveCheckedMod ?>>Active&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="radio" name="Status" id="Status" value="0" >InActive    </span></td>
	</tr>
    </table>                      
</td>
</tr>


   


	
	</td>
    </tr>
   <tr>
    <td  colspan="2"  align="center" >
	<br />
<div id="SubmitDiv" style="display:none1">
	
<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
   <input type="hidden" name="id" id="id" value="<?=$_GET['edit'];?>" />
   	
   <input name="Submit" type="submit" class="button" id="Submit" value=" <?= $ButtonTitle ?> " />&nbsp;

</div>




</td>
   </tr>
 </form>
</table>

