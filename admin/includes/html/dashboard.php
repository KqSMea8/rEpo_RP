<?  
$dest = $_SERVER['DOCUMENT_ROOT']."/erp/admin/e-commerce/".$_SESSION['DisplayName'];
$NumDepartment = sizeof($arryDepartment);


if($NumDepartment >0 ){
	/*if($_SESSION['AdminType']=="admin"){
		$NumDepartment = $NumDepartment + 1;
	}*/

	if($NumDepartment>6){
		$U_With =  170*($NumDepartment); 
		$FinalWidth = round($U_With/2)+150;
	}else{
		$FinalWidth = 1000;
	}
?>

<div class="dashboard-nav">
 <span class="had" style="display:none">My Dashboard</span>
<ul style="width:<?=$FinalWidth?>px; margin:auto; text-align:center;">
<? 

for($i=0;$i<sizeof($arryDepartment);$i++) {
	$depID = $arryDepartment[$i]['depID'];
	$Department = strtolower($arryDepartment[$i]['Department']);
	
	//$FullUrl = $Department.'/home.php';
if($Department=='edi'){   $_SESSION['EDI_Access'] = 'enable'; }
	if($Department=='e-commerce' && $Config['ecomType']!='' && (is_dir($dest))){
		$FullUrl = $Department.'/'.$_SESSION['DisplayName'].'/home.php';
	}else{
		$FullUrl = $Department.'/home.php';
	}

	/*****To check header menu****/
	if($_SESSION['AdminType']!="admin" && $depID==5){		
		if(!empty($RoleGroupUserId)){
			$arraySectionMenus = $objConfig->GetHeaderMenusUserGroupNew($RoleGroupUserId,$depID,'',1);	
		}else{ 
			$arraySectionMenus = $objConfig->GetHeaderMenusUserNew($_SESSION['UserID'],$depID,'',1);
		}
		$SectionMenuFlag = sizeof($arraySectionMenus);
	}else{
		$SectionMenuFlag = 1;		
	}
	/*****************************/

	if(!empty($SectionMenuFlag)){
?>
	<li class="<?=strtolower($arryDepartment[$i]['Department'])?>" >


		<? if($depID == 10 || $depID == 11){ 
			$HeaderTopLink = $objConfig->GetHeaderTopLinkDash($depID,$RoleGroupUserId);
		?>
			<a href="<?=$HeaderTopLink[0]['Link'];?>"><?=$arryDepartment[$i]['Department']?></a>
		<? }else if($_SESSION['AdminType']=="admin" && $NumLocation>1){?>
			<a class="fancybox" href="#location_div" onclick="Javascript:SetContinueUrl('<?=$FullUrl?>');"><?=$arryDepartment[$i]['Department']?></a>
		<? }else{ ?>
			<a class="fancybox" href="<?=$FullUrl?>"><?=$arryDepartment[$i]['Department']?></a>
		<? } ?>
	</li>
  <? 	} 
  } ?>

	 
	
  </ul>
</div>
			

<script language="JavaScript1.2" type="text/javascript">
$(document).ready(function() {
		$(".fancybox").fancybox({
			'arrows'		  : false
		 });

});
</script>

  <?  include("includes/html/box/select_location.php"); 

      include("includes/html/box/security_level.php");
	

}else{ 

	if($PinPunch==1){
		header("Location:hrms/home.php");
		exit;
	}


?>
	<div class="dashboard-nav">
 		<div class="redmsg" align="center"><?=ERROR_NOT_AUTH?></div>	
	</div>
<? } ?>

	
	 
