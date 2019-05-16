<a href="<?=$RedirectURL?>"  class="back">Back</a>

<? if($module=="Manage"){?>
<a href="<?=$EditUrl?>"  class="edit">Edit</a>
<? } ?>


<div class="had">
<?=$MainModuleName?>   <span> &raquo; View <?=$ModuleName?>

		
		</span>
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">





<div class="right_box">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="left"   class="head" colspan="2">Candidate Detail</td>
      
      </tr>
<tr>
        <td  align="right"   class="blackbold"> Job Vacancy  : </td>
        <td   align="left" >

	  <a class="fancybox fancybox.iframe" href="vacancyInfo.php?view=<?=$arryCandidate[0]['Vacancy']?>" ><?=stripslashes($arryCandidate[0]['VacancyName'])?> [<?=stripslashes($arryCandidate[0]['DepartmentName'])?>]</a>

	


		</td>
      </tr>	
  <tr>
	     <td  align="right"  class="blackbold" >Gender : </td>
	     <td   align="left" >
			<?=$arryCandidate[0]['Gender']?>
		</td>
	     </tr>

<tr>
        <td  align="right"   class="blackbold"> First Name  : </td>
        <td   align="left" >
		<?php echo stripslashes($arryCandidate[0]['FirstName']); ?>
		</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryCandidate[0]['LastName']); ?>         </td>
      </tr>
	 
	   <tr>
        <td  align="right"   > Date of Birth :  </td>
        <td   align="left" >
		<? if($arryCandidate[0]['date_of_birth']>0) echo date($Config['DateFormat'], strtotime($arryCandidate[0]['date_of_birth'])); ?>
        </td>
      </tr> 

	  
 <tr>
        <td  align="right"   class="blackbold" width="45%"> Email : </td>
        <td   align="left" ><?php echo $arryCandidate[0]['Email']; ?>
		</td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Contact Number  :</td>
        <td  align="left"  ><?=stripslashes($arryCandidate[0]['Mobile'])?>
		</td>
      </tr>	

        <tr>
          <td align="right"   class="blackbold" valign="top">Address  :</td>
          <td  align="left" >
            <?=nl2br(stripslashes($arryCandidate[0]['Address']))?>	          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
	<?=(!empty($CountryName))?($CountryName):(NOT_SPECIFIED)?>

		     </td>
      </tr>

<? if(!empty($StateName)){ ?>
     <tr>
	  <td  align="right" class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal">
	<?=$StateName?>
	  
	  </td>
	</tr>
<? } ?>
	  
     
	   <tr>
        <td  align="right" class="blackbold"> City   :</td>
        <td  align="left" >	<?=(!empty($CityName))?($CityName):(NOT_SPECIFIED)?>
</td>
      </tr> 
	     
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
<?=stripslashes($arryCandidate[0]['ZipCode'])?>
</td>
      </tr>
	  
       	



<tr>
    <td height="30" align="right"    class="blackbold" >  Resume   :</td>
    <td  align="left"  >	
	<?	 
        if(IsFileExist($Config['CandResumeDir'],$arryCandidate[0]['Resume'])){  ?>
	<?=stripslashes($arryCandidate[0]['Resume'])?>&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryCandidate[0]['Resume']?>&folder=<?=$Config['CandResumeDir']?>" title="<?=$arryCandidate[0]['Resume']?>" class="download">Download</a>
	
<?	}else{ echo NOT_UPLOADED;}?>		
	
	</td>
  </tr>



<tr>
        <td align="right"   class="blackbold">Apply Date  :</td>
        <td  align="left" >	
		
		<? if($arryCandidate[0]['ApplyDate']>0) echo date($Config['DateFormat'], strtotime($arryCandidate[0]['ApplyDate'])); ?>
		</td>
      </tr>  
	  
	
	
<tr>
        <td align="right"   class="blackbold" >
		Total Experience  :</td>
        <td height="30" align="left" >
		
<?=$arryCandidate[0]['ExperienceYear']?> Years &nbsp;&nbsp; 	
		
<?=$arryCandidate[0]['ExperienceMonth']?> Months	
		
		</td>
	  </tr>	
	  
	 <tr>
        <td align="right"   class="blackbold" >Skill  :</td>
        <td  align="left"  >
<?=(!empty($arryCandidate[0]['Skill']))?(stripslashes($arryCandidate[0]['Skill'])):(NOT_SPECIFIED)?>

		</td>
      </tr>  
	  
	  
	  <tr>
        <td align="right"   class="blackbold" >
		 Current Salary  :</td>
        <td height="30" align="left" ><?php echo stripslashes($arryCandidate[0]['Salary']); ?>&nbsp;<?=$Config['Currency']?>&nbsp;&nbsp;
		
	<?=$arryCandidate[0]['SalaryFrequency']?>
		
		
		</td>
	  </tr>	  
	
<tr>
        <td  align="left"   class="head" colspan="2">Interview Status</td>
      
      </tr>	 

	<tr>
        <td  align="right"   class="blackbold" 
		>Interview Stage  : </td>
        <td   align="left"  >
          <?=$arryCandidate[0]['InterviewStatus']?></td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold" valign="top">Test Taken  : </td>
        <td   align="left"> 
		<?
		
		if(!empty($arryCandidate[0]['TestTaken'])){
			$TestTaken = str_replace(",","<br>",stripslashes($arryCandidate[0]['TestTaken']));
			echo $TestTaken;
		}else{
			echo NOT_SPECIFIED;
		}
		
		?>

       </td>
      </tr>
<? for($i=1;$i<=3;$i++){ ?>
<tr>
        <td  align="right"   class="blackbold">Level-<?=$i?> Interview Taken By  : </td>
        <td   align="left">
<? if(!empty($arryCandidate[0]['EmpName'.$i])){ ?>
<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryCandidate[0]['EmpID'.$i]?>" ><?=stripslashes($arryCandidate[0]['EmpName'.$i])?></a>   
<? 
	   }else{
			echo NOT_SPECIFIED;
	   }
?>		  
		   </td>
      </tr>

<? } ?>







	 <? if(!empty($arryCandidate[0]['Status'])){ ?>
	<tr>
        <td  align="right"   class="blackbold" 
		>Current Status  : </td>
        <td   align="left"  >
          <strong> <?=$arryCandidate[0]['Status']?></strong> </td>
      </tr>
	   <? if($arryCandidate[0]['Status']=="Offered"){ ?>
	 <tr>
        <td  align="right"   class="blackbold" >Offered Date  : </td>
        <td   align="left"  >
          <? if($arryCandidate[0]['OfferedDate']>0) echo date($Config['DateFormat'], strtotime($arryCandidate[0]['OfferedDate'])); ?>
		   </td>
      </tr>
	   <tr>
        <td  align="right"   class="blackbold" >Offered to join on date  : </td>
        <td   align="left"  >
          <? if($arryCandidate[0]['JoiningDate']>0) echo date($Config['DateFormat'], strtotime($arryCandidate[0]['JoiningDate'])); ?>
		   </td>
      </tr>
	   <? } ?>
	  
	  <? } ?>
	
</table>	
  





</div>
	
	</td>
    </tr>
 
</table>
