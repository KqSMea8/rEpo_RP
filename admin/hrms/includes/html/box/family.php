<?
$arryFamily = $objEmployee->GetFamily($EmpID);
?>

<script language="JavaScript1.2" type="text/javascript">
function validate_family(frm){
	if( ValidateForSimpleBlank(frm.Name, "Relative Name")
		&& ValidateForSimpleBlank(frm.Relation, "Relation")
		//&& ValidateForSimpleBlank(frm.Age,"Age")
		){
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
<div align="right"><a class="add fancybox" href="#family_form_div" onclick="Javascript:FamilyDetail();">Add Family Detail</a></div>
<br><br>
<div id="preview_div" >
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="25%"  class="head1" >Relative Name</td>
      <td width="20%"  class="head1" >Relation</td>
      <td width="25%"   class="head1" >Age</td>
       <td class="head1" >Dependent</td>
        <td class="head1" align="center" >Action</td>
   </tr>
   
    <?php 
	
  if(sizeof($arryFamily)>0){
  	$flag=true;
	$Line=0;
  	foreach($arryFamily as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left"  >
      <td><?=stripslashes($values["Name"])?></td>
      <td><?=stripslashes($values["Relation"])?></td>
      <td><?=stripslashes($values["Age"])?></td>
      <td><?=stripslashes($values["Dependent"])?></td>
		 
      
      <td  align="center" class="head1_inner"  >
	  <a class="fancybox" href="#family_form_div" onclick="Javascript:FamilyDetail(<?=$values['familyID']?>);"><?=$edit?></a>
	  
	<a href="<?=$ActionUrl?>&del_family=<?=$values['familyID']?>" onclick="return confirmDialog(this, 'Record')"  ><?=$delete?></a>   </td>
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





<? include("includes/html/box/family_form.php"); ?>
</div>





