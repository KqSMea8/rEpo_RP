<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td valign="top" width="17%"><? if (empty($_SESSION['UserName']) && empty($_SESSION['MemberID'])) {
			 	include('includes/html/box/left.php'); 
	 		}else{
				include('includes/html/box/left_member.php'); 
			}	 
	    ?></td>
        
        <td align="left" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
	<form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">		
          <tr>
            <td  >
				
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="8" height="26" background="images/bg-blue-left.jpg">&nbsp;</td>
                    <td bgcolor="#15507A" class="heading" ><?=COMPANY_PROFILE?></td>
                    <td width="6" background="images/bg-blue-right.jpg">&nbsp;</td>
                  </tr>
                </table></td>
          </tr>
        
	
  
		
		
<? if(sizeof($arryMember)>0){ ?>				 
<tr>
<td align="center" valign="top"  bgcolor="#FFFFFF" >
<table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  
    <td bgcolor="#ffffff" valign="top" >&nbsp;</td>
  </tr>
</table>
<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td>
	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="128" height="24" bgcolor="#999797" class="whit-txt" nowrap="nowrap"><?php echo strtoupper(stripslashes($arryMember[0]['CompanyName'])); ?> </td>
    <td width="677">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline" >
  <tr>
    <td height="6" ></td>
    </tr>
  <tr>
    <td  valign="top" height="110" >
	
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
	  <tr>
	  
	   <?php if($arryMember[0]['Image'] !='' && file_exists('upload/company/'.$arryMember[0]['Image']) ){ ?>
	   
		<td width="118" valign="top" >
		
			<?php 
			//imageThumb('upload/company/'.$arryMember[0]['Image'],'upload/company/thumb/'.$arryMember[0]['Image'],118,120);
			//$ImagePath = 'upload/company/thumb/'.$arryMember[0]['Image']; 
			
			$ImagePath = 'resizeimage.php?img=upload/company/'.$arryMember[0]['Image'].'&w=118&h=120'; 

			
			$ImagePath = '<a href="upload/company/'.$arryMember[0]['Image'].'" target="_blank" ><img src="'.$ImagePath.'"  border="0"/></a>';
			echo $ImagePath;
		   ?>		   </td>
		   <? } ?>
		   
		<td valign="top">
		
		<? if($arryMember[0]['CompanyDescription'] != ''){ ?>
		<Div class="verdan11" style="text-align:justify">
		<?php echo nl2br(stripslashes($arryMember[0]['CompanyDescription'])); ?>
		</Div>
		<br>
		<? }?>
		
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#ffffff"  >
          <tr>
            <td align="left" valign="top" bgcolor="#F9F7F8"   class="simpletxt"><?=BUSINESS_TYPE?>
              : </td>
            <td align="left"  bgcolor="#F9F7F8"  class="verdan11"><?=stripslashes($arryMember[0]['BussinessType'])?></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#F9F7F8"   class="simpletxt"><?=YEAR_ESTABLISHED?>
              : </td>
            <td align="left"  bgcolor="#F9F7F8"  class="verdan11"><?=$arryMember[0]['YearEstablished']?>            </td>
          </tr>
          <tr>
            <td width="19%" align="left" valign="top" bgcolor="#F9F7F8"   class="simpletxt"><?=COUNTRY?>
              : </td>
            <td width="81%" align="left" bgcolor="#F9F7F8"  class="verdan11"><?=stripslashes($arryMember[0]['Country'])?>            </td>
          </tr>
      
          <?php if($arryMember[0]['Website'] != ''){ ?>
          <tr>
            <td align="left" valign="top" bgcolor="#F9F7F8"  class="simpletxt" ><?=WEBSITE?>
              : </td>
            <td align="left" bgcolor="#F9F7F8"  class="verdan11"><a href="<?=$arryMember[0]['Website']?>" target="_blank"><?=$arryMember[0]['Website']?></a></td>
          </tr>
          <? } ?>
        </table></td>
	  </tr>
	</table>	</td>
    </tr>

</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10"></td>
    <td width="536" height="5" bgcolor="#C7C5C5"></td>
    <td width="10"></td>
  </tr>
</table>

<? if($_SESSION['MemberID'] != $_GET['view']) { ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td width="651" height="20">&nbsp;</td>
    <td width="75"><input  class="button" type="button" name="Submit2" value="<?=SEND_EMAIL?>" alt="<?=SEND_EMAIL?>" title="<?=SEND_EMAIL?>" onclick="Javascript: location.href='send-email.php?cmp=<?=$_GET[view]?>';"/></td>
    </tr>
   <tr>
    <td height="10" colspan="2"></td>
  </tr>
</table>
<? } ?>
	
	</td>
  </tr>
</table>
<table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td bgcolor="#ffffff" valign="top" >&nbsp;</td>
  </tr>
</table>
<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td width="128" height="24" bgcolor="#999797" class="whit-txt" nowrap="nowrap">
		<?=strtoupper(OTHER_INFORMATION)?> </td>
        <td width="677">&nbsp;</td>
      </tr>
    </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline" >
          <tr>
            <td height="6" ></td>
          </tr>
          <tr>
            <td  valign="top" height="110" >
			
			<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#ffffff"  >
      <tr>
        <td width="17%" align="left" bgcolor="#F9F7F8" class="simpletxt"><?=CONTACT_PERSON?> : </td>
        <td width="83%" height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?php echo stripslashes($arryMember[0]['Name']); ?></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#F9F7F8" class="simpletxt"><?=DESIGNATION?> : </td>
        <td height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?php echo stripslashes($arryMember[0]['Designation']); ?></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#F9F7F8" class="simpletxt"><?=DATE_OF_BIRTH?> 
          : </td>
        <td height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?=$arryMember[0]['date_of_birth']?> </td>
      </tr>
      <tr>
        <td align="left" bgcolor="#F9F7F8" class="simpletxt" valign="top"><?=MAIN_MARKETS?>  
          : </td>
        <td height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?=nl2br(stripslashes($arryMember[0]['MainMarkets']))?></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#F9F7F8" class="simpletxt" valign="top"><?=ADDRESS?> 
          : </td>
        <td height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?=nl2br(stripslashes($arryMember[0]['Address']))?></td>
      </tr>
      <tr>
        <td width="17%" align="left" bgcolor="#F9F7F8" class="simpletxt"> <?=COUNTRY?> 
          : </td>
        <td width="83%" height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?=$arryMember[0]['Country']?></td>
      </tr>
      <tr>
        <td width="17%" align="left" valign="middle" nowrap="nowrap" bgcolor="#F9F7F8" class="simpletxt"> <?=STATE?> 
          : </td>
        <td width="83%" align="left" bgcolor="#F9F7F8" class="verdan11"><?=$arryMember[0]['State']?></td>
      </tr>
      <tr>
        <td width="17%" align="left" bgcolor="#F9F7F8" class="simpletxt"> 
          <?=CITY?>
        : </td>
        <td width="83%" height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?=$arryMember[0]['City']?> </td>
      </tr>
	   <tr>
        <td width="17%" align="left" bgcolor="#F9F7F8" class="simpletxt"><?=POSTAL_CODE?> : </td>
        <td width="83%" height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?php echo $arryMember[0]['PostCode']; ?></td>
      </tr>
      <tr>
        <td width="17%" align="left" bgcolor="#F9F7F8" class="simpletxt"><?=PHONE?> 
          : </td>
        <td width="83%" height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?php echo $arryMember[0]['Phone']; ?></td>
      </tr>
      <tr>
        <td align="left" bgcolor="#F9F7F8" class="simpletxt"><?=FAX?> 
          : </td>
        <td height="30" align="left" bgcolor="#F9F7F8" class="verdan11"><?php echo $arryMember[0]['Fax']; ?></td>
      </tr>
     
                    </table></td>
                </tr>
            </table>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="10"></td>
            <td width="536" height="5" bgcolor="#C7C5C5"></td>
            <td width="10"></td>
          </tr>
        </table>
		
	<? if($_SESSION['MemberID'] != $_GET['view']) { ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td width="651" height="20">&nbsp;</td>
    <td width="75"><input  class="button" type="button" name="Submit2" value="<?=SEND_EMAIL?>" alt="<?=SEND_EMAIL?>" title="<?=SEND_EMAIL?>" onclick="Javascript: location.href='send-email.php?cmp=<?=$_GET[view]?>';"/></td>
    </tr>
   <tr>
    <td height="10" colspan="2"></td>
  </tr>
</table>
<? } ?>	
     
	  
	  
	  </td>
  </tr>
</table>
<table width="89%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td bgcolor="#ffffff" valign="top" align="center" >&nbsp;</td>
  </tr>
</table></td>
</tr>
<? }else{ ?>

 <tr>
       <td bgcolor="#F9F7F8"  height="130" valign="middle" align="center" class="border01 redtxt" ><?=NO_RECORD_FOUND?></td>
   </tr>
<? } ?>
		  
          <tr>
            <td bgcolor="#CCCCCC" height="1" style="padding:0px; margin:0px;"></td>
          </tr>
          <tr>
            <td height="6" ></td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr></form>
        </table></td>
		
				
  </tr>
    </table></td>
  </tr>
</table>
