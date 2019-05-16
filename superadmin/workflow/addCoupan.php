<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For addElement.php
 */

/* * *********************************************** */
$ThisPageName = 'addCoupan.php';
/* * *********************************************** */
require_once("includes/header.php");
require_once("classes/configure.class.php");
require_once("classes/function.class.php");

$objConfigure = new configure();
$ModuleName = "Coupan";
$RedirectURL = "coupan.php?curP=" . $_GET['curP']; 
if (empty($_GET['tab']))
$_GET['tab'] = "coupan";
$EditUrl = "addCoupan.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "&tab=". $_GET["tab"] ;
$ActionUrl = $EditUrl . $_GET["tab"];
//$HideModule = 'Style="display:none"';
$objelement=new coupan();
$arryElement=$objelement->getPlanelement($_GET);

if (!empty($_GET["edit"])){ 
    $id =$_REQUEST['edit'];
    $arryElement = $objelement->getPlanelement($_GET['edit'],$id);
  }
 else {
$EditPage = 1;     
}   
require_once("includes/footer.php");
?>


