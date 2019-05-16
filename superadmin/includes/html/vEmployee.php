<script language="JavaScript1.2" type="text/javascript">

function ShowPermission(){
	if(document.getElementById("Role").value=='Admin'){
		document.getElementById('PermissionTitle').style.display = 'block'; 
		document.getElementById('PermissionValue').style.display = 'block'; 
	}else{
		document.getElementById('PermissionTitle').style.display = 'none'; 
		document.getElementById('PermissionValue').style.display = 'none'; 
	}
}
</script>

<a class="back" href="<?=$RedirectURL."&cmp=" . $_GET['cmp']?>">Back</a>

<!-- 
 <a href="<?=$EditUrl?>" class="edit">Edit</a> 

 -->
<div class="had">User Info</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
<td align="left" >
	<a href="cmpList.php?link=viewEmployee.php" class="fancybox action_bt fancybox.iframe" class="action_bt">Select Company</a></td>
</tr>


<? if($CmpID>0){?>
<tr>
  <td  valign="top" align="left">

<table width="30%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="30%" > Company Name  : </td>
        <td   align="left" >
<strong><?php echo stripslashes($arryCompany[0]['CompanyName']); ?></strong>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Company ID  :</td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['CmpID']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Display Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>
           </td>
      </tr>
<tr>
	 <td  align="right">Email : </td>
 <td  align="left">
<?php echo $arryCompany[0]['Email']; ?>
</td>
</tr>
</table>

</td>
</tr>

<? }  ?>

</table>


<div class="had"><?//=$MainModuleName?>   <?php /*<span> &raquo;
	<? 	//echo $SubHeading; ?>
		</span>
		*/?>
</div>



<? include("includes/html/box/employee_view.php");

/*
if (!empty($_GET['view'])) {
	if($_GET["tab"]=="sales"){
		include("../includes/html/box/commission_view.php");
	}else if($_GET["tab"]=="territory"){
		include("../includes/html/box/territory_view.php");
	}else{
		include("includes/html/box/employee_view.php");
	}
}
*/

?>

