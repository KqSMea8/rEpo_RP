<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewCurrencies.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCurrencies.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
<div class="had"><?php echo 'Manage Currencies';?></div>
<div class="message"><? if(!empty($_SESSION['mess_currency'])) {echo $_SESSION['mess_currency']; unset($_SESSION['mess_currency']); }?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
		<td  align="right"><a href="editCurrency.php" class="add">Add Currency</a></td>
	  </tr>
	<tr>
	  <td  valign="top">
	  

	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="0" cellspacing="3"  id="search_table" style="margin:0; display:none;">
                    <tr>
                      <td > <select name="sortby" id="sortby" class="inputbox" >
							<option value="" >All</option>
						    <option value="name" <? if($_GET['sortby']=='name') echo 'selected';?>>Currency</option>
						    <option value="code" <? if($_GET['sortby']=='code') echo 'selected';?>>Code</option>
	<option value="symbol_left" <? if($_GET['sortby']=='symbol_left') echo 'selected';?>>Symbol Left</option>
	<option value="symbol_right" <? if($_GET['sortby']=='symbol_right') echo 'selected';?>>Symbol Right</option>
					 </select>
					  
					  </td>
                      <td ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"></td> 
					  
					  <td>				   
					 <select name="asc" id="asc" class="textbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select>
					 
					 </td>
					  
					  
                       <td> <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewCurrencies.php">View All</a><? }?>
						</td>
                   
				    </tr>
      </table><br></form>
<form action="" method="post" name="form1">

<table <?=$table_bg?>>

  
  <tr align="left"  >
    <td class="head1" >Currency</td>
    <td width="13%" class="head1" >Code</td>
    <td width="14%" class="head1" >Currency Value</td>
    <td width="12%"  class="head1" >Symbol Left</td>
    <td width="12%" class="head1" >Symbol Right</td>
    <td width="10%"  align="center" class="head1" >Status</td>
    <td width="8%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryRegion,$RecordsPerPage,$_GET['curP']);
 (count($arryRegion)>0)?($arryRegion=$objPager->getPageRecords()):("");
  if(is_array($arryRegion) && $num>0){
  	$flag=true;
  	foreach($arryRegion as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td >
      <?=stripslashes($values['name'])?>    </td>
    <td >
      <?=stripslashes($values['code'])?>   </td>
    <td ><?=stripslashes($values['currency_value'])?></td>
    <td  >
	<?=stripslashes($values['symbol_left'])?></td>
    <td ><?=stripslashes($values['symbol_right'])?></td>
    <td  align="center" >
      <? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 
	  if($values['currency_id']!=9){
	  		echo '<a href="editCurrency.php?active_id='.$values["currency_id"].'&curP='.$_GET["curP"].'" class="'.$status.'">'.$status.'</a>';
		 } else{ 
	 	    echo $status;
	   } 
	   
	 ?>    </td>
    <td  align="center"  >
	
	<? if($values['currency_id']!=9){ ?>
	<a href="editCurrency.php?edit=<?php echo $values['currency_id'];?>&curP=<?php echo $_GET['curP'];?>" ><?=$edit?></a>
	<a href="editCurrency.php?del_id=<?php echo $values['currency_id'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('Currency')" ><?=$delete?></a>
	<? } ?>	&nbsp;</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="7" class="no_record">No currency found. </td>
  </tr>

  <?php } ?>
    
  <tr  >  <td  colspan="7">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryRegion)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
