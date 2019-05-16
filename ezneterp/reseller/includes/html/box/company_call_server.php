<?php 
	/****************************/
        $_GET['cmp']=$_GET['edit'];
	require_once("userInfoConnection.php");
	$_SESSION['locationID']=1;
	/****************************/



	require_once($Prefix."classes/user.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");

	$objphone=new phone();	
	$objEmployee=new employee();
	$objUser=new user();
	/*if($CmpID>0 && empty($ErrorMsg)){			    	
		$arryEmployee=$objEmployee->ListEmployee($_GET);
		$num=$objEmployee->numRows();

		$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
		(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
		$viewAll = 'viewEmployee.php?cmp='.$CmpID.'&curP='.$_GET['curP'];
	}*/
	
	if(!empty($_POST)){
		
	
	}


	$Config['DateFormat']='j M, Y';	
?>

<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>
<? if(!empty($ErrorMsg)){
	echo '<div class="redmsg" align="center">'.$ErrorMsg.'</div>';
 }else{ ?>

<div class="message" align="center"><? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<? if($CmpID>0){
$settingArray=$objphone->GetcallSetting();

$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
$servers=$objphone->ListServer(array('status'=>'Active'));
$country_code  =   $objphone->ListCountryCode(array('isd_status'=>'Active'));
$allcode  =   $objphone->CountryCodebyCompanyId(array('company_id'=>$_REQUEST['edit']));

?>
	 
	<tr>
	  <td  valign="top"><form action="" method="POST">
		<table width="100%" cellspacing="0" cellpadding="5" border="0"
			class="borderall">
			<tr>
				<td align="left" class="head" colspan="2">Call Server</td>
			</tr>
			<tr>
				<td width="45%" valign="top" align="right">Server :</td>
				<td valign="top" align="left">
				
				<select name="server" class="inputbox">
					<option value="">Select Server</option>
					<?php if(!empty($servers)){
					foreach($servers as $server){
					$select='';
					if($settingArray[0]->server_id==$server->id)
					$select='selected="selected"';
					echo '<option value="'.$server->id.'" '.$select.'>'.$server->server_name.'</option>';
					
					}
					
					}?>
				</select></td>
			</tr>
			
			<tr>
				<td width="45%" valign="top" align="right">Group Name :</td>
				<td valign="top" align="left"><?php echo !empty($settingArray[0]->group_name)?$settingArray[0]->group_name:'';?>
			</td>
			
			<tr>
				<td width="45%" valign="top" align="right">Country Code :</td>
				<td valign="top" align="left">
				<select name="country_code[]" class="inputbox" multiple style="height: 200px;">
					<option value="">Select Country Code</option>
					<?php if(!empty($country_code)){
					foreach($country_code as $code){
					$select='';
					if(in_array($code->country_id, $allcode)){
					$select='selected="selected"';
					}
					echo '<option value="'.$code->country_id.'" '.$select.'>'.$code->name.'</option>';
					
					}
					
					}?>
				</select>
			</td>
			
			<tr>
				<td width="45%" valign="top" align="right">&nbsp;</td>
				<td valign="top" align="left">
				<input type="hidden" value="<?php echo !empty($settingArray[0]->group_id)?$settingArray[0]->server_id:'';?>" name="old_server">
				<input type="hidden" value="<?php echo !empty($settingArray[0]->group_id)?$settingArray[0]->group_id:'';?>" name="old_group_id">
				<input type="hidden" value="<?php echo !empty($settingArray[0]->id)?$settingArray[0]->id:'';?>" name="call_setting_id">
				<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" />
				<input name="Email" type="hidden" id="Email" value="<?php echo $arryCompany[0]['Email']; ?>"  maxlength="80" />
				<input type="submit" value="Save" class="button">
			</td>
			</tr>
		</table>
	  
	  </form>
		</td>
	</tr>
	<? } ?>
</table>
<?}?>
