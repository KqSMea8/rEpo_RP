<? if($_SESSION['AdminType'] != "admin"){ 
		/***************************/
                
                
                
                
		//$_GET['m'] = '09'; $_GET['y'] = '2014'; //temp 
                $EmpID = $_SESSION["AdminID"]; $EmpDivision = 5;
                $arryEmp = $objEmployee->GetEmployeeBrief($EmpID);
                
                
                
                $arryCommissionType = $objEmployee->GetCommissionType($EmpID); 
                $CommissionType = $arryCommissionType[0]['CommissionType'];
                
                //$arryEmp[0]['JoiningDate']='2015-02-01'; // for checking
                //$CommissionType='Quaterly'; // for checking
                if($CommissionType=='Yearly'){
                    $Y = date("Y");
                    $FromDate = $Y."-01-01"; $ToDate = $Y."-12-31";
                    if(($arryEmp[0]['JoiningDate'] > $FromDate)){
                        $FromDate = $arryEmp[0]['JoiningDate'];
                    } 
                     
                     $SalesCommFor = date('M, Y', strtotime($FromDate)).' - '.date('M, Y', strtotime($ToDate));
                }else if($CommissionType=='Quaterly'){
                    
                    
                   
                    $FirstQ=array('Jan','Feb','Mar');
                    $SecondQ=array('Apr','May','Jun');
                    $ThirdQ=array('Jul','Aug','Sep');
                    $FourthQ=array('Oct','Nov','Dec');
                    
  
                    $curr_month = date("M");
                    //$curr_month = 'Aug';

                    if($quater=in_array($curr_month,$FirstQ))
                    {
                       $quater='FirstQ';
                       $FromDate = date("Y")."-01-01";
                       $ToDate = date("Y")."-03-31";
                    }
                    else if($quater=in_array($curr_month,$SecondQ)) {
                       $quater='SecondQ';
                       $FromDate = date("Y")."-04-01";
                       $ToDate = date("Y")."-06-30";
                     }
                    else if($quater=in_array($curr_month,$ThirdQ)) {
                       $quater='ThirdQ';
                       $FromDate = date("Y")."-07-01";
                       $ToDate = date("Y")."-09-30";
                     }
                     else {
                       $quater='FourthQ';
                       $FromDate = date("Y")."-10-01";
                       $ToDate = date("Y")."-12-31";
                     }

                     $SalesCommFor = date('M, Y', strtotime($FromDate)).' - '.date('M, Y', strtotime($ToDate));
                }else{
                   // $_GET['m'] = '05'; $_GET['y'] = '2017'; //temp
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
                    $SalesCommFor = date('M, Y', strtotime($ToDate));
                    
                }
                
               
                   
                
                
		if($arryEmp[0]['CommOn']==1){
			require_once("../includes/html/box/commission_cal_per.php");
		}else if($arryEmp[0]['CommOn']==2){
			require_once("../includes/html/box/commission_cal_margin.php");
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


<style>
	  
      .my-dashboard .new_lead tbody tr td a{ font-size:11px}
      .progress-box-custom{
float:left;
width:260px;
margin-left:5px;
}
.progress-bar-custom{
float:left;
width:100%;

background-color: #f5f5f5;
    border-radius: 4px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset;
    height: 20px;
}
.count-progress{
margin-left:5px;
}
.progress-custom{
background:none repeat scroll 0 0 #337ab7;
border-radius:5px;
float:left;
width:50%

}

.total-progress {
    float: right;
    margin-right: 5px;
    }
      </style>






	<div class="third_col" <?=$StyleCom?>>
             <div class="block new_lead">            
              <h3>Sales Commission for <?=$SalesCommFor?></h3>
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
