<script language="JavaScript1.2" type="text/javascript">
function validateAccount(){	
	ShowHideLoader(1,'S');
	return true;	
	
}
</script>
 

<div class="had">
<?=$MainModuleName?> Settings    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
 <div class="message"><? if (!empty($_SESSION['mess_bank_account'])) {  echo stripslashes($_SESSION['mess_bank_account']);   unset($_SESSION['mess_bank_account']);} ?></div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }
    else{ ?>  
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateAccount(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
  
	<tr>
	<td  align="right"  width="45%" class="blackbold">Year :</td>
	<td   align="left"><?=$arryPeriodFields[0]['PeriodYear'];?></td>
	</tr>	
	 <tr>
		<td  align="right"   class="blackbold">Month :</td>
		<td  align="left"class="blacknormal">
     <?php
        
            $monthNum  = $arryPeriodFields[0]['PeriodMonth'];
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F'); // March
        ?>
    <?=$monthName;?></td>
	</tr>	
 
	 <tr>
		<td  align="right"   class="blackbold">Module :</td>
		<td  align="left"class="blacknormal">
       
        <?=$arryPeriodFields[0]['PeriodModule'];?></td>
	</tr>	 
	 
	<tr>
	<td  align="right"   class="blackbold">Status  : </td>
	<td   align="left"  >
			 
	  <select name="PeriodStatus" id="PeriodStatus" class="inputbox" style="width: 90px;">
            <option value="Open" <?php if($arryPeriodFields[0]['PeriodStatus'] == "Open"){echo "selected";}?>>Open</option>
            <option value="Closed" <?php if($arryPeriodFields[0]['PeriodStatus'] == "Closed"){echo "selected";}?>>Closed</option>
            </select>
        </td>
	</tr>
	

</table>	
  </td>
 </tr>

  
	<tr>
	<td  align="center">
		<input type="hidden" name="active_id" id="active_id"  value="<?=$_GET['edit'];?>" />
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Update"  />
	</td>
	</tr>
 </form>
</table>
    <?php } ?>
