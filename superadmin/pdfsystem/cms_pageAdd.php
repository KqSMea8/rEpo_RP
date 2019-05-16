<?php 
    /**************************************************/
    $ThisPageName = 'cms_pageAdd.php'; $EditPage = 1; 
    /**************************************************/

	include_once("includes/header.php");
    include_once("classes/cms.class.php");
	   $objelement=new cms();
	   global $FormHelper,$errorformdata ,$objVali;;
	   
  /************************ GET UPDATE PAGE DETAILS ******************************************   */
	 $id = '';
	   if (!empty($_GET['edit'])) { 
         $id = $_GET['edit'];  
        $arryPages=$objelement->get_page($id);  //print_r($arryPages);
	   }
  /************************ FOR CHANGE STATUS ******************************************   */  
	   if(!empty($_GET['active_id'])){ 
	     $status = $_GET['Status'];
       $data = array('status'=>$status);//die('hmmmm');
        $objelement->change_Status($data,$_GET['active_id']);
        header('Location:cms.php?curP='.$_GET['curP']);
	exit;
	   }
  /************************ FOR ADD AND UPDATE ******************************************   */      
	   
	   if(isset($_POST['Submit'])){
	  	 $pageContent=$_POST['page_content'];
	 	  ////CleanPost();
	 	  $_POST['page_content']=$pageContent;
		 $data=array('Name' => $_POST['Name'],
		 'Title' => $_POST['Title'],
		 'Priority' =>  $_POST['Priority'],
		 'page_slug' =>  str_replace(' ', '-',$_POST['page_slug']),
		 'MetaTitle' =>  $_POST['MetaTitle'],
		 'MetaKeywords' =>  $_POST['MetaKeywords'],
		 'MetaDescription' =>  $_POST['MetaDescription'],
		 'page_content' =>  $_POST['page_content'],
		 //'template' =>  $_POST['Template'],
		 'Status' =>  $_POST['Status'],
                 //'Image'=>empty($_FILES['image']['name'])?$_POST['image']:$_FILES['image']['name']
		 );
                 //print_r($data);die;
		 $validatedata=array(	
		'Name'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Name')
                    ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                   // ,array('rule' => 'string', 'message' => 'Please enter only alphabets.')
                    ),
		'Title'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Title')
                    ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                    ),
		'page_slug'=>array(array('rule'=>'notempty','message'=>'Please Enter Page Slug')
                    ,array('rule' => 'removahtml', 'message' => 'Please remove HTML tags.')
                    ),
		);
		$objVali->requestvalue=$_POST;
		$errors  =	$objVali->validate($validatedata);	
	 
	   if( empty($_POST['id']) && !empty($_POST['page_slug']) && !$objelement->checkSlug($_POST['page_slug'])){
			$errors['page_slug']='Slug Already Exist';
		}
                 move_uploaded_file($_FILES['image']['tmp_name'],"../../upload/ecomupload/37/banner_image/".$_FILES['image']['name']);
   
             unlink("../../upload/ecomupload/37/banner_image".$_FILES['image']['name']);
	
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
	$files=array('content'=>'Content Template','price'=>'Price Template','contact'=>'Contact Template','home'=>'Home Template','registration'=>'Registration Template');
		
	require_once("includes/footer.php"); 	 
?>


