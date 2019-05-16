<?php   
require_once("includes/header.php");
include_once("includes/header_menu.php");
	

if (!empty($_SESSION['Email']) && !empty($_SESSION['Cid'])) {
			header('location: account.php');
			exit;
	}
                                    
        if (!empty($_POST['LoginEmail'])) {

               if($arryMember = $objCustomer->ValidateCustomer($_POST['LoginEmail'], $_POST['LoginPassword'], $_POST['LoginType'])){

                       if(md5($_POST['LoginPassword']) != $arryMember[0]['Password']){
                               $_SESSION['errorMsg'] = INVALID_LOGIN; 
                       }else{
                               //print_r($arryMember);
                               //echo $arryMember[0]['Type']; exit;
                               $objCustomer->updateSessionCustomer($arryMember[0]['Cid']);

                               $_SESSION['Password'] = $arryMember[0]['Password']; 
                               $_SESSION['Email'] = $arryMember[0]['Email']; 
                               $_SESSION['Cid'] =    $arryMember[0]['Cid']; 
                               $_SESSION['Level'] =    $arryMember[0]['Level']; 
                               $_SESSION['GroupID'] =    $arryMember[0]['GroupID'];
                               $_SESSION['Name'] = ucfirst($arryMember[0]['FirstName']).' '.ucfirst($arryMember[0]['LastName']); 
                               $_SESSION['CompanyName']= $arryMember[0]['Company']; 

                               if(!empty($_POST['Remember'])){
                                       setcookie("RememberUserName", $arryMember[0]['Email'], time()+(5*3600));
                                       setcookie("RememberPassword", $arryMember[0]['Password'], time()+(5*3600));
                               }






                       /****** Update Member Cart On Login *****/
                               $arryCart = $objOrder->GetCart(session_id());	
                               $numCart  = $objOrder->numRows(); 
                               if($numCart > 0){
                                       $PrdIDs = '';
                                       foreach($arryCart as $key=>$values){
                                               $PrdIDs .= $values['ProductID'].',';
                                       }
                                       $objCustomer->UpdateCustomerCart($_SESSION['Cid'],$PrdIDs);
                                       header('location:cart.php');
                                       exit;
                               }


                               if(!empty($_POST['ContinueUrl'])){
                                       $_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);
                                       header('location:'.$_POST['ContinueUrl']);
                                       exit;
                               }else{

                                    if(!empty($_GET['ProductId']))
                                    {
                                        header('location:productDetails.php?id='.$_GET['ProductId'].'&review=1');
                                        exit;
                                    }
                                    else {
                                        header('location:account.php');
                                        exit;
                                    }

                               }
                       }

               } else{
                      $_SESSION['errorMsg'] = INVALID_LOGIN;
                      header('location:login.php');
                     exit;

               }

        }

	if(!empty($_REQUEST['logout']))
        {
             $_SESSION['successMsg'] = LOG_OFF_SUCCESSFULLY;
        }
		 
        

require_once("includes/footer.php"); 

               
?>