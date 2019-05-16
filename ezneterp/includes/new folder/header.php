<?php 
include ('includes/function.php');
$slug='home';
if(!empty($_GET['slug']))
$slug = $_GET['slug'];
$datah=homePageContent($slug);

if(empty($datah['id'])){
	//echo '404';
	header("location: 404-error");
	exit;

}

$mData=getHeaderMenu('header');
$footerMenuData=getFooterMenu('footer');
?>
<!DOCTYPE html>
<html style="" class="js js no-touch csstransforms csstransitions"
	lang="en-US">
<head profile="http://www.w3.org/1999/xhtml/vocab">
<link rel="shortcut icon"
	href="<?php echo $Config['Url'] ?>eznetcrm/img/favicon.ico"
	type="image/x-icon">

<link href="https://plus.google.com/+Eznetcrm/about" rel="publisher" />

<meta name="msvalidate.01" content="E9AA281C2F6B2D1413B23EE21902C81B" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="<?php echo $datah['Title'];?>" content="">
<meta name="keywords" content="<?php echo $datah['MetaKeywords'];?>">
<meta name="description" content="<?php echo $datah['MetaDescription'];?>">

<title><?php echo $datah['MetaTitle'];?></title>


<meta name="viewport"
	content="width=device-width, initial-scale=0.6, maximum-scale=1.0, user-scalable=yes">
	
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.once.js"></script>
<script type="text/javascript" src="js/drupal.js"></script>
<script type="text/javascript" src="js/admin_devel.js"></script>
<script type="text/javascript" src="js/pre_payment.js"></script>
<script type="text/javascript" src="js/scroll_to_top.js"></script>
<script type="text/javascript" src="js/jquery.flexslider.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/responsive_menus_simple.js"></script>
<script type="text/javascript" src="js/jquery.hoverIntent.minified.js"></script>
<script type="text/javascript" src="js/sfsmallscreen.js"></script>
<script type="text/javascript" src="js/supposition.js"></script>
<script type="text/javascript" src="js/superfish.js"></script>
<script type="text/javascript" src="js/supersubs.js"></script>
<script type="text/javascript" src="js/superfish(1).js"></script>
<script type="text/javascript" src="js/modernizr.custom.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<link href="css/css" rel="stylesheet" type="text/css">
<link href="css/css(1)" rel="stylesheet" type="text/css">
<link href="css/better_messages.css" rel="stylesheet" type="text/css">
<link href="css/better_messages_admin.css" rel="stylesheet" type="text/css">
<link href="css/ckeditor.css" rel="stylesheet" type="text/css">
<link href="css/colors.css" rel="stylesheet" type="text/css">
<link href="css/ctools.css" rel="stylesheet" type="text/css">
<link href="css/field.css" rel="stylesheet" type="text/css">
<link href="css/flexslider.css" rel="stylesheet" type="text/css">
<link href="css/flexslider_img.css" rel="stylesheet" type="text/css">
<link href="css/jquery.validate.css" rel="stylesheet" type="text/css">
<link href="css/layout.css" rel="stylesheet" type="text/css">
<link href="css/logintoboggan.css" rel="stylesheet" type="text/css">
<link href="css/node.css" rel="stylesheet" type="text/css">

<link href="css/print.css" rel="stylesheet" type="text/css">
<link href="css/responsive_menus_simple.css" rel="stylesheet" type="text/css">
<link href="css/scroll_to_top.css" rel="stylesheet" type="text/css">
<link href="css/search.css" rel="stylesheet" type="text/css">
<link href="css/simplenews.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/superfish.css" rel="stylesheet" type="text/css">
<link href="css/system.base.css" rel="stylesheet" type="text/css">
<link href="css/system.menus.css" rel="stylesheet" type="text/css">
<link href="css/system.messages.css" rel="stylesheet" type="text/css">
<link href="css/system.theme.css" rel="stylesheet" type="text/css">
<link href="css/user.css" rel="stylesheet" type="text/css">
<link href="css/views.css" rel="stylesheet" type="text/css">
<!--responsive css start-->
<link href="css/responsive_media_queries.css" rel="stylesheet" type="text/css">
<link href="css/responsive-9-styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/responsive_menu.js"></script>
<script type="text/javascript" src="js/responsive-menu-9-script.js"></script>
<!--responsive css start-->

<script type="text/javascript" src="js/flexslider.load.js"></script>

