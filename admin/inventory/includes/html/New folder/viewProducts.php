<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(SearchBy){
	/*
	  var frm  = document.form1;
	  var frm2 = document.form2;
	   if(SearchBy==1)  {
		   location.href = 'viewProducts.php?curP='+frm.CurrentPage.value+'&MemberID='+document.topForm.MemberID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value)+'&CatID='+document.topForm.CatID.value;
	   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
		   location.href = 'viewProducts.php?curP='+frm.CurrentPage.value+'&MemberID='+document.topForm.MemberID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value)+'&CatID='+document.topForm.CatID.value;
		}
		
		return false;*/
	}


function submitThisForm(frm){	
	if(document.getElementById("ProductsListing") != null){
		document.getElementById("ProductsListing").innerHTML= '<img src="images/loading.gif"><br><br><br><br>';
	}
	document.topForm.submit();
}

</script> 
 
 
 <div style="float:right"><a href="viewProductCategory.php?MemberID=<?=$_GET['MemberID']?>">Click here to choose another store or category</a></div>
<div class="had">
Manage Products <?=$MainParentCategory?>  <strong><?=$ParentCategory?></strong>
</div>



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<? if(sizeof($arryMemberDetail)>0) { ?>
	<tr>
   	 <td  align="left" valign="top"  <? if($_GET['MemberID']<=0){ echo 'height="240"';}?>  >
	
	  <form name="topForm" action="viewProducts.php" method="get">
	  <!--
	  <select name="MemberID" class="inputbox" id="MemberID" onChange="submitThisForm(this);" style="width:250px;">
        <option value="">-----Select Store-----</option>
        <? //for($i=0;$i<sizeof($arryMember);$i++) {?>
        <option value="<?=$arryMember[$i]['MemberID']?>" <?  if($arryMember[$i]['MemberID']==$_GET['MemberID']){echo "selected";}?>>
        <?=stripslashes($arryMember[$i]['CompanyName'])?> (By <?=stripslashes($arryMember[$i]['UserName'])?>)
        </option>
        <? //} ?>
      </select>  -->
	  
	  <?
	echo '<br><div class="red">Store: </b><a onclick="OpenNewPopUp(\'vSeller.php?edit='.$_GET['MemberID'].'\', 550, 500, \'no\' );" href="#" class="Blue">'.stripslashes($arryMemberDetail[0]['UserName']).' ('.stripslashes($arryMemberDetail[0]['CompanyName']).')</a></div>';
	echo '<input type="hidden" name="MemberID" id="MemberID" value="'.$_GET['MemberID'].'">'; 
	echo '<input type="hidden" name="CatID" id="CatID" value="'.$_GET['CatID'].'">'; 
	?>
	</form>
	  	
	
	  
	</td>
	</tr>  
	  
	<?  if(sizeof($arryMemberDetail)>0) {?>
 <tr>
    <td  align="right" >
	 <a href="editProduct.php?MemberID=<?=$_GET['MemberID']?>&curP=<?=$_GET['curP']?>&CatID=<?=$_GET['CatID']?>" class="Blue">Add Product</a>			
	</td>
	</tr>	
  <tr>
    <td  >
	<div class="message"><? if(!empty($_SESSION['mess_product'])) {echo $_SESSION['mess_product']; unset($_SESSION['mess_product']); }?>
                      </div>
	</td>
	</tr>		
		
		
  <tr>
    <td id="ProductsListing">
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
			<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td>  <select name="sortby" id="sortby" class="inputbox" >
						<option value="">All</option> 
						<option value="p1.Name" <? if($_GET['sortby']=='p1.Name') echo 'selected';?>>Product Name</option>
					   <!--<option value="m1.UserName" <? if($_GET['sortby']=='m1.UserName') echo 'selected';?>>Posted by</option>-->
					   	<option value="p1.AddedDate" <? if($_GET['sortby']=='p1.AddedDate') echo 'selected';?>>Posted Date</option>
					   	<option value="p1.Featured" <? if($_GET['sortby']=='p1.Featured') echo 'selected';?>>Featured</option>
					<option value="p1.Special" <? if($_GET['sortby']=='p1.Special') echo 'selected';?>>Recommended</option>
						<option value="p1.Status" <? if($_GET['sortby']=='p1.Status') echo 'selected';?>>Status</option>
					 </select></td>
                      <td  ><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
					     <td >				  
					 <select name="asc" id="asc" class="inputbox" >
						<option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					    <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
					 </select>					 </td>
					  
                      <td  >
					  
					<input type="hidden" name="MemberID" id="MemberID" value="<?=$_GET['MemberID']?>">  
					<input type="hidden" name="CatID" id="CatID" value="<?=$_GET['CatID']?>">  
					  
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewProducts.php?MemberID=<?=$_GET['MemberID']?>&CatID=<?=$_GET['CatID']?>">View All</a><? }?></td>
                
				    </tr>
      </table>
	</form>
	
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
	

  <tr align="left">
    <td width="1%" class="head1" ><!--<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ProductID','<?=sizeof($arryProduct)?>');" />--></td>
    <td width="35%"  class="head1" >Product Name</td>
    <td width="6%" class="head1" ><!--Posted by--></td>
    <td width="16%" class="head1" >Posted Date </td>
     <td width="11%" class="head1" >Featured</td>
     <td width="11%" class="head1" >Recommended</td>
     <td width="8%"  class="head1" >Status</td>
    <td width="12%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
 
  if(is_array($arryProduct) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryProduct as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
	$Line++;
	
	//if($values['Status']<=0){ $bgcolor="#000000"; }
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td ><!--<input type="checkbox" name="ProductID[]" id="ProductID<?=$Line?>" value="<?=$values['ProductID'];?>">--></td>
    <td   >
	<? 	 
	echo stripslashes($values['Name']);
if(!empty($values['ProductNumber'])){
	echo ' <span class="txt">('.stripslashes($values['ProductNumber']).')</span>';
}
  
  ?>	</td>
    <td><?php
		/*
	if($values['PostedByID'] > 0 && $values['PostedByName'] !=''){
		echo '<a onclick="OpenNewPopUp(\'vSeller.php?edit='.$values['PostedByID'].'\', 550, 500, \'no\' );" href="#" class="Blue">'.$values['PostedByName'].'</span>';
	}else if($values['PostedByID'] > 0){
		echo '<span class="red">(Member Removed)</span><span >'.$values['PostedByName'].'</span>';
	}else{
		echo '<span >Admin</span>';
	}
*/
	?></td>
    <td ><? 	
	if($values['AddedDate'] > 0){	
		//echo '<SPAN >'.  date("jS F  y", strtotime($values['AddedDate'])) .'</SPAN>'; 
		echo '<SPAN>'. $values['AddedDate'] .'</SPAN>'; 
	}
	?></td>
	
    <td>
		<? 
		echo '<a href="editProduct.php?featured_id='.$values["ProductID"].'&curP='.$_GET["curP"].'&MemberID='.$_GET['MemberID'].'&CatID='.$_GET['CatID'].'" class="edit" alt="Click to Change Featured Status" title="Click to Change Featured Status">'.$values['Featured'].'</a>';
	 ?>
		
		
		</td>
    <td><? 
		echo '<a href="editProduct.php?special_id='.$values["ProductID"].'&curP='.$_GET["curP"].'&MemberID='.$_GET['MemberID'].'&CatID='.$_GET['CatID'].'" class="edit" alt="Click to Change Special Status" title="Click to Change Special Status">'.$values['Special'].'</a>';
	 ?></td>
    <td ><? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
	
	 

	echo '<a href="editProduct.php?active_id='.$values["ProductID"].'&curP='.$_GET["curP"].'&MemberID='.$_GET['MemberID'].'&CatID='.$_GET['CatID'].'" class="edit" alt="Click to Change Status" title="Click to Change Status">'.$status.'</a>';
		
	   
	 ?></td>
    <td  align="center"  >
	<a href="editProduct.php?edit=<? echo $values['ProductID'];?>&curP=<?php echo $_GET['curP'];?>&MemberID=<?=$_GET['MemberID']?>&CatID=<?=$_GET['CatID']?>" class="edit"><?=$edit?></a>  <a href="editProduct.php?del_id=<? echo $values['ProductID'];?>&CategoryID=<?php echo $values['CategoryID'];?>&curP=<?php echo $_GET['curP'];?>&MemberID=<?=$_GET['MemberID']?>&CatID=<?=$_GET['CatID']?>" onClick="return confDel('Product')" class="edit" ><?=$delete?></a>	</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	 	<tr >
  	  <td  colspan="8" class="no_record">No product found.</td>
  </tr>

  <?php } ?>
    

  
  <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryProduct)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>

 <? if(sizeof($arryProduct)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none" >
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="Button"  value="Delete" onclick="javascript: ValidateMultipleAction('product','delete','<?=$Line?>','ProductID','editProduct.php?curP=<?=$_GET[curP]?>&MemberID=<?=$_GET['MemberID']?>');">
      <input type="button" name="ActiveButton" class="Button"  value="Active" onclick="javascript: ValidateMultipleAction('product','active','<?=$Line?>','ProductID','editProduct.php?curP=<?=$_GET[curP]?>&MemberID=<?=$_GET['MemberID']?>');" />
      <input type="button" name="InActiveButton" class="Button"  value="InActive" onclick="javascript: ValidateMultipleAction('product','inactive','<?=$Line?>','ProductID','editProduct.php?curP=<?=$_GET[curP]?>&MemberID=<?=$_GET['MemberID']?>');" /></td>
  </tr>
  </table>
  <? } ?>

<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


</form>
</td>
  </tr>
  <? } ?>
  
  <? } else{ ?>
  <tr>
  <td align="center">
  <span class="red">No Store found !</span> 
  </td>
  </tr>
  <? } ?>
  
</table>
