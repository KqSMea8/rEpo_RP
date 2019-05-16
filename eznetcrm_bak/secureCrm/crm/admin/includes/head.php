<? 
if($arryCompany[0]['Image'] !='' && file_exists($Prefix.'upload/company/'.$arryCompany[0]['Image']) ){

	$SiteLogo = $Prefix.'upload/company/'.$arryCompany[0]['Image'];
	$LogoStyle = "style='margin-bottom:10px;'";
	list($LogoWidth, $LogoHeight) = getimagesize($SiteLogo);
	if($LogoWidth>350 || $LogoHeight>80){	
		$SiteLogo = $Prefix.'resizeimage.php?w=80&h=80&img=upload/company/'.$arryCompany[0]['Image'];
		$LogoStyle = '';
	}
}else if($_SESSION['CmpLogin']==1){
		$SiteLogo = $Prefix.'images/logo_crm.png';		
}else{
	$SiteLogo = $Prefix.'images/logo.png';
}
?>
<div class="header-container">
    <div class="logo" id="logo" <?=$LogoStyle?>><a href="<?=$MainPrefix?>dashboard.php"><img src="<?=$SiteLogo?>" border="0" alt="<?=$Config['SiteName']?>" title="<?=$Config['SiteName']?>"/></a></div>
    <? #echo (!empty($CurrentDepartment)?('<div class="crm">'.$CurrentDepartment.'</div>'):('')); ?>
    <div class="top-right-nav">
      <ul class="clearfix log_link">
	  
			
		<li class="logout"><a href="<?=$MainPrefix?>logout.php" onclick="Javascript:ShowHideLoader('2','P');"><span>Log Out</span></a></li>
		<li class="chpassword"><a class="fancybox fancybox.iframe" href="<?=$MainPrefix?>chPassword.php"><span>Change Password</span></a></li>






<? if($_SESSION['AdminType'] == "admin") {
		
		$UsedStorage = $arryCompany[0]['Storage']; //kb
		if($UsedStorage>0){
			if($UsedStorage<1024){
				$StorageUsed = $UsedStorage.' KB';
			}else if($UsedStorage<1024*1024){
				$StorageUsed = round($UsedStorage/1024,2).' MB';
			}else if($UsedStorage<1024*1024*1024){
				$StorageUsed = round(($UsedStorage/(1024*1024)),8).' GB';
			}else{
				$StorageUsed = round(($UsedStorage/(1024*1024*1024)),8).' TB';
			}
		}else{
			$StorageUsed= '0';
		}

		echo '<li><span>Total Storage :</span> ';

		if($arryCompany[0]['StorageLimit']>0){
			echo $arryCompany[0]['StorageLimit'].' '.$arryCompany[0]['StorageLimitUnit'];
			echo '&nbsp;&nbsp;&nbsp;&nbsp;<span>Storage Used :</span> '.$StorageUsed.'&nbsp;&nbsp;<a href="http://66.55.11.50/user" style="color:#D40503" target="_blank">Upgrade</a>';
		}else{
			echo 'Unlimited';
		}
			
		if($arryCompany[0]['ExpiryDate']>0){
			$Days = (strtotime($arryCompany[0]['ExpiryDate']." 23:59:59") - strtotime($Config['TodayDate']));
			echo '<li><span>Account Expires in </span>'.round($Days/(24*3600)).' days</li>';
		}

		echo '</li>';


	} 

?>





	</ul>
	
	<ul class="clearfix">	
		<li class="welcome">Welcome <span><?=$_SESSION['UserName']?>!</span></li>

	  	<? if($SelfPage!="dashboard.php"){ ?>
	 <li class="dash-back"><a href="<?=$MainPrefix?>dashboard.php">Back to <span>Main Dashboard</span></a></li>
        <li class="location"><span>Location:</span> <? echo stripslashes($arryCurrentLocation[0]['City']).", ".stripslashes($arryCurrentLocation[0]['State']).", ".stripslashes($arryCurrentLocation[0]['Country']); ?></li>
       
		<? } 

		?>
        


      </ul>
    </div>
</div>
