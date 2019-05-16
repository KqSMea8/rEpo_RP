
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewMemberships.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewMemberships.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>

<div class="had"><?php echo '&nbsp;Manage Memberships';?></div>
<div class="message"><? if(!empty($_SESSION['mess_memb'])) {echo $_SESSION['mess_memb']; unset($_SESSION['mess_memb']); }?></div>
<TABLE WIDTH="95%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
		<td align="right"><a href="editMembership.php" class="Blue">Add Membership</a></td>

  </tr>
	<tr>
	  <td  valign="top">
	

	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
			<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td> <select name="sortby" id="sortby" class="inputbox" >
						<option value="">All</option>
						  <option value="Name" <? if($_GET['sortby']=='Name') echo 'selected';?>>Membership</option>
					    <option value="Price" <? if($_GET['sortby']=='Price') echo 'selected';?>>Price</option>		
						<option value="Validity" <? if($_GET['sortby']=='Validity') echo 'selected';?>>Validity</option>
					 </select></td>
                      <td ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
					   <td> <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
					  
                      <td>
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewMemberships.php">View All</a><? }?></td>
                  
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  <tr align="left"  >
    <td width="20%"  class="head1" >&nbsp;Membership</td>
    <td width="28%"class="head1"  style="display:none">&nbsp;</td>
    <td width="13%"class="head1" >Price (<?=$Config['Currency']?>)</td>
	 <td width="16%" class="head1" >Validity (In days)</td>
    <td width="7%"  class="head1" >Status</td>
    <td width="16%"  align="center" class="head1" >Action</td>
  </tr>
  
  <?php 
  $pagerLink=$objPager->getPager($arryMember,200,$_GET['curP']);
 (count($arryMember)>0)?($arryMember=$objPager->getPageRecords()):("");
  if(is_array($arryMember) && $num>0){
  	$flag=true;
	$k = 0;
  	foreach($arryMember as $key=>$values){
	
	//$objMember->UpdateTestPostion($values['MembershipID'],$k+1);
	
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
	
   $PrevNo = $values['sort_order'] - 1;
   $NextNo = $values['sort_order'] + 1;
	
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td  >
	<?=stripslashes($values['Name'])?></td>
    <td style="display:none" >
 <Div style="width:20px;float:left"> 
									  <? if($k!=0){
									  ?>
                                          <a href="editMembership.php?sortID=<?=$values['MembershipID']?>&curP=<?=$_GET['curP']?>&SortNo=<?=$PrevNo?>" ><img src="images/sort_asc2.gif" border="0" /></a>
                                          <? } ?>
									</Div>	  
										
										
									 <Div style="width:20px"> 	  
		<? if($k!= sizeof($arryMember)-1) {?>
                                           <a href="editMembership.php?sortID=<?=$values['MembershipID']?>&curP=<?=$_GET['curP']?>&SortNo=<?=$NextNo?>" ><img src="images/sort_desc2.gif" border="0" /></a>
                                          <? } ?>   
									</Div>		
	</td>
    <td ><?  if($values['Price']>0) echo $values['Price']; ?></td>
    <td >
	<? 	echo $values['Validity'];	?>     </td>
    <td  >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 
	  if($values['MembershipID']>1){
	  		echo '<a href="editMembership.php?active_id='.$values["MembershipID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		 } else{ 
	 	    echo '<span >'.$status.'</span>';
	   } 
	   
	 ?>    </td>
    <td  align="center"  >
	<a href="editMembership.php?edit=<?php echo $values['MembershipID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>
	<? if($values['MembershipID']>1){ ?>
	<a href="editMembership.php?del_id=<?php echo $values['MembershipID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Membership')" class="edit" ><?=$delete?></a>&nbsp;
	<? } ?>	</td>
  </tr>
  <?php $k++; } // foreach end //?>
 

  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="6" class="no_record">Membership Not Found ! </td>
  </tr>

  <?php } ?>
    
  <tr>  <td  colspan="6" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryMember)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
