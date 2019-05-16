

  

<tr>
	 <td  align="left" class="head">Lead Details</td>
	 <td class="head" align="right"><a class="fancybox" href="#Convert_div" ><b>Convert Lead</b></a>&nbsp&nbsp&nbsp&nbsp <a class="fancybox" href="editLead.php?edit=<?=$_GET['edit']?>&curP=1&module=<?=$_GET['module']?>&tab=Edit" ><b>Edit <?=$_GET['module']?></b></a></td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> First Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryLeadDetail[0]['FirstName']); ?>           </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  :</td>
        <td   align="left" >
<?php echo stripslashes($arryLeadDetail[0]['LastName']); ?>           </td>
      </tr>
	   <tr>
        <td  align="right"   class="blackbold"> Company  : </td>
        <td   align="left" >
<?php echo stripslashes($arryLeadDetail[0]['company']); ?>           </td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold"> Primary Email : </td>
        <td   align="left" >
<?php echo stripslashes($arryLeadDetail[0]['primary_email']); ?>            </td>
      </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold"> Website : </td>
        <td   align="left" >
<?php echo stripslashes($arryLeadDetail[0]['Website']); ?>            </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Designation : </td>
        <td   align="left" >
<?php echo stripslashes($arryLeadDetail[0]['designation']); ?>           </td>
      </tr>
	  
	 <!--  <tr>
        <td  align="right"   > Date of Birth : <span class="red">*</span> </td>
        <td   align="left" >
		
<script type="text/javascript">
$(function() {
	$('#date_of_birth').datepick(
		{
		dateFormat: 'yyyy-mm-dd', 
		yearRange: '1950:<?=date("Y")?>', 
		defaultDate: '<?=$arryLeadDetail[0]['date_of_birth']?>'
		}
	);
});
</script>
<input id="date_of_birth" name="date_of_birth" readonly="" class="disabled" size="10" value="<?=$arryLeadDetail[0]['date_of_birth']?>"  type="text" >         </td>
      </tr> -->

  <tr>
        <td  align="right"   class="blackbold"> Industry  : </td>
        <td   align="left" >
		<?php echo stripslashes($arryLeadDetail[0]['Industry']); ?>
            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Annual Revenue : </td>
        <td   align="left" ><?php echo stripslashes($arryLeadDetail[0]['AnnualRevenue']); ?>
            </td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold"> Lead Source  : </td>
        <td   align="left" >
		<?=stripslashes($arryLeadDetail[0]['lead_source'])?>
           </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">  Assigned To  : </td>
        <td   align="left" ><?=stripslashes($arryLeadDetail[0]['AssignTo'])?>
		 </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Lead Status  : </td>
        <td   align="left" >
		
           <?=stripslashes($arryLeadDetail[0]['lead_status'])?> </td>
      </tr>
	  
 <tr>



	
	<tr>
       		 <td colspan="2" align="left"   class="head">Address Details</td>
        </tr>
   
	  
	  
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Street Address  :</td>
          <td  align="left" >
            <?=stripslashes($arryLeadDetail[0]['Address'])?>		          </td>
        </tr>
         
	<tr>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		<?=$CountryName?>      </td>
      </tr>
     <tr>
	  <td  align="right" valign="middle"   class="blackbold"> State  :</td>
	  <td  align="left"  class="blacknormal"><?=$StateName?> </td>
	</tr>
	    
     
	   <tr>
        <td  align="right"   class="blackbold"> City   :</td>
        <td  align="left"  ><?=$CityName?> </td>
      </tr> 
	    
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	 <?=stripslashes($arryLeadDetail[0]['ZipCode'])?>			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	<?=stripslashes($arryLeadDetail[0]['Mobile'])?>			</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
		<?
		if(!empty($arryLeadDetail[0]['LandlineNumber'])){
			$LandArray = explode(" ",$arryLeadDetail[0]['LandlineNumber']);
	    }
		?>
		<? echo $arryLeadDetail[0]['LandlineNumber'];?>	</td>
      </tr>







	<tr>
       		 <td colspan="2" align="left"   class="head">Description Details</td>
        </tr>	
	
	
	  
	 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" >
           <? echo stripslashes($arryLeadDetail[0]['description']); ?>         </td>
        </tr>
 
