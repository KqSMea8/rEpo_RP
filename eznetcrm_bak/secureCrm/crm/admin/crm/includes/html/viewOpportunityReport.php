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
   /* if(!ValidateForSelect(frm.w, "Warehouse")){
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
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>

		<!--<td valign="bottom">
		Lead :<br> <select name="w" class="inputbox" id="w" >
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arryLeadValue);$i++) {?>
		  <option value="<?=$arryLeadValue[$i]['leadID']?>" <?  if($arryLeadValue[$i]['leadID']==$_GET['w']){echo "selected";}?>>
		  <?=stripslashes($arryLeadValue[$i]['FirstName'])?> <?=stripslashes($arryLeadValue[$i]['LastName'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>-->
		<td valign="bottom">
	
		  Opportunity Sales Stage :<br> <select name="lso" class="textbox" id="lso" style="width:100px;" >
		<option value="">--- All ---</option>
		<? for($i=0;$i<sizeof($arrySalesStage);$i++) {?>
			<option value="<?=$arrySalesStage[$i]['attribute_value']?>" <?  if($arrySalesStage[$i]['attribute_value']==$_GET['lso']){echo "selected";}?>>
			<?=$arrySalesStage[$i]['attribute_value']?>
			</option>
		<? } ?>
			
	</select>
		</td>
	   <td>&nbsp;</td>


        <td valign="bottom">
	
		   Source :<br> <select name="lst" class="textbox" id="lst" style="width:100px;">
					<option value="">--- All ---</option>
		<? for($i=0;$i<sizeof($arryLeadSource);$i++) {?>
			<option value="<?=$arryLeadSource[$i]['attribute_value']?>" <?  if($arryLeadSource[$i]['attribute_value']==$_GET['lso']){echo "selected";}?>>
			<?=$arryLeadSource[$i]['attribute_value']?>
			</option>
		<? } ?>
		</select> 
		</td>
		
	   <td>&nbsp;</td>

		<td valign="bottom">
		  Filter By :<br> 
		  <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateField();">
					 <option value="Date" <?  if($_GET['fby']=='Date'){echo "selected";}?>>Date Range</option>
					 <option value="Year" <?  if($_GET['fby']=='Year'){echo "selected";}?>>Year</option>
					 
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

	   <td>&nbsp;</td>

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







	  <td align="right" valign="bottom"> <input name="sb" type="submit" class="search_button" value="Go"  />
	  
	  <script>
	  ShowDateField();
	  </script>
	  
	  </td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	
	
	
	
	
	<? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">
<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_adj_report.php?<?=$QueryString?>';" -->
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		</td>
      </tr>
	 <? } ?>

	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if($ShowData == 1){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
        <td width="14%"  class="head1" >Opportunity Number</td>
        <td width="15%" class="head1" >Opportunity Date</td>
        <td width="15%"  class="head1" >Opportunity Name</td>
		
   <td width="15%" class="head1" > Source </td>
     <td width="15%"   class="head1" >Sales Stage</td>
       
    </tr>
   
    <?php 

	
  if(is_array($arryOpportunity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryOpportunity as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
       <td><a class="fancybox fancybox.iframe" href="vOpportunity.php?pop=1&view=<?=$values['OpportunityID']?>" ><?=$values["OpportunityID"]?></a></td>
	   <td height="20">
	   <? if($values['AddedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['AddedDate']));
		?>
	   
	   </td>
      <td><a class="fancybox fancybox.iframe" href="vOpportunity.php?pop=1&view=<?=$values['OpportunityID']?>" ><?=$values['OpportunityName']?></a></td>
	 
     
       <td ><?=$values['lead_source']?>  </td>
     <td><?=stripslashes($values["SalesStage"])?></td> 
    

  
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record">No Record Found.</td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryOpportunity)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
<? } ?>

  </div> 
 

<?  if($num>0){
	echo '<div class="bar_chart" >';
	echo '<h2>'.$MainModuleName.'</h2>';
	echo '<img src="barOpportunity.php?f='.$_GET['f'].'&t='.$_GET['t'].'&fby='.$_GET['fby'].'&y='.$_GET['y'].'&w='.$_GET['w'].'&lso='.$_GET['lso'].'&lst='.$_GET['lst'].'" >';
	echo '</div>';
}
?>

  
</form>
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>