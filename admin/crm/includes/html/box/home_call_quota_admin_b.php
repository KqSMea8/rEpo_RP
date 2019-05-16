<?
	if(empty($CallDashboardInc)){
		$CallDashboardInc = "includes/html/box/call_dashboard.php";
		include($CallDashboardInc);
	}

 ?> 

<div class="callrowadmin">

<div class="block calladminblock" style="<?=(isset($WidthRow1)) ? $WidthRow1 : '';?>;">

<h3><?=$BlockHeading?></h3>
<div class="bgwhite">
<? if($Config['FullPermission']==1){	?>
<div class="quota-emp">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="left"><label style="width: 71px; display: inline-block;">From
		Date </label>: <script>
					$(function() {
					$( "#from" ).datepicker({	
						beforeShow:function(e,l)	{
						$( "#to" ).val('');
						$( "#from" ).datepicker( "option", "maxDate", null );
						}	,			
					onClose: function( selectedDate ) {
					$( "#to" ).datepicker( "option", "minDate", selectedDate );
					}
					});
					$( "#to" ).datepicker({					
					onClose: function( selectedDate ) {
					$( "#from" ).datepicker( "option", "maxDate", selectedDate );
					}
					});
					});
					</script> <input id="from" name="from" readonly="" class="datebox"
			value="<?php echo date('m/d/Y');?>" type="text"> 
		</td>

		<tr>
			<td><label style="width: 71px; display: inline-block;">To Date</label>:
			<input id="to" name="to" readonly="" class="datebox"
				value="<?php echo date('m/d/Y');?>" type="text"></td>
		</tr>
		<tr>
			<td>
			<form action="#CallForm" method="get" id="CallForm">

			
			 <select name="empId"
				 class="inputbox empList" style="margin: 10px; width: 150px">
				<option value="">Select CRM User</option>
				<?php

				if(is_array($arryCallUser) && $numCallUser>0){
				$flag=true;
				$Line=0;
					
				foreach($arryCallUser as $key=>$emp){
				$flag=!$flag;
				#$bgcolor=($flag)?("#FDFBFB"):("");
				$Line++;
				$select="";
				//if($emp['EmpID']==$empid) $select='Selected="Selected"';
				?>
				<option value="<?php echo $emp['EmpID']?>" <?php echo $select;?>><?=stripslashes($emp['UserName'])?>
				</option>
				<? } ?>
			</select> <input type="button" value="Go" onclick="GetCallResponceAdminBygo(this);" class="button"/><?php }else{
			
			
			}?>
			<div align="center" id="ajax-loader-calladmin" style="display: none;"><img
				src="../images/loading.gif">&nbsp;Loading.......</div>
			<div class="call-detail"></div>


			</form>
			</td>
		</tr>

</table>


<? }else{ echo '<div class=redmsg align="center" style="padding-top: 50px;">Restricted.</div>';} ?>

</div>

<div class="chart" style="padding-top: 15px;float:left;margin-left:116px;"></div>


</div>
</div>



<script>
function GetCallResponceAdminBygo(obj){
var empid=jQuery('.empList').val();

	if(empid !='' && empid != 'undefined'){
		GetCallResponceAdmin(empid);
	}else{
		alert('Please select CRM User');
		}
}

</script>

<script>

  function CallFormSubmit(obj){
		if(jQuery(obj).val()!=''){
			GetCallResponceAdmin(jQuery(obj).val());
		}else{
			$('.callrowadmin .call-detail').html('');
			$('.callrowadmin .chart').html('');
			
			}
	  }

  function GetCallResponceAdmin(empid){
	 // alert(empid);
	   var fromdate =  $("#from").val();
	   var todate =    $("#to").val();
	  var request=jQuery.ajax({
			url:'ajax.php',
			type:'GET',
			data:{
			empId:empid, fromdate:fromdate, todate:todate, AdminType:'admin',
			action:'calldetail'
			},beforeSend:function(){
				$('#ajax-loader-calladmin').show();
				},success:function(data){
				var jsonobj =	$.parseJSON(data );
			
				var bwidth=$('.callrowadmin .bgwhite').width();
					if(!$('.callrowadmin .bgwhite').hasClass('active')){
					$('.callrowadmin .bgwhite .quota-emp').css({'width':bwidth,'float':'left'});
					$('.callrowadmin .call-detail').html(jsonobj.quota);
				    $('.block14').animate({
				        width: '1158px'
				    },1200,function(){
				    		$('.callrowadmin .chart').html(jsonobj.chart);
				    		$('.callrowadmin .bgwhite').addClass('active');
					    });
					}else{
						$('.callrowadmin .call-detail').html(jsonobj.quota);
						$('.callrowadmin .chart').html(jsonobj.chart);
						}
					$('#ajax-loader-calladmin').hide();
				}
			});
	  }
  </script>
