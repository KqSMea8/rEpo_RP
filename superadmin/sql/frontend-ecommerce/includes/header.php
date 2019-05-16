<?
	require_once("includes/settings.php");
	#require_once("settings.php"); 
	
?>
<!DOCTYPE html>
<html>
<head>
<title><?= $MetaTitle ?></title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<?= $MetaDescription ?> <?= $MetaKeywords ?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css"  />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="treeview/jquery.treeview.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js"></script>
<script language="javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<script language="javascript" src="js/jquery.jcarousel.min.js"></script>
<script language="javascript" src="rater/jquery.rater-custom.js"></script>
<script type="text/javascript" src="treeview/jquery.treeview.min.js"></script>
<script language="javascript" src="js/theme.js?<?php echo time();?>"></script>
<link rel="stylesheet" type="text/css" href="css/default-style.css?<?php echo time(); ?>"  />
<link rel="stylesheet" type="text/css" href="css/main-style.css?<?php echo time(); ?>"  />
<script language="javascript" src="includes/ecom_ajax.js"></script>
 <script language="javascript" src="includes/ecom_global.js"></script>
<script language="javascript" src="js/jquery.floating-social-share.js"></script>
<script language="javascript" src="js/validation.js"></script>
<script language="javascript" src="includes/checkout.js"></script>
<?php echo $settings['GoogleAnalytics']; ?>
<?php
	for ($count = 0; $count < count($cssfiles); $count++) {
		echo '<link href="' . $Config['MainUrl'] . $cssfiles[$count] . '?'.time().' " rel="stylesheet" type="text/css"></link>';
	}
?>
<script>

jQuery(function () { 
    $("body").floatingSocialShare({
       buttons: ["facebook","twitter","google-plus","linkedin","pinterest"],
       text: "share with: "
        //url: "http://twitter.com"
    });

 });
function ChangeCurrency() {
    var SendCurrUrl = document.getElementById("CurrActionUrl").value + "curr_id=" + document.getElementById("top_currency_id").value;
            location.href = SendCurrUrl;
    }
</script> 
</head>
<body>

<!-- MAIN WRAP START-->

<div class="header">
	<div class="container">
    	<div class="row">
        	<div class="col-sm-12 header-section">
            	<?php 
					echo $arryPageTemplate[0]['header']; 
				?>
            </div>
        </div>
    </div>
</div>

<div class="main-container">
	<div class="container">
    	<div class="row">
        	<div class="col-sm-12">
				<?php
                if($arryPageTemplate[0]['layoutType']=='leftsidebar' || $arryPageTemplate[0]['layoutType']=='bothsidebar') { ?>
                    <div class="ecomm-themeLeftbar"><?php echo $arryPageTemplate[0]['left']?></div>
                <?php } ?>
                 
                <!-- MAIN WRAP END-->

			
