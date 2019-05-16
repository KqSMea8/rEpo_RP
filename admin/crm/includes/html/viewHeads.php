<script language="JavaScript1.2" type="text/javascript">
function ShowList(){
	document.getElementById("ListingRecords").style.display = 'none';
	document.topForm.submit();
}

function SubmitModule(frm){	
		if(document.getElementById("prv_msg_div")!=null){
			document.getElementById("prv_msg_div").style.display = 'block';
			document.getElementById("preview_div").style.display = 'none';
		}

		document.topForm.submit();
	}	

</script>
<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_mod'])) {echo $_SESSION['mess_mod']; unset($_SESSION['mess_mod']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0  >
	
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
        </table>

<div id="ListingRecords">

<? if($_GET['mod']>0){ ?>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
        <td align="right" ><a href="editHead.php?mod=<?=$_GET['mod']?>"  class="add">Add <?=$ModuleName?></a></td>
 </tr>
</table>
 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td width="30%"  class="head1" >Header Name</td>
      <td width="10%"  class="head1" >Sequence</td>
      <td width="10%"  class="head1" align="center">Status</td>
      
      <td width="10%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryAtt) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryAtt as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	<td ><?=$values["head_value"]?></td>
	<td ><?=$values["sequence"]?></td>
	<td align="center"><? 
	if($values['Status'] ==1){
	$status = 'Active';
	}else{
	$status = 'Inactive';
	}
	//By Chetan 17Aug//
	echo '<a href="editHead.php?active_id='.$values["head_id"].'&curP='.$_GET["curP"].'&mod='.$_GET["mod"].'" class="'.$status.'">'.$status.'</a>';
	//End//
	?></td>
      <td  align="center">

<? if($values["edittable"]==1){?>
<a href="editHead.php?edit=<?php echo $values['head_id'];?>&amp;curP=<?php echo $_GET['curP'];?>&mod=<?=$_GET['mod']?>" ><?=$edit?></a>
 
<a href="editHead.php?del_id=<?php echo $values['head_id'];?>&amp;curP=<?php echo $_GET['curP'];?>&mod=<?=$_GET['mod']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
<? }?> </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="4" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
<tr >  <td  colspan="4" >Total Record(s) : &nbsp;<?php echo $num;?>  </td>
  </tr>
  </table>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>

<? } ?>

</div>	
</td>
</tr>
</table>
