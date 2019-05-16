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

		var FromDate = document.getElementById("f").value;
		var ToDate = document.getElementById("t").value;
		if(ToDate!='' && FromDate!=''){

			FromDate = DefaultDateFormat(FromDate);
			ToDate = DefaultDateFormat(ToDate);

			if(ToDate < FromDate){ 
				alert("From Date should not be greater than To Date.");
				return false;	
			}
		}

	}

	ShowHideLoader(1,'F');
	return true;	



	
}
</script>
<script src="../js/jRate.min.js"></script> 
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
<tr>

	  <td  valign="top">
	  
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" width="45%">

		<tr>

		<td valign="bottom">
			
		</td>
		
	   <td>&nbsp;</td>


        <td valign="bottom">
	
		 
		</td>
		<td valign="bottom">
	
		 
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
		showOn: "both",dateFormat: '<?=$Config["DateFormatJS"]?>', 
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
		showOn: "both", dateFormat: '<?=$Config["DateFormatJS"]?>', 
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
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_Industry.php?<?= $QueryString ?>';" />

		</td>
      </tr>
	 <? } ?>

	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if(isset($ShowData) && $ShowData == 1){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
        <td width="25%"  class="head1" >Lead Name</td>
        <td width="20%" class="head1" >Lead Date</td>
        <td  class="head1" >Industry</td>
		<td  class="head1" align="center">Rating</td>
     
    </tr>
   
    <?php 
//echo "<pre>";print_r($arryLead);
  if(is_array($arryLead) && $num>0)
  {
  	$flag=true;
	$Line=0;
  	foreach($arryLead as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
       <td><a class="fancybox fancybox.iframe" href="vLead.php?pop=1&view=<?=$values['leadID']?>" ><?=$values['FirstName']?> <?=$values['LastName']?></a></td>
	   <td height="20">
	   <? if($values['LeadDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['LeadDate']));
		?>
	   
	   </td>
      <td><?=$values['Industry']?> </td>
      <td align="center">
         
   <script type="text/javascript">
		$(function () {
			
			var that = this;
			$("#jRate<?=$Line?>").jRate({
				rating: "<?=stripslashes($values['Rating'])?>",
				strokeColor: 'black',
				readOnly: true,
				width: 20,
				height: 20,
				precision: 0.1,
				minSelected: 0,
				isDisabled : true
				
				
			});
			
		});
	</script>


<div id="jRate<?=$Line?>" style="height:30px;width: 100px;"></div>

                          
	  </td>
     
     
    

  
    
    </tr>
    <?php } // foreach end //?>
  
    <?php }
    else
    {?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No Record Found.</td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryLead)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
<? } ?>

  </div> 
 



  
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
