<? if ($_GET['tab'] == 'Document') { 
	$arryDocument=$objLead->ListDocument('',$_GET['module'],$_GET['view'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objLead->numRows();
	$pagerLink=$objPager->getPager($arryDocument,$RecordsPerPage,$_GET['curP']);
	(count($arryDocument)>0)?($arryDocument=$objPager->getPageRecords()):("");
        //$AddDoc = "editDocument.php?module=".$_GET['module']."&parent_type=".$_GET['module']."&parentID=".$_GET['view'];
 $AddDoc = "editDocument.php?module=Document&parent_type=".$_GET['module']."&parentID=".$_GET['view'];

?>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Document'])) {echo $_SESSION['mess_Document']; unset($_SESSION['mess_Document']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	  <td  valign="right">
	  
		<a href="<?=$AddDoc?>" class="add">Add <?=ucfirst($_GET['module'])?> Document</a>

		 


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<div id="piGal">
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <!--<td width="2%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','documentID','<?=sizeof($arryDocument)?>');" /></td>-->
      <td width="14%"  class="head1" >Document ID</td>
      <td width="11%"  class="head1" >Title</td>
      <td width="19%"  class="head1" >Description</td>
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
	 
  	foreach($arryDocument as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="documentID[]" id="documentID<?=$Line?>" value="<?=$values['documentID']?>" /></td>-->
       <td ><?=stripslashes($values['documentID'])?></td>
            <td ><?=stripslashes($values['title'])?></td>
    <td><?=stripslashes($values['description'])?></td>
    <td >
      <? if(IsFileExist($Config['C_DocumentDir'], $values['FileName']) ){
	?>
	<a href="../download.php?file=<?=$values['FileName']?>&folder=<?=$Config['C_DocumentDir']?>" class="download">Download</a>	
	
    <? } else {	
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
	
	$parent_type = isset($_GET['parent_type']) ? $_GET['parent_type'] : '';
	$parentID = isset($_GET['parentID']) ? $_GET['parentID'] : '';

	echo '<a class="'.$status.'" href="editDocument.php?active_id='.$values["documentID"].'&module='.$_GET['module'].'&parent_type='.$parent_type.'&parentID='.$parentID.'&curP='.$_GET["curP"].'" >'.$status.'</a>';
		
	 ?></td>
      <td  align="center" class="head1_inner"  ><!--a href="editDocument.php?edit=<?php echo $values['documentID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$_GET['parent_type']?>&parentID=<?=$_GET['parentID']?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a-->
	  
	<a href="editDocument.php?del_id=<?php echo $values['documentID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$_GET['module']?>&parentID=<?=$_GET['view']?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, 'Document')"  ><?=$delete?></a>   </td-->
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
<td></tr>
</TABLE>
<? } ?>
