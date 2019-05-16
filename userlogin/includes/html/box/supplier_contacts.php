<? 


if($SuppID>0){
	$arryContact = $objSupplier->GetSupplierContact($SuppID,'');
	$_GET['edit']=1;
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<? if($_GET['edit']>0){ ?>	
<tr>
<td colspan="2" align="right" height="30">
<a class="fancybox add fancybox.iframe" href="editSuppContact.php?SuppID=<?=$SuppID?>">Add Contact</a>
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
    <tr align="left" class="<?=$class?>" >
      <td>
	
	  <? 	
	  
	if($_GET['edit']>0){
		echo '<div style="float:right;">';
		echo '<a class="fancybox fancybox.iframe" href="editSuppContact.php?AddID='.$values['AddID'].'&SuppID='.$SuppID.'">'.$edit.'</a>';
		if($values['PrimaryContact']==1){
			$Primary ='<span class=red >&nbsp;&nbsp;[Primary Contact]</span>';			
		}else{
			echo '&nbsp;&nbsp;&nbsp;<a href="editSupplier.php?del_contact='.$values['AddID'].'&SuppID='.$SuppID.'" onclick="return confirmDialog(this, \'Contact\')">'.$delete.'</a>';
			$Primary = '';
		}
		echo '</div>';
	}


	$ContactInfo = '<strong>'.$Line.'. '.stripslashes($values["Name"]).'</strong>'.$Primary.'
	<br>'.nl2br(stripslashes($values["Address"])).',
	<br>'.htmlentities($values["City"], ENT_IGNORE).', '.stripslashes($values["State"]).',
	<br>'.stripslashes($values["Country"]).' - '.stripslashes($values["ZipCode"]).'';

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
		 
	 
		 </td>
	</tr>	
	

</table>
<? } ?>
