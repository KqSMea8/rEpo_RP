<SCRIPT LANGUAGE=JAVASCRIPT>

function ClearHead(d){
	document.getElementById("EmpID"+d).value='';
	document.getElementById("OldEmpID"+d).value='';
	document.getElementById("EmpName"+d).value='';
}

function validate(frm){
		if( ValidateForSelect(frm.Division, "Division") 
			&& ValidateForSimpleBlank(frm.Department, "Department")
		){

			if(document.getElementById("depID").value>0){
				var Head = document.getElementById("EmpID").value;
				var Head1 = document.getElementById("EmpID1").value;
				var Head2 = document.getElementById("EmpID2").value;
				var duplic = 0;
				if(Head>0){				
					if(Head==Head1 || Head==Head2){
						duplic=1;
					}
				}
				if(Head1>0 || Head2>0){
					if(Head1==Head2){
						duplic=1;
					}
				}

				if(duplic==1){
					alert("Duplicacy in heads are not allowed.");
					return false;
				}

			}

			var Url = "isRecordExists.php?Department="+escape(document.getElementById("Department").value)+"&editID="+document.getElementById("depID").value;

			SendExistRequest(Url,"Department","Department");
			
			return false;
			
		}else{
			return false;	
		}
		
}



</SCRIPT>
<a href="<?=$RedirectUrl?>" class="back">Back</a>


<div class="had"><?=$MainModuleName?> <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
	

		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" style="padding-top:80px" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    
					
			  <tr <?=$HideRow?>>
                      <td align="right" valign="top"  class="blackbold">
					  Division  :<span class="red">*</span>
					  </td>
                      <td align="left">
				<? if($_GET['edit']==1 ){ 
					echo '<input type="hidden" name="Division" id="Division"  value="'.$_GET['d'].'" />HRMS';
					$DeptClass = 'class="disabled" readonly';
				}else{?> 
				<select name="Division" class="inputbox" id="Division">
					<option value="">--- Select ---</option>
					<? for($i=0;$i<sizeof($arryDepartment);$i++) {?>
						<option value="<?=$arryDepartment[$i]['depID']?>" <?  if($arryDepartment[$i]['depID']==$_GET['d']){echo "selected";}?>>
						<?=$arryDepartment[$i]['Department']?>
						</option>
					<? } ?>
				 </select>
				<? 
					$DeptClass = 'class="inputbox"';
				} ?>
					  </td>
                    </tr>		
					
					
					<tr>
                      <td width="45%" align="right" valign="top"   class="blackbold">
					   Department :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<input  name="Department" id="Department" value="<?=stripslashes($arryDept[0]['Department'])?>" type="text"  <?=$DeptClass?> maxlength="30" onkeypress="return isAlphaKey(event);" />  
					    </td>
                    </tr>
                 
<? if($_GET['edit']>0){ 

	$clear = '<img src="'.$Config['Url'].'admin/images/clear.gif" border="0"  onMouseover="ddrivetip(\'<center>Clear</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';

?>  
<tr>
<td align="right" valign="top"   class="blackbold">
   Departmental Head :</td>
<td align="left" valign="top">
<? if(!empty($arryDept[0]['UserName']))
$EmpName = $arryDept[0]['UserName'].' ['.stripslashes($arryDept[0]['JobTitle']).']';?>
<input name="EmpName" id="EmpName" type="text" class="disabled" style="width:250px;" value="<?=$EmpName?>" readonly />
<input name="EmpID" id="EmpID" type="hidden" value="<?=$arryDept[0]['EmpID']?>"  maxlength="20" readonly />
<input name="OldEmpID" id="OldEmpID" type="hidden" value="<?=$arryDept[0]['EmpID']?>"  maxlength="20" readonly />

<a class="fancybox fancybox.iframe" href="EmpList.php?d=<?=$_GET['edit']?>" ><?=$search?></a>	  

<a href="Javascript:ClearHead('');" ><?=$clear?></a>

    </td>
</tr>


<tr>
<td align="right" valign="top"   class="blackbold">
   Other Head 1 :</td>
<td align="left" valign="top">
<? 
$EmpName1='';
if(!empty($arryOtherHead[0]['UserName']))
$EmpName1 = $arryOtherHead[0]['UserName'].' ['.stripslashes($arryOtherHead[0]['JobTitle']).']';?>
<input name="EmpName1" id="EmpName1" type="text" class="disabled" style="width:250px;" value="<?=$EmpName1?>" readonly />
<input name="EmpID1" id="EmpID1" type="hidden" value="<?=$arryOtherHead[0]['EmpID']?>"  maxlength="20" readonly />
<input name="OldEmpID1" id="OldEmpID1" type="hidden" value="<?=$arryOtherHead[0]['EmpID']?>"  maxlength="20" readonly />

<a class="fancybox fancybox.iframe" href="EmpList.php?d=<?=$_GET['edit']?>&id=1" ><?=$search?></a>	  
<a href="Javascript:ClearHead('1');" ><?=$clear?></a>
    </td>
</tr>


<tr>
<td align="right" valign="top"   class="blackbold">
   Other Head 2 :</td>
<td align="left" valign="top">
<? $EmpName2='';
if(!empty($arryOtherHead[1]['UserName']))
$EmpName2 = $arryOtherHead[1]['UserName'].' ['.stripslashes($arryOtherHead[1]['JobTitle']).']'; ?>
<input name="EmpName2" id="EmpName2" type="text" class="disabled" style="width:250px;" value="<?=$EmpName2?>" readonly />
<input name="EmpID2" id="EmpID2" type="hidden" value="<?=$arryOtherHead[1]['EmpID']?>"  maxlength="20" readonly />
<input name="OldEmpID2" id="OldEmpID2" type="hidden" value="<?=$arryOtherHead[1]['EmpID']?>"  maxlength="20" readonly />

<a class="fancybox fancybox.iframe" href="EmpList.php?d=<?=$_GET['edit']?>&id=2" ><?=$search?></a>	  
<a href="Javascript:ClearHead('2');" ><?=$clear?></a>
    </td>
</tr>









<? } ?>


		  <tr >
                      <td align="right" valign="top"  class="blackbold">Status : </td>
                      <td align="left" >
       
		<? if($_GET['edit']==1){ 
					echo '<input type="hidden" name="Status" id="Status"  value="1" />Active';
				}else{?> 
		<table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>  
			<? } ?>
		</td>
                    </tr>


                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
		
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="depID" id="depID"  value="<?=$_GET['edit']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>
