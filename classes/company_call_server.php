<?php 
	/****************************/
        $_GET['cmp']=$_GET['edit'];
	require_once("userInfoConnection.php");
	$_SESSION['locationID']=1;
	/****************************/



	require_once("../classes/user.class.php");
	require_once("../classes/employee.class.php");
	require_once("../classes/dbfunction.class.php");
	require_once("../classes/phone.class.php");

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
		if(!empty($_POST['server'])){
			if(empty($_POST['call_setting_id'])){
			$name = $arryCompany[0]['DisplayName'];
				$responce=$objphone->CreateGroup($name,$_POST['server']);
				if(!empty($responce['error'])){
					$_SESSION['mess_company']=$responce['error'];				
				}else{
					header("Location:editCompany.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."&tab=".$_GET['tab']);
				}
			}
		
		}
	
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
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
$servers=$objphone->ListServer(array('status'=>'Active'));
	
?>
	 
	<tr>
	  <td  valign="top">
		<table width="100%" cellspacing="0" cellpadding="5" border="0"
			class="borderall">
			<tr>
				<td align="left" class="head" colspan="2">Call Server</td>
			</tr>
			<tr>
				<td width="45%" valign="top" align="right">Server :</td>
				<td valign="top" align="left"><select name="server" class="inputbox">
					<option value="">Select Server</option>
					<?php if(!empty($servers)){
					foreach($servers as $server){
					echo '<option value="'.$server->id.'">'.$server->server_name.'</option>';
					
					}
					
					}?>
				</select></td>
			</tr>
			<tr>
				<td width="45%" valign="top" align="right">Group Name :</td>
				<td valign="top" align="left"><input type="text" name="groupname" class="inputbox">
			</td>
			<tr>
				<td width="45%" valign="top" align="right">&nbsp;</td>
				<td valign="top" align="left"><input type="submit" value="Save" class="button">
			</td>
			</tr>
		</table>
	  
	  
		</td>
	</tr>
	<? } ?>
</table>
<?}?>
