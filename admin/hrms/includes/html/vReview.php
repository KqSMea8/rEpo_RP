
<a href="<?=$RedirectURL?>" class="back">Back</a>

<a href="<?=$EditURL?>" class="edit">Edit</a>
<input type="button" class="print_button" style="float:right"  name="exp" value="Print" onclick="Javascript:window.print();"/>


<div class="had">
Manage Review   <span> &raquo;
	<? 	echo (!empty($_GET['view']))?($ModuleName." Detail") :(""); ?>
		
		</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">

 <tr>
	<td width="45%" align="right"    class="blackbold">
	Employee :
	</td>
	<td  align="left" >
<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryReview[0]['EmpID']?>" ><?=stripslashes($arryReview[0]['UserName'])?></a>   [<?=stripslashes($arryReview[0]['Department'])?>]   

	</td>
 </tr>	
 <tr>
	<td  align="right"    class="blackbold">
	Job Title : 
	</td>
	<td  align="left" >
	<?=stripslashes($arryReview[0]['JobTitle'])?>
	</td>
 </tr>	
 <tr>
	<td  align="right"  class="blackbold">
	Category : 
	</td>
	<td  align="left" >
	<?=(!empty($arryReview[0]['catName']))?(stripslashes($arryReview[0]['catName'])):(NOT_SPECIFIED)?>
	</td>
 </tr>

  <tr>
	<td  align="right"    class="blackbold">
	Review From : 
	</td>
	<td  align="left" >
	<? if($arryReview[0]["FromDate"]>0) echo date($Config['DateFormat'], strtotime($arryReview[0]["FromDate"])); ?>
	</td>
 </tr>	
<tr>
	<td  align="right"    class="blackbold">
	Review To : 
	</td>
	<td  align="left" >
	<? if($arryReview[0]["ToDate"]>0) echo date($Config['DateFormat'], strtotime($arryReview[0]["ToDate"])); ?>
	</td>
 </tr>	
 <tr>
	<td  align="right"    class="blackbold">
	Reviewer :
	</td>
	<td  align="left" >
	<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryReview[0]['ReviewerID']?>" ><?=stripslashes($arryReview[0]['ReviewerName'])?></a>   

	</td>
 </tr>	
<? 	 if($arryReview[0]['Status'] != "Scheduled") $stClass = 'green';
	 else $stClass = '';
?>
 <tr>
	<td  align="right"    class="blackbold">
	Status : 
	</td>
	<td  align="left" class="<?=$stClass?>" >
	<?=stripslashes($arryReview[0]['Status'])?>
	</td>
 </tr>

<? if($numKra>0){ ?>
 <tr>
	<td  align="right"    class="blackbold">
	KRA : 
	</td>
	<td  align="left" >
	<B><?=stripslashes($arryKra[0]['heading'])?></B>

	</td>
 </tr>	
 
 <tr>
	<td  align="right"    class="blackbold">
 	Minimum Rating :
	</td>
	<td  align="left" >
	<?=$arryKra[0]['MinRating']?>
	 <input name="MinRating" type="hidden" id="MinRating" value="<?=$arryKra[0]['MinRating']?>"  />		
	</td>
 </tr>

<tr>
	<td  align="right"    class="blackbold">
	Maximum Rating : 
	</td>
	<td  align="left" >
	<?=$arryKra[0]['MaxRating']?>
	 <input name="MaxRating" type="hidden" id="MaxRating" value="<?=$arryKra[0]['MaxRating']?>"  />		
	</td>
 </tr>	

 </table>
 <br>
<table width="100%" border="0" cellpadding="5" cellspacing="0"  class="borderall">

 <? 
if($catID>0){

 $TotalKraWeightage = 0; $TotalWeightage = 0;
 foreach($arryComponent as $key=>$values){ 
 		
 
		$compID = $values['compID'];
		$Rating = $arryReview[0]['Rating'.$compID];
		if(empty($Rating)) $Rating=0;
		
		$KraWeightage = $arryWeightage[0]['Weightage'.$compID];
			
			
		$Percentage = (100*($Rating - $arryKra[0]['MinRating']))/($arryKra[0]['MaxRating']-$arryKra[0]['MinRating']);
		$Weightage = ($Percentage * $KraWeightage) /100;

		if($Weightage<=0) $Weightage=0;
		
	?>	
	<tr>
	  <td  align="left" colspan="2" class="head"><?=stripslashes($values['heading'])?> </td>
	</tr>
			
	<tr>
	  <td  class="blackbold"  align="right" >Rating : </td>
	  <td  align="left" >
		<?=$Rating?> 
	   </td>
	</tr>
	<tr>
	  <td  class="blackbold"  align="right" >KRA Weightage : </td>
	  <td  align="left" >
		<?=$KraWeightage?> %  
	   </td>
	</tr>
	<tr>
	  <td  class="blackbold"  align="right" >Weightage Achieved : </td>
	  <td  align="left" >
		<strong><?=round($Weightage)?> %  </strong>
	   </td>
	</tr>
	
<? 
	$TotalKraWeightage += $KraWeightage;
	$TotalWeightage += $Weightage;
} ?>	
<tr>
	  <td  align="left" colspan="2" class="head">Total  Weightage </td>
	</tr>
	<tr>
	  <td  class="blackbold"  align="right" >Total KRA Weightage : </td>
	  <td  align="left" >
		<?=$TotalKraWeightage?> %  
	   </td>
	</tr>
	<tr>
	  <td  class="blackbold"  align="right" >Total Weightage Achieved : </td>
	  <td  align="left" >
		<strong><?=round($TotalWeightage)?> %  </strong>
	   </td>
	</tr>
	
	
 <tr>
	  <td  align="left" colspan="2" class="head">Comments  </td>
	</tr> 
	<tr>
	<td  align="right"   valign="top" class="blackbold" width="45%">
	Comments : 
	</td>
	<td  align="left"  >
<?=(!empty($arryReview[0]['Comment']))?(nl2br(stripslashes($arryReview[0]['Comment']))):(NOT_SPECIFIED)?>

	</td>
 </tr>

<? 
	}else{ 
		$HideSubmit = 1; ?>
		
	 <tr>
	  <td  align="center" colspan="2" class="redmsg"><?=NO_CAT_FOR_EMPLOYEE?> </td>
	</tr>	


<? 
	}

}else{ 
		
		?>

<tr>
	<td  align="right"    class="blackbold">
	KRA : 
	</td>
	<td  align="left"class="redmsg" >
	<?=NO_KRA_FOR_JOB_TITLE?>
	</td>
 </tr>

<? } ?>





                  
                  </table></td>
                </tr>

	


				
              </form>
          </table>