<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">



   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

	
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>	
       <tr>
		<td  align="right" width="45%" valign="top" class="blackbold">Select File  :</td>
		<td   align="left" >
		  <input type="file" name="AttachmentFile" id="AttachmentFile" value="">
                  <br><?=SUPPORTED_ATTACHMENT?>
		</td>
	</tr>	

	<tr>
		<td  align="right" valign="top"  class="blackbold"> Note  : </td>
		<td  align="left">
		 <textarea id="AttachmentNote" class="textarea" type="text" name="AttachmentNote"></textarea>
		</td>
	</tr>	
	
	 
	

<tr>
    <td  align="center" valign="top" colspan="2">
   <table <?=$table_bg?> >
   
    <tr align="left">
      <td width="12%"  class="head1">File Name</td>
      <td width="8%"  class="head1" align="center">Download</td>
      <td width="30%"  class="head1">Note</td>
      <td width="5%"   align="center" class="head1">Action</td>
    </tr>
   <?php 
 if(is_array($arryJournalAttachment) && $num>0){

		$flag=true;
		$Line=0;

foreach($arryJournalAttachment as $values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	?>
      <tr align="left" bgcolor="<?=$bgcolor?>">
            <td align="left"><?=$values['AttachmentFile'];?></td>
      <td align="center">

  <?  if(IsFileExist($Config['JournalDir'], $values['AttachmentFile']) ){ ?>
	<a href="../download.php?file=<?=$values['AttachmentFile']?>&folder=<?=$Config['JournalDir']?>" class="download">Download</a>
	<? }	?>
</td>
      <td align="left"><?=stripslashes($values['AttachmentNote']);?></td>
      <td align="center"><a href="editGeneralJournal.php?edit=<?=$_GET['edit'];?>&del_attach_id=<?php echo $values['AttachmentID']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('Attachment')" class="Blue" ><?= $delete ?></a></td>
    </tr>
 <?php }?>
   <?php }else{?>
    <tr align="center" >
      <td  colspan="4" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>		


</table>	
  </td>
 </tr>


</table>

