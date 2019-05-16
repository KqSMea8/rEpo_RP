<? $_GET['Status'] = 1;
   $_GET['Division'] = '5,7';
   $_GET['SalesCommFlag'] = '1';
$arryEmployeeCRM = $objEmployee->GetEmployeeList($_GET);
?>
<script>
function GetSalesCommChart(){
	var salesCommEmp=document.getElementById("salesCommEmp").value;
	var salesCommYr=document.getElementById("salesCommYr").value;
var salesCommPersonType=document.getElementById("sp").value; //added by nisha for sales commission
	var dataString="empId="+escape(salesCommEmp)+"&y="+escape(salesCommYr)+"&salesPerson="+escape(salesCommPersonType); // modified by nisha for sales commission
	 $('#divSalesReport').hide();
	
	if(salesCommEmp<=0){
		alert('Please Select User.');
	}else if(salesCommYr<=0){
		alert('Please Select Year.');
	}else if(salesCommEmp>0 && salesCommYr>0){
		$('#loadingSalesR').show();
		
		
		
		$.ajax({
			type: "GET",
			url: "../adminSalesCommChart.php",
			data: dataString,
			async:false,
			success: function(result){
				$('#loadingSalesR').hide();
				$('#divSalesReport').show();	 
				
				 
				  var bwidth=$('.Sales .bgwhite').width();
				  if(!$('.Sales .bgwhite').hasClass('active')){
					$('.Sales .bgwhite .salesBl').css({'width':bwidth,'float':'left'});				
					$('.salesadmin').animate({
				        width: '+=673px'
				    },500,function(){
			    		
			    		$('.Sales .bgwhite').addClass('active');
				    });
				}else{					
					$('.callrow .chart').html('');
				}
				
				$('#divSalesReport').html(result);


			}
			});
	}else{
		
		 $('#divSalesReport').hide();
		 $('#loadingSalesR').hide();
		
	}
}
//added by nisha for sales commission	
function ResetSearch(){	
	$("#loadingSalesR").show();
	$("#frmSrch").hide();
	$("#loadingSalesR").hide();
}
function GetSalesPerson(str,locationID){
ResetSearch();
document.getElementById('sp').value=str;
var dataString="SalesPersonType="+escape(str);
	$.ajax({
			type: "POST",
			url: "ajax.php",
			data: dataString,
			async:false,
			success: function(result){
				$('#loadingSalesR').hide();
				$("#salesCommEmp").html('');
				$("#salesCommEmp").html(result);
			var salesPersonTypeData = document.getElementById("salesPersonTypeDrop").classList;
if (salesPersonTypeData.contains("adminSalesPersonType")) {
salesPersonTypeData.remove("adminSalesPersonType");
} 
				
}
});

}
</script>

<style>
#salesCommYr{
margin-left:11px;
}
</style>

<div class="first_col salesadmin" style="<?=$WidthRow1?>">
            <div class="block Sales"> 
		<h3>Sales Commission Report</h3>
              <div class="bgwhite salesCommition" style="padding: 0 5px 0 5px;">
              

		<div class="salesBl">
		<?php if($_SESSION['AdminType'] == "employee"){
	  $sPersonType =1;
	$class= "employeeSalesPersonType";
      }
	 else {
		 $sPersonType =0;
		 $class ="adminSalesPersonType";
	 }
if($sPersonType==0) {
	  ?>
		
	<select name="sp" class="inputbox" onChange="Javascript: GetSalesPerson(this.value,'<?php echo $_GET['locationID']?>');" style="margin:10px;" id="adminSalesPerson">
		  <option value="">--- Select Sales Person Type---</option>
		 <option value="1" <?=($_GET["sp"]=='1')?("selected"):("")?>>Employees</option>
         <option value="2" <?=($_GET["sp"]=='2')?("selected"):("")?>>Vendor</option>
	</select>
<?php } ?>	
<div class="<?php echo $class?>" id="salesPersonTypeDrop">	
	 <select name="salesCommEmp" class="inputbox salesCommEmp" style="margin:10px;" id="salesCommEmp" >
				<option value="">Select CRM User</option>
				<?php

				if(is_array($arryEmployeeCRM)){
				$flag=true;
				$Line=0;
					
				foreach($arryEmployeeCRM as $key=>$emp){
				$flag=!$flag;
				#$bgcolor=($flag)?("#FDFBFB"):("");
				$Line++;
				$select="";
				//if($emp['EmpID']==$empid)	//by chetan on 24Jan2018//
				//$select='Selected="Selected"'; //by chetan on 24Jan2018//
				?>
				<option value="<?php echo $emp['EmpID']?>" <?php echo $select;?>><?=stripslashes($emp['UserName'])?>
				</option>
				<? } }?>
			</select>
	
	<?=getYears($_GET['y'],"salesCommYr","textbox")?>

	&nbsp;&nbsp;<input type="button" value="GO" class="button" onclick="Javascript:GetSalesCommChart()">
<input type="hidden" name="salesPerson" id="sp" value="">
</div>
			<div id="loadingSalesR" align="center" style="display:none;padding-top:20px;"><img src="../images/ajaxloader.gif"></div>
			
			
			</div>
<div class="chartSales" id="divSalesReport" ></div>

             
            </div>


  </div>
</div>
