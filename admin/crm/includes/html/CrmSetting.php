<script language="JavaScript1.2" type="text/javascript">
$(function() {  //by chetn 3March//
      var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
        };

      $( ".listrows tbody" ).sortable({
        helper: fixHelper,
        items: "> tr:not(:last)",
        update: function( event, ui ) {      
                $fstID = [];
                $start = Number($('#startPage').val()) + 1;
                $( ".listrows tbody tr:not(:last)").each(function(i){
                    $fstID.push($(this).find('input[name^="fieldID"]').val());
                    $(this).find('td:eq(3)').text(Number(i)+Number($start));
                })
                $fstID = $fstID.join(',');
                head = $('#head').val();
                $.ajax({
                        
                        method: "GET",
                        url : "ajax.php?action=updateCFSequence",
                        data : {Ids : $fstID, headID : head,start:$start},
                        success :function(data){}
                    
                    
                })
        }
      });
        $( ".listrows tbody" ).disableSelection();
    });
//End//


	function SubmitModule(frm){	
		if(document.getElementById("prv_msg_div")!=null){
			document.getElementById("prv_msg_div").style.display = 'block';
			document.getElementById("preview_div").style.display = 'none';
		}

		document.topForm.submit();
	}	

	
	function ValidateSearch2(){

		if(document.getElementById("head").value==""){
			alert("Please Select Head.");
			document.getElementById("head").focus();
			return false;
		}
		if(document.getElementById("prv_msg_div")!=null){
			document.getElementById("prv_msg_div").style.display = 'block';
			document.getElementById("preview_div").style.display = 'none';
		}
		
	}	
	
	function SubmitHead(frm){	
	//alert("aaaaa");
		if(document.getElementById("prv_msg_div")!=null){
			document.getElementById("prv_msg_div").style.display = 'none';
			document.getElementById("preview_div").style.display = 'none';
		}
	
	}	
</script>

<div class="had">Field List</div>
<!--By Chetan 13July -->
<div class="message"><?php  if(!empty($_SESSION['mess_field'])) {echo $_SESSION['mess_field']; unset($_SESSION['mess_field']); }?></div>



<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0">

 <tr>
	  <td  valign="top">
	
	

	
	
<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="display:block; width:280px; margin:0">
	<form action="" method="get" name="topForm" >
	<tr>
		<td width="80" >Module :  </td>
		<td >
        
        <select name="mod" class="inputbox" id="mod" onChange="SubmitModule(this);" >
       <option value="">--Select Module--</option>
   <? for($i=0;$i<9;$i++) {?>
							<option value="<?=$arrayHeaderMenus[$i]['ModuleID']?>" <?  if($arrayHeaderMenus[$i]['ModuleID']==$_GET['mod']){echo "selected";}?>>
							<?=stripslashes($arrayHeaderMenus[$i]['Module']);?> 
							</option>
						<? } ?>
     
      <option value="2003" <?  if($_GET['mod']==2003){echo "selected";}?>>Item Master </option>
     </select>
		 
		
			
		</td>
		</tr>
		</form>
		
	<? if($_GET['mod']>0){ ?>	
	
	 <form action="" method="get" name="form2" onSubmit="ValidateSearch2();">
	<tr>
		<td valign="top">Header :  </td>
		<td>
		 <select name="head" class="inputbox" id="head" onChange="SubmitHead(this);" >
       <option value="" >--Select Module--</option>
   <? for($i=0;$i<sizeof($arryAtt);$i++) {?>
							<option value="<?=$arryAtt[$i]['head_id']?>" <?  if($arryAtt[$i]['head_id']==$_GET['head']){echo "selected";}?>>
							<?=stripslashes($arryAtt[$i]['head_value'])?> 
							</option>
						<? } ?>
	<input type="hidden" name="mod" value="<?=$_GET["mod"]?>" />
		</td>
		 
        </tr>
		
		<tr>
		<td>&nbsp;</td>
		<td>
		 <input name="search" type="submit" class="search_button" value="Go"  />
		
		 </td> 
		 </tr>
		</form>	
		<? }else{
			 if($_GET['mod']>0){
			 ?>
		<tr>
		<td>&nbsp;</td>
		<td class="redmsg" align="left" >
		No Field  added.
		</td>
		</tr>
		<? }
		} ?>
      </table>
	
	
	
	 

		
		
	
	</table>  
	  
	


