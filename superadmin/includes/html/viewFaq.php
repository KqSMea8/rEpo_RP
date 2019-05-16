
<?php include('siteManagementMenu.php');?>
   <div class="clear"></div> 
<div class="had"> FAQ Management</div>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_faq'])) {echo $_SESSION['mess_faq']; unset($_SESSION['mess_faq']); }?>
</div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_faq'])) {
    echo stripslashes($_SESSION['mess_faq']);
    unset($_SESSION['mess_faq']);
} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="editFaq.php" class="add">Add FAQ</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td  height="20"  class="head1" align="left"> Faq Title</td> 
 
                    <td width="20%" height="20" class="head1" align="center">Image</td>
                    <td  width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="10%"   height="20"  class="head1" align="center">Action</td>
                </tr>
                <?php
                
                if (is_array($arryFaq) && $num > 0) {

                    foreach ($arryFaq as $key => $values) {
                        ?>
                        <tr align="left" bgcolor="<?= $bgcolor ?>">
    <td align="left"><?=stripslashes($values['Title'])?></td>
    
     <td height="26" align="center">

<? 

	$PreviewArray['Folder'] = $Config['FaqDir'];
	$PreviewArray['FileName'] = $values['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($values['Title']);
	$PreviewArray['Width'] = "70";
	$PreviewArray['Height'] = "70";
	$PreviewArray['Link'] = "1";
	$PreviewArray['NoImage'] = "../images/no.jpg";
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
	
	 

		echo '<a href="editFaq.php?active_id='.$values["FaqID"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
	   
	 ?>    </td>
    <td  align="center" class="head1_inner" >
	<a href="vFaq.php?view=<?=$values['FaqID']?>" class="fancybox fancybox.iframe"><?=$view?></a>
	<a href="editFaq.php?edit=<?php echo $values['FaqID'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>

	<a href="editFaq.php?del_id=<?php echo $values['FaqID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confirmDialog(this, 'FAQ')" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryFaq)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
            </table>
        </td>
    </tr>
</table>
        

  
