<? $_GET['Status'] = 1;
   $_GET['Division'] = '5,7';
   $_GET['SalesCommFlag'] = '1';

$arryEmployeeCRM = $objEmployee->GetEmployeeList($_GET);
?>
<script>
function GetSalesCommChart(){
	var salesCommEmp=document.getElementById("salesCommEmp").value;
	var salesCommYr=document.getElementById("salesCommYr").value;
	var dataString="empId="+salesCommEmp+"&y="+salesCommYr;
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
					
					
					
			            $('.block13').animate({
				        width: '1158px'
				    },1200,function(){
			    		
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
</script>

<style>
#salesCommYr{
margin-left:11px;
}
</style>


            <div class="block Sales salesadmin" style="<?=(isset($WidthRow1)) ? $WidthRow1 : '';?>"> 
		<h3><?=$BlockHeading?></h3>
              <div class="bgwhite salesCommition" style="padding: 0 5px 0 5px;">
              
		<? if($Config['FullPermission']==1){	?>
		<div class="salesBl">
			
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
				if(isset($empid) && $emp['EmpID']==$empid)
				$select='Selected="Selected"';
				?>
				<option value="<?php echo $emp['EmpID']?>" <?php echo $select;?>><?=stripslashes($emp['UserName'])?>
				</option>
				<? } }?>
			</select>
	
	<?=getYears($_GET['y'],"salesCommYr","textbox")?>

	&nbsp;&nbsp;<input type="button" value="GO" class="button" onclick="Javascript:GetSalesCommChart()">

			<div id="loadingSalesR" align="center" style="display:none;padding-top:20px;"><img src="../images/ajaxloader.gif"></div>
			
			
			</div>
<div class="chartSales" id="divSalesReport" ></div>
			<? }else{ echo '<div class=redmsg align="center" style="padding-top: 50px;">Restricted.</div>';} ?>
             
            </div>


  </div>

