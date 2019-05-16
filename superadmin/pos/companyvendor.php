<?php 
    $HideNavigation = 1;
    include_once("includes/header.php");
    include_once("classes/region.class.php");
	
	require_once("classes/plan.class.php");
	
	$ObjPlan = new plan();
	$objUser=new user();
	
	$CmpId =$_REQUEST['cmp'];

    $arryCompany = $objUser->getUser(array(),$CmpId);
	

	$cmpDb = "erp_".$arryCompany->DisplayName;
	
	
	
    $objRegion = new region();
    $ModuleName = "company";
   
    $_GET['userRoleID']=2;
 
 
     $page=$_GET['curP']=empty($_GET['curP'])?1:$_GET['curP'];
    $limit=$_GET['limit']=10; 
    $offset=$_GET['offset']= (($_GET['curP']-1)*$_GET['limit']);
      
	  
    $Config['RecordsPerPage'] = $limit;
    $Config['StartPage'] = $offset;
      
     $getvendorByCompnay =     $objUser->getvendorByCompnayID(array('cmpId'=>$_GET['cmp'],'user_type'=>'vendorpos','isvendor_admin'=>'Yes'));
  
	  $getvendorByCompnayResult = $getvendorByCompnay['result'];
	 $totalrecords=   $num=   $getvendorByCompnayID =    (int) $getvendorByCompnay['totalCount'];
	
	 //$pageslink=$objUser->pagingChat($page,$limit,$offset,$num,$totalrecords);
	 $pageslink=$objPager->getPaging($totalrecords,$Config['RecordsPerPage'],$_GET['curP']);
   	
	require_once("includes/footer.php"); 	
    
?>


