<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewDocument.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewDocument.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>
<div class="had">Manage <?=$_GET['parent_type']?> Document</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Document'])) {echo $_SESSION['mess_Document']; unset($_SESSION['mess_Document']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	  <td  valign="right">
	  
		<a href="<?=$AddUrl?>" class="add">Add <?=$_GET['parent_type']?> Document</a>

		 <? if($_GET['key']!='') {?>
	  	<a href="<?=$ViewUrl?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
		 
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<div id="piGal">
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <!--<td width="2%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','documentID','<?=sizeof($arryDocument)?>');" /></td>-->
      <!--td width="14%"  class="head1" >Document ID</td-->
      <td width="20%"  class="head1" >Title</td>
      <td class="head1" >Description</td>
      <td width="13%"  class="head1" >Download</td>
      <td width="15%" class="head1" >  Created On</td>
	  <!--<td width="11%" class="head1" > Assign To</td>-->
	  
    
      <td width="8%"  align="center" class="head1" >Status</td>
      <td width="10%"   align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryDocument) && $num>0){
  	$flag=true;
	$Line=0;
	$MainDir = "upload/Document/".$_SESSION['CmpID']."/";
  	foreach($arryDocument as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="documentID[]" id="documentID<?=$Line?>" value="<?=$values['documentID']?>" /></td>-->
       <!--td ><?=stripslashes($values['documentID'])?></td-->
            <td ><?=stripslashes($values['title'])?></td>
    <td><?=stripslashes($values['description'])?></td>
    <td >

 <? if($values['FileName'] !='' && file_exists($MainDir.$values['FileName']) ){
	$DocExist=1;
	?>
	<a href="dwn.php?file=<?=$MainDir.$values['FileName']?>" class="download">Download</a>	
	
    <? } else {	
	$DocExist=0;
	echo NOT_UPLOADED;
	}
?> 

       </td>
    
      
      
      
      
      
	  <td><? if($values['AddedDate']) echo date($Config['DateFormat'].", H:i:s" , strtotime($values["AddedDate"])); ?> </td>
	  <!--<td><?=$values['AssignTo']?></td>-->
	   
       
    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
			
		 }else{
			  $status = 'InActive';
			    
		 }
	
	 

	echo '<a class="'.$status.'" href="editDocument.php?active_id='.$values["documentID"].'&module='.$_GET['module'].'&parent_type='.$_GET['parent_type'].'&parentID='.$_GET['parentID'].'&curP='.$_GET["curP"].'" >'.$status.'</a>';
		
	 ?></td>
 
      <td  align="center" class="head1_inner"  >
<a href="vDocument.php?view=<?php echo $values['documentID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$_GET['parent_type']?>&parentID=<?=$_GET['parentID']?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$view?></a>

<a href="editDocument.php?edit=<?php echo $values['documentID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$_GET['parent_type']?>&parentID=<?=$_GET['parentID']?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
	  
	<a href="editDocument.php?del_id=<?php echo $values['documentID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$_GET['parent_type']?>&parentID=<?=$_GET['parentID']?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  

<? if($DocExist==1){ ?>
<br><a class="fancybox fancybox.iframe" href="<?='sendDoc.php?view='.$values['documentID'].'&curP='.$_GET['curP']?>" >Send Document</a>
<? } ?>

 </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryDocument)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  </div>
  </div> 
 <? if(sizeof($arryDocument)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','documentID','editDocument.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','documentID','editDocument.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','documentID','editDocument.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
