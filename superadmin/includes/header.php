<?php 	require_once("settings.php");
	
	if(empty($HideNavigation)){
		$HideNavigation = 0;
	}

	$midStyle = ''; $innermidNum = '';
	if($HideNavigation==1){ 
		$midStyle = 'style="padding:0"'; 
		$innermidNum = '55'; 

	} 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<TITLE><?=$Config['SiteName']?> &raquo; Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="../<?=$Config['AdminCSS']?>" rel="stylesheet" type="text/css">
<link href="../<?=$Config['AdminCSS2']?>" rel="stylesheet" type="text/css">

<? if($Config['Online']==1){ ?>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
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
<link rel="stylesheet" href="../css/sitemanagement.css" />
<script src="../fancybox/jquery_calender/jquery-ui.js"></script>


<link rel="stylesheet" href="../fancybox/timepicker/jquery.timepicker.css" />
<script src="../fancybox/timepicker/jquery.timepicker.js"></script>

<script type="text/JavaScript">
var GlobalSiteUrl = "<?=$Config['Url']?>";
</script>

<script language="javascript" src="../includes/validate.js"></script>
<script language="javascript" src="../includes/global.js"></script>
<script language="javascript" src="../includes/ajax.js"></script>
<script language="javascript" src="../includes/tooltip.js"></script>
</HEAD>

<body>

<div class="wrapper">

<? if($LoginPage!=1){
	ValidateSuperAdminSession($ThisPage);  
/*
if($arrayConfig[0]['SiteLogo'] !='' && file_exists('../images/'.$arrayConfig[0]['SiteLogo']) ){
	$SiteLogo = '../resizeimage.php?w=150&h=150&img=images/'.$arrayConfig[0]['SiteLogo'];
}else{
	$SiteLogo = '../images/logo.png';
}	
$SiteLogo = '<img src="'.$SiteLogo.'" border="0" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'"/>';
*/

if(IsFileExist($Config['SiteLogoDir'],$arrayConfig[0]['SiteLogo'])){ 
	$PreviewArray['Folder'] = $Config['SiteLogoDir'];
	$PreviewArray['FileName'] = $arrayConfig[0]['SiteLogo']; 
	$PreviewArray['FileTitle'] = stripslashes($Config['SiteName']);
	$PreviewArray['Width'] = "150";
	$PreviewArray['Height'] = "150";
	$SiteLogo = PreviewImage($PreviewArray); 
}else{ 
	$SiteLogo = '<img src="'.$Config['DefaultLogo'].'" border="0" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'" >';
}
	
	?>







  <? if($HideNavigation!=1){ ?>
<div id="main_table_nav" align="center">

<div class="header-container">
    <div class="logo" id="logo"><a href="dashboard.php"><?=$SiteLogo?></a></div>
    <?=(!empty($CurrentDepartment)?('<div class="crm">'.$CurrentDepartment.'</div>'):(''))?>
    <div class="top-right-nav">
      <ul>
        <li class="welcome">Welcome <span><?=$_SESSION['UserName']?>!</span></li>
	<? if($NavText!=1) { ?>
	<li class="dash-back"><a href="dashboard.php">Back to <span>Main Dashboard</span></a></li>
	<? } ?>

		<? if($_SESSION['AdminType']=="admin") {?><li class="chpassword"><a href="changePassword.php"><span>Change Password</span></a></li><? } ?>
		<li class="logout"><a href="logout.php"><span>Log Out</span></a></li>
      </ul>
    </div>
</div>



<? 	
if($NavText!=1) { 
	require_once("includes/menu.php"); 
	require_once("submenu.php");
}else{ 
	echo '<div class="nav-container"><h2>My Dashboard</h2></div>';
}
?>	
	

 

</div>

  <? } ?>

<div id="main_table_list" class="main-container clearfix">
	<div id="mid" class="main" <?=$midStyle?>>
		<? 	//require_once("left.php"); ?>
		

		<? //if($InnerPage==1){ 
			echo '<div class="mid-continent'.$innermidNum.'" id="inner_mid"  style="width:85%;">';
			//} ?>
			<div id="load_div" align="center"><img src="images/loading.gif">&nbsp;Loading.......</div>
<? } ?>
