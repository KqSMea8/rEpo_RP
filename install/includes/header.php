<?php 	require_once("settings.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<TITLE><?=$Config['SiteName']?> &raquo; Installation</TITLE>
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


<div id="main_table_nav" align="center">
	<div class="header-container">
	<div class="logo" id="logo"><img src="../images/logo.png" border="0" alt="<?=$Config['SiteName']?>" title="<?=$Config['SiteName']?>"/></div>
</div>



</div>

<div id="main_table_list" class="main-container clearfix">
	<div id="mid" class="main">
		<div class="mid-continent" id="inner_mid" style="width:98%">
		
		<div class="install_head"><?=$Config['SiteName']?> Installation Process</div>
	

