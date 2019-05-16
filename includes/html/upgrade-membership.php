<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
     
	   <tr>
        <td  align="left" valign="middle" class="heading"><?=UPGRADE_MEMBERSHIP?></td>
      </tr>
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> 
          <?=$Nav_MemberPortal?>
          </span>
              <?=UPGRADE_MEMBERSHIP?></td>
      </tr>
    
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
                <form action=""  method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validate(this);">
                  <tr>
                    <td   ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="left"  height="280" bgcolor="#ffffff" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
                               
							   
													   
							<tr>
							  <td colspan="2" class="txt" style="text-align:right" >
							  
			
                                          <a href="#TopTable"  >
                                            <?=CLICK_VIEW_MEBERSHIP?>
                                            </a>
                                     		  
							  
							  
							  </td>
							</tr>   
							   
							   
							   	<tr>
								  <td colspan="2" height="20" class="graybox" ><?=MEMBERSHIP_HISTORY?></td>
								</tr>	
								
							   
							    <tr>
                                  <td>
                                      <table width="100%" border="0" cellpadding="0" cellspacing="0"  >
                                        <tr>
                                          <td height="6" ></td>
                                        </tr>
                                        <tr>
                                          <td  valign="top"  ><? if(sizeof($arryMembershipHistory)>1){ ?>
                                            <table width="100%"  border="0" align="center" cellpadding="2" cellspacing="1" >
                                              <tr bgcolor="#F5F5F5"  >
                                                <td width="39%" height="20" align="left"  ><strong><?=MEMBERSHIP?></strong>
                                                </td>
                                                <td width="23%" align="left" ><strong><?=ACTIVATED_ON?></strong>
                                                </td>
                                                <td width="18%" align="left" ><strong><?=EXPIRES_ON?></strong>
                                                </td>
                                                <td width="20%" align="left" ><strong><?=AMOUNT_PAID?></strong>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td height="1" bgcolor="#d6d6d6" colspan="4" style="padding:0px; margin:0px;"></td>
                                              </tr>
                                              <tr bgcolor="#F5F5F5">
                                                <td align="left" valign="top" bgcolor="#FBFBFB" colspan="4">
												<div style="overflow:auto1; height:300px;width:100%; vertical-align:top;  " id="HistoryDiv">
                                                  
                                                      <table width="100%" border="0" cellspacing="1" cellpadding="2" align="center"  class="txt" >
                                                        <? 
						for($i=0;$i<sizeof($arryMembershipHistory);$i++) { 
							
							?>
                                                        <tr bgcolor="#F5F5F5">
                                                          <td align="left" height="30" width="39%" valign="middle" bgcolor="#FBFBFB"><?=$arryMembershipHistory[$i]['PackageName']?></td>
                                                          <td align="left" width="23%" valign="middle" bgcolor="#FBFBFB"><? if($arryMembershipHistory[$i]['StartDate'] > 0){	
								echo date("jS F,  Y", strtotime($arryMembershipHistory[$i]['StartDate']));
							}
							?></td>
                                                          <td align="left" width="18%" valign="middle" bgcolor="#FBFBFB"><? if($arryMembershipHistory[$i]['EndDate'] > 0){	
								echo date("jS F,  Y", strtotime($arryMembershipHistory[$i]['EndDate']));
							}
							?>
                                                          </td>
                                                          <td align="left" width="20%" valign="middle" bgcolor="#FBFBFB">
														  
                                                            <? 
															if($arryMembershipHistory[$i]['Payment']==1){
																echo $arryMembershipHistory[$i]['Price'].' '.$Config['Currency']; 
															}else{
																echo '<span class=red>Pending</span>';
															}
															/*
															if(!empty($arryMembershipHistory[$i]['PaymentGateway'])){
																echo '<br>('.$arryMembershipHistory[$i]['PaymentGateway'].')';
															}*/
															?>
															
															</td>
                                                        </tr>
														
														
											<? if($i<sizeof($arryMembershipHistory)-1){ ?>
											
											<tr>
                                                <td height="1" bgcolor="#d6d6d6" colspan="4" style="padding:0px; margin:0px;"></td>
                                              </tr>
											  <? } ?>
											  
											  
														
                                                        <? } ?>
                                                      </table>
                                                 
                                                </div></td>
                                              </tr>
                                            </table>
                                            <? }else{ ?>
                                              <table width="100%" border="0" align="center" cellpadding="4" cellspacing="2" bgcolor="#ffffff"  >
                                                <tr>
                                                  <td align="right" valign="top"   nowrap="nowrap">
												  <?=MEMBERSHIP?> :
                                                    </td>
                                                  <td align="left"  class="verdan11"><?=stripslashes($arryMember[0]['Membership'])?></td>
                                                </tr>
                                                <? if($arryMembershipHistory[0]['Price']>0){ ?>
                                                <tr>
                                                  <td align="right" valign="top"   nowrap="nowrap">
												  <?=AMOUNT_PAID?> :
                                                    </td>
                                                  <td align="left"  class="verdan11">
                                                    <?=round($arryMembershipHistory[0]['Price'],2)?> <?=$Config['Currency']?></td>
                                                </tr>
                                                <? } ?>
                                                <tr>
                                                  <td width="12%" align="right" valign="top"   nowrap="nowrap">
												  <?=ACTIVATED_ON?> :
                                                    </td>
                                                  <td width="88%" align="left" class="verdan11"><?=date("jS F,  Y", strtotime($arryMember[0]['JoiningDate']))?>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td align="right" valign="top"  ><?=EXPIRES_ON?>
                                                    : </td>
                                                  <td align="left" class="verdan11"><?=date("jS F,  Y", strtotime($arryMember[0]['ExpiryDate']))?>
                                                  </td>
                                                </tr>
                                              </table>
                                            <? } ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td height="6" ></td>
                                        </tr>
                                      </table>
                                    </td>
                                </tr>
                              </table>
                           </td>
                        </tr>
                      </table>
                        </div>
                    </td>
                  </tr>
                 
                  
                  <tr>
                    <td align="center" valign="top">
