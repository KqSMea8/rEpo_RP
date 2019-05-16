<div id="add_participant" style="display:none; width:800px; height:500px;">
<form action="" method="post" name="formAdd" onSubmit="return validateAddPart(this);">
<div class="had2">&nbsp;Add Participant</div>
<div id="part_load" style="display:none;" align="center" class="redmsg"><br><br><img src="../images/ajaxloader.gif"></div>
<div id="part_list" style="width:800px; height:430px; overflow:auto">
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="4%" class="head1" align="center"><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','EmpID','<?=sizeof($arryEmployee)?>');" /></td>
      <td width="10%" class="head1" >Emp Code</td>
      <td width="20%"  class="head1" >Employee Name</td>
      <td width="20%" class="head1" >Email</td>
      <td width="20%" class="head1" >Department</td>
      <td  class="head1" >Designation</td>
    </tr>
   
    <?php 
  if(is_array($arryEmployee)){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;

  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td  align="center"><input type="checkbox" name="EmpID[]" id="EmpID<?=$Line?>" value="<?=$values['EmpID']?>" /></td>
     <td height="25"><?=$values["EmpCode"]?></td>
     <td><?=stripslashes($values["UserName"])?></td>
     <td><?=stripslashes($values["Email"])?></td>
	 <td><?=stripslashes($values["Department"])?></td>
	 <td><?=stripslashes($values["JobTitle"])?></td>
    </tr>
    <?php } // foreach end //?>
  




    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	
  </table>






 
</div>
  

 <div align="center" style="padding-top:8px;">
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit "  />
	<input type="hidden" name="trainingID" id="trainingID" value="<?=$_GET['t']?>" />  
	<input type="hidden" name="numEmployee" id="numEmployee" value="<?=sizeof($arryEmployee)?>" />  



 </div>

 </form>

</div>


<script language="JavaScript1.2" type="text/javascript">
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
					document.getElementById("SubmitButton").style.display = 'none';
				
					document.getElementById("part_list").style.display = 'none';
					document.getElementById("part_load").style.display = 'block';
					document.getElementById("add_participant").style.height = '200px';

					return true;
				}

		}

		return false;
		
}
</script>
