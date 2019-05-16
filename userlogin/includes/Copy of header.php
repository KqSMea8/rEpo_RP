<? 	 require_once("settings.php");
?>
<HTML>
<HEAD>
<TITLE><?=$Config['SiteName']?> &raquo; Admin Panel</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="<?=$Prefix.$Config['AdminCSS']?>" rel="stylesheet" type="text/css">
<link rel="print stylesheet" type="text/css" href="<?=$Prefix.$Config['PrintCSS']?>" media="print" />


<script type="text/javascript" src="<?=$Prefix?>fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?=$Prefix?>fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?=$Prefix?>fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />


<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>

<!--
<link type="text/css" href="<?=$Prefix?>fancybox/calender/jquery.datepick.css" rel="stylesheet">
<script type="text/javascript" src="<?=$Prefix?>fancybox/calender/jquery.datepick.js"></script>
-->

<link rel="stylesheet" href="<?=$Prefix?>fancybox/jquery_calender/jquery-ui.css" />
<script src="<?=$Prefix?>fancybox/jquery_calender/jquery-ui.js"></script>


<link rel="stylesheet" href="<?=$Prefix?>fancybox/timepicker/jquery.timepicker.css" />
<script src="<?=$Prefix?>fancybox/timepicker/jquery.timepicker.js"></script>


<script type="text/JavaScript">
var GlobalSiteUrl = '<?=$Config[Url]?>';

if (document.images) 
{
   img_icon1 = new Image();
   img_icon1.src = "<?=$Prefix?>images/hovertop.jpg";
}

</script>

<script language="javascript" src="<?=$Prefix?>includes/global.js"></script>
<script language="javascript" src="<?=$Prefix?>includes/ajax.js"></script>
<script language="javascript" src="<?=$Prefix?>includes/tooltip.js"></script>
</HEAD>

<body>

<div id="main_table_nav" align="center" >

<?php if ($SelfPage!="index.php") { ?>
		<div style="float:right; text-align:right" id="header_right">Welcome <?=$_SESSION['UserName']?>!
		<br><br><? if ($SelfPage!="dashboard.php") {?><a href="<?=$MainPrefix?>dashboard.php">Back to Dashboard</a> | <? } ?><a href="<?=$MainPrefix?>logout.php">Log Out</a>
		<? if($CurrentDepID>0){?>
	<br><br><span style="color:#aaa">Location: <? echo stripslashes($arryCurrentLocation[0]['City']).", ".stripslashes($arryCurrentLocation[0]['State']).", ".stripslashes($arryCurrentLocation[0]['Country']); ?></span>
	<br><br>
	<? } ?>
	</div>

<? }


if($arryCompany[0]['Image'] !='' && file_exists($Prefix.'upload/company/'.$arryCompany[0]['Image']) ){
	$SiteLogo = $Prefix.'resizeimage.php?w=120&h=120&img=upload/company/'.$arryCompany[0]['Image'];
}else{
	$SiteLogo = $Prefix.'images/logo.png';
}

?>	

<table width="600" border="0" cellspacing="0" cellpadding="0" align="left" >
  <tr>
    <td width="120" height="90" align="left"><div id="logo"><a href="<?=$MainPrefix?>dashboard.php"><img src="<?=$SiteLogo?>" border="0" alt="<?=$Config['SiteName']?>" title="<?=$Config['SiteName']?>"/></a></div></td>
    <td align="left" style="padding-left:20px;"><div id="head_txt"><?=$CurrentDepartment?></div></td>
  </tr>
</table>




		


<div style="clear:both"></div>

