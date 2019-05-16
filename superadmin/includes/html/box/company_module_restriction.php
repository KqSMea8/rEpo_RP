<?php 
	require_once("../classes/company.class.php");
	$objCompany=new company();
	
	

	$_GET['d']=(int)$_GET['d'];
	$numModule=0;

	if($_GET['edit']>0){
		$arryCompany = $objCompany->GetCompany($_GET['edit'],'');
		$CmpID   = $arryCompany[0]['CmpID'];		
		$RedirectUrl = 'editCompany.php?edit='.$CmpID.'&curP='.$_GET['curP'].'&d='.$_GET['d'].'&tab=restricted';	
		
		$CmpDepartment = $arryCompany[0]['Department'];
		
		if($CmpID>0){
			/********Connecting to main database*********/
			$CmpDatabase = $Config['DbName']."_".$arryCompany[0]['DisplayName'];
			$Config['DbName2'] = $CmpDatabase;
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}else{
				$Config['DbName'] = $CmpDatabase;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
			
				/*******************************************/			
				if ($_POST) {
					CleanPost();
					if(!empty($_POST['numModule'])) {
						$objConfigure->updateRestrictionMenuSettings($_POST);
						$_SESSION['mess_res'] = MODULE_RESTRICTION_UPDATED;
					}
					header("location: ".$RedirectUrl);
					exit;
				}
				/*******************************************/				
				$arryDepartment = $objConfigure->GetDepartment();

				if(!empty($CmpDepartment)){
					$arryCmpDepartment = explode(",",$CmpDepartment);
					$Count=0;
					for($i=0;$i<sizeof($arryDepartment);$i++) {
						if(in_array($arryDepartment[$i]['depID'],$arryCmpDepartment)) {
							$arryTempDepartment[$Count]['depID'] = $arryDepartment[$i]['depID']; 
							$arryTempDepartment[$Count]['Department'] = $arryDepartment[$i]['Department'];						$Count++;
						}
					}
					unset($arryDepartment);
					$arryDepartment = $arryTempDepartment;
					
				}


				if($_GET['d']>0){				
					$arryMainMenu = $objConfigure->GetMainMenu($_GET['d']);
					//echo "<pre>";print_r($arryMainMenu);die;
					$numModule = sizeof($arryMainMenu);
				}

			}			
		}
	}

	
?>


<script language="JavaScript1.2" type="text/javascript">

function SelectAllRecord()
{	
	for(i=1; i<=document.form1.numModule.value; i++){
		document.getElementById("ModuleID"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.numModule.value; i++){
		document.getElementById("ModuleID"+i).checked=false;
	}
}


function ShowListing(){
	ShowHideLoader('1','L');	
	location.href = "<?php echo 'editCompany.php?edit='.$CmpID.'&mode='.$_GET['mode'].'&tab=restricted';?>&d="+document.getElementById("DepartmentID").value;

}

function validateForm(frm){
	ShowHideLoader('1','S');	
	return true;
}
</script>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


<? if($CmpID>0){?>

<? if(!empty($ErrorMsg)){?>
	<tr>
	  <td height="50" align="center" class="redmsg">
<?=$ErrorMsg?>
</td>
</tr>
<? }else{?>



	<tr>
	  <td  valign="top">
<div class="message" align="center"><? if(!empty($_SESSION['mess_res'])) {echo $_SESSION['mess_res']; unset($_SESSION['mess_res']); }?></div>	  
	
<table width="100%"   border="0" cellpadding="0" cellspacing="0" >
  <form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
    <tr>
      <td align="center" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
          <tr>
            <td colspan="2" height="5"></td>
          </tr>
          <tr>
            <td  align="right"   class="blackbold" width="12%"> Division  : </td>
            <td   align="left" ><select name="DepartmentID" class="inputbox" id="DepartmentID" onChange="Javascript:ShowListing();">
                <option value="">--- Select ---</option>
                <? for($i=0;$i<sizeof($arryDepartment);$i++) {?>
                <option value="<?=$arryDepartment[$i]['depID']?>" <?=($_GET['d']==$arryDepartment[$i]['depID'])?("selected"):("")?> >
                <?=$arryDepartment[$i]['Department']?>
                </option>
                <? } ?>
              </select></td>
          </tr>
          <tr>
            <td colspan="2" align="right" height="5"><?   if($numModule >1){ 	?>
              <a href="javascript:SelectAllRecord();">Select All</a> | <a href="javascript:SelectNoneRecords();" >Select None</a>
              <? } ?></td>
          </tr>
          <? if($_GET["d"]>0){ ?>
          <tr>
            <td  align="right"   class="blackbold" valign="top" > Show Menu  : </td>
            <td   align="left" ><?  if($numModule>0){ ?>
              <table width="100%"  border="0" cellspacing=3 cellpadding=5 >
                <? 
  	$flag=true;
	$Line=0;
  	foreach($arryMainMenu as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	
	if ($Line % 3 == 0) {
		echo "</tr><tr>";
	}

	$Line++;
	
	$checked=($values['Restricted']=='1')?("checked"):("");

  ?>
                
                  <td valign="top" width="33%">
<label>
		<input type="checkbox" name="ModuleID[]" id="ModuleID<?=$Line?>" value="<?=$values['ModuleID']?>" <?=$checked?>/>
                    <input type="hidden" name="MainModuleID[]" id="MainModuleID<?=$Line?>" value="<?=$values['ModuleID']?>" />
                    &nbsp;
                    
                    <?=stripslashes($values['Module'])?></label>
                  </td>
                  <?php } // foreach end //?>
              </table>
              <?php }else{ echo NO_MODULE; } ?></td>
          </tr>
          <? } ?>
        </table></td>
    </tr>
    <? if(!empty($numModule)){  ?>
    <tr>
      <td align="center"  height="50"><input name="Submit" type="submit" id="SubmitButton" class="button" value="Submit" />
        <input type="hidden" name="numModule" id="numModule" value="<?=$numModule?>" /></td>
    </tr>
    <? } ?>
  </form>
</table>

</td>
</tr>

<? } } ?>


</table>

