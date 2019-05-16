<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){	
	if( //ValidateForSelect(frm.s, "Sales Person") 
		ValidateForSelect(frm.m, "Month") 
		&& ValidateForSelect(frm.y, "Year") 
	){
			
			ShowHideLoader(1,'F');
			return true;	
	}else{
		return false;	
	}
	
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




		 <td valign="bottom">
			Month :<br>
			<?=getMonths($_GET['m'],"m","textbox")?>
		 </td> 



	   <td>&nbsp;</td>

		

		 <td valign="bottom">
			Year :<br>
			<?=getYears($_GET['y'],"y","textbox")?>
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
<? if(!empty($_GET['m']) && !empty($_GET['y'])){ ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
		<td class="head1" >Sales Person</td>
		<td width="30%"  class="head1" align="center">Total Sales Amount [<?=$Config['Currency']?>]</td>
		<td width="30%" class="head1" align="center">Sales Commission [<?=$Config['Currency']?>]</td>
    </tr>
   
    <?php 
  if(is_array($arryPayment) && $num>0){
  	$flag=true;
	$Line=0; $TotalAmount=0;
	$EmpDivision = 5;
  	foreach($arryPayment as $key=>$values){
	$flag=!$flag;
	$Line++;
	$EmpID = $values['SalesPersonID'];
	include("../includes/html/box/commission_cal.php");
  ?>
    <tr align="left" >
	 <td height="20">
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['SalesPersonID']?>" ><?=stripslashes($values["SalesPerson"])?></a>

</td>
              
     <td align="center"><?=number_format($TotalSales,2,'.',',')?></td>
     <td align="center"><?=number_format($TotalCommission,2,'.',',')?></td>

    
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

<br>
<?
if($TotalAmount>0){
/***************************
$EmpID = $_GET['s']; $EmpDivision = $arryEmp[0]['Division'];
require_once("../includes/html/box/commission_cal.php");
include("../includes/html/box/commission_view.php");
/***************************/
?>


<? }} ?>

  </div> 
 

  
</form>
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