<?php
	//if(empty($ModuleParentID))  $MenuRadius = 'style="border-radius:5px;"';

	if($SelfPage!="index.php") { 
  		ValidateAdminSession($ThisPage); 

		if($SelfPage!="dashboard.php") { 
			$arrayHeaderMenus = $objConfig->GetHeaderMenus($_SESSION['AdminID'],$CurrentDepID,'',1);	
		}

		if(sizeof($arrayHeaderMenus)>0){	
		 //echo '<pre>';print_r($arrayHeaderMenus); exit;


	
		$BgHmClass = ($SelfPage=="home.php")?("menu_bg2"):("menu_bg");
  ?>
  

    <div align="left"  >
	
	<table width="100%"  border="0" cellpadding="0" cellspacing="0"  id="main_menu" <?=$MenuRadius?>>
    <tr>
	
		<td class="<?=$BgHmClass?>" ><a href="home.php" class="menu_link" >Home</a></td>
		  <? 
		  foreach($arrayHeaderMenus as $key=>$valuesAdmin){ 
				 
				 $BgClass = ($ModuleParentID == $valuesAdmin['ModuleID'])?("menu_bg2"):("menu_bg");
				
				 $ArrTopLink =  $objConfig->GetHeaderTopLink($valuesAdmin['ModuleID']);


				 if($valuesAdmin['ModuleID'] == 1){
					 $MainLink = $MainPrefix.$ArrTopLink[0]['Link'];
				 }else{
					 $MainLink = $DeptFolder.$ArrTopLink[0]['Link'];
				 }
				 

		  ?>
		  <td class="<?=$BgClass?>" ><a href="<?=$MainLink?>" class="menu_link" ><?=$valuesAdmin['Module']?></a></td>
		  <? } ?>
		  <td  align="center" class="menu_bg" >&nbsp;</td>
	 </tr>
   </table>
		  
		
		</div>
		
 <?   
 }


 if($_SESSION['AdminType']=="employee" && $ThisPageName!='dashboard.php' && $ThisPageName!='home.php' && !in_array($ModuleParentID,$AllowedModules)){
		$arryPermitted = $objConfig->isModulePermitted($ModuleParentID,$_SESSION['AdminID']);
		if($arryPermitted[0]['ModifyLabel']==1){
			/*****************/
			/*****************/
			$ModifyLabel = 1; 
			/*****************/
			/*****************/
		}
		if(empty($arryPermitted[0]['EmpID'])) {
			$NotAllowed = 1;
		}
 }



  if($ModuleParentID > 0 && $NotAllowed!=1 ) {
 

			/******  Sub menu ****/
			if($ModuleParentID == 49) { 
				$arrayMenu1 = $objMenu->GetContentCategory('');
			}else{			
				 $arraySubMenus = $objConfig->GetHeaderMenus($_SESSION['AdminID'],'',$ModuleParentID,2);
			}
 
  
 ?>


		 <div class="white" id="sub_menu">
		&nbsp;
		<? 
		 if($ModuleParentID == 49) { 
		 	if(empty($_GET['CatID'])) $_GET['CatID']=1;
			 for($i=0;$i<sizeof($arrayMenu1);$i++) {
			 	$PageTitle = str_replace(" ","&nbsp;",stripslashes($arrayMenu1[$i]['Name']));
				$Class = ($_GET['CatID'] == $arrayMenu1[$i]['CatID'])?("nav_menu_sel"):("nav_menu");
				echo '<a href="cms.php?CatID='.$arrayMenu1[$i]['CatID'].'" class="'.$Class.'">'.$PageTitle.' Pages</a>';
				if($i<sizeof($arrayMenu1)-1) { echo '&nbsp; | &nbsp;'; } 
			}
		 }else{
				for($i=0;$i<sizeof($arraySubMenus);$i++){ 
					$Class = ($MainModuleID == $arraySubMenus[$i]['ModuleID'])?("nav_menu_sel"):("nav_menu");
					echo '<a href="'.$arraySubMenus[$i]['Link'].'" class="'.$Class.'">'.$arraySubMenus[$i]['Module'].'</a>';
					if(sizeof($arraySubMenus)-1!=$i) echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
					
			   } 
	    }
	   
	   ?>
	  </div>

 <?	}	?>
 
 
 
  <?php }else{ ?>
	<div align="left"  id="main_menu" class="menu_bg" <?=$MenuRadius?>>
		<strong> &nbsp;&nbsp;<?=$Config['SiteName']?></strong>
	</div>
  <? } ?>

	<? if ($SelfPage=="dashboard.php") {?>
	<div align="left"  id="main_menu" class="menu_bg" <?=$MenuRadius?>>
		<strong> &nbsp;&nbsp;<?=$Config['SiteName']?></strong>
	</div>
	<? } ?>





</div>

<div id="main_table_list" align="center">
		<? 

			if($_SESSION['AdminType']=="employee" && $EditPage==1 && $ModifyLabel!=1){ 
				$NotAllowed =1;
			}


			if($NotAllowed == 1){
				echo '<Div style="padding-top:200px;" class="redmsg">'.$MSG[43].'</Div>';
				exit;
			}
		?>
		
		
		<div id="load_div"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Loading.......</div>
		

