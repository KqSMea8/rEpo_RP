	<div class="had" style="margin-bottom:5px;">Vacancy Name  : <?=stripslashes($arryVacancy[0]['Name'])?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="left">


<table width="100%" border="0" cellpadding="5" cellspacing="0" >

<tr>
        <td  width="45%" align="right"   class="blackbold"> Job Title  : </td>
        <td   align="left" > <?=stripslashes($arryVacancy[0]['JobTitle'])?>	</td>
      </tr>	




<tr>
        <td  align="right"   class="blackbold" valign="top"> Department  : </td>
          <td   align="left" > 
		  
	   	<?=(!empty($arryVacancy[0]['DepartmentName']))?(stripslashes($arryVacancy[0]['DepartmentName'])):(NOT_SPECIFIED)?>
		  
		  </td>
     
      </tr>

	   <tr>
        <td  align="right"  class="blackbold" valign="top">Hiring Manager  : </td>
        <td  align="left" >
	   	<?=(!empty($arryVacancy[0]['UserName']))?(stripslashes($arryVacancy[0]['UserName'])):(NOT_SPECIFIED)?>
		
		</td>
      </tr>
	 
	 <tr>
          <td align="right"  class="blackbold" valign="top">Description  :</td>
          <td  align="left" >
	   	<?=(!empty($arryVacancy[0]['Description']))?(nl2br(stripslashes($arryVacancy[0]['Description']))):(NOT_SPECIFIED)?>
		  
		  </td>
        </tr>

     <tr>
       <td align="right" class="blackbold">Qualification :</td>
       <td  align="left">

 <?
	 if($arryVacancy[0]['Qualification']=="Other"){
			$Qualification= stripslashes($arryVacancy[0]['OtherQualification']);
	 }else{
			$Qualification= stripslashes($arryVacancy[0]['Qualification']);
	 }
	 	 echo (!empty($Qualification))?(stripslashes($Qualification)):(NOT_SPECIFIED);

	 ?>	  
			



	   </td>
     </tr>
	   <tr>
       <td align="right" class="blackbold">Skill :</td>
       <td  align="left">
	   	<?=(!empty($arryVacancy[0]['Skill']))?(stripslashes($arryVacancy[0]['Skill'])):(NOT_SPECIFIED)?>
	   
	   </td>
     </tr>
     <tr>
        <td align="right" class="blackbold">Number of Position  :</td>
        <td  align="left"><?=stripslashes($arryVacancy[0]['NumPosition'])?>		</td>
      </tr>	
     <tr>
        <td align="right" class="blackbold">Hired Candidate  :</td>
        <td  align="left"><?=stripslashes($arryVacancy[0]['Hired'])?>		</td>
      </tr>	

        <tr>
          <td align="right"  class="blackbold">Experience : </td>
          <td  align="left" >
		  
	<?=$arryVacancy[0]['MinExp']?>  &nbsp;&nbsp;To&nbsp;&nbsp;	<?=$arryVacancy[0]['MaxExp']?>  
		  
	  </td>
        </tr>
        <tr>
          <td align="right"  class="blackbold">Age : </td>
          <td  align="left" >
		  
		<?=$arryVacancy[0]['MinAge']?>   &nbsp;&nbsp;To&nbsp;&nbsp;	 <?=$arryVacancy[0]['MaxAge']?> 
		  
		  </td>
        </tr>
        <tr>
         <td align="right"  class="blackbold">Salary (<?=$Config['Currency']?>) : </td>
          <td  align="left" >

	   	<? 
		if(empty($arryVacancy[0]['MinSalary']) && empty($arryVacancy[0]['MaxSalary'])){
			echo NOT_SPECIFIED;
		}else{
		
		?>

		 <?=$arryVacancy[0]['MinSalary']?>
	 &nbsp;&nbsp;To&nbsp;&nbsp;
	<?=$arryVacancy[0]['MaxSalary']?>
	
		  <?=IN_LAKH_ANNUM?>
		  <? } ?>
		  </td>
        </tr>
        
         
	<tr>
         <td align="right"  class="blackbold">Exceptional Approval : </td>
          <td  align="left" >
		<?=($arryVacancy[0]['Exceptional'] == 1)?('Yes'):('No')?>	  </td>
        </tr>
      

  <tr>
        <td  align="right"   > Posted Date :  </td>
        <td   align="left" >
		<? if($arryVacancy[0]['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($arryVacancy[0]['PostedDate']));
	   ?>

        </td>
      </tr>



<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
<?
	 if($arryVacancy[0]['Status'] == "Approved") $stClass = 'green';
	 else if($arryVacancy[0]['Status'] == "Rejected") $stClass = 'red';
	 else $stClass = '';

?>

       <div class="<?=$stClass?>"><?=$arryVacancy[0]['Status']?></div>		   </td>
      </tr>

   


</table>		
	
	
	</td>
	
  </tr>
</table>






	
	
	
	
	

  



