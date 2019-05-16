<div class="had"><?=$MainModuleName?></div>
<? if(!empty($_SESSION['mess_benefit'])) {echo '<div class="message">'.$_SESSION['mess_benefit'].'</div>'; unset($_SESSION['mess_benefit']); }?>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td>
              <a href="editBenefit.php" class="add">Add Benefit</a>
		
<? if($_GET['search']!='') {?> <a href="viewBenefit.php" class="grey_bt">View All</a><? }?>
	  </td>
	  </tr>
	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td width="25%" class="head1" >Heading</td>
    <td class="head1" > Detail </td>
        <td width="13%"  class="head1" >Document</td>
    <td width="8%" align="center" class="head1" >Status</td>
    <td width="13%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  if(is_array($arryBenefit) && $num>0)
  {
  	$flag=true;
       
  	foreach($arryBenefit as $key=>$values){
	$flag=!$flag;
  ?>
  <tr align="left" >
    <td><?=stripslashes($values['Heading'])?></td>
     <td><?=substr(strip_tags(stripslashes($values['Detail'])),0,300)?>...</td>
   <td >

 <? if($values['Document'] !='' && IsFileExist($Config['BenefitDir'], $values['Document']) ){
	$DocExist=1;
	?>
	<a href="../download.php?file=<?=$values['Document']?>&folder=<?=$Config['BenefitDir']?>" class="download">Download</a>	
	
    <? } else {	
	$DocExist=0;
	echo NOT_UPLOADED;
	}
?> 

       </td>
   
    
   
    <td align="center">
      <? 
		 if($values['Status'] ==1)
		 {
			  $status = 'Active';
		 }
                 else
                 {
			  $status = 'InActive';
		 }
	

		echo '<a href="editBenefit.php?active_id='.$values["Bid"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
	   
	 ?>    </td>
    <td  align="center" class="head1_inner" >
        <a href="vBenefit.php?view=<?=$values['Bid']?>" class="fancybox fancybox.iframe"><?=$view?></a>
	<a href="editBenefit.php?edit=<?php echo $values['Bid'];?>&curP=<?php echo $_GET['curP'];?>"><?=$edit?></a>

        <a href="editBenefit.php?del_id=<?php echo $values['Bid'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confirmDialog(this, 'Benefit')" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="6" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryBenefit)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
