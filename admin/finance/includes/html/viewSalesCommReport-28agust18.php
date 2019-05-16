
<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>


<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){
	/*	
	if( //ValidateForSelect(frm.s, "Sales Person") 
		ValidateForSelect(frm.m, "Month") 
		&& ValidateForSelect(frm.y, "Year") 
	){
			
			ShowHideLoader(1,'F');
			return true;	
	}else{
		return false;	
	}*/

	if(frm.m.value !=''){
		if(!ValidateForSelect(frm.y, "Year") ){
			return false;	
		}
	}
	ShowHideLoader(1,'F');
	return true;	
	
}

 
function GetSalesPerson(str){
	ShowHideLoader(1,'F');
	location.href = "viewSalesCommReport.php?sp="+str;   	
}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_sale'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<? if($_GET['pop']!=1){ ?>	
<tr>
	  <td  valign="top">
	  
<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

			<tr>

	<? if($CommissionAp==1){ ?>
		<td valign="bottom">Sales Person Type:<br> <select name="sp" class="inputbox" onChange="Javascript: GetSalesPerson(this.value);" >
		  <option value="">--- Select Sales Person Type---</option>
					<option value="0" <?=($_GET["sp"]=='0')?("selected"):("")?>>Employees</option>
                    <option value="1" <?=($_GET["sp"]=='1')?("selected"):("")?>>Vendor</option>
				</select>
             </td>
	 <td>&nbsp;</td>
	<? } ?>

			<? if($_GET['sp']=="0" || $_GET['sp']=="1"){ ?>
		<td valign="bottom">
		Sales Person :<br> <select name="s" class="inputbox" id="s" >
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arrySalesPerson);$i++) {?>
		  <option value="<?=$arrySalesPerson[$i]['SalesPersonID']?>" <?  if($arrySalesPerson[$i]['SalesPersonID']==$_GET['s']){echo "selected";}?>>
		  <?=stripslashes($arrySalesPerson[$i]['SalesPerson'])?>
		  </option>
		  <? } ?>
		</select>

     <script>
$("#s").select2();
</script> 
		
		</td>
		
	   <td>&nbsp;</td>




		 <td valign="bottom">
			Month :<br>
			<?=getMonths($_GET['m'],"m","textbox")?>
		 </td> 



	   <td>&nbsp;</td>

		

		 <td valign="bottom">
			Year :<br>
			<?=getYears($_GET['y'],"y","textbox")?>
		 </td> 

<td align="right" valign="bottom">
		  <input name="sb" type="submit" class="search_button" value="Go"  /></td> 
			<? } ?>
 </tr>


</table>
 	</form>



	
	</td>
      </tr>	
	
	
	
	
	
	<? if($num>0){?>
	<tr>
        <td align="right" valign="bottom">
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_comm_report.php?<?=$QueryString?>';" />

<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		</td>
      </tr>
	 <? } ?>


<? } ?>


	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<? if(!empty($_GET['sb'])){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
		<td class="head1" >Sales Person</td>
		<td width="30%"  class="head1" align="center">Commission on Sales Amount [<?=$Config['Currency']?>]</td>
		<td width="30%" class="head1" align="center">Sales Commission [<?=$Config['Currency']?>]</td>
    </tr>
   
    <?php //echo $FromDate.' : '.$ToDate;
  if(is_array($arryPayment) && $num>0){
  	$flag=true;
	$Line=0; $TotalAmount=0;
	$EmpDivision = 5;
  	foreach($arryPayment as $key=>$values){
	$flag=!$flag;
	$Line++;
	
 
	if($_GET['sp']=='1') {
		$SuppID = $values['SalesPersonID'];		 	
	}else {
		$EmpID = $values['SalesPersonID'];
		 
	}

	if($values['CommOn']==1){
		include("../includes/html/box/commission_cal_per.php");
	}else if($values['CommOn']==2){
		include("../includes/html/box/commission_cal_margin.php");
	}else{
		include("../includes/html/box/commission_cal.php");
	}
  ?>
    <tr align="left" >
	<td height="20">
	 
<?php if($_GET['sp']=='1') { ?>
	<a class="fancybox fancybox.iframe" href="../vendorInfo.php?SuppID=<?=$values['SalesPersonID']?>" ><?=stripslashes($values["SalesPerson"])?></a>	
<?php } else { ?>
	<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['SalesPersonID']?>" ><?=stripslashes($values["SalesPerson"])?></a>
<?php } ?>
	
	</td>

	<td align="center"><strong><?=number_format($TotalSales,2,'.',',')?></strong></td>
	<td align="center">

	<? if($TotalCommission>0){?>
	<a class="fancybox fancybig fancybox.iframe" href="commReport.php?pop=1&s=<?=$values['SalesPersonID']?>&f=<?=$FromDate?>&t=<?=$ToDate?>&sp=<?=$_GET['sp']?>"><?=number_format($TotalCommission,2,'.',',')?></a>
	<? }else{?>
	<?=number_format($TotalCommission,2,'.',',')?>
	<? } ?>

	</td>

    
    </tr>
    <?php 
		
    } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  


 <tr >  <td  colspan="10"  id="td_pager">
<?php if($_GET['pop']!=1 && count($arryPayment)>0){?>
Total Record(s) : &nbsp;<?php echo $num;?>      
&nbsp;&nbsp;&nbsp;     
<?}?>
</td>
  </tr>


  </table>

 
<?

/*
if($TotalAmount>0){
	$EmpID = $_GET['s']; $EmpDivision = $arryEmp[0]['Division'];
	require_once("../includes/html/box/commission_cal.php");
	include("../includes/html/box/commission_view.php");
  }
*/



} 

?>

  </div> 
 

  
</form>
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 1000
		 });

});

</script>
