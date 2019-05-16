<div class="had">Manage Template Categories
</div>
	  <div class="message"><? if(!empty($_SESSION['mess_tpcat'])) {echo stripslashes($_SESSION['mess_tpcat']); unset($_SESSION['mess_tpcat']); }?></div>
<TABLE WIDTH="90%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
    <td align="right"><a href="editTpCategory.php?curP=<?php echo $_GET['curP'];?>" class="Blue">Add Template Category</a></td>
  </tr>
	
	<tr>
	  <td height="350" valign="top">


<table <?=$table_bg?>>

  <tr align="left" valign="middle"  >
    <td width="63%" height="20" class="head1" >Category Name</td>
 
    <td width="18%"  height="20" class="head1"  >Status</td>
    <td width="19%"   height="20" align="center" class="head1"  >Action</td>
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
    <td height="20"  ="">
	 


	 
	 
	 <?  echo stripslashes($values['Name']);
	 ?></td>
    
    <td height="20" ><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editTpCategory.php?active_id='.$values["catID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?></td>
    <td height="20" align="center" ><a href="editTpCategory.php?edit=<?php echo $values['catID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>  <a href="editTpCategory.php?del_id=<?php echo $values['catID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Category')" class="edit" ><?=$delete?></a>
	
	</td>
  </tr>
  <?php } // foreach end //?>
  
  <?php }else{?>
  <tr >
  	  <td height="20" colspan="4" class="no_record">No record found.</td>
  </tr>

  <?php } ?>
   
 
  <tr >  <td height="20" colspan="5" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCategory)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
</td>
	</tr>
</table>