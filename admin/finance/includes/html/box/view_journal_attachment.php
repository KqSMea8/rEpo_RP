<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">



   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
    <td  align="center" valign="top" colspan="2">
   <table <?=$table_bg?> >
   
    <tr align="left">
      <td width="20%"  class="head1">File Name</td>
	<td width="28%"  class="head1" >Download</td>
      <td    class="head1">Note</td>
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
      <td align="left">

<?  if(IsFileExist($Config['JournalDir'], $values['AttachmentFile']) ){ ?>
	<a href="../download.php?file=<?=$values['AttachmentFile']?>&folder=<?=$Config['JournalDir']?>" class="download">Download</a>
	<? }	?>
</td>
      <td align="left"><?=stripslashes($values['AttachmentNote']);?></td>
     
    </tr>
 <?php }?>
   <?php }else{?>
    <tr align="center" >
      <td  colspan="3" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>		


</table>	
  </td>
 </tr>


</table>

