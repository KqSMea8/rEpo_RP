<script language="javascript">


$(function() {
	$('.edu_doc').tooltip({
		position: {
			 at: "left bottom-10"
		},
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
});

</script>
<?
$arryDocument = $objCommon->GetNewsDoc($newsID,'News');
?>
<br>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="borderall">
	<tr>
		 <td align="left"   class="head"> Documents
		 <? if($_GET['view']<=0){?><a class="fancybox" style="float:right" href="#doc_uploader_div">Upload Document</a><?}?>
		 
		 </td>
	</tr>	
<?
if(sizeof($arryDocument)>0){
  	
?>
	<tr>
      <td valign="top" class="list-Image">
		<?
	echo '<ul>';
        
	foreach($arryDocument as $key=>$values){        
	   
		if($values['Document'] !='' && IsFileExist($Config['NewsDir'], $values['Document']) ){ ?>
		<li>
			<? if($_GET['view']<=0){?><a href="<?=$ActionUrl?>&del_doc=<?=$values['DocID']?>" style="float:right" onclick="return confirmDialog(this, 'Document')"  ><?=$delete?></a><?}?>
			
			<br><?=stripslashes($values['DocumentTitle'])?><br>
			<a href="../download.php?file=<?=$values['Document']?>&folder=<?=$Config['NewsDir']?>" class="download" >Download</a>


		</li>
	<?	} 
	 		
	}	
	echo '</ul>';
	
	?>
	  
	  
	  </td>
    </tr>

<? }else{ ?>
	<tr align="center" >
      <td class="no_record"><?=NO_DOCUMENT_UPLOADED?> </td>
    </tr>
 <? } ?>
</table>	
