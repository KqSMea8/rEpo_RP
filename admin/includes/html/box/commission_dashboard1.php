<? if($_SESSION['AdminType'] != "admin"){ 
		/***************************/

		$arryDate = explode("-",$Config['TodayDate']);
		list($year, $month, $day) = $arryDate;
		$LastMonthTm  = mktime(0, 0, 0, $month-1 , $day, $year);

		$FromDate = date("Y-m-01",$LastMonthTm);		
		$NumDayMonth = date('t', strtotime($FromDate));
		$ToDate = date("Y-m-".$NumDayMonth,$LastMonthTm); 

		$EmpID = $_SESSION["AdminID"]; $EmpDivision = 5;
		require_once("../includes/html/box/commission_cal.php");
		/***************************/

	?>
	<div class="third_col" <?=$StyleCom?>>
             <div class="block new_lead">            
              <h3>Sales Commission for <?=date('F, Y', $LastMonthTm)?></h3>
              <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
               
  <?  if(!empty($arrySalesCommission[0]['SalesPersonType'])){	 ?>
		<tr class="even">  
			<td >Sales Person Type : </td>
			<td><?=(!empty($arrySalesCommission[0]['SalesPersonType']))?($arrySalesCommission[0]['SalesPersonType']):("None");?></td>
		  </tr>         
                      
<tr class="odd">
	<td>Commission Tier :</td>
	<td>

<? if($arrySalesCommission[0]['Percentage']>0){ ?>
<?=$arrySalesCommission[0]['Percentage']." %  on sale of : ".$arrySalesCommission[0]['RangeFrom']." - ".$arrySalesCommission[0]['RangeTo']." ".$Config['Currency'].""?>
<? }else {echo "None"; } ?>
			

	</td>
 </tr>	

<tr class="even">
	<td >
	Spiff Amount   :

	</td>
	<td>

	<?
	if(!empty($arrySalesCommission[0]['SpiffAmount'])){
	$SpiffAmount = $arrySalesCommission[0]['SpiffAmount'].' '.$Config['Currency'];
	}else{
	$SpiffAmount = 'None';
	}
	echo $SpiffAmount;
	?>
	
	

	</td>
</tr>

	<tr class="odd">
	<td>
		Sales Target for Spiff Amount  :

		</td>
		<td  align="left" valign="top" >	
		<?
		if(!empty($arrySalesCommission[0]['SpiffTarget'])){
		$SpiffTarget = $arrySalesCommission[0]['SpiffTarget'].' '.$Config['Currency'];
		}else{
		$SpiffTarget = 'None';
		}
		echo $SpiffTarget;
		?>

	</td>
	</tr>
 <tr class="even">  
	<td>Sales Amount for Commission : </td>
	<td><?=round($TotalSales,2).' '.$Config["Currency"]?></td>
  </tr>
 <tr class="odd">  
	<td>Sales Commission : </td>
	<td><b><?=round($TotalCommission,2).' '.$Config["Currency"]?></b></td>
  </tr>

  
                         
              <?   } else{?>
		    <tr align="center" >
		      <td  colspan="2" class="no_record"><?=NO_RECORD?> </td>
		    </tr>
               <? }?>
                           
              </table>
            </div>
            </div>
          </div>
	<? } ?>
