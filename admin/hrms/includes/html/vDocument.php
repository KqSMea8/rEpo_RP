	<div class="had" style="margin-bottom:5px;">Document Title : <?=stripslashes($arryDocument[0]['heading'])?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
 <tr>
        <td  align="left" valign="top" height="300">
		
	<? 
	  $document = stripslashes($arryDocument[0]['document']);
           
	if(IsFileExist($Config['H_DocumentDir'],$document) ){  ?>	

	 <div style="float:right; padding:5px;">
		<a href="../download.php?file=<?=$document?>&folder=<?=$Config['H_DocumentDir']?>" class="download">Download</a> 
	 </div>
	  <? } ?>


	<div><?=nl2br(stripslashes($arryDocument[0]['detail']))?></div>
		
		
		</td>
      </tr>
</table>
