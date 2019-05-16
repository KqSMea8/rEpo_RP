<?
$arryEmployment = $objEmployee->GetEmployment($EmpID);
?>

<script language="JavaScript1.2" type="text/javascript">
function validate_employment(frm){
	if( ValidateForSimpleBlank(frm.EmployerName, "Employer Name")
		&& ValidateForSimpleBlank(frm.Designation, "Designation")
		&& ValidateForSelect(frm.FromDate,"Duration From")
		){
			if( frm.ToDate.value!='' && frm.FromDate.value > frm.ToDate.value){
				alert("Duration From Date should not be greater than Duration To Date.");
				return false;	
			}
			$.fancybox.close();
			ShowHideLoader('1','P');
			return true;	
		}else{
			return false;	
		}	
}
</script>


<div class="right_box">

<? if (!empty($_SESSION['mess_employee'])) {?>
<div class="message" style="padding:20px;"  >
	<? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?>	
</div>
<? } ?>
<div align="right"><a class="add fancybox" href="#empl_form_div" onclick="Javascript:EmplDetail();">Add Employment Detail</a></div>
<br><br>
<div id="preview_div">
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="25%"  class="head1" >Employer</td>
      <td width="20%"  class="head1" >Designation</td>
      <td width="25%"   class="head1" align="center" >Duration</td>
       <td class="head1" >Job Profile</td>
        <td class="head1" align="center" >Action</td>
   </tr>
   
    <?php 
	
  if(sizeof($arryEmployment)>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployment as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
      <td><?=stripslashes($values["EmployerName"])?></td>
      <td><?=stripslashes($values["Designation"])?></td>
      <td align="center">
	  <? if($values["FromDate"]>0) echo date($Config['DateFormat'], strtotime($values["FromDate"])); ?>
	
	  <? if($values["ToDate"]>0) echo ' <br>To<br> '.date($Config['DateFormat'], strtotime($values["ToDate"])); ?>
	</td>
      <td><?=stripslashes($values["JobProfile"])?></td>
		 
      
      <td  align="center" class="head1_inner"  >
	  <a class="fancybox" href="#empl_form_div" onclick="Javascript:EmplDetail(<?=$values['employmentID']?>);"><?=$edit?></a>
	  
	<a href="<?=$ActionUrl?>&del_employment=<?=$values['employmentID']?>" onclick="return confirmDialog(this, 'Record')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
    <tr >
      <td  colspan="5" id="td_pager"> </td>
    </tr>
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  </table>
</div>





<? include("includes/html/box/employment_form.php"); ?>
</div>





