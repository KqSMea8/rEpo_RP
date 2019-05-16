<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){
		document.getElementById("emp").value = '';

		if(document.getElementById("EmpID") != null){
			if(document.getElementById("EmpValue").style.display != 'none'){
				document.getElementById("emp").value = document.getElementById("EmpID").value;
			}
		}
		/*
		if(document.getElementById("Department").value==""){
			alert("Please Select Department.");
			document.getElementById("Department").focus();
			return false;
		}*/
	
		if(document.getElementById("y").value==""){
			alert("Please Select Year.");
			document.getElementById("y").focus();
			return false;
		}
		if(document.getElementById("m").value==""){
			alert("Please Select Month.");
			document.getElementById("m").focus();
			return false;
		}
		ShowHideLoader(1,'L');
	}	
</script>












<div class="had">View <?=$MainModuleName?></div>


<div id="ListingRecords">


<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
 <form action="" method="get" name="form3" onSubmit="return ValidateSearch();">
	<tr>
		 <td align="left" >
		<select name="Department" class="textbox" id="Department" onChange="Javascript:EmpListSend('1','1');">
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
		  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$_GET['Department']){echo "selected";}?>>
		   <?=stripslashes($arrySubDepartment[$i]['Department'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		
		<td>
		<div id="EmpTitle"></div>
		<div id="EmpValue"></div> 	
		</td>
		
		 <td><?=getYears($_GET['y'],"y","textbox")?></td>
			  
          <td><?=getMonths($_GET['m'],"m","textbox")?></td>
		 <td>
		 <input name="s" type="submit" class="search_button" value="Go"  />
		<input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$_GET['emp']?>" />	
		<input type="hidden" name="emp" id="emp" value="<?=$_GET['emp']?>">
		
		 </td> 
		
	</tr>
	</form>		

</table>

<script language="javascript">
EmpListSend('1','');
</script>


<form action="" method="post" name="form1">

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">

 <tr>
		 <td><br><? if(!empty($_SESSION['mess_gen_salary'])) {echo '<div class="message" align="center">'.$_SESSION['mess_gen_salary'].'</div>'; unset($_SESSION['mess_gen_salary']); }?></td>
	</tr>
<? if($arryCurrentLocation[0]['country_id']==106){?>
 <!--tr>
        <td >
	<a href="http://www.incometaxindia.gov.in/Pages/tools/income-tax-calculator.aspx" class="grey_bt" target="_blank">Tax Calculator</a>

		</td>
 </tr-->
 <? } ?>
<tr>
        <td >
	

<a href="generateSalary.php?add=1<?=$UrlSuffixGen?>" class="add">Generate Salary</a>

 <? if($num>0){?>

<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_gen_salary.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

<? } ?>


<? if($_GET['key']!='') {?>
  <a href="viewGeneratedSalary.php" class="grey_bt">View All</a>
<? }?>
	
		
		</td>
 </tr>







<? if($num>0){?>

<tr>
		 <td class="had2" align="left">&nbsp;</td>
	</tr>

 <tr>
	  <td height="30">

<div class="had2" style="float:left;">Salary for the period of <?=date('F, Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'))?></div>

<input type="submit" name="Delete" class="button" style="float:right;" value="Delete" onclick="javascript: return ValidateMultiple('salary record','delete','NumField','payID');">

<input type="submit" name="PaymentStatus" class="button" style="float:right;margin-right:5px;" value="Mark as Paid" onclick="javascript: return ValidateMultiple('salary record','mark as paid','NumField','payID');">

	  </td>
 </tr>



 <? } ?>
 <tr>
	  <td  valign="top">

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($ShowList==1){ 
	
	$viewSal = str_replace("View","Salary Slip",$view);
	$viewSal = str_replace("40","60",$viewSal);
	
	
	?>
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <!--td width="5%" class="head1" >Year</td>
      <td width="8%" class="head1" >Month</td-->
       <td class="head1" >Employee</td>
       <td width="15%"  align="center" class="head1">GROSS (<?=$Config['Currency']?>)</td>
       <td width="15%"  align="center" class="head1">Net Salary (<?=$Config['Currency']?>)</td>
       <td width="19%"  align="center"  class="head1" >Current Salary (<?=$Config['Currency']?>)</td>
       <td width="9%"  align="center"  class="head1" >Payment</td>
       <td width="7%"  align="center"  class="head1 head1_action" >Action</td>
      <td width="4%"  align="center" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','payID','<?=sizeof($arrySalary)?>');" />
    </tr>
   
    <?php 
  if(is_array($arrySalary) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arrySalary as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >
      <!--td ><?=$values['Year']?></td>
      <td ><?=date('F', strtotime($values['Year'].'-'.$values['Month'].'-01'))?></td-->
      <td>
	<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>"><?=stripslashes($values['UserName'])?></a>	
	- <?=$values["EmpCode"]?> 
	<br><?=stripslashes($values["JobTitle"])?> - <?=stripslashes($values["Department"])?>
	
	</td>

	<td  align="center"><? if($values["Gross"]>0) echo number_format($values["Gross"]); ?></td>
	<td  align="center"><? if($values["NetSalary"]>0) echo number_format($values["NetSalary"]); ?></td>

    <td  align="center"><? if($values["CurrentSalary"]>0) echo number_format($values["CurrentSalary"]); ?></td>
      <td align="center"><? 
		 if($values['Status'] ==1){
			 #$status = 'Active'; $status_val = ' Paid ';
			  echo '<span class="green">Paid</a></span>';
		 }else{
			#$status = 'InActive'; $status_val = 'Pending';
			echo '<span class="red">Pending</a></span>';
			#echo '<br><a href="generateSalary.php?active_id='.$values["payID"].'&curP='.$_GET["curP"].$UrlSuffix.'" class="action_bt" onclick="return confirmAction(this, \'Approve\', \''.CONFIRM_SALARY_PAID.'\')"  >Change</a>';
		 }
	
	 

		
	 ?></td>

      <td  align="center" class="head1_inner">
<!--<a href="vPaySalary.php?view=<?=$values['payID']?>&curP=<?=$_GET['curP']?>&emp=<?=$_GET['emp']?>" ><?=$view?></a>-->
	  
<a class="fancybox sal fancybox.iframe" href="salarySlip.php?view=<?=$values['payID']?>" ><?=$viewSal?></a>	  
	  
<? if($values['Status'] !=1){?>	  
<a href="generateSalary.php?edit=<?=$values['payID']?>&curP=<?=$_GET['curP']?><?=$UrlSuffix?>" ><?=$edit?></a>
 <? } ?>

<!--a href="generateSalary.php?del_id=<?=$values['payID']?>&curP=<?=$_GET['curP']?><?=$UrlSuffix?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a-->   </td>


 <td align="center" class="head1_inner">
	  <input type="checkbox" name="payID[]" id="payID<?=$Line?>" value="<?=$values['payID']?>" />
	  
	  </td>


    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
  
<tr >  <td  colspan="9" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arrySalary)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
  </td>
  </tr>
  </table>
  <? } ?>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">

  <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">

</td>
</tr>
</table>

</form>

</div>





<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".sal, .grey_bt").fancybox({
			autoSize: false,
			width: 950,
			height: 900
	});

});

</script>
