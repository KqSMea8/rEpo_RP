<?php 	require_once("settings.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<TITLE><?=$Config['SiteName']?> &raquo; Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="../<?=$Config['AdminCSS']?>" rel="stylesheet" type="text/css">
<link href="../<?=$Config['AdminCSS2']?>" rel="stylesheet" type="text/css">

<? if($Config['Online']==1){ ?>
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<? } ?>


<script type="text/javascript" src="../fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="../fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />


<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>



<link rel="stylesheet" href="../fancybox/jquery_calender/jquery-ui.css" />
<script src="../fancybox/jquery_calender/jquery-ui.js"></script>


<link rel="stylesheet" href="../fancybox/timepicker/jquery.timepicker.css" />
<script src="../fancybox/timepicker/jquery.timepicker.js"></script>

<script type="text/JavaScript">
var GlobalSiteUrl = '<?=$Config[Url]?>';
</script>

<script language="javascript" src="../includes/validate.js"></script>
<script language="javascript" src="../includes/global.js"></script>
<script language="javascript" src="../includes/ajax.js"></script>
<script language="javascript" src="../includes/tooltip.js"></script>
</HEAD>

<body>

<div class="wrapper">

<? if($LoginPage!=1){
	ValidateAdminSession($ThisPage);  

if($arrayConfig[0]['SiteLogo'] !='' && file_exists('../images/'.$arrayConfig[0]['SiteLogo']) ){
	$SiteLogo = '../resizeimage.php?w=150&h=150&img=images/'.$arrayConfig[0]['SiteLogo'];
}else{
	$SiteLogo = '../images/logo.png';
}	
	
	?>

<div id="main_table_nav" align="center">

<div class="header-container">
    <div class="logo" id="logo"><a href="adminDesktop.php"><img src="<?=$SiteLogo?>" border="0" alt="<?=$Config['SiteName']?>" title="<?=$Config['SiteName']?>"/></a></div>
    <?=(!empty($CurrentDepartment)?('<div class="crm">'.$CurrentDepartment.'</div>'):(''))?>
    <div class="top-right-nav">
      <ul>
        <li class="welcome">Welcome <span><?=$_SESSION['UserName']?>!</span></li>
		<li class="chpassword"><a href="changePassword.php"><span>Change Password</span></a></li>
		<li class="logout"><a href="logout.php"><span>Log Out</span></a></li>
      </ul>
    </div>
</div>


<div class="nav-container" id="main_menu">
		 <ul>
		<li  class="<?=($SelfPage=="siteSettings.php")?("active"):("")?>" ><a href="siteSettings.php" class="menu_link">Global Settings</a></li>
		<li  class="<?=($SelfPage=="viewCompany.php" || $SelfPage=="editCompany.php" || $SelfPage=="deleteCompany.php")?("active"):("")?>" ><a href="viewCompany.php" class="menu_link">Companies</a></li>
		<!--<li  class="<?=($SelfPage=="cms.php")?("active"):("")?>" ><a href="cms.php" class="menu_link">Static Contents</a></li>-->
		<li  class="<?=($SelfPage=="viewCountries.php" || $SelfPage=="editCountry.php")?("active"):("")?>" ><a href="viewCountries.php" class="menu_link">Countries</a></li>
		<li  class="<?=($SelfPage=="viewStates.php" || $SelfPage=="editState.php")?("active"):("")?>" ><a href="viewStates.php" class="menu_link">States</a></li>
		<li  class="<?=($SelfPage=="viewCities.php" || $SelfPage=="editCity.php")?("active"):("")?>" ><a href="viewCities.php" class="menu_link">Cities</a></li>
		<li  class="<?=($SelfPage=="viewZipCodes.php" || $SelfPage=="editZipCode.php" || $SelfPage=="importZipCode.php")?("active"):("") ?>" ><a href="viewZipCodes.php" class="menu_link">Zip Code</a></li>
		<li  class="<?=($SelfPage=="blockedIP.php")?("active"):("")?>" ><a href="blockedIP.php" class="menu_link">Blocked IP</a></li>
		<li  class="<?=($SelfPage=="viewLicense.php" || $SelfPage=="editLicense.php")?("active"):("")?>" ><a href="viewLicense.php" class="menu_link">License Key</a></li>

		<!--li  class="<?=($SelfPage=="changePassword.php")?("active"):("")?>" ><a href="changePassword.php" class="menu_link">Change Password</a></li-->
<!--li  class="<?=($SelfPage=="importCityState.php")?("active"):("")?>" ><a href="importCityState.php" class="menu_link">Import City/State</a></li-->
		</ul>
</div>

	<div class="white" id="sub_menu">
		<? if($SelfPage=="cms.php"){
		$arrayMenu1 = $objMenu->GetContentCategory('');
		if(empty($_GET['CatID'])) $_GET['CatID']=1;
		for($i=0;$i<sizeof($arrayMenu1);$i++) {
			$PageTitle = str_replace(" ","&nbsp;",stripslashes($arrayMenu1[$i]['Name']));
			$Class = ($_GET['CatID'] == $arrayMenu1[$i]['CatID'])?("nav_menu_sel"):("nav_menu");
			echo '<a href="cms.php?CatID='.$arrayMenu1[$i]['CatID'].'" class="'.$Class.'">'.$PageTitle.' Pages</a>';
			if($i<sizeof($arrayMenu1)-1) { echo '&nbsp; | &nbsp;'; } 
		}
		
		?>
		
		<? } ?>
	</div>

 

</div>

<div id="main_table_list" class="main-container clearfix">
	<div id="mid" class="main">
		<? 	//require_once("left.php"); ?>
		

		<? //if($InnerPage==1){ 
			echo '<div class="mid-continent" id="inner_mid" style="width:85%">';
			//} ?>
			<div id="load_div" align="center"><img src="images/loading.gif">&nbsp;Loading.......</div>
<? } ?>
