<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){
	
		if(document.getElementById("y").value==""){
			alert("Please Select Year.");
			document.getElementById("y").focus();
			return false;
		}
		if(document.getElementById("m").value==""){
			alert("Please Select Month.");
			document.getElementById("m").focus();
			return false;
		}
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';

	}	
</script>



<div class="had">Generate Salary Slip</div>

<div id="ListingRecords" style="height:500px;">

<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
 <form action="" method="get" name="form3" onSubmit="return ValidateSearch();">
	<tr>
		
		 <td><?=getYears($_GET['y'],"y","textbox")?></td>
			  
          <td><?=getMonths($_GET['m'],"m","textbox")?></td>
		 <td>
		 <input name="s" type="submit" class="search_button" value="Go"  />
		
		 </td> 
		
	</tr>
	</form>		

</table>

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Processing..............</div>
<div id="preview_div" >

<? if($ShowList == 1 && $num<=0){ ?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
	  <td class="redmsg" height="100" align="center">
		<?=NO_SALARY_FOR_SLIP?>
</td>
</tr>
</table>
<? } ?>
</div>

</div>

