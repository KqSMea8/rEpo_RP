<?php
if($_GET['tab'] == 'Quote'){ ?>
<div class="had">Quotes Details</div>

<table border="0" class="borderall" cellpadding="0" cellspacing="0"
	width="100%">
	
	<!---Recurring Start-->
 <?php   
        $arryRecurr = $arryQuote;

        include("../includes/html/box/recurring_2column_sales_view.php");
 ?>  
      
        <!--Recurring End-->

	<tr>
		<td align="right" class="blackbold" width="25%">Subject :</td>
		<td align="left"><?=$arryQuote[0]['subject']?></td>


		<? if($arryQuote[0]['CustType']=='o'){ ?>

		<td align="right" class="blackbold">Opportunity :</td>
		<td align="left"><?=(!empty($OpportunityName))?(stripslashes($OpportunityName)):(NOT_SPECIFIED)?>
		</td>

		<? }else if($arryQuote[0]['CustType']=='c'){  ?>

		<td align="right" class="blackbold">Customer :</td>
		<td align="left"><?=(!empty($CustomerName))?(stripslashes($CustomerName)):(NOT_SPECIFIED)?>
		</td>

		<? } ?>

	</tr>

	<tr style="display: none;">
		<td align="right" class="blackbold">Quote No :</td>
		<td align="left"><input class="inputbox" name="quote_no" id="quote_no"
			value="AUTO GEN ON SAVE" type="text"></td>
	</tr>

	<tr>
		<td align="right" class="blackbold">Quote Stage :</td>
		<td align="left"><?=(!empty($arryQuote[0]['quotestage']))?(stripslashes($arryQuote[0]['quotestage'])):(NOT_SPECIFIED)?></td>

		<td align="right" class="blackbold">Valid Till :</td>
		<td align="left"><?=($arryQuote[0]['validtill']>0)?(date($Config['DateFormat'] , strtotime($arryQuote[0]["validtill"]))):(NOT_SPECIFIED)?></td>
	</tr>




	<tr>

		<td align="right" class="blackbold">Carrier :</td>
		<td align="left"><?=(!empty($arryQuote[0]['carrier']))?(stripslashes($arryQuote[0]['carrier'])):(NOT_SPECIFIED)?></td>

		<td align="right" class="blackbold">Shipping :</td>
		<td align="left"><?=(!empty($arryQuote[0]['shipping']))?(stripslashes($arryQuote[0]['shipping'])):(NOT_SPECIFIED)?></td>
	</tr>
	<tr>

		<td align="right" class="blackbold">Assign To :</td>
		<td align="left" colspan="3"><? if($arryQuote[0]['AssignType'] == 'Group'){ ?>
		<?=$AssignName ?> <br>
		<? }?>

		<div><? foreach($arryAssignee as $values) {

			?> <a class="fancybox fancybox.iframe"
			href="../userInfo.php?view=<?=$values['EmpID']?>"><?=$values['UserName']?></a>,
			<? }  ?></div>


		</td>
	</tr>
	<tr>

		<td align="right" class="blackbold">Notes :</td>
		<td align="left"><?=(!empty($arryQuote[0]['Comment']))?(stripslashes($arryQuote[0]['Comment'])):(NOT_SPECIFIED)?></td>



		<td align="right" class="blackbold" valign="top">Currency :</td>
		<td align="left" valign="top"><?=(!empty($arryQuote[0]['CustomerCurrency']))?(stripslashes($arryQuote[0]['CustomerCurrency'])):(NOT_SPECIFIED)?></td>

	</tr>


</table>


</div>
<?php } ?>