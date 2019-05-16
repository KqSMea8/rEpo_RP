<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
       
	   <tr>
        <td  align="left" valign="middle" class="heading">
		<?=stripslashes($arryMember[0]['CompanyName'])?></td>
      </tr>

      
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
                <form action=""  method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validate(this);">

  <? if(sizeof($arryMember)>0){ ?>
				  

				  
	<tr>
		<td  height="10" align="right">
											<input  class="button" type="button" name="Submit2" value="Browse Products" alt="Browse Products" title="Browse Products" onclick="Javascript: location.href='category.php?StoreID=<?=$_GET['StoreID']?>';"/>

		
		</td>
	</tr>
                  <tr>
                    <td align="center" valign="top"  ><table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
                        <tr>
                          <td>
                              <table width="100%" border="0" cellpadding="0" cellspacing="0"  >
                                <tr>
                                  <td  valign="top" height="110" ><table  width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
     <? if($arryMember[0]['Image'] !='' && file_exists('upload/company/'.$arryMember[0]['Image']) ){ ?>
                                        <td align="left" valign="top" class="imgborder_prd22" ><?
			$ImagePath = 'resizeimage.php?img=upload/company/'.$arryMember[0]['Image'].'&w=150&h=150'; 
			
			$ImagePath = '<a href="upload/company/'.$arryMember[0]['Image'].'" rel="lightbox"><img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/></a>';
			echo $ImagePath;
			
		
	?>   
		   
		   </td>
		   <td width="16"> </td>
     <? } ?>
                                        <td valign="top" >
										
										
										
                                            <table  border="0" align="center" cellpadding="3" cellspacing="1" style="display:none"  >
                                             <? if($arryMember[0]['TagLine'] != ''){ ?>
											  <tr>
                                                <td align="left" valign="top"  >
												<?=COMPANY_TAG_LINE?>: </td>
                                                <td align="left" class="generaltxt_inner"><? echo nl2br(stripslashes($arryMember[0]['TagLine'])); ?>                                               </td>
                                              </tr>
											   <? }?>
											  <tr style="display:none">
                                                <td align="left"  valign="top"  ><?=STORE_RATING?>: </td>
                                                <td align="left" ><?=$RatingHTML?>                                                </td>
                                              </tr>
                                   
                                              <? if($arryMember[0]['Website'] != ''){ ?>
                                              <!--<tr>
                                                <td align="left" valign="top"  ><?=WEBSITE?>: </td>
                                                <td align="left" class="skytxt"><a href="<?=$arryMember[0]['Website']?>" target="_blank">
                                                  <?=$arryMember[0]['Website']?>
                                                </a></td>
                                              </tr>-->
                                              <? } ?>
									
										
	   <!--								
	  

   <? 
   $WebUrl = $Config['Url'].$Config['StorePrefix'].$_SESSION['UserName'].'/';
   $StoreUrl = $Config['Url'].$Config['StorePrefix'].$_SESSION['UserName'].'/store.php';
   ?>
   <? if($_SESSION['WebsiteStoreOption']=='w'){ ?>
 <tr>  <td ><?=WEBSITE?>:</td>
<td class="skytxt"><a href="<?=$WebUrl?>"><?=$WebUrl?></a></td></tr>
  <? }else if($_SESSION['WebsiteStoreOption']=='s'){ ?>
 <tr> <td ><?=ONLINE_STORE?>:</td>
  <td class="skytxt"><a href="<?=$StoreUrl?>"><?=$StoreUrl?></a></td></tr>
  <? }else if($_SESSION['WebsiteStoreOption']=='ws'){ ?>
 <tr>  <td ><?=WEBSITE?>:</td>
<td class="skytxt"><a href="<?=$WebUrl?>"><?=$WebUrl?></a></td></tr>
 <tr> <td ><?=ONLINE_STORE?>:</td>
  <td class="skytxt"><a href="<?=$StoreUrl?>"><?=$StoreUrl?></a></td></tr>
  <? } ?>
  	-->	
											  
                                          </table>
										  
								<table width="350" border="0" align="left" cellpadding="3" cellspacing="1" class="txt" >

										
													   
										 <tr>
                                          <td  align="left" colspan="2"   >
										  <B>Welcome to <?=stripslashes($arryMember[0]['CompanyName'])?>!</B>
										  </td>
                                        </tr> 					   
										 <tr>
                                          <td  align="left" colspan="2" >
										<?=nl2br(stripslashes($arryMember[0]['TagLine']))?>
										  </td>
                                        </tr> 									
										 <tr>
                                          <td  align="left" colspan="2" height="24" >
										  </td>
                                        </tr>
										
										 <tr>
                                          <td align="left"  valign="top" width="35%"><B><?=ADDRESS?>:</B> </td>
                                          <td height="24" valign="top" align="left" >

<?
if(!empty($arryMember[0]['Address']))
	echo nl2br(stripslashes($arryMember[0]['Address'])).'<br>';
if(!empty($arryMember[0]['City']))
	echo stripslashes($arryMember[0]['City']).', ';
if(!empty($arryMember[0]['State']))
	echo stripslashes($arryMember[0]['State']).', ';
if(!empty($arryMember[0]['Country']))
	echo '<br>'.stripslashes($arryMember[0]['Country']);
if(!empty($arryMember[0]['PostCode']))
	echo ' - '.stripslashes($arryMember[0]['PostCode']);

?>

										
										  
										  
										  </td>
                                        </tr>

										  <tr>
                                          <td  align="left" class="txt"><B><?=CONTACT_PERSON?>:</B> </td>
                                          <td  height="24" align="left" ><? echo $arryMember[0]['ContactPerson']; ?></td>
                                        </tr> 
										
										<tr>
                                          <td  align="left" ><B><?=CONTACT_NUMBER?>:</B> </td>
                                          <td  height="24" align="left" ><? echo $arryMember[0]['ContactNumber']; ?></td>
                                        </tr> 
					
               
										
									 <tr>
                                          <td  align="left" ><B><?=LANDLINE_NUMBER?>:</B> </td>
                                          <td  height="24" align="left" >
										  <? echo $arryMember[0]['LandlineNumber']; ?></td>
                                        </tr>
											
										
                                        <tr>
                                          <td  align="left" ><B><?=MOBILE_NUMBER?>:</B> </td>
                                          <td  height="24" align="left" ><? echo $arryMember[0]['Phone']; ?></td>
                                        </tr>
										
                                        <tr>
                                          <td align="left" ><B><?=FAX?>:</B> </td>
                                          <td height="24" align="left" ><? echo $arryMember[0]['Fax']; ?></td>
                                        </tr>
										
										
										
										
										
										
                                    </table>		  
										  
										  
										  </td>
                                      
									  
                                  </table></td>
                                </tr>
                              </table>
                              <? if($_SESSION['MemberID'] != $_GET['StoreID']) { ?>
							  <!--
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
                                <tr>
                                  <td height="10" colspan="2"></td>
                                </tr>
                                <tr> 
                                  <td align="right">
								  
							<a href="ranking.php?mId=<?=$_GET['StoreID']?>" ><img src="images/write_reStoreID.jpg" border="0"></a>	  
								  </td>
								 
                                  <td width="75"><input  class="button" type="button" name="Submit2" value="<?=SEND_EMAIL?>" alt="<?=SEND_EMAIL?>" title="<?=SEND_EMAIL?>" onclick="Javascript: location.href='send-email.php?cmp=<?=$_GET[StoreID]?>';"/></td>
								  
                                </tr>
                                <tr>
                                  <td height="10" colspan="2"></td>
                                </tr>
                              </table>-->
                            <? } ?>
                          </td>
                        </tr>
                      </table>
                       
           
                               
                                
								
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
                                  <tr>
                                    <td height="10" colspan="2"></td>
                                  </tr> 
                                  <tr>
								<? if($_SESSION['MemberID'] != $_GET['StoreID']) { ?>  
								  <!--
                                    <td  align="right">
				<a href="ranking.php?mId=<?=$_GET['StoreID']?>" ><img src="images/write_reStoreID.jpg" border="0"></a>	
				
		<input  class="button" type="button" name="Submit2" value="<?=SEND_EMAIL?>" alt="<?=SEND_EMAIL?>" title="<?=SEND_EMAIL?>" onclick="Javascript: location.href='send-email.php?cmp=<?=$_GET[StoreID]?>';"/>

									
									</td>-->
									 <? } ?>
                                    <td align="right">
									
									



									</td>
                                  </tr>
                                  <tr>
                                    <td height="10" colspan="2"></td>
                                  </tr>
                                </table>
								
                             
                          
						  </td>
                  </tr>
                  <? }else{ ?>
                  <tr>
                    <td height="130" valign="middle" align="center" class="redtxt" ><?=NO_RECORD_FOUND?></td>
                  </tr>
                  <? } ?>
                  <tr>
                    <td  height="1"></td>
                  </tr>
                  <tr>
                    <td height="6" ></td>
                  </tr>
                  <tr>
                    <td align="center"></td>
                  </tr>
                </form>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    </td>
  </tr>
</table>

