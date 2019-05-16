<? 
if($CustID>0){
	$arryContact = $objCustomer->GetAllAddress($CustID);
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<? if($_GET['edit']>0){ ?>	
<tr>
<td colspan="2" align="right" height="30">
<a class="fancybox add fancybox.iframe" href="../editCustContact.php?CustID=<?=$CustID?>">Add Contact</a>
</td>
</tr>
<? } ?>

	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="10" width="100%" align="center">
   
    <?php 
	
  if(sizeof($arryContact)>0){
?>


<?
  	$flag=true;
	$Line=0;
  	foreach($arryContact as $key=>$values){
	$flag=!$flag;
	//$class=($flag)?("oddbg"):("evenbg");
	$Line++;
	
  ?>
    <tr align="left" class="oddbg" >
      <td>
	
<div style="float:right;margin-top:20px;">
<a href="Javascript:void(0)" class="action_bt" 
onclick="Javascript:SetAddress('<?=$CustID?>','<?=$values['AddID']?>');"><?=CLICK_TO_SELECT?></a>
</div>

	  <? 	
	  
	if($values['PrimaryContact']==1){
		$Primary ='<span class=red >&nbsp;&nbsp;[Primary Contact]</span>';
	}else if($values['AddType']=='billing' || $values['AddType']=='shipping'){
		$Primary ='<span class=red >&nbsp;&nbsp;['.ucfirst($values['AddType']).' Address]</span>';			
	}else{		
		$Primary = '';
	}

	


	$ContactInfo = '<strong>'.$Line.'. '.stripslashes($values["FullName"]).'</strong>'.$Primary.'
	<br>'.nl2br(stripslashes($values["Address"])).',
	<br>'.htmlentities($values["CityName"], ENT_IGNORE).', '.stripslashes($values["StateName"]).',
	<br>'.stripslashes($values["CountryName"]).' - '.stripslashes($values["ZipCode"]).'';

	if(!empty($values["Mobile"]))
		$ContactInfo .=	'<br>Mobile : '.stripslashes($values["Mobile"]);  
	if(!empty($values["Landline"]))
		$ContactInfo .=	'<br>Landline : '.stripslashes($values["Landline"]);  
	if(!empty($values["Fax"]))
		$ContactInfo .=	'<br>Fax : '.stripslashes($values["Fax"]);  
	if(!empty($values["Email"]))
		$ContactInfo .=	'<br>Email : '.stripslashes($values["Email"]);  

	echo $ContactInfo;
	  ?>
	  
	  
	  </td>
  
     </tr>
    <?php 
	//if($Line%2==0) echo '</tr><tr bgcolor="#FFFFFF">';

} // foreach end //

	



?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
		 
	<input type="hidden" name="CurrentDivision" id="CurrentDivision" value="<?=strtolower($CurrentDepartment)?>">	 
		 </td>
	</tr>	
	

</table>
<? } ?>
