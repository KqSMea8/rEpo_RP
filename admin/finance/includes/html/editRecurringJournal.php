
<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } 
  


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){

	var JournalType = Trim(document.getElementById("JournalType")).value;
	var JournalDateFrom = Trim(document.getElementById("JournalDateFrom")).value;
	var JournalDateTo = Trim(document.getElementById("JournalDateTo")).value;

        if(JournalType == "recurring"){
            if(!ValidateForSelect(frm.JournalDateFrom, "Entry From")){        
              return false;
            }

            /*if(!ValidateForSelect(frm.JournalDateTo, "Entry To")){        
                return false;
            }
            if(JournalDateFrom >= JournalDateTo) {
              document.getElementById("JournalDateFrom").focus();   
              alert("End Date Should be Greater Than Start Date.");
              return false;
             }*/
       }

  
	$("#rec_load").show();
	$("#rec_form").hide();	


}
 
        
</script>


<div id="rec_load" style="display:none;padding:60px;" align="center"><img src="../images/ajaxloader.gif"></div>
<div id="rec_form" style="min-height:200px;">
<form name="form1" id="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr>
	 <td>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 



 <!---Recurring Start-->
  <?php 
 
    $arryRecurr = $arryJournal;

   include("includes/html/box/recurring_2column_journal.php");?>
   
   <!--Recurring End-->

   

</table>

</td>
   </tr>


   <tr>
    <td  align="center">
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
		<input type="hidden" name="JournalID" id="JournalID" value="<?=$_GET['edit']?>" />
	</td>
   </tr>

  
</table>

 </form>
</div>

<? } ?>



