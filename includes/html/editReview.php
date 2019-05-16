<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
    <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		
		<span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>  <a href="viewReviews.php"><?=MY_REVIEWS?></a>  </span> Edit Review</td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading">Edit Review
        </td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	   	 <tr>
            <td colspan="2" align="right" height="35"  valign="top"  class="skytxt">
			<a href="viewReviews.php">
              <? echo MY_REVIEWS; ?>
            </a></td>
          </tr>
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
          <form action=""  method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validate(this);">
           
       
            <tr>
              <td align="center" valign="top"  bgcolor="#FFFFFF" height="200" >
               
                <div id="MsgDiv">
                    <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
					  
					  <tr>
                        <td><table width="100%" border="0" align="right" cellpadding="5" cellspacing="0" >
                          <tr>
                            <td width="15%"   align="right" valign="top" class="generaltxt_inner">Store</td>
                            <td align="left" valign="top" class="skytxt">
							<? 
		$StoreLink = $Config['StorePrefix'].$arryRankingDetails[0]['UserName'].'/store.php';
		echo '<a href="'.$StoreLink.'"  target="_blank">'.stripslashes($arryRankingDetails[0]['CompanyName']).'</a><br>'; 
		?>							</td>
                          </tr>
                          <tr>
                            <td   align="right" valign="top" class="generaltxt_inner"><?=ASSIGN_RANK?>
                                <span class="bluestar">*</span></td>
                            <td width="85%" align="left" valign="top" class="skytxt" >
								<?
								for($i=5;$i>=0;$i--){
									$Checked = ($arryRankingDetails[0]['Points']==$i)?(" checked"):("");
									echo '<input type="radio" name="Points" id="Points" value="'.$i.'" '.$Checked.'/>
                               			  <img src="images_small/'.$i.'star.png" /> <br />';
								}
								?>
                                <!--<input type="radio" name="Points" id="Points" value="-5" />-->
                               &nbsp;<a href="report.php?mId=<?=$arryRankingDetails[0]['MemberID']?>"  ><?=REPORT_OFFENSIVE_CONTENT?></a> <br />                            </td>
                          </tr>
                          <tr>
                            <td height="40" align="right" valign="top" class="generaltxt_inner"><?=COMMENTS?> <span class="bluestar">*</span></td>
                            <td >
							<textarea name="Message" class="txt-feild" id="Message" style="width:300px; height:150px;"><?=stripslashes($arryRankingDetails[0]['Message'])?></textarea> 
                                <span class="txt">
                                <?=BETWEEN_10_500?>
                              </span></td>
                          </tr>
                          <tr>
                            <td height="42"   align="right" valign="top" class="generaltxt_inner">Status</td>
                            <td align="left" valign="top" >
			 <? 
		if($arryRankingDetails[0]['Status'] ==1){
			  $status = '<span class=greentxt>Active</span>';
		 }else{
			  $status = '<span class=red12>InActive</span>';
		 }			
		 
		 echo  $status;
							?></td>
                          </tr>
                          <tr>
                            <td height="42"   align="right" valign="top" ></td>
                            <td align="left"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="80"><input type="image" name="SubmitButton"  id="SubmitButton" src="images/update.jpg" width="72" height="24" value=" "  alt=" Submit " title=" Submit " /></td>
                                  <td >
			  <input type="reset" name="Reset"  width="72" height="24" value=" " class="ResetContact"  />
				  <input type="hidden" name="RaterID" id="RaterID" value="<?=$_SESSION['MemberID']?>" />
				  <input type="hidden" name="RecieverID" id="RecieverID" value="<?=$arryRankingDetails[0]['MemberID']?>" />
									  
					 <input type="hidden" name="RankingID" id="RankingID" value="<?=$_GET['edit']?>" />									  </td>
                                </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
                </div>
                </td>
            </tr>
         
          
           
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
