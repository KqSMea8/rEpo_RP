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
function ValidateYear(frm){	
	document.getElementById("f").value="";
	document.getElementById("t").value="";

	if(document.getElementById("y").value==""){
		alert("Please Select Year.");
		document.getElementById("y").focus();
		return false;
	}else{	
		
		ShowHideLoader('1','P');
		return true;	
		/*
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';	
		var SendUrl = 'ajax.php?action=EmpturnoverBar&Year='+document.getElementById("y").value+'&r='+Math.random(); 
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function BarRecieve(){
			if (httpObj.readyState == 4) {
				document.getElementById("preview_div").innerHTML  = httpObj.responseText;
				document.getElementById("prv_msg_div").style.display = 'none';
				document.getElementById("preview_div").style.display = 'block';	
				document.getElementById("print_export").style.display = 'block';	
				
			}
		};
		httpObj.send(null);
		return false;
		*/
	}

}


function ValidateRange(frm){	
	document.getElementById("y").value="";

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
		/*
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';	

		var SendUrl = 'ajax.php?action=EmpturnoverRange&FromYear='+document.getElementById("f").value+'&ToYear='+document.getElementById("t").value+'&r='+Math.random(); 
	
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function BarRecieve2(){
			if (httpObj.readyState == 4) {
				document.getElementById("preview_div").innerHTML  = httpObj.responseText;
				document.getElementById("prv_msg_div").style.display = 'none';
				document.getElementById("preview_div").style.display = 'block';	
			}
		};
		httpObj.send(null);

		return false;
		*/
	}
}


</script>
<div class="had"><?=$MainModuleName?></div>



<div id="ListingRecords">



<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center" class="bar-search">

 <tr>
	  <td  valign="top">
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateYear(this);">
	 <table  border="0" cellpadding="3" cellspacing="0" id="search_table" style="margin:0" >
		<tr>
          <td>Year :</td>
          <td><?=getYears($_GET['y'],"y","textbox")?></td>
		 <td>
		 <input name="s" type="submit" class="search_button" value="Go"  />
		 </td> 
        </tr>
	</table>
 	</form>
</td>

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

<? if( !empty($_GET['y']) || (!empty($_GET['f']) && !empty($_GET['t']))){  ?>
<div id="print_export">
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_emp_turn.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
</div> 

<br>
<? } ?>
<div id="prv_msg_div" style="display:none"><img src="../images/load.gif"></div>
<div id="preview_div" style="padding-top:20px;" >



<? if( !empty($_GET['y']) || (!empty($_GET['f']) && !empty($_GET['t']))){ 
	
	

	if(!empty($_GET['y'])){
		$From = $_GET['y']; $To = $_GET['y'];
	}else if(!empty($_GET['f']) && !empty($_GET['t'])){ 
		$From = $_GET['f']; $To = $_GET['t'];
	}
	
?>
<table <?=$table_bg?>>
	<tr align="left"  >
	<td width="20%" class="head1" >Department</td>
	<?
	for($y=$From;$y<=$To;$y++){
		echo '<td align="center" class="head1" >'.$y.'</td>';
	}
	?>
	
	</tr>
    <? for($i=0;$i<sizeof($arrySubDepartment);$i++) { ?>
     
		<tr align="left">
		<td><?=$arrySubDepartment[$i]['Department']?></td>
		<?
		  
		for($y=$From;$y<=$To;$y++){
			 if(empty($TotalEmp[$y])) $TotalEmp[$y] ='0';

			$arryNumEmployee = $objEmployee->GetEmpByYear($arrySubDepartment[$i]['depID'],$y);
			$TotalEmp[$y] += $arryNumEmployee[0]['TotalEmployee'];
			echo '<td align="center" >'.$arryNumEmployee[0]['TotalEmployee'].'</td>';
		}
		?>

    <? } ?>
	 <tr >  
	 <td align="left" id="td_pager">Total : </td>
	 <?
	 for($y=$From;$y<=$To;$y++){
		echo '<td align="center" id="td_pager">'.$TotalEmp[$y].'</td>';
	 }
	 ?>
  </tr>
</table>
<? } ?>


<? if(!empty($_GET['y'])){ ?>
	<div class="report_chart" >
		<h2>Year: <?=$_GET['y']?></h2>
		
		<select name="event" id="event" class="chartselect" onchange="Javascript:showChart(this);" >
		<option value="bChart:pChart">Bar Chart</option>
		<option value="pChart:bChart">Pie Chart</option>
		</select>
		<div class="cb3"></div>
		<img id="bChart" src="barTurn.php?Year=<?=$_GET['y']?>" >
		<img id="pChart" src="pieTurn.php?Year=<?=$_GET['y']?>" style="display:none">	
			

	</div>
<? }else if(!empty($_GET['f']) && !empty($_GET['t'])){ ?>
		<div class="report_chart" >
		  <h2>Year: <?=$_GET['f'].' - '.$_GET['t']?></h2>
		  
		 <select name="event" id="event" class="chartselect" onchange="Javascript:showChart(this);" >
		<option value="bChart:pChart">Bar Chart</option>
		<option value="pChart:bChart">Pie Chart</option>
		</select>
		<div class="cb3"></div>
		<img id="bChart" src="barTurn.php?FromYear=<?=$_GET['f']?>&ToYear=<?=$_GET['t']?>" >
		<img id="pChart" src="pieTurn.php?FromYear=<?=$_GET['f']?>&ToYear=<?=$_GET['t']?>" style="display:none">




		</div>
<? } ?>

</div>











 </div>
  


</div>
