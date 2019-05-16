<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SelectCmp(cmp){	
	ResetSearch();
	window.parent.location.href = document.getElementById("link").value+"?cmp="+cmp;
}

</script>
<div class="had">Select Company</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	<td align="right" valign="bottom">

	<form name="frmSrch" id="frmSrch" action="cmpList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
	</form>



	</td>
	</tr>
	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$Config['Url']?>images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CmpID','<?=sizeof($arryCompany)?>');" /></td>-->
      <td width="25%"  class="head1" >Company Name</td>
      <td width="12%"  class="head1" >Company ID</td>
       <td width="20%" class="head1" >Display Name</td>
     <td  class="head1" >Email</td>

      <td width="6%"  align="center" class="head1" >Status</td>

    </tr>
   
    <?php 

$deleteCmp = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Confirm Delete</center>\', 90,\'\')"; onMouseout="hideddrivetip()" >';

  if(is_array($arryCompany) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCompany as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }


	//$AdminUrl = $Config['Url'].$values["DisplayName"].'/'.$Config['AdminFolder']."/";


  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	
	<td><a href="Javascript:void(0);" onclick="Javascript:SelectCmp(<?=$values['CmpID']?>)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?=stripslashes($values["CompanyName"])?></a></td>
	</td>


	<td><?=$values["CmpID"]?></td>
	<td><?=$values["DisplayName"]?></td>   
	<td><?=$values["Email"]?></td>
 


 
    <td align="center"><? 
		 if($values['Status'] ==1){
			  $status = 'Active';$StatusCls = 'green';
		 }else{
			  $status = 'InActive';$StatusCls = 'red';
		 }
	
	 

	echo '<span class="'.$StatusCls.'">'.$status.'</span>';
		
	 ?></td>
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCompany)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryCompany)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','CmpID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','CmpID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','CmpID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
