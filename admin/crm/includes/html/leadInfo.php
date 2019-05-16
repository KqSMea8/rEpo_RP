<div class="had">Lead Details</div>


<div class="right_box">
<table width="100%" id="table1" border="0" cellpadding="0"
	cellspacing="0">
	<form name="form1" action="" method="post">


	<tr>
		<td align="center" valign="top">


		<table width="100%" id="table4" border="0" cellpadding="5"
			cellspacing="0" class="borderall">

			<tr>

			<? if($arryLead[0]['type']!='Individual'){?>

				<td align="right" class="blackbold"><?=LEAD_COMPANY?>:</td>
				<td align="left"><?=(!empty($arryLead[0]['company']))?(stripslashes($arryLead[0]['company'])):(NOT_SPECIFIED)?>
				</td>

				<? }?>

			</tr>
			<tr>
				<td align="right" class="blackbold" width="25%"><?=LEAD_FIRST_NAME?>
				:</td>
				<td align="left" width="25%"><?=(!empty($arryLead[0]['FirstName']))?(stripslashes($arryLead[0]['FirstName'])):(NOT_SPECIFIED)?></td>

			

				<td align="right" class="blackbold" width="25%"><?=LEAD_LAST_NAME?>
				:</td>
				<td align="left"><?=(!empty($arryLead[0]['LastName']))?(stripslashes($arryLead[0]['LastName'])):(NOT_SPECIFIED)?>
				</td>
			</tr>



			<tr>


				<td align="right" class="blackbold"><?=LEAD_INDUSTRY?> :</td>
				<td align="left"><?=(!empty($arryLead[0]['Industry']))?($arryLead[0]['Industry']):(NOT_SPECIFIED)?>

				</td>
			


				<td align="right" class="blackbold">Lead Date :</td>
				<td align="left"><? if($arryLead[0]['LeadDate']>0) 
				echo date($Config['DateFormat'], strtotime($arryLead[0]['LeadDate']));
				else echo NOT_SPECIFIED;

	   ?></td>
			</tr>

			<tr>
				<td align="right" class="blackbold">Last Contact Date :</td>
				<td align="left"><? if($arryLead[0]['LastContactDate']>0) 
				echo date($Config['DateFormat'], strtotime($arryLead[0]['LastContactDate']));
				else echo NOT_SPECIFIED;

	   ?></td>
			
				<td align="right" class="blackbold"><?=LEADSTATUS?> :</td>
				<td align="left"><?=(!empty($arryLead[0]['lead_status']))?($arryLead[0]['lead_status']):(NOT_SPECIFIED)?>
				</td>

			</tr>
<tr>



				<td align="right" class="blackbold" valign="top"><?=LEAD_ASSIGN_TO?> :</td>
				<td align="left" valign="top" colspan="3"><? if (!empty($arryTicket[0]['AssignType']) && $arryTicket[0]['AssignType'] == 'Group') { ?>
				<?= $AssignName ?> <br>
				<? } ?>
				<div><? if(!empty($arryAssignee)){
						foreach ($arryAssignee as $values) {
					?> <a class="fancybox fancybox.iframe"
					href="../userInfo.php?view=<?= $values['EmpID'] ?>"><?= $values['UserName'] ?></a>
				&nbsp; &nbsp; &nbsp; <? } } ?>
				
				</td>


			</tr>

		</table>


		</td>
	</tr>

	</form>
</table>
</div>
