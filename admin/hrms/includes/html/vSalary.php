<? if($_GET['pop']!=1){ ?>
<a href="<?=$RedirectUrl?>" class="back">Back</a>
<a href="<?=$EditUrl?>"  class="edit">Edit</a>

<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();" style="float:right"/>

<div class="had">Employee Salary &raquo; <span>
View <?=$ModuleName?>
</span>
</div>
<? } ?>
<br />
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	
	<? include("includes/html/box/salary_view.php"); ?>
</div>
