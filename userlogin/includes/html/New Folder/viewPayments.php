
<script language="JavaScript1.2" type="text/javascript">

function Clickheretoprint()

{ 

  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 

      disp_setting+="scrollbars=yes,width=650, height=600, left=100, top=25"; 

  var content_vlue = document.getElementById("ResultList").innerHTML; 

  

  var docprint=window.open("","",disp_setting); 

   docprint.document.open(); 

   docprint.document.write('<html><head><title>Inel Power System</title>'); 

   docprint.document.write('</head><body onLoad="self.print()"><center>');          

   docprint.document.write(content_vlue);          

   docprint.document.write('</center></body></html>'); 

   docprint.document.close(); 

   docprint.focus(); 

}

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewPayments.php?curP='+frm.CurrentPage.value+'&CatID='+frm.CatID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewPayments.php?curP='+frm.CurrentPage.value+'&CatID='+frm.CatID.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
		
	
	function ValidateSearchDate(){	
		  var frm  = document.form1;
		  var form5 = document.form5;
		  
		  if(form5.year.value==''){
		  	alert('Please select year.');
			return false;
		  }else{
		  
			  var DateVal = escape(form5.year.value)+'-'+escape(form5.month.value);
			  
				location.href = 'viewPayments.php?curP='+frm.CurrentPage.value+'&CatID='+frm.CatID.value+'&sortby=p1.Date&asc='+form5.AscDate.value+'&key='+DateVal+'&SearchByDate=1';
				
				return false;
			}
			
			
	}		
		
</script>



