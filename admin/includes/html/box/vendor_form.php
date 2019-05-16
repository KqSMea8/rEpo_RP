<script language="JavaScript1.2" type="text/javascript">
function SelectDeselectRecordForVendor(checkAll,inercheck)
{	
	var i=0;
	var Checked = false;
	if(document.getElementById(checkAll).checked)
		{
	
		Checked = true;
	
	//alert(document.getElementById('LineVendor').value);

	
	    }

	
   
	for(i=1; i<=document.form1.LineVendor.value; i++)
		{
		//alert('abcdee');
		document.getElementById(inercheck+i).checked=Checked;
		
	}

}
</script>

<? 
$arryVendor=$objEmployee->GetEmpVender($EmpID);
$LineVendor=0;
?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post"  enctype="multipart/form-data">
  <? if (!empty($_SESSION['mess_user'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? echo $_SESSION['mess_user']; unset($_SESSION['mess_user']); ?>	
</td>
</tr>
<? } ?>

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

 <tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>




<tr>
       <td align="left" colspan="2">
 			   
						   
<table width="100%" cellspacing=0 cellpadding=0 style="background-color:#EFEFEF"  align="left">
	<tr>
	<td width="25%" class="head"><strong>Vendor Code</strong></td>
	<td width="35%" class="head"><strong>Vendor Name</strong></td>
	<td class="head"><label><input type="checkbox" name="checkAll" id="checkAll" onclick="javascript:SelectDeselectRecordForVendor('checkAll','inercheck');"  /> Checked</label></td>
	</tr>
</table> 


	 </td>
 </tr> 


<tr>
       <td align="left" colspan="2">
      
      <? 
      

	
	if(sizeof($arryVendor)>0)
	{
		
		
		echo '<table width="100%" cellspacing=0 cellpadding=0 align="left">';
		foreach($arryVendor as $key=>$valuesMod)
		{
			$LineVendor++; 
	
				echo '<tr>
			
			
			<td width="25%"><a class="fancybox fancybox.iframe" href="'.$MainPrefix.'finance/suppInfo.php?view='.$valuesMod['SuppCode'].'" >'.$valuesMod["SuppCode"].'</a></td>
			<td width="35%">'.stripslashes($valuesMod['CompanyName']).'</td> ';
			
		?>
			
			
<td >
<input type="checkbox" name="inercheck[]" id="inercheck<?=$LineVendor?>" value="<?=$valuesMod['SuppCode']?>" <? if(!empty($valuesMod['CheckedID']) && !empty($_GET['edit'])) echo " checked"; ?>/></td>
	
	</td>
	
			<?
					
			echo '</tr>';
			
		} 
		 
	echo '</table>';

	  }
    
							
 ?>    
  

   <input type="hidden" name="LineVendor" id="LineVendor" value="<?=$LineVendor?>" />

 </td>
 </tr> 
       
	
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryEmployee[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryEmployee[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>















