<?php require_once("includes/settings.php");
	  require_once("../classes/employee.class.php");
	  
	$objEmployee=new employee();
	
	if ($_REQUEST['edit'] && !empty($_REQUEST['edit'])) {
		$arryEmployee = $objEmployee->GetEmployeeDetail($_REQUEST['edit']);
	}
	$objAdmin = new admin();
?>
<HTML>
<HEAD>
<TITLE><?=$Config['SiteName']?> :: Employee Details</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="<?=$Config['AdminCSS']?>" rel="stylesheet" type="text/css">
</HEAD>
<BODY style="background-image:none">
	

	
	
<table width="520"  border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
     <form name="form1" action=""  method="post" >
	 
	 <tr>
	   <td colspan="2"  >
	   
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left"  width="70%" class="had">Employee Details</td>
    <td align="right" > <input name="button2" type="button" class="button" value="Close"  onClick="window.close();"></td>
  </tr>
</table>

	   
       </td>
   	   </tr>

  
	
	   </tr>
	   <? if(count($arryEmployee)>0){?>
	 <tr>
       		 <td colspan="2" align="left"   class="head1">Account Details</td>
        </tr>
	
	
	  <tr>
        <td  align="right"  width="46%" class="blackbold">Email : </td>
        <td  height="30" align="left" ><a href="mailto:<?=$arryEmployee[0]['Email']?>"><?=$arryEmployee[0]['Email']?></a></td>
      </tr>
	  
	  
	  
       <? if($arryEmployee[0]['JoiningDate'] > 0){?>
      <tr>
        <td align="right"   class="blackbold">Joining Date : </td>
        <td height="30" align="left" ><? echo date("j F, Y", strtotime($arryEmployee[0]['JoiningDate'])) ?></td>
      </tr>
      <? } ?>
      <? if($arryEmployee[0]['ExpiryDate'] > 0){?>
     <!-- <tr>
        <td align="right"   class="blackbold">Expiry Date : </td>
        <td height="30" align="left" ><? echo date("j F, Y", strtotime($arryEmployee[0]['ExpiryDate'])) ?></td>
      </tr> -->
      <? } ?>
	  
	  
      <tr <? if(empty($_GET['edit'])) echo 'Style="display:none"'?>>
        <td  align="right"   class="blackbold" 
		>Status : </td>
        <td  height="30" align="left"  >
          <? 
		  	
			
				 if($arryEmployee[0]['Status'] == 1) echo 'Active';
				 else echo 'InActive';
			
		  ?>         </td>
      </tr>
	
	  <tr>
       		 <td colspan="2" align="left"   class="head1">Contact Details</td>
        </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold"> First Name : </td>
        <td  height="30" align="left" ><?=stripslashes($arryEmployee[0]['FirstName'])?></td>
      </tr>
	    <tr>
        <td  align="right"   class="blackbold"> Last Name : </td>
        <td  height="30" align="left" ><?=stripslashes($arryEmployee[0]['LastName'])?></td>
      </tr>
	  <? if(!empty($arryEmployee[0]['AlternateEmail'])){ ?>
	     <tr>
        <td align="right"   class="blackbold" valign="top">Alternate Email : </td>
        <td height="30" align="left" ><?=stripslashes($arryEmployee[0]['AlternateEmail'])?>
		
			</td>
      </tr>
	  <? } ?>
	  
	  <? if(!empty($arryEmployee[0]['Address'])){ ?>
	   <tr>
        <td align="right"   class="blackbold" valign="top">Contact Address : </td>
        <td height="30" align="left"  valign="top"><?=nl2br(stripslashes($arryEmployee[0]['Address']))?></td>
      </tr>	
	  <? } ?>
      <tr  <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country : </td>
        <td  height="30" align="left" ><?=$arryEmployee[0]['Country']?></td>
      </tr>
	  
	   <? if(!empty($arryEmployee[0]['State'])){ ?>
      <tr>
        <td  align="right"  class="blackbold"> State : </td>
        <td  align="left" id="state_td" ><?=$arryEmployee[0]['State']?></td>
      </tr>
	  <? }else{ ?>
      <tr>
        <td  align="right"  class="blackbold">Other State : </td>
        <td  align="left" id="state_td" ><?=$arryEmployee[0]['OtherState']?></td>
      </tr>
	  <? } ?>
	  
	   <? if(!empty($arryEmployee[0]['City'])){ ?>
      <tr>
        <td  align="right"   class="blackbold"> City : </td>
        <td  height="30" id="city_td" align="left" ><?=$arryEmployee[0]['City']?></td>
      </tr>
	  <? }else{ ?>
      <tr>
        <td  align="right"   class="blackbold"> Other City : </td>
        <td  height="30" id="city_td" align="left" ><?=$arryEmployee[0]['OtherCity']?></td>
      </tr>
	  <? } ?>
          <? if(!empty($arryEmployee[0]['Phone'])){ ?>  
 <tr>
        <td  align="right"   class="blackbold">Mobile : </td>
        <td  height="30" align="left" ><?=$arryEmployee[0]['Phone']?></td>
      </tr>
 <? } ?>


    
	   <? if(!empty($arryEmployee[0]['LandlineNumber'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline : </td>
        <td  height="30" align="left" ><?=$arryEmployee[0]['LandlineNumber']?></td>
      </tr>
	  <? } ?>
	  
	
	<tr>
       		 <td colspan="2" align="left"   class="head1">Professional Details</td>
        </tr>		
  
  <tr>
        <td align="right"   class="blackbold" >
		Total Experience :</td>
        <td height="30" align="left" >
		
	<?=$arryEmployee[0]['ExperienceYear']?> Year(s) &nbsp;&nbsp; 	
		
	<?=$arryEmployee[0]['ExperienceMonth']?> Month(s)	
		
		</td>
	  </tr>	
	  
	 <tr>
        <td align="right"   class="blackbold" >
		Current Annual Salary :</td>
        <td height="30" align="left" >
		
	<?=$arryEmployee[0]['SalaryLac']?> Lac(s) &nbsp;&nbsp; 	
		
	<?=$arryEmployee[0]['SalaryThousand']?> Thousand(s)
		
		</td>
	  </tr>	  
	  
	   
	   <tr>
        <td align="right"   class="blackbold" >
		Functional Area :</td>
        <td height="30" align="left" >
	<?=stripslashes($arryEmployee[0]['FunctionalArea'])?>
		
		</td>
      </tr>
	  
  <tr>
        <td align="right"   class="blackbold" valign="top">
		Key Skills :</td>
    <td height="30" align="left" valign="top" >
	
	 <?=stripslashes($arryEmployee[0]['Skill'])?>
	
	</td>
  </tr>	  
	 
	
	<tr>
       		 <td colspan="2" align="left"   class="head1">Education Details</td>
        </tr>	
	
	
	  
	 <tr>
          <td align="right"   class="blackbold" > Graduation :</td>
          <td height="30" align="left" >
		<?=($arryEmployee[0]['Graduation']=='Other')?(stripslashes($arryEmployee[0]['OtherGraduation'])):($arryEmployee[0]['Graduation'])?>
		  
		  </td>
  </tr>  
	  
	 <tr>
          <td align="right"   class="blackbold" >Post Graduation :</td>
          <td height="30" align="left" >
		  
		<?=($arryEmployee[0]['PostGraduation']=='Other')?(stripslashes($arryEmployee[0]['OtherPostGraduation'])):($arryEmployee[0]['PostGraduation'])?>
		  
		  </td>
  </tr>  
	  
	
	
	    	
     <tr>
       <td height="30" align="right"    class="blackbold"> Doctorate/Phd : </td>
       <td  align="left" >
			<?=($arryEmployee[0]['Doctorate']=='Other')?(stripslashes($arryEmployee[0]['OtherDoctorate'])):($arryEmployee[0]['Doctorate'])?>

		
	   </td>
     </tr>
	<tr>
        <td align="right"   class="blackbold" valign="top">
		Certification Course :</td>
    <td height="30" align="left" valign="top" >
	
	 <?=stripslashes($arryEmployee[0]['Certification'])?>
	
	</td>
  </tr>	 
	 
	 
<tr>
       		 <td colspan="2" align="left"   class="head1">Manage Resume</td>
        </tr>	
	
	 <tr>
        <td align="right"   class="blackbold" >
		Resume Title  : </td>
       <td height="30" align="left" >
	<?=stripslashes($arryEmployee[0]['ResumeTitle'])?>
	   
	   </td>
  </tr>
  
   <tr>
        <td align="right"   class="blackbold" valign="top" >
		Resume : </td>
       <td align="left" >
	<?=stripslashes($arryEmployee[0]['ResumeContent'])?>
	   
	   </td>
  </tr>		
	 <tr>
    <td height="30" align="right" valign="top"   class="blackbold">  Resume Attached : </td>
    <td  align="left" valign="top" class="blacknormal">
	
	<? if($arryEmployee[0]['Resume'] !='' && file_exists('../upload/resume/'.$arryEmployee[0]['Resume']) ){ ?>
	<a href="../upload/resume/<?=$arryEmployee[0]['Resume']?>" target="_blank"  title="<?=stripslashes($arryEmployee[0]['ResumeTitle'])?>"><?=stripslashes($arryEmployee[0]['ResumeTitle'])?></a>
<?	} ?>
	

	
		
	
	</td>
  </tr>
			  
			   
		
 <? }else{?>
  <tr>
    <td height="250" align="center" colspan=2><div class="message"><? echo $MSG[66];?></div></td>
  </tr>
   <? }?>
 
</form>
</table>
</body>
</html>
