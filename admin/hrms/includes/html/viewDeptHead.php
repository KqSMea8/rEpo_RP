<a href="viewEmployee.php" class="back">Back</a>

<div class="had">
Manage Employee    <span>&raquo; Departmental Head </span>
		
</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_head'])) {echo $_SESSION['mess_head']; unset($_SESSION['mess_head']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
 <td  valign="top">

<div id="ListingRecords">
 
<form action="" method="post" name="form1">
<div id="piGal">
<table <?=$table_bg?> >
   
    <tr align="left"  >
      <td width="45%" class="head1" >Department</td>
       <td width="45%"  class="head1" >Departmental Head</td>
      <td align="center" class="head1" >Edit</td>
    </tr>
   
    <?php 
  if(is_array($arryDepartmentHead) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryDepartmentHead as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left" >
      <td><?=$values["Department"]?></td>
      <td>
	  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=stripslashes($values['UserName'])?></a>	 
	  
	  
	  </td>
      <td  align="center"  ><a class="fancybox" href="#dept_head_form" onclick="Javascript:GetDeptHeadForm('<?=$values["depID"]?>','<?=$values["Department"]?>','<?=$values['EmpID']?>');" ><?=$edit?></a></td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="4" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  

  </table>
  </div>
  
 
</form>

<?  include("includes/html/box/dept_head_form.php"); ?>
</div>	
</td>
</tr>
</table>