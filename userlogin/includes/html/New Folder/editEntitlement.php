
<SCRIPT LANGUAGE=JAVASCRIPT>

function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("EmpID"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("EmpID"+i).checked=false;
	}
}



function ValidateForm(frm)
{

	var i=0;
	var flag=0;
	if(document.getElementById("EntID").value<=0){
		if(frm.Line.value > 1){
			for(i=1; i<=frm.Line.value; i++){
				if(document.getElementById("EmpID"+i).checked==true){
					flag=1;	break;
				}else{
					flag=0;
				}
			}
		}else{		
			if(document.getElementById("Email1").checked==true) flag=1;
				else flag=0;
		}	
		
		if(flag==0){
			alert('Please check atleast one employee.'); 
			return false;
		}
	}





	if(  ValidateForSelect(frm.LeaveType, "Leave Type")
		&& ValidateMandNumField2(frm.Days,"Days",1,50)
	){
		
		if(document.getElementById("EntID").value>0){
			var Url = "isRecordExists.php?EntitlementEmpID="+escape(document.getElementById("EmpID").value)+"&LeaveType="+document.getElementById("LeaveType").value+"&editID="+document.getElementById("EntID").value;
		
			SendExistRequest(Url,"EmpID","Leave Entitlement");
			return false;
		}else{
			return true;
		}
	}else{
		return false;	
	}
	
}

function ValidateForm555555(frm)
{
		
		
		
		

}

</SCRIPT>
  <div  align="right" class="back"><a href="<?=$RedirectUrl?>" >Back</a></div>
<div class="had"><?=$ModuleName?> &raquo; <strong>
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</strong>
</div>
<TABLE WIDTH=850   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
		<tr>
		  <td align="center" style="padding-top:80px">
		  <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
            
               
                <tr>
                  <td align="center" valign="top" >
				  
				  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" >
                  
                   
                    <tr>
                      <td  align="right" valign="top" class="blackbold"> 
					  Employee :<span class="red">*</span> </td>
                      <td   align="left" valign="top">
					<? 
					$Width="45%";
					
					if($_GET['edit'] >0){	?>
						<?=$arryEntitlement[0]['UserName']?> (<?=$arryEntitlement[0]['Department']?>)
						<input type="hidden" name="EmpID" id="EmpID" value="<?=$arryEntitlement[0]['EmpID']?>">
					<? }else if(sizeof($arryEmployee)>0){ 
							$Width="20%";
							if(sizeof($arryEmployee)>1) { $DivStyle = 'style="height:20px;overflow-y:auto "';} 
					 ?>
				
<div id="PermissionValue" style="width:650px; height:180px; overflow:auto">  
<table width="100%"  border="0" cellspacing=0 cellpadding=2>
				  <tr> 
				  	<?   
				  		$flag = 0;
					   if(sizeof($arryEmployee)>0) {					   
					  for($i=0;$i<sizeof($arryEmployee);$i++) { 
					  
					  	if ($flag % 2 == 0) {
							echo "</tr><tr>";
						}
						
						$Line = $flag+1;
					   ?>
                       
                          <td align="left"  valign="top" width="320" height="20">
	 <input type="checkbox" name="EmpID[]" id="EmpID<?=$Line?>" value="<?=$arryEmployee[$i]['EmpID'];?>">&nbsp;<?=stripslashes($arryEmployee[$i]['UserName']);?> (<?=stripslashes($arryEmployee[$i]['Department']);?>)</a>							</td>
						 <?
						  $flag++;
						  } 
						  ?>
                        </tr>
						
                        <? }  ?>
                     
</table>
<input type="hidden" name="Line" id="Line" value="<? echo sizeof($arryEmployee);?>">
</Div>	
<?  if(sizeof($arryEmployee)>1) {	?>
    <div align="right">
	<a href="javascript:SelectAllRecord();">Select All</a> | <a href="javascript:SelectNoneRecords();" > Select None</a>
	</div>	
<? } ?>					
					
					
					
					<? }else{ 
						$HideSibmit = 1;
					?>
					<div class="redmsg">No employee exist.</div>
					<? } ?>
					  </td>
                    </tr>

				
					
			<tr >
				<td  align="right"  width="<?=$Width?>" class="blackbold">Leave Type :<span class="red">*</span></td>
				<td align="left">

				<select name="LeaveType" class="inputbox" id="LeaveType">
					<option value="">--- Select ---</option>
					<? for($i=0;$i<sizeof($arryLeaveType);$i++) {?>
						<option value="<?=$arryLeaveType[$i]['attribute_value']?>" <?  if($arryLeaveType[$i]['attribute_value']==$arryEntitlement[0]['LeaveType']){echo "selected";}?>>
						<?=$arryLeaveType[$i]['attribute_value']?>
						</option>
					<? } ?>
				</select> 	</td>
			  </tr>	
			  
			   <tr >
                      <td align="right" valign="middle"  class="blackbold">Days :<span class="red">*</span></td>
                      <td align="left" >
<input id="Days" name="Days"  class="textbox" size="3" value="<?=$arryEntitlement[0]['Days']?>"  type="text" maxlength="2" > 

                       </td>
                    </tr>
			  	
                  
			<? if(!empty($LeaveStart) && !empty($LeaveEnd)){ ?>
			<tr>
                      <td  align="right"   class="blackbold"> 
					 Leave Period :
					  </td>
                      <td  align="left" valign="top">
					<? echo date("j M Y", strtotime($LeaveStart))." - ".date("j M Y", strtotime($LeaveEnd)); ?>

 	<input type="hidden" name="LeaveStart" id="LeaveStart" value="<?=$LeaveStart?>">   
 	<input type="hidden" name="LeaveEnd" id="LeaveEnd" value="<?=$LeaveEnd?>">   



					  </td>
                    </tr>
			<? } ?>
			
                   
                   
                  </table>
				  
				  
				  </td>
                </tr>
				
          
          </table>
		  
		  
		  </td>
	    </tr>
		<tr>
				<td align="center" valign="top"><br>
			<? if($_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

	<input type="hidden" name="EntID" id="EntID" value="<?=$_GET['edit']?>">  

	<? if($HideSibmit!=1){ ?>

	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />&nbsp;
	<input type="reset" name="Reset" value="Reset" class="button" />
	<? } ?>
		  
				  
				  
				  </td>
		  </tr>
	    </form>
</TABLE>
