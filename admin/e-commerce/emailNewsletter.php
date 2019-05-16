<?php 
/**************************************************/
	 $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
         
	require_once($Prefix."classes/customer.class.php");
	
	$cmsCustomer = new Customer();

(!isset($_GET['template_id']))?($_GET['template_id']=""):("");         
       
        $ModuleTitle = "Newsletter Email Wizard";
        $ModuleName = 'Newsletter';
        $ListUrl    = "emailNewsletter.php";
                       
                $previousTemplate = $cmsCustomer->getNewsletterTemplateByStatus();
                if(!empty($_GET['template_id']))
                {
                 $arrayTemplateByID = $cmsCustomer->getNewsletterTemplateById($_GET['template_id']);
                }


                         if ($_POST) {

                                $_SESSION['mess_Subscriber'] = $ModuleName.SEND;
                                $cmsCustomer->sendNewsletterEmail($_POST);
                                header("location:".$ListUrl);
                                exit;
                        }
		




 require_once("../includes/footer.php"); 
 
 
 ?>
