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
        <td height="15"><table width="100%" border="0" cellpadding="4" cellspacing="1" class="generaltxt_inner">
          <form action="#" method="post" name="form1" id="form1" onsubmit="javascript:return ValidateForm(this);">
            <tr>
              <td height="43" align="right"  >Member's Type&nbsp;</td>
              <td align="left" ><select name="MemberType" id="MemberType" class="txtfield" onchange="Javascript:ChangeType();">
                  <option value="Seller" <? if($_GET['opt'] == 'Seller') echo 'selected';?>> Seller </option>
                  <option value="Buyer" <? if($_GET['opt'] == 'Buyer') echo 'selected';?>> Buyer </option>
                </select>              </td>
            </tr>
            <tr>
              <td width="14%" align="right" valign="top" style="padding-top:8px;"   nowrap="nowrap"> Select Members <span class="bluestar">*</span></td>
              <td width="86%" align="left"  valign="top"><?  if(sizeof($arrayMember)>18) { $DivStyle = 'style="height:310px;overflow:auto "';} ?>
                  <div <?=$DivStyle?>>
                    <table width="100%"  border="0" class="outline">
                      <tr>
                        <?   
				  		$flag = 0;
					   if(sizeof($arrayMember)>0) {					   
					  for($i=0;$i<sizeof($arrayMember);$i++) { 
					  
					  	if ($flag % 3 == 0) {
							echo "</tr><tr>";
						}
						
						$Line = $flag+1;
					   ?>
                        <td align="left"  valign="top" class="greentxt">
						
						<input type="checkbox" name="Email[]" id="Email<?=$Line?>" value="<?=$arrayMember[$i]['MemberID']?>"
						<? if(!empty($arrayMember[$i]['bulkID']) && $arrayMember[$i]['BulkType']==$_GET['tp']) echo " checked"; ?> />
						 
                          <?=stripslashes($arrayMember[$i]['UserName'])?>  
						</td>
                        <?
						  $flag++;
						  } 
						  ?>
                      </tr>
                      <? }  else { ?>
                      <tr align="center">
                        <td  class="redtxt">
						 No <?=$_GET['opt']?>s have subscribed. </td>
                      </tr>
                      <? } ?>
                    </table>
                    <input type="hidden" name="NumMembers" id="NumMembers" value="<? echo sizeof($arrayMember);?>" />
                  </div>
                <?  if(sizeof($arrayMember)>1) {	?>
                  <table width="100%"  border="0">
                    <tr>
                      <td align="right" class="skytxt"><a href="javascript:SelectAllEmails();" >
                        <?=SELECT_ALL?>
                        </a> <span > | </span> <a href="javascript:SelectNoneEmails();">
                          <?=SELECT_NONE?>
                        </a>&nbsp;</td>
                    </tr>
                  </table>
                <? } ?>              </td>
            </tr>

            <tr>
              <td align="center" height="40" valign="middle" >&nbsp;</td>
              <td align="left" valign="middle" ><input name="SubmitButton" id="SubmitButton" type="image" value=" " src="images/submit.jpg" width="88" height="31" />
                  <input type="hidden" name="BulkType" id="BulkType" value="<? echo $_GET['tp'];?>" />
                
				  
				  
				               </td>
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
