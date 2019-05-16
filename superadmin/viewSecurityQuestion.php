<?php 
	include_once("includes/header.php");
	require_once("../classes/question.class.php");
    	 
	$questionObj=new question();


	function GetOptionLabel($ColumnName,$OptionArray){	
		$LableName=  '';	 
		foreach($OptionArray as $values){
			if($ColumnName==$values['value']){
				$LableName = $values['label'];
				break;
			}
		}
		return $LableName;
	}



   	$Config['RecordsPerPage'] = $RecordsPerPage;
	/***********Count Records****************/
	$arryQuestion=$questionObj->getQuestion();	
	$Config['GetNumRecords'] = 1;
	$arryCount=$questionObj->getQuestion();
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/

	require_once("includes/footer.php"); 	 
?>


