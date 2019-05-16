
<a href="<?=$RedirectUrl?>" class="back">Back</a>

<a href="<?=$EditUrl?>" class="edit">Edit</a>

<div class="had"><?=$MainModuleName?> <span> &raquo;
<?=$ModuleName?> Detail
</span>
</div>
	

		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post"  enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" >
<table width="100%" border="0" cellpadding="5" cellspacing="0"  class="borderall">

 <tr>
	 <td colspan="4" align="left" class="head">General</td>
</tr>

                    <tr>
                      <td align="right" width="20%" valign="top"   class="blackbold">
					   Shift Name : </td>
                      <td align="left" width="25%"  valign="top">
					<?=stripslashes($arryShift[0]['shiftName'])?>
					    </td>
                  
                      <td width="25%" align="right"  class="blackbold">
					Working Hour Start :
					  </td>
                      <td >

<?=$arryShift[0]['WorkingHourStart']?>

		 
					  </td>
                    </tr>
                    <tr>
                      <td  align="right"   class="blackbold"> 
						Working Hour End :

					  </td>
                      <td  align="left" valign="top">

<?=$arryShift[0]['WorkingHourEnd']?>


					  </td>
                   
                      <td  align="right"   class="blackbold"> 
						Duration :

					  </td>
                      <td  align="left" valign="top">

			<?			
	$Duration =  strtotime($arryShift[0]['WorkingHourEnd']) - strtotime($arryShift[0]['WorkingHourStart']);
	echo $FinalDuration = time_diff($Duration);
			?>			



					  </td>
                    </tr>
					
					
                  	
					

	<tr>
                      <td  align="right"   class="blackbold"> 
						Short Leave for Late Coming :
					  </td>
                      <td  align="left" valign="top">
<?=$arryShift[0]['SL_Coming']?>				

					  </td>
                  
                      <td  align="right"   class="blackbold"> 
						Short Leave for Early Leaving :
					  </td>
                      <td  align="left" valign="top">
<?=$arryShift[0]['SL_Leaving']?>
					  </td>
                    </tr>

<tr>

<td  align="right"   class="blackbold" valign="top">Week Start :</td>
<td  align="left" valign="top">
<?=$arryShift[0]['WeekStart']?>
<td  align="right"   class="blackbold">Week End :</td>
<td  align="left" valign="top">
<?=$arryShift[0]['WeekEnd']?> 

</td>
</tr>

<tr>
<td  align="right"   class="blackbold" valign="top">Weekend Count for Leave :</td>
<td  align="left" valign="top">

<?=($arryShift[0]['WeekendCount'] == 1)?('Yes'):('No')?>

</td>
</tr>


 <tr id="timetr">
	 <td colspan="4" align="left" class="head">Time</td>
</tr>




<tr id="lunchtr">
<td  align="right"   class="blackbold" valign="top">Lunch Punch Allowed :</td>
<td  align="left" valign="top">
<?=($arryShift[0]['LunchPunch'] == 1)?('Yes'):('No')?>

</td>

<td  align="right"   class="blackbold" valign="top">Lunch Time :</td>
<td  align="left" valign="top">
<?  	
	if(!empty($arryShift[0]['LunchTime'])){
		$arryLunchTime = explode(":",$arryShift[0]['LunchTime']);
		echo $LunchTime = $arryLunchTime[0].' hrs '.$arryLunchTime[1].' min';
	}

?>

</td>
</tr>


<tr id="breakpaidtr">
<td  align="right"   class="blackbold" valign="top">Lunch Paid 	:</td>
<td  align="left" valign="top">
<?=($arryShift[0]['LunchPaid'] == 1)?('Yes'):('No')?>

</td>
<td  align="right"   class="blackbold" valign="top">Short Break Paid :</td>
<td  align="left" valign="top">
<?=($arryShift[0]['ShortBreakPaid'] == 1)?('Yes'):('No')?>

</td>
</tr>

<tr id="flextr">
<td  align="right"   class="blackbold" valign="top">Flex Time 	:</td>
<td  align="left" valign="top">
<?=($arryShift[0]['FlexTime'] == 1)?('Yes'):('No')?>

</td>
<td  align="right"   class="blackbold" valign="top">Short Break Allowed :</td>
<td  align="left" valign="top">
<?=($arryShift[0]['ShortBreakPunch'] == 1)?('Yes'):('No')?>

</td>


</td>
</tr>

<tr id="shortbreaktr">

<td  align="right"   class="blackbold" valign="top">Short Break Limit :</td>
<td  align="left" valign="top">
<?=$arryShift[0]['ShortBreakLimit']?>
<td  align="right"   class="blackbold">Short Break Time :</td>
<td  align="left" valign="top">
<?=$arryShift[0]['ShortBreakTime']?> min

</td>
</tr>


<tr id ="EarlyPunchRestricttr">
<td  align="right"   class="blackbold" valign="top">Early Punch Restrict :</td>
<td  align="left" valign="top">
<?=($arryShift[0]['EarlyPunchRestrict'] == 1)?('Yes'):('No')?>
</td>
<td  align="right"   class="blackbold" valign="top">Early Break Restrict :</td>
<td  align="left" valign="top">
<?=($arryShift[0]['EarlyBreakRestrict'] == 1)?('Yes'):('No')?>
</td>

</tr>

<tr id ="EarlyPunchRestricttr2">
<td  align="right"   class="blackbold" valign="top">Early Lunch In Restrict :</td>
<td  align="left" valign="top">
<?=($arryShift[0]['EarlyLunchRestrict'] == 1)?('Yes'):('No')?>
</td>
 

</tr>


 <tr>
	<td  align="right"  valign="top" class="blackbold"> 
	Overtime Period : </td>
<td align="left" valign="top">
<?=($arryShift[0]['OvertimePeriod'] == 'W')?('Weekly'):('Daily')?>

 </td>

	<td  align="right"  valign="top" class="blackbold"> 
	Overtime Eligibility in a Week : </td>
<td align="left" valign="top">
<?=($arryShift[0]['OvertimeHourWeek']>0)?($arryShift[0]['OvertimeHourWeek'].' Hours'):('')?>

 
 </td>

</tr>




 <tr>
	 <td colspan="4" align="left" class="head">Payroll</td>
</tr>





<tr id="paycycletr">


			<td  align="right"   class="blackbold"> 
				Payroll Start Date :
			</td>
			 <td  align="left" valign="top">

<? if($arryShift[0]['PayrollStart']>0) echo date($Config['DateFormat'], strtotime($arryShift[0]['PayrollStart'])); ?>


				</td>

                      <td  align="right"   class="blackbold"> 
					Pay Cycle :
		      </td>
                      <td  align="left" valign="top">

<?=$arryShift[0]['PayCycle']?>			  </td>

		





                    </tr>



<tr>


 
                      <td align="right" valign="top"  class="blackbold">Status : </td>
                      <td align="left" >
       <?=($arryShift[0]['Status'] == 1)?('Active'):('InActive')?>

                                          </td>
                    </tr>


                 
                  </table></td>
                </tr>
				
		
				
				
			
              </form>
          </table>