<div class="had"><?=stripslashes($arryCategory[0]['Name'])?> Payments</div>
<div class="message"><? if(!empty($_SESSION['mess_pay'])) {echo $_SESSION['mess_pay']; unset($_SESSION['mess_pay']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

	<tr>
	  <td valign="top">
	  

<form action="" method="post" name="form5" onSubmit="return ValidateSearchDate();">
<?
if($_GET['SearchByDate']){
	$arryDat = explode("-",$_GET['key']);
	$year_value = $arryDat[0];
	$month_value = $arryDat[1];
}

?>
<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
  <tr>

    <td align="right" >Search By Date:&nbsp;</td>
    <td ><?=getYears($year_value,'year','inputbox')?></td>
    <td ><?=getMonths($month_value,'month','inputbox')?></td>
	 <td >
	   <select name="AscDate" id="AscDate" class="inputbox">
         <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
         <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
       </select>
	</td>
	 <td ><input name="search2" type="submit" class="button" value="Go" /></td>
	  <td ><input name="print" type="button" class="button" value="Print" onclick="javascript:Clickheretoprint();" /></td>
  </tr>
</table>

	</form>

	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table  border="0" cellpadding="3" cellspacing="0"  id="search_table">
                    <tr>
                      <td ><select name="sortby" id="sortby" class="inputbox" >
						<option value="">All</option>
						  <option value="p1.PaymentFor" <? if($_GET['sortby']=='p1.PaymentFor') echo 'selected';?>>Payment For</option>
						  
						   <option value="m1.UserName" <? if($_GET['sortby']=='m1.UserName') echo 'selected';?>>Paid By</option>
						  <option value="p1.Amount" <? if($_GET['sortby']=='p1.Amount') echo 'selected';?>>Amount</option>
						   <option value="m1.AreaCode" <? if($_GET['sortby']=='m1.AreaCode') echo 'selected';?>>Area Code</option>
						  <option value="pg.name" <? if($_GET['sortby']=='pg.name') echo 'selected';?>>Payment Method</option>
						  
						   <option value="p1.Date" <? if($_GET['sortby']=='p1.Date') echo 'selected';?>>Payment Date</option>
						  
					 </select></td>
                      <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"> </td>
					  
					    <td>				    
					 <select name="asc" id="asc" class="inputbox" >
						 <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						 <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					   
					 </select></td>
					  
                      <td  align="left" >
                        <input name="search" type="submit" class="button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewPayments.php?CatID=<?=$_GET['CatID']?>">View All</a><? }?></td>
                 
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<div id="ResultList">
<? if($_GET['SearchByDate']==1){   $Dat = date('Y-m-d'); 


if(!empty($month_value)) {
	$SelectedDate = $year_value.'-'.$month_value.'-01';
	$Dat = strtotime($SelectedDate);
	$ResultDate = date("F, Y", $Dat);
}else{
	$SelectedDate = $year_value.'-01-01';
	$Dat = strtotime($SelectedDate);
	$ResultDate = date("Y", $Dat);
}
?>
<table width="99%" cellpadding="0" cellspacing="0">
<tr><td>&nbsp;<strong>Search Result For Date:</strong> <?=$ResultDate?></td></tr>
<tr><td>&nbsp;<strong>Current Date:</strong> <?=date("F j, Y")?></td></tr>
<tr><td>&nbsp;<strong>Administrator:</strong> <?=$_SESSION['Name']?></td></tr>
</table><br>
<? } ?>
<table <?=$table_bg?>>
  <tr align="left" valign="middle" >
    <td width="15%"  class="head1" >Payment For</td>
    <td width="13%" class="head1" >Paid By</td>
	<td width="13%" class="head1" >Amount (<?=$Config['Currency']?>)</td>
	<td width="10%"class="head1" >Area Code</td>
	<td width="14%"class="head1" >Payment Method</td>
    <td width="14%" class="head1" > Payment Date</td>
    <td width="14%"  class="head1" >Payment Status</td>
    <td width="7%"  align="left" class="head1" >Action</td>
  </tr>

  <? 
  $pagerLink=$objPager->getPager($arryPayment,$RecordsPerPage,$_GET['curP']);
 (count($arryPayment)>0)?($arryPayment=$objPager->getPageRecords()):("");
  if(is_array($arryPayment) && $num>0){
  	$flag=true;
  	foreach($arryPayment as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
	#if($values['PaymentStatus']<=0){ $bgcolor="#000000"; }
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$bgcolor?>">
    <td   > 
	<?=stripslashes($values['PaymentFor'])?>
	<? if($_GET['CatID']==3){
		echo '<br>(<a href="editBanner.php?edit='.$values['PaymentForCode'].'" target="_blank">View Banner</a>)';
	}else if($_GET['CatID']==6 || $_GET['CatID']==7){
		$PaymentForCode = explode(",",$values['PaymentForCode']);
		echo '<br>(<a href="editProduct.php?edit='.$PaymentForCode[0].'&MemberID='.$values['MemberID'].'" target="_blank">View Product</a>)';
	}
	?>		</td>
    <td >
	<?
	if(!empty($values['UserName'])){
	 echo '<a onclick="OpenNewPopUp(\'vSeller.php?edit='.$values['MemberID'].'\', 550, 660, \'no\' );" href="#" ><b>'. stripslashes($values["UserName"]) .'</b></a><br>';
	}else{ 
	 echo stripslashes($values['PaidBy']);
	}
	
	?>	</td>
    <td ><?=number_format($values['Amount'],2);?></td>
    <td ><?=stripslashes($values['AreaCode'])?></td>
    <td ><?=stripslashes($values['PaymentMethod'])?></td>
    <td >
      <?=stripslashes($values['Date'])?>   </td>
    <td  >
      <? 
		 if($values['PaymentStatus'] ==1){
			  $status = 'Received';
		 }else{
			  $status = 'Pending';
		 }
	
	 
		if($values['PaymentGateway'] ==1 || $values['PaymentGateway'] ==2 || $values['PaymentStatus']==1){
			echo $status;
		}else{
	  		echo '<a href="viewPayments.php?active_id='.$values["PaymentID"].'&PaymentStatus='.$values["PaymentStatus"].'&CatID='.$_GET["CatID"].'&curP='.$_GET["curP"].'" class="edit">'.$status.'</a>';
		}
		
	 
	   
	 ?>    </td>
    <td  align="center"  ><a href="viewPayments.php?del_id=<? echo $values['PaymentID'];?>&CatID=<?=$_GET['CatID']?>&curP=<? echo $_GET['curP'];?>" onClick="return confDel('Payment detail')" class="edit" ><?=$delete?></a>		</td>
  </tr>
  <? } // foreach end //?>
 

 
  <? }else{?>
  <tr >
  	  <td  colspan="8" class="no_record">No record found.</td>
  </tr>

  <? } ?>
    
  <tr>  <td  colspan="8" >Total Record(s) : &nbsp;<? echo $num;?>      <? if(count($arryPayment)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <? echo $pagerLink;
}?></td>
  </tr>
</table>
</div>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>">
<input type="hidden" name="CatID" id="CatID" value="<? echo $_GET['CatID']; ?>">

</form>
</td>
	</tr>
	<tr >
  	  <td height="30">&nbsp;</td>
  </tr>
</table>
