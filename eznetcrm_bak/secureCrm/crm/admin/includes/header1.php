<? 	 require_once("settings.php");


	if($HideNavigation==1){
		$BodyStyle = 'style="background:none;"';
		$mainClassStye = 'style="padding:0;"';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<TITLE><?=$Config['SiteName']?> &raquo; Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="<?=$Prefix.$Config['AdminCSS']?>" rel="stylesheet" type="text/css">
<link href="<?=$Prefix.$Config['AdminCSS2']?>" type="text/css" rel="stylesheet"  />
<link href="<?=$Prefix.$Config['AdminCSS3']?>" type="text/css" rel="stylesheet"  />
<link rel="print stylesheet" type="text/css" href="<?=$Prefix.$Config['PrintCSS']?>" media="print" />
<? if($Config['Online']==1){ ?>
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<? } ?>



<script type="text/javascript" src="<?=$Prefix?>fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?=$Prefix?>fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?=$Prefix?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
<link rel="stylesheet" href="<?=$Prefix?>fancybox/jquery_calender/jquery-ui_Backup.css" />

<script src="<?=$Prefix?>fancybox/jquery_calender/jquery-ui.js"></script>
<link rel="stylesheet" href="<?=$Prefix?>fancybox/timepicker/jquery.timepicker.css" />
<script src="<?=$Prefix?>fancybox/timepicker/jquery.timepicker.js"></script>
<script type="text/JavaScript">
var GlobalSiteUrl = '<?=$Config[Url]?>';
</script>
<script language="javascript" src="<?=$Prefix?>includes/validate.js"></script>
<script language="javascript" src="<?=$Prefix?>includes/global.js"></script>
<script language="javascript" src="<?=$Prefix?>includes/ajax.js"></script>

<script language="javascript" src="<?=$Prefix?>includes/tooltip.js"></script>


<script>
/*
$(function() {
	$( document ).tooltip({
	track: true
	});
});*/
</script>

</HEAD>
<body <?=$BodyStyle?>>
<div class="wrapper">

<? if($LoginPage!=1){ 
	ValidateAdminSession($ThisPage);  
	
	
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
	<div id="mid" class="main" <?=$mainClassStye?>>
	<? if($HideNavigation!=1)	require_once("left.php");	?>
	
	<? if($InnerPage==1){ echo '<div class="mid-continent" id="inner_mid">'; } ?>
		<? require_once("permission.php"); ?>
	<div id="load_div" align="center"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Loading.......</div>
	
<? } ?>



 