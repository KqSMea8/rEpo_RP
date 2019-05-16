<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <a href="Javascript:window.history.go(-1)"><?=SEARCH_PRODUCTS?></a> 
              <a href="review.php?mId=<?=$_GET['mId']?>&pId=<?=$_GET['pId']?>"><?=BUYERS_REVIEWS?></a> </span> <?=WRITE_REVIEW?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=WRITE_REVIEW?>
        </td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	    <tr>
        <td valign="top">
		
	  	<? include("includes/html/box/review_top.php");?>
	  
 		</td>
      </tr>
	  
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
          <form action=""  method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validate(this);">
           
            <? if(sizeof($arryMember)>0){ ?>
            <tr>
              <td align="center" valign="top"  bgcolor="#FFFFFF" height="200" >
                  <div id="MsgDiv_Rank" align="center" class="redtxt"></div>
                <div id="MsgDiv">
                    <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
					  
					  <tr>
                        <td><table width="100%" border="0" align="right" cellpadding="5" cellspacing="0" class="outline" >
                          <tr>
                            <td   align="right" valign="top" ><?=ASSIGN_RANK?>
                                <span class="bluestar">*</span></td>
                            <td width="83%" align="left" valign="top"  class="skytxt" >
							
							
                                
                              <?
								for($i=5;$i>=0;$i--){
									//$Checked = ($arryRankingDetails[0]['Points']==$i)?(" checked"):("");
									echo '<input type="radio" name="Points" id="Points" value="'.$i.'" '.$Checked.'/>
                               			  <img src="images_small/'.$i.'star.png" /> <br />';
								}
								?>
								<!--<input type="radio" name="Points" id="Points" value="-5" />-->
                                &nbsp;<a href="report.php?mId=<?=$_GET['mId']?>" ><?=REPORT_OFFENSIVE_CONTENT?></a>
                                <br />
                            </td>
                          </tr>
                          <tr>
                            <td height="40" align="right" valign="top" ><?=COMMENTS?> <span class="bluestar">*</span></td>
                            <td ><textarea name="Message" class="txt-feild" id="Message" style="width:300px; height:150px;"></textarea> 
                                <span class="txt">
                                <?=BETWEEN_10_500?>
                              </span></td>
                          </tr>
                          <tr>
                            <td height="42"   align="right" valign="top" ></td>
                            <td align="left"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="80"><input type="image" name="SubmitButton"  id="SubmitButton" src="images/add.jpg" width="72" height="24" value=" "  alt=" Submit " title=" Submit " <?=$DisabledButton?>/></td>
                                  <td ><input type="reset" name="Reset"  width="72" height="24" value=" " class="ResetContact"  <?=$DisabledButton?>/>
                                      <input type="hidden" name="RaterID" id="RaterID" value="<?=$_SESSION['MemberID']?>" />
                                      <input type="hidden" name="RecieverID" id="RecieverID" value="<?=$_GET['mId']?>" /></td>
                                </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                </div>
                </td>
            </tr>
            <? }else{ ?>
            <tr>
              <td  height="130" valign="middle" align="center" class="border01 redtxt" ><?=NO_MEMBER_EXIST?></td>
            </tr>
            <? } ?>
          
           
          </form>
        </table></td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
  </tr>
</table>
