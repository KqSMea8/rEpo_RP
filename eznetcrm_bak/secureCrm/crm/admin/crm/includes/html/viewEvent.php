<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewEvent.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewEvent.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>

<div class="had">Manage Event</div>

<div class="message" align="center"><? if(!empty($_SESSION['mess_event'])) {echo $_SESSION['mess_event']; unset($_SESSION['mess_event']); }?></div>
<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right"><a href="editEvent.php?module=event" >Add Event</a></td>
      </tr>
	<tr>
	  <td  valign="top">
	  
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
        <tr >
          <td>		  
	<select name="sortby" id="sortby" class="textbox">
		<option value=""> All </option>
		<option value="l.eventID" <? if($_GET['sortby']=='l.eventID') echo 'selected';?>>Event ID</option>
		<option value="l.Status" <? if($_GET['sortby']=='l.Status') echo 'selected';?>>Event status</option>
	</select>
	  </td>
			  
          <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>" /></td>
          <td>            
              <select name="asc" id="asc" class="textbox" >
                <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
              </select>         
			   </td>
		 <td>
		 <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
		 <input name="search" type="submit" class="search_button" value="Go"  />
		  <? if($_GET['key']!='') {?>
		  <a href="viewEvent.php?module=<?=$_GET['module']?>">View All</a>
		<? }?>
		 
		 </td> 
        </tr>
      </table>
	</form>
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<div id="piGal">
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="0%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','eventID','<?=sizeof($arryEvent)?>');" /></td>
  <td width="10%"  class="head1" >Event ID</td>
      <td width="20%"  class="head1" >Event Title</td>
	  <td width="20%" class="head1"> Event Type </td>
	  <td width="18%" class="head1" >Priority</td>
	  <td width="18%" class="head1" > Created Time</td>
      <td width="7%"  align="center" class="head1" > Event Status</td>
      <td width="35%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryEvent) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEvent as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td ><input type="checkbox" name="eventID[]" id="eventID<?=$Line?>" value="<?=$values['eventID']?>" /></td>
      <td ><?=$values["eventID"]?></td>
      <td height="50" > 
	  <?
		  echo  stripslashes($values["FirstName"]); 
		  
		  
		  ?>		       </td>
		   <td><?=$values['company']?></td>
      <td><a href="mailto:<?  echo $values['primary_email'];?>"><?  echo $values['primary_email'];?></a> </td>
	  <td><?=$values['AssignTo']?> (<?=$values['Department']?>)</td>
       
    <td align="center"><? 
		
			  $status = $values['Status'];
		
	
	 

	echo $status;
		
	 ?></td>
			<td  align="center"  >
			<a href="vEvent.php?view=<?php echo $values['eventID'];?>&amp;curP=<?php echo $_GET['curP'];?>&module=<?php echo $_GET['module'];?>"><?=$view?></a>
			<a href="editEvent.php?edit=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Event" ><?=$edit?></a>
			<a href="editEvent.php?del_id=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confDel('<?=$ModuleName?>')"  ><?=$delete?></a>  
			</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEvent)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  </div>
  </div> 
 <? if(sizeof($arryEvent)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','eventID','editEvent.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','eventID','editEvent.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','eventID','editEvent.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>