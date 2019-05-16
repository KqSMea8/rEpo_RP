
<?php include('siteManagementMenu.php');?>
   <div class="clear"></div> 
<div class="had">Testimonial Management</div>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_testimonial'])) {echo $_SESSION['mess_testimonial']; unset($_SESSION['mess_testimonial']); }?>
</div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_testimonial'])) {
    echo stripslashes($_SESSION['mess_testimonial']);
    unset($_SESSION['mess_testimonial']);
} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editTestimonial.php" class="add">Add Testimonial</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="10%" height="20"  class="head1" align="left">Author Name</td> 
                    <td width="20%" height="20"  class="head1" align="left">Description</td> 
                    <td width="10%" height="20" class="head1" align="center">Image</td>
                    <td  width="5%" height="20"  class="head1" align="center">Status</td>
                    <td width="5%"   height="20"  class="head1" align="center">Action</td>
                </tr>
                <?php
                

                if (is_array($arryTestimonials) && $num > 0) {

                    foreach ($arryTestimonials as $key => $values) {
                        ?>
                        <tr align="left" bgcolor="<?= $bgcolor ?>">
    <td align="left"><?=stripslashes($values['AuthorName'])?></td>
     <td align="left"><?=stripslashes($values['Description'])?></td>
     <td height="26" align="center">

<? /*if($values['Image'] !=''){ ?>
<img border="0"src="../resizeimage.php?w=75&amp;h=75&amp;img=images/<?= $values['Image']; ?>">
<? }else{ ?>

<img src="../resizeimage.php?w=75&amp;h=75&amp;img=images/nouser.gif" />
 <? } */?>

<?
 

	$PreviewArray['Folder'] = $Config['TestimonialDir'];
	$PreviewArray['FileName'] = $values['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($values['AuthorName']);
	$PreviewArray['Width'] = "75";
	$PreviewArray['Height'] = "75";
	$PreviewArray['Link'] = "1";
	$PreviewArray['NoImage'] = "../images/nouser.gif";
	echo PreviewImage($PreviewArray);

 
?>


   
					</td>
    <td align="center">
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editTestimonial.php?active_id='.$values["TestimonialID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
	   
	 ?>    </td>
    <td  align="center" class="head1_inner" >
	<a href="vTestimonial.php?view=<?=$values['TestimonialID']?>" class="fancybox fancybox.iframe"><?=$view?></a>
	<a href="editTestimonial.php?edit=<?php echo $values['TestimonialID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>

	<a href="editTestimonial.php?del_id=<?php echo $values['TestimonialID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confirmDialog(this, 'Testimonial')" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTestimonials)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
            </table>
        </td>
    </tr>
</table>
        

  
