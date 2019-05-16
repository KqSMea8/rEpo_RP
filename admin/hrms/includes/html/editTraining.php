
<div><a href="<?=$RedirectURL?>"  class="back">Back</a></div>


<div class="had">
<?=$MainModuleName?>    <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

	<? if (!empty($errMsg)) {?>
    <div  class="red" ><?php echo $errMsg;?></div>
  <? } ?>


<script language="JavaScript1.2" type="text/javascript">
function validateTraining(frm){

	if(document.getElementById("EmpID") != null){
		document.getElementById("Coordinator").value = document.getElementById("EmpID").value;
	}



	if( ValidateForSimpleBlank(frm.CourseName, "Course Name")
		&& ValidateForSimpleBlank(frm.Company, "Company")
		&& ValidateForSelect(frm.trainingDate,"Training Date")
		&& ValidateForSelect(frm.Department,"Department")
		&& ValidateForSelect(frm.Coordinator,"Coordinator")
		&& ValidateForSimpleBlank(frm.Address,"Training Location")
		&& ValidateOptionalDoc(frm.document,"Document")
		){
					
					ShowHideLoader('1','S');

				
				/*var Url = "isRecordExists.php?TrainingCourse="+escape(document.getElementById("CourseName").value)+"&editID="+document.getElementById("trainingID").value;
				SendExistRequest(Url, "CourseName", "Course Address");
				return false;	*/
				return true;	
			}else{
				return false;	
		}			
}
</script>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateTraining(this);" enctype="multipart/form-data">
   <tr>
    <td  align="center" valign="top" >
	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
  
	<? if(!empty($_GET['edit'])){ ?>
	<tr>
        <td  align="right" class="blackbold"> Training ID : </td>
        <td   align="left"><?=stripslashes($arryTraining[0]['trainingID'])?></td>
      </tr>
	<? } ?>


	<tr>
        <td  align="right"   class="blackbold"> Course Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="CourseName" type="text" class="inputbox" id="CourseName" value="<?php echo stripslashes($arryTraining[0]['CourseName']); ?>"  maxlength="50"  />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Company  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="Company" type="text" class="inputbox" id="Company" value="<?php echo stripslashes($arryTraining[0]['Company']); ?>"  maxlength="50" />            </td>
      </tr>
	 
	   <tr>
        <td  align="right"   > Training Date : <span class="red">*</span> </td>
        <td   align="left" >
		
<script type="text/javascript">
$(function() {
	$('#trainingDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")?>:<?=date("Y")+5?>', 
		dateFormat: 'yy-mm-dd',
		minDate: "+1D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="trainingDate" name="trainingDate" readonly="" class="datebox" value="<?=$arryTraining[0]['trainingDate']?>"  type="text" >         </td>
      </tr> 

	  
 <tr>
        <td  align="right"   class="blackbold" width="45%"> Training Time : </td>
        <td   align="left" >
<script>
  $(function() {
	$('#trainingTime').timepicker({ 
		'timeFormat': 'H:i',
		'step': '5'
		});
  });
</script>

<input name="trainingTime" type="text" class="disabled" size="4" id="trainingTime" value="<?=$arryTraining[0]['trainingTime']?>"  autocomplete="off"/>

		</td>
      </tr>



<tr>
        <td  align="right"   class="blackbold" valign="top"> Department  :<span class="red">*</span> </td>
        <td   align="left" >

<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','');">
  <option value="">--- Select ---</option>
  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryTraining[0]['Department']){echo "selected";}?>>
  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
  </option>
  <? } ?>
</select></td>
      </tr>

	   <tr>
        <td  align="right"  class="blackbold" valign="top"><div id="EmpTitle">Coordinator  :<span class="red">*</span></div> </td>
        <td  align="left" >
		<div id="EmpValue"></div> <input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$arryTraining[0]['Coordinator']?>" /><input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
					
<script language="javascript">
EmpListSend('','');
</script>				


		</td>
      </tr>

        <tr>
          <td align="right"   class="blackbold" valign="top">Training Location  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" class="textarea" id="Address" maxlength="250" ><?=stripslashes($arryTraining[0]['Address'])?></textarea>			          </td>
        </tr>
         
	  <tr>
        <td align="right"   class="blackbold" >Cost  :</td>
        <td  align="left"  >
	 <input name="Cost" type="text" class="textbox" id="Cost" value="<?=stripslashes($arryTraining[0]['Cost'])?>" size="10" maxlength="20" onkeypress="return isDecimalKey(event);"/>	<?=$Config['Currency']?> 		</td>
      </tr> 
  <tr>
        <td align="right"   class="blackbold" >Topic  :</td>
        <td  align="left"  >
	 <input name="Topic" type="text" class="inputbox" id="Topic" value="<?=stripslashes($arryTraining[0]['Topic'])?>" maxlength="70" />			</td>
      </tr> 

  <tr>
          <td align="right"   class="blackbold" valign="top">Description  :</td>
          <td  align="left" >
            <textarea name="detail" class="bigbox" id="detail" maxlength="1000" ><?=stripslashes($arryTraining[0]['detail'])?></textarea>			          </td>
        </tr>


<tr>
    <td height="30" align="right" valign="top"   class="blackbold" >  Document   :</td>
    <td  align="left" valign="top" >
	
	<input name="document" type="file" class="inputbox" id="document" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
	
	<?        
 
        if($arryTraining[0]['document'] !='' && IsFileExist($Config['TrainingDir'],$arryTraining[0]['document']) ){ 
	
	$OldDocument =  $arryTraining[0]['document'];

?><br><br>
	<input type="hidden" name="OldDocument" value="<?=$OldDocument?>">


	<div id="documentDiv">
	<?=$arryTraining[0]['document']?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryTraining[0]['document']?>&folder=<?=$Config['TrainingDir']?>" title="<?=$arryTraining[0]['document']?>" class="download">Download</a>
&nbsp;
	<a href="Javascript:void(0);" onclick="Javascript:RemoveFile('<?=$Config['TrainingDir']?>', '<?=$arryTraining[0]['document']?>','documentDiv')"><?=$delete?></a>
	<br><br>
	</div>
	
<?	} ?>		
	
	</td>
  </tr>


	  
	
	
	<tr>
                      <td align="right" valign="top"  class="blackbold">Status : </td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>
	
</table>	
  




	
	  
	
	</td>
   </tr>

 <? if($HideSibmit != 1){ ?>
   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

<input type="hidden" name="trainingID" id="trainingID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="Coordinator" id="Coordinator" value="<?=$arryTraining[0]['Coordinator']?>" />

</div>

</td>
   </tr>
   <? } ?>

   </form>
</table>




