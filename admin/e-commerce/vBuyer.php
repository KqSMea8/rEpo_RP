<?php require_once("includes/settings.php");
	  require_once("../classes/member.class.php");
	$_GET['opt']="Buyer";
	if (class_exists(member)) {
	  	$objMember=new member();
	} else {
  		echo "Class Not Found Error !! Member Class Not Found !";
		exit;
  	}
	
	if ($_REQUEST['edit'] && !empty($_REQUEST['edit'])) {
		$arryMember = $objMember->GetMemberDetail($_REQUEST['edit']);
		$MemberID   = $_REQUEST['edit'];
		
	}

?>
<HTML>
<HEAD>
<TITLE><?=$Config['SiteName']?> :: Buyer Details</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="<?=$Config['AdminCSS']?>" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
	
<table width="520"  border="0" align="center" cellpadding="3" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validate(this);">
  
	 <tr>
    <td colspan="6"  class="head1">
	<? echo $_GET['opt'].' Details';?>
	
	</td>
  </tr>
	<? if(count($arryMember)>0){?>
   <tr>
    <td  align="center"><table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF">
     
	 <tr>
       		 <td colspan="2" align="left"   class="head1">Account Information</td>
        </tr>
	
	     <tr>
        <td width="49%" align="right"   class="blackbold">User Name: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=stripslashes($arryMember[0]['UserName'])?></td>
      </tr>  
	  <tr>
        <td width="49%" align="right"   class="blackbold">Email: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" ><a href="mailto:<?=$arryMember[0]['Email']?>"><?=$arryMember[0]['Email']?></a></td>
      </tr>
      <tr>
        <td width="49%" align="right"   class="blackbold">Password: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=stripslashes($arryMember[0]['Password'])?></td>
      </tr>
	 
	  
	  
	  
      <? if($arryMember[0]['JoiningDate'] > 0){?>
      <tr>
        <td align="right"   class="blackbold">Joining Date: </td>
        <td height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><? echo $arryMember[0]['JoiningDate']?></td>
      </tr>
      <? } ?>
      <? if($arryMember[0]['ExpiryDate'] > 0){?>
      <tr>
        <td align="right"   class="blackbold">Expiry Date: </td>
        <td height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><? echo $arryMember[0]['ExpiryDate']?></td>
      </tr>
      <? } ?>
      <tr <? if(empty($_GET['edit'])) echo 'Style="display:none"'?>>
        <td width="49%" align="right"   class="blackbold" 
		>Status: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF"  class="blacknormal">
          <? 
		  	
			
				 if($arryMember[0]['Status'] == 1) echo 'Active';
				 else echo 'InActive';
			
		  ?>         </td>
      </tr>
	  
	    <tr>
        <td width="49%" align="right"   class="blackbold"> Subscribe for Email Service: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal">
		 <?  if($arryMember[0]['EmailSubscribe'] == 1) { echo 'Yes';}else echo 'No';?>
		</td>
      </tr>
  <tr style="display:none">
        <td width="49%" align="right"   class="blackbold"> Subscribe for SMS Service: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal">
		 <?  if($arryMember[0]['SmsSubscribe'] == 1) { echo 'Yes';}else echo 'No';?>
		</td>
      </tr>   
	  <tr>
       		 <td colspan="2" align="left"   class="head1">Personal Information</td>
        </tr>
	  
	   <tr>
        <td width="49%" align="right"   class="blackbold"> First Name: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=stripslashes($arryMember[0]['FirstName'])?></td>
      </tr>
	    <tr>
        <td width="49%" align="right"   class="blackbold"> Last Name: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=stripslashes($arryMember[0]['LastName'])?></td>
      </tr>
	  <tr style="display:none">
        <td width="49%" align="right"   class="blackbold">ID Number: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=$arryMember[0]['IDNumber']?></td>
      </tr>
	 
	   <tr>
        <td align="right"   class="blackbold" valign="top">Address: </td>
        <td height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=nl2br(stripslashes($arryMember[0]['Address']))?></td>
      </tr>
      <tr>
        <td width="49%" align="right"   class="blackbold"> Country: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=$arryMember[0]['Country']?></td>
      </tr>
      <tr>
        <td width="49%" align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State: </td>
        <td width="63%" align="left" id="state_td" class="blacknormal"><?=$arryMember[0]['State']?></td>
      </tr>
      <tr>
        <td width="49%" align="right"   class="blackbold"> City: </td>
        <td width="63%" height="30" id="city_td" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=$arryMember[0]['City']?></td>
      </tr>
	   <tr>
        <td width="49%" align="right"   class="blackbold"> Post Code: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=$arryMember[0]['PostCode']?></td>
      </tr>
	   <tr>
        <td width="49%" align="right"   class="blackbold">Landline Number: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=$arryMember[0]['LandlineNumber']?></td>
      </tr>
	  
      <tr>
        <td width="49%" align="right"   class="blackbold">Mobile Number: </td>
        <td width="63%" height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=$arryMember[0]['Phone']?></td>
      </tr>
      <tr>
        <td align="right"   class="blackbold">Fax: </td>
        <td height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=$arryMember[0]['Fax']?></td>
      </tr>  
	  <tr>
       		 <td colspan="2" align="left"   class="head1">Company Information</td>
        </tr>
	  <tr>
        <td align="right"   class="blackbold">Company Name: </td>
        <td height="30" align="left" bgcolor="#FFFFFF" class="blacknormal"><?=stripslashes($arryMember[0]['CompanyName'])?></td>
      </tr>
  
	 <tr>
        <td align="right"   class="blackbold"> Contact Person: </td>
        <td  height="30" align="left" bgcolor="#FFFFFF"><?=stripslashes($arryMember[0]['ContactPerson'])?>          </td>
      </tr>
	  
	 <tr style="display:none">
        <td align="right"   class="blackbold"> Position: </td>
        <td  height="30" align="left" bgcolor="#FFFFFF"><?=stripslashes($arryMember[0]['Position'])?>
           </td>
      </tr>


	 <tr style="display:none">
        <td align="right"   class="blackbold"> Registration Number: </td>
        <td  height="30" align="left" bgcolor="#FFFFFF"><?=stripslashes($arryMember[0]['RegistrationNumber'])?>         </td>
      </tr>  
	 
	 <tr>
        <td align="right"   class="blackbold"> Contact Number: </td>
        <td  height="30" align="left" bgcolor="#FFFFFF"><?=stripslashes($arryMember[0]['ContactNumber'])?>   </td>
      </tr>
	  
	 
	 
	 
      
	  
    </table></td>
   
  </tr>
 <? }else{?>
  <tr>
    <td height="250" align="center" colspan=2><div class="message"><? echo $MSG[66];?></div>
</td>
  </tr>
   <? }?>
  <tr>
    <td height="50" align="center" colspan=2><input name="button2" type="button" class="inputbox" value="Close" onClick="window.close();">
</td>
  </tr>


</table>
</body>
</html>
