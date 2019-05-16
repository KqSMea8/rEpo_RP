<script language="JavaScript1.2" type="text/javascript">	
function ShowReport(){	 
	if(document.getElementById("CustomReport").value==""){
		alert("Please Select Custom Report.");
		document.getElementById("CustomReport").focus();
		return false;
	}

	var redUrl = "viewCustomReport.php?CustomReport="+document.getElementById("CustomReport").value;
	if(document.getElementById("shiftID") != null){
		if(document.getElementById("shiftID").value==""){
			alert("Please Select Work Shift.");
			document.getElementById("shiftID").focus();
			return false;
		}

		redUrl += "&shiftID="+document.getElementById("shiftID").value;
	}   
	location.href = redUrl;
	LoaderSearch();
}	
</script>
<? if($_GET['CustomReport']>0){ ?>
<a href="viewPayrollReport.php" class="back">Back</a>
<?}?>


<div class="had"><?=$MainModuleName?></div>
<div id="ListingRecords">

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
<tr>
<td  valign="top">

	

  
<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
<tr>
<td  colspan="2"  valign="top">

<form action="" method="get" name="topForm" onSubmit="return  ShowReport();">
<table border="0" cellpadding="3" cellspacing="0" >
<tr>
	<td width="40" align="right">Report : </td>
	<td >
	<select class="inputbox" name="CustomReport" id="CustomReport" ><option value="">Select Report</option>
	<? foreach($arryCustomReport as $report){

	$sel = ($report['reportID'] == $_GET['CustomReport'])?("selected"):("");

	echo '<option value="'.$report['reportID'].'" '.$sel.'>'.$report['title'].'</option>';
	}?>
	</select>
	</td>

<? if(!empty($arryShift)){?>
	<td  align="right"  width="70">Work Shift :</td>
	<td align="left">
	<select name="shiftID" class="inputbox" id="shiftID">
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryShift);$i++) {?>
	<option value="<?=$arryShift[$i]['shiftID']?>" <?  if($arryShift[$i]['shiftID']==$_GET['shiftID']){echo "selected";}?>>
	<?=stripslashes($arryShift[$i]['shiftName'])?>
	</option>
	<? } ?>
	</select> </td>
<? } ?>

	<td align="left"><input name="s2" type="submit" class="search_button" value="Go"  /></td>

   </tr>
</table>
</form>	



	</td>
     </tr>
</table>  
  

<? if($num>0 && $_GET['CustomReport']>0){ ?>
	<div id="print_export" style="clear:both"><input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_payroll_report.php?<?=$QueryString?>';" /></div> 
	<div class="cb"></div>	
<? } ?>
 


<? if(!empty($_GET['CustomReport'])){ ?>
	<script language="javascript" src="<?=$Prefix?>includes/jquery.doubleScroll.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.double-scroll').doubleScroll();
		var ScrollWidth=  $("#inner_mid").width();

		$('.double-scroll').width(ScrollWidth+'px');
		$('.suwala-doubleScroll-scroll-wrapper').width(ScrollWidth+'px');

	});
	</script>

	<div class="double-scroll" style="width:1100px;min-height:500px;">
	<? 
	include_once("includes/html/box/custom_report_data.php"); 
	?>
	</div>
<? } ?>

</td>
</tr>
</table>
</div>


<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });

</script>



<style>
.evenbg:hover,.oddbg:hover,.itembg:hover{  background-color: #CCCCFF;}
#punchTable{border:1px solid #e1e1e1;}
#punchTable td{border-right:1px solid #d1d1d1;}
#punchTable td:last-child{border-right:none}


.double-scroll table tr.RowFirst td.ColFirst {
    display: table;
    line-height: 25px;
    position: absolute;
   width:150px;
}

.double-scroll table tr.oddbg td.ColFirst, .double-scroll table tr.evenbg td.ColFirst {
    display: table;
    line-height: 30px;
   width:150px; 
}

.double-scroll table tr.oddbg td.ColFirst a, .double-scroll table tr.evenbg td.ColFirst a{
    position: absolute;
    background:#fff;
    padding:0 5px;
}
</style>


