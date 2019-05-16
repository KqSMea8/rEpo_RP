<? if(empty($ErrorExist)){ ?>
	<div class="had" style="margin-bottom:5px;">Benefit: <?=stripslashes($arryBenefit[0]['Heading'])?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
 <tr>
        <td  align="left" valign="top" height="200">
	    
	<div><?=stripslashes($arryBenefit[0]['Detail'])?></div>
	
		</td>
      </tr>

 <tr>
        <td  align="left" valign="top">
	    
<? 
$MainDir = $Config['FileUploadDir'].$Config['BenefitDir'];

if($arryBenefit[0]['Document'] !='' && IsFileExist($Config['BenefitDir'],$arryBenefit[0]['Document'])){ 
 

?>
			
	<div  id="DocumentDiv">
<a href="../download.php?file=<?=$arryBenefit[0]['Document']?>&folder=<?=$Config['BenefitDir']?>" class="download">Download</a>	
	
		</div>
<?	} ?>
	
	
		</td>
      </tr>


</table>
<? }else
{ 
	echo '<div class="redmsg" align="center">'.$ErrorExist.'</div>';	
} ?>


