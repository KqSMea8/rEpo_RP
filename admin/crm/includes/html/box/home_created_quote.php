<div class="first_col" style="<?=$WidthRow1?>">
            <div class="block p_l_request">
              <h3>Created Quotes</h3>
              <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php  $arryQuote=$objQuote->GetDashboardQuote();
	if(sizeof($arryQuote)>0){
		$flag=true;
		$Line=0;
		foreach($arryQuote as $key=>$Quote){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;
		?>
                <tr>
                  <td><a href="vQuote.php?view=<?=$Quote['quoteid']?>&module=Quote"><?=substr(stripslashes($Quote['subject']),0,35)?></a></td>
                </tr>
<? } ?>
<tr>
                  <td><a href="viewQuote.php?module=Quote">More..</a></td>
                </tr>

<? } else{?>
                <tr>
                  <td><font color="darkred" >No Quote Found.</font></td>
                </tr>
<? }?>
               
              </table>
            
              </div>
            </div>
          </div>
