<? 
if($CustID>0){

	/********* By Karishma for MultiStore 22 Dec 2015******/	
	if($_GET['tab']=='shipping'){
		$arryContact = $objCustomer->GetCustomerContact($CustID,'','1',' , Status DESC');
		$ContactModule = 'Shipping Address';
	}else{
		$arryContact = $objCustomer->GetCustomerContact($CustID,'',null,' , Status DESC');
		$ContactModule = 'Contact';
	}
	/*****End By Karishma for MultiStore 22 Dec 2015**********/
	$Primary = '';
	
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<? if($_GET['edit']>0){ ?>	
<tr>
<td colspan="2" align="right" height="30">
<a class="fancybox add fancybox.iframe" href="../editCustContact.php?CustID=<?=$CustID?>&tab=<?=$_GET['tab']?>"><?if($_GET['tab']=="shipping") echo "Add Address";else echo "Add Contact";?> </a> <!--By chetan 10DEc-->
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
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;
	/********* By Karishma for MultiStore 22 Dec 2015******/
	$PrimaryClass='';
	if($_GET['tab']=='shipping'){
		
		$PrimaryClass=($values["Status"]=='1')?'in-active':'';
	}elseif($_GET['tab']=='contacts'){
		$PrimaryClass=empty($values['Status'])?'in-active':'';
	}
	/*****End By Karishma for MultiStore 22 Dec 2015**********/
  ?>
    <tr align="left" class="<?=$class?> <?php echo $PrimaryClass;?>" >
      <td>
	<div class="contact-box">
	  <? 	
	  
	if($_GET['edit']>0){
		echo '<div style="float:right;">';
		echo '<a class="fancybox fancybox.iframe" href="../editCustContact.php?AddID='.$values['AddID'].'&CustID='.$CustID.'&tab='.$_GET['tab'].'">'.$edit.'</a>';
		if($values['PrimaryContact']==1){
			$Primary ='<span class=red >&nbsp;&nbsp;[Primary Contact]</span>';			
		}else{
			echo '&nbsp;&nbsp;&nbsp;<a href="editCustomer.php?del_contact='.$values['AddID'].'&CustID='.$CustID.'&tab='.$_GET['tab'].'" onclick="return confirmDialog(this, \''.$ContactModule.'\')">'.$delete.'</a>';
			$Primary = '';
		}
		echo '</div>';
	}
if($_GET['tab']=='contacts'){
$ContactInfo = '<strong>'.$Line.'. '.stripslashes($values["FullName"]).'</strong>'.$Primary;
}else{
$ContactInfo = '<strong>'.$Line.'. '.stripslashes($values["Company"]).'</strong>'.$Primary;
}

	$ContactInfo .= '<br>'.nl2br(stripslashes($values["Address"]));
	if(!empty($values["CityName"]))$ContactInfo .= ', <br>'.htmlentities($values["CityName"], ENT_IGNORE);
	if(!empty($values["StateName"]))$ContactInfo .= ', '.stripslashes($values["StateName"]);
	$ContactInfo .= '<br>'.stripslashes($values["CountryName"]).' - '.stripslashes($values["ZipCode"]).'';

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
	  
	  </div>
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
