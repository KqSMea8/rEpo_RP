<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';

	}
function filterModel(id)
	{ 
		location.href="viewModel.php?sortby=l.Model_status&key="+id+"&asc=Desc&module=Model&search=Search"		

	}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_model'])) {echo $_SESSION['mess_model']; unset($_SESSION['mess_model']); }?></div>
<form action="" method="post" name="form1">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 <tr>  
	  <td  valign="top" align="right">
 



		   <? if($num>0){?>

<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_Model.php?<?=$QueryString?>';" />
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/-->
	  <? } ?>
     
      <a href="editModel.php" class="add" >Add Model</a>
      
        <? if($_GET['key']!='') {?>
		  <a class="grey_bt"  href="viewModel.php?module=<?=$_GET['module']?>">View All</a>
		<? }?>
        	</td>
      </tr>



 
	<tr>
	  <td  valign="top">
	


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
    
     <!--td width="8%"  class="head1" >Model No</td-->
	<!--td class="head1">S.No.</td-->
	<td class="head1">Model</td>
	<td class="head1">Generation</td>
	<!--td class="head1">Status</td-->
	
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
  
    </tr>
   
    <?php 
  if(is_array($arryModel) && $num>0){
  	$flag=true;
	$Line=0;

	$ModelNo = 0;
	$ModelNo = ($_GET['curP']-1)*$RecordsPerPage;

  	foreach($arryModel as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	$ModelNo++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr  bgcolor="<?=$bgcolor?>">     
     
     
	<!--td><?=$ModelNo?></td-->
	<td><?= $values['Model']; ?></td>
	<td><?= $values['Generation']; ?></td>
	<!--td>

<?
$Active=''

/* if ($values['Status'] == 1) {
	$Status= 'Active';
	$Active = "Active";
	}else{
	
	$Active = "InActive";
	$Status = 'InActive';
	}

*/
?>
<a href="editModel.php?active_id=<?=$values['id']?>&curP=<?=$_GET['curP']?>" class="<?=$Active?>" ><?=$Status?></a>
 </td-->
	
	
	<td align="center">

<a href="editModel.php?edit=<? echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>"><?= $edit ?></a> 


<? if(!$objItem->isSettingTransactionExist($values['id'])){ ?>   <a href="editModel.php?del_id=<? echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>" onClick="return confDel('Model')"  ><?= $delete ?></a>
<? } ?>	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="11" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="5" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryModel)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
 
  </div> 
 <? if(sizeof($arryModel)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','ModelID','editModel.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','ModelID','editModel.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','ModelID','editModel.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

  <input type="hidden" name="NumField" id="NumField" value="<?=sizeof($arryModel)?>">

</td>
	</tr>
</table>
</form>
