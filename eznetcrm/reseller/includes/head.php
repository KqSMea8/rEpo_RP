<?php
$folderPath = '../';
require_once("includes/settings.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<TITLE><?=$Config['SiteName']?> &raquo; Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">

<link href="css/admin.css" rel="stylesheet" type="text/css">

<? if($Config['Online']==1){ ?>
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<? } ?>


<script type="text/javascript" src="../../fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="../../fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="../../fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />


<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>



<link rel="stylesheet" href="../../fancybox/jquery_calender/jquery-ui.css" />
<link rel="stylesheet" href="../../css/sitemanagement.css" />
<script src="../../fancybox/jquery_calender/jquery-ui.js"></script>


<link rel="stylesheet" href="../../fancybox/timepicker/jquery.timepicker.css" />
<script src="../../fancybox/timepicker/jquery.timepicker.js"></script>

<script type="text/JavaScript">
var GlobalSiteUrl = '<?=$Config[Url]?>';
</script>

<script language="javascript" src="../../includes/validate.js"></script>
<script language="javascript" src="../../includes/global.js"></script>
<script language="javascript" src="../../includes/ajax.js"></script>
<script language="javascript" src="../../includes/tooltip.js"></script>
</HEAD>
<body
	class="html front not-logged-in no-sidebars page-node page-node- page-node-14 node-type-page responsive-menus-load-processed">
<div id="skip-link"><a href="#main-content"
	class="element-invisible element-focusable">Skip to main content</a></div>
<div id="wrapper">

<div id="mainContainer"><?php if(!$FancyBox){?> <header id="headerArea">

<div class="wrap clearfix">

<div class="logo"><a href="../index.php" title="Home" rel="home"
	alt="eZnet CRM logo" id="logo"> <img src="../img/eZnetLogo.png"
	alt="eZnet CRM logo" title="eZnet CRM logo"> </a></div>
<?php include('user_menu.php');?> 


<?php if(!empty($_SESSION['CrmRsID'])){?>

<nav class="menuArea">

<ul class="menu sf-menu sf-main-menu sf-horizontal sf-style-none sf-total-items-5 sf-parent-items-0 sf-single-items-5 superfish-processed sf-js-enabled sf-shadow"
	id="superfish-1">

	<li id="menu-218-1"><a href="viewCompany.php">Manage Company</a></li>
	<li id="menu-218-1"><a href="editCompany.php">Create Company</a></li>


</ul>

</nav>

	<?php }?>



</div>

</header>

<div class="top-cont1"></div>
<?php }?>