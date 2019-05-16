<?
//$_SESSION['projectID']
$arrayHeaderMenus="";
if($_SESSION['AdminType']=="user"){
	$arrayHeaderMenus = $objUserConfig->GetHeaderMenusUser($_SESSION['AdminID']);
}else if($_SESSION['AdminType']=="admin"){
	$arrayHeaderMenus = $objUserConfig->GetHeaderMenusBySuperadmin($_SESSION['AdminID']);
}	

?>

<div class="nav-container" id="main_menu">
    <ul>
	<li></li>
		  <?  
		
		  if(!empty($arrayHeaderMenus))
		  {       	
 foreach($arrayHeaderMenus as $key=>$valuesAdmin)
{ 
$BgClass = ($ThisPageName==$valuesAdmin['Link'] || $ModuleParent==$valuesAdmin['ModuleID'])?("active"):("");


	if($_SESSION['AdminType']=="user"){
		$arraySubMenus = $objUserConfig->GetHdMenu($_SESSION['AdminID'],$valuesAdmin['ModuleID']);		
	}else{
		$arraySubMenus = $objUserConfig->GetHdMenuAdmin($valuesAdmin['ModuleID']);
	}


	if(!empty($arraySubMenus[0]['Link'])){
		$strlink=$arraySubMenus[0]['Link']; 		
	}else{
		$strlink=$valuesAdmin['Link'];
	}


	echo '<li class="'.$BgClass.'"><a href="'.$strlink.'">'.$valuesAdmin['Module'].'</a></li>';
	$arryLinks[] = $valuesAdmin['Link'];
	
	if(empty($FirstLink)) $FirstLink=$strlink;	
} 
		  
		   }?>
	</ul>
</div>




<? if($MoreFlag==1)
{ ?>
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

<? }
/**
if($_SESSION['AdminType']=="user")
	{ 

    $NotAllowed=in_array($ThisPageName,$arryLinks);
    $Mypage="dashboard.php";

	if($NotAllowed ==0 && $ThisPageName!=$Mypage)
		{
			echo '<div align="center" class="redmsg" style="padding-top:200px;">'.ERROR_NOT_AUTH.'</div>';
			exit;
		}
	
			
	}

//echo $ThisPageName;

//print_r($arryLinks);




?>
**/





