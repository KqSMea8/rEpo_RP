<link href="includes/dashboard.css" rel="stylesheet" type="text/css">

<? 

	function GetClassName($Module){
		$Module = str_replace("&","",$Module);
		$Module = str_replace(" ","_",$Module);
		$Module = str_replace("(","",$Module);
		$Module = str_replace(")","",$Module);
		$Module = str_replace("{","",$Module);
		$Module = str_replace("}","",$Module);
		$Module = str_replace("/","",$Module);
		$Module = str_replace("'","",$Module);

		$Module = preg_replace('/[.,~:>-]/', '_', $Module);
		$Module = strtolower($Module);

		return $Module;
	}

 
	
	if(!empty($RoleGroupUserId)){
		$arryDashboardIcon = $objConfigure->DashboardIconRoleGroupNew($CurrentDepID,$RoleGroupUserId);
	}else{
		$arryDashboardIcon = $objConfigure->DashboardIconNew($CurrentDepID);
	}
	$NumIcon = sizeof($arryDashboardIcon);
 

	/*****Pin Punch Icon*******/
	if(@sizeof($arryExtraIcon)>0){
		if($NumIcon>0){
			$arryDashboardIcon = array_merge($arryDashboardIcon, $arryExtraIcon);
		}else{
			$arryDashboardIcon = $arryExtraIcon;
		}
		$NumIcon = sizeof($arryDashboardIcon);
	}
	/************************/


	if($NumIcon>0){
?>
 <ul class="dashboardul">
 <?	foreach($arryDashboardIcon as $key=>$values){ 
	
		if($values['IframeFancy']=="i"){
			$Iframe = "fancybox fancybox.iframe";
		}else if($values['IframeFancy']=="f"){
			$Iframe = "fancybox";
		}else{
			$Iframe = "";
		}

		($values['Link']=="punching.php")?($Iframe .= " punch"):(""); 


		$className = GetClassName(stripslashes($values['Module']));
		#$className = "icon".$values['IconType'];
	?>
		<li class="<?=$className?>"><a class="<?=$Iframe?>" href="<?=$values['Link']?>"><?=stripslashes($values['Module'])?></a></li>
	 <? } ?>

</ul>
<? } ?>
<script language="JavaScript1.2" type="text/javascript">
$(document).ready(function() {
		$(".punch").fancybox({
			'width'         : 500
		 });

});
</script>
