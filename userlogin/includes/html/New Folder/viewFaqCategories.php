<div class="had">Manage Faq Categories</div>
	  <div class="message"><? if(!empty($_SESSION['mess_vfcat'])) {echo stripslashes($_SESSION['mess_vfcat']); unset($_SESSION['mess_vfcat']); }?></div>

<TABLE WIDTH="90%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
    <td align="right" height="30"><a href="editFaqCategory.php?curP=<?php echo $_GET['curP'];?>" >Add Faq Category</a></td>
  </tr>
  
 <tr>
	  <td valign="top">


<table <?=$table_bg?>>

  <tr align="left"  >
    <td width="63%"  class="head1" >Category Name</td>
    <td width="18%"   class="head1"  >Status</td>
    <td width="19%"    align="center" class="head1"  >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryCategory,$RecordsPerPage,$_GET['curP']);
 (count($arryCategory)>0)?($arryCategory=$objPager->getPageRecords()):("");
  if(is_array($arryCategory) && $num>0){
  	$flag=true;
  	foreach($arryCategory as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
	
	
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td >
	 
	 <?  echo '<SPAN >'.stripslashes($values['Name']).'</SPAN>';
	 ?></td>
    
    <td  ><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editFaqCategory.php?active_id='.$values["catID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?></td>
    <td  align="center" ><a href="editFaqCategory.php?edit=<?php echo $values['catID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>    <a href="editFaqCategory.php?del_id=<?php echo $values['catID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('<?=$cat_title?>')" class="edit" ><?=$delete?></a>
	
	</td>
  </tr>
  <?php } // foreach end //?>
  
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="4" class="no_record">No category found.</td>
  </tr>

  <?php } ?>
   
 
  <tr>  <td  colspan="5" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCategory)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
</td>
	</tr>
</table>