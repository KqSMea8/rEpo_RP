<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>

<script language="JavaScript1.2" type="text/javascript">

</script>

	<SCRIPT LANGUAGE=JAVASCRIPT>


	function calculateCoupon(){
		var TotalAmount = $('#TotalAmount').val();
		var CouponCode = document.getElementById("CouponCode").value;
		var SendUrl = "&action=CouponCode&CouponCode="+escape(CouponCode)+"&TotalAmount="+escape(TotalAmount);
		
	   	$.ajax({
		type: "GET",
		url: "ajax_main.php",
		data: SendUrl,
		dataType : "JSON",
		success: function (responseText) {
			var CouponApplied=0;
			if(responseText['id']>0){
                var packageId= $('#pack_id').val();
				var Percentage=responseText['Percentage'];
				var Amount=responseText['Amount'];
				var CouponType=responseText['CouponType'];
				var DiscountType=responseText['DiscountType'];
				var Package=responseText['Package'];
				var MaxUser = $('#MaxUser').val();
				var NumUser = parseInt(responseText['User']);
				var arrayPackage = Package.split(",");
				//// for hidden field 
				 $('#CouponType').val(CouponType);
				 $('#DiscountType').val(DiscountType);
				 $('#User').val(NumUser);
				
				/// 
				var packexist=0;
				
				if(CouponType=='Package'){
					for(var i = 0; i < arrayPackage.length; i++){
						if(packageId==arrayPackage[i]){
							packexist = 1;
							break;						
						}					
					}
					if(packexist==1){
						CouponType = DiscountType;
						if(NumUser>0 && MaxUser>NumUser){
							calculateprice(NumUser);	
						}				
					}
					
				}

				
				var TotalAmountVal = $('#TotalAmount').val();
				
				if(CouponType=='Percentage'){												
					  var DiscountVal = TotalAmountVal*Percentage/100;
					  var TotalPrice = TotalAmountVal-DiscountVal;	
					  if(TotalPrice<=0){
						  TotalPrice = 0;	
						}				  
					  $('#CouponDiscount').val(DiscountVal);
					  $('#TotalAmount').val(TotalPrice);
					  $('#TotalAmountSpan').html(TotalPrice); 					  
					  $('#CouponCd').hide();
					  CouponApplied=1;
					
				}else if(CouponType=='Fixed'){					
					  var TotalPrice = TotalAmountVal-Amount;
					  if(TotalPrice<=0){
						  TotalPrice = 0;	
						}					 
					  $('#CouponDiscount').val(Amount);
					  $('#TotalAmount').val(TotalPrice);
					  $('#TotalAmountSpan').html(TotalPrice); 					  
					  $('#CouponCd').hide();
					  CouponApplied=1;
					
				}
				
			
				
			}

			if(CouponApplied==1){
				$('#coupontext').html("<span class=greentxt>Coupon Code Applied.</span>"); 				
			}else{
				$('#coupontext').html("Coupon Code Not Applied.");
			}
			
			//document.getElementById("CustomerName").value=responseText["CustomerName"];
			   
		}

	   });


	}

	

	function calculateprice(UserLess){
		
		var MaxUser = $('#MaxUser').val();
		var UserNum = MaxUser - UserLess;
		var Price = $('#Price').val();
		var PlanDuration = $('#PlanDuration').val();
		var Duration = $('#Duration').val();
		var AdditionalSpace = $('#AdditionalSpace').val();
		var AdditionalSpaceUnit = $('#AdditionalSpaceUnit').val(); 
		var FreeSpace = $('#FreeSpace').val();
		var FreeSpaceUnit = $('#FreeSpaceUnit').val(); 
		var AdditionalSpacePrice = $('#AdditionalSpacePrice').val();
		var Deduction = $('#Deduction').val();
		var TotalAmount = 0; var AdditionalPrice = 0;
		var arrPlan = PlanDuration.split("/");
		var DaysLeft = $('#DaysLeft').val(); 

		if(UserLess==0){
		 $('#CouponType').val('');
		 $('#DiscountType').val('');
		 $('#User').val('');
		}

		
		if(AdditionalSpace>0){
			var addition_sp = AdditionalSpace;
			if(AdditionalSpaceUnit=="TB"){
				addition_sp = addition_sp*1024;
			}			
			AdditionalPrice = (addition_sp*AdditionalSpacePrice)/10;
		}

		
		if(PlanDuration==Duration){
			TotalAmount = UserNum*Price;	
		}else if(Duration=='user/month' && PlanDuration=='user/year'){
			TotalAmount = UserNum*Price*12;	
		}else if(Duration=='user/year' && PlanDuration=='user/month'){
			TotalAmount = UserNum*(Price/12);	
		}
		TotalAmount = (TotalAmount + AdditionalPrice) - Deduction;
		
		TotalAmount = Math.round(TotalAmount);


		if(TotalAmount<=0){
			TotalAmount = 0;	
		}
		
		//TotalAmount = TotalAmount/coupenParse;
			
		$('#TotalAmount').val(TotalAmount);
		
		$('#pricetext').hide();
		$('#CouponCd').hide();
		$('#coupontext').html('');
		$('#CouponCode').val(''); 
		$('#CouponDiscount').val(''); 
		if(MaxUser>0){
		

			var datahtml = '<h3>You have been choosen subscription for 1 '+arrPlan[1]+'(s) for '+MaxUser+' user(s)<br>After deduction of $'+Deduction+' for time '+DaysLeft+' day(s):</h3> <h3><br>Final Price:$<span id="TotalAmountSpan">'+TotalAmount+'</span> <br>Additional Space:- '+AdditionalSpace+'  '+AdditionalSpaceUnit+'<br>Free Space:- '+FreeSpace+'  '+FreeSpaceUnit+'</h3>';

			//var datahtml = '<h3>You have been choosen 1 '+arrPlan[1]+'(s) subscription for '+MaxUser+' user(s) for $'+TotalAmount+'<br>after deduction of $'+Deduction+'.<br>Your old deduction of $0.00 and time 23 days has been deducted<br>Space:20GB<br>Price: $20.00.</h3>';
			
			$('#pricetext').show();
			$('#CouponCd').show();
			$('#pricetext').html(datahtml);	
		}
	}
	
	


	
