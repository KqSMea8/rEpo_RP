<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm){


		if(frm.reviewID.value >0){
				var MinRating = frm.MinRating.value;
				var MaxRating = frm.MaxRating.value;

				for(i=1;i<=3;i++){
						if(document.getElementById("Rating"+i) != null){
						
								if(!ValidateMandNumField2(document.getElementById("Rating"+i),"Rating",MinRating,MaxRating)
								){
									return false;
								}
							
						}
				}


		}else{

				if(document.getElementById("EmpID") != null){
					document.getElementById("MainEmpID").value = document.getElementById("EmpID").value;
				}


				if( ValidateForSelect(frm.Department,"Department")
					&& ValidateForSelect(frm.MainEmpID, "Employee")
					&& ValidateForSelect(frm.ReviewerID, "Reviewer")
					&& ValidateForSelect(frm.FromDate,"Review From Date")
					&& ValidateForSelect(frm.ToDate,"Review To Date")
				){

					if(frm.MainEmpID.value == frm.ReviewerID.value){
						alert("Reviewer and Employee should not be same.");
						return false;
					}


					if(frm.ToDate.value < frm.FromDate.value){
						alert("Review To Date should be greater than Review From Date.");
						return false;
					}

					return true;

				}else{
					return false;	
				}


		}



		
}
</SCRIPT>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
Manage Review   <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">

<? if($_GET['edit'] >0){ ?>
 <tr>
	<td width="45%" align="right"    class="blackbold">
	Employee :
	</td>
	<td  align="left" >
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryReview[0]['EmpID']?>" ><?=stripslashes($arryReview[0]['UserName'])?></a> [<?=stripslashes($arryReview[0]['Department'])?>]   
	

	</td>
 </tr>	
 <tr>
	<td  align="right"    class="blackbold">
	Job Title : 
	</td>
	<td  align="left" >
	<?=stripslashes($arryReview[0]['JobTitle'])?>
	</td>
 </tr>
  <tr>
	<td  align="right"  class="blackbold">
	Category : 
	</td>
	<td  align="left" >
	<?=(!empty($arryReview[0]['catName']))?(stripslashes($arryReview[0]['catName'])):(NOT_SPECIFIED)?>
	</td>
 </tr>
  <tr>
	<td  align="right"    class="blackbold">
	Review From : 
	</td>
	<td  align="left" >
	<? if($arryReview[0]["FromDate"]>0) echo date($Config['DateFormat'], strtotime($arryReview[0]["FromDate"])); ?>
	</td>
 </tr>	
<tr>
	<td  align="right"    class="blackbold">
	Review To : 
	</td>
	<td  align="left" >
	<? if($arryReview[0]["ToDate"]>0) echo date($Config['DateFormat'], strtotime($arryReview[0]["ToDate"])); ?>
	</td>
 </tr>	
 <tr>
	<td  align="right"    class="blackbold">
	Reviewer :
	</td>
	<td  align="left" >
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryReview[0]['ReviewerID']?>" ><?=stripslashes($arryReview[0]['ReviewerName'])?></a>   

	</td>
 </tr>	

<? 	 if($arryReview[0]['Status'] != "Scheduled") $stClass = 'green';
	 else $stClass = '';
?>

 <tr>
	<td  align="right"    class="blackbold">
	Status : 
	</td>
	<td  align="left" class="<?=$stClass?>" >
	<?=stripslashes($arryReview[0]['Status'])?>
	</td>
 </tr>

<? if($numKra>0){ ?>
 <tr>
	<td  align="right"    class="blackbold">
	KRA : 
	</td>
	<td  align="left" >
	<B><?=stripslashes($arryKra[0]['heading'])?></B>

	</td>
 </tr>	
 
 <tr>
	<td  align="right"    class="blackbold">
 	Minimum Rating :
	</td>
	<td  align="left" >
	<?=$arryKra[0]['MinRating']?>
	 <input name="MinRating" type="hidden" id="MinRating" value="<?=$arryKra[0]['MinRating']?>"  />		
	</td>
 </tr>

<tr>
	<td  align="right"    class="blackbold">
	Maximum Rating : 
	</td>
	<td  align="left" >
	<?=$arryKra[0]['MaxRating']?>
	 <input name="MaxRating" type="hidden" id="MaxRating" value="<?=$arryKra[0]['MaxRating']?>"  />		
	</td>
 </tr>	
 </table>
 <br>
<table width="100%" border="0" cellpadding="5" cellspacing="0"  class="borderall">
 
 <? 
 if($catID>0){
 
 foreach($arryComponent as $key=>$values){ 
			$compID = $values['compID'];
			$Rating = $arryReview[0]['Rating'.$compID];
	?>	
	<tr>
	  <td  align="left" colspan="2" class="head"><?=stripslashes($values['heading'])?> </td>
	</tr>		
	<tr>
	  <td  class="blackbold"   align="right">Rating :<span class="red">*</span> </td>
	  <td  align="left" >
<input  name="Rating<?=$compID?>" id="Rating<?=$compID?>" value="<?=$Rating?>" type="text" class="textbox" size="3"  maxlength="3" onkeypress="return isNumberKey(event);"/>	
	  
	   </td>
	</tr>
<? } ?>
 
 <tr>
	  <td  align="left" colspan="2" class="head">Comments  </td>
	</tr>
	<tr>
	<td  align="right"   valign="top" class="blackbold" width="45%" >
Comments : 
	</td>
	<td  align="left"  >
	<textarea name="Comment" class="textarea" id="Comment" maxlength="250" ><?=stripslashes($arryReview[0]['Comment'])?></textarea>		
	</td>
 </tr>

<? 
	}else{ 
		$HideSubmit = 1; ?>
		
	 <tr>
	  <td  align="center" colspan="2" class="redmsg"><?=NO_CAT_FOR_EMPLOYEE?> </td>
	</tr>	
<?	}
	
	
	
	

}else{ 
		$HideSubmit = 1;
		?>

<tr>
	<td  align="right"    class="blackbold">
	KRA : 
	</td>
	<td  align="left"class="redmsg" >
	<?=NO_KRA_FOR_JOB_TITLE?>
	</td>
 </tr>

<? } ?>




<? }else{ ?>




	<? if(sizeof($arryEmployee)>0){ ?> 

<tr>
        <td  align="right"   class="blackbold" valign="top" width="45%"> Department  :<span class="red">*</span> </td>
        <td   align="left" >

<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','');">
  <option value="">--- Select ---</option>
  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryReview[0]['Department']){echo "selected";}?>>
  <?=$arrySubDepartment[$i]['Department']?>
  </option>
  <? } ?>
