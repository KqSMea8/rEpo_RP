        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=$PolicyTabTitle?></div>
            </td>
          </tr>
		     <tr>
            <td height="313" class="featuretable_border"  align="center" valign="top">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
		
			
              <tr>
                <td  class="generaltxt_inner">
				
				<? echo stripslashes($arrySite[0]['PolicyContent']);?>
                </td>
              </tr>
            </table></td>
          </tr>
		  
		  <?
		   if(!empty($_SESSION['MemberID']) && $_SESSION['MemberID']!=$_SESSION['StoreID']){
		
		   ?>
						  <tr>
                            <td class="generaltxt" style="text-align:right" height="50" align="right">
		<?					
		if(!$objBulk->isMemberSubscribed($_SESSION['MemberID'],$_SESSION['StoreID'],'email')){
			echo '<a href="'.$Config['Url'].'subscribe.php?Type=email&MemberID='.$_SESSION['MemberID'].'&StoreID='.$_SESSION['StoreID'].'&pId='.$_GET['id'].'&UserName='.$_SESSION['StoreUserName'].'" onclick="return confDel(\''.SUSBCRIBE_FOR_EMAIL_ALERT.'\')">'.SUSBCRIBE_FOR_EMAIL.'</a> ';
			$Separator = ' | ';
		}
		
		if(!$objBulk->isMemberSubscribed($_SESSION['MemberID'],$_SESSION['StoreID'],'sms')){
			echo $Separator .' <a href="'.$Config['Url'].'subscribe.php?Type=sms&MemberID='.$_SESSION['MemberID'].'&StoreID='.$_SESSION['StoreID'].'&pId='.$_GET['id'].'&UserName='.$_SESSION['StoreUserName'].'" onclick="return confDel(\''.SUSBCRIBE_FOR_SMS_ALERT.'\')">'.SUSBCRIBE_FOR_SMS.'</a> ';
		}
		?>
						
						&nbsp;&nbsp;	
							</td>
                          </tr>		  
						  <? } ?>
		  
         
        </table>
    </td>
  </tr>
</table>

