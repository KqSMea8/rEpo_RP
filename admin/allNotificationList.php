<?php  $HideNavigation = 1;
	require_once("includes/header.php");
        require_once("../classes/admin.class.php");
    $arryNotification=$objConfig->GetAllNotification();
//pr($arryNotification);
    $num=$objConfig->numRows();

   $pagerLink=$objPager->getPager($arryNotification,$RecordsPerPage,$_GET['curP']);
  (count($arryNotification)>0)?($arryNotification=$objPager->getPageRecords()):("");
    require_once("includes/footer.php"); 
?>
