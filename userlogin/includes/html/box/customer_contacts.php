<? 
if($CustID>0){
	if($_SESSION['UserType']=='customer')
		$_GET['edit']=1;
	$arryContact = $objCustomer->GetCustomerContact($CustID,'',1,', Status Desc');
?>
 <div  align="center"  class="message"  >
          <?php if(!empty($_SESSION['mess_cust'])) {echo $_SESSION['mess_cust']; unset($_SESSION['mess_cust']); }?>	
        </div>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<? if($_GET['edit']>0){ ?>	
<tr>
<td colspan="2" align="right" height="30">
<a class="fancybox add fancybox.iframe" href="editCustContact.php?CustID=<?=$CustID?>&tab=<?=$_GET['tab']?>">Add Contact</a>
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
	 
  ?>
    <tr align="left" class="<?=$class?><?php echo ($_GET['tab']=='shipping' && $values["Status"]=='1')? ' in-active':''; ?>" >
      <td>
	
	  <? 	
	  
	if($_GET['edit']>0){
		echo '<div style="float:right;">';
		echo '<a class="fancybox fancybox.iframe" href="editCustContact.php?AddID='.$values['AddID'].'&CustID='.$CustID.'&tab='.$_GET['tab'].'">'.$edit.'</a>';
		if($values['PrimaryContact']==1){
			$Primary ='<span class=red >&nbsp;&nbsp;[Primary Contact]</span>';			
		}else{
			echo '&nbsp;&nbsp;&nbsp;<a href="editCustomer.php?del_contact='.$values['AddID'].'&CustID='.$CustID.'&tab='.$_GET['tab'].'" onclick="return confirmDialog(this, \'Contact\')">'.$delete.'</a>';
			$Primary = '';
		}
		echo '</div>';
	}

	$defaultShip=($_GET['tab']=='shipping' && $values["Status"]=='1')? ' <span class=red >&nbsp;&nbsp;[Default Contact]</span>':'';
	
	$ContactInfo = '<strong>'.$Line.'. '.stripslashes($values["FullName"]).'</strong>'.$Primary.$defaultShip.'
	
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
