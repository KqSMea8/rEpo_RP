<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<script language="JavaScript1.2" type="text/javascript">

function GoState(){	

	var stateDisplay = $("#state_td").css('display');	 
	if(stateDisplay!='none'){
		if(document.getElementById("state_id") != null){
			document.getElementById("main_state_id").value = document.getElementById("state_id").value;
		}
		if(!ValidateForSelect(document.getElementById("main_state_id"), "State")){
			return false;
		}
	}
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
	location.href = 'vatCollection.php?country_id='+document.getElementById("country_id").value+'&state_id='+document.getElementById("main_state_id").value;
	return false;
}
</script>

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

<div class="had"> VAT Collection Report </div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_taxclass'])) {  echo stripslashes($_SESSION['mess_taxclass']);   unset($_SESSION['mess_taxclass']);} ?></div>
           


	</td>
      </tr>	
      
      <tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		
				<td valign="bottom"><b>Country :</b><br> 
 <?
$country_id = ($_GET['country_id']>0)?($_GET['country_id']):($arryCurrentLocation[0]['country_id']);
?>


	    	<select name="country_id"  id="country_id" class="inputbox"  onchange="Javascript: StateListSend(1);" >
	      <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
	      <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$country_id){echo "selected";}?>>
	      <?=$arryCountry[$i]['name']?>
	      </option>
	      <? } ?>
	    </select>
	    </td>
		<td>&nbsp;</td>
 
 	<td  valign="bottom"><b>State :</b><br> <span id="state_td"> </span></td>
   	<td>&nbsp;</td>
   
 
    <td>
    	<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $_GET['main_state_id']; ?>" />
    </td>
    

			<td valign="bottom">
				  Filter By :<br> 
				  <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateField();">
							 <option value="Date" <?  if($_GET['fby']=='Date'){echo "selected";}?>>Date Range</option>
							 <option value="Year" <?  if($_GET['fby']=='Year'){echo "selected";}?>>Year</option>
							 <option value="Month" <?  if($_GET['fby']=='Month'){echo "selected";}?>>Month</option>
				</select> 
			</td>
	  		<td>&nbsp;</td>


		 <td valign="bottom">
                			
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
From Date :<br> <input id="f" name="f" readonly="" class="datebox" value="<?=$_GET['f']?>"  type="text" placeholder="From Date" > 
</div>

	</td> 

		 <td valign="bottom">

                			
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
To Date :<br> <input id="t" name="t" readonly="" class="datebox" value="<?=$_GET['t']?>"  type="text" placeholder="To Date">
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

	  <td align="right" valign="bottom">  

 <input name="search" type="submit" class="search_button" value="Go"  />

	  <script>
	  ShowDateField();
	  StateListSend();
	  </script>

	  </td> 
 </tr>

</table>
 	</form>


	</td>
      </tr>
      
      <tr>
	<td align="right" valign="top">
		<? if($num>0){?>
		<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_vat_po_report.php?<?=$QueryString?>&module=Invoice';" />

		<? } ?>
	</td>
</tr>
      	<? if($num>0){?>
		<tr>
			<td align="right">
			<?		 
			echo $CurrencyInfo = str_replace("[Currency]",$Config['Currency'],CURRENCY_INFO);
			?>	 
			</td>
		</tr>
	<? } ?>
	 	
	<tr>
	  <td  valign="top"> 
   	 <? include_once("includes/html/box/vat_po_report_data.php"); ?>
	  
	</td>
	</tr>


	
                   <tr align="center">  <td  height="20" colspan="2" >Total VAT on Sales : &nbsp;<?php echo '<b>'.number_format($TotalsoAmnt,2).'<b>'; ?>     </td></tr>
                   
  <tr align="center">  <td  height="20" colspan="2" >Total VAT on Purchase : &nbsp;<?php echo '<b>'.number_format($TotalpoAmnt,2).'<b>'; ?>     </td></tr>
                   
              <tr align="center">  <td  height="20" colspan="2" ><b>Total VAT Collection: </b>&nbsp;<?php echo '<b>'.number_format($TotalOtherCollection,2).'<b>'; ?>     </td></tr>
              
</table>
