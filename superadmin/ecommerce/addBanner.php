
<?php

require_once("includes/header.php");
require_once("classes/banner.class.php");
$objUser=new banner();
$id='';

/************************ GET UPDATE PAGE DETAILS ******************************************   */
	   if (!empty($_GET['edit'])) { 
        $id = $_GET['edit'];  
       
        $arryBanner=$objUser->get_banner($id); 
     
            
	   }
  /************************ FOR CHANGE STATUS ******************************************   */  
	   if(!empty($_GET['active_id'])){
	   $id = $_GET['active_id']; 
	      $status = $_GET['status'];
       $data = array('status'=>$status);
       //print_r($data);die('hmmmm');
       
        $objUser->change_Status($data,$_REQUEST['active_id']);
        header('Location:banner.php');
	   }
  
 //echo  $_SERVER['DOCUMENT_ROOT']   ;   
if(isset($_POST['submit']))
{
    //print_r($_REQUEST['image']);die;
    
      
        $hid=$_POST['hid'];
        $arr['image']=empty($_FILES['image']['name'])?$_REQUEST['image']:$_FILES['image']['name'];
	$arr['status']=$_POST['status'];
        $arr['bannerContent']=$_POST['bannerContent'];
        
       if($arr['image']!='' )
	 { 
                  
                       
   move_uploaded_file($_FILES['image']['tmp_name'],"../../upload/ecomupload/37/banner_image/".$arr['image']);
   
   unlink("../../upload/ecomupload/37/banner_image".$_FILES['image']['name']);
    
       if(empty($_POST['id']) ){
          
            $_SESSION['mess_banner'] = 'Banner added';
                        	 $objUser->addbanner($arr);
                                  header("Location:banner.php"); 
                                 exit;
                        }
                        
                        else{      
                              $_SESSION['mess_banner'] = 'Banner update';     
                        $objUser->update_banner($arr,$_POST['id']);
                        header("Location:banner.php"); 
                         exit;
                        }
 
}
else
{ 
    $_SESSION['mess_banner'] = 'Please select the banner';
	
}

}

require_once("includes/footer.php");
?>
