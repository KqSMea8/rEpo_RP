<?php 
/* Developer Name: Niraj Gupta
 * Date : 19-06-15
 * Description: For addElement.php
 */
?>

<div><a href="payment.php" class="back">Back</a></div>
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

	<table <?= $table_bg ?> style="width:30%; margin:0px auto 0px auto;">
	<?php   
                        $deleteElement = '<img src="' . $Config['Url'] . 'admin/images/delete.png" border="0" >';
			//print_r($arryElement);
                        
			//print_r($arryElement);
                            $flag = true;
                           ?>
                        <tr align="center"  >
                          <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CmpID','<?= sizeof($arryElement) ?>');" /></td>-->
                            <td width="50%"  class="head1" >Company Name</td> <td class="head1"><?= stripslashes($arryElement->name) ?></td>
</tr>
<tr align="center"  >
                             <td width="50%"  class="head1" >Total Amount</td><td class="head1"><?= stripslashes($arryElement->total_amount) ?></td>
</tr>
                         <tr align="center"  >   <td width="50%" class="head1" >Discount Amount</td> <td class="head1"><?=$arryElement->discount_amount?></td>  
</tr>
                  <tr align="center"  >          <td  width="50%" class="head1" >Pay Amount</td><td class="head1"><?=$arryElement->pay_amount ?></td> 
</tr>
 			  <tr align="center"  >  <td  width="50%" class="head1" >Allow Users</td><td class="head1"><?=$arryElement->allow_users ?></td> </tr>
			   <tr align="center"  > <td  width="50%" class="head1" >Plan Duration</td><td class="head1"><?=$arryElement->plan_duration ?></td></tr>
 			   <tr align="center"  > <td  width="50%" class="head1" >Date</td><td class="head1"><?=$arryElement->date ?></td>
                        </tr>

                       
    

                       

                        
                    </table>

