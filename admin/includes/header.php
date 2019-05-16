<? 	require_once("settings.php");

	if(empty($HideNavigation)){
		$HideNavigation = 0;
	}

	if($HideNavigation==1){
		$BodyStyle = 'style="background:none;"';
		$MainClass = 'main_pop';
	}else{
		$BodyStyle = '';
		$MainClass = 'main';
	}
	 
	
 
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html moznomarginboxes mozdisallowselectionprint xmlns="https://www.w3.org/1999/xhtml">

<TITLE><?=$Config['SiteName']?> &raquo; Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="<?=$MainPrefix?>images/favicon.ico" type="image/x-icon">
<link href="<?=$Prefix.$Config['AdminCSS']?>?<?=time();?>" rel="stylesheet" type="text/css">
<link href="<?=$Prefix.$Config['AdminCSS2']?>" type="text/css" rel="stylesheet"  />
<link href="<?=$Prefix.$Config['AdminCSS3']?>" type="text/css" rel="stylesheet"  />
<link rel="print stylesheet" type="text/css" href="<?=$Prefix.$Config['PrintCSS']?>" media="print" />
<? if($Config['Online']==1){ ?>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />

<? }else{ ?>
<link rel="stylesheet" href="<?=$Prefix?>fancybox/jquery_calender/jquery-ui.css" />
<? } ?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<script type="text/javascript" src="<?=$Prefix?>fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?=$Prefix?>fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?=$Prefix?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>



 
<link rel="stylesheet"  href="<?=$Prefix?>admin/crm/css/crmpopup.css"/><!--By chetan 4DEC-->


<script src="<?=$Prefix?>fancybox/jquery_calender/jquery-ui.js"></script>
<link rel="stylesheet" href="<?=$Prefix?>fancybox/timepicker/jquery.timepicker.css" />
<script src="<?=$Prefix?>fancybox/timepicker/jquery.timepicker.js"></script>
<script type="text/JavaScript">
var GlobalSiteUrl = "<?=$Config['Url']?>";
var CurrencyConversionType = "<?=$Config['ConversionType']?>";
var DateFormatForm = "<?=$Config['DateFormatForm']?>";
</script>

<script language="javascript" src="<?=$Prefix?>includes/validate.js"></script>
<script language="javascript" src="<?=$Prefix?>includes/global.js?<?=time()?>"></script>
<script language="javascript" src="<?=$Prefix?>includes/ajax.js?<?=time()?>"></script>

<script language="javascript" src="<?=$Prefix?>includes/tooltip.js"></script>
<?php if(!empty($CurrentDepartment)){  // By Ravi?>
<script language="javascript" src="includes/<?=strtolower($CurrentDepartment)?>.js?<?=time();?>"></script>
<?php }?>
<script language="javascript" src="<?=$MainPrefix?>js/common.js"></script>


<? if($Tooltip==1){ ?>
<script>
  $( function() {
    $( ".help" ).tooltip({
	track: true,
      show: {
        effect: "slideDown",
        delay: 50
      }
    });
  } );

     
  </script>

  <style>
  .ui-tooltip{
    color: #fff;
    background: #666;
    border: 2px solid #aaa;
  }
</style>
<? } ?>



</HEAD>
<body <?=$BodyStyle?>>



<div class="wrapper">

<? if($LoginPage!=1){
	#ValidateAdminSession($ThisPage);  //Not required, definded in settings.php
	
	
	?>
<div id="main_table_nav" align="center" >
  <?
		if($HideNavigation!=1){
			
			$clearfix = 'clearfix';

			require_once("head.php");
			
			if($NavText!=1) { 
				require_once("menu.php");
				//require_once("submenu.php");
			}else{ 
				echo '<div class="nav-container"><h2>'.$Config['SiteName'].'</h2></div>';
			} 

		}

	
?>
</div>

<div id="main_table_list" class="main-container <?=$clearfix?>">
	<div id="mid" class="<?=$MainClass?>" >
	<? if($HideNavigation!=1)	require_once("left.php"); 	?>
	
	<? if($InnerPage==1){ echo '<div class="mid-continent" id="inner_mid">'; } ?>
		<? require_once("permission.php"); ?>
	<div id="load_div" align="center" style="color:#d40503;"><img src="<?=$MainPrefix?>images/loadr.gif">&nbsp;Loading.......</div>
	
<? }

	
 ?>




<? if($HideNavigation == 1 && $_SESSION['AdminType'] != "admin"){ ?>
<script language="JavaScript1.2" type="text/javascript">
function CheckFancyReferer(){	
	var test = window.parent.document.getElementById("footer");
	if(test!=null){
		//alert('yes');
	}else{
		window.location.href="home.php";
	}
}
//CheckFancyReferer();
</script>
<? } ?>



<?
if(!empty($_SESSION['AdminID']) && $LoginPage!=1){
 	include($MainPrefix."includes/html/box/session_expiry.php"); 
}

 
?>
 
