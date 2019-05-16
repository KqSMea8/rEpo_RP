<?php 
	require_once("../classes/company.class.php");
require_once("../classes/fin.api.class.php");
	
	$objCompany=new company();
$objFiniCity = new fincity();



	if($_GET['edit']>0){
		$arryCompany = $objCompany->GetCompany($_GET['edit'],'');
		$CmpID   = $arryCompany[0]['CmpID'];
//echo $arryCompany[0]['Fin_API_Key'];
if($arryCompany[0]['FinicityApi']==1){

$url = "https://api.finicity.com/aggregation/v2/partners/authentication";
 $Config['partnerId']= $arryCompany[0]['Fin_API_PatID'];
 $Config['partnerSecret'] = $arryCompany[0]['Fin_Secret_Key'];

  $Token = $objFiniCity->patnerAuth($arryCompany[0]['Fin_API_Key'],$url);
if($Token['message']!=''){

$ErrorMsg = $Token['message'];

}else{

$ArrIns = $objCompany->GetInstitution($_GET['edit']);
 if(is_array($ArrIns)){
//echo "dfgdfgdf";
}else{
$arryInst = $objFiniCity->GetInstution($arryCompany[0]['Fin_API_Key'],$url, $Token);

$objCompany->InsertInstitution($arryInst['institution'],$_GET['edit']);

}
}


}
		//$RedirectUrl = 'viewUserLog.php?cmp='.$CmpID.'&curP='.$_GET['curP'].'&mode='.$_GET['mode'];
		$RedirectUrl = 'editCompany.php?edit='.$CmpID.'&curP='.$_GET['curP'].'&mode='.$_GET['mode'].'&tab=institution';	
		
		
		
		if($CmpID>0){
				
				
					
				/******Get User Log Records***********/
				$RecordsPerPage = 100;
				$Config['StartPage'] = ($_GET['curP']-1)*$RecordsPerPage;	
				$Config['RecordsPerPage'] = $RecordsPerPage;
				$arryUserProfileLog=$objCompany->GetInstitution($CmpID);
				/**********Count Records**************/
				$Config['GetNumRecords'] = 1;
				$arryCount=$objCompany->GetInstitution($CmpID);
				$num=$arryCount[0]['NumCount'];	
				$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
				/*************************************/


				

				
		}
	}

	
	$viewAll = 'editCompany.php?edit='.$CmpID.'&curP='.$_GET['curP'].'&tab=institution';	 
?>
<?php 
	if(!empty($_POST['logID'])){?>
	<style>
	.red{
	display:none;
	}
	</style>
	
	<?php }?>

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
<? if(!empty($_SESSION['mess_profile'])) {echo $_SESSION['mess_profile']; unset($_SESSION['mess_profile']); }?>
</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


<? if($CmpID>0){?>

<? if(!empty($ErrorMsg)){?>
	<tr>
<td><div class="message" align="center">
<? echo $ErrorMsg;?>
</div></td>
</tr>


<? }else{?>

	<tr>
	  <td  valign="top">

<form action="" method="post" name="form1">

<div id="preview_div">

 <? if($num>0){ ?>


 <br>
 <div class="cb">

<input type="submit" name="DeleteButton" class="button" style="float:right;margin-bottom:5px;" value="Delete" onclick="return confDel('User Profile Log')">
 
 </div>
 
 <? } ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >  
<td width="10%" class="head1" >ID</td>
    	<td width="10%" class="head1" >Name</td>
     <td  width="10%" class="head1" >Account Type</td>

	<td width="10%" class="head1" >Updated Time</td>
	
	<td width="10%" class="head1" >Phone</td>
	
	<td width="10%" align="center" class="head1" >View</td>
	<td width="1%"  align="center" class="head1" >
	<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','logID','<?=sizeof($arryUserProfileLog)?>');" /></td>

    </tr>
   
    <?php 
$viewpage = '<img src="'.$Config['Url'].'admin/images/view.png" border="0"  onMouseover="ddrivetip(\'<center>View</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';

//$kick = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Kick Out</center>\', 50,\'\')"; onMouseout="hideddrivetip()" >'; 


	$Today= date("Y-m-d");
  if(is_array($arryUserProfileLog)){
 $Line = 0;
  	foreach($arryUserProfileLog as $key=>$values){
  		 $Line++;
  		
  		if(!empty($values['Email'])){
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">

  <td>
<a class="fancybox fancybox.iframe" href="userInfo.php?view=<?=$values['EmpID']?>&cmp=<?=$CmpID?>" >
<?=stripslashes($values["UserName"])?></a>
</td>
 <td>
<a class="fancybox fancybox.iframe" href="userInfo.php?view=<?=$values['EmpID']?>&cmp=<?=$CmpID?>" >
<?=stripslashes($values["UserName"])?></a>
</td>

<td> <?=$values['Email'];?></td>  
 
<td ><?php echo date("j M, Y H:i:s",strtotime($values['updated']));?></td>  

<td><?=$values['tab'];?></td>

<td  align="center"  class="head1_inner">
<a class="fancybox fancybox.iframe" href="userProfileChanges.php?view=<?=$values['logID']?>&cmp=<?=$CmpID?>" ><?=$viewpage?></a>
</td>

<td  align="center"  class="head1_inner">
<input <?=$CheckHide?> type="checkbox" name="logID[]" id="logID<?= $Line ?>" value="<?=$values['logID']?>" />
</td>

    </tr>
    <?php } }// foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="11" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryUserProfileLog)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryUserProfileLog)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','loginID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','loginID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','loginID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
  <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">
</form>
</td>
</tr>

<? } } ?>


</table>

