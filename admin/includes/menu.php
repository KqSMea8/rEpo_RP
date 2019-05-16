<?

if(!empty($RoleGroupUserId)){
	$arrayHeaderMenus = $objConfig->GetHeaderMenusUserGroupNew($RoleGroupUserId,$CurrentDepID,'',1);	
}else{
	$arrayHeaderMenus = $objConfig->GetHeaderMenusUserNew($_SESSION['UserID'],$CurrentDepID,'',1);
}	

$numHeaderMenu = sizeof($arrayHeaderMenus);

//if($numHeaderMenu>0){

	if($CurrentDepID==1) $MoreAfterNum = 135;
	else if($CurrentDepID==4) $MoreAfterNum = 160;
	else if($CurrentDepID==5) $MoreAfterNum = 150;
	else if($CurrentDepID==6) $MoreAfterNum = 150;
	else if($CurrentDepID==7) $MoreAfterNum = 150;
	else $MoreAfterNum = 135;	 


	$BgHmClass = ($SelfPage=="home.php")?("active"):("");

 	$fixedLen=$MoreFlag=$SettingSecurityDep=0;
?>

<div class="nav-container" id="main_menu">
    <ul>
	  <? 

		 if($CurrentDepID=='10' || $CurrentDepID=='11'){
				echo '<li></li>';
				$SettingSecurityDep = true;
		 }else{
			echo '<li class="dept_head" >'.$CurrentDepartment.'</li>';
			echo '<li  ><a href="home.php" >Home</a></li>';
			$fixedLen = strlen($CurrentDepartment)+16;
		 }
		  $cMenu = 1; $Len = $fixedLen;
		  unset($arryMainMenu);
		  foreach($arrayHeaderMenus as $key=>$valuesAdmin){ 
				 $arryMainMenu[] = $valuesAdmin['ModuleID'];
				 $cMenu++;
				 $Len += strlen($valuesAdmin['Module'])+6;

				 $BgClass = ($ModuleParentID == $valuesAdmin['ModuleID'])?("active"):("");
				
				 $ArrTopLink =  $objConfig->GetHeaderTopLinkNew($valuesAdmin['ModuleID'],$valuesAdmin['Default'],$RoleGroupUserId);
		
				 $TopLinkUrl = (!empty($ArrTopLink[0]['Link']))?($ArrTopLink[0]['Link']):('home.php');

				 if($valuesAdmin['ModuleID'] == 1 || $valuesAdmin['ModuleID'] == 16){
					 $MainLink = $MainPrefix.$TopLinkUrl;
				 }else{
					 $MainLink = $DeptFolder.$TopLinkUrl;
				 }
				 
				
				//if($MoreFlag!=1 && $cMenu>=$MoreAfterNum){
				if($MoreFlag!=1 && $Len>=$MoreAfterNum){
					$MoreFlag=1;
					echo '<li class="more_last"><a href="#" class="more_last_a">More...</a>';
					echo '<ul class="more_menu_ul">';
				}


				if($MoreFlag==1 && !empty($BgClass)){ $MoreModule=1; }


				if($SettingSecurityDep){
					echo '<li class="dept_head" >'.$valuesAdmin['Module'].'</li>';
				}else{
					echo '<li class="'.$BgClass.'"><a href="'.$MainLink.'">'.$valuesAdmin['Module'].'</a></li>';
				}

 

				if($MoreFlag==1 && $cMenu==$numHeaderMenu+1){
					/*if($Config['CurrentDepID']==5){					
						echo '<li class="'.$BgWClass.'" ><a href="workspace.php">Workspace</a></li>';
					}*/
					echo '</ul></li>';
				}
		  
		  
		  } ?>
	</ul>
</div>
<? //} ?>



<? if($MoreFlag==1){ ?>
	<script type="text/javascript">
	$(document).ready(function() {
		
		<? if(!empty($MoreModule)){ ?>
			$(".more_last_a").css("color", "#aaa");
		<? } ?>

		$(".more_last").click(function(){
		  $(".more_menu_ul").show(500);
		}); 

		$(".more_last").mouseleave(function(){
		  $(".more_menu_ul").hide(500);
		}); 

	});
</script>

<? } ?>
