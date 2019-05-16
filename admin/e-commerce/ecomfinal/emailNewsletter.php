<?php 
/**************************************************/
	 $EditPage = 1;
	/**************************************************/
	include_once("includes/header.php");
         
	require_once("classes/customer.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
             if (class_exists(Customer)) {
	  	$cmsCustomer = new Customer();
	} else {
  		echo "Class Not Found Error !! Customer Class Not Found !";
		exit;
  	}
                
                        $ModuleTitle = "Newsletter Email Wizard";
                        $ModuleName = 'Newsletter';
                        $ListUrl    = "emailNewsletter.php";
                       
                $previousTemplate = $cmsCustomer->getNewsletterTemplateByStatus();
                if(!empty($_GET['template_id']))
                {
                 $arrayTemplateByID = $cmsCustomer->getNewsletterTemplateById($_GET['template_id']);
                }

                
                if (is_object($cmsCustomer)) {	

                         if ($_POST) {

                                $_SESSION['mess_Subscriber'] = $ModuleName.SEND;
                                $cmsCustomer->sendNewsletterEmail($_POST);
                                header("location:".$ListUrl);
                                exit;
                        }
		
                 
}



 require_once("includes/footer.php"); 
 
 
 ?>
