
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewFaqs.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewFaqs.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>

<div class="had">Manage FAQs</div>
<div class="message"><? if(!empty($_SESSION['mess_faq'])) {echo $_SESSION['mess_faq']; unset($_SESSION['mess_faq']); }?></div>
<TABLE WIDTH="95%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 <tr>
		<td align="right"><a href="editFaq.php" >Add FAQ</a></td>
	  </tr>
	  
	<tr>
	  <td valign="top">  


	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td>  <select name="sortby" id="sortby" class="inputbox" >
						    <option value="" >All</option>
							<option value="f.Question" <? if($_GET['sortby']=='f.Question') echo 'selected';?>>Question</option>
							<option value="c.Name" <? if($_GET['sortby']=='c.Name') echo 'selected';?>>Category</option>
					 </select></td>
                      <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
					  
					   <td>				  
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					 </select>
					 
					 </td>
					  
                      <td>
                        <input name="search" type="submit" class="search_button" value="Go">
					  <? if($_GET['key']!='') {?> <a href="viewFaqs.php">View All</a><? }?></td>
                  
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>

  
  <tr align="left"  >
    <td width="51%" class="head1" >Question</td>
    <td width="26%" class="head1" >Category</td>
    <td width="12%"  class="head1" >Status</td>
    <td width="11%"  align="center" class="head1" >Action</td>
  </tr>
  
  <?php 
  $pagerLink=$objPager->getPager($arryFaq,$RecordsPerPage,$_GET['curP']);
 (count($arryFaq)>0)?($arryFaq=$objPager->getPageRecords()):("");
  if(is_array($arryFaq) && $num>0){
  	$flag=true;
  	foreach($arryFaq as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td class="blacknormal">
    <?=substr(stripslashes($values['Question']),0,100)?>   </td>
    <td > <?=stripslashes($values['Category'])?></td>
    <td height="32" >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editFaq.php?active_id='.$values["faqID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?>    </td>
    <td  align="center"  >
	<a href="editFaq.php?edit=<?php echo $values['faqID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>

	<a href="editFaq.php?del_id=<?php echo $values['faqID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('FAQ')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  <tr >
  	  <td height="20" colspan="4" class="no_record">No record found.</td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="4" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryFaq)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
