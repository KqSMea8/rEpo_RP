<?php 
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For addElement.php
 */

global $FormHelper,$errorformdata ,$objVali;;
if(isset($_POST['Submit'])){
     
    	$validatedata=array(	
		'coupan_name'=>array(array('rule'=>'notempty','message'=>'Please enter element name.')),
		'btype'=>array(array('rule'=>'notempty','message'=>'Please enter element slug.')),
                'coupan_quantity'=>array(array('rule'=>'notempty','message'=>'Please enter coupan quantity.')),
		'discount_amount'=>array(array('rule'=>'notempty','message'=>'Please enter discount amount.')),
		'vouchertime'=>array(array('rule'=>'notempty','message'=>'Please Select Customer Voucher Use.')),
		'expire_date'=>array(array('rule'=>'notempty','message'=>'Please enter expire date.')),			
		)	;
		$objVali->requestvalue=$_POST;
		$errors  = $objVali->validate($validatedata);
			$aa=array();
                        if(empty($errors)){
                            $objelement = new coupan();  
//echo    $objelement;                       
                             $data=array('name'=>$_POST['coupan_name'],'voucher_type'=>$_POST['btype'],'coupan_quantity'=>$_POST['coupan_quantity'],'customer_voucher_use'=>$_POST['vouchertime'],'discount'=>$_POST['discount_amount'],'expire_date'=>date('Y-m-d',strtotime($_POST['expire_date'])), 'created_date'=>date("Y-m-d"),'status'=>$_POST['status']);
		//print_r($data); die();
                            if(!empty($_POST['element_id'])){ 
                                $element_id=$_POST['element_id'];                           
                                $update_id=$objelement->UpdateElement($data,$element_id);
                               //print_r($update_id);die();
                                header("Location:".$RedirectURL);
                            }else{                            
                                 $element_id=$objelement->AddElement($data);
				//print_r($element_id);
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
Manage Coupan    <span> &raquo;
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
		if($_GET['tab']=="coupan"){
			include("includes/html/box/coupan_form.php");
		}
	    }else{
		include("includes/html/box/coupan_form.php");
	         }
	
	?>

