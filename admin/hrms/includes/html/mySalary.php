<? if(empty($ErrorMsg)){ ?> 
<a href="genSalarySlip.php" class="fancybox sal action_bt fancybox.iframe" style="float:right;margin-left:5px;">Generate Salary Slip</a>
<a href="#request_salary_slip" class="fancybox action_bt" onclick="Javascript:ResetForm();" style="float:right">Request for Salary Slip</a>
<? } ?>


<div class="had">Salary Details</div>

<? if(!empty($ErrorMsg)){ ?> 
	  <div align="center" id="ErrorMsg" class="redmsg">
	  <br><?=$ErrorMsg?>
	  </div>
<? }else{ ?> 
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();" style="float:right"/>
<br /><br />
<? include("includes/html/box/salary_view.php"); 
}
?>

<? include("includes/html/box/request_salary_slip.php"); ?>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".sal").fancybox({
			'width'         : 900
		 });

});

</script>
