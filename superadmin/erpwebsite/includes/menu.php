<?php
$arrayHeaderMenus="";
if($_SESSION['AdminType']=="user")
{ 
$arrayHeaderMenus = $objUserConfig->GetHeaderMenusUser($_SESSION['AdminID']);


}
else if($_SESSION['AdminType']=="admin")	
{

$arrayHeaderMenus = $objUserConfig->GetHeaderMenusBySuperadmin($_SESSION['AdminID']);
//echo "<pre>";
//print_r($arrayHeaderMenus);
}	

?>

<div class="nav-container" id="main_menu">
    <ul>
	<li></li>
		  <?php  
		
		  if(sizeof($arrayHeaderMenus)>0)
		  {       	
 foreach($arrayHeaderMenus as $key=>$valuesAdmin)
{ 
$BgClass = ($ThisPageName==$valuesAdmin['Link'])?("active"):("");


	if($_SESSION['AdminType']=="user")
	{
		$arraySubMenus = $objUserConfig->GetHdMenu($_SESSION['AdminID'],$valuesAdmin['ModuleID']);
		
	}else{
		$arraySubMenus = $objUserConfig->GetHdMenuAdmin($valuesAdmin['ModuleID']);
                
	}


if($arraySubMenus[0][Link]!='')
{
	$strlink=$arraySubMenus[0][Link]; 
	//$strlink=$valuesAdmin['Link'];
}
else 
{
	$strlink=$valuesAdmin['Link'];
}

//$ThisPageName==$valuesAdmin['Link']

echo '<li class="'.$BgClass.'"><a href="../'.$strlink.'">'.$valuesAdmin['Module'].'</a></li>';
$arryLinks[] = $valuesAdmin['Link'];
		
} 
		  
		   }?>
		   <!--li><a href="../webShare/pageList.php">WebShare</a></li-->
	</ul>
</div>




<?php if($MoreFlag==1)
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

<?php }
/**
if($_SESSION['AdminType']=="user"){  $NotAllowed=in_array($ThisPageName,$arryLinks); $Mypage="adminDesktop.php";if($NotAllowed ==0 && $ThisPageName!=$Mypage){echo '<div align="center" class="redmsg" style="padding-top:200px;">'.ERROR_NOT_AUTH.'</div>';exit;	}}//echo $ThisPageName;
//print_r($arryLinks);*/
?>




