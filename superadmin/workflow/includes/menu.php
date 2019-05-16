<?php 
$arrayHeaderMenus="";
if($_SESSION['AdminType']=="user")
{ 
$arrayHeaderMenus = $objcommon->GetHeaderMenusUser(array('AdminID'=>$_SESSION['AdminID'],'AdminType'=>$_SESSION['AdminType']));

}
else if($_SESSION['AdminType']=="admin")	
{
//$AdminID=0,$DepID,$Parent,$Level
$arrayHeaderMenus = $objcommon->headermenu(array('AdminID'=>$_SESSION['AdminID'],'AdminType'=>$_SESSION['AdminType']));
}	

?>

<div class="nav-container" id="main_menu">
    <ul>
	<li></li>
		  <?php  
		  if(!empty($arrayHeaderMenus))
		  {       	
 foreach($arrayHeaderMenus as $key=>$valuesAdmin)
{ 
                $BgClass = ($ThisPageName==$valuesAdmin->Link)?("active"):("");	
		$arraySubMenus = $objcommon->GetHdMenuAdmin($valuesAdmin->ModuleID);
	
 


if($arraySubMenus[0]->Link!='')
{
	$strlink=$arraySubMenus[0]->Link; 
	//$strlink=$valuesAdmin['Link'];
}
else 
{
	$strlink=$valuesAdmin->Link;
}

//$ThisPageName==$valuesAdmin['Link']

echo '<li class="'.$BgClass.'"><a href="../'.$strlink.'">'.$valuesAdmin->Module.'</a></li>';
$arryLinks[] = $valuesAdmin->Link;
		
} 	  
		   }
		 
		   ?>
		   <li><a href="../chat/">Chat System</a></li>
			<li><a href="../workflow/">Workflow</a></li>
		   <!-- <li><a href="../pmsystem/">PM</a></li>-->
	</ul>
</div>






