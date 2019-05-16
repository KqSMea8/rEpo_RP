	
	<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
	<tr>
		 <td colspan="2" align="left" class="head"><?=CUSTOMER_BILLING_ADDRESS?></td>
	</tr>
	
       <tr style="display:none">
			<td  align="right"   class="blackbold" > Billing Name  :</td>
			<td   align="left" >
	            <?php echo stripslashes($arrySale[0]['BillingName']); ?>   </td>
		  </tr>	
	<tr>
			<td  align="right"   class="blackbold" width="40%"> Company Name  : </td>
			<td   align="left" >
	         <?php echo stripslashes($arrySale[0]['CustomerCompany']); ?>
		</td>
	</tr>


		
		<tr>
			<td  align="right"   class="blackbold" valign="top" > Address :</td>
			<td   align="left" >
	        <?=stripslashes($arrySale[0]['Address'])?>
		</td>
	 </tr>
	 

	<tr>
			<td  align="right"   class="blackbold" > City  : </td>
			<td   align="left" >
         	<?php echo stripslashes($arrySale[0]['City']); ?>
		</td>
		 </tr>

	<tr>
		   <td  align="right"   class="blackbold" > State  : </td>
			<td   align="left" >
	        <?php echo stripslashes($arrySale[0]['State']); ?>
		</td>
	 </tr>


	<tr>
			<td  align="right"   class="blackbold" > Country  : </td>
			<td   align="left" >
	         <?php echo stripslashes($arrySale[0]['Country']); ?>
		</td>
		 </tr>

	<tr>
			<td  align="right"   class="blackbold" > Zip Code  : </td>
			<td   align="left" >
	              <?php echo stripslashes($arrySale[0]['ZipCode']); ?>
		</td>
		  </tr>
	

	

 <tr>
			<td align="right"   class="blackbold" >Mobile  :</td>
			<td  align="left"  >
		<?=stripslashes($arrySale[0]['Mobile'])?>
		 
		 </td>
		  </tr>

	<tr>
			<td  align="right"   class="blackbold">Landline  :</td>
			<td   align="left" >
			<?=stripslashes($arrySale[0]['Landline'])?>

				</td>
	 </tr>

	   <tr>
			<td align="right"   class="blackbold">Fax  : </td>
			<td  align="left" ><?=stripslashes($arrySale[0]['Fax'])?> </td>
		  </tr>

	    <tr>
			<td align="right"   class="blackbold">Email  :</td>
			<td  align="left" ><?=stripslashes($arrySale[0]['Email'])?></td>
		  </tr>

	
		</table>
