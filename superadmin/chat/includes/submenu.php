<?
/*
$arrayHeaderMenus="";
$arraySubMenus = $objUserConfig->GetHeaderParent($ThisPageName);

if( ($_SESSION['AdminType']=="user") && ($arraySubMenus[0]['Parent']>0))
{
	
$arrayHeaderSubMenus = $objUserConfig->GetHeaderSubmenuUser($_SESSION['AdminID'],$arraySubMenus[0]['Parent']);
print_r($arrayHeaderSubMenus);
}
else if($_SESSION['AdminType']=="admin"  && $arraySubMenus[0]['Parent']>0)	
{ 	
$arrayHeaderSubMenus = $objUserConfig->GetHeaderSubmenuadmin($_SESSION['AdminID'],$arraySubMenus[0]['Parent']);
}	
{ 
?>

<div class="sub-container" id="sub_menu" >
    <ul>
 <?  
 foreach($arrayHeaderSubMenus as $key=>$valuesAdmin)
{ 
$BgClass = ($ThisPageName==$valuesAdmin['Link'])?("active"):("");

echo '<li class="'.$BgClass.'"><a href="'.$valuesAdmin['Link'].'">'.$valuesAdmin['Module'].'</a></li>';
$arryLinks[] = $valuesAdmin['Link'];
		
}
  }
 ?>
</ul>
</div>
<div style="clear:both"></div>
<?php 


	if($_SESSION['AdminType']=="user")
	{ 
		$arrayPageDt = $objUserConfig->GetHdMenuByLink($_SESSION['AdminID'],$ThisPageName);
		$NotAllowed=in_array($ThisPageName,$arryLinks);
		$Mypage="index.php";
		
		if($arrayPageDt[0]['ModifyLabel']!=1 && $EditPage==1){
			$NotAllowed=0;
		}	


		if($NotAllowed ==0 && $ThisPageName!=$Mypage)
		{
			echo '<div align="center" class="redmsg" style="padding-top:200px;">'.ERROR_NOT_AUTH.'</div>';
			exit;
		}
		
	}
	
if(($ThisPageName=='viewCompany.php'))	{
	$arrayHeaderMenus="";$arrayHeaderSubMenus="";
	if( $_SESSION['AdminType']=="user")
	{
	$arrayHeaderSubMenus = $objUserConfig->GetrightmenuByuser($_SESSION['AdminID']);
	}
	else if($_SESSION['AdminType']=="admin")	
	{
	$arrayHeaderSubMenus = $objUserConfig->GetrightmenuByadmin($_SESSION['AdminID']);
	}
 //print_r($arrayHeaderSubMenus);

}
	
	*/
?>
