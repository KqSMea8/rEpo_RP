
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewFeedback.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewFeedback.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
<div class="had"> Manage Product Feedbacks </div>
<div class="message"><? if(!empty($_SESSION['mess_feedback'])) {echo $_SESSION['mess_feedback']; unset($_SESSION['mess_feedback']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
	  <td  valign="top">
	  
<!--
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td width="81%">&nbsp;</td>
		<td width="19%" align="right"><a href="editFeedback.php" class="Blue">Add Feedback</a></td>
	  </tr>
	</table>
-->
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td >
					  <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
							 <option value="p.Name" <? if($_GET['sortby']=='p.Name') echo 'selected';?>>Product Name</option>
						    <option value="f.Comment" <? if($_GET['sortby']=='f.Comment') echo 'selected';?>>Comments</option>
						    <option value="f.Name" <? if($_GET['sortby']=='f.Name') echo 'selected';?>>Posted By</option>
						    <option value="f.Email" <? if($_GET['sortby']=='f.Email') echo 'selected';?>>Email Address</option>
					 </select>
					  
					  </td>
                      <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
					   <td>
				    
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
                      <td>
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewFeedback.php">View All</a><? }?></td>
                  
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left"  >
    <td width="16%" class="head1" >Product Name</td>
    <td width="23%" class="head1" >Comments</td>
    <td width="14%" class="head1" >Posted By</td>
    <td width="18%" class="head1" >Email Address</td>
    <td width="16%" class="head1" >Posted Date</td>
    <td width="6%"  class="head1" >Status</td>
    <td width="7%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryFeedback,$RecordsPerPage,$_GET['curP']);
 (count($arryFeedback)>0)?($arryFeedback=$objPager->getPageRecords()):("");
  if(is_array($arryFeedback) && $num>0){
  	$flag=true;
  	foreach($arryFeedback as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>" >
    <td ><a href="../productDetails.php?id=<?=$values['ProductID']?>" target="_blank" class="Blue"><strong><?=stripslashes($values['ProductName'])?></strong></a> </td>
    <td ><?=stripslashes($values['Comment'])?>    </td>
    <td><?=stripslashes($values['Name'])?></td>
<td><?=stripslashes($values['Email'])?></td>
 <td>
	 
 <? if($values['feedbackDate'] > 0){	
		echo date("jS F, Y H:i:s", strtotime($values['feedbackDate']));
		//echo $values['feedbackDate'];
	}
?>	 </td>
 <td>
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editFeedback.php?active_id='.$values["feedbackID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?>    </td>
    <td  align="center"  >
	<a href="editFeedback.php?edit=<?php echo $values['feedbackID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>

	<a href="editFeedback.php?del_id=<?php echo $values['feedbackID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Feedback')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="7" class="no_record">No feedback posted yet. </td>
  </tr>

  <?php } ?>
    
  <tr  >  <td  colspan="7" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryFeedback)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
