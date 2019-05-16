<?
////////////////////////////////

        require_once($Prefix."classes/help.class.php");
	$objHelp=new help();

	/********Connecting to main database*********/
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	/*******************************************/
	(!isset($_GET['cat']))?($_GET['cat']=""):("");
	(!isset($_GET['depID']))?($_GET['depID']=""):("");
	(!isset($_GET['WsID']))?($_GET['WsID']=""):("");

	$listworkflow=$objHelp->HelpListing($_GET['cat'],$_GET['depID']);
 
        if(!empty($listworkflow)):
	 	$output = array();
		foreach($listworkflow as $item) {
		    if(!isset($output[$item['CategoryName']])) {
		        $output[$item['CategoryName']] = array();
		    }
		    $catName = $item['CategoryName'];
		    unset($item['CategoryName']);
		    $item['DepartmentCount'] = $objHelp->ListCountPost($item['CategoryID'],$_GET['depID']);
		    $output[$catName][] = $item;
		}
	endif;
	$listContentbyHeading=$objHelp->ListContentbyHeadingId($_GET['WsID']);
	$listHCbyCategoryName=$objHelp->ListHCByDepartmentName($_GET['cat'],$_GET['depID']);  

	///////////// End ///////////////////

?>
