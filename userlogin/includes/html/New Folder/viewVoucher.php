
<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewVoucher.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewVoucher.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
		}
</script>

<div class="had">Manage Voucher Codes</div>
<div class="message"><? if(!empty($_SESSION['mess_voucher'])) {echo $_SESSION['mess_voucher']; unset($_SESSION['mess_voucher']); }?></div>
<TABLE WIDTH="99%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
		<td align="right"><a href="editVoucher.php" class="Blue">Add Voucher Code</a></td>
	  </tr>
	  
	<tr>
	  <td  valign="top">
	  
	

	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="0" cellspacing="3"  id="search_table">
                    <tr>
                      <td> <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
						    <option value="code" <? if($_GET['sortby']=='code') echo 'selected';?>>Voucher Code</option>
					 </select></td>
					 
					  <td>				   
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
					 
                      <td ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>">
					  
					  </td><td> 
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewVoucher.php">View all</a><? }?></td>
                  
					 
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
  
  <tr align="left" valign="middle" >
    <td width="19%" class="head1" >Voucher Code</td>
    <td width="17%" class="head1" >Discount(%)</td>
    <td width="25%" class="head1" >Discount Over the Amount($)</td>
    <td width="11%" class="head1" >Start Date</td>
    <td width="11%" class="head1" >End Date</td>
    <td width="9%" height="20" class="head1" >Status</td>
    <td width="8%" height="20" align="center" class="head1" >Action</td>
  </tr>
  
  <?php 
  $pagerLink=$objPager->getPager($arryVoucher,$RecordsPerPage,$_GET['curP']);
 (count($arryVoucher)>0)?($arryVoucher=$objPager->getPageRecords()):("");
  if(is_array($arryVoucher) && $num>0){
  	$flag=true;
  	foreach($arryVoucher as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td>
    <?=stripslashes($values['code'])?>    </td>
    <td  ><?=stripslashes($values['Discount'])?></td>
    <td  ><?=stripslashes($values['DiscountOver'])?></td>
    <td  ><?=stripslashes($values['StartDate'])?></td>
    <td  ><?=stripslashes($values['EndDate'])?></td>
    <td height="20" >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

		echo '<a href="editVoucher.php?active_id='.$values["voucherID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		
	   
	 ?>    </td>
    <td height="20" align="center"  >
	<a href="editVoucher.php?edit=<?php echo $values['voucherID'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>

	<a href="editVoucher.php?del_id=<?php echo $values['voucherID'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Voucher Code')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="7" class="no_record" >No record found! </td>
  </tr>

  <?php } ?>
    
  <tr>  <td height="20" colspan="7">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryVoucher)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
