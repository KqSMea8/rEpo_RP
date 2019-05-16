<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewItem.php'; 
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	$objItem=new items();
        $_GET['Status']=1;
      
        
        $arryCat=$objItem->categoryChild($_GET['CatID']);
       	$result =array(); 
       	
       
		   	
		    
		   
		     $_GET['InData'] = $arryCat.$_GET['CatID'];
		    $_GET['InData'] = preg_replace('/^,+|,+$/', '', $_GET['InData']);
		    	$_GET['CatID'] ='';
        
        $arryQuant=$objItem->GetSerialqtyAvg($_GET['fby'],$_GET['f'],$_GET['t'],$_GET['m'],$_GET['y'],$_GET['c'],$values["Sku"],$_GET['InData']);
       
	//$arryProduct=$objItem->GetItemsView($_GET);
	
	$num=$objItem->numRows();
       /* if($RecordsPerPage == 10)
        {
            $RecordsPerPage = $RecordsPerPage;
        }
        else{
            $RecordsPerPage = 100;
        }*/

	 //$pagerLink=$objPager->getPager($arryQuant,$RecordsPerPage,$_GET['curP']);
	//(count($newarray)>0)?($arryQuant=$objPager->getPageRecords()):("");
	 
	
		  

  require_once("../includes/footer.php");

?>