</select></td>
      </tr>

	   <tr>
        <td  align="right"  class="blackbold" valign="top" ><div id="EmpTitle">Employee  :<span class="red">*</span></div> </td>
        <td  align="left" >
		<div id="EmpValue"></div> <input type="hidden" name="OldEmpID" id="OldEmpID" value="" />
		<input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
						
<input type="hidden" name="MainEmpID" id="MainEmpID" value="" />

		</td>
      </tr>




	
					

				  <tr>
					<td  align="right"   class="blackbold" width="45%"> Reviewer  :<span class="red">*</span> </td>
					<td   align="left" >
	
                   
				
<select name="ReviewerID" class="inputbox" id="ReviewerID">
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
		<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryReview[0]['ReviewerID']){echo "selected";}?>>
		<?=stripslashes($arryEmployee[$i]['UserName']);?> (<?=stripslashes($arryEmployee[$i]['Department']);?>)
		</option>
	<? } ?>
</select>


							</td>
				  </tr>	                       
              


			<tr>
        <td align="right" class="blackbold">Review From   :<span class="red">*</span></td>
        <td  align="left">
<script type="text/javascript">
$(function() {
	$('#FromDate').datepicker(
		{
			showOn: "both",
	dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-10?>:<?=date("Y")?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="FromDate" name="FromDate" readonly="" class="datebox" value="<?=$arryReview[0]['FromDate']?>"  type="text" > 
			
			</td>
      </tr>	

	  <tr>
        <td align="right" class="blackbold">Review To  :<span class="red">*</span></td>
        <td  align="left">
	
<script type="text/javascript">
$(function() {
	$('#ToDate').datepicker(
		{
			showOn: "both",
	dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-10?>:<?=date("Y")?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="ToDate" name="ToDate" readonly="" class="datebox" value="<?=$arryReview[0]['ToDate']?>"  type="text" > 		
			</td>
      </tr>		
			
	<? }else{?>	
	  <tr>
        <td align="center" class="redmsg" ><?=NO_EMPLOYEE_EXIST?></td>
		</tr>
	<? } ?>




<? } ?>	
                  
                  </table></td>
                </tr>

				<? if($HideSubmit!=1){ ?>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="reviewID" id="reviewID"  value="<?=$_GET['edit']?>" />
		
				  
				  </td></tr> 
				  <? } ?>


				
              </form>
          </table>
