<? if($_SESSION['AdminType'] != "admin"){ 
		/***************************/
		#$_GET['m'] = '10'; $_GET['y'] = '2014'; //temp
		if(!empty($_GET['m']) && !empty($_GET['y'])){
			$LastMonthTm  = mktime(0, 0, 0, $_GET['m'], 1, $_GET['y']);
		}else{
			$arryDate = explode("-",$Config['TodayDate']);
			list($year, $month, $day) = $arryDate;
			$LastMonthTm  = mktime(0, 0, 0, $month-1 , $day, $year);
			$_GET['m'] = date("m",$LastMonthTm);
			$_GET['y'] = date("Y",$LastMonthTm);
		}

		$FromDate = date("Y-m-01",$LastMonthTm);		
		$NumDayMonth = date('t', strtotime($FromDate));
		$ToDate = date("Y-m-".$NumDayMonth,$LastMonthTm); 

		$EmpID = $_SESSION["AdminID"]; $EmpDivision = 5;
		$arryEmp = $objEmployee->GetEmployeeBrief($EmpID);
		if($arryEmp[0]['CommOn']==1){
			require_once("../includes/html/box/commission_cal_per.php");
		}else{
			require_once("../includes/html/box/commission_cal.php");
		}
		/***************************/
		$arryPayment=$objSale->PaymentReport($FromDate,$ToDate,$EmpID);

		$num=$objSale->numRows();
		foreach($arryPayment as $key=>$values){
			$TotalAmount += $values['PaidAmount'];
		}
		$Dashboard=1;
	?>
	<div class="third_col" <?=$StyleCom?>>
             <div class="block new_lead">            
              <h3>Sales Commission for <?=date('F, Y', $LastMonthTm)?></h3>
              <div class="bgwhite">
			<!--div align=right><?=getMonths($_GET['m'],"m","textbox")?> <?=getYears($_GET['y'],"y","textbox")?></div-->
			<? include("../includes/html/box/commission_view.php"); ?>
              
            </div>
            </div>
          </div>

<script type="text/javascript">
	$(document).ready(function() {

		$("#m").change(function(){
		  ChangeCommDuration();
		}); 

		$("#y").change(function(){
		  ChangeCommDuration();
		}); 

		function ChangeCommDuration(){
			var y = $("#y").val();
			var m = $("#m").val();
			 if(y!='' && m!=''){
			 	location.href = 'home.php?y='+y+'&m='+m;
			 	ShowHideLoader('1','L');
			 }
		}
		

	});
</script>



<? } ?>