function validate(frm)
{	
	if( ValidateForSelect(frm.MaxUser, 'Number of users')
	){	
		return true;	
	}else{
		return false;	
	}
}


function coupon(frm){
	//var Url = "isRecordExists.php?CouponCode="+escape(document.getElementById("CouponCode").value);
	//SendExistRequest(Url,"CouponCode", "Coupon Code");
	//return false;
			
}
</SCRIPT>

<h1 id="page-title" class="title" style="text-align: center;">Choose Your Plan</h1>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
<td align="left" >
	<a href="cmpList.php?link=viewPackageLog.php" class="fancybox action_bt fancybox.iframe" class="action_bt">Select Company</a></td>
</tr>

<? if($CmpID>0){?>
<tr>
  <td  valign="top" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="50%" > Company Name  : </td>
        <td   align="left" >
<strong><?php echo stripslashes($arryCompany[0]['CompanyName']); ?></strong>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Company ID  :</td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['CmpID']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Display Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>
           </td>
      </tr>
<tr>
	 <td  align="right">Email : </td>
 <td  align="left">
<?php echo $arryCompany[0]['Email']; ?>
</td>
</tr>
</table>

</td>
</tr>


<? } ?>


</table>

<br>
<br>
		
<div id="PlanDetail"><span class="label">Plan Type:-</span> <span
	class="value"><?php echo $arrayPkj[0]['name'];?> </span><br>
<span class="label">Price:-</span> <span class="value">$<?php echo $arrayPkj[0]['price'];?>
</span> <br>
<span class="label">Free Space:-</span> <span class="value"><?php echo $arrayPkj[0]['space'].' GB';?>
</span>

<? if(!empty($rSDiscount)){?>
<br>
<span class="label">Discount:-</span> <span
	class="value">
<?php 
echo $rSDiscount .'%';
?> 
</span>
<? } ?>

</div>


