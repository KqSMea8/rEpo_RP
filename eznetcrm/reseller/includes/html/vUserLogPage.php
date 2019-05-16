
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
<div class="had">Page History</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


<? if($CmpID>0){?>
<tr>
  <td  valign="top" align="left">
	<? if($arryLog[0]['loginID']>0){ ?>
	<table width="50%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;background:#fff">
  <tr>
        <td  align="right"   class="blackbold" width="30%" > User Name : </td>
        <td   align="left" >
<strong><?=($arryLog[0]['UserType']=='employee')?($arryLog[0]["UserName"]):(ADMINISTRATOR)?></strong>


           </td>
      </tr>
	<tr>
		 <td  align="right">Email : </td>
	 <td  align="left"><?=($arryLog[0]['UserType']=='employee')?($arryLog[0]["Email"]):($arryCompany[0]['Email'])?>

	</td>
	</tr>

  <tr>
        <td  align="right"   class="blackbold"  > IP Address  :</td>
        <td   align="left" >
<?php echo stripslashes($arryLog[0]['LoginIP']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Browser  : </td>
        <td   align="left" >
<?php echo stripslashes($arryLog[0]['Browser']); ?>
           </td>
      </tr>

</table>
	<? } ?>
</td>
</tr>


<? if(!empty($ErrorMsg)){?>
	<tr>
	  <td height="50" align="center" class="redmsg">
<?=$ErrorMsg?>
</td>
</tr>
<? }else{?>



	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','pageID','<?=sizeof($arryUserPage)?>');" /></td>-->
	<td width="20%"  class="head1" >Page Name</td>     
	<td width="20%"  class="head1" >Heading</td>
	<td  class="head1" >Url</td>
	<td width="20%" class="head1" >View Time</td>
      <!--td width="6%"  align="center" class="head1" >Action</td-->
    </tr>
   
    <?php 

  if(is_array($arryUserPage) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryUserPage as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;

  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="pageID[]" id="pageID<?=$Line?>" value="<?=$values['pageID']?>" /></td>-->

 
<td><?=stripslashes($values["PageName"])?></td>  
 
<td><?=stripslashes($values["PageHeading"])?></td> 
<td><?=stripslashes($values["PageUrl"])?></td>  
<td>
<?  if($values['ViewTime']>0){
	echo date("j M, Y H:i:s",strtotime($values['ViewTime']));
}
?>
</td>   



<!--td  align="center"  class="head1_inner">
<a href="#vUserLogPage.php?edit=<?=$values['pageID']?>&curP=<?=$_GET['curP']?>" ><?=$delete?></a>
</td-->
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryUserPage)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryUserPage)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','pageID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','pageID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','pageID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">

</form>
</td>
</tr>

<? } } ?>


</table>
