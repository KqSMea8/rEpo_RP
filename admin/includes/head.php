<? 
 
$LogoStyle = ''; 
 
if(IsFileExist($Config['CmpDir'],$arryCompany[0]['Image'])){//cmp logo
	$LogoStyle = "style='margin-bottom:10px;'";
	$arrayFileInfo = GetFileInfo($Config['CmpDir'],$arryCompany[0]['Image']);
	if($arrayFileInfo[0]>350 || $arrayFileInfo[1]>150){	
		$PreviewArray['Width'] = "150";
		$PreviewArray['Height'] = "150"; 
		$LogoStyle = '';
	} 
	$PreviewArray['Folder'] = $Config['CmpDir'];
	$PreviewArray['FileName'] = $arryCompany[0]['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($Config['SiteName']); 
	$SiteLogo = PreviewImage($PreviewArray); 
}else if(!empty($_SESSION['CmpLogin'])){ //crm logo
	$SiteLogo = '<div class="logotext">'.$Config['SiteName'].'</div>>' ; /*'<img src="'.$Config['DefaultLogoCrm'].'" border="0" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'" >';*/		
}else{
	/*$Config['CmpID'] = $Config['SuperCmpID'];
	if(IsFileExist($Config['SiteLogoDir'],$arrayConfig[0]['SiteLogo'])){  //site logo	
		$PreviewArray['Folder'] = $Config['SiteLogoDir'];
		$PreviewArray['FileName'] = $arrayConfig[0]['SiteLogo']; 
		$PreviewArray['FileTitle'] = stripslashes($Config['SiteName']);
		$PreviewArray['Width'] = "150";
		$PreviewArray['Height'] = "150"; 
		$SiteLogo = PreviewImage($PreviewArray); 			

		 
	}else{  //default logo	 
		$SiteLogo = '<img src="'.$Config['DefaultLogo'].'" border="0" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'" >';
	}
	$Config['CmpID'] = $_SESSION['CmpID'];*/
	$SiteLogo = '<div class="logotext">'.$Config['SiteName'].'</div>' ;
}

 

(empty($_GET['k']))?($_GET['k']=''):(""); 
?>
<div class="header-container">
    <div class="logo" id="logo" <?=$LogoStyle?>><a href="<?=$MainPrefix?>dashboard.php"><?=$SiteLogo?></a></div>
    <? #echo (!empty($CurrentDepartment)?('<div class="crm">'.$CurrentDepartment.'</div>'):('')); ?>
    <div class="top-right-nav">
      <ul class="clearfix log_link">
	  
			
		<li class="logout"><a href="<?=$MainPrefix?>logout.php" onclick="Javascript:ShowHideLoader('2','P');"><span>Log Out</span></a></li>
		<li class="chpassword"><a class="fancybox fancybox.iframe" href="<?=$MainPrefix?>chPassword.php"><span>Change Password</span></a></li>

   <?php 
require_once("notification.php");

if($Config['CurrentDepID']>0){?><li class="help"><a class="fancybox fancybox.iframe" href="<?=$MainPrefix?>help.php?depID=<?=$Config['CurrentDepID']?>"><span>Help</span></a></li><?php } ?>

<?
	

 if($_SESSION['AdminType'] == "admin") {
		
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
			echo '&nbsp;&nbsp;&nbsp;&nbsp;<span>Storage Used :</span> '.$StorageUsed.'&nbsp;&nbsp;<a href="'.$Config['WebUrl'].'pricing-signup" style="color:#D40503" target="_blank">Upgrade</a>';
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
        <li class="location">
<span>Location:</span>
 <? 
if(!empty($arryCurrentLocation[0]['City'])) echo stripslashes($arryCurrentLocation[0]['City']).", ";
if(!empty($arryCurrentLocation[0]['State'])) echo stripslashes($arryCurrentLocation[0]['State']).", ";
echo stripslashes($arryCurrentLocation[0]['Country']);

 ?>
</li>
       
		<? }else if($arryCompany[0]['SecurityLevel'] == "2"){ ?>
<li class="secure" onMouseover="ddrivetip('<center><?=$TwoStepStatus?></center>', 160,'')"; onMouseout="hideddrivetip()" ><a href="Javascript:securityDialog(<?=$EnableSecurity?>);"><span><?=$EnableSecurityTitle?></span></a></li>
<? } ?>
        


      </ul>

	<? if($Config['CurrentDepID']==5 && $TopSearch!=1){?>
	<ul class="clearfix">	
		<li class="search">
	<input type="text" name="k" id="k" placeholder="<?=SEARCH_KEYWORD?>" class="textbx" maxlength="30" value="<?=$_GET['k']?>" onkeypress="Javascript:enterSub(this,event);">&nbsp;<input type="button" name="s" value="Go" class="searchbt" onClick="Javascript:TopSearch();">
		</li>
	 </ul>
       <?  } ?>





    </div>
</div>

<SCRIPT LANGUAGE=JAVASCRIPT>
function TopSearch()
{
	if(ValidateForSimpleBlank(document.getElementById("k"),"Search Keyword")){
		location.href="search.php?k="+document.getElementById("k").value;
		LoaderSearch();	
	}
}

function enterSub(inField, e) 
{ 
        var charCode;

        if(e && e.which)
        {
            charCode = e.which;
        }
        else if (window.event)
        {
            e = window.event;
            charCode = e.keyCode;
        }

        if (charCode == 13) 
        {
            TopSearch(); // My Main action
        }
 }

$(document).ready(function() {
		$(".help a").fancybox({
			'width'         : 1000
		 });

});
</SCRIPT>