<table width="97%" border="0" align="center" cellpadding="0"
	cellspacing="0">


	<form name="form1" action="upgradePaymentrs.php?pack_id=<?php echo $_GET['pack_id'];?>&cmp=<?php echo $_GET['cmp'];?>" method="post"
		onsubmit="return validate(this);" enctype="multipart/form-data">

		<tr>
			<td align="center" valign="top">

				<table width="100%" border="0" cellpadding="5" cellspacing="10"
					class="borderall">
		
					<tr>
					<td align="right" class="blackbold" valign="top">Select Number of users<span
												class="red">*</span></td>
					<td align="left">
					 <select class="inputbox" name="MaxUser" id="MaxUser" onchange="javascript:calculateprice(0);">
					 <option value="">Select</option>
					<?php
					for($i=1;$i<=200;$i++){?>
					<option value="<?php echo $i;?>">
					<?php echo $i;?>
					</option>
					<?php } ?>
					</select>
											
					</td>
					</tr>
					
					
					<tr>
					<td align="right" class="blackbold" valign="top">Select Additional Space<span class="red">*</span></td>
					<td align="left">
					<select class="inputbox" name="AdditionalSpace"
						id="AdditionalSpace"
						onchange="javascript:calculateprice(0);">
						<option selected="selected" value="0">select</option>
						<?php
						for($j=10; $j<=50000; $j+=10){?>
						<option value="<?php echo $j;?>">
						<?php echo $j;?>
						</option>
						<?php } ?>
	
					</select>

					</td>
					</tr>
					
					
					<tr>
					<td align="right" class="blackbold" valign="top">Select Space Unit <span class="red">*</span></td>
					<td align="left">
					<select class="inputbox" name="AdditionalSpaceUnit"
						id="AdditionalSpaceUnit"
						onchange="javascript:calculateprice(0);">
						<option value="GB">GB</option>
						<option value="TB">TB</option>
					</select>

					</td>
					</tr>
					
					
					<tr>
					<td align="right" class="blackbold" valign="top">Select Plan Duration<span class="red">*</span></td>
					<td align="left">
					<select class="inputbox" name="PlanDuration" id="PlanDuration" onchange="javascript:calculateprice(0);">
					<option selected="selected" value="user/month">user/month</option>
					<option value="user/year">user/year</option>
					</select>

					</td>
					</tr>
					
					<tr div id="CouponCd" style="display: none;">
					<td align="right" class="blackbold" valign="top">Coupon Code<span class="red">*</span></td>
					<td align="left">
						 <input id="CouponCode" name="CouponCode" maxlength="250" class="datebox" value="" type="text"> 
						 <input type="button" name="apply" value="Apply" id="btn1" onclick="calculateCoupon()" />

					</td>
					</tr>
					
					

					<tr>
				<div id="coupontext" style="padding-left:0%;"></div>
				<div id="pricetext"></div>
					</tr>
					
					
				<input type="hidden" name="FreeSpace" id="FreeSpace"
					value="<?php echo $arrayPkj[0]['space'];?>"> <input
					type="hidden" name="FreeSpaceUnit" id="FreeSpaceUnit"
					value="GB"> <input type="hidden" name="pack_id"
					id="pack_id" value="<?php echo $pack_id;?>"> <input
					type="hidden" name="Price" id="Price"
					value="<?php echo $arrayPkj[0]['price'];?>"> <input
					type="hidden" name="AdditionalSpacePrice"
					id="AdditionalSpacePrice"
					value="<?php echo $arrayPkj[0]['additional_spaceprice'];?>">
				<input type="hidden" name="Deduction" id="Deduction"
					value=<?php echo $Deduction;?>> <input type="hidden"
					name="DaysLeft" id="DaysLeft"
					value=<?php echo $DaysLeft;?>> <input type="hidden"
					name="Duration" id="Duration"
					value="<?php echo $arrayPkj[0]['duration'];?>"> <input
					type="hidden" name="TotalAmount" id="TotalAmount"
					value="0"> 
					
                <input type="hidden" name="cmp" id="cmp" value="<?php echo $_GET['cmp'];?>"> 
                <input type="hidden" name="CouponType" id="CouponType" value="0"> 
                 <input type="hidden" name="DiscountType" id="DiscountType" value="0"> 
                 <input type="hidden" name="NumUser" id="NumUser" value="0"> 
                 <input type="hidden" name="PlanType" id="PlanType" value="<?php echo $arrayPkj[0]['name'];?>"> 


				</table>
			</td>
		</tr>

		<tr>
			<td align="left" valign="top">&nbsp;</td>
		</tr>

		<tr>
			<td align="center">

				<div id="SubmitDiv" style="display: none1">

				<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Continue ';?>
					<input name="Submit" type="submit" class="button" id="SubmitButton"
						value=" <?=$ButtonTitle?> " /> <input type="hidden"
						name="LicenseID" id="LicenseID" value="<?=$_GET['edit']?>" />


				</div>
			</td>
		</tr>
	</form>
</table>
