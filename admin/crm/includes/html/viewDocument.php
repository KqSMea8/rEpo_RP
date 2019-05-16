<script language="JavaScript1.2" type="text/javascript">	
function ShowReport(){	 
	LoaderSearch();
}	


  $(function() {
    $( ".draggable" ).draggable({revert: 'invalid'});
    $( ".droppable" ).droppable({
 
      drop: function( event, ui ) {

     
      //alert($(this).attr('id')+"&documentID="+ui.draggable.attr('id'));
      //return false;
        $.ajax({
			type: "GET",
			data: "action=documentTofolder&FolderID="+$(this).attr('id')+"&documentID="+ui.draggable.attr('id'),
			url: "ajax.php",
            success: function (data) {

                     if (data=1)
                        {
				 ShowHideLoader(1,'S');
                          window.location.reload();
                        }
                      } 
                   
             });
             }
       
    
    });
  });

//By Rajan 21 Jan 2016//
  $(document).ready(function(){
      
  	  $('#highlight select#RowColor').attr('onchange','javascript:showColorRowsbyFilter(this)');
        $('#highlight select#RowColor option').each(function() {
            $val = $(this).val();
            $text = $(this).text();
            $val = $val.replace('#', '');
    	    $(this).val($val);
        });
        
  });


  var showColorRowsbyFilter = function(obj)
  { 
      if(obj.value !='')
      {
          $url = window.location.href.split("&rows")[0]; 
          window.location.href = $url+'&rows='+obj.value;
      }
  }
//End Rajan 21 Jan 2016//
</script>
<div class="had">Manage <?=$parent_type?> Document</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Document'])) {echo $_SESSION['mess_Document']; unset($_SESSION['mess_Document']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


<!--form action="" method="get" name="form2" onSubmit="return  ShowReport();">
<tr>
		<td    valign="left">
	
<table id="search_table" cellspacing="0" cellpadding="0" border="0" style="margin:0">
<td    valign="left">	 
Folder :  
</td>
<td    valign="left">
		<select name="FolderID" class="inputbox" id="FolderID"> 
			  <option value="">--- All ---</option>
			  <? for($i=0;$i<sizeof($arryFolder);$i++) {?>
			  <option value="<?=$arryFolder[$i]['FolderID']?>" <?  if($arryFolder[$i]['FolderID']==$_GET['FolderID']){echo "selected";}?>>
			  <?=stripslashes($arryFolder[$i]['FolderName'])?>
			  </option>
			  <? } ?>
			</select>
    </td>

<td    valign="left">

   <input name="module" type="hidden" class="search_button" value="Document"  />
		
		 <input name="submit" type="submit" class="search_button" value="Go"  />
 </td>

</table>

</td>
</tr>
</form-->

	 
<tr>	
	  <td  valign="right">
	  


