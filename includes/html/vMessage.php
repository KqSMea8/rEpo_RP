 <form name="offerForm" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">	
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td valign="top" width="17%">
		
		<? include('includes/html/box/left_member.php'); ?>
		
		</td>
        <td  width="6"><img src="images/spacer.gif" width="6" height="1" /></td>
        <td align="right" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
		
          <tr>
            <td  >
				
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="8" height="26" background="images/bg-blue-left.jpg">&nbsp;</td>
                    <td bgcolor="#15507A" class="heading" > 
					  <? echo VIEW_MESSAGE;?></td>
                    <td width="6" background="images/bg-blue-right.jpg">&nbsp;</td>
                  </tr>
                </table></td>
          </tr>
        
	
   <tr>
    <td   >
			   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                

                 <tr>
				  
				 
                   <td align="left"  height="276" bgcolor="#FFFFFF" valign="top"><table width="100%" height="26" border="0" cellpadding="0" cellspacing="0">
                     <tr>
                       <td>&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                   </table>
                   <table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
                       <tr>
                         <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                             <tr>
                               <td width="128" height="24" bgcolor="#999797" class="whit-txt" nowrap="nowrap">
							   <?php echo $MenuTitle; ?> </td>
                               <td width="677" align="right"><span class="skytxt"><a href="<?=$RedirectURL?>">
                                 <?=$MenuTitle?>
                               </a></span></td>
                             </tr>
                           </table>
                             <table width="100%" border="0" cellpadding="0" cellspacing="0" class="outline" >
                               <tr>
                                 <td  valign="top" height="110" ><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                                  
                                
                                   <tr>
                                     <td width="16%" align="right" bgcolor="#F9F7F8"  class="simpletxt" id="SubCatTitle"></td>
                                     <td width="84%" align="left" id="SubCatTd"></td>
                                   </tr>
                                   <? if($_GET['edit'] > 0){ 	   	
					 ?>
                                   <tr>
                                     <td align="right" valign="top" bgcolor="#F9F7F8"  class="simpletxt"><?=$SentTitle?>
                                       : </td>
                                     <td  align="left" valign="top" bgcolor="#F9F7F8"  class="blacktxt"><span class="skytxt">
                                       <? 	
	if($_GET['type'] == 'Sent'){
		echo '<a href="view-company.php?view='.$arryMessage[0]['RecieverID'].'" target="_blank">'.$Reciever.'</a>';
	}else{
		echo '<a href="view-company.php?view='.$arryMessage[0]['SenderID'].'" target="_blank">'.$Sender.'</a>';
	}
	 ?>
                                     </span></td>
                                   </tr>
                                   <tr>
                                     <td align="right" valign="top" bgcolor="#F9F7F8"  class="simpletxt"><?=DATE?>
                                       : </td>
                                     <td  align="left" valign="top" bgcolor="#F9F7F8"  class="blacktxt"><? 	
	if($arryMessage[0]['Date'] > 0){	
	   echo date("jS F,  Y H:i:s", strtotime($arryMessage[0]['Date']));
	}
	?></td>
                                   </tr>
                                   <tr>
                                     <td align="right" valign="top" bgcolor="#F9F7F8"  class="simpletxt"><?=RESOURCE?>
                                       : </td>
                                     <td  align="left" valign="top" bgcolor="#F9F7F8"  class="blacktxt"><span class="verdan11"> <? echo $arryMessage[0]['Source'];?> </span></td>
                                   </tr>
                                   <tr>
                                     <td align="right" valign="top" bgcolor="#F9F7F8"  class="simpletxt"><?=SUBJECT?>
                                       : </td>
                                     <td  align="left" valign="top" bgcolor="#F9F7F8"  class="blacktxt"><? echo stripslashes($arryMessage[0]['Subject']);?></td>
                                   </tr>
                                  
                                   <tr>
                                     <td align="right" valign="top" bgcolor="#F9F7F8"  class="simpletxt"><?=MESSAGE?>
                                       : </td>
                                     <td  align="left" valign="top" bgcolor="#F9F7F8" ><table width="100%" border="0" cellspacing="0" cellpadding="0" class="blacktxt" >
                                         <tr>
                                           <td valign="top" bgcolor="#F9F7F8" ><? echo stripslashes($arryMessage[0]['Message']);?></td>
                                         </tr>
                                     </table></td>
                                   </tr>
								    <tr>
                                     <td align="right" valign="top" bgcolor="#F9F7F8"  height="10" ></td>
                                     <td  align="left" valign="top" bgcolor="#F9F7F8" ></td>
                                   </tr>
								   
								   
                                   <? } ?>
								   
								   
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
                           
                             <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                               <tr>
                                 <td height="10" colspan="2"></td>
                               </tr>
                               <tr>
                                 <td width="21" height="20">&nbsp;</td>
                                 <td width="728" align="right">
								 
								 <? if($_GET['type']!='Sent') {?>
								   <input  class="button" type="button" name="Submit22" value="    <?=REPLY?>   " alt="<?=REPLY?>" title="<?=REPLY?>" onclick="Javascript: location.href='send-email.php?cmp=<?=$arryMessage[0]['SenderID']?>&opt=<?=$arryMessage[0]['Source']?>&type=<?=$arryMessage[0]['InquiryQuotation']?>&subject=<?=stripslashes($arryMessage[0]['Subject'])?>';"/> &nbsp;
								   <? } ?>  
								   
							<? if($_GET['type']!='Deleted' && $_GET['type']!='Sent' && $_GET['type']!='Spam' ) {?>    
			  <input  class="button" type="button" name="Submit22" value="<?=REPORT_SPAM?>" alt="<?=REPORT_SPAM?>" title="<?=REPORT_SPAM?>" onclick="Javascript: location.href='vMessage.php?spam=1&sender=<?=$arryMessage[0]['SenderID']?>&reciever=<?=$arryMessage[0]['RecieverID']?>&type=<?=$_GET['type']?>';" /> &nbsp;					   
							 <? } ?> 
							 
							<? if($_GET['type']=='Spam' ) {?>    
			  <input  class="button" type="button" name="Submit22" value="  <?=NOT_SPAM?>  " alt="<?=NOT_SPAM?>" title="<?=NOT_SPAM?>" onclick="Javascript: location.href='vMessage.php?spam=0&sender=<?=$arryMessage[0]['SenderID']?>&reciever=<?=$arryMessage[0]['RecieverID']?>&type=<?=$_GET['type']?>';" /> &nbsp;					   
							 <? } ?>  
							 
								
								   
							     <input  class="button" type="button" name="Submit2" value="  <?=REMOVE?>  " alt="<?=REMOVE?>" title="<?=REMOVE?>" onclick="Javascript: location.href='vMessage.php?del_id=<?=$arryMessage[0]['MessageID']?>&type=<?=$_GET['type']?>';"/></td>
                               </tr>
                               <tr>
                                 <td height="10" colspan="2"></td>
                               </tr>
                             </table>
                          
                         </td>
                       </tr>
                     </table>
                     <table width="100%" height="26" border="0" cellpadding="0" cellspacing="0">
                       <tr>
                         <td>&nbsp;</td>
                         <td>&nbsp;</td>
                       </tr>
                     </table></td>
                 </tr>
               </table> 	</td>
  </tr>	  
		
		
				 

		  
          <tr>
            <td bgcolor="#CCCCCC" height="1"></td>
          </tr>
          <tr>
            <td height="6" ></td>
          </tr>
          <tr>
            <td align="center"><? //include('includes/html/box/banner_bottom.php'); ?></td>
          </tr>
        </table></td>
	
				
  </tr>
    </table></td>
  </tr>
</table>
 </form>
