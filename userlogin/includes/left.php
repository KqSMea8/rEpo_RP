
<?
//if($ModuleParentID > 0 && $NotAllowed!=1 ) {
if(!empty($ModuleParentID) && $NotAllowed!=1 ) {
			/******  Sub menu ****/
			if($ModuleParentID == 49) { 
				$arrayMenu1 = $objMenu->GetContentCategory('');
			}else{			
				 $arraySubMenus = $objConfig->GetHeaderMenusUser($_SESSION['UserID'],'',$ModuleParentID,2);
			}
			$InnerPage = 1;


?>



<div class="left-main-nav">	
	<h3><span class="icon"></span>Main Menu</h3>
	<ul>
		<!--<li class="new"><?=$AddLink?></li>-->
		<? 
		 if($ModuleParentID == 49) { 
		 	if(empty($_GET['CatID'])) $_GET['CatID']=1;
			 for($i=0;$i<sizeof($arrayMenu1);$i++) {
			 	$PageTitle = str_replace(" ","&nbsp;",stripslashes($arrayMenu1[$i]['Name']));
				$Class = ($_GET['CatID'] == $arrayMenu1[$i]['CatID'])?("active"):("");
				echo '<li class="submenu '.$Class.'"><a href="cms.php?CatID='.$arrayMenu1[$i]['CatID'].'" >'.$PageTitle.' Pages</a></li>';
				//if($i<sizeof($arrayMenu1)-1) { echo '&nbsp; | &nbsp;'; } 
			}
		 }else{
				for($i=0;$i<sizeof($arraySubMenus);$i++){ 
					$Class = ($MainModuleID == $arraySubMenus[$i]['ModuleID'])?("active"):("");
					echo '<li class="submenu '.$Class.'"><a href="'.$arraySubMenus[$i]['Link'].'">'.$arraySubMenus[$i]['Module'].'</a></li>';
					#if(sizeof($arraySubMenus)-1!=$i) echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
					
			   } 
	    }
	   
	   
	   $Class = ($SelfPage=="changePassword.php")?("active"):("");
	  /*  echo '<li class="chanpass '.$Class.'"><a class="fancybox fancybox.iframe" href="'.$MainPrefix.'chPassword.php" >Change Password</a></li>';
	  
	   echo '<li class="chanpass '.$Class.'"><a href="'.$MainPrefix.'changePassword.php" >Change Password</a></li>';
	   echo '<li class="logoff"><a href="'.$MainPrefix.'logout.php" >Log Out</a></li>';
	   */
	   ?>
	   
	   
	   
</ul>
	</div> 
	
<? }

?>