<? if ($num > 0) { ?>	

<ul class="export_menu">
<li><a class="hide" href="#">Export Document</a>
<ul>
<li class="excel" ><a href="export_doc.php?<?=$QueryString?>&flage=1" ><?=EXPORT_EXCEL?></a></li>
<li class="pdf" ><a href="pdfDocument.php?<?=$QueryString?>" ><?=EXPORT_PDF?></a></li>	
<li class="csv" ><a href="export_doc.php?<?=$QueryString?>&flage=2" ><?=EXPORT_CSV?></a></li>	
<li class="doc" ><a href="export_todoc_Document.php?<?=$QueryString?>" ><?=EXPORT_DOC?></a></li>	
</ul>
</li>
</ul>	

  <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>

<a href="editDocumentFolder.php?module=Document" class="add">Add Folder</a>

<a href="<?=$AddUrl?>" class="add">Add Document</a>

		 <? if($_GET['key']!='' || (isset($_GET['FolderID']) && $_GET['FolderID']>0)) {?>
	  	<a href="<?=$ViewUrl?>" class="grey_bt" style="float:left">Back to Root</a>
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

<tr>
	  <td  valign="left"  colspan="6">
Folder List
		</td>
      </tr>

   <?php 
  if(is_array($arryFolder)){
  	$flag=true;
	$Line=0;
  	foreach($arryFolder as $key=>$assignvalues){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

$NumDoc = $objLead->CountDocument($assignvalues['FolderID']);
if($NumDoc>0) $NumDoc='('.$NumDoc.')';

?>
<tr align="left" class="droppable" id="<?=$assignvalues['FolderID']?>" <?php  if(isset($_GET['FolderID']) && $_GET['FolderID']==$assignvalues['FolderID']){ echo 'style="background-color:#CCCCCC;"'; } ?> }  >

   <td colspan="9">
<a <?php  if(isset($_GET['FolderID']) && $_GET['FolderID']==$assignvalues['FolderID']){ echo 'style="color:#000; font-weight:bold;"'; } ?> href="viewDocument.php?FolderID=<?=$assignvalues['FolderID'];?>&module=Document&submit=Go"><img border="0"  src="../../admin/images/folder_icon.png">&nbsp;&nbsp;<?=stripslashes($assignvalues['FolderName']);?></a>&nbsp;<?=$NumDoc?>

</td>  
    </tr>

<? }?>
<tr>
	  <td  valign="left"  colspan="9"  >

		</td>
      </tr>
<? } ?>   



    <tr align="left"  >
      <!--<td width="2%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','documentID','<?=sizeof($arryDocument)?>');" /></td>-->
      <!--td width="14%"  class="head1" >Document ID</td-->
      <td width="20%"  class="head1" >Title</td>
      <td class="head1" >Description</td>
      <td width="13%"  class="head1" >Download</td>
      <td width="18%" class="head1" >  Created On</td>
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
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>" class="draggable" style="cursor:move" id="<?=$values['documentID']?>">
     <!-- <td ><input type="checkbox" name="documentID[]" id="documentID<?=$Line?>" value="<?=$values['documentID']?>" /></td>-->
       <!--td ><?=stripslashes($values['documentID'])?></td-->
            <td onmouseover="mouseoverfun('title','<?php echo $values['documentID']; ?>')"
					onmouseout="mouseoutfun('title','<?php echo $values['documentID']; ?>')"><span id="title<?php echo $values['documentID']; ?>"> <?=stripslashes($values['title'])?>
				</span> 
<?php if($ModifyLabel==1 && $FieldEditableArray['title']==1){ ?>
				<span class="editable_evenbg"
					id="field_title<?php echo $values['documentID']; ?>"></span>
				<span
					id="edit_title<?php echo $values['documentID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_document','title','documentID','<?php echo $values['documentID']; ?>','<?php echo $FieldTypeArray['title']?>');"><?= $edit ?></span>
					<?php }?></td>
    <td onmouseover="mouseoverfun('description','<?php echo $values['documentID']; ?>')"
					onmouseout="mouseoutfun('description','<?php echo $values['documentID']; ?>')"><?=stripslashes($values['description'])?>

<span id="description<?php echo $values['documentID']; ?>"> 
					<?=stripslashes($values['description'])?>
					</span> 
				<?php if($ModifyLabel==1 && $FieldEditableArray['description']==1){ ?>
				<span class="editable_evenbg"
					id="field_description<?php echo $values['documentID']; ?>"></span>
				<span
					id="edit_description<?php echo $values['documentID']; ?>"
					style="cursor: pointer; display: none;"
					onclick="getField('c_document','description','documentID','<?php echo $values['documentID']; ?>','<?php echo $FieldTypeArray['description']?>');"><?= $edit ?></span>
					<?php }?>

</td>
    <td >

 <? if(is_file_exist($Config['C_DocumentDir'], $values['FileName'], $values['FileExist']) ){
	$DocExist=1;
	?>
	<a href="../download.php?file=<?=$values['FileName']?>&folder=<?=$Config['C_DocumentDir']?>" class="download">Download</a>	
	
    <? } else {	
	$DocExist=0;
	echo NOT_UPLOADED;
	}
?> 

       </td>
    
      
      
      
      
      
	  <td><? if($values['AddedDate']) echo date($Config['DateFormat'].", ".$Config['TimeFormat'] , strtotime($values["AddedDate"])); ?> </td>
	  <!--<td><?=$values['AssignTo']?></td>-->
	   
       
    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
			
		 }else{
			  $status = 'InActive';
			    
		 }
	
	 

	echo '<a class="'.$status.'" href="editDocument.php?active_id='.$values["documentID"].'&module='.$_GET['module'].'&parent_type='.$parent_type.'&parentID='.$parentID.'&curP='.$_GET["curP"].'" >'.$status.'</a>';
		
	 ?></td>
 
      <td  align="center" class="head1_inner"  >
<a href="vDocument.php?view=<?php echo $values['documentID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$parent_type?>&parentID=<?=$parentID?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$view?></a>

<a href="editDocument.php?edit=<?php echo $values['documentID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$parent_type?>&parentID=<?=$parentID?>&amp;curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
	  
	<a href="editDocument.php?del_id=<?php echo $values['documentID'];?>&amp;module=<?=$_GET['module']?>&parent_type=<?=$parent_type?>&parentID=<?=$parentID?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  

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
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','documentID','editDocument.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','documentID','editDocument.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','documentID','editDocument.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
