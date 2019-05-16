<?
$arrayHeaderMenus = $objConfig->GetHeaderMenusUser($_SESSION['UserID'],$CurrentDepID,'',1);	
$numHeaderMenu = sizeof($arrayHeaderMenus);

//if($numHeaderMenu>0){

	if($CurrentDepID==1) $MoreAfterNum = 135;
	else if($CurrentDepID==4) $MoreAfterNum = 160;
	else if($CurrentDepID==5) $MoreAfterNum = 150;
	else if($CurrentDepID==6) $MoreAfterNum = 150;
	else if($CurrentDepID==7) $MoreAfterNum = 150;
	else $MoreAfterNum = 135;	 


	$BgHmClass = ($SelfPage=="home.php")?("active"):("");
?>

<div class="nav-container" id="main_menu">
    <ul>
		  <? 
		  if($CurrentDepID>0){
				
				echo '<li class="dept_head" >'.$CurrentDepartment.'</li>';
				echo '<li class="'.$BgHmClass.'" ><a href="home.php" >Home</a></li>';
				$fixedLen = strlen($CurrentDepartment)+16;
		 }
		  $cMenu = 1; $Len = $fixedLen;
		  unset($arryMainMenu);
		  foreach($arrayHeaderMenus as $key=>$valuesAdmin){ 
				 $arryMainMenu[] = $valuesAdmin['ModuleID'];
				 $cMenu++;
				 $Len += strlen($valuesAdmin['Module'])+6;

				 $BgClass = ($ModuleParentID == $valuesAdmin['ModuleID'])?("active"):("");
				
				 $ArrTopLink =  $objConfig->GetHeaderTopLink($valuesAdmin['ModuleID']);


				 if($valuesAdmin['ModuleID'] == 1){
					 $MainLink = $MainPrefix.$ArrTopLink[0]['Link'];
				 }else{
					 $MainLink = $DeptFolder.$ArrTopLink[0]['Link'];
				 }
				 
				
				//if($MoreFlag!=1 && $cMenu>=$MoreAfterNum){
				if($MoreFlag!=1 && $Len>=$MoreAfterNum){
					$MoreFlag=1;
					echo '<li class="more_last"><a href="#" class="more_last_a">More...</a>';
					echo '<ul class="more_menu_ul">';
				}


				if($MoreFlag==1 && !empty($BgClass)){ $MoreModule=1; }

				echo '<li class="'.$BgClass.'"><a href="'.$MainLink.'">'.$valuesAdmin['Module'].'</a></li>';
		

				if($MoreFlag==1 && $cMenu==$numHeaderMenu+1){
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
			$(".more_last_a").css("color", "#d33f3e");
		<? } ?>

		$(".more_last").hover(function(){
		  $(".more_menu_ul").show(500);
		}); 

		$(".more_last").mouseleave(function(){
		  $(".more_menu_ul").hide(500);
		}); 

	});
</script>

<? } ?>
