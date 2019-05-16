<?php   
require_once("includes/header.php");
include_once("includes/header_menu.php");
require_once("classes/customer.class.php");
require_once("classes/company.class.php");
$objCompany=new company();
$objCustomer=new Customer();

ValidateMemberSession($ThisPage);
if(!empty($_SESSION['Cid'])){ $arrayWishlist = $objProduct->getWishlist($_SESSION['Cid']);}

  if(!empty($_REQUEST['Wlid']) && !empty($_REQUEST['Cid']))
           {
               
              $objProduct->RemoveWishList($_REQUEST['Wlid'],$_REQUEST['Cid']);
              $_SESSION['successMsg'] = WISHLIST_REMOVE;
	      echo '<script>location.href="myWishlist.php?action=manage_wishlist";</script>';
	      exit;
               
           }
           
     if(!empty($_REQUEST['Wlpid']) && !empty($_REQUEST['WID']))
           {
               
              $objProduct->RemoveWishListProduct($_REQUEST['Wlpid'],$_REQUEST['WID']);
              $_SESSION['successMsg'] = WISHLIST_PRODUCT_REMOVE;
	      echo '<script>location.href="myWishlist.php?action=edit_wishlist&WishlistID='.$_REQUEST['WID'].'&CustID='.$_SESSION['Cid'].'";</script>';
	      exit;
               
           }
           
     if(!empty($_REQUEST['CustID']) && !empty($_REQUEST['WishlistID']) ){
         $wishlist_data = $objProduct->GetProductByWishListId($_REQUEST['CustID'],$_REQUEST['WishlistID']); 
         }      
         
    if(($_REQUEST['action'] == "update_wishlist") && !empty($_REQUEST['Wlid']))
    { 
         $objProduct->UpdateWishList($_POST);
         $_SESSION['successMsg'] = WISHLIST_UPDATE;
	 echo '<script>location.href="myWishlist.php?action=edit_wishlist&WishlistID='.$_REQUEST['WishlistID'].'&CustID='.$_SESSION['Cid'].'";</script>';
	 exit;
    }
    
   if(($_REQUEST['action'] == "send_email") && !empty($_REQUEST['Wlid']))
    { 
          $list = $objProduct->GetProductByWishListId($_SESSION['Cid'],$_REQUEST['Wlid']);
	  $mail_subject = isset($_POST["mail_subject"]) ? $_POST["mail_subject"] : "";
	  $your_email = isset($_POST["your_email"]) ? $_POST["your_email"] : "";
          $objProduct->EmailWishlist($_SESSION['Cid'], $list);
          $_SESSION['successMsg'] = WISHLIST_EMAIL;
	 echo '<script>location.href="myWishlist.php?action=manage_wishlist";</script>';
	 exit;
    }
require_once("includes/footer.php"); 

               
?>