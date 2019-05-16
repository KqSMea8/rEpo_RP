<script language="JavaScript1.2" type="text/javascript">

function ShowDateField(){
	document.getElementById("monthDiv").style.display = 'none';
	document.getElementById("yearDiv").style.display = 'none';
	document.getElementById("fromDiv").style.display = 'none';
	document.getElementById("toDiv").style.display = 'none';	
	document.getElementById("keyDiv").style.display = 'none';

	 if(document.getElementById("FilterBy").value=='Year'){
		document.getElementById("yearDiv").style.display = 'block';				
	 }else if(document.getElementById("FilterBy").value=='Month'){
	    	document.getElementById("monthDiv").style.display = 'block';
		document.getElementById("yearDiv").style.display = 'block';		
	 }else if(document.getElementById("FilterBy").value=='Reference' || document.getElementById("FilterBy").value=='Source'  || document.getElementById("FilterBy").value=='Name'){	    	
		document.getElementById("keyDiv").style.display = 'block';	
	 }else{
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

	if(document.getElementById("FilterBy").value=='Year'){
		if(!ValidateForSelect(frm.Year, "Year")){
			return false;	
		}
	}else if(document.getElementById("FilterBy").value=='Month'){
		if(!ValidateForSelect(frm.Month, "Month")){
			return false;	
		}
		if(!ValidateForSelect(frm.Year, "Year")){
			return false;	
		}
	}else if(document.getElementById("FilterBy").value=='Reference' || document.getElementById("FilterBy").value=='Source'  || document.getElementById("FilterBy").value=='Name'){	    		
		if(!ValidateForSimpleBlank(frm.key, "Search Keyword")){
			return false;	
		}	 
	 
	}else{
		if(!ValidateForSelect(frm.FromDate, "From Date")){
			return false;	
		}
		if(!ValidateForSelect(frm.ToDate, "To Date")){
			return false;	
		}

		if(frm.FromDate.value>frm.ToDate.value){
			alert("From Date should not be greater than To Date.");
			return false;	
		}

		var NumDay =  DateDiff(frm.FromDate.value,frm.ToDate.value);
		if(NumDay>92){
			alert("Please select 3 months duration.");
			return false;
		}	

	}

	ShowHideLoader(1,'F');
	return true;	



	
}
</script>

<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Sale'])) {echo $_SESSION['mess_Sale']; unset($_SESSION['mess_Sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
	
	

		<td valign="bottom">
		  Filter By :<br> 
		  <select name="FilterBy" class="textbox" id="FilterBy" style="width:120px;" onChange="Javascript:ShowDateField();">
					 <option value="Date" <?  if($_GET['FilterBy']=='Date'){echo "selected";}?>>Date Range</option>
					 <!--option value="Year" <?  if($_GET['FilterBy']=='Year'){echo "selected";}?>>Year</option-->
					 <option value="Month" <?  if($_GET['FilterBy']=='Month'){echo "selected";}?>>Month</option>
			 <option value="Source" <?  if($_GET['FilterBy']=='Source'){echo "selected";}?>>Source</option>
			 <option value="Reference" <?  if($_GET['FilterBy']=='Reference'){echo "selected";}?>>Reference No</option>
			 <option value="Name" <?  if($_GET['FilterBy']=='Name'){echo "selected";}?>>Name</option>
		</select> 
		</td>
	   <td>&nbsp;</td>


		 <td valign="bottom">
                		
		<script type="text/javascript">
		$(function() {
			$('#FromDate').datepicker(
				{
				showOn: "both",dateFormat: 'yy-mm-dd', 
				yearRange: '<?=date("Y")-20?>:<?=date("Y")+1?>', 
				 
				changeMonth: true,
				changeYear: true

				}
			);
		});
		</script>
<div id="fromDiv" style="display:none">
From Date :<br> <input id="FromDate" name="FromDate" readonly="" class="datebox" value="<?=$_GET['FromDate']?>"  type="text" placeholder="From Date" > 
</div>

	</td> 

	 

		 <td valign="bottom">

               		
<script type="text/javascript">
$(function() {
	$('#ToDate').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+1?>', 
		 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<div id="toDiv" style="display:none">
To Date :<br> <input id="ToDate" name="ToDate" readonly="" class="datebox" value="<?=$_GET['ToDate']?>"  type="text" placeholder="To Date">
</div>

<div id="monthDiv" style="display:none">
Month :<br>
<?=getMonths($_GET['Month'],"Month","textbox")?>
</div>

<div id="keyDiv" style="display:none">
<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">
</div>

</td> 
  <td><div id="yearDiv" style="display:none">
Year :<br>
<?=getYears($_GET['Year'],"Year","textbox")?>
</div></td>


<? if(sizeof($CurrencyArray)>1){ ?>
	<td>
		Currency :<br>

		<select name="Currency" class="inputbox" id="Currency" style="width:70px">		
		<?	
		foreach($CurrencyArray as $Currency){ 
		$sel = ($_GET['Currency']==$Currency)?("selected"):("");
		echo '<option value="'.$Currency.'" '.$sel.'>'.$Currency.'</option>';				
		}
		?>
		</select> 

		<script>
		$("#Currency").select2();
		</script> 
	</td>
<? } ?>




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
        <td align="right" valign="top">
		
	    <? if($num>0){?>

<ul class="export_menu">
	<li><a class="hide" href="#">Export Accounts</a>
	<ul>
		<li class="excel" ><a href="export_gl_report.php?<?=$QueryString?>" ><?=EXPORT_EXCEL?></a></li>
		 
	</ul>
	</li>
</ul>


	      <input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/> 
	    <? } ?>


		</td>
      </tr>
	 	  
	<tr>
	  <td  valign="top">
	
 		  <? include_once("includes/html/box/gl_report_data.php"); ?>
</td>
</tr>

</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".po").fancybox({
			'width'         : 900
		 });

});

</script>
