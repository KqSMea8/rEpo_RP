<style>

td i{
    color: red;
}
.sycn-ul li {
  
    width: 13%;
}

.sycn-ul li label {
    display: inline-block;
    margin-right: 7px;
}

.sycn-ul li input {
    float: left;
    margin-right: 2px;
    margin-top: 2px;
}
.hide{
display:none;
}

</style>

<div class="had">Hostbill Setting</div>
<div class="message"><? if(!empty($_SESSION['mess_hostbill'])) {echo $_SESSION['mess_hostbill']; unset($_SESSION['mess_hostbill']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >	 
		 <td valign="top">
			<form action="" method="POST">
			<table width="100%" border="0" cellspacing="0" cellpadding="5" class="borderall">
				<tbody>
			 		<tr>
			          <td valign="top" align="right" class="blackbold">Api ID :<i>*</i></td>
			          <td align="left"> 
			         	 <input type="text" class="inputbox" name="id" value="<?php echo $hostbillConfig['api_id']?>"> <br/>          
			          	
			       		
			       	</td>
			        </tr>
			        	<tr>
			          <td valign="top" align="right" class="blackbold">Api Key :<i>*</i></td>
			          <td align="left"> 
			         	 <input type="text" class="inputbox" name="key" value="<?php echo $hostbillConfig['api_key']?>"> <br/>           
			          	
			       		
			       	</td>
			        </tr>
			        	<tr>
			          <td valign="top" align="right" class="blackbold">IP :<i>*</i></td>
			          <td align="left"> 
			         	 <input type="text" class="inputbox" name="ip" value="<?php echo $hostbillConfig['ip']?>"> <br/>           
			          	
			       		
			       	</td>
			        </tr>
			        <tr>
			          <td valign="top" align="right" class="blackbold">Hostbill Url :<i>*</i></td>
			          <td align="left"> 
			         	 <input type="text" class="inputbox" name="api_url" value="<?php echo $hostbillConfig['api_url']?>"> <br/>           
			          	
			       		
			       	</td>
			        </tr>
			        
			         <tr>
			          <td valign="top" align="right" class="blackbold">Synchronize Invoice :<i>*</i></td>
			          <td align="left"> 
			         	<ul class="sycn-ul">
			         		<li><label>All</label><input type="radio" name="sycnInvoice" value="all" <?php echo (empty($hostbillConfig['sycnInvoice']) || $hostbillConfig['sycnInvoice']=='all' )?'checked="checked"':'';?>></li>
			         		<li><label>From Date</label><input type="radio" name="sycnInvoice" value="fromdate" <?php echo ($hostbillConfig['sycnInvoice']=='fromdate' )?'checked="checked"':'';?>>
			         			
			         			<div class="date-div <?php echo ($hostbillConfig['sycnInvoice']=='fromdate' )?'':'hide';?>"><input type="text" class="datebox date-input " name="fromdate" value="<?php  echo $hostbillConfig['fromdate']; ?>"></div>
			         		</li>
			         		<li><label>Current Date</label><input type="radio" name="sycnInvoice" value="current" <?php echo ($hostbillConfig['sycnInvoice']=='current' )?'checked="checked"':'';?>></li>
			         	</ul>  
			       	</td>
			        </tr>
			        
			        <tr>
			          <td valign="top" align="right" class="blackbold"></td>
			          <td align="left"> 
			         	<input type="submit" class="button" value="Save" name="hostbillconfigsubmit">      
			         				         	
			         	<?php if(!empty($hostbillConfig['api_url']) AND !empty($hostbillConfig['ip']) AND !empty($hostbillConfig['api_key']) AND !empty($hostbillConfig['api_id'])){?>
			         		<input type="submit" class="button" value="Validate" name="checkapi">   
			         	<?php }?>
			       	</td>
			        </tr>
			         
				</tbody>
			</table>
			</form>
			</td>
			</tr>
		</td>
	</tr>
</table>
<script>
$(function() {

	jQuery('.sycn-ul li input[type="radio"]').change(function(){

if(jQuery(this).val()=='fromdate'){

	jQuery(this).siblings('.date-div').removeClass('hide');
}else{
jQuery('.date-div').addClass('hide');
	
}
		
	});
    $(".date-input").datepicker({
        showOn: "both",
        yearRange: '1996:2016',
        dateFormat: 'yy-mm-dd',
        maxDate: "D",
        minDate:"",
        changeMonth: true,
        changeYear: true

    });
});
</script>
