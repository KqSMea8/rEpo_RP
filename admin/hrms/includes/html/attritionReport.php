<script language="javascript">
$(document).ready(function() {
	$("#y").change(function(){
		$("#preview_div").hide();
		$(".print_button").hide();
		$(".export_button").hide();
		
	});
	$("#f").change(function(){
		$("#preview_div").hide();
		$(".print_button").hide();
		$(".export_button").hide();
	});
	$("#t").change(function(){
		$("#preview_div").hide();
		$(".print_button").hide();
		$(".export_button").hide();
	});
});
</script>

<script language="JavaScript1.2" type="text/javascript">

function ValidateRange(frm){	
	if(document.getElementById("f").value==""){
		alert("Please Select From Year.");
		document.getElementById("f").focus();
		return false;
	}else if(document.getElementById("t").value==""){
		alert("Please Select To Year.");
		document.getElementById("t").focus();
		return false;
	}else{

		if(document.getElementById("t").value<=document.getElementById("f").value){
			alert("To Year should be greater than From Year.");
			return false;
		}

		ShowHideLoader('1','P');
		return true;	
		
	}
}


</script>
<div class="had"><?=$MainModuleName?></div>



<div id="ListingRecords">



<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center" class="bar-search">

 <tr>

<td  valign="top">
	<form action="" method="get" enctype="multipart/form-data" name="form3" onSubmit="return ValidateRange(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >
		<tr>
          <td>From Year :</td><td><?=getYears($_GET['f'],"f","textbox")?></td>
		  <td>&nbsp;</td>
          <td>To Year :</td><td><?=getYears($_GET['t'],"t","textbox")?></td>
		 <td>
		 <input name="s2" type="submit" class="search_button" value="Go"  />
		 </td> 
        </tr>
	</table>
 	</form>
</td>


</tr>
</table>

<? if(!empty($_GET['f']) && !empty($_GET['t'])){  ?>
<div id="print_export">
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_attrition.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
</div> 

<br>
<? } ?>
<div id="prv_msg_div" style="display:none"><img src="../images/load.gif"></div>
<div id="preview_div" style="padding-top:20px;" >



<? if(!empty($_GET['f']) && !empty($_GET['t'])){	
	
	$From = $_GET['f']; $To = $_GET['t'];
	
?>
<table <?=$table_bg?>>
	<tr align="left"  >
	<td width="20%" class="head1" >Year</td>
	<td width="20%" class="head1" >Attrition Ratio</td>
	
	
	</tr>
    <? 
	/*
	Opening Balance: OB
	Resignations: R
	New Joinings: NJ
	ATTRITION % = [(R) / (OB + NJ)] * 100
	*/
	for($y=$From;$y<=$To;$y++){
		$PrevY = $y-1;
		/*$arryOpeningBalance = $objEmployee->GetEmpByYear('',$PrevY);
		$OpeningBalance = $arryOpeningBalance[0]['TotalEmployee'];*/

		$arryTotalEmployee = $objEmployee->GetEmpByYear('',$y);
		$TotalEmployee = $arryTotalEmployee[0]['TotalEmployee'];

		$arryResignation = $objEmployee->GetResignation('',$y);
		$TotalResignation = $arryResignation[0]['TotalEmployee'];
		
		if($TotalResignation>=0 && $TotalEmployee>0){
			$Attrition = ($TotalResignation / $TotalEmployee) * 100;
		}
		$Attrition = round($Attrition,2);
	?>
     
		<tr align="left">
		<td><? echo $y; ?></td>
		<td><?=$Attrition?> %</td>
	
    <? } ?>
	 <tr >  
	 <td align="left" id="td_pager" colspan="2"> </td>
	
  </tr>
</table>


		<div class="report_chart" >
		  <h2>Year: <?=$_GET['f'].' - '.$_GET['t']?></h2>
		  <img src="barAttrition.php?FromYear=<?=$_GET['f']?>&ToYear=<?=$_GET['t']?>" >
		</div>
<? } ?>

</div>











 </div>
  


</div>
