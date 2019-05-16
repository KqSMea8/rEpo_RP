<script language="JavaScript1.2" type="text/javascript">

	
	function report(id){	     
          location.href = "viewCustomReport.php?CustomReport=" + id ;
          LoaderSearch();
	}	
	
	
	
</script>




<div class="had"><?=$MainModuleName?></div>
<div class="message"><? if(!empty($_SESSION['mess_att'])) {echo $_SESSION['mess_att']; unset($_SESSION['mess_att']); }?></div>


<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0">




 <tr>
	  <td  valign="top">

	  
	<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
	<form action="" method="get" name="topForm" >
	<tr>
		<td  colspan="2"  valign="top">
		 
	 <table border="0" cellpadding="3" cellspacing="0" >
	<tr>
		<td width="70" align="right">Report: </td>
		<td >
		<select class="inputbox" name="CustomReport" id="CustomReport" onchange="return  report(this.value);"><option value="">Select Report</option>
<? foreach($arryCustomReport as $report){

$sel = ($report['reportID'] == $_GET['CustomReport'])?("selected"):("");

echo '<option value="'.$report['reportID'].'" '.$sel.'>'.$report['title'].'</option>';
}?>


</select>

		</td>
	
	
		
		</tr>
	 </table>

	</td>
		</tr>
		</form>
		


	</table>  
	  

<div id="print_export" style="clear:both">


 <? if($num>0){ ?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_custom_att.php?<?=$QueryString?>';" />
		<!--input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/-->

<? } ?>

</div>  
 <div class="cb"></div>

<br>

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($ShowList==1){ ?>

 <? if($num>0){ ?>
 <br>
<form action="" method="get" name="reportForm" >
 <div class="cb"></div>

<!--input type="submit" name="DeleteButton" class="button" style="float:right;margin-bottom:5px;" value="Delete" onclick="javascript: return ValidateMultiple('attendance record','delete','NumField','attID');"-->
<? } ?>

<div style="overflow-x: auto; width:1080px">

<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable"  >
   
   <tr align="left"  >
		<? if(!empty($_GET['CustomReport'])){

		for ($j = 0; $j <= sizeof($reportHeader); $j++) {
			
			if($reportHeader[$j][0] != 'Date'){
				echo '<td class="head1" >'.$reportHeader[$j][0].'</td>';
                              }else{
				for($dat=0;$dat<count($arrYDate);$dat++){
				echo '<td class="head1">'.date("d/m/Y",strtotime($arrYDate[$dat])).' </td>';
				}
			}

		}
	      }

	?>

	</tr>

    <tr align="left"  >
<? 
if(!empty($_GET['CustomReport'])){
$numHead = Count($reportHeader);
$numHead = $numHead-1;
	for ($j = 0; $j <= sizeof($reportHeader); $j++) {
	
if($reportHeader[1][0] == 'Date'){
$numHead = $numHead-3;
}elseif($reportHeader[2][0] == 'Date'){
$numHead = $numHead-2;
}elseif($reportHeader[3][0] == 'Date'){
$numHead = $numHead-1;
}else{
$numHead = $numHead;
}
		if($reportHeader[$j][0] == 'Date'){
echo '<td class="head1" colspan="'.$numHead.'" > </td>';
			for($dat=0;$dat<count($arrYDate);$dat++){
				echo '<td class="head1">
					 <table width="170" align="center" cellpadding="0" cellspacing="1" >
						<tr align="left" class="'.$bgclass.'">
							<td>IN</td>
							<td>OUT</td>
<td>Dur.</td>
							
						</tr>
					  </table>
					</td>';
			}
			}

	}
 
 
  }

?>

    </tr>
   
    <?php $headNum = count($arrYDate)+ $numHead+1;
  if(sizeof($arrayList) >0){
	$flag=true;
	$Line=0; $TotalDuration = 0;

        
	foreach($arrayList as $key=>$values){
	$flag=!$flag;
	$Line++;
	$Duration = 0;
	/*if(!empty($values["InTime"]) && !empty($values["OutTime"])){
		$Duration = strtotime($values["OutTime"]) - strtotime($values["InTime"]);
		$TotalDuration += $Duration;
		if($Duration<0) $Duration=0;
		$Duration = time_diff($Duration);
		
	}*/

	$incolor = ''; $outcolor ='';
	/*
	if(!empty($values["InComment"])) $incolor = '#ffff11';
	if(!empty($values["OutComment"])) $outcolor = '#ffff11';
*/
		$bgclass = (!$flag)?("oddbg"):("evenbg");

  ?>




    <tr align="left" class="<?=$bgclass?>">
        

<? if(!empty($_GET['CustomReport'])){
$num = Count($reportHeader);

for ($i = 0; $i <= sizeof($reportHeader); $i++) {

	if($reportHeader[$i][1] == "UserName"){?>


		<td  >

		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><strong><?=$values['EmpName']?></strong></a> 


		</td>

	<?}elseif($reportHeader[$i][1] == "InTime"){?>
		<td>
		<? if(!empty($values[$reportHeader[$i][1]])){ echo $values[$reportHeader[$i][1]]; }?>
		</td>
	<? }elseif($reportHeader[$i][1] == "OutTime"){?>
		<td>
		<? if(!empty($values[$reportHeader[$i][1]])) { echo $values[$reportHeader[$i][1]]; }?>
		</td>
	<? }elseif($reportHeader[$i][1] == "breaks"){
		$arryBreak=$objTime->getAttPunching($values['attID'],'','');?>
<td ><table ><tr> 



 <td><? foreach($arryBreak as $key=>$values){?><b><?=$values["punchType"]?></b> - <? if(!empty($values["InTime"])) echo $values["InTime"]; ?> <strong>|</strong> <? if(!empty($values["OutTime"])) echo $values["OutTime"];?><br><? }?> </td></tr></table></td>
	     <? // echo '<td><a class="fancybox fancybig fancybox.iframe" href="vAttBreak.php?att='.$values['attID'].'&emp='.$values['EmpID'].'" >'.$view.'</a></td>';
	 }elseif($reportHeader[$i][1] == "Duration"){

		echo '<td>'.$Duration.'</td>';
	}elseif($reportHeader[$i][1] == "attDate"){?>

		<? for($dat2=0;$dat2<count($arrYDate);$dat2++){?> 
			<td>
	
				<table width="100%" align="center" cellpadding="0" cellspacing="1" id="myTable">
		
					<tr align="left" class="<?=$bgclass?>">
						<td><?=$values[$arrYDate[$dat2]]['Intime']?></td>
						<td><?=$values[$arrYDate[$dat2]]['OutTime']?></td>
                                                <td><?=$values[$arrYDate[$dat2]]['Duration']?></td>
						
					</tr>
				</table>


			</td>       
		<? }?>
	<?}else{
		echo '<td>'.$values[$reportHeader[$i][1]].'</td>';
}
}  }?>
    </tr>
	

    <?php 
	  $NewEmpID = $values['EmpID'];
  } // foreach end //?>
  
    <?php }else{?>
    <tr >
      <td  colspan="<?=$headNum?>" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 <tr >  <td  colspan="<?=$headNum?>" align="left" id="td_pager">
 
 
 
</td>
  </tr>
  </table>
  <? } ?>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?=$_GET['curP']?>">

  <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">


</form>

</td>
</tr>
</table>
</div>

</div>

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });

</script>

<? //include("includes/html/box/att_detail.php"); ?>
