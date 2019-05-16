<?php

/* * *********************************************** */
$ThisPageName = 'viewCustomSearch.php';
$EditPage = 1;
/* * *********************************************** */

require_once("../includes/header.php");
require_once($Prefix."classes/employee.class.php");  //By Chetan 12Jan2017 added//
$employee = new employee();
//By Chetan 12Jan2017 update//
       if(  (!strstr($_SERVER['REQUEST_URI'],'vcsearch')) && (!strstr($_SERVER['REQUEST_URI'],'createcustomsearch'))
               && ($_GET['pop']!=1)   &&   (!strstr($_SERVER['REQUEST_URI'],'editaliasItem')) &&  (!strstr($_SERVER['REQUEST_URI'],'custInfo')) && (!strstr($_SERVER['REQUEST_URI'],'csviewcondqty'))  &&  (!strstr($_SERVER['REQUEST_URI'],'csItemSerial')))
        {
               unset($_SESSION['PostData']);
               unset($_SESSION['searchdata']); //added by chetan on 23june//
        }
        //End//
require_once($Prefix . "classes/custom_search.class.php");
//require_once($Prefix . "classes/field.class.php");


$ModuleName = "CustomSearch";
$RedirectURL = "viewCustomSearch.php?curP=" . $_GET['curP'];

$csearch = new customsearch();
//$field   =   new field();
$empArr['Status'] = 1;//By Chetan 20Jan2017 added//
$employeeList = $employee->GetEmployeeList($empArr);//By Chetan 2Jan2017 added/20Jan2017 updated//
$arryCurrency = $csearch->getCurrency('',1); //by chetan 2feb2017//
if(!empty($_GET['edit']))
{
    
    $editData =  $csearch->GetSearchLists($_GET['edit']);
    $editData =  $editData[0];


}else{
	$editData = $objConfigure->GetDefaultArrayValue('c_customsearch');
	 $editData =  $editData[0];
}


require_once("../includes/footer.php");

?>
