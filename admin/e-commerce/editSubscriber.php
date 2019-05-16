<?php 
	/**************************************************/
	$ThisPageName = 'viewSubscriber.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/customer.class.php");
	
		 $cmsCustomer = new Customer();

                 $EmailId = isset($_GET['edit'])?$_GET['edit']:"";	
                  $ModuleTitle = "Edit Subscriber";
                        $ModuleName = 'Subscriber';
                        $ListTitle  = 'Subscriber';
                        $ListUrl    = "viewSubscriber.php?curP=".$_GET['curP'];
                       
               
                   
		 	 
                 if(!empty($_GET['active_id'])){
                    $_SESSION['mess_Subscriber'] = $ModuleName.STATUS;
                    $cmsCustomer->changeSubcriberStatus($_REQUEST['active_id']);
                    header("location:".$ListUrl);
		    exit;
                 }
	

                if(!empty($_GET['del_id'])){

                       $_SESSION['mess_Subscriber'] = $ModuleName.REMOVED;
                       $cmsCustomer->deleteSubcriber($_GET['del_id']);
                       header("location:".$ListUrl);
                       exit;
               }
		


                         if ($_POST) {

                            if (!empty($EmailId)) {
                                    $_SESSION['mess_Subscriber'] = $ModuleName.UPDATED;
                                    $cmsCustomer->updateSubcriber($_POST);
                                    header("location:".$ListUrl);
                            } 

                            exit;

                        }

		 if (!empty($EmailId)) 
                    {
                        $arrySubcriber = $cmsCustomer->getSubcriberById($EmailId);
                        if($arrySubcriber[0]['Status'] == "No"){
			$SubcriberStatus = "No";
                            }else{
                                    $SubcriberStatus = "Yes";
                            }
                    }
		
                 




 require_once("../includes/footer.php"); 
 
 
 ?>
