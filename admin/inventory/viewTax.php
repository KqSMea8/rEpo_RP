<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/inv_tax.class.php");
        
	  $objTax=new tax();
	  
	
	 	$arryTax=$objTax->getTaxes();
		$num=$objTax->numRows();

		//print_r($arryTax);
                
               //print_r($arryTax);
                //print_r($arryTax);
                 $pagerLink = $objPager->getPager($arryTax, $RecordsPerPage, $_GET['curP']);
                (count($arryTax) > 0) ? ($arryTax = $objPager->getPageRecords()) : ("");
         
		 

               
                     
                
          
             
		
	

                     
  
  require_once("../includes/footer.php");
  
?>
