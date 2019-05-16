<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewBuyers.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewBuyers.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
<div class="had"><?php echo 'Manage '.$_GET['opt'].'s';?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_member'])) {echo $_SESSION['mess_member']; unset($_SESSION['mess_member']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <tr>
        <td align="right"><a href="editBuyer.php" class="Blue">Add <?=$_GET['opt']?></a></td>
      </tr>
	
	<tr>
	  <td  valign="top">
	  
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
	  <table  border="0" cellpadding="0" cellspacing="3"  id="search_table">
        <tr>
          <td><select name="sortby" id="sortby" class="inputbox">
			
                <option value=""> All </option>
				 <option value="m.UserName" <? if($_GET['sortby']=='m.UserName') echo 'selected';?>>User Name</option>
				   <option value="m.MemberID" <? if($_GET['sortby']=='m.MemberID') echo 'selected';?>>Reference Number</option>
                <option value="m.Email" <? if($_GET['sortby']=='m.Email') echo 'selected';?>>Email</option>
						
			 <option value="m.JoiningDate" <? if($_GET['sortby']=='m.JoiningDate') echo 'selected';?>>Joining Date</option>
			
			
			<option value="m.Status" <? if($_GET['sortby']=='m.Status') echo 'selected';?>>Status</option>
              </select></td>
          <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>" /></td>
		  <td >
            
              <select name="asc" id="asc" class="inputbox">
                <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
              </select>
          </td>
		  
          <td>
              <input name="search" type="submit" class="search_button" value="Go" />
              <? if($_GET['key']!='') {?>
              <a href="viewBuyers.php">View all</a>
            <? }?></td>
          
        </tr>
      </table>
	</form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
   
    <tr align="left" >
      <td width="1%" class="head1" ><!--<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','MemberID','<?=sizeof($arryMember)?>');" /> --></td>
      <td width="23%" height="20" class="head1" >User Name</td>
      <td class="head1" >Reference Number</td>
      <td class="head1" >Email</td>
      <td  class="head1" >Joining Date</td>
      <td width="8%" height="20" class="head1" >Status</td>
      <td width="10%" height="20" align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryMember) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryMember as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td ><!--<input type="checkbox" name="MemberID[]" id="MemberID<?=$Line?>" value="<?=$values['MemberID']?>" /> --></td>
      <td height="35" > <?
		  echo '<a onclick="OpenNewPopUp(\'vBuyer.php?edit='.$values['MemberID'].'\', 550, 660, \'no\' );" href="#" ><b>'. stripslashes($values["UserName"]) .'</b></a><br>'; 
		  
		
		  
		  ?>		       </td>
      <td>
        <?=$values['MemberID']?>
      </td>
      <td><?  echo '<a href="mailto:'.$values['Email'].'">'.$values['Email'].'</a>'; ?></td>
      <td class="blacknormal">
	  <? 	
	 echo $values['JoiningDate'];
	  
	  
	?>      </td>
      <td height="35"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editBuyer.php?active_id='.$values["MemberID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	 ?></td>
      <td height="35" align="center"  ><a href="editBuyer.php?edit=<?php echo $values['MemberID'];?>&amp;curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>
	  <? if($values['MemberID']>1){ ?>
	  <a href="editBuyer.php?del_id=<?php echo $values['MemberID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confDel('<?=$_GET['opt']?>')" class="edit" ><?=$delete?></a>
	  <? } ?>	  </td>
    </tr>
    <?php } // foreach end //?>
   
    <?php }else{?>
    <tr align="center" >
      <td height="20" colspan="7" class="no_record">No <?=$_GET['opt']?> Found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td height="20" colspan="7">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryMember)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  
 <? if(sizeof($arryMember)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none" >
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="Button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$_GET['opt']?>','delete','<?=$Line?>','MemberID','editBuyer.php?curP=<?=$_GET[curP]?>');">
      <input type="button" name="ActiveButton" class="Button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$_GET['opt']?>','active','<?=$Line?>','MemberID','editBuyer.php?curP=<?=$_GET[curP]?>');" />
      <input type="button" name="InActiveButton" class="Button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$_GET['opt']?>','inactive','<?=$Line?>','MemberID','editBuyer.php?curP=<?=$_GET[curP]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $_GET['opt']; ?>">
</form>
</td>
	</tr>
</table>
