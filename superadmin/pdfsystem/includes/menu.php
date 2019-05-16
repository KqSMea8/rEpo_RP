<?php 
//ini_set('display_errors',1);
$arrayHeaderMenus=array(
//array('Module'=>'Element','Link'=>'element.php?module=Elements'),
array('Module'=>'Package','Link'=>'../pdfsystem/package.php'),
//array('Module'=>'Company','Link'=>'company.php?module=User'),
array('Module'=>'CMS','Link'=>'../pdfsystem/cms.php'),
//array('Module'=>'Templates','Link'=>'viewTemplates.php'),
//array('Module'=>'Banner','Link'=>'banner.php'),
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
echo '<li class="active"><a href="../pdfsystem/index.php">PdfSystem &raquo;</a></li>';     	
 foreach($arrayHeaderMenus as $key=>$valuesAdmin)
{ 
  $BgClass = ($ThisPageName==$valuesAdmin['Link'])?("active"):("");	
		//$arraySubMenus = $objcommon->GetHdMenuAdmin($valuesAdmin->ModuleID);
	$strlink='pos/'.$valuesAdmin['Link'];

echo '<li class="'.$BgClass.'"><a href="../'.$strlink.'">'.$valuesAdmin['Module'].'</a></li>';
$arryLinks[] = $valuesAdmin['Link'];
		
} 	  
		   }
		 
		   ?>
		   
		   <!-- <li><a href="../pmsystem/">PM</a></li>-->
	</ul>
</div>






