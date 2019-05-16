<script language="JavaScript1.2" type="text/javascript">

function SelectAllRecord()
{	
	$( ".check" ).prop( "checked", true );

}

function SelectNoneRecords()
{
		$( ".check" ).prop( "checked", false );

}


function ShowEmpListing(){
	ShowHideLoader('1','L');	
	location.href = "editParticipant.php?t="+document.getElementById("trainingID").value+"&d="+document.getElementById("Department").value;
}

function validateAddPart(frm){
		var checkedFlag = 0;
		var TotalRecords = frm.numEmployee.value;

		if(TotalRecords > 0){
				for(var i=1;i<=TotalRecords;i++){
					if(document.getElementById("EmpID"+i).checked==true){
						if(checkedFlag == 0){
							checkedFlag = 1;
							break;
						}
					}
				}

				if(checkedFlag == 0){
					alert("You must select atleast one employee.");
					return false;
				}else{
					ShowHideLoader('1','S');	
					return true;
				}

		}

		return false;
		
}
</script>


<div><a href="<?=$RedirectURL?>"  class="back">Back</a></div>


<div class="had">
<?=$MainModuleName?>   <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

	<? if (!empty($errMsg)) {?>
    <div  class="red" ><?php echo $errMsg;?></div>
  <? } ?>



<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateAddPart(this);" enctype="multipart/form-data">
	<tr>
        <td>
		
		<? require_once("includes/html/box/training_box.php");  ?>
		
		</td>
      </tr>
   
   
   <tr>
    <td  align="center" valign="top" >
	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

 <tr>
		 <td colspan="4" align="left" class="head"> Add Participant
		 </td>
	</tr>  
<tr>
        <td colspan="2" height="5">
		
		</td>
  </tr>
<tr>
        <td  align="right"   class="blackbold" width="12%"> Department  :<span class="red">*</span> </td>
        <td   align="left" >

<select name="Department" class="inputbox" id="Department" onChange="Javascript:ShowEmpListing();">
  <option value="">--- Select ---</option>
  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?=($_GET["d"]==$arrySubDepartment[$i]['depID'])?("selected"):("")?> >
  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
  </option>
  <? } ?>
</select></td>
      </tr>


<tr>
        <td colspan="2" align="right" height="5">
		
<?   if($numEmployee>1){ 	?>
	<a href="javascript:SelectAllRecord();">Select All</a> | <a href="javascript:SelectNoneRecords();" >Select None</a>
<? } ?>		
		
		
		</td>
  </tr>
<? if($_GET["d"]>0){ ?>
<tr>
        <td  align="right"   class="blackbold" valign="top" > Employee  :<span class="red">*</span> </td>
        <td   align="left" >

<div id="part_list" style="padding:5px; width:670px; <?=$ScrollStyle?>" class="borderall">
<table width="100%"  border="0" cellspacing=3 cellpadding=5 >
   <?  if($numEmployee>0){ 
 
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	
	if ($Line % 2 == 0) {
		echo "</tr><tr>";
	}

	$Line++;
  ?>
     <td valign="top" width="50%"><input type="checkbox" class="check" name="EmpID[]" id="EmpID<?=$Line?>" value="<?=$values['EmpID']?>" />&nbsp;<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>"><?=stripslashes($values['UserName'])?></a> 
	[<?=stripslashes($values["JobTitle"])?>]
	 
	 </td>

    <?php } // foreach end //?>
  




    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_EMPLOYEE?></td>
    </tr>
    <?php } ?>
  
	
  </table>

 
</div>



</td>
      </tr>

<tr>
        <td   align="left" colspan="2"  height="10"></td>
  </tr>
	  
<? } ?>	  	



	
</table>	
  




	
	  
	
	</td>
   </tr>


   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>

	  <?  if($numEmployee>0){ ?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
		<? } ?>


<input type="hidden" name="trainingID" id="trainingID" value="<?=$_GET['t']?>" />
	<input type="hidden" name="numEmployee" id="numEmployee" value="<?=$numEmployee?>" />  

</div>

</td>
   </tr>


   </form>
</table>




