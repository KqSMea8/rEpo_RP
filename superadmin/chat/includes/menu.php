<?php 
 
$arrayHeaderMenus=array(
array('Module'=>'Element','Link'=>'element.php?module=Elements'),
array('Module'=>'Package','Link'=>'package.php'),
array('Module'=>'Company','Link'=>'company.php?module=User'),
array('Module'=>'CMS','Link'=>'cms.php?module=chatcms'),
);
if($_SESSION['AdminType']=="user")
{ 
//$arrayHeaderMenus = $objcommon->GetHeaderMenusUser(array('AdminID'=>$_SESSION['AdminID'],'AdminType'=>$_SESSION['AdminType']));

}
else if($_SESSION['AdminType']=="admin")	
{
//$AdminID=0,$DepID,$Parent,$Level
//$arrayHeaderMenus = $objcommon->headermenu(array('AdminID'=>$_SESSION['AdminID'],'AdminType'=>$_SESSION['AdminType']));
}	

?>

<div class="nav-container superadmin" id="main_menu">
    <ul>
	<li></li>
		  <?php  
		 
		  if(!empty($arrayHeaderMenus))
		  {       	
 foreach($arrayHeaderMenus as $key=>$valuesAdmin)
{ 
  $BgClass = ($ThisPageName==$valuesAdmin['Link'])?("active"):("");	
		//$arraySubMenus = $objcommon->GetHdMenuAdmin($valuesAdmin->ModuleID);
	$strlink='chat/'.$valuesAdmin['Link'];

echo '<li class="'.$BgClass.'"><a href="../'.$strlink.'">'.$valuesAdmin['Module'].'</a></li>';
$arryLinks[] = $valuesAdmin['Link'];
		
} 	  
		   }
		 
		   ?>
		   
		   <!-- <li><a href="../pmsystem/">PM</a></li>-->
	</ul>
</div>






