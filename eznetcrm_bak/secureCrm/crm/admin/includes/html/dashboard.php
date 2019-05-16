
<?  

$NumDepartment = sizeof($arryDepartment);

if($NumDepartment >0 ){
	if($_SESSION['AdminType']=="admin"){
		$NumDepartment = $NumDepartment + 1;
	}

	if($NumDepartment>6){
		$U_With =  165*($NumDepartment); 
		$FinalWidth = round($U_With/2)+150;
	}else{
		$FinalWidth = 990;
	}
?>

<div class="dashboard-nav">
 <span class="had" style="display:none">My Dashboard</span>
<ul style="width:<?=$FinalWidth?>px; margin:auto; text-align:center;">
<? 

for($i=0;$i<sizeof($arryDepartment);$i++) {

	$Department = strtolower($arryDepartment[$i]['Department']);
	
	$FullUrl = $Department.'/home.php';
?>
	<li class="<?=strtolower($arryDepartment[$i]['Department'])?>" >
		<? if($_SESSION['AdminType']=="admin" && $NumLocation>1){?>
			<a class="fancybox" href="#location_div" onclick="Javascript:SetContinueUrl('<?=$FullUrl?>');"><?=$arryDepartment[$i]['Department']?></a>
		<? }else{ ?>
			<a class="fancybox" href="<?=$FullUrl?>"><?=$arryDepartment[$i]['Department']?></a>
		<? } ?>
	</li>
  <? 	/*if (($i+1) % 3 == 0) {
			echo "</tr><tr>";
		}*/
  } ?>

	<? if($_SESSION['AdminType']=="admin"){?>
	<li class="setting"><a class="fancybox" href="editCompany.php">Settings</a></li>
	<? } ?>
	
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

}else{ ?>
	<div class="dashboard-nav">
 		<div class="redmsg" align="center"><?=ERROR_NOT_AUTH?></div>	
	</div>
<? } ?>

	
	 
