<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
	/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewDocuments.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewDocuments.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>	



<div class="had"><?=$MainModuleName?></div>
<div class="message"><? if(!empty($_SESSION['mess_document'])) {echo $_SESSION['mess_document']; unset($_SESSION['mess_document']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

		<tr>
        <td>
		<a href="editDocument.php" class="add">Add Document</a>
	  
<? if($_GET['key']!='') {?> <a href="viewDocument.php" class="grey_bt">View All</a><? }?>


		</td>
      </tr>
	
	<tr>
	  <td  valign="top">
  
	

	
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left" valign="middle" >
    <td width="15%"  class="head1" >Document Title</td>
     <td  class="head1" >Description</td>
     <td width="12%" align="center" class="head1" >Document</td>
   <td width="12%" align="center" class="head1" >Publish</td>
    <td width="12%"  align="center" class="head1" >Action</td>
  </tr>

  <?php 
  
  $pagerLink=$objPager->getPager($arryDocument,$RecordsPerPage,$_GET['curP']);
 (count($arryDocument)>0)?($arryDocument=$objPager->getPageRecords()):("");
  if(is_array($arryDocument) && $num>0){
  	$flag=true;
         
  	foreach($arryDocument as $key=>$values){
	$flag=!$flag;
  ?>
  <tr align="left" valign="middle" >
    <td height="35"><?=stripslashes($values['heading'])?></td>
    <td><?=stripslashes($values['detail'])?></td>
    <td align="center">
      <? 
	if($values['document'] !='' && IsFileExist($Config['H_DocumentDir'], $values['document']) ){
	?>
	<a href="../download.php?file=<?=$values['document']?>&folder=<?=$Config['H_DocumentDir']?>" class="download">Download</a>
	<? }	?>   </td>
    <td align="center">
      <? 
		 if($values['publish'] ==1){
			  $class = 'Active'; $publish = 'Yes';
		 }else{
			  $class = 'InActive'; $publish = 'No';
		 }
	
	 

		echo '<a href="editDocument.php?active_id='.$values["documentID"].'&curP='.$_GET["curP"].'" class="'.$class.'">'.$publish.'</a>';
		
	   
	 ?>    </td>
    <td align="center" class="head1_inner" >
	<a href="vDocument.php?view=<?=$values['documentID']?>"  class="fancybox fancybox.iframe"><?=$view?></a>
	<a href="editDocument.php?edit=<?=$values['documentID']?>&curP=<?=$_GET['curP']?>"><?=$edit?></a>

	<a href="editDocument.php?del_id=<?=$values['documentID']?>&curP=<?=$_GET['curP']?>" onClick="return confirmDialog(this, 'Document')"><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="5" class="no_record"><?=NO_RECORD?></td>
  </tr>

  <?php } ?>
    
  <tr  >  <td height="20" colspan="5"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryDocument)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
