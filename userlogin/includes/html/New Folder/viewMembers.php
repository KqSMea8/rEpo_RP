<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewMembers.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value)+'&opt='+escape(frm.opt.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewMembers.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value)+'&opt='+escape(frm.opt.value);
			}
			return false;*/
		}
</script>

<div class="had"><?php echo 'Manage '.$_GET['opt'].'s';?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_member'])) {echo $_SESSION['mess_member']; unset($_SESSION['mess_member']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right"><a href="editMember.php?opt=<?=$_GET['opt']?>" class="Blue">Add <?=$_GET['opt']?></a></td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
	  <table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
        <tr>
          <td>
		  <select name="sortby" id="sortby" class="inputbox" >
			
                <option value=""> All </option>
				 <option value="m.UserName" <? if($_GET['sortby']=='m.UserName') echo 'selected';?>>User Name</option>
                <option value="m.Email" <? if($_GET['sortby']=='m.Email') echo 'selected';?>>Email</option>
			<? if($_GET['opt']=="Seller") {?>	<option value="ms.Name" <? if($_GET['sortby']=='ms.Name') echo 'selected';?>>Membership</option> 
			<option value="m.CompanyName" <? if($_GET['sortby']=='m.CompanyName') echo 'selected';?>>Company</option>
			<option value="m.Featured" <? if($_GET['sortby']=='m.Featured') echo 'selected';?>>Featured Store</option>
			<? }else{ ?>
				 <option value="m.JoiningDate" <? if($_GET['sortby']=='m.JoiningDate') echo 'selected';?>>Joining Date</option>
			<? } ?>
			
			<option value="m.Status" <? if($_GET['sortby']=='m.Status') echo 'selected';?>>Status</option>
              </select>
		  
		  </td>
          <td ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>" /></td>
		  
		  <td>
            
              <select name="asc" id="asc" class="inputbox" >
                <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
              </select>
          </td>
		  
          <td>
              <input name="search" type="submit" class="search_button" value="Go" />
              <? if($_GET['key']!='') {?>
              <a href="viewMembers.php?opt=<?=$_GET['opt']?>">View All</a>
            <? }?></td>
         
        </tr>
      </table>
	</form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
   
    <tr align="left" >
      <td width="1%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','MemberID','<?=sizeof($arryMember)?>');" /></td>
      <td width="23%" class="head1" >User Name</td>
      <td class="head1" >Email</td>
      <td class="head1" ><? if($_GET['opt']=="Seller") echo 'Membership'; ?></td>
      <td  class="head1" ><? if($_GET['opt']=="Buyer") echo 'Joining Date';else echo 'Company'; ?></td>
      <td width="12%" class="head1" ><? if($_GET['opt']=="Seller") echo 'Featured Store'; ?></td>
      <td width="8%" class="head1" >Status</td>
      <td width="10%" align="center" class="head1" >Action</td>
    </tr>
    
    <?php 
  if(is_array($arryMember) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryMember as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
	$Line++;
	
	#if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left" bgcolor="<?=$bgcolor?>">
      <td ><input type="checkbox" name="MemberID[]" id="MemberID<?=$Line?>" value="<?=$values['MemberID']?>" /></td>
      <td height="35" > <?
		  echo '<a onclick="OpenNewPopUp(\'vMember.php?edit='.$values['MemberID'].'\', 550, 660, \'no\' );" href="#" ><b>'. stripslashes($values["UserName"]) .'</b></a><br>'; 
		  
		 if($_GET['opt']=="Seller" && $values['Status']==1) {
		 	
		 	if($values['WebsiteStoreOption']=='s' || $values['WebsiteStoreOption']=='ws'){
				$StoreLink = $Config['Url'].$Config['StorePrefix'].$values['UserName'].'/store.php';
				echo '<Span class=red><a href="'.$StoreLink.'" target="_blank" >(View Store)</a></span>&nbsp;';
			}
			if($values['WebsiteStoreOption']=='w' || $values['WebsiteStoreOption']=='ws'){
				$Weblink = $Config['Url'].$Config['StorePrefix'].$values['UserName'].'/home.php';
				echo '<Span class=red><a href="'.$Weblink.'" target="_blank" >(View Website)</a></span>';
			}
		 } 
		  
		  ?>		       </td>
      <td><?  echo '<a href="mailto:'.$values['Email'].'">'.$values['Email'].'</a>'; ?></td>
      <td >
	  <? if($_GET['opt']=="Seller"){
	  	 	echo stripslashes($values['Membership']); 
			//echo '<br>(<a onclick="OpenNewPopUp(\'vMemberships.php?edit='.$values['MemberID'].'\', 850, 460, \'no\' );" href="#" class="edit">View All</a>)';
		 }
	  
	  ?></td>
      <td >
	  <? 	
	 if($_GET['opt']=="Buyer")
	 	 echo $values['JoiningDate'];
	 else 
	 	echo stripslashes($values['CompanyName']); 
	  
	  
	?>      </td>
      <td><? 
		if($_GET['opt']=="Seller"){
			echo $values["Featured"];
			/*
			 $fstatus = ($values["Featured"]=='Yes')?("No"):("Yes");
	
			echo '<a href="editMember.php?feature_id='.$values["MemberID"].'&curP='.$_GET["curP"].'&opt='.$_GET['opt'].'&fstatus='.$fstatus.'" class="edit">'.$values["Featured"].'</a>';
			*/
			}
	 ?></td>
      <td><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editMember.php?active_id='.$values["MemberID"].'&curP='.$_GET["curP"].'&opt='.$_GET['opt'].'" class="edit">'.$status.'</a>';
		
	 ?></td>
      <td align="center" ><a href="editMember.php?edit=<?php echo $values['MemberID'];?>&amp;curP=<?php echo $_GET['curP'];?>&opt=<?=$_GET['opt']?>" class="edit"><?=$edit?></a>
	  <? if($values['MemberID']>1){ ?>
	  <a href="editMember.php?del_id=<?php echo $values['MemberID'];?>&amp;curP=<?php echo $_GET['curP'];?>&opt=<?=$_GET['opt']?>" onclick="return confDel('<?=$_GET['opt']?>')" class="edit" ><?=$delete?></a>
	  <? } ?>	  </td>
    </tr>
    <?php } // foreach end //?>
    <tr align="center" >
      <td height="5" colspan="8" class="myt1"></td>
    </tr>
    <?php }else{?>
    <tr align="center" >
      <td colspan="8" class="no_record"><?=$_GET['opt']?> Not Found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryMember)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  
 <? if(sizeof($arryMember)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" >
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="Button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$_GET['opt']?>','delete','<?=$Line?>','MemberID','editMember.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="Button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$_GET['opt']?>','active','<?=$Line?>','MemberID','editMember.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="Button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$_GET['opt']?>','inactive','<?=$Line?>','MemberID','editMember.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $_GET['opt']; ?>">
</form>
</td>
	</tr>
</table>
