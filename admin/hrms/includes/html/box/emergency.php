<? 
$arryEmergency = $objEmployee->GetEmergency($EmpID);
?>

<script language="JavaScript1.2" type="text/javascript">
function validate_emergency(frm){
	if( ValidateForSimpleBlank(frm.Name, "Relative Name")
		&& ValidateForSimpleBlank(frm.Relation, "Relation")
		&& ValidateForSimpleBlank(frm.Address,"Address")
		&& ValidateOptPhoneNumber(frm.Mobile,"Mobile Number",10,20)
		){
			$.fancybox.close();
			ShowHideLoader('1','P');

			return true;	
		}else{
			return false;	
		}	
}
</script>


<div class="right_box">

<? if (!empty($_SESSION['mess_employee'])) {?>
<div class="message" style="padding:20px;"  >
	<? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?>	
</div>
<? } ?>
<div align="right"><a class="add fancybox  fancybox.iframe" href="editEmergency.php?EmpID=<?=$EmpID?>" >Add Emergency Contact</a></div>
<br><br>
<div id="preview_div">
<table <?=$table_bg?>>
    <tr align="left">
      <td width="15%"  class="head1" >Relative Name</td>
      <td width="10%"  class="head1" >Relation</td>
      <td  class="head1" >Address</td>
       <td width="15%" class="head1" >Mobile</td>
      <td width="15%"  class="head1" >Home Phone</td>
      <td width="15%"  class="head1" >Work Phone</td>
        <td width="10%"  class="head1" align="center" >Action</td>
   </tr>
   
    <?php 
	
  if(sizeof($arryEmergency)>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmergency as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
      <td><?=stripslashes($values["Name"])?></td>
      <td><?=stripslashes($values["Relation"])?></td>
      <td>
	  
	  <?
	$ContactInfo = stripslashes($values["Address"]);
	if(!empty($values["CityName"]))$ContactInfo .= '<br>'.htmlentities($values["CityName"], ENT_IGNORE).', ';
	if(!empty($values["StateName"])) $ContactInfo .= stripslashes($values["StateName"]).',';

	$ContactInfo .= '<br>'.stripslashes($values["CountryName"]).' - '.stripslashes($values["ZipCode"]); 

	echo $ContactInfo;
	  ?>
	  
	  
	  </td>
      <td><?=stripslashes($values["Mobile"])?></td>
      <td><?=stripslashes($values["HomePhone"])?></td>
      <td><?=stripslashes($values["WorkPhone"])?></td>
      
      <td  align="center" class="head1_inner"  >
	  <a class="fancybox  fancybox.iframe"  href="editEmergency.php?EmpID=<?=$EmpID?>&contactID=<?=$values['contactID']?>" ><?=$edit?></a>
	  
	<a href="<?=$ActionUrl?>&del_emergency=<?=$values['contactID']?>" onclick="return confirmDialog(this, 'Record')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
   <tr >
      <td  colspan="7" id="td_pager"> </td>
    </tr>
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  </table>
</div>





<? //include("includes/html/box/emergency_form.php"); ?>
</div>





