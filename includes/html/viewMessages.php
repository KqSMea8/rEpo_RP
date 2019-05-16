<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td valign="top" width="17%">
		
		<? include('includes/html/box/left_member.php'); ?>
		
		</td>
       <td width="6"><img src="images/spacer.gif" width="6" height="1" /></td>
        <td align="right" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
		
          <tr>
            <td>
				
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="8" height="26" background="images/bg-blue-left.jpg">&nbsp;</td>
                    <td bgcolor="#15507A" class="heading" > 
					<?=$MenuTitle?>
					  </td>
                    <td width="6" background="images/bg-blue-right.jpg">&nbsp;</td>
                  </tr>
                </table></td>
          </tr>
        
	
   <tr>
    <td   >
			   <table width="100%" border="0" cellspacing="0" cellpadding="10">
			   
             
				
				 <tr>
				   <td colspan="2" align="center" valign="top" bgcolor="#F9F7F8"  class="redtxt">
	 <? if(!empty($_SESSION['mess_email'])) {echo $_SESSION['mess_email']; unset($_SESSION['mess_email']); }?></td>
				  </tr>
				
                 <tr>
                   <td align="left"  height="280" bgcolor="#F8F7F7" valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                  
					 <tr>
					   <td width="100%" align="center" valign="top" bgcolor="#F9F7F8">
					   
					   
 <form action="" method="post" name="formList" onsubmit="return validate(this);">
<table width="100%" align="center" cellpadding="3" cellspacing="1" >

<? if(is_array($arryMessage) && $num>0){?>
 
  
 	<tr> 
		<td height="20" colspan="5" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="33%">&nbsp;</td>
    <td align="right">
	<span class="redtxt"> <?=$Start?>-<?=$End?> of <?=$num?></span>&nbsp;&nbsp;&nbsp;<span class="verdan11"><? echo $pagerLink; ?></span>	</td>
    </tr>
</table></td>
	</tr>
	
 <tr align="left" valign="middle" bgcolor="#999797" >
    <td width="4%"  align="left" class="heading" ></td>
    <td width="19%"  class="heading" ><?=$SentTitle?></td>
    <td width="50%" height="20"  class="heading" ><?=SUBJECT?></td>
    <td width="15%" class="heading" ><?=DATE?></td>
     <td width="12%" height="20" class="heading" ><?=RESOURCE?></td>
  </tr>	
	
  <?php 
  	$Line=0;
  	foreach($arryMessage as $key=>$values){
	$Line++;
	$ClassName = ($values['Viewed']>0)?("skytxt"):("skytxtbold");
	$BgColor = ($values['Viewed']>0)?("#FFFFFF"):("#C7C5C5");
	
	if(empty($values['Sender'])) $values['Sender'] = $values['SenderName'];
	if(empty($values['Reciever'])) $values['Reciever'] = $values['RecieverName'];
  ?>
  <tr align="left" valign="middle" bgcolor="<?=$BgColor?>"  >
    <td align="left">
      <input type="checkbox" name="DeleteItem<?=$Line?>" id="DeleteItem<?=$Line?>" value="<?=$values['MessageID']?>" />  	</td>
	
    <td class="skytxt">
	<? 	
	if($_GET['type'] == 'Sent'){
		echo '<a href="view-company.php?view='.$values['RecieverID'].'" target="_blank">'.$values['Reciever'].'</a>';
	}else{
		echo '<a href="view-company.php?view='.$values['SenderID'].'" target="_blank">'.$values['Sender'].'</a>';
	}
	 ?>	</td>
    <td height="20" class="<?=$ClassName?>">
	<? 	echo '<a href="vMessage.php?type='.$_GET['type'].'&edit='.$values['MessageID'].'&curP='.$_GET['curP'].'">'.$values['Subject'] .'</a>'; ?>	</td>
    <td class="verdan11"><? 	
	if($values['Date'] > 0){	
		//echo date("jS F,  Y H:i:s", strtotime($values['Date']));
		echo date("d/m/Y H:i", strtotime($values['Date']));
	}
	?></td>
	
    <td height="20" class="blacktxt">
	&nbsp;<? echo $values['Source'];?></td>
  </tr>
  <?php } // foreach end //?>
	<tr> 
		<td height="20" colspan="5" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="33%"><span class="skytxt">
     <? 
	 echo '<a href="Javascript: SelectDeselect('.sizeof($arryMessage).',\'DeleteItem\',1);"><u>'.SELECT_ALL.'</u></a>&nbsp;&nbsp;<a href="Javascript: SelectDeselect('.sizeof($arryMessage).',\'DeleteItem\',0);"><u>'.SELECT_NONE.'</u></a>';
	 
	 ?>
     <span class="heading" >
     <input name="Submit" type="submit" class="button" value="<?=REMOVE?>" />
     </span></span></td>
    <td align="right">
	<span class="redtxt"> <?=$Start?>-<?=$End?> of <?=$num?></span>&nbsp;&nbsp;&nbsp;<span class="verdan11"><? echo $pagerLink; ?></span>	</td>
    </tr>
</table></td>
	</tr>
  
  <?php }else{?>
  	<tr align="center">
  	  <td height="30" colspan="5" class="redtxt" bgcolor="#FFFFFF"><?=$NoRecordFound?></td>
  </tr>

  <?php } ?>
</table>
<input name="RemoveSubmit" type="hidden" id="RemoveSubmit" value="1" />
<input type="hidden" name="numMessage" id="numMessage" value="<?php echo sizeof($arryMessage); ?>">
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">


</form>

					   
					   
					   
					   
					   
					   
					   </td>
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
