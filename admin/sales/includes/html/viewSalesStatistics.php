<script language="JavaScript1.2" type="text/javascript">

function ShowDateField(){	
	 if(document.getElementById("fby").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else if(document.getElementById("fby").value=='Month'){
	    document.getElementById("monthDiv").style.display = 'block';
		document.getElementById("yearDiv").style.display = 'block';
		document.getElementById("fromDiv").style.display = 'none';
		document.getElementById("toDiv").style.display = 'none';	
	 }else{
	   document.getElementById("monthDiv").style.display = 'none';
		document.getElementById("yearDiv").style.display = 'none';
		document.getElementById("fromDiv").style.display = 'block';
		document.getElementById("toDiv").style.display = 'block';	
	 }
}



function ValidateSearch(frm){	

	  /*if(document.getElementById("c").value == "")
	  {
		alert("Please Select Customer.");
		document.getElementById("c").focus();
		return false;
	  }*/

	if(document.getElementById("fby").value=='Year'){
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else if(document.getElementById("fby").value=='Month'){
		if(!ValidateForSelect(frm.m, "Month")){
			return false;	
		}
		if(!ValidateForSelect(frm.y, "Year")){
			return false;	
		}
	}else{
		if(!ValidateForSelect(frm.f, "From Date")){
			return false;	
		}
		if(!ValidateForSelect(frm.t, "To Date")){
			return false;	
		}

		if(frm.f.value>frm.t.value){
			alert("From Date should not be greater than To Date.");
			return false;	
		}

	}

	ShowHideLoader(1,'F');
	return true;	



	
}
</script>

<div class="had"><?=$ModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Customer :<br><select id="c" method="get" class="inputbox" name="c">
		         <option value="">--- All ---</option>
			     <?php foreach($arryCustomer as $customer){?>
				 <option value="<?=$customer['CustCode'];?>" <?php if($_REQUEST['c'] == $customer['CustCode']){echo "selected";}?>><?php echo $customer['FirstName']." ".$customer['LastName']; ?></option>
				<?php }?>
			</select>
		</td>
		
	   <td>&nbsp;</td>
		<td valign="bottom">
		Order Status :<br> <select name="st" class="textbox" id="st" style="width:100px;">
		<option value="">--- All ---</option>
		<option value="Open" <?  if($_GET['st'] == "Open"){echo "selected";}?>>Open</option>
		<option value="Completed" <?  if($_GET['st'] == "Completed"){echo "selected";}?>>Completed</option>
		<option value="Cancelled" <?  if($_GET['st'] == "Cancelled"){echo "selected";}?>>Cancelled</option>
		</select> 
		</td>
	   <td>&nbsp;</td>

		<td valign="bottom">
		  Filter By :<br> 
		  <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateField();">
					 <option value="Date" <?php  if($_GET['fby']=='Date'){echo "selected";}?>>Date Range</option>
					 <option value="Year" <?php  if($_GET['fby']=='Year'){echo "selected";}?>>Year</option>
					 <option value="Month" <?php  if($_GET['fby']=='Month'){echo "selected";}?>>Month</option>
		</select> 
		</td>
	   <td>&nbsp;</td>


		 <td valign="bottom">
		 <? if($_GET['f']>0) $FromDate = $_GET['f'];  ?>				
		<script type="text/javascript">
		$(function() {
			$('#f').datepicker(
				{
				showOn: "both",dateFormat: 'yy-mm-dd', 
				yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
				maxDate: "+0D", 
				changeMonth: true,
				changeYear: true

				}
			);
		});
		</script>
<div id="fromDiv" style="display:none">
From Date :<br> <input id="f" name="f" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" placeholder="From Date" > 
</div>

	</td> 

	 

		 <td valign="bottom">

		 <? if($_GET['t']>0) $ToDate = $_GET['t'];  ?>				
<script type="text/javascript">
$(function() {
	$('#t').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
		maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<div id="toDiv" style="display:none">
To Date :<br> <input id="t" name="t" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" placeholder="To Date">
</div>

<div id="monthDiv" style="display:none">
Month :<br>
<?=getMonths($_GET['m'],"m","textbox")?>
</div>





</td> 
  <td><div id="yearDiv" style="display:none">
Year :<br>
<?=getYears($_GET['y'],"y","textbox")?>
</div></td>

	  <td align="right" valign="bottom">   <input name="search" type="submit" class="search_button" value="Go"  />	  
	  <script>
	  ShowDateField();
	  </script>
	  
	  </td> 
 </tr>


</table>
 	</form>

	</td>
      </tr>	

	<tr>
		<td  valign="top">
			<?  if(!empty($_GET['fby'])){
			echo '<div class="bar_chart">';
			echo '<h2>'.$MainModuleName.'</h2>';
			echo '<img src="barStatistics.php?module=Order&f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&m='.$_GET['m'].'&y='.$_GET['y'].'&c='.$_GET['c'].'&st='.$_GET['st'].'" >';
			echo '</div>';
			}
			?>	
		</td>
	</tr>

</table>

