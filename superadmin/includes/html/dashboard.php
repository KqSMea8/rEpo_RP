<?  
$NumProject = sizeof($arryProject);

if($NumProject >0 ){
	if($NumProject>6){
		$U_With =  170*($NumProject); 
		$FinalWidth = round($U_With/2)+150;
	}else{
		$FinalWidth = 800;
	}

?>

<div class="dashboard-nav">

<ul style="width:<?=$FinalWidth?>px; margin:auto; text-align:center;">
<? 
$CountIcon=0;
for($i=0;$i<sizeof($arryProject);$i++) {
	$ShowIconFlag = 1;
	
	if($_SESSION['AdminType']=="user"){	
		$_SESSION['projectID']=$arryProject[$i]['projectID'];	
		$arrayHeaderM = $objUserConfig->GetHeaderMenusUser($_SESSION['AdminID']);
		$ShowIconFlag = sizeof($arrayHeaderM);
	}
	
	if($ShowIconFlag>0){
		$CountIcon++;
?>
	<li class="<?=strtolower($arryProject[$i]['ProjectName'])?>" >
	<a class="fancybox" href="home.php?prID=<?=$arryProject[$i]['projectID']?>"><?=$arryProject[$i]['ProjectName']?></a>
	</li>
<? }
}

 ?>

<!--li class="EzNetStore" >
	<a class="fancybox" href="ecommerce/">EzNetStore</a>
	</li-->
	
	
  </ul>
</div>
			
<?php } 

unset($_SESSION['projectID']);


if($CountIcon<=0){
	echo '<div align="center" class="redmsg" style="padding-top:200px;">'.ERROR_NOT_AUTH.'</div>';
	
}


?>
	
