
 <form name="form1" id="form1" action=""  method="post" enctype="multipart/form-data">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
   


        <tr>
            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

		<?php
for($h=0;$h<sizeof($arryHead);$h++){
$head = 1;   
?>
                
    <tr>
        <td colspan="4" align="left" class="head"><?=$arryHead[$h]['head_value']?></td>
    </tr>

<?php $arryField = $objField->getFormField('',$arryHead[$h]['head_id'],'1'); 

include("includes/html/box/CustomFieldsNew.php"); 

 }
//head close?>
  

	
	  </table>
	
	</td>
   </tr>

 

   <tr>
    <td  align="center" >
	
	<div id="SubmitDiv" style="display:none1">
	
        <?php if ($_GET['edit'] > 0)
            $ButtonTitle = 'Update ';
        else
            $ButtonTitle = ' Submit ';
        ?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />
     
      <input type="hidden" name="LeadID" id="LeadID" value="<?= $_GET['edit'] ?>" />

      <input type="hidden"  name="main_state_id" id="main_state_id"  value="<?php (!empty($arryLead)) ? $arryLead[0]['state_id'] : ''; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php (!empty($arryLead)) ? $arryLead[0]['city_id'] : ''; ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?= $_SESSION['AdminType'] ?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?= $_SESSION['AdminID'] ?>" />

</div>

</td>
   </tr>
  
</table>
 </form>
<SCRIPT LANGUAGE=JAVASCRIPT>
    StateListSend();
    //ShowPermission();
</SCRIPT>
