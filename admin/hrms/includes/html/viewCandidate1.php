<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>
<div class="had"><?=$module?> Candidates</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_candidate'])) {echo $_SESSION['mess_candidate']; unset($_SESSION['mess_candidate']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	
	
	<tr>
        <td align="right" >
		
		 	<? if($num>0){?>
	<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_cand.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	  <? } ?>
		
		
		
		<? if($module=="Manage"){?>
		<a href="<?=$AddUrl?>" class="add">Add Candidate</a>
		<? }?>
		
		<? if($_GET['key']!='') {?>
		  <a href="<?=$ViewUrl?>" class="grey_bt">View All</a>
		<? }?>
		
		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	 
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CanID','<?=sizeof($arryCandidate)?>');" /></td>-->
      <td width="15%"  class="head1" >Candidate Name</td>
      <td  class="head1" >Email</td>
      <td width="20%" class="head1" >Contact Number</td>
      <td width="15%" class="head1" >Vacancy</td>
     <td width="10%" class="head1" >Image</td>
      <td width="15%"  align="center" class="head1" >Interview Status</td>
      <td width="6%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryCandidate) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCandidate as $key=>$values){
	$flag=!$flag;
	$Line++;
	
	if($values['InterviewStatus'] == "Passed") $stClass = 'green';
	else $stClass = '';
	
  ?>
    <tr align="left"  >
      <!--<td ><input type="checkbox" name="CanID[]" id="CanID<?=$Line?>" value="<?=$values['CanID']?>" /></td>-->
      <td><?=stripslashes($values["UserName"])?></td>
		  
		 
      <td><?  echo '<a href="mailto:'.$values['Email'].'">'.$values['Email'].'</a>'; ?></td>

      <td><?=stripslashes($values["Mobile"])?></td>
      <td><?=stripslashes($values["Vacancy"])?></td>
	  
	  <td>
	  
<? if($values['Image'] !='' && file_exists('upload/candidate/'.$values['Image']) ){ ?>

<a href="upload/candidate/<?=$values['Image']?>" class="fancybox" data-fancybox-group="gallery"  title="<?=$values['UserName']?>" alt="<?=$values['UserName']?>"><? echo '<img src="resizeimage.php?w=70&h=70&img=upload/candidate/'.$values['Image'].'" border=0 >';?></a>
<?	} ?>	  </td>
    <td align="center" class="<?=$stClass?>">

	
	<?  echo $values['InterviewStatus'];
		if($values['InterviewStatus']=="Passed"){
			echo '<br><a href="'.$EditUrl.'&shortlist='.$values['CanID'].'" class="action_bt" onclick="return confAction(\''.$ModuleName.'\',\'Shortlist\');">Shortlist</a>';
		}
	?>
	
	</td>
      <td  align="center"  class="head1_inner" >
	  <a href="<?=$ViewUrl.'&view='.$values['CanID']?>" ><?=$view?></a>
	  
	<? if($module=="Manage"){?>  
	<a href="<?=$EditUrl.'&edit='.$values['CanID']?>" ><?=$edit?></a>
	  
	<a href="<?=$EditUrl.'&del_id='.$values['CanID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> 
	<? } ?>
	  </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_CANDIDATE?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7" id="td_pager" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCandidate)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryCandidate)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','CanID','editCandidate.php?curP=<?=$_GET[curP]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','CanID','editCandidate.php?curP=<?=$_GET[curP]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','CanID','editCandidate.php?curP=<?=$_GET[curP]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   
</form>
</td>
	</tr>
</table>


<!--
<div id="dialog-confirm" title="Empty the recycle bin?">
<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
<a href="viewCandidate.php" id="link_id" >dddddd</a>

 <script>

$('#link_id').click(function() {
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		height:140,
		modal: true,
		buttons: {
		"Ok": function() {
			$( this ).dialog( "close" );
			return true;
		},
		Cancel: function() {
			$( this ).dialog( "close" );
			return false;
		}
	}
	});
});

</script>-->