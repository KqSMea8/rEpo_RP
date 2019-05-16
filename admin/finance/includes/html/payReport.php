<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){	
	if( ValidateForSelect(frm.f, "From Date") 
		&& ValidateForSelect(frm.t, "To Date") 
	){
			if(frm.f.value>frm.t.value){
				alert("From Date should not be greater than To Date.");
				return false;	
			}
			ShowHideLoader(1,'F');
			return true;	
	}else{
		return false;	
	}
	
}
</script>
<div class="had"><?=$MainModuleName?> [ <?=$arryPayment[0]['SalesPerson']?> ]</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_sale'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<? if($_GET['pop']!=1){ ?>	
<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		<td valign="bottom">
		Sales Person :<br> <select name="s" class="inputbox" id="s" >
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
		  <option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$_GET['s']){echo "selected";}?>>
		  <?=stripslashes($arryEmployee[$i]['UserName'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		
	   <td>&nbsp;</td>




		 <td valign="bottom"><? if($_GET['f']>0) $FromDate = $_GET['f'];  ?>				
<script type="text/javascript">
$(function() {
	$('#f').datepicker(
		{
		showOn: "both",dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+1?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
From Date :<br> <input id="f" name="f" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" placeholder="From Date" > 
	</td> 



	   <td>&nbsp;</td>

		

		 <td valign="bottom"><? if($_GET['t']>0) $ToDate = $_GET['t'];  ?>				
<script type="text/javascript">
$(function() {
	$('#t').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")+1?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
To Date :<br> <input id="t" name="t" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" placeholder="To Date">
</td> 


	  <td align="right" valign="bottom"> <input name="sb" type="submit" class="search_button" value="Go"  /></td> 
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	
	
	
	
	
	<? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_pay_report.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		</td>
      </tr>
	 <? } ?>


<? } ?>

      
      
      <? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_comm_det_report.php?<?=$QueryString?>';" />
		</td>
      </tr>
	 <? } ?>


	<tr>
		<td  valign="top">
		<? if(!empty($_GET['sb'])){
			include_once("includes/html/box/pay_report_data.php");  
		}
		?>
		</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>
