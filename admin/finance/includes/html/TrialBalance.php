<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){	
		ShowHideLoader('1','L');
	}

	function SetDate(str){
		if(str == "A") {
		    	$(".specificdaterange").show();
		     	$(".monthlyyearly").hide();
		}else{
		    	$(".specificdaterange").hide();
		    	$(".monthlyyearly").show();
		}
	}
   
	function SetEquityAmount(NewEquityAmount){
		 
		$("#AccountTypeIDCredit3").html('<b>'+NewEquityAmount+'</b>');  //Equity  
	}
   

</script>

<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>

 
<input type="button" onclick="Javascript:window.location = 'export_trial_balance.php?<?=$QueryString?>';" value="Export To Excel" name="exp" class="export_button">
 





<?php if(!empty($num777)){?>
<a href="<?=$EmailUrl?>" target="_blank" class="fancybox fancybox.iframe email_button" style="float:right;margin-left:5px;">Email</a>

<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>


<?php }?>
<div class="had"><?=$MainModuleName?> Report</div>

<div class="message" align="center">
 
<? if(!empty($_SESSION['mess_report_email'])) {echo $_SESSION['mess_report_email']; unset($_SESSION['mess_report_email']); }?>
</div>


<table width="100%" border=0 align="center" cellpadding=0 cellspacing=0>
    <?php if($num > 0){?>
	<tr>
        <td align="left" valign="top">
         <form onsubmit="return ValidateSearch();" name="form3" method="get" action="">
	<table cellspacing="0" cellpadding="0" border="0" style="margin:0" id="search_table">
	<tbody>
            <tr>
 
             <td align="left" style="display:none5">
 <select id="TrType" class="textbox" name="TrType">
	<option value="B" <?php if ($_GET['TrType'] == "B") {
	echo "selected";
	} ?>>Beginning Balance</option>
	
	<option value="A" <?php if ($_GET['TrType'] == "A") {
	echo "selected";
	} ?>>Balance and Activity</option>
	<option value="E" <?php if ($_GET['TrType'] == "E") {
	echo "selected";
	} ?>>Ending Balance</option>
	 
</select>
             </td>
             
             <td>
                 
                 <table cellspacing="0" cellpadding="0" border="0" class="specificdaterange" style="display:none;">
                     <tr>
                         <td align="left">From:</td>
             <td align="left">
                     <?php
                     if(!empty($_GET['FromDate']) && $SpecificDate==1){
                      $FromDate = $_GET['FromDate'];
                     }
                     ?>
		<script type="text/javascript">
					$(function() {
						$('#FromDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#FromDate").on("click", function () { 
								 $(this).val("");
							}
						);
					});
					</script>
					<input id="FromDate" name="FromDate" readonly="" value="<?=$FromDate?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
		</td>
		
		 
		 <td align="left">To:</td>
                  <?php
                     if(!empty($_GET['ToDate']) && $SpecificDate==1){
                      $ToDate = $_GET['ToDate'];
                     }
                     
                     ?>
		 <td> <script type="text/javascript">
					$(function() {
						$('#ToDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#ToDate").on("click", function () { 
								 $(this).val("");
							}
						);

					});
					</script>
					<input id="ToDate" name="ToDate" readonly="" value="<?=$ToDate?>" class="inputbox" style="width: 120px;" type="text" maxlength="10" > 
                 </td>
                         
                     </tr>
                     
                 </table>

	<table cellspacing="0" cellpadding="0" border="0" class="monthlyyearly">
                <tr>
                    <td align="left"><?=getMonths($_GET['m'],"m","textbox")?></td>
                    <td align="left"><?=getYears($_GET['y'],"y","textbox")?></td>
               </tr>
        </table>


	<script language="JavaScript1.2" type="text/javascript">
	//SetDate('<?=$_GET["TransactionDate"]?>');
	</script>




                 
             </td>
        
             
                 <td>
		 <input type="submit" value="Go" class="search_button" name="s">
		 
		
		 </td>
	 
		
	</tr>
			

</tbody>
        </table>
                 </form>
	
		</td>
      </tr>
      <?php }?>
	 <tr>
             <td  valign="top">&nbsp;</td>
         </tr>
	<tr>
	  <td  valign="top">
	


<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
    <?php
	include_once("includes/html/box/trial_balance_data.php");
	?>
  </div> 

</td>
</tr>
</table>