<script type="text/javascript" src="js/clientside_validation.ie8.js"></script>
<script type="text/javascript" src="js/clientside_validation_html5.js"></script>
<script type="text/javascript" src="js/clientside_validation.js"></script>


<script language="javascript" src="../includes/validate.js"></script>
<script language="javascript" src="../includes/global.js"></script>
<script language="javascript" src="../includes/ajax.js"></script>
<script language="javascript" src="../includes/tooltip.js"></script>

<script type="text/javascript" src="../fancybox/lib/jquery-1.10.1.min.js"></script>


<script language="javascript1.2" type="text/javascript">

function ShowHideLoader(opt,DivID){

}
</script>

<!--logo show in Google search --> 

 <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "eZnetCRM",
      "url": "http://www.eznetcrm.com",
      "logo": "http://www.eznetcrm.com/erp/eznetcrm/img/eZnetLogo.png"
    }
    </script>

<!-- Corporate Contact Details in Google search --> 

<script type="application/ld+json">
{ "@context" : "http://schema.org",
  "@type" : "eZnetCRM",
  "url" : "http://www.eznetcrm.com",
  "contactPoint" : [
    { "@type" : "ContactPoint",
      "telephone" : "+407-544-3201",
      "contactType" : "customer service"
    } ] }
</script>

<!--Social Profile Show in Google search --> 

<script type="application/ld+json">
{ "@context" : "http://schema.org",
  "@type" : "eZnetCRM",
  "name" : "Online CRM for Business",
  "url" : "http://www.eznetcrm.com",
  "sameAs" : [ "https://www.facebook.com/pages/eZnetCRM/1499005770386551?fref=ts",
    "https://twitter.com/eZnetCRM",
    "https://plus.google.com/+Eznetcrm/about"] 
}
</script>


	<?php include_once('includes/googleAnalytics.php');?>
	
</head>
<body class="html front not-logged-in no-sidebars page-node page-node- page-node-14 node-type-page responsive-menus-load-processed">


	
	<div id="wrapper">

		<div id="mainContainer">

			<header id="headerArea">

				<div class="wrap clearfix">

					<div class="logo">
						<a href="<?php echo $Config['Url'] ?>eznetcrm/" title="Home" rel="home" alt="eZnet CRM"  title="eZnet CRM"
							id="logo"> <img src="img/eZnetLogo.png" alt="eZnet CRM" title="eZnet CRM"> </a>
					</div>
                    <?php include('includes/user_menu.php');?>
					<nav class="menuArea">
						<div class="region region-main-menu">
							<div id="block-superfish-1" class="block block-superfish">


								<div class="content" id="cssmenu">
									<ul id="superfish-1"
										class="menu sf-menu sf-main-menu sf-horizontal sf-style-none sf-total-items-5 sf-parent-items-0 sf-single-items-5 superfish-processed sf-js-enabled sf-shadow">
		<?php
		$bannerDt=showBanner();
		foreach($mData as $meData){ 

		$UrlCustom = ($meData['UrlCustom']=='home')?($Config['Url'].'eznetcrm/'):($meData['UrlCustom']);

                ?>

	        <li id="menu-218-1"
			class=" middle even sf-item-2 sf-depth-1 sf-no-children <?php if($_GET['slug']==$meData['UrlCustom']){echo 'active-trail first odd sf-item-1 sf-depth-1 sf-no-children';}?>"><a
			href="<?php echo $UrlCustom;?>"
			class="sf-depth-1"><?php echo $meData['Title'];?> </a>
		
		<?php 
		
		 $sql = "SELECT * FROM sub_menu WHERE parent_id = '".$meData['id']."'";
		 $res = mysql_query($sql);
		
		if(mysql_num_rows($res)==''){
		
		}else{ ?>
		      <ul id="sub_menu">
		<?php
		  while($menu2=mysql_fetch_array($res))
		  {?>
		  <li><a href="<?php echo $menu2['menu_slug'];?>"><?php echo $menu2['menu_name'];?></a></li>
		  <?php  } ?>
		  </ul>
		</li>
		<?php } ?>
                


		<?php } ?>
                <li class="middle even sf-item-2 sf-depth-1 sf-no-children active has-sub submenu-opened" id="menu-218-1" style="display:none;">
                    <a class="sf-depth-1 submenu-opened" href="javascript:void(0)">Login</a>
                    
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