<table width="100%" border="0" cellpadding="2" cellspacing="0" class="blacktxt" id="TopTable">
													
													
													
										  
										  
								<tr>
								  <td colspan="2" height="16" class="skytxt" align="right" >
								  
								 <a href="#" alt="<?=BACK_TO_TOP?>" title="<?=BACK_TO_TOP?>" >
                                          <?=BACK_TO_TOP?>
                                        </a>  
								  
								  </td>
								</tr>			  
								<tr>
								  <td colspan="2" height="20" class="graybox" ><?=MEMBERSHIP_OFFERED?></td>
								</tr>	
		
		<tr>
								  <td colspan="2" height="10" ></td>
								</tr>
													
													
													
       <? 
	    $Line = 1;
	  	if(sizeof($arryMembership)>0) { 
	  		for($i=0;$i<sizeof($arryMembership);$i++) {
			
			if($Line<3)
				$Line++;
	  ?>
                                                       
											<tr>
                                                <td height="1" bgcolor="#d6d6d6" colspan="4" style="padding:0px; margin:0px;"></td>
                                              </tr>			   
													<tr>
                                                <td height="6" colspan="4"></td>
                                              </tr>   
											
							
                                                        <tr>
                                                        
                                                          <td width="86%" valign="top">
<a href="payment-gateway.php?pkID=<?=$arryMembership[$i]['MembershipID']?>"><strong> <?=stripslashes($arryMembership[$i]['Name'])?></strong></a><br />
                                                            <div class="simpletxt">                                                              (<?=$arryMembership[$i]['Price']?> <?=$Config['Currency']?>
                                                              for
                                                              <?=$arryMembership[$i]['Validity']?>
                                                              days)</div>
                                                            <br />
															<!--
															<strong><?=EMAIL_CREDITS?>:</strong> <?=$arryMembership[$i]['MaxEmail']?>
															 <br />
															 <strong><?=SMS_CREDITS?>:</strong> <?=$arryMembership[$i]['MaxSms']?>
															  <br /><br />-->
                                                            <?=stripslashes($arryMembership[$i]['Description']);?></td>
                                                        </tr>
											<tr>
                                                <td height="6" colspan="4"></td>
                                              </tr>
														
										
                                                        <? } } else { ?>
                                                        <tr>
                                                          <td colspan="2"  align="center" height="45"><?=NO_MEMBERSHIP_OFFERED?></td>
                                                        </tr>
                                                        <? } ?>
                                                        <tr>
                                                          <td colspan="2">&nbsp;</td>
                                                        </tr>
                                                    </table>					
					
					
					</td>
                  </tr>
				  
				  
				  
                </form>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
