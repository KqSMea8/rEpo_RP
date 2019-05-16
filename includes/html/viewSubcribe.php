<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		

		<span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>  </span> <?=$ModTitle?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=$ModTitle?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
        <tr>
              <td colspan="2" align="center" valign="top" class="redtxt" height="35">
			  <? if(!empty($_SESSION['mess_bulk'])) {echo $_SESSION['mess_bulk']; unset($_SESSION['mess_bulk']); }?></td>
            </tr>

		  <tr>
        <td height="15"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="generaltxt_inner">
          <form action="#" method="post" name="form1" id="form1" >
            <tr>
              <td width="14%" align="right" valign="top" style="padding-top:8px;"   nowrap="nowrap"> My Subscribed Stores : </td>
              <td width="86%" align="left"  valign="top"><?  if(sizeof($arrayMember)>18) { $DivStyle = 'style="height:410px;overflow:auto "';} ?>
                  <div <?=$DivStyle?>>
                    <table width="100%"  border="0" class="outline">
                      <tr>
                        <?   
				  		$flag = 0;
					   if(sizeof($arrayMember)>0) {					   
					  for($i=0;$i<sizeof($arrayMember);$i++) { 
					  	/*
					  	if ($flag % 3 == 0) {
							echo "</tr><tr>";
						}*/
						
						$Line = $flag+1;
						
						$StoreLink = $Config['StorePrefix'].$arrayMember[$i]['UserName'].'/store.php';

						
					   ?>
					   <tr>
                        <td align="left"  valign="top" >
						
						<input type="checkbox" name="Email[]" id="Email<?=$Line?>" value="<?=$arrayMember[$i]['bulkID']?>"
						 />
						<span class="blacktxt"><?=stripslashes($arrayMember[$i]['CompanyName'])?></span> -
						 <a href="<?=$StoreLink?>" class="greentxt"><?=GO_TO_STORE?></a>
                         
						  		</td></tr>
                        <?
						  $flag++;
						  } 
						  ?>
                     
                      <? }  else { ?>
                      <tr align="center">
                        <td  class="redtxt"> No Subscriptions
                          </td>
                      </tr>
                      <? } ?>
                    </table>
                    <input type="hidden" name="NumMembers" id="NumMembers" value="<? echo sizeof($arrayMember);?>" />
                  </div>
              
                  <table width="100%"  border="0">
                    <tr>
                      <td align="right" class="skytxt">
					    <?  if(sizeof($arrayMember)>1) {	?>
					  <a href="javascript:SelectAllEmails();" >
                        <?=SELECT_ALL?>
                        </a> <span > | </span> <a href="javascript:SelectNoneEmails();">
                          <?=SELECT_NONE?> 
                        </a> <span > | </span> <? } ?> 
							
						   <?  if(sizeof($arrayMember)>0) {	?>	
                         <a href="javascript:ValidateForm('form1');"> <?=REMOVE?></a>
						 <? } ?>
                        &nbsp;</td>
                    </tr>
                  </table>
                             </td>
            </tr>

            <tr>
              <td align="center" height="40" valign="middle" >&nbsp;</td>
              <td align="left" valign="middle" >
                  <input type="hidden" name="BulkType" id="BulkType" value="<? echo $_GET['tp'];?>" />				               <input name="SubmitButton" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31" style="display:none" /></td>
            </tr>
          </form>
        </table></td>
      </tr>
		
		
    </table></td>
    <td width="244"  valign="top"><? require_once("includes/html/box/right.php"); ?>    </td>
  </tr>
</table>
</td>
  </tr>
</table>
