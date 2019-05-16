<?
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
	  
<? } ?>