<?php 
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For addElement.php
 */

global $FormHelper,$errorformdata ,$objVali;;
if(isset($_POST['Submit'])){
     
    	$validatedata=array(	
		'element_name'=>array(array('rule'=>'notempty','message'=>'Please enter element name.'),array('rule' => 'removahtml', 'message' => 'Please Remove Html tags.'),array('rule'=>'string','message'=>'Please enter only alphabet.')),
		'element_slug'=>array(array('rule'=>'notempty','message'=>'Please enter element slug.'),array('rule' => 'removahtml', 'message' => 'Please Remove Html tags.')),
                'type'=>array(array('rule'=>'notempty','message'=>'Please enter element type.')),
		//'description'=>array(array('rule'=>'notempty','message'=>'Please enter description.')),			
		)	;
		$objVali->requestvalue=$_POST;
		$errors  = $objVali->validate($validatedata);
			$aa=array();
                        if(empty($errors)){
                            $objelement = new plan();                            
                             $data=array('element_name'=>$_POST['element_name'],'element_slug'=>str_replace(' ', '-',$_POST['element_slug']),'type'=>$_POST['type'],'description'=>$_POST['description'],'status'=>$_POST['status']);
                            if(!empty($_POST['element_id'])){ 
                                $element_id=$_POST['element_id'];                           
                                $update_id=$objelement->UpdateElement($data,$element_id);
                               
                                header("Location:".$RedirectURL);
                            }else{                            
                                 $element_id=$objelement->AddElement($data);
                                 header("Location:".$RedirectURL); /* Redirect browser */ 
                               /* Make sure that code below does not get executed when we redirect. */
                                   exit;
                            }
                           
                          }else{
                            $FormHelper->errordata=$errorformdata=$errors;
                            
                        }
             
}
?>


<div><a href="<?=$RedirectURL?>" class="back">Back</a></div>
<style>
.input.textarea {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    width: auto;
}
</style>
<div class="had">
Manage Element    <span> &raquo;
	<?php 
	if(!empty($_GET['edit'])){
		if($_GET['tab']=="element"){
			echo "Edit Element Details";
		}
	    }else{
		echo "Add ".$ModuleName;
	}
	 ?>
	</span>
</div>
	<?php if (!empty($errors)) {?>
    <div height="2" align="center"  class="red" ><?php //echo $errors;?></div>

  <?php } ?>
  <?php if(!empty($_SESSION['mess_element'])){
  	echo '<div height="2" align="center"  class="redmsg" >'.$_SESSION['mess_element'].'</div>';
  	unset($_SESSION['mess_element']);  	
  }?>

	<?php 
	if(!empty($_GET['edit']))
            {
		if($_GET['tab']=="element"){
			include("includes/html/box/element_form.php");
		}
	    }else{
		include("includes/html/box/element_form.php");
	         }
	
	?>

