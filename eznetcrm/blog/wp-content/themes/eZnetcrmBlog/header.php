<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
//print_r($_SERVER);die;
$url=$_SERVER['SERVER_NAME'];
function url_origin($s, $use_forwarded_host=false)
{
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}
$url= url_origin($_SERVER).'/erp/eznetcrm/ajax-menu.php';
$menudata=file_get_contents($url);
$Mdata=json_decode($menudata);

?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="shortcut icon"
	href="<?php $url?>/erp/eznetcrm/img/favicon.ico"
	type="image/x-icon">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--start css for blog -->
<link href="<?php bloginfo('template_directory');?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/views.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/system.messages.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/simplenews.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/scroll_to_top.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/flexslider.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/ctools.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/better_messages.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/colors.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/user.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/system.theme.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/system.menus.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/system.base.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/superfish.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/search.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/responsive_media_queries.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/responsive-9-styles.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/print.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/owl.transitions.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/owl.theme.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/owl.carousel.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/node.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/logintoboggan.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/jquery.validate.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/jquery.bxslider.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/flexslider_img.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/field.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/ckeditor.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/better_messages_admin.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory');?>/css/ie.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.min.js"></script>

<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/responsive-menu-9-script.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.once.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/drupal.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/admin_devel.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/pre_payment.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/scroll_to_top.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.flexslider.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/responsive_menus_simple.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jquery.hoverIntent.minified.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/sfsmallscreen.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/supposition.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/superfish.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/supersubs.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/superfish(1).js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/script.js"></script>

<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/responsive_menu.js"></script>

<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

 

  ga('create', 'UA-60276873-1', 'auto');

  ga('send', 'pageview');

 

</script>	


<!--end css for blog -->
<?php //echo bloginfo('template_directory'); die('hi');?>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<style type="text/css">
    body {
    background: none repeat scroll 0 0 #fff;
    color: #6f6f6f;
    font-family: "Open Sans",sans-serif;
    font-size: 13px;
    line-height: 1;
    margin: 0;
    padding: 0;
    width: 100% !important;
}
#footer {
    
    width: 100% !important;
}
    
</style>
</head>

<body <?php body_class(); ?>>
<div id="wrapper">
    <div id="mainContainer">
	<header id="headerArea">

				<div class="wrap clearfix">

					<div class="logo">



						<a id="logo" alt="eZnet CRM" rel="home" title="eZnet CRM" href="<?php $url?>/erp/eznetcrm/"> <img title="eZnet CRM" alt="eZnet CRM" src="<?php bloginfo('template_directory');?>/img/eZnetLogo.png"> </a>
					</div>



<nav id="primary_nav_wrap">

<ul>
    <li><a href="#"><img src="<?php $url?>/erp/eznetcrm/img/menu-icon-responsive.png"> Login</a>
    
    <ul>

                    <li><a target="_blank" href="<?php $url?>/erp/admin/dashboard.php">CRM Login</a></li>
                    <li><a href="<?php $url?>/erp/eznetcrm/user">Manage Web Account</a></li>
                    <li><a href="<?php $url?>/erp/eznetcrm/reseller/user.php">Reseller Login</a></li>
    </ul>
  </li>
</ul>
</nav>


					<nav class="menuArea">
						<div class="region region-main-menu">
							<div class="block block-superfish" id="block-superfish-1">


								<div id="cssmenu" class="content">
									<ul class="menu sf-menu sf-main-menu sf-horizontal sf-style-none sf-total-items-5 sf-parent-items-0 sf-single-items-5 superfish-processed sf-js-enabled sf-shadow" id="superfish-1">
										
<?php
		
		foreach($Mdata as $MeData){ 
		$UrlCustom = ($MeData->UrlCustom=='home')?(''):($MeData->UrlCustom);
        
?>

		<li id="menu-218-1"
			class=" middle even sf-item-2 sf-depth-1 sf-no-children <?php if($_GET['header']==$MeData->UrlCustom){echo 'active-trail first odd sf-item-1 sf-depth-1 sf-no-children';}?>"><a
			href="<?php echo url_origin($_SERVER).'/erp/eznetcrm/'.$UrlCustom;?>"
			class="sf-depth-1"><?php echo $MeData->Title;?> </a>
		</li>


		<?php } ?>
                <li class=" middle even sf-item-2 sf-depth-1 sf-no-children active has-sub" id="menu-218-1" style="display:none;">
                    <a class="sf-depth-1" href="javascript:void(0)">Login</a>
                    <ul>
                        <?php if(!empty($_SESSION['CrmDisplayName'])){?>
                        <li class=" middle even sf-item-2 sf-depth-1 sf-no-children" id="menu-218-1"><a class="sf-depth-1" href="../admin/dashboard.php" target="_blank">CRM Login</a></li>
                        <li class=" middle even sf-item-2 sf-depth-1 sf-no-children" id="menu-218-1"><a class="sf-depth-1" href="user">Manage Web Account</a></li>
                        <li class=" middle even sf-item-2 sf-depth-1 sf-no-children" id="menu-218-1"><a class="sf-depth-1" href="log-out">Log Out</a></li>
                        <?php }else{?>
                        <li class=" middle even sf-item-2 sf-depth-1 sf-no-children" id="menu-218-1"><a class="sf-depth-1" href="../admin/dashboard.php" target="_blank">CRM Login</a></li>
                        <li class=" middle even sf-item-2 sf-depth-1 sf-no-children" id="menu-218-1"><a class="sf-depth-1" href="user">Manage Web Account</a></li>
                        <li class=" middle even sf-item-2 sf-depth-1 sf-no-children" id="menu-218-1"><a class="sf-depth-1" href="reseller/">Reseller Login</a></li>
                        <?php }?>
                    </ul>
              
		</li>

										
									</ul>
								</div>
							</div>
						</div>
					</nav>

				</div>

			</header>
        
	<div id="mainContent">
         <div class="wrap clearfix">
            <?php //$objconn=new dbClass();//$bannerDt=showBanner(); ?>
