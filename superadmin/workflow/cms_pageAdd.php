<?php 
    /**************************************************/
    $ThisPageName = 'cms_pageAdd.php'; $EditPage = 1; 
    /**************************************************/

	include_once("includes/header.php");
    include_once("classes/cms.class.php");
	   $objelement=new cms();
	   global $FormHelper,$errorformdata ,$objVali;;
  /************************ GET UPDATE PAGE DETAILS ******************************************   */
	   if (!empty($_GET['edit'])) { 
        $id = $_GET['edit'];  
        $arryPages=$objelement->get_page($id);  //print_r($arryPages);
	   }
  /************************ FOR CHANGE STATUS ******************************************   */  
	   if(!empty($_GET['active_id'])){
	   // echo  $id = $_GET['active_id']; 
	    echo  $status = $_GET['Status'];
       $data = array('status'=>$status);//die('hmmmm');
        $objelement->change_Status($data,$_REQUEST['active_id']);
        header('Location:cms.php');
	   }
  /************************ FOR ADD AND UPDATE ******************************************   */      
	   if(isset($_POST['Submit'])){
		 //  echo"<pre>";
		 //  print_r($_POST);//die();
		 $data=array('Name' => $_POST['Name'],
		 'Title' => $_POST['Title'],
		 'Priority' =>  $_POST['Priority'],
		 'page_slug' =>  $_POST['page_slug'],
		 'MetaTitle' =>  $_POST['MetaTitle'],
		 'MetaKeywords' =>  $_POST['MetaKeywords'],
		 'MetaDescription' =>  $_POST['MetaDescription'],
		 'page_content' =>  $_POST['page_content'],
		 'Template' =>  $_POST['Template'],
		 'Status' =>  $_POST['Status'],
		 );
		//print_r($data);//die('nnn');
		 $validatedata=array(	
		'Name'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Name')),
		'Title'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Title')),
		'page_slug'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Slug')),
		);
		$objVali->requestvalue=$_POST;
		$errors  =	$objVali->validate($validatedata);	
	 
	   if( empty($_POST['id']) && !empty($_POST['page_slug']) && !$objelement->checkSlug($_POST['page_slug'])){
			$errors['page_slug']='Slug Already Exist';
		}
	
			 $aa=array();
                        if(empty($errors)){
                        if(empty($_POST['id']) ){
                        	$objelement->addPage($data);
                        }else{      
                        unset($data['page_slug']);                  
                        $objelement->update_page($data,$_POST['id']);
                        }
                        header("Location: cms.php");    
                        }else{
                            $FormHelper->errordata=$errorformdata=$errors;
                            
                        }
	
		  
	   }
	
		
	require_once("includes/footer.php"); 	 
?>


