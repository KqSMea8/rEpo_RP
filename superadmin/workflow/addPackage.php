<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For addElement.php
 */

/* * *********************************************** */
$ThisPageName = 'addPackage.php';
/* * *********************************************** */

require_once("includes/header.php");

require_once("classes/configure.class.php");
require_once("classes/function.class.php");
$objConfigure = new configure();
$ModuleName = "Package";
$RedirectURL = "package.php?curP=" . $_GET['curP']; 
if (empty($_GET['tab']))
$_GET['tab'] = "package";
$EditUrl = "addPackage.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "&tab=". $_GET["tab"] ;
$ActionUrl = $EditUrl . $_GET["tab"];
//$HideModule = 'Style="display:none"';
$objPackage=new package();
$arryPackage=$objPackage->getPackage($_GET);
$objelement= new package();
$arryElement =$objelement->getPlanelement($_GET);

#edit the package 
if (!empty($_GET["edit"])){ 
    $pckg_id =$_GET['edit']; 
    $arryPackage = $objPackage->getPackage($_GET['edit'],$pckg_id);

    $arryPackageelement = $objPackage->getPackageelement($_GET['edit'],$pckg_id);
    if(!empty($arryPackageelement)){
     foreach ($arryPackageelement as  $valueelement) {
               $tempdata[$valueelement->ele_key] = $valueelement->ele_value;
                
            }
    }
    //print_R($arryPackage);
  //  header("Location:".$EditUrl);
			//exit;
}
 else {
$EditPage = 1;     
}   
require_once("includes/footer.php");
?>


