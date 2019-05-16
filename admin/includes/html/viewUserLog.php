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
<div class="had"><?=$MainModuleName?></div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


<? 


if(!empty($ErrorMsg)){?>
	<tr>
	  <td height="50" align="center" class="redmsg">
<?=$ErrorMsg?>
</td>
</tr>
<? }else{?>

<tr>
        <td align="left" >
<?
	$OnlineClass = ($_GET['mode']=="online")?("grey_bt"):("white_bt");
	$OffineClass = ($_GET['mode']=="offline")?("grey_bt"):("white_bt");
	
	$OnlineUrl = 'viewUserLog.php?mode=online';	
	$OfflineUrl = 'viewUserLog.php?mode=offline';	
?>
<a href="<?=$OnlineUrl?>" class="<?=$OnlineClass?>" style="float:left"><b>Online Users</b></a> <a href="<?=$OfflineUrl?>" class="<?=$OffineClass?>" style="float:left"><b>Offline Users</b></a>



		<? if($_GET['key']!='' || $_GET['mode']!='') {?>
		  <input type="button" class="view_button" style="float:right" name="view" value="View All" onclick="Javascript:window.location='<?=$viewAll?>';" />
		<? }?>

<? if($num>0 && $DeleteLabel==1){ ?>
<a class="fancybox action_bt fancybox.iframe" href="deleteUserLog.php"  class="action_bt" style="float:right">Delete User Log</a>
<? }?>	
	
	
      </tr>

	<tr>
	  <td  valign="top">
<div class="message" align="center"><? if(!empty($_SESSION['mess_log'])) {echo $_SESSION['mess_log']; unset($_SESSION['mess_log']); }?></div>	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

 <? if($num>0 && $ModifyLabel==1){ ?>
 <br>
 <div class="cb"></div>
<input type="submit" name="DeleteButton" class="button" style="float:right;margin-bottom:5px;" value="Kick Out" onclick="javascript: return ValidateMultiple('log','kick out','NumField','loginID');">
<? } ?>
<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="10%"  class="head1" >User Name</td>   
 <td width="8%"  class="head1" >User Type</td>       
     <td  class="head1" >Email</td>
<td width="10%" class="head1" >IP Address</td>
	<td width="13%" class="head1" >Login Time</td>
	<td width="13%" class="head1" >Logout Time</td>
      
      <td width="10%" class="head1" >Duration</td>
	<td width="15%" class="head1" >Browser</td>
	<td width="5%" class="head1" >Status</td>
	<td width="4%"  align="center" class="head1" >Pages</td>
	<td width="1%"  align="center" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','loginID','<?=sizeof($arryUserLog)?>');" /></td>
    </tr>
   
    <?php 
$viewpage = '<img src="'.$Config['Url'].'admin/images/view.png" border="0"  onMouseover="ddrivetip(\'<center>Page History</center>\', 70,\'\')"; onMouseout="hideddrivetip()" >';

$kick = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Kick Out</center>\', 50,\'\')"; onMouseout="hideddrivetip()" >'; 


	$Today= date("Y-m-d");
	$TotalDuration=0;
$Line=0;
  if(is_array($arryUserLog) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryUserLog as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	/*$Duration = 0;$CheckHide = ''; $Status='Online';$stClass = 'green';
	if($values['LoginTime']>0 && $values['LogoutTime']>0){
		$Duration = strtotime($values["LogoutTime"]) - strtotime($values["LoginTime"]);
		$TotalDuration += $Duration;
		if($Duration<0) $Duration=0;
		$Duration = time_diff($Duration);
		$CheckHide = 'style="display:none"';$stClass = 'red';
		$Status='Offline';
	}else if($values['Kicked']==1){
		$CheckHide = 'style="display:none"';
		$Status='Kicked';$stClass = 'red';
	}else if($values['LoginTime']<$Today){
		$CheckHide = 'style="display:none"';
		$Status='Offline';$stClass = 'red';
	}*/

	$Duration = 0;
	if($values['LoginTime']>0 && $values['LogoutTime']>0){
		$Duration = strtotime($values["LogoutTime"]) - strtotime($values["LoginTime"]);
		$TotalDuration += $Duration;
		if($Duration<0) $Duration=0;
		$Duration = time_diff($Duration);		
	}


	$values['SessionTimeout'] = $SessionTimeout; 
	$values['CurrentCmpTime'] = $CurrentCmpTime; 
	$arryStatusDetail = CheckLoginStatus($values);
	$Status = $arryStatusDetail[0];
	$stClass = $arryStatusDetail[1];
	$CheckHide = $arryStatusDetail[2];

	
	 if($values['UserType']=='employee'){
		$UserLink = '<a class="fancybox fancybox.iframe" href="userInfo.php?view='.$values['EmpID'].'" >'.stripslashes($values["UserName"]).'</a>';
		$Email = $values['Email'];
	 }else if($values['UserType']=='customer'){
		$UserLink = '<a class="fancybox fancybox.iframe" href="custInfo.php?CustID='.$values['UserID'].'">'.stripslashes($values['CustomerName']).'</a>';
		$Email = $values['CustomerEmail'];
	}else if($values['UserType']=='customerContact'){
		$UserLink = stripslashes($values['CustContactName']);
		$Email = $values['CustContactEmail'];
	}else if($values['UserType']=='vendor'){
		$UserLink = '<a class="fancybox fancybox.iframe" href="vendorInfo.php?SuppID='.$values['UserID'].'" >'.stripslashes($values["VendorName"]).'<a>';
		$Email = $values['VendorEmail'];
	}else{
		$UserLink = ADMINISTRATOR;
		$Email = $arryCompany[0]['Email'];
	}

  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      
     
<td><?=$UserLink?></td>
 <td><?=ucwords($values['UserType'])?></td>
<td><?=$Email?></td>  
<td><?=stripslashes($values["LoginIP"])?></td>  
<td>
<?  if($values['LoginTime']>0){
	echo date("j M, Y H:i:s",strtotime($values['LoginTime']));
}
?>
</td>   
<td>
<?  if($values['LogoutTime']>0){
	echo date("j M, Y H:i:s",strtotime($values['LogoutTime']));
}
?>
</td>

 <td><?=($Duration!=0)?($Duration):('')?></td>
<td ><?=stripslashes($values["Browser"])?></td>
<td class="<?=$stClass?>"><?=$Status?></td>

      <td  align="center"  class="head1_inner">


<a class="fancybox fancybox.iframe" href="vUserLogPage.php?view=<?=$values['loginID']?>" ><?=$viewpage?></a>

<? //if($values["LoginTime"]>0 && $values['LogoutTime']<=0){ ?>
<!--a href="#editUserLog.php?edit=<?=$values['loginID']?>&curP=<?=$_GET['curP']?>" ><?=$kick?></a-->
<? //} ?>

</td>

	 <td  align="center"  class="head1_inner">

<input <?=$CheckHide?> type="checkbox" name="loginID[]" id="loginID<?=$Line?>" value="<?=$values['loginID']?>" />


	</td>

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="11" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryUserLog)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
 
  <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">
</form>
</td>
</tr>

<? }  ?>


</table>
