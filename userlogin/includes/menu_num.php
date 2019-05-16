<?
$arrayHeaderMenus = $objConfig->GetHeaderMenusUser($_SESSION['UserID'],$CurrentDepID,'',1);	
$numHeaderMenu = sizeof($arrayHeaderMenus);
if($numHeaderMenu>0){
//echo '<pre>';print_r($arrayHeaderMenus); exit;

if($CurrentDepID==5) $MoreAfterNum = 10;
else $MoreAfterNum = 9;
$BgHmClass = ($SelfPage=="home.php")?("active"):("");
?>

<div class="nav-container" id="main_menu">
    <ul>
		  <? 
		  if($CurrentDepID>0)echo '<li class="'.$BgHmClass.'" ><a href="home.php" >Home</a></li>';
		  $cMenu = 1;
		  foreach($arrayHeaderMenus as $key=>$valuesAdmin){ 
				 $cMenu++;
				 
				 $BgClass = ($ModuleParentID == $valuesAdmin['ModuleID'])?("active"):("");
				
				 $ArrTopLink =  $objConfig->GetHeaderTopLink($valuesAdmin['ModuleID']);


				 if($valuesAdmin['ModuleID'] == 1){
					 $MainLink = $MainPrefix.$ArrTopLink[0]['Link'];
				 }else{
					 $MainLink = $DeptFolder.$ArrTopLink[0]['Link'];
				 }
				 
				
				if($cMenu==$MoreAfterNum && $numHeaderMenu>=$MoreAfterNum){
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
<? } ?>



<? if($MoreFlag==1){ ?>
	<script type="text/javascript">
	$(document).ready(function() {
		
		<? if(!empty($MoreModule)){ ?>
			$(".more_last_a").css("color", "#d33f3e");
		<? } ?>

		$(".more_last").hover(function(){
		  $(".more_menu_ul").slideToggle(500);
		}); 


	});
</script>

<? } ?>