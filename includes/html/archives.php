<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td valign="top"><?  include('includes/html/box/left.php'); ?></td>
        
        <td align="right" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="26"  class="heading" ><?=ARCHIVES?></td>
          </tr>
          <tr>
            <td   valign="top" >
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="20" ></td>
              </tr>
              <tr>
                <td ><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                    <tr>
                      <td  align="left"  bgcolor="#FFFFFF" nowrap="nowrap">
					  <table border="0" cellspacing="0" cellpadding="0"  height="20">
                        <tr >
                          <td width="70" <?=($_GET['opt']==1)?('class="blueTab"'):('class="whiteTab"')?>  id="ArchivesTD1" onclick="Javascript: SelectArchive(1);"><?=SELL_OFFERS?></td>
                           <td width="2" bgcolor="#FFFFFF"> </td>
						   <td width="70" <?=($_GET['opt']==2)?('class="blueTab"'):('class="whiteTab"')?> id="ArchivesTD2" onclick="Javascript: SelectArchive(2);"> <?=BUY_OFFERS?></td>
						    <td width="2" bgcolor="#FFFFFF"> </td>
                          <td width="70" <?=($_GET['opt']==3)?('class="blueTab"'):('class="whiteTab"')?> id="ArchivesTD3" onclick="Javascript: SelectArchive(3);"><?=PRODUCTS?></td>
                        </tr>
                      </table></td>
                      
                    </tr>
                    <tr>
                      <td height="50" class="outline" align="center"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                        
                        <tr>
                          <td width="15%" height="41" align="left"><? echo getMonths($_GET['month'],"Month","txt-feild");?></td>
                          <td width="14%" align="left" class="blue-head"><? echo getYears($_GET['year'],"Year","txt-feild");?></td>
                          <td width="45%" class="blue-head"><input name="Submit" type="button" class="button"  id="SubmitButton" value="  <?=GO?>  " title=" <?=SEARCH?> " alt=" <?=SEARCH?> "  onclick="Javascript: Validate();"/>
                            <input type="hidden" name="ArchiveFor" id="ArchiveFor" value="<?=$_GET['opt']?>" /></td>
                          <td width="26%" class="blue-head">&nbsp;</td>
                        </tr>

                      </table></td>
                    </tr>
                </table></td>
              </tr>
             
            </table></td>
          </tr>
		  
		   <tr>
    <td   valign="top" >
	
	<table width="100%" border="0" align="center" cellpadding="7" cellspacing="1" bgcolor="#FFFFFF" class="blacktxt">
      <tr>
        <td   align="center"  valign="top" height="100" class="redtxt" id="MsgDiv">
		
		
		<?
	if(!empty($_GET['opt']) && !empty($_GET['month']) & !empty($_GET['year'])){
		
		switch($_GET['opt']){
			case 1:	include('includes/html/box/offer-listing.php'); 
					break;
			case 2:	include('includes/html/box/offer-listing.php'); 
					break;
			case 3:	include('includes/html/box/product-listing.php'); 
					break;
		}
		
	}
		
		 ?>
		
		
		</td>
        </tr>
    </table>
	
	
	</td>
  </tr>	
         
          <tr>
            <td height="6"></td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr>
        </table></td>
		
		 <td align="right" valign="top">
		 
		 		 
		 <? require_once("includes/html/box/right.php"); ?>

		 
		 </td>
  </tr>
    </table></td>
  </tr>
</table>
