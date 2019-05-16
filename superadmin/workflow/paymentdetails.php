<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For addElement.php
 */

/* * *********************************************** */
$ThisPageName = 'paymentdetails.php';
/* * *********************************************** */
require_once("includes/header.php");
require_once("classes/configure.class.php");
require_once("classes/function.class.php");

$objConfigure = new configure();
$ModuleName = "paymentdetails";
$RedirectURL = "paymentdetails.php?curP=" . $_GET['curP']; 
if (empty($_GET['tab']))
$_GET['tab'] = "coupan";
$EditUrl = "paymentdetails.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "&tab=". $_GET["tab"] ;
$ActionUrl = $EditUrl . $_GET["tab"];
//$HideModule = 'Style="display:none"';
$objelement=new payment();
$arryElement=$objelement->getPlanelement($_GET);

if (!empty($_GET["edit"])){ 
    $id =$_REQUEST['edit'];
	//echo $id;
    $arryElement = $objelement->getPlanelement($_GET['edit'],$id);
	//print_r($arryElement);
  }
 else {
$EditPage = 1;     
}   
require_once("includes/footer.php");
?>


