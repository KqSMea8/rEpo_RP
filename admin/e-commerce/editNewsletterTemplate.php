<?php 
	/**************************************************/
	$ThisPageName = 'viewNewsletterTemplate.php'; $EditPage = 1;
	/**************************************************/
      
 	include_once("../includes/header.php");
         
	require_once($Prefix."classes/customer.class.php");
	
	$cmsCustomer = new Customer();

                 $TemplateId = isset($_GET['edit'])?$_GET['edit']:"";	
                  $ModuleTitle = "Edit Newsletter Template";
                        $ModuleName = 'Newsletter Template';
                        $ListTitle  = 'Newsletter Template';
                        $ListUrl    = "viewNewsletterTemplate.php?curP=".$_GET['curP'];
                       
               $TemplateStatus = "Yes";
                    if (!empty($TemplateId)) 
                    {
                        $arryNewsletterTemplate = $cmsCustomer->getNewsletterTemplateById($TemplateId);
                        if($arryNewsletterTemplate[0]['Status'] == "No"){
			$TemplateStatus = "No";
                            }else{
                                    $TemplateStatus = "Yes";
                            }
                    }

			
		 	 
                 if(!empty($_GET['active_id'])){
                    $_SESSION['mess_template'] = $ModuleName.STATUS;
                    $cmsCustomer->changeNewsletterTemplateStatus($_REQUEST['active_id']);
                    header("location:".$ListUrl);
		    exit;
                 }
	

                if(!empty($_GET['del_id'])){

                       $_SESSION['mess_template'] = $ModuleName.REMOVED;
                       $cmsCustomer->deleteNewsletterTemplate($_GET['del_id']);
                       header("location:".$ListUrl);
                       exit;
               }
		


                         if ($_POST) {

                            if (!empty($TemplateId)) {
                                    $_SESSION['mess_template'] = $ModuleName.UPDATED;
                                    $cmsCustomer->updateNewsletterTemplate($_POST);
                                    header("location:".$ListUrl);
				    exit;
                            } 
                            else
                            {
                                   $_SESSION['mess_template'] = $ModuleName.ADDED;
                                    $cmsCustomer->addNewsletterTemplate($_POST);
                                    header("location:".$ListUrl);
				    exit;
                            }

                            

                        }
		
                 




 require_once("../includes/footer.php"); 
 
 
 ?>
