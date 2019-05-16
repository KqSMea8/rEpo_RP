<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
	/*
		  var frm  = component.form1;
		  var frm2 = component.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewComponent.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewComponent.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/

		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		}
</script>








<div class="had">Performance Components</div>
<div class="message"><? if(!empty($_SESSION['mess_component'])) {echo $_SESSION['mess_component']; unset($_SESSION['mess_component']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td>
		<!--  <a href="editComponent.php" class="add">Add Component</a>-->
  
  <? if($_GET['key']!='') {?> <a href="viewComponent.php" class="grey_bt">View All</a><? }?>

<? if($num>0){?>
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>


		</td>
      </tr>

	<tr>
	  <td  valign="top">
	
<form action="" method="post" name="form1">

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >

<table <?=$table_bg?>>
  <?  if(is_array($arryComponent) && $num>0){ ?>
  <tr align="left" valign="middle" >
    <td width="25%"  class="head1" >Component Title</td>
     <td  class="head1" >Description</td>
   <td width="8%" align="center" class="head1" >Status</td>
    <td width="8%"  align="center" class="head1 head1_action" >Action</td>
  </tr>

  <?php 
  $pagerLink=$objPager->getPager($arryComponent,$RecordsPerPage,$_GET['curP']);
 (count($arryComponent)>0)?($arryComponent=$objPager->getPageRecords()):("");
 
  	$flag=true;
  	foreach($arryComponent as $key=>$values){
	$flag=!$flag;
  ?>
  <tr align="left" valign="middle" >
    <td height="35" valign="top"><?=stripslashes($values['heading'])?></td>
    <td valign="top"><?=stripslashes($values['detail'])?></td>

    <td align="center" valign="top">
      <? 
		 if($values['Status'] ==1){
			  $Status = 'Active'; 
		 }else{
			  $Status = 'InActive'; 
		 }
	
	 

		echo '<a href="editComponent.php?active_id='.$values["compID"].'" class="'.$Status.'">'.$Status.'</a>';
		
	   
	 ?>    </td>
    <td align="center"  valign="top" class="head1_inner">
	<a href="vComponent.php?view=<?=$values['compID']?>"><?=$view?></a>
	<a href="editComponent.php?edit=<?=$values['compID']?>"><?=$edit?></a>

	<!--<a href="editComponent.php?del_id=<?=$values['compID']?>" onClick="return confirmDialog(this, 'Component')"><?=$delete?></a>-->
	
		</td>
  </tr>
  <?php } // foreach end //?>
 <tr > 
	<td  colspan="4" id="td_pager">
	Total Record(s) : &nbsp;<?php echo $num;?>  
  </td>
  </tr>

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="4" class="no_record"><?=NO_COMPONENT?></td>
  </tr>

  <?php } ?>
    
   <!-- <tr  >  <td height="20" colspan="4" >
Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryComponent)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?>

</td>
  </tr>--->
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
