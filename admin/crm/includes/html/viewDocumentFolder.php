<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		
	}
</script>
<div class="had">Manage Folder</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Document'])) {echo $_SESSION['mess_Document']; unset($_SESSION['mess_Document']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	  <td  valign="right">
	  
	<a href="<?=$AddUrl?>" class="add">Add <?=$parent_type;?> Folder</a>

         <? if($_GET['key']!='') {?>
	  	<a href="<?=$ViewUrl?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
		 
	
<form action="" method="post" name="FolderName">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<div id="piGal">
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <!--<td width="2%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','documentID','<?=sizeof($arryDocument)?>');" /></td>-->
      <!--td width="14%"  class="head1" >Document ID</td-->
      <td width="20%"  class="head1" >Folder Name</td>
<td width="8%"  align="center" class="head1" >Status</td>
      <td width="10%"   align="center" class="head1" >Action</td>
    </tr>
   
    <?php

//print_r($arryDocument); 
  if(is_array($arryDocument) && $num>0){
  	$flag=true;
	$Line=0;
	//$MainDir = "upload/Document/".$_SESSION['CmpID']."/";
  	foreach($arryDocument as $key=>$values){

	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="documentID[]" id="documentID<?=$Line?>" value="<?=$values['FolderID']?>" /></td>-->
       <!--td ><?=stripslashes($values['FolderID'])?></td-->
            <td ><?=stripslashes($values['FolderName'])?></td>
<td align="center"><? 
		 if($values['Status'] ==1){


			    $status = 'Active';
			
		 }else{
			   $status = 'InActive';    
		 }
	
	 echo '<a class="'.$status.'" href="editDocumentFolder.php?active_id='.$values["FolderID"].'&module='.$_GET['module'].'&parent_type='.$parent_type.'&parentID='.$parentID.'&curP='.$_GET["curP"].'" >'.$status.'</a>';
		
	 ?></td>
 
      <td  align="center" class="head1_inner"  >


<a href="editDocumentFolder.php?edit=<?php echo $values['FolderID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$parent_type?>&parentID=<?=$parentID?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
	  
	<a href="viewDocumentFolder.php?del_id=<?php echo $values['FolderID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$parent_type?>&parentID=<?=$parentID?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  

<?php /*?><a href="editxyz.php?edit=<?php echo $values['xyz_id'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$_GET['parent_type']?>&parentID=<?=$_GET['parentID']?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
	  
<a href="viewxyz.php?del_id=<?php echo $values['xyz_id'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$_GET['parent_type']?>&parentID=<?=$_GET['parentID']?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this,'<?=$ModuleName?>')"  ><?=$delete?></a>  
<?php */?>
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
    <td height="30" align="left">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','FolderID','editDocumentFolder.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','FolderID','editDocumentFolder.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
  
  </table>
  <? } ?>  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