<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>

<div id="preview_div" >
<? if($_GET['head']>0){?>
	<div align="right">
	<a href="editCustomField.php?head=<?=$_GET['head']?>&mod=<?=$_GET['mod']?>" class="add">Add Custom Field</a>
    </div><br /><br />
<? }?>
<? if($_GET['head']!=''){?>


<table class="listrows" <?=$table_bg?> >
   <thead>
    <tr align="left"  >
       <!--td width="23%" class="head1" >Field ID</td-->
       <!--td width="23%"  class="head1" >Field Name</td-->
	   <td  class="head1"  >Label Name</td>
    
      <!--td  class="head1"  >Type</td-->
      <td  class="head1" align="center" >Mandatory</td>
      <td  class="head1" align="center" >Display</td>
      <td  class="head1"  >Sequence</td>
       <td  class="head1" align="center" >Action</td>
    </tr>
   
  </thead>
   
 <tbody> 
    <?php 
  if(is_array($arryField) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryField as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--td ><?=$values["fieldid"]?></td-->
      <!--td ><?=$values["fieldname"]?></td-->
      <td ><?=$values["fieldlabel"]?>
 <input type="hidden" name="sequence<?=$Line?>" id="sequence<?=$Line?>" value="<?php echo $values['sequence'];?>">
          <input type="hidden" name="fieldID<?=$Line?>" id="fieldID<?=$Line?>" value="<?php echo $values['fieldid'];?>"></td>
      <!--td ><? if($values["type"] == 'select'){ echo 'Dropdown List';}else{ echo $values["type"];} ?></td-->
     
   <td align="center"><? 
if($values['mandatory'] ==1){
 $mandatory = 'Yes';
 $class="Active";
}else{
 $mandatory = 'No';
 $class="InActive";
}
 

echo '<a href="CrmSetting.php?mand='.$values['fieldid'].'&head='.$_GET['head'].'&mod='.$_GET['mod'].'&curP='.$_GET['curP'].'" class="'.$class.'">'.$mandatory.'</a>';
?></td>
 <td align="center"><? 
if($values['Status'] ==1){
 $status = 'Show';
 $class="Active";
}else{
 $status = 'Hide';
 $class="InActive";
}
 

echo '<a href="CrmSetting.php?display='.$values['fieldid'].'&head='.$_GET['head'].'&mod='.$_GET['mod'].'&curP='.$_GET['curP'].'" class="'.$class.'">'.$status.'</a>';
?></td>
<td ><?=$values["sequence"]?></td>
      <td  align="center"  ><a href="editCustomField.php?edit=<?php echo $values['fieldid'];?>&amp;curP=<?php echo $_GET['curP'];?>&mod=<?=$_GET['mod']?>&head=<?=$_GET['head']?>" ><?=$edit?></a>
 <? if($values['editable']==1){?>
<a href="editCustomField.php?del_id=<?php echo $values['fieldid'];?>&amp;curP=<?php echo $_GET['curP'];?>&mod=<?=$_GET['mod']?>&head=<?=$_GET['head']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>  </td>
<? }?>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
<tr >   <td  colspan="7" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryField) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?>
  </tr>
   
  
</tbody>
 </table>
  <? }?>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
<!--by chetan 3 March--->
  <input type="hidden" name="head" id="head" value="<?php echo $_GET['head']; ?>"> 
  <input type="hidden" name="rcdprPg" id="rcdprPg" value="<?php echo $RecordsPerPage; ?>">
  <input type="hidden" name="startPage" id="startPage" value="<?php echo $Config['StartPage']; ?>">
  <!--End--->
</form>



</div>



