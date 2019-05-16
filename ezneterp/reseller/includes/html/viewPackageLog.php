<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>

<div class="message" align="center">
<? if(!empty($_SESSION['mess_dash'])) {echo $_SESSION['mess_dash']; unset($_SESSION['mess_dash']); }?>
</div>

<div class="hadrs">Upgrade Packages</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<tr>
<td align="left" >
	<a href="cmpList.php?link=viewPackageLog.php" class="fancybox action_bt fancybox.iframe" class="action_bt">Select Company</a></td>
</tr>

<? if($CmpID>0){?>
<tr>
  <td  valign="top" align="left">

<table width="44%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="40%" > Company Name  : </td>
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


<? } ?>


</table>

<div class="tryNow" style="margin-left:18px;">
<a href="upgradePk.php?pack_id=7&cmp=<?php echo $CmpID;?>">STANDARD</a>
</div>

<div class="tryNow" style="margin-left:18px;">
<a href="upgradePk.php?pack_id=8&cmp=<?php echo $CmpID;?>">PROFESSIONAL</a>
</div>

<div class="tryNow" style="margin-left:18px;">
<a href="upgradePk.php?pack_id=9&cmp=<?php echo $CmpID;?>">ENTERPRISE</a>
</div>


