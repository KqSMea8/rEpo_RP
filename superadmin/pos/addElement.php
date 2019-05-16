<?php
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For addElement.php
 */

/* * *********************************************** */
$ThisPageName = 'addElement.php';
/* * *********************************************** */
require_once("includes/header.php");


$objConfigure = new configure();
$ModuleName = "Element";
$RedirectURL = "element.php?curP=" . $_GET['curP']; 
if (empty($_GET['tab']))
$_GET['tab'] = "element";
$EditUrl = "addElement.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "&tab=". $_GET["tab"] ;
$ActionUrl = $EditUrl . $_GET["tab"];
 
$objelement=new plan();
 
 
if(!empty($_GET["edit"])){ 
	$element_id =$_GET['edit'];
	$arryElement = $objelement->getPlanelement($_GET,$element_id,'');
}else{
	$EditPage = 1;     
	 	

}   
require_once("includes/footer.php");
?>


