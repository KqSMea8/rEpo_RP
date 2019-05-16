<a href="<?=$RedirectUrl?>" class="back">Back</a>
<a href="<?=$EditUrl?>"  class="edit">Edit</a>

<div class="had">View Generated Salary &raquo; <span>
<?=$ModuleName?> Detail
</span>
</div>

<div  style="float:right"/>
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();">
<!--
<input type="button" class="dwn_button"  name="dwn" value="Download" onclick="Javascript:location.href='salary_pdf.php?view=<?=$_GET['view']?>';">
-->

</div>
<div id="prv_msg_div" style="display:none"><br><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	

	<? include("includes/html/box/salary_pay_view.php"); ?>
</div>
		
		
	   

