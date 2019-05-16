<table cellspacing="0" cellpadding="0" width="100%" align="center">
  <tr>
    <td  align="left" valign="middle" class="heading">FAQs </td>
  </tr>
  <tr>
    <td height="32" align="left" valign="middle" class="pagenav"><?=$Nav_Home?>
        FAQs</td>
  </tr>
  <tr>
    <td height="15"></td>
  </tr>
  
   <tr>
        <td  valign="top"  class="txt" >
		<?
	 	echo  stripslashes($arrayContents[0]['PageContent']); 
	?>
        </td>
      </tr>
    <tr>
    <td height="15"></td>
  </tr>
  <tr>
    <td  class="generaltxt_inner"><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td  id="MainTD"><?
	
if($arryNumFaq[0]['NumFaq']>0 && sizeof($arryFaqCategory)>0){
		
		
		$CountFaq = 0;
	  	foreach($arryFaqCategory as $key=>$values){
		
			$arryFaq = $objFaq->getFaq('',1,$values['catID']);
?>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" valign="top" class="graybox"><img src="images/arrownext.jpg"  />&nbsp;<?=stripslashes($values['Name'])?>
                  </td>
                </tr>
              </table>
          <?	if(sizeof($arryFaq)>0) { ?>
              <table width="97%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td colspan="2" height="6"></td>
                </tr>
                <tr>
                  <td align="left" width="80%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?	for($i=0;$i<sizeof($arryFaq);$i++) { 
 				$CountFaq++;
 ?>
                      <tr>
                        <td align="left" valign="top" style="padding-top:7px;" width="8" ><a href="Javascript: ShowAnswer(<?=$CountFaq?>)" class="help_link" ><img src="images/plus.jpg" border="0" /></a></td>
                        <td align="left" valign="top" class="blacktxt" ><a href="Javascript: ShowAnswer(<?=$CountFaq?>)"  >
                          <?=stripslashes($arryFaq[$i]['Question'])?>
                          </a>
                            <div style="display:none" id="Answer<?=$CountFaq?>" >
                              <table width="97%" border="0" cellspacing="0" cellpadding="3" >
                                <tr>
                                  <td class="blacktxt" ><?=stripslashes($arryFaq[$i]['Answer'])?></td>
                                </tr>
                              </table>
                            </div></td>
                      </tr>
                      <tr>
                        <td height="3" colspan="2"></td>
                      </tr>
                      <tr>
                        <td height="2" colspan="2"></td>
                      </tr>
                      <? } ?>
                      <input type="hidden" name="NumFaq" id="NumFaq" value="<?=$arryNumFaq[0]['NumFaq']?>" />
                  </table></td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="2" height="6"></td>
                </tr>
              </table>
          <?	}}}else{ echo '<Div align=center  class=redtxt>'.NO_RECORD_FOUND.'</Div>';	}	?>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